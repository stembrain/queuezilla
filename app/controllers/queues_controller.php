<?php
class QueuesController extends AppController {
	var $name = 'Queues';
	var $uses = array('Queue', 'QueueMovie', 'NetflixAccount');	

    function index(){
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		$userId = $this->getUserId();

        if (!$userId) {
			$this->flash('You must reauthorize this site to access your netflix queue.', 'authorizeNetflix');
			return;
		}
		
		$this->set('userId', $userId);
		$this->Queue->recursive = 0;
		$this->set('queues', $this->paginate('Queue', array("Queue.account_number = '$userId'  OR privacy = 'public'")));
	}
	
	function logout(){
		unset($_SESSION['user_id']);
		setcookie('user_id', '', time() - 60*60*24*30, '/', '', false, true);
		$this->redirect(array('controller' => 'queues', 'action' => 'index'));
	}
	
	function authorizeNetflix() {
		$netflix = new NetflixConsumer();
		$callbackURL = "http://{$_SERVER['HTTP_HOST']}/lab/queues/netflixCallback";
        $requestToken = $netflix->getRequestToken('http://api-public.netflix.com/oauth/request_token', $callbackURL);
        $this->log("Request token is $requestToken", LOG_DEBUG);
		$this->Session->write('netflixRequestToken', $requestToken);

		$auth_url = "https://api-user.netflix.com/oauth/login" . 
			"?oauth_token=" . $requestToken->key . 
			"&application_name=" . $netflix->getConsumerName() . 
			"&oauth_consumer_key=" . $netflix->getConsumerKey();
		$this->redirect($auth_url);
	}

	function netflixCallback(){	
		$requestToken = $this->Session->read('netflixRequestToken');

		$netflix = new NetflixConsumer();
		$accessToken = $netflix->getAccessToken('http://api.netflix.com/oauth/access_token', $requestToken);
		$this->set('accessToken', $accessToken);

		if(!$accessToken){
			$this->Session->setFlash('Access token not acquired');
			$this->log('Access token could not be acquired for request token ' . print_r($requestToken, true));
		}
		else{
			$fullResponse = array();
			parse_str($netflix->getFullResponse(), $fullResponse);
			$this->set('fullResponse', $fullResponse);
			$netflixUserId = $fullResponse['user_id'];
			$netflixUserIdHash = md5($netflixUserId);
			$netflixAccount = array();
			
			$existingNetflixAccount = $this->NetflixAccount->find(array('account_number' => $netflixUserId));
			if(!empty($existingNetflixAccount)){
				$this->log(__METHOD__ . ": User id $netflixUserId already has registered their account", LOG_DEBUG);
				$netflixAccount = $existingNetflixAccount;
			}
			else{
				$netflixAccount['NetflixAccount']['oauth_token'] = $accessToken->key;
				$netflixAccount['NetflixAccount']['oauth_token_secret'] = $accessToken->secret;
				$netflixAccount['NetflixAccount']['account_number'] = $netflixUserId;
				$netflixAccount['NetflixAccount']['account_number_hash'] = $netflixUserIdHash;

				if($this->NetflixAccount->save($netflixAccount)){
					$this->log(__METHOD__ . ": New user id $netflixUserId saved.", LOG_DEBUG);
				}
				else{
					$this->set('error', $netflix->getFullResponseXML());
					$this->log("Error saving " . print_r($netflixAccount, true));
					return;
				}				
			}
			
			//TODO: Create Login function out of this
			$this->set('netflixAccount', $netflixAccount);
			$_SESSION['user_id'] = $netflixUserIdHash;
			setcookie('user_id', $netflixUserIdHash, time()+60*60*24*30, '/', '', false, true);
		}
	}
	
	function listQueueFeeds(){
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'login'));
		}

		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
		$feeds = $netflix->getListOfQueuesRSS();
		$this->set('feeds', $feeds);
	}

	function viewNetflixQueue(){
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}		

		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
		if(!$netflix){
			$this->flash('You must authorize this site to interact with your Netflix queue', array('controller' => 'users', 'action' => 'authorizeNetflix'));
			return;
		}

		$queuedMovies = $netflix->getQueueItemsAsCatalogTitles();
		$this->set('queuedMovies', $queuedMovies);
	}
	
	function dumpNetflixQueueXml(){
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}		

		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
		if(!$netflix){
			$this->flash('You must authorize this site to interact with your Netflix queue', array('controller' => 'users', 'action' => 'authorizeNetflix'));
			return;
		}

		$queuedMovies = $netflix->getQueueItemsAsSimpleXMLElements();
		pr($queuedMovies);
		exit;
	}

	function saveNetflixQueue(){
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}

		if(empty($this->data)){
			return;
		}
		
		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
		if(!$netflix){
			$this->flash('You must authorize this site to interact with your Netflix queue', array('controller' => 'queues', 'action' => 'authorizeNetflix'));
			return;
		}
				
		App::import('Sanitize');
		$sanitize = new Sanitize();
		$sanitizeQueueData = $sanitize->clean($this->data['Queue']);	
		$this->Queue->create();		
		$this->Queue->set($sanitizeQueueData);
		$this->Queue->set('account_number', $userId);
		
		if(!$this->Queue->save($this->Queue->data)){
			$this->flash("Could not save this data in a queue: " . print_r($sanitizeQueueData, true), LOG_DEBUG);
			return;
		}

		//TODO: Let netflix_consumer convert the simplexml in to a flat array like used in uploadBlockbusterQueue
		$queuedMovies = $netflix->getQueueItemsAsSimpleXMLElements();

		$queueId = $this->Queue->getLastInsertId();
		$errors = array();
		foreach($queuedMovies as $movie){
			$entryId = $movie->id;
			$catalogInfo = $movie->xpath('./link[@rel=\'http://schemas.netflix.com/catalog/title\']');
			$catalogInfo = $catalogInfo[0];
			$externalLink = $movie->xpath('./link[@rel=\'alternate\']');
			$externalLink = (string)$externalLink[0]->attributes()->href;
			$netflixKey = $catalogInfo->attributes()->href;
			$title = $catalogInfo->attributes()->title;
			$position = intval($movie->position);

			$this->Queue->QueueMovie->create();
			$this->Queue->QueueMovie->set(array(
						'queue_id' => $queueId,
						'netflix_key' => $netflixKey,
						'external_link' => $externalLink,
//						'netflix_entryId' => $entryId, //This doesn't seem to be necessary for manipulating the netflix queue later. Of the form http://api.netflix.com/users/T1DOCDyCxe7j3gN6N_RIiBiKLNF4PvM4hqnyMYSD.LEv4-/queues/disc/saved/70128710
						'position' => $position,
						'title' => $title
			));

			if(!$this->Queue->QueueMovie->save()){
				$errors[] = $this->Queue->QueueMovie->invalidFields();
			}
		}

		if(count($errors)){
			$this->set('errors', $errors);
		}
	}

	/**
	 * This method still supports the disc and instant queue because it works
	 * for both as of 8/15/11.
	 * @param $queueType 'instant' if the instant queue should be cleared.
	 * @return unknown_type
	 */
	function clearNetflixQueue($queueType = ''){
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}

		if($queueType == 'instant'){			
			$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
			$netflix->clearQueue();
			$this->flash('Queue emptied. Redirecting to main page.', 'index');
		}
	}

	/**
	 * Appends the stored gorilla queue to the user's active netflix queue
	 * //TODO: This works for queues that are empty. Does it work if the queue
	 * already has titles in it?
	 * @param $queueId
	 * @return unknown_type
	 */
	function appendNetflixQueue($queueId){		
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'login'));
		}

		$queue = $this->Queue->find('first', 
			array('conditions' => 
				"Queue.id = $queueId AND (Queue.account_number = '$userId' OR Queue.privacy = 'public')"
			)
		);
		
		$this->log("Appending queue with id $queueId and owner {$queue['Queue']['account_number']} to netflix queue for user $userId", LOG_DEBUG);
		
		$this->Queue->id = $queueId;
		$this->Queue->read(null, $queueId);
		$etag = $this->Queue->field('etag');

		if(!$queue){
			$this->flash("The queue does not exist or does not belong to the user.");
			$this->redirect(array('action' => 'index'));
			exit;
		}

		$queueMovies = $this->Queue->QueueMovie->find('all', 
			array('conditions' => "queue_id = $queueId", 
				  'order' => 'QueueMovie.position ASC'));
		$this->set('queueMovies', $queueMovies);

		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);

		$errors = array();
		
		foreach($queueMovies as $movieToAdd){
			$titleURL = $movieToAdd['QueueMovie']['netflix_key'];
			$position = $movieToAdd['QueueMovie']['position'];
			$title = $movieToAdd['QueueMovie']['title'];
			
			$this->log("Adding $title at position $position for $userId", LOG_DEBUG);
			
			if($position == 0){
				//Handle movies in the 'saved' queue. They have position 0.
				$position = count($queueMovies);
			}

			try{
				$etag = $netflix->addTitle($titleURL, $position);
				$this->Queue->saveField('etag', $etag);
			}
			catch(Exception $e){
				$errors[] = $e->getMessage();					
			}
		}

		$this->set('errors', $errors);
	}	

	function searchForTitle(){
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'login'));
		}
		
		if($this->data && $this->data['Queue']){
			$searchTerm = $this->data['Queue']['searchTerm'];
			
			if($searchTerm){
				$this->set('searchTerm', htmlentities($searchTerm));
				
				$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
				$results = $netflix->searchForTitle($searchTerm);
				$this->set('results', $results);
			}
		}
	}
	
	function searchAndAddTitle($searchTerm, $jabberAccount){
		//Searches for the title, adds first result to netflix queue
		$jabberAccount = base64_decode($jabberAccount);
		$netflixAccount = $this->NetflixAccount->find("jabber_account = '$jabberAccount'");
		$this->log("Searching for netflix account associated with jabber account $jabberAccount", LOG_DEBUG);

		if(empty($netflixAccount)){
			$this->log("No netflix account for jabber account $jabberAccount found.", LOG_DEBUG);
			exit;
		}
		
		$userId = $netflixAccount['NetflixAccount']['account_number'];					
		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
		$results = $netflix->searchForTitle($searchTerm);
		$this->log(__METHOD__ . ": User $userId searching for title $searchTerm", LOG_DEBUG);
		
		if(!empty($results)){		
			$titleToAdd = $results[0];
			$name = $titleToAdd['name'];
			$netflixKey = $titleToAdd['netflixKey'];
			$externalLink = $titleToAdd['externalLink'];
			$this->log(__METHOD__ . " Found title with name $name, link $externalLink, and key $netflixKey . Will add to queue of user $userId", LOG_DEBUG);
			try{
				$netflix->addTitle($netflixKey, 1);
			}
			catch(Exception $e){
				$this->log(__METHOD__ . " Error adding $netflixKey to queue for user $userId. Error is " . $e->getMessage(), LOG_ERROR);
			}
			
			$this->log(__METHOD__ . " Added title with name $name and key $netflixKey to queue of user $userId", LOG_DEBUG);
			echo $name;
		}
		else{
			$this->log(__METHOD__ . ": No results for search term $searchTerm", LOG_DEBUG);
		}
				
		exit;
	}
	
	function addTitle(){
		if(empty($this->data['QueueMovie'])){
			$this->redirect('searchForTitle');
			exit;
		}
		
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}

		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
		
		$titleURL = $this->data['QueueMovie']['netflix_key'];
		$position = null;
		if(isset($this->data['QueueMovie']['position'])){
			$position = $this->data['QueueMovie']['position'];			
		}
		
		try{
			$netflix->addTitle($titleURL, $position);
		}
		catch(Exception $e){
			$this->flash('Error: ' . $e->getMessage(), 
				array('controller' => 'queues', 'action' => 'searchForTitle'), 
				99
			);
			
			return;
		}
		
		$this->flash($titleURL . ' added to queue.', array('controller' => 'queues', 'action' => 'searchForTitle'));
	}
	
	/**
	 * Returns numeric array of simple structs like array('year'=> 1995, 'title' => 'Batman');
	 * @param unknown_type $html
	 * @return unknown_type
	 */
	private function extractTitlesFromBlockbusterHTML($html){
		$matches = array();
		preg_match_all('/<div[^>]+class\s*=\s*("|\')title("|\')[^>]*><a[^>]*>([^<]+)/m', $html, $matches);
		$titles = isset($matches[3]) ? $matches[3] : array();
		
		$titles = array_filter($titles, 
			create_function('$var', 
				'return !(strcmp($var, "Title") == 0 || strcmp($var, "Movie Title") == 0);')
		);

		$parsedTitles = array();
		foreach($titles as $title){
			$year = '';
			$parsedTitle = html_entity_decode(preg_replace('/\[[^\]]*]/', '', $title));
			
			if(preg_match('/(.*?)( \(\d{4}\))/', $parsedTitle, $secondaryMatches)){
				$year = $secondaryMatches[2];
				$parsedTitle = $secondaryMatches[1];
			}
			
			$parsedTitles[] = array('title' => $parsedTitle, 'year' => $year);
		}
		
//		$this->log('Extracted titles: ' . print_r($parsedTitles, true), LOG_DEBUG);
		return $parsedTitles;
	}
	
	function uploadBlockbusterQueue(){
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'login'));
		}
		
		$netflix = $this->NetflixAccount->getNetflixAPIConsumerForAccountNumber($userId);
			
		//Queue uploaded
		if(is_uploaded_file($this->data['Queue']['blockbusterQueue']['tmp_name'])){
			
			$error = $this->data['Queue']['blockbusterQueue']['error'];	
    		if ($error != UPLOAD_ERR_OK) {
    			$this->flash('Upload failed. Please try again.', 'uploadBlockbusterQueue');	
    			return;
    		}
    		
    		//Extract movie titles and years from uploaded HTML with a regex
			$html = file_get_contents($this->data['Queue']['blockbusterQueue']['tmp_name']);
			$titles = $this->extractTitlesFromBlockbusterHTML($html);
			
			if(count($titles) == 0){
				$this->flash("No movie titles found in uploaded HTML. Send file via email, please.",
					array('controller' => 'queues' , 'action' => 'uploadBlockbusterQueue'));
				return;
			}
			
			$this->Queue->create();
			$this->Queue->set('account_number', $userId);
			$this->Queue->set('name', 'Blockbuster Queue from ' . $this->data['Queue']['blockbusterQueue']['name']);
			if(!$this->Queue->save()){
				$this->flash("Error creating an empty queue to store the uploaded titles.", 
					array('controller' => 'queues' , 'action' => 'uploadBlockbusterQueue'));
				return;
			}
			$this->log('Created new queue for uploaded blockbuster data with id ' . $this->Queue->id, LOG_DEBUG);
			
			$netflixTitlesForBlockbusterQueue = array();
			foreach ($titles as $queuePosition => $titleInfo){
				$error = false;
				
				$title = $titleInfo['title'];

				$netflixSearchResults = $netflix->searchForTitle($title, 3);
				$this->log("Got " . ($queuePosition + 1) . 
					" netflix search result of " . 
					count($titles) . ' blockbuster titles', LOG_DEBUG);				
				
				if(count($netflixSearchResults) == 0){
					$error = 'no results for "' . $title .'"';
					$netflixTitlesForBlockbusterQueue[$queuePosition] = array(
						'blockbusterTitleName' => $title,
						'netflixSearchResults' => $netflixSearchResults,
						'error' => $error,
						'position' => $queuePosition,
					);
					
					continue;
				}
										
				$this->QueueMovie->create();
				$this->QueueMovie->set('queue_id', $this->Queue->id);
				$this->QueueMovie->set('position', $queuePosition + 1);
				$this->QueueMovie->set('title', $netflixSearchResults[0]['name']);
				$this->QueueMovie->set('netflix_key', $netflixSearchResults[0]['netflixKey']);
				$this->QueueMovie->set('external_link', $netflixSearchResults[0]['externalLink']);
				
				if(!$this->QueueMovie->save()){
					$error = "\"$title\" could not be saved to position $queuePosition of instant queue.";
					$netflixTitlesForBlockbusterQueue[$queuePosition] = array(
						'blockbusterTitleName' => $title,
						'netflixSearchResults' => $netflixSearchResults,
						'error' => $error,
						'position' => $queuePosition
					);
					$this->set('error', true);
				}
				
				if($netflixSearchResults[0]['score'] > 10){
					$error = "\"$title\" has netflix search results that do not match closely.";
					$netflixTitlesForBlockbusterQueue[$queuePosition] = array(
						'blockbusterTitleName' => $title,
						'netflixSearchResults' => $netflixSearchResults,
						'error' => $error,
						'position' => $queuePosition
					);
					$this->set('error', true);
				}				
			}//End foreach($titles as $queuePosition => $titleInfo)

			$this->set('netflixTitlesForBlockbusterQueue', $netflixTitlesForBlockbusterQueue);
		}
	}

	function view($id = null) {
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'login'));
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid queue', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$queueViewability = $this->Queue->read(array('account_number', 'privacy'), $id);
		if(empty($queueViewability) || 
			($queueViewability['Queue']['account_number'] != $userId && $queueViewability['Queue']['privacy'] != 'public')){
			$this->Session->setFlash(__('Invalid request.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('queue', $this->Queue->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Queue->create();
			if ($this->Queue->save($this->data)) {
				$this->Session->setFlash(__('The queue has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The queue could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'login'));
		}
				
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid queue', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$queueOwnerId = $this->Queue->read('account_number', $id);
		if(empty($queueOwnerId) || $queueOwnerId['Queue']['account_number'] != $userId){
			$this->Session->setFlash(__('Invalid request.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if (!empty($this->data)) {
			if ($this->Queue->save($this->data)) {
				$this->Session->setFlash(__('The queue has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The queue could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Queue->read(null, $id);
		}
	}

	function delete($id = null) {
		$userId = $this->getUserId();

		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for queue', true));
			$this->redirect(array('action'=>'index'));
		}
				
		$queueOwnerId = $this->Queue->read('account_number', $id);
		if(empty($queueOwnerId) || $queueOwnerId['Queue']['account_number'] != $userId){
			$this->Session->setFlash(__('Invalid request.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Queue->delete($id)) {
			$this->Session->setFlash(__('Queue deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Queue was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
