<?php

class Bibliothouris_Model_CoursesMapper extends Bibliothouris_Model_AbstractMapper {

    public function getDbTable() {
        if(null === $this->_dbTable) {
            $this->setDbTable('Bibliothouris_Model_DbTable_Courses');
        }
        return $this->_dbTable;
    }

    public function toArray($model) {
        if(!$model instanceof Bibliothouris_Model_Courses) {
            throw new Zend_Exception("Invalid parameter model");
        }

        $result = array(
            'id' => $model->getId(),
            'title' => $model->getTitle(),
            'date_start' => $model->getDateStart(),
            'date_end' => $model->getDateEnd(),
            'trainer_name' => $model->getTrainerName(),
            'content' => $model->getContent(),
            'status' => $model->getStatus(),
            'created' => $model->getCreated(),
            'modified' => $model->getModified(),
        );

        return $result;
    }

    public function find($id) {
        if(!is_numeric($id)) {
            throw new Zend_Exception('Id is not set');
        }

        $result = $this->getDbTable()->find($id);
        if(0 == count($result)) {
            throw new Zend_Exception("Course does not exist for id {$id}");
        }

        $row = $result->current();
        $model = new Bibliothouris_Model_Courses();

        $this->loadModel($row, $model);

        if(!$model instanceof  Bibliothouris_Model_Courses) {
            throw new Zend_Exception("Invalid Model");
        }
        return $model;
    }

    public function courseStarted($id) {

        $results = $this->getDbTable()->fetchSelect();
    }

    public function loadModel($data, &$entry = null) {

        if(!is_array($data) && !$data instanceof Zend_Db_Table_Row_Abstract && !$data instanceof stdClass) {
            throw new Zend_Exception("Invalid parameter data");
        }
        if(null !== $entry &&  !$entry instanceof Bibliothouris_Model_Courses) {
            throw new Zend_Exception("Invalid parameter entry");
        }

        if ($data instanceof Zend_Db_Table_Row_Abstract) {
            $data = $data->toArray();
        }
        if ($entry === null) {
            $entry = new Bibliothouris_Model_Courses();
        }

        $entry->setId($data['id'])
            ->setTitle($data['title'])
            ->setDateStart($data['date_start'])
            ->setDateEnd($data['date_end'])
            ->setTrainerName($data['trainer_name'])
            ->setContent($data['content'])
            ->setStatus($data['status'])
            ->setCreated($data['created'])
            ->setModified($data['modified']);

        return $entry;
    }
}