<?php

class Bibliothouris_CoursesModelsTest extends Zend_Test_PHPUnit_ControllerTestCase {

    protected $_model;

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->_model = new Bibliothouris_Model_DbTable_Courses();
    }

    public function testFindByPKWithDbTable()
    {
        $createResult = $this->_model->find(1);
        $this->assertInstanceOf('Zend_Db_Table_Rowset', $createResult);
        $this->assertNotNull($createResult->toArray());
    }

    public function testFindByPKWithMapper()
    {

        $mapper  =  new Bibliothouris_Model_CoursesMapper();
        $results =  $mapper->find(1);

        $this->assertInstanceOf('Bibliothouris_Model_Courses', $results);
        $this->assertInstanceOf('Bibliothouris_Model_CoursesMapper', $results->getMapper());

        $this->assertTrue(method_exists($results, 'getId'));
        $this->assertTrue(method_exists($results, 'getCreated'));
        $this->assertTrue(method_exists($results, 'getDateStart'));
        $this->assertTrue(method_exists($results, 'getDateEnd'));
        $this->assertTrue(method_exists($results, 'getStatus'));
        $this->assertTrue(method_exists($results, 'getModified'));
        $this->assertTrue(method_exists($results, 'getTitle'));
        $this->assertTrue(method_exists($results, 'getTrainerName'));
        $this->assertTrue(method_exists($results, 'getContent'));
        $this->assertTrue(method_exists($results, 'getMapper'));

    }

}