<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once 'PHPUnit/Extensions/SeleniumTestCase/Driver.php';
require_once 'PHPUnit/Extensions/SeleniumTestSuite.php';
 
class SeleniumInsertCourseTest extends PHPUnit_Extensions_SeleniumTestCase {

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
	public function testSeleniumInsertCourse($data) {
	
		 $this->open( $data[0] );
		 $this->clickAndWait('//*[@id="ui-id-3"]');
		 
		 $fakeCourseTitle = 'Selenium Auto-Test Course ' . rand(0,100);
		 $fakeDateStart	  = date('Y-m-d');
		 $fakeDateEnd	  = date('Y-m-d');
		 $fakeTrainerName = 'Selenium Trainer name ' . rand(0,100);
		 $fakeContent	  = 'Selenium Test Content ' . sha1(rand(0,100));
		
		 
		 $this->type('//*[@id="title"]', $fakeCourseTitle);
		 $this->type('//*[@id="date_start"]', $fakeDateStart);
		 $this->type('//*[@id="date_end"]', $fakeDateEnd);
		 $this->type('//*[@id="trainer_name"]', $fakeTrainerName);
		 $this->type('//*[@id="content"]', $fakeContent);
		 
		 $this->clickAndWait('//*[@id="registerCourseSbt"]');
		 
		 $this->open(self::DEFAULT_APP_URL . '/bibliothouris/courses/ajax-list-courses/');
		 $this->assertTrue($this->isTextPresent($fakeCourseTitle));
	}
}
