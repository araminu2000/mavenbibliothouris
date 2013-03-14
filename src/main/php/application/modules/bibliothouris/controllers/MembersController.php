<?php
class Bibliothouris_MembersController extends Zend_Controller_Action {

    public function init() {
		$this->_helper->layout->setLayout('layout');
    }

    public function preDispatch() {
        $this->view->baseUrl = $this->getFrontController()->getBaseUrl();
    }

    public function indexAction() {
		$this->_forward('list');
    }

    public function registerAction() {
        $registerMemberForm = new Bibliothouris_Form_RegisterMember();
        $registerMemberForm->setAction($this->getFrontController()->getBaseUrl() . '/bibliothouris/members/register-save');

        if($this->getRequest()->isPost()){
            $registerMemberForm->populate($this->getRequest()->getPost());
        }

        $registerMemberForm->setPrevalidation();
        $this->view->registerMemberForm = $registerMemberForm;
    }

    public function registerSaveAction() {
		$this->view->headTitle()->headTitle('Register new member');
        $errMessages = array();


        $request = $this->getRequest();
        $form    = new Bibliothouris_Form_RegisterMember();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $membersMapper = new Bibliothouris_Model_MembersMapper();
                $membersModel = $membersMapper->loadModel($request->getPost());
                $membersModel->setPassword(md5($membersModel->getPassword()));
                $membersModel->getMapper()->getDbTable()->insert(
                    $membersModel->getMapper()->toArray($membersModel)
                );
            } else {
                $errMessages = $form->getMessages();
            }
        }

        foreach($errMessages as $k => $v) {
            $this->view->errorMessages = implode('<br />', $v);
        }

        if (empty($errMessages)) {
            $this->_redirect('bibliothouris/members/index');
        } else {
            $this->_forward('register');
        }

    }

	public function listAction() {
        $this->view->headTitle()->headTitle('Members Listings');
    }

	public function ajaxListMembersAction() {

        $membersMapper = new Bibliothouris_Model_MembersMapper();
        $members = $membersMapper->fetchAll();
        $membersArray = array();
        foreach($members as $member) {
            $membersArray[] = array(
                $member->getFname() . ' ' . $member->getLname()
            );
        }

		$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		echo $this->_helper->json($membersArray, false);

    }

    public function loginAction() {

        $loginMemberForm = new Bibliothouris_Form_LoginMember();
        $loginMemberForm->setAction($this->getFrontController()->getBaseUrl() . '/bibliothouris/members/process-login');

        if($this->getRequest()->isPost()){
            $loginMemberForm->populate($this->getRequest()->getPost());
        }

        $message = $this->getRequest()->getParam('msg', false);

        if ($message) {
            $this->view->msg = $message;
        }

        $loginMemberForm->setPrevalidation();
        $this->view->loginMemberForm = $loginMemberForm;

    }

    public function processLoginAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $email      = $this->getRequest()->getParam('email', null);
        $password   = $this->getRequest()->getParam('password', null);

        if (!is_null($email) && !is_null($password)) {
            $membersMapper = new Bibliothouris_Model_MembersMapper();
            $userData      = $membersMapper->fetchUserData($email, $password);

            if (is_array($userData) && count($userData)) {
                $session = new Zend_Session_Namespace('identity');
                $session->userData = $userData[0];

                // do redirect to last page.
                $this->_redirect('bibliothouris/courses/list');
            } else {
                // do redirect.
                $this->_redirect('bibliothouris/members/login?msg=' . urlencode('User Account is unknown or password is wrong.'));
            }

        } else {
            // problem with user params
            // do nothing for now
        }

    }

    public function processLogoutAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $session       = new Zend_Session_Namespace('identity');
        unset($session->userData);

        $this->_redirect('bibliothouris/courses/list');
    }


    public function postDispatch() {

    }
}
