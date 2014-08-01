<?php
class NetflixAccount extends AppModel {
	var $name = 'NetflixAccount';
	var $validate = array(
		'account_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'account_number_hash' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'oauth_token' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'oauth_token_secret' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Queue' => array(
			'className' => 'Queue',
			'foreignKey' => 'account_number',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	/**
	 * Creates a netflix api consumer object associated with this netflix
	 * account.
	 * @param unknown_type $id - database id of a stembrain netflix account
	 * @return NetflixConsumer object
	 */
	public function getNetflixAPIConsumer($id){
		if(!$id){
			throw new Exception("Invalid Netflix Account ID");
		}
		
		App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'netflix_consumer.php'));		
		$netflixAccount = $this->find('first', array('conditions' => array('NetflixAccount.id' => $id)));
		$netflixUserId = $netflixAccount['NetflixAccount']['account_number'];
		$accessToken = $netflixAccount['NetflixAccount']['oauth_token'];
		$accessTokenSecret =  $netflixAccount['NetflixAccount']['oauth_token_secret'];
		$netflix = new NetflixConsumer($accessToken, $accessTokenSecret, $netflixUserId);
		return $netflix;
	}
	
	/**
	 * Creates a netflix api consumer object associated with the netflix
	 * account of the user id passed in
	 * @param unknown_type $id - database id of a user who has an associated netflix account.
	 * @return NetflixConsumer object
	 */
	public function getNetflixAPIConsumerForAccountNumber($accountNumber){
		if(!$accountNumber){
			throw new Exception("Invalid User Id");
		}
		
		$netflixAccount = $this->find('first', array('conditions' => array('NetflixAccount.account_number' => $accountNumber)));
		return $this->getNetflixAPIConsumer($netflixAccount['NetflixAccount']['id']);
	}	
}
?>