<?php

/**
 * DashboardWidgetsTest
 * 
 * @package  
 * @author    Amos Kosgei <amos@tracetracker.com> 
 * @copyright Tracetracker
 * @version   $id$
 * @uses      PHPUnit
 * @uses      _Framework_testCase
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
//define('TEST_BASE_URL', 'http://localhost/story/index.php/');
class DashboardWidgetsTest extends PHPUnit_Extensions_SeleniumTestCase {

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
		$this->type("id=LoginForm_username", "james@tracetracker.com");
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
		$this->click("link=Graph View (2)");
		sleep(2);
		$this->assertElementPresent("id=addwidgetgeoLocationWidget");
		$this->click("id=addwidgetgeoLocationWidget");
		sleep(8);
		$this->assertElementPresent("//div[@title='Geo Location']/div/span[2]/span[2]");
		$this->click("//div[@title='Geo Location']/div/span[2]/span[2]");
		sleep(10);
		$this->assertElementPresent("//div[@title='Geo Location']/div/span[2]/span[3]/ul/li[4]");
		$this->click("//div[@title='Geo Location']/div/span[2]/span[3]/ul/li[4]");
		sleep(1);
		$this->assertElementPresent("id=GeoLocationWidgetForm_title");
		$this->type("id=GeoLocationWidgetForm_title", "Geo Location");
		sleep(1);
		$this->assertElementPresent("id=GeoLocationWidgetForm_epc");
		$this->type("id=GeoLocationWidgetForm_epc", "urn:gtnet:id:gsii:9999.161105.16111400");
		sleep(1);
		$this->assertElementPresent("id=GeoLocationWidgetForm_dateFrom");
		$this->type("id=GeoLocationWidgetForm_dateFrom", "1-10-2012");
		sleep(1);
		$this->assertElementPresent("id=GeoLocationWidgetForm_dateTo");
		$this->type("id=GeoLocationWidgetForm_dateTo", "5-11-2012");
		sleep(1);
		$this->assertElementPresent("id=configSubmit");
		$this->click("id=configSubmit");
		sleep(15);
		$this->click("//div[@title='Geo Location']/div/span[2]/span[2]");
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

	/**
	 * testEvent Statistics Widget 
	 * 
	 * @access public
	 * @return void
	 */
	public function testEventStatisticsWidget() {
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
		$this->assertElementPresent("id=addwidgeteventStatisticsWidget");
		$this->click("id=addwidgeteventStatisticsWidget");
		sleep(8);
		$this->assertElementPresent("//div[@title='Event Statistics']/div/span[2]/span[2]");
		$this->click("//div[@title='Event Statistics']/div/span[2]/span[2]");
		sleep(10);
		$this->assertElementPresent("//div[@title='Event Statistics']/div/span[2]/span[3]/ul/li[4]");
		$this->click("//div[@title='Event Statistics']/div/span[2]/span[3]/ul/li[4]");
		sleep(1);
		$this->assertElementPresent("id=EventStatisticsWidgetForm_title");
		$this->type("id=EventStatisticsWidgetForm_title", "Event Statistics");
		sleep(1);
		$this->assertElementPresent("id=EventStatisticsWidgetForm_bizLocation");
		$this->type("id=EventStatisticsWidgetForm_bizLocation", "Nairobi");
		sleep(1);
		$this->assertElementPresent("id=EventStatisticsWidgetForm_dateFrom");
		$this->type("id=EventStatisticsWidgetForm_dateFrom", "14-11-2012");
		sleep(1);
		$this->assertElementPresent("id=EventStatisticsWidgetForm_dateTo");
		$this->type("id=EventStatisticsWidgetForm_dateTo", "30-11-2012");
		sleep(1);
		$this->assertElementPresent("id=configSubmit");
		$this->click("id=configSubmit");
		sleep(15);
		$this->click("//div[@title='Event Statistics']/div/span[2]/span[2]");
		sleep(1);
		$this->click("css=li.widgetDelete");
		sleep(1);
		$this->assertConfirmation("Are you sure you want to delete this widget?");
		sleep(1);
		$this->clickAndWait("id=yt0");
		sleep(2);
	}
	
	/**
	 * testEventsWidget
	 * 
	 * @access public
	 * @return void
	 */
	public function testShipmentsBTLWidget() {
		/*$this->open('site/login');
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
		
		sleep(15);*/
		$this->assertElementPresent("id=addWidget");
		$this->click("id=addWidget");
		sleep(8);
		//$this->assertElementPresent("link=Graph View (2)");
		//$this->click("link=List View (5)");
		//sleep(2);
		$this->assertElementPresent("id=addwidgetshipmentsWidget");
		$this->click("id=addwidgetshipmentsWidget");
		sleep(8);
		$this->assertElementPresent("//div[@title='Shipments between two locations']/div/span[2]/span[2]");
		$this->click("//div[@title='Shipments between two locations']/div/span[2]/span[2]");
		sleep(10);
		$this->assertElementPresent("//div[@title='Shipments between two locations]/div/span[2]/span[3]/ul/li[4]");
		$this->click("//div[@title='Shipments between two locations']/div/span[2]/span[3]/ul/li[4]");
		sleep(1);
		//$this->click("css=li.widgetDelete");
		//sleep(1);
		$this->assertElementPresent("id=ShipmentsWidgetForm_title");
		$this->type("id=EventwidgetForm_title", "Shipments between two locations");
		sleep(1);
		//$this->assertElementPresent("id=EventStatisticsWidgetForm_bizLocation");
		//$this->type("id=EventStatisticsWidgetForm_bizLocation", "Nairobi");
		sleep(1);
		$this->assertElementPresent("id=ShipmentsWidgetForm_dateFrom");
		$this->type("id=ShipmentsWidgetForm_dateFrom", "1-10-2012");
		sleep(1);
		$this->assertElementPresent("id=ShipmentsWidgetForm_dateTo");
		$this->type("id=ShipmentsWidgetForm_dateTo", "30-11-2012");
		sleep(1);
		$this->assertElementPresent("id=ShipmentsWidgetForm_fromLocation");
		$this->type("id=ShipmentsWidgetForm_fromLocation", "urn:gtnet:id:gsli:0800002873.Nairobi");
		sleep(1);
		$this->assertElementPresent("id=ShipmentsWidgetForm_toLocation");
		$this->type("id=ShipmentsWidgetForm_toLocation", "urn:gtnet:id:gsli:0800002873.Nakuru");
		sleep(1);
		$this->assertElementPresent("id=configSubmit");
		$this->click("id=configSubmit");
		sleep(15);
		$this->click("//div[@title='Shipments between two locations']/div/span[2]/span[2]");
		sleep(1);
		$this->click("css=li.widgetDelete");
		sleep(1);
		$this->assertConfirmation("Are you sure you want to delete this widget?");
		sleep(1);
		//$this->clickAndWait("id=yt0");
		//sleep(2);
		
	}

}
