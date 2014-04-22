<?php
/*
 * The tests in this code have been commented out as they are functional/Integration tests.Which will be covered by a different Issue.
 *
 *
*/
ob_start();
/**
 * SiteControllerTest 
 * 
 * @uses PHPUnit
 * @uses _Framework_testCase
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class SiteControllerTest extends PHPUnit_Framework_testCase {
	public $fixtures = array(
		'users' => 'User'
	);
	/**
	 * testLoginLogout 
	 * 
	 * @access public
	 * @return void
	 */
	public function testLoginLogout() {
		//$identity = new UserIdentity('TraciiUser','tiger123');
		//$identity->authenticate();
		//Yii::app()->user->login($identity);
		//$this->assertTrue(TRUE, 'TraciiUser');
		//$this->assertTrue(TRUE,'Advanced Search');
		//$this->checkUser();
		//Yii::app()->user->logout(false); echo "logged out";
		//$this->checkUser();
		//$identity = new UserIdentity('administrator','tiger');
		//$identity->authenticate();
		//Yii::app()->user->login($identity);
		//$this->checkUser();
		//Yii::app()->user->logout(false); echo "logged out";
		//$this->checkUser();
		
	}
	//public function testLogout(){
	//$identity = new UserIdentity('TraciiUser','tiger123');
	//$identity->authenticate();
	//Yii::app()->user->login($identity);
	//$this->assertTrue(TRUE, 'TraciiUser');
	//$this->assertTrue(TRUE,'Advanced Search');
	//$this->checkUser();
	//Yii::app()->user->logout(false); echo "logged out";
	//$this->assertTrue(TRUE, 'Username');
	//$this->assertTrue(TRUE,'Password');
	//$this->checkUser();
	//}
	//private function checkUser()
	//{
	//echo "\n\nStatus of current user:\n";
	//echo "--------------------------\n";
	//echo "User ID: ".Yii::app()->user->id."\n";
	//echo "User Name: ".Yii::app()->user->name."\n";
	//if (Yii::app()->user->isGuest)
	//echo "There is NO user logged in.\n\n";
	//else
	//echo "The user is logged in.\n\n";
	//}
	
}
