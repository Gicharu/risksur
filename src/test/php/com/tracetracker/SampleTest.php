<?php

class SampleTest extends PHPUnit_Framework_TestCase {
	
	public function testGetDate() {
		$today = getdate();

		// Assert that a value is not null
		$this->assertNotNull( $today );
		// Assert that a value is greater than another value 
		$this->assertGreaterThan( 2011, $today['year'] );
		// Assert that a value is greater than another value, customize message for failed test 
		$this->assertGreaterThan( 2011, $today['year'], "Today's year should be greater than 2011" );
		// Assert that a value is greater than another value 
		$this->assertFalse( $today == "yesterday" );
	}

}
?>
