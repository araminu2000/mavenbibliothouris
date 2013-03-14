<?php

class Bibliothouris_CoursesControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testRoutingBibliothourisModuleOnDefaultModule_ErrorController_ErrorIndex_IfControllerNotSet(){
        $url = '/bibliothouris/';
        $this->dispatch($url);
        $this->assertRedirect('/bibliothouris/courses/list');
    }

    public function testRoutingInexistingUriOnDefaultModule_ErrorController_ErrorIndex(){
        $url = '/inexistent/';
        $this->dispatch($url);

        $this->assertModule('default');
        $this->assertController('error');
        $this->assertAction('error');
    }

    public function testRoutingCoursesControllerOnIndexAction(){
        $url = '/bibliothouris/courses/index/';
        $this->dispatch($url);

        $this->assertModule('bibliothouris');
        $this->assertController('courses');
        $this->assertAction('list');
    }

    public function testRoutingCoursesControllerOnIndexActionIfActionNotSet(){
        $url = '/bibliothouris/courses/';
        $this->dispatch($url);

        $this->assertModule('bibliothouris');
        $this->assertController('courses');
        $this->assertAction('list');
    }

    public function testRoutingCoursesControllerOnLoginAction(){
        $url = '/bibliothouris/courses/register/';
        $this->dispatch($url);

        $this->assertModule('bibliothouris');
        $this->assertController('courses');
        $this->assertAction('register');
    }

    public function testIfLoginPageContainsLoginForm(){
        $url = '/bibliothouris/courses/register/';
        $this->dispatch($url);

        $this->assertQueryCount('form#registerForm', 1);
    }

    public function testIfLoginPageContainsRightTitle(){
        $url = '/bibliothouris/courses/register/';
        $this->dispatch($url);

        $this->assertQueryContentContains('div.page-title', 'Register a new course');
    }

    public function testIfAjaxInfoAreCorrectForListingCourses() {
        $url = '/bibliothouris/courses/ajax-list-courses/';
        $this->dispatch($url);


        $coursesMapper = new Bibliothouris_Model_CoursesMapper();
        $courses = $coursesMapper->fetchAll();
        $coursesArray = array();
        foreach($courses as $course) {
            $coursesArray[] = array(
                $course->getDateStart(),
                $course->getDateEnd(),
                $course->getTitle(),
                $course->getTrainerName(),
                $course->getId()
            );
        }

        $httpResponse = $this->getResponse();

        $this->assertEquals($httpResponse->getBody(),Zend_Json::encode($coursesArray));
        $this->assertHeaderContains('Content-Type', 'application/json');
        $this->assertResponseCode(200, null);
    }


    public function testControllerRedirectIfCourseIdNotSetInUrl() {

        $url = '/bibliothouris/courses/detail';
        $this->dispatch($url);

        $responseHeaders = $this->response->getHeaders();
        $this->assertTrue(count($responseHeaders) != 0);
        $this->assertArrayHasKey('value', $responseHeaders[0]);

        $this->assertEquals('/bibliothouris/courses/index', $responseHeaders[0]['value']);

    }

    public function testIfCourseIsCorrectListedWhenSearchingWithCourseId() {

        $url = '/bibliothouris/courses/detail?id=1';
        $this->dispatch($url);

        $frontController = $this->getFrontController();

        $courseId = $this->getRequest()->getParam('id', false);

        $coursesMapper = new Bibliothouris_Model_CoursesMapper();
        $results       = $coursesMapper->find($courseId);

        $this->assertEquals(method_exists($results, 'getId'), true);
        $this->assertEquals(method_exists($results, 'getCreated'), true);
        $this->assertEquals(method_exists($results, 'getDateStart'), true);
        $this->assertEquals(method_exists($results, 'getDateEnd'), true);
        $this->assertEquals(method_exists($results, 'getStatus'), true);
        $this->assertEquals(method_exists($results, 'getModified'), true);
        $this->assertEquals(method_exists($results, 'getTitle'), true);
        $this->assertEquals(method_exists($results, 'getTrainerName'), true);
        $this->assertEquals(method_exists($results, 'getContent'), true);
        $this->assertEquals(method_exists($results, 'getMapper'), true);

        $this->assertEquals($courseId, $results->getId());
    }


    public function testEnrollmentMemberToCourseFromStartToEnd() {

        $cid = 43;
        $mid = 46;

        $url = '/bibliothouris/courses/enroll?cid=' . $cid . '&mid=' . $mid;
        $this->dispatch($url);

        $courseId = $this->getRequest()->getParam('cid', null);
        $memberId = $this->getRequest()->getParam('mid', null);

        $this->assertNotNull($courseId);
        $this->assertNotNull($memberId);

        $this->assertTrue(is_numeric($courseId));
        $this->assertTrue(is_numeric($memberId));


        $enrollmentsMapper = new Bibliothouris_Model_EnrollmentsMapper();
        $isEnrolled = $enrollmentsMapper->countByQuery(' member_id = ' . $mid . ' AND course_id = ' . $cid);

        $this->assertGreaterThan(0, $isEnrolled);
    }

    public function testEnrollControllerWithoutCourseIdAndMemberId() {

        $url = '/bibliothouris/courses/enroll';
        $this->dispatch($url);

        $responseHeaders = $this->response->getHeaders();
        $this->assertTrue(count($responseHeaders) != 0);
        $this->assertArrayHasKey('value', $responseHeaders[0]);

        $this->assertEquals('/bibliothouris/courses/index', $responseHeaders[0]['value']);
    }

    public function testEnrollControllerDispatchIfStudentIsAlreadyEnrolled() {

        $cid = 43;
        $mid = 46;

        $url = '/bibliothouris/courses/enroll?cid=' . $cid . '&mid=' . $mid;
        $this->dispatch($url);

        $enrollmentsMapper = new Bibliothouris_Model_EnrollmentsMapper();

        $isEnrolled = $enrollmentsMapper->isEnrolled($mid, $cid);

        $this->assertLessThanOrEqual(1, $isEnrolled);
    }

}



