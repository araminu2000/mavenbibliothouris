<?php

class Bibliothouris_Model_EnrollmentsMapper extends Bibliothouris_Model_AbstractMapper {

    public function getDbTable() {
        if(null === $this->_dbTable) {
            $this->setDbTable('Bibliothouris_Model_DbTable_Enrollments');
        }
        return $this->_dbTable;
    }

    public function toArray($model) {
        if(!$model instanceof Bibliothouris_Model_Enrollments) {
            throw new Zend_Exception("Invalid parameter model");
        }

        $result = array(
            'id' => $model->getId(),
            'member_id' => $model->getMemberId(),
            'course_id' => $model->getCourseId()
        );

        return $result;
    }

    public function find($id) {
        if(!is_numeric($id)) {
            throw new Zend_Exception('Id is not set');
        }

        $result = $this->getDbTable()->find($id);
        if(0 == count($result)) {
            return array();
        }

        $row = $result->current();
        $model = new Bibliothouris_Model_Enrollments();

        $this->loadModel($row, $model);

        if(!$model instanceof  Bibliothouris_Model_Enrollments) {
            throw new Zend_Exception("Invalid Model");
        }
        return $model;
    }

    public function isEnrolled($mid, $cid) {

        if(!is_numeric($mid)) {
            throw new Zend_Exception('Member Id is not set');
        }

        if(!is_numeric($cid)) {
            throw new Zend_Exception('Course Id is not set');
        }

        $result = $this->getDbTable()->countByQuery(' member_id = ' . $mid . ' AND course_id = ' . $cid);

        return $result;
    }

    public function loadModel($data, &$entry = null) {

        if(!is_array($data) && !$data instanceof Zend_Db_Table_Row_Abstract && !$data instanceof stdClass) {
            throw new Zend_Exception("Invalid parameter data");
        }
        if(null !== $entry &&  !$entry instanceof Bibliothouris_Model_Enrollments) {
            throw new Zend_Exception("Invalid parameter entry");
        }

        if ($data instanceof Zend_Db_Table_Row_Abstract) {
            $data = $data->toArray();
        }
        if ($entry === null) {
            $entry = new Bibliothouris_Model_Enrollments();
        }

        $entry->setMemberId($data['member_id'])
            ->setCourseId($data['course_id']);

        return $entry;
    }
}