<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once 'PHPUnit/Extensions/SeleniumTestCase/Driver.php';
require_once 'PHPUnit/Extensions/SeleniumTestSuite.php';
 
class SeleniumAuthenticateTest extends PHPUnit_Extensions_SeleniumTestCase {
 
public function setUp() {
        $this->setBrowser('*firefox');
        $this->setPort(4444);
        $this->setBrowserUrl('http://www1.mavencourses.ro/');
}
 
public function provider() {
         return array (array (array ('http://www1.mavencourses.ro/', '3.17999') ) );
}
 
/**
* @dataProvider provider
*/
public function testSeleniumAuthenticate($data) {
        $this->open($data[0]);
      $this->clickAndWait('//*[@id="main-wrapper"]/div[1]/div/span/a');
      //$this->waitForPageToLoad(22);
      $this->type('//*[@id="email"]','araminu2000@yahoo.com');
      $this->type('//*[@id="password"]','macara0&');
      $this->clickAndWait('//*[@id="loginMember"]');
      $this->waitForPageToLoad(10);
      
      $this->assertEquals('Marius Anghel',$this->getText('//*[@id="main-wrapper"]/div[1]/div/span[1]'));
}
 
}
