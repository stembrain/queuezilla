<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {

	var $components = array('Session');

	public function beforeFilter(){
		App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'netflix_consumer.php'));
	}

	
	protected function getUserId(){
		$accountNumberHash = null;	
		if(isset($_COOKIE['user_id'])){
			$accountNumberHash = $_COOKIE['user_id'];
		}
		else if(isset($_SESSION['user_id'])){
			$accountNumberHash = $_SESSION['user_id'];
		}
		
		if(!empty($accountNumberHash)){
			App::import('NetflixAccount');
			$netflixAccount = new NetflixAccount();
			$accountNumber = $netflixAccount->find('first', 
				array(
					'conditions' => array("account_number_hash" => $accountNumberHash),
					'fields' => 'account_number'
				)
			);
			
//			$this->log('Found account number ' . $accountNumber['NetflixAccount']['account_number'], LOG_DEBUG);
			return $accountNumber['NetflixAccount']['account_number'];
		}
		else{
			return null;
		}
	}
}
