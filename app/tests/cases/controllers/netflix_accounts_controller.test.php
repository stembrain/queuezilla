<?php
/* NetflixAccounts Test cases generated on: 2010-11-20 21:11:57 : 1290305397*/
App::import('Controller', 'NetflixAccounts');

class TestNetflixAccountsController extends NetflixAccountsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class NetflixAccountsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.netflix_account', 'app.user', 'app.group');

	function startTest() {
		$this->NetflixAccounts =& new TestNetflixAccountsController();
		$this->NetflixAccounts->constructClasses();
	}

	function endTest() {
		unset($this->NetflixAccounts);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>