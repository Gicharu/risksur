<?php
/**
 * DashboardWidgetsTest
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
class ITDashboardWidgetsTest extends PHPUnit_Extensions_SeleniumTestCase {
	//class DashboardWidgetsTest extends CWebTestCase {
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
		//parent::setUp();
		//session_start();
		$this->setBrowserUrl('http://localhost/story/index.php/');
	}
	/**
	 * testGeoLocationWidget 
	 * 
	 * @access public
	 * @return void
	 */
	public function testGeoLocationWidget() {
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
		sleep(15);
		$this->assertElementPresent("id=addWidget");
		$this->click("id=addWidget");
		sleep(10);
		$this->assertElementPresent("link=Graph View (2)");
		$this->click("link=List View (5)");
		sleep(2);
		$this->assertElementPresent("id=addwidgeteventWidget");
		$this->click("id=addwidgeteventWidget");
		sleep(8);
		$this->assertElementPresent("//div[@title='Events']/div/span[2]/span[2]");
		$this->click("//div[@title='Events']/div/span[2]/span[2]");
		sleep(10);
		$this->assertElementPresent("//div[@title='Events']/div/span[2]/span[3]/ul/li[4]");
		$this->click("//div[@title='Events']/div/span[2]/span[3]/ul/li[4]");
		sleep(1);
		//$this->click("css=li.widgetDelete");
		//sleep(1);
		$this->assertElementPresent("id=EventwidgetForm_title");
		$this->type("id=EventwidgetForm_title", "Events Test");
		sleep(1);
		//$this->assertElementPresent("id=EventStatisticsWidgetForm_bizLocation");
		//$this->type("id=EventStatisticsWidgetForm_bizLocation", "Nairobi");
		sleep(1);
		$this->assertElementPresent("id=EventwidgetForm_dateFrom");
		$this->type("id=EventwidgetForm_dateFrom", "14-11-2012");
		sleep(1);
		$this->assertElementPresent("id=EventwidgetForm_dateTo");
		$this->type("id=EventwidgetForm_dateTo", "30-11-2012");
		sleep(1);
		$this->assertElementPresent("id=configSubmit");
		$this->click("id=configSubmit");
		sleep(15);
		$this->click("//div[@title='Events']/div/span[2]/span[2]");
		sleep(1);
		$this->click("css=li.widgetDelete");
		sleep(1);
		$this->assertConfirmation("Are you sure you want to delete this widget?");
		sleep(1);
		$this->clickAndWait("id=yt0");
		sleep(2);
		//$storyLogoutUrl = "http://localhost/story/index.php";
		//$this->assertLocationEquals($storyLogoutUrl);
		//$this->assertTitleEquals('Story - Login');
		
	}
}
