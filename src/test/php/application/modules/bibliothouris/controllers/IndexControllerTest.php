<?php

class Bibliothouris_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{


    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $this->assertTrue(true);
    }


}



