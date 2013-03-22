<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once 'PHPUnit/Extensions/SeleniumTestCase/Driver.php';
require_once 'PHPUnit/Extensions/SeleniumTestSuite.php';
 
class SeleniumProvideFeedbackTest extends PHPUnit_Extensions_SeleniumTestCase {
 
public function setUp() {
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://www1.mavencourses.ro/');
}
 
public function provider() {
         return array (array (array ('http://www1.mavencourses.ro/') ) );
}
 
/**
* @dataProvider provider
*/
public function testSeleniumProvideFeedback($data) {
	
      $this->open($data[0]);
      $this->clickAndWait('//*[@id="main-wrapper"]/div[1]/div/span/a');
      $this->type('//*[@id="email"]','araminu2000@yahoo.com');
      $this->type('//*[@id="password"]','macara0&');
      $this->clickAndWait('//*[@id="loginMember"]');
      $this->waitForPageToLoad(10);
      
      $this->assertEquals('Marius Anghel', $this->getText('//*[@id="main-wrapper"]/div[1]/div/span[1]'));
	
	  $this->open('http://www1.mavencourses.ro/bibliothouris/courses/feedback?course_id=1');
	  
	  $this->click('//*[@id="score_trainer-1"]');
	  $this->click('//*[@id="score_location_infrastructure-1"]');
	  $this->click('//*[@id="score_documentation-1"]');
	  $this->click('//*[@id="score_recommend-1"]');
	  $this->type('//*[@id="score_content"]', 'Selenium test ' . rand(100, 1000));
	  
	  $this->clickAndWait('//*[@id="registerCourseSbt"]');
      $this->waitForPageToLoad(10);
	    	
	}
 
}
