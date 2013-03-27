<?php
class Bibliothouris_CoursesController extends Zend_Controller_Action {

    protected $_session;

    public function init() {
		$this->_helper->layout->setLayout('layout');
        $this->_session = new Zend_Session_Namespace("identity");
    }

    public function preDispatch() {
        /* Nothing to do right now */
    }

    public function postDispatch() {
        /* Nothing to do right now */
    }

    public function indexAction() {
        $this->_forward('list');
    }

    public function listAction() {
        $this->view->headTitle()->headTitle('Courses list Title');
    }

    public function followingAction() {

        $m = $this->getRequest()->getParam('id', null);

        if (intval($m) <= 0) {
            $this->_redirect('/bibliothouris/members/list/');
        }

        $membersMapper = new Bibliothouris_Model_MembersMapper();
        $result        = $membersMapper->find($m);

        if (empty($result)) {
            $this->_redirect('/bibliothouris/members/list/');
        }

        $dataArray = $membersMapper->toArray($result);
        $this->view->memberData = $dataArray;
        $this->view->headTitle()->headTitle('Courses followed by ' . $dataArray['fname'] . ' ' . $dataArray['lname']);
    }

    public function feedbackAction(){
        $courseId = $this->getRequest()->getParam('course_id',null);

        if (empty($this->_session->userData) || intval($this->_session->userData['id']) == 0){
            $this->_redirect('/bibliothouris/members/login/');
        }

        if(intval($courseId) <= 0){
            $this->_redirect('/bibliothouris/courses/list/');
        }

        $coursesMapper = new Bibliothouris_Model_CoursesMapper();
        $results       = $coursesMapper->find($courseId);

        $this->view->headTitle()->headTitle('Register feedback on course ' . $results->getTitle() . ' (<i>'.$results->getDateStart().' - '.$results->getDateEnd().'</i>)');

        $feedbackCourseForm = new Bibliothouris_Form_FeedbackCourse();
        $feedbackCourseForm->setAction($this->getFrontController()->getBaseUrl() . '/bibliothouris/courses/feedback-save');
        $feedbackCourseForm->setPrevalidation();
        $this->view->feedbackCourseForm = $feedbackCourseForm;
    }

    public function feedbackSaveAction(){
        if (empty($this->_session->userData) || intval($this->_session->userData['id']) == 0){
            $this->_redirect('/bibliothouris/members/login/');
        }

        $errMessages = array();

        $request = $this->getRequest();
        $form    = new Bibliothouris_Form_FeedbackCourse();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $coursesMapper = new Bibliothouris_Model_CoursesFeedbackMapper();
                $requestInfo = $request->getPost();
                $requestInfo['member_id'] = $this->_session->userData['id'];
                $coursesModel = $coursesMapper->loadModel($requestInfo);

                $coursesModel->getMapper()->getDbTable()->insert(
                    $coursesModel->getMapper()->toArray($coursesModel)
                );
            } else {
                $errMessages = $form->getMessages();
            }
        }

        foreach($errMessages as $k => $v) {
            $this->view->errorMessages = implode('<br />', $v);
        }

        if (empty($errMessages)) {
            $this->_redirect('bibliothouris/courses/index');
        } else {
            $this->_forward('feedback');
        }
    }

    public function registerAction() {
        $registerCourseForm = new Bibliothouris_Form_RegisterCourse();
        $registerCourseForm->setAction($this->getFrontController()->getBaseUrl() . '/bibliothouris/courses/register-save');

        if($this->getRequest()->isPost()){
            $registerCourseForm->populate($this->getRequest()->getPost());
        }

        $registerCourseForm->setPrevalidation();
        $this->view->registerCourseForm = $registerCourseForm;
    }

    public function registerSaveAction(){

        $this->view->headTitle()->headTitle('Register new course');

        $errMessages = array();
        
        $request = $this->getRequest();
        $form    = new Bibliothouris_Form_RegisterCourse();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $coursesMapper = new Bibliothouris_Model_CoursesMapper();
                $coursesModel = $coursesMapper->loadModel($request->getPost());
                $coursesModel->getMapper()->getDbTable()->insert(
                    $coursesModel->getMapper()->toArray($coursesModel)
                );
            } else {
                $errMessages = $form->getMessages();
            }
        }

        foreach($errMessages as $k => $v) {
            $this->view->errorMessages = implode('<br />', $v);
        }

        if (empty($errMessages)) {
            $this->_redirect('bibliothouris/courses/index');
        } else {
            $this->_forward('register');
        }
    }

    public function enrollAction() {

        $courseId = $this->getRequest()->getParam('cid', null);
        $memberId = $this->getRequest()->getParam('mid', null);

        if (is_null($courseId) || is_null($memberId)) {
            $this->_redirect('bibliothouris/courses/list');
        }

        if (count($this->_session->userData) && array_key_exists('id', $this->_session->userData) ) {

            $enrollmentsMapper = new Bibliothouris_Model_EnrollmentsMapper();

            if ($enrollmentsMapper->isEnrolled($memberId, $courseId) > 0) {

                $this->view->message = 'You are already enrolled in this course!';

            } else {

                $enrollmentModel = $enrollmentsMapper->loadModel(array(
                    'member_id' => $memberId,
                    'course_id' => $courseId
                ));

                $added = $enrollmentModel->getMapper()->getDbTable()->insert(
                    $enrollmentModel->getMapper()->toArray($enrollmentModel)
                );

                if ($added && is_numeric($added)) {

                    $coursesMapper = new Bibliothouris_Model_CoursesMapper();
                    $results       = $coursesMapper->find($courseId);

                    $this->view->courseName   = $results->getTitle();
                    $this->view->startingDate = $results->getDateStart();
                    $this->view->endDate      = $results->getDateEnd();

                    $this->view->message = 'You successfully enrolled in course : '
                                            . $results->getTitle()
                                            . ' starting '
                                            . $results->getDateStart()
                                            . ' untill ' . $results->getDateEnd();
                }
            }

            $this->view->courseId = $courseId;

        } else {
            $this->_redirect('bibliothouris/members/login');
        }
    }

    public function detailAction() {

        $courseId = $this->getRequest()->getParam('id', null);

        if (intval($courseId) == 0) {
            $this->_redirect('bibliothouris/courses/index');
        }

        $coursesMapper = new Bibliothouris_Model_CoursesMapper();
        $results       = $coursesMapper->find($courseId);
        $registerCourseForm = new Bibliothouris_Form_RegisterCourse();
        $registerCourseForm->setAction('#');
        $registerCourseForm->populate($coursesMapper->toArray($results));

        if (date("Y-m-d") > $results->getDateEnd()) {
            $registerCourseForm->disableEnrollment = true;
        }

        $registerCourseForm->setReadonly();
        $this->view->registerCourseForm = $registerCourseForm;
        $this->view->headTitle('View Details for ' . $results->getTitle());
    }

    public function ajaxListCoursesAction() {

        $coursesArray = array();
        
        $coursesMapper = new Bibliothouris_Model_CoursesMapper();
        $courses = $coursesMapper->fetchAll();

        $enrollMentsMapper = new Bibliothouris_Model_EnrollmentsMapper();
        $enrolledIn = $enrollMentsMapper->getAllByMember( (int) $this->_session->userData['id'] );

        foreach($courses as $course) {

            $feedbackId = null;

            if (date("Y-m-d") > $course->getDateEnd() && in_array($course->getId(), $enrolledIn)) {
                $feedbackId = $course->getId();
            }

            $coursesArray[] = array(
                $course->getDateStart(),
                $course->getDateEnd(),
                $course->getTitle(),
                $course->getTrainerName(),
                $course->getId(),
                $feedbackId
            );

        }

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        echo $this->_helper->json($coursesArray, false);

    }

    public function ajaxListFollowingAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $member_id = $this->getRequest()->getParam('m', null);
        $outputArr = array();

        if (intval($member_id) > 0) {

            $coursesMapper = new Bibliothouris_Model_CoursesMapper();
            $courses = $coursesMapper->getCoursesFollowedByMemberId($member_id);

            foreach($courses as $course) {
                $outputArr[] = array(
                    $course['date_start'],
                    $course['date_end'],
                    $course['title'],
                    $course['trainer_name'],
                );
            }
        }

        echo $this->_helper->json($outputArr, false);
    }

}
