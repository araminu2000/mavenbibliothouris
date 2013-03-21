<?php
class Bibliothouris_CoursesFeedbackModelsTest extends Zend_Test_PHPUnit_ControllerTestCase {

    protected $_model;

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->_model = new Bibliothouris_Model_DbTable_CoursesFeedback();
    }

    public function testFindByPKWithDbTable()
    {
        $createResult = $this->_model->find(1);
        $this->assertInstanceOf('Zend_Db_Table_Rowset', $createResult);
        $this->assertNotNull($createResult->toArray());
    }

    public function testFindByPKWithMapper()
    {

        $mapper  =  new Bibliothouris_Model_CoursesFeedbackMapper();
        $results =  $mapper->find(1);

        $this->assertInstanceOf('Bibliothouris_Model_CoursesFeedback', $results);
        $this->assertInstanceOf('Bibliothouris_Model_CoursesFeedbackMapper', $results->getMapper());

        $this->assertTrue(method_exists($results, 'getId'));
        $this->assertTrue(method_exists($results, 'getCourseId'));
        $this->assertTrue(method_exists($results, 'getMemberId'));
        $this->assertTrue(method_exists($results, 'getScoreTrainer'));
        $this->assertTrue(method_exists($results, 'getScoreLocationInfrastructure'));
        $this->assertTrue(method_exists($results, 'getScoreDocumentation'));
        $this->assertTrue(method_exists($results, 'getScoreRecommend'));
        $this->assertTrue(method_exists($results, 'getScoreContent'));
        $this->assertTrue(method_exists($results, 'getStatus'));
        $this->assertTrue(method_exists($results, 'getCreated'));
        $this->assertTrue(method_exists($results, 'getModified'));
        $this->assertTrue(method_exists($results, 'getMapper'));

    }

}