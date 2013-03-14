<?php
class Bibliothouris_CoursesController extends Zend_Controller_Action {

    public function init() {
		$this->_helper->layout->setLayout('layout');
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

        $session = new Zend_Session_Namespace("identity");

        if (is_null($courseId) || is_null($memberId)) {
            $this->_redirect('bibliothouris/courses/index');
        }

        if (array_key_exists('id', $session->userData) && count($session->userData)) {

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

        if (is_null($courseId)) {
            $this->_redirect('bibliothouris/courses/index');
        }

        $coursesMapper = new Bibliothouris_Model_CoursesMapper();
        $results       = $coursesMapper->find($courseId);


        $this->view->headTitle()->headTitle('View Details for ' . $results->getTitle());
        $this->view->courseInfo = array(
            'title'      => $results->getTitle(),
            'dateStart'  => $results->getDateStart(),
            'dateEnd'    => $results->getDateEnd(),
            'trainer'    => $results->getTrainerName(),
            'contents'   => $results->getContent(),
            'id'         => $results->getId()
        );

        if (date("Y-m-d") > $results->getDateStart()) {
            $this->view->disableEnrollment = true;
        }

        $session = new Zend_Session_Namespace('identity');

        if (isset($session->userData)) {
            $this->view->currentUserId = $session->userData['id'];
        }
    }

    public function ajaxListCoursesAction() {
        
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

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        echo $this->_helper->json($coursesArray, false);

    }

}
