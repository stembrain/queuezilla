<?php
class Queue extends AppModel {
	var $name = 'Queue';
	var $validate = array(
		'account_number' => array(
			'rule' => 'notEmpty',
			'message' => 'Queues must have a title.',
			'allowEmpty' => false,
			'required' => true,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'Queues must have a title.',
			'allowEmpty' => false,
			'required' => true,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'NetflixAccount' => array(
			'className' => 'NetflixAccount',
			'foreignKey' => 'account_number',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'QueueMovie' => array(
			'className' => 'QueueMovie',
			'foreignKey' => 'queue_id',
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

}
?>