<?php

class Bibliothouris_EnrollmentsModelsTest extends Zend_Test_PHPUnit_ControllerTestCase {

    protected $_model;

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->_model = new Bibliothouris_Model_DbTable_Enrollments();
    }

    public function testFindByPKWithDbTable() {
        $createResult = $this->_model->find(1);
        $this->assertInstanceOf('Zend_Db_Table_Rowset', $createResult);
        $this->assertNotNull($createResult->toArray());
    }

    public function testFindByPKWithMapper() {

        $mapper  =  new Bibliothouris_Model_EnrollmentsMapper();
        $results =  $mapper->find(1);

        $this->assertInstanceOf('Bibliothouris_Model_Enrollments', $results);
        $this->assertInstanceOf('Bibliothouris_Model_EnrollmentsMapper', $results->getMapper());

        $this->assertTrue(method_exists($results, 'getId'));
        $this->assertTrue(method_exists($results, 'getCourseId'));
        $this->assertTrue(method_exists($results, 'getMemberId'));

    }

}