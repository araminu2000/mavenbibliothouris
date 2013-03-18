<?php

class Bibliothouris_MembersModelsTest extends PHPUnit_Framework_TestCase {

    protected $_model;

    public function setUp() {

        $this->_model = new Bibliothouris_Model_DbTable_Members();
    }

    public function testFindByPKWithDbTable() {
        $createResult = $this->_model->find(1);
        $this->assertInstanceOf('Zend_Db_Table_Rowset', $createResult);
        $this->assertNotNull($createResult->toArray());
    }

    public function testFindByPKWithMapper() {

        $mapper  =  new Bibliothouris_Model_MembersMapper();
        $results =  $mapper->find(11);

        $this->assertInstanceOf('Bibliothouris_Model_Members', $results);
        $this->assertInstanceOf('Bibliothouris_Model_MembersMapper', $results->getMapper());

        $this->assertTrue(method_exists($results, 'getId'));
        $this->assertTrue(method_exists($results, 'getCreated'));
        $this->assertTrue(method_exists($results, 'getEmail'));
        $this->assertTrue(method_exists($results, 'getFname'));
        $this->assertTrue(method_exists($results, 'getLname'));
        $this->assertTrue(method_exists($results, 'getModified'));
        $this->assertTrue(method_exists($results, 'getPassword'));
        $this->assertTrue(method_exists($results, 'getStatus'));

    }

}