<?php

class Bibliothouris_Model_CoursesFeedbackMapper extends Bibliothouris_Model_AbstractMapper {

    public function getDbTable() {
        if(null === $this->_dbTable) {
            $this->setDbTable('Bibliothouris_Model_DbTable_CoursesFeedback');
        }
        return $this->_dbTable;
    }

    public function toArray($model) {
        if(!$model instanceof Bibliothouris_Model_CoursesFeedback) {
            throw new Zend_Exception("Invalid parameter model");
        }

        $result = array(
            'id' => $model->getId(),
            'course_id' => $model->getCourseId(),
            'member_id' => $model->getMemberId(),
            'score_trainer' => $model->getScoreTrainer(),
            'score_location_infrastructure' => $model->getScoreLocationInfrastructure(),
            'score_documentation' => $model->getScoreDocumentation(),
            'score_recommend' => $model->getScoreRecommend(),
            'score_content' => $model->getScoreContent(),
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
            throw new Zend_Exception("Course Feedback does not exist for id {$id}");
        }

        $row = $result->current();
        $model = new Bibliothouris_Model_CoursesFeedback();

        $this->loadModel($row, $model);

        if(!$model instanceof  Bibliothouris_Model_CoursesFeedback) {
            throw new Zend_Exception("Invalid Model");
        }
        return $model;
    }

    public function loadModel($data, &$entry = null) {

        if(!is_array($data) && !$data instanceof Zend_Db_Table_Row_Abstract && !$data instanceof stdClass) {
            throw new Zend_Exception("Invalid parameter data");
        }
        if(null !== $entry &&  !$entry instanceof Bibliothouris_Model_CoursesFeedback) {
            throw new Zend_Exception("Invalid parameter entry");
        }

        if ($data instanceof Zend_Db_Table_Row_Abstract) {
            $data = $data->toArray();
        }
        if ($entry === null) {
            $entry = new Bibliothouris_Model_CoursesFeedback();
        }

        $entry->setId($data['id'])
            ->setCourseId($data['course_id'])
            ->setMemberId($data['member_id'])
            ->setScoreTrainer($data['score_trainer'])
            ->setScoreLocationInfrastructure($data['score_location_infrastructure'])
            ->setScoreDocumentation($data['score_documentation'])
            ->setScoreRecommend($data['score_recommend'])
            ->setScoreContent($data['score_content'])
            ->setStatus($data['status'])
            ->setCreated($data['created'])
            ->setModified($data['modified']);

        return $entry;
    }
}