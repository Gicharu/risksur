<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class SiteTest extends PHPUnit_Extensions_SeleniumTestCase
{
	protected function setUp()
    {
		$this->setBrowser('*firefox' );
        $this->setBrowserUrl( 'http://localhost:11200/wd/hub/' );
        $this->setPort( 11200 );
    }
    
    public function testIndex()
	{
		$this->open('');
		sleep(15);
		//$this->assertTextPresent('Login');
	}
	
	public function testLogin()
	{
            /*
		$this->open('site/login');
		sleep(15);
		// ensure the user is logged out


		    if($this->isTextPresent('Logout'))
			$this->clickAndWait('link=Logout (nancy)');

		// test login process, including validation
        $this->clickAndWait('link=Login');

		$this->assertElementPresent('name=LoginForm[username]');
		$this->assertElementPresent('name=LoginForm[loginType]');
		$this->type('name=LoginForm[username]','administrator');
		$this->select('name=LoginForm[loginType]','label=Ldap Login');
		$this->click("//input[@value='Login']");
		sleep(5);
		//$this->waitForTextPresent('Password cannot be blank.');
		$this->assertTextPresent('Password cannot be blank.');
		$this->type('name=LoginForm[password]','tiger');
		$this->select('name=LoginForm[loginType]','label=Ldap Login');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertTextNotPresent('Password cannot be blank.');
		$this->assertTextPresent('Logout');


		// test logout process
		$this->assertTextNotPresent('Login');
		$this->clickAndWait('link=Logout (nancy)');
		$this->assertTextPresent('Login');
		*/
	}
	
}
