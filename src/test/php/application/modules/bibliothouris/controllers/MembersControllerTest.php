<?php

class Bibliothouris_MembersControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
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

    public function testRoutingMembersControllerOnIndexAction(){
        $url = '/bibliothouris/members/index/';
        $this->dispatch($url);

        $this->assertModule('bibliothouris');
        $this->assertController('members');
        $this->assertAction('list');
    }

    public function testRoutingMembersControllerOnIndexActionIfActionNotSet(){
        $url = '/bibliothouris/members/';
        $this->dispatch($url);

        $this->assertModule('bibliothouris');
        $this->assertController('members');
        $this->assertAction('list');
    }

    public function testRoutingMembersControllerOnRegisterAction(){
        $url = '/bibliothouris/members/register/';
        $this->dispatch($url);

        $this->assertModule('bibliothouris');
        $this->assertController('members');
        $this->assertAction('register');
    }

    public function testRoutingMembersControllerOnLoginAction(){
        $url = '/bibliothouris/members/login/';
        $this->dispatch($url);

        $this->assertModule('bibliothouris');
        $this->assertController('members');
        $this->assertAction('login');
    }

    public function testIfLoginPageContainsLoginForm() {
        $url = '/bibliothouris/members/login/';
        $this->dispatch($url);

        $this->assertQueryCount('form#loginForm', 1);
    }

    public function testIfLoginPageContainsRegisterForm() {
        $url = '/bibliothouris/members/register/';
        $this->dispatch($url);

        $this->assertQueryCount('form#registerForm', 1);
    }

    public function testIfLoginPageContainsRightTitle() {

        $url = '/bibliothouris/members/register/';
        $this->dispatch($url);

        $this->assertQueryContentContains('div.page-title', 'Register a new member');
    }

    public function testIfAjaxInfoAreCorrectForListingMembers() {
        $url = '/bibliothouris/members/ajax-list-members/';
        $this->dispatch($url);


        $membersMapper = new Bibliothouris_Model_MembersMapper();
        $members = $membersMapper->fetchAll();
        $membersArray = array();
        foreach($members as $member) {

            $line = '<a href="javascript:void(0);" class="members-name">' . $member->getFname() . ' ' . $member->getLname() . '</a> '
                  . '<a href="/bibliothouris/courses/following?id=' . $member->getId() . '" class="members-detail-button buttons" id="' . $member->getId() . '">Detail</a>';

            $membersArray[] = array($line);
        }

        $httpResponse = $this->getResponse();

        $this->assertEquals($httpResponse->getBody(), Zend_Json::encode($membersArray));
        $this->assertHeaderContains('Content-Type', 'application/json');
        $this->assertResponseCode(200, null);
    }

    public function testLoginUserFromStartToEndIfUserIsInvalid() {

        $this->request->setMethod('POST')
             ->setPost(array(
                    'email'             => 'user@lastname.com--invalid',
                    'password'          => 'Password100',
             ));

        $url = '/bibliothouris/members/process-login';
        $this->dispatch($url);

        $email      = $this->getRequest()->getParam('email', null);
        $password   = $this->getRequest()->getParam('password', null);

        $this->assertNotNull($email);
        $this->assertNotNull($password);

        $membersMapper = new Bibliothouris_Model_MembersMapper();
        $isValidUser   = $membersMapper->fetchUserData($email, $password);

        $this->assertFalse($isValidUser);

        $this->assertRedirect('bibliothouris/members/login');

    }

    public function testLoginUserFromStartToEndIfUserIsValid() {

        $this->request->setMethod('POST')
            ->setPost(array(
            'email'             => 'araminu2001@yahoo.com',
            'password'          => 'macara0&',
        ));

        $url = '/bibliothouris/members/process-login';
        $this->dispatch($url);

        $email      = $this->getRequest()->getParam('email', null);
        $password   = $this->getRequest()->getParam('password', null);

        $this->assertNotNull($email);
        $this->assertNotNull($password);

        $membersMapper = new Bibliothouris_Model_MembersMapper();
        $isValidUser   = $membersMapper->fetchUserData($email, $password);

        $session       = new Zend_Session_Namespace('identity');

        $session->userData = $isValidUser[0];
        $this->assertArrayHasKey('id', $session->userData);

        $this->assertRedirect('bibliothouris/courses/list');

    }

    public function testSessionClearOnLogout() {
        $url = '/bibliothouris/members/process-logout';
        $this->dispatch($url);

        $session       = new Zend_Session_Namespace('identity');

        unset($session->userData);
        $this->assertFalse(isset($session->userData));
        $this->assertRedirect('bibliothouris/courses/list');
    }
}



