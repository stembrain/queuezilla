<?php
class QueueMovie extends AppModel {
	var $name = 'QueueMovie';
	var $validate = array(
		'queue_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Queue Movies must have an associated queue.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'netflix_entryId' => array(
			'numeric' => array(
				'rule' => 'notEmpty',
				'message' => 'Queue Movies must have a netflix url that specifies the user queue, user id, and movie.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'netflix_key' => array(
			'numeric' => array(
				'rule' => 'notEmpty',
				'message' => 'Queue Movies must have a netflix url that specifies a URL for the movie.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'position' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),				
	);
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed		
	var $belongsTo = array(
		'Queue' => array(
			'className' => 'Queue',
			'foreignKey' => 'queue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>