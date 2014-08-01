<?php
/* NetflixAccount Fixture generated on: 2010-11-20 21:11:46 : 1290305386 */
class NetflixAccountFixture extends CakeTestFixture {
	var $name = 'NetflixAccount';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'account_number' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'oauth_token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'oauth_token_secret' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'account_number' => 1,
			'oauth_token' => 'Lorem ipsum dolor sit amet',
			'oauth_token_secret' => 'Lorem ipsum dolor sit amet',
			'created' => '2010-11-20 21:09:46',
			'modified' => '2010-11-20 21:09:46'
		),
	);
}
?>