<?php
/* QueuedMovie Fixture generated on: 2010-11-20 21:11:09 : 1290305409 */
class QueuedMovieFixture extends CakeTestFixture {
	var $name = 'QueuedMovie';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'movie_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'queue_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'movie_id' => 1,
			'queue_id' => 1,
			'created' => '2010-11-20 21:10:09',
			'modified' => '2010-11-20 21:10:09'
		),
	);
}
?>