<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once 'PHPUnit/Extensions/SeleniumTestCase/Driver.php';
require_once 'PHPUnit/Extensions/SeleniumTestSuite.php';
 
class SeleniumAuthenticateTest extends PHPUnit_Extensions_SeleniumTestCase {

	const DEFAULT_BROWSER = '*firefox';
	const DEFAULT_PORT	  = 4444;
	const DEFAULT_APP_URL = 'http://www1.mavencourses.ro/';

	public function setUp() {
			$this->setBrowser(self::DEFAULT_BROWSER);
			$this->setPort(self::DEFAULT_PORT);
			$this->setBrowserUrl(self::DEFAULT_APP_URL);
	}
	 
	public function provider() {
			 return array(
							array(
									array(self::DEFAULT_APP_URL, __CLASS__) 
								) 
						);
	}
	 
	/**
	* @dataProvider provider
	*/
	public function testSeleniumAuthenticate($data) {

		  $this->open($data[0]);
		  $this->clickAndWait('//*[@id="main-wrapper"]/div[1]/div/span/a');

		  $this->type('//*[@id="email"]','araminu2000@yahoo.com');
		  $this->type('//*[@id="password"]','macara0&');
		  $this->clickAndWait('//*[@id="loginMember"]');
		  $this->waitForPageToLoad(10);
		  
		  $this->assertEquals('Marius Anghel',$this->getText('//*[@id="main-wrapper"]/div[1]/div/span[1]'));
	}
 
}
