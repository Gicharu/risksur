<?php
/*
 * The tests in this code have been commented out as they are functional/Integration tests.Which will be covered by a different Issue.
 *
 *
 */
/**
 * ContactTest 
 * 
 * @package  
 * @author    Chirag Doshi <chirag@tracetracker.com> 
 * @copyright Tracetracker
 * @version   $id$
 * @uses      PHPUnit
 * @uses      _Framework_testCase
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
//define('TEST_BASE_URL', 'http://localhost/story/index.php/');
class ITSiteLoginTest extends PHPUnit_Extensions_SeleniumTestCase {
	//class SiteTest extends WebTestCase {

	/**
	 * testIndex 
	 * 
	 * @access public
	 * @return void
	 */
	//TEST_BASE_URL = 'http://localhost/story/index.php';
	public $fixtures = array(
		'post' => 'Post'
	);
	/**
	 * setUp 
	 * 
	 * @access public
	 * @return void
	 */
	public function setUp() {
		// Import controller
		//s  Yii::import('application.controllers.*');
		$this->setBrowser("*firefox");
		parent::setUp();
		//session_start();
		$this->setBrowserUrl('http://localhost/story/index.php/');
	}
	/*public function testIndex() {
		//		$this->open('');
		//		$this->assertTextPresent('Login');

	}*/
	/**
	 * testContact 
	 * 
	 * @access public
	 * @return void
	 */
	/**
	 * testLoginLogout 
	 * 
	 * @access public
	 * @return void
	 */
	public function testLoginLogout() {
		$this->open('site/login');
		// ensure the user is logged out
		if ($this->isTextPresent('Logout')) {
			$this->clickAndWait('id=yt0');
			$this->waitForPageToLoad("30000");
		}
		sleep(2);
		$this->assertElementPresent('id=LoginForm_username');
		$this->assertElementPresent('id=LoginForm_password');
		$this->assertElementPresent("id=login");
		$this->type("id=LoginForm_username", "John");
		$this->type("id=LoginForm_password", "tiger123");
		$this->clickAndWait("id=login");
		sleep(1);
		if ($this->isElementPresent("id=selectNode")) {
			$this->selectAndWait("id=selectNode", "label=Feed Company - Nightly 5.0 Feed GAN - 0800000024000011");
		}
		sleep(8);
		$this->clickAndWait("id=yt0");
		//		$this->open('site/login');
		//		// ensure the user is logged out
		//		if($this->isTextPresent('Logout'))
		//			$this->clickAndWait('link=Logout (nancy)');
		//
		//		// test login process, including validation
		//        //$this->clickAndWait('link=Login');
		//		$this->assertElementPresent('name=LoginForm[username]');
		//		$this->assertElementPresent('name=LoginForm[loginType]');
		//		$this->type('name=LoginForm[username]','nancy');
		//		$this->select('name=LoginForm[loginType]','label=Ldap Login');
		//		$this->click("//input[@value='Login']");
		//		sleep(5);
		//		//$this->waitForTextPresent('Password cannot be blank.');
		//		$this->assertTextPresent('Password cannot be blank.');
		//		$this->type('name=LoginForm[password]','tiger');
		//		$this->select('name=LoginForm[loginType]','label=Ldap Login');
		//		$this->clickAndWait("//input[@value='Login']");
		//		$this->assertTextNotPresent('Password cannot be blank.');
		//		$this->assertTextPresent('Logout');
		//
		//		// test logout process
		//		$this->assertTextNotPresent('Login');
		//		$this->clickAndWait('link=Logout (nancy)');
		//		$this->assertTextPresent('Login');
		//$controller = new SiteController('site');
		//ob_start();
		//$this->assertTrue($controller != null);
		//$this->assertInstanceOf('SiteController', $controller);
		//$controller->actionLogin();
		//echo $controller->model;
		//$this->assertTrue($controller->model != null);
		//$this->assertEquals('login', $controller->viewId);

	}
	//}

}
