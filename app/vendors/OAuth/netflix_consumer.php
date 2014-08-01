<?php

require_once('oauth_consumer.php');

class NetflixConsumer extends OAuth_Consumer{

	private $accessToken;
	private $accessTokenSecret;
	private $userId;

    public function __construct($accessToken = '', $accessTokenSecret = '', $userId = ''){
        echo "consumer constructor entry" . PHP_EOL;
		$this->consumerKey = 'w2pvq3yymthnj23vteqcp4b9';
		$this->consumerSecret = 'GNmPxfA3Bw';
		$this->consumerName = 'QueueConverter';

		$this->accessToken = $accessToken;
		$this->accessTokenSecret = $accessTokenSecret;
		$this->userId = $userId;
echo "calling parent of netflix consumer" . PHP_EOL;
		parent::__construct($this->consumerKey, $this->consumerSecret, $this->consumerName);
	}

	public function getNetflixAccountNumber(){
		$reflectionURL = 'http://api-public.netflix.com/users/current';
		$accountInfo = $this->get($this->accessToken, $this->accessTokenSecret, $reflectionURL);
		$xml = new SimpleXMLElement($accountInfo);
		$accountNumber = array_pop(array_slice(explode('/', $xml->link->attributes()->href), -1, 1));
		return $accountNumber;
	}
	
	/**
	 * Adds a title to the netflix queue for this account.
	 * @param String $titleURL - A unique netflix title URI, such as 
	 * 		http://api-public.netflix.com/catalog/titles/movies/70052696
	 * 	or
	 * 		http://www.netflix.com/Movie/Big_Fish/60031268
	 * @param int $position - A positive number that indicates where the title should appear in the queue.
	 * @return String - Returns the modified queue's etag if the operation was successful. Returns error code otherwise.
	 */
	public function addTitle($titleURL, $position = 1){
		$url = "http://api-public.netflix.com/users/" . $this->userId . "/queues/instant";
		
		$postData = array(
//			'etag' => $etag,
			'position' => $position,
			'title_ref' => $titleURL
		);
		
		$returnCode = $this->post($this->accessToken, $this->accessTokenSecret, $url, $postData);
		$returnCode = new SimpleXMLElement($returnCode);

		if($returnCode->status_code == '201'){
			$this->log("Added $titleURL to active netflix queue for user {$this->userId}");
			$etag = $returnCode->etag;
			return $etag;
		}
		else{
			$error = "Could not add title '$titleURL' to " .
				"instant queue at position $position using API url $url " . 
				"Reason: " . $returnCode->message . 
				'. Error code: ' . $returnCode->status_code;				
			$this->error(__METHOD__ . ":" . $error);
			
			if($returnCode->status_code == '400'){
				$error = "Could not add title '$titleURL' to instant queue.".
					" The movie may not be available in this format.".
					" This can happen if this tool presented the title as a search" .
					" result but the title is only available on DVD." .
					" This can also happen if the title was available for" .
					" streaming at the time a backup was made, but the title".
					" has been removed from Netflix streaming catalog." .
					" Please note that if this title is part of a television".
					" series then it can not be added to the queue by this tool".
					" because of technical limitations. More about these limits:".
					" at http://developer.netflix.com/blog/read/Upcoming_Changes_to_the_Open_API_Program";
			}
			
			throw new Exception($error, intval($returnCode->status_code));
		}		
	}
	
	private function log($msg){
		file_put_contents(LOGS . DS . 'debug.log', 
			date('c') . ": $msg" . PHP_EOL, FILE_APPEND);
	}
	
	private function error($msg){
		file_put_contents(LOGS . DS . 'error.log', 
			date('c') . ": $msg" . PHP_EOL, FILE_APPEND);
	}
	
	public function searchForTitle($titleName, $maxResults = 10){
		if(!is_string($titleName)){
			return;
		}

		$titleName = trim($titleName);
		if(empty($titleName)){
			return;
		}

		$url = 'http://api-public.netflix.com/catalog/titles/streaming';

		$itemsFetched = 0;
		$catalogTitles = array();

		$access_params['term'] = $titleName;
		$access_params['start_index'] = $itemsFetched;
		$access_params['max_results'] = $maxResults; //max is 100

		$items = $this->get('', '', $url, $access_params);

		if($items){
			$xml = new SimpleXMLElement($items);
			$catalogTitles = $xml->xpath('/catalog_titles/catalog_title');
		}

		//Order by levenshtein: http://www.php.net/manual/en/function.array-multisort.php#103047	
		$orderedCatalogTitles = array();
		$editDistances = array();
		foreach($catalogTitles as $result){
//			$this->log("Result for title $titleName: " . print_r($result, true), LOG_DEBUG);
			$catalogTitle = $this->convertXmlCatalogTitleToCatalogTitle($result);			
			
			$editDistance = levenshtein($catalogTitle['name'], $titleName);			
			$catalogTitle['score'] = $editDistance;			
			$orderedCatalogTitles[] = $catalogTitle;			
			$editDistances[] = $editDistance;
		}
		array_multisort($editDistances, SORT_ASC, $orderedCatalogTitles);

		return $orderedCatalogTitles;
	}	

	/**
	 * Returns array with keys:
	 * 'netflixKey' => 'http://api-public.netflix.com/catalog/titles/movies/70064723'
	 * The netflixKey value is used to add / remove titles from a user's netflix queue
	 * 
	 * @param unknown_type $xmlCatalogTitle
	 * @return unknown_type
	 */
	private function convertXmlCatalogTitleToCatalogTitle($xmlCatalogTitle){
		$catalogTitle = array();
		$netflixKey = (string)$xmlCatalogTitle->id;
		$externalLink = $xmlCatalogTitle->xpath('./link[@rel=\'alternate\']');
		$externalLink = (string)$externalLink[0]->attributes()->href;
		$title = trim((string)$xmlCatalogTitle->title->attributes()->regular);
		$boxArtSmall = (string)$xmlCatalogTitle->box_art->attributes()->small;
		$year = (string)$xmlCatalogTitle->release_year;
		$catalogTitle = array(
			'netflixKey' => $netflixKey,
			'externalLink' => $externalLink,
			'name' => $title,
			'boxArtSmallLink' => $boxArtSmall,
			'year' => $year
		);
		
		return $catalogTitle;
	}
	
	public function clearQueue(){
		//TODO: If etag for a queue in the db is fresh, then pull ids from db instead of from returned xml
		$etag = $this->getNetflixQueueEtag();

		$queuedMovies = $this->getQueueItemsAsSimpleXMLElements();
		foreach($queuedMovies as $movieToDelete){
			$entryId = $movieToDelete->id;
			$this->log("Deleting $entryId from active netflix queue for user {$this->userId}");
			$this->delete($this->accessToken, $this->accessTokenSecret, $entryId);
		}
	}

	public function getQueueItemsAsCatalogTitles(){
		$xmlCatalogTitles = $this->getQueueItemsAsSimpleXMLElements();
		$catalogTitles = array();
		foreach($xmlCatalogTitles as $xmlCatalogTitle){
			$catalogTitle = $this->convertXmlCatalogTitleToCatalogTitle($xmlCatalogTitle);
			$catalogTitles[] = $catalogTitle;	
		}
		
		return $catalogTitles;
	}
	
	public function getQueueItemsAsSimpleXMLElements(){
		$url = "http://api-public.netflix.com/users/{$this->userId}/queues/instant";

		$itemsFetched = 0;
		$queuedMovies = array();
		
		$this->log(__METHOD__ . ": Fetching queue items from URL $url", LOG_DEBUG);
		
		while(TRUE){
			$access_params['start_index'] = $itemsFetched;
			$access_params['max_results'] = 100; //max is 100
			$items = $this->get($this->accessToken, $this->accessTokenSecret, $url, $access_params);

			if($items){
				$xml = new SimpleXMLElement($items);

				$etag = $xml->etag;

				$queueItems = $xml->xpath('/queue/queue_item');
				$queuedMovies = array_merge($queuedMovies, $queueItems);

				$queueSize = $xml->xpath("/queue/number_of_results");
				$queueSize = $queueSize[0];
				$resultsPerPage = $xml->xpath("/queue/results_per_page");
				$resultsPerPage = $resultsPerPage[0];
				$itemsFetched += $resultsPerPage;

				if($itemsFetched >= $queueSize){
					break;
				}
			}
			else{
				break;
			}
		}
		
		$this->log(__METHOD__ . ": Done Fetching queue items.", LOG_DEBUG);
		
		return $queuedMovies;
	}

	public function getNetflixQueueEtag(){
		$url = "http://api-public.netflix.com/users/{$this->userId}/queues/instant";

		while(TRUE){
			$access_params['start_index'] = 1;
			$access_params['max_results'] = 1;
			$items = $this->get($this->accessToken, $this->accessTokenSecret, $url, $access_params);

			if($items){
				$xml = new SimpleXMLElement($items);
				$etag = $xml->etag;
				return $etag;
			}
		}

		return null;
	}

	public function getListOfQueuesRSS(){
		$url = "http://api-public.netflix.com/users/{$this->userId}/feeds";
		$items = $this->get($this->accessToken, $this->accessTokenSecret, $url);
		return $items;
	}
}
