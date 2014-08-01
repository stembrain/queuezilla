<?php
class NetflixAccountsController extends AppController {

	var $name = 'NetflixAccounts';
	
	var $adminMode = false;

	function beforeFilter(){
		
		parent::beforeFilter();
		
		$userId = $this->getUserId();
		
		if (!$userId) {
			$this->Session->setFlash(__('You must log in.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		//Dirty admin ACL - Admin can perform all functions. 
		//Other users can only edit their own account.
		if(md5($userId) == 'b00ff44f306b2474c48480fef0e9c395'){
			$this->adminMode = true;
		}
	}
	
	function index() {
		if(!$this->adminMode){
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		$this->NetflixAccount->recursive = 0;
		$this->set('netflixAccounts', $this->paginate());
	}

	function view($id = null) {
		if(!$this->adminMode){
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid netflix account', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('netflixAccount', $this->NetflixAccount->read(null, $id));
	}

	function add() {
		if(!$this->adminMode){
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		if (!empty($this->data)) {
			$this->NetflixAccount->create();
			if ($this->NetflixAccount->save($this->data)) {
				$this->Session->setFlash(__('The netflix account has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The netflix account could not be saved. Please, try again.', true));
			}
		}
		$users = $this->NetflixAccount->User->find('list');
		$this->set(compact('users'));
	}

	/**
	 * Admin can edit any account. Otherwise user must be account owner.
	 * @param $id
	 * @return unknown_type
	 */
	function edit($id = null) {
		$userId = $this->getUserId();
		
		if(!$userId){
			$this->Session->setFlash(__('You must log in first.', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		$netflixAccount = null;
		if($this->adminMode && $id){
			$netflixAccount = $this->NetflixAccount->read(null, $id);					
		}
		else{
			$netflixAccount = $this->NetflixAccount->find("account_number = '$userId'");		
		}

		if(empty($netflixAccount) ||
			(($netflixAccount['NetflixAccount']['account_number'] != $userId) && !$this->adminMode)){
			$this->Session->setFlash(__('Invalid request', true));		
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		$id = $netflixAccount['NetflixAccount']['id'];
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid netflix account', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			$saveStatus = false;
			if(!$this->adminMode){
				$saveStatus = $this->NetflixAccount->save($this->data, true, 'jabber_account');
			}
			else{
				$saveStatus = $this->NetflixAccount->save($this->data);
			}
			
			if($saveStatus){
				$this->Session->setFlash(__('The netflix account has been saved', true));
				$this->redirect(array('controller' => 'queues', 'action' => 'index'));
			} 
			else {
				$this->Session->setFlash(__('The netflix account could not be saved. Please, try again.', true));
			}			
		}
		
		if (empty($this->data)) {
			$this->data = $this->NetflixAccount->read(null, $id);
		}
	}

	function delete($id = null) {
		if(!$this->adminMode){
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for netflix account', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->NetflixAccount->delete($id)) {
			$this->Session->setFlash(__('Netflix account deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Netflix account was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function showNetflixAccountNumber($id = null){
		if(!$this->adminMode){
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('controller' => 'queues', 'action' => 'index'));
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for netflix account', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('netflixAccount', $this->NetflixAccount->read(null, $id));
		
		$netflix = $this->NetflixAccount->getNetflixAPIConsumer($id);		
		$accountNumber = $netflix->getNetflixAccountNumber();
		$this->set('accountNumber', $accountNumber);
	}
}
?>