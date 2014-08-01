<?php
/* NetflixAccount Test cases generated on: 2010-11-20 21:11:46 : 1290305386*/
App::import('Model', 'NetflixAccount');

class NetflixAccountTestCase extends CakeTestCase {
	var $fixtures = array('app.netflix_account', 'app.user', 'app.group');

	function startTest() {
		$this->NetflixAccount =& ClassRegistry::init('NetflixAccount');
	}

	function endTest() {
		unset($this->NetflixAccount);
		ClassRegistry::flush();
	}

}
?>