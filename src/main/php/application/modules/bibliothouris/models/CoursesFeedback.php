<?php

class Bibliothouris_Model_CoursesFeedback extends Bibliothouris_Model_AbstractModel {

    protected $_id;
    protected $_courseId;
    protected $_memberId;
    protected $_scoreTrainer;
    protected $_scoreLocationInfrastructure;
    protected $_scoreDocumentation;
    protected $_scoreRecommend;
    protected $_scoreContent;
    protected $_status;
    protected $_created;
    protected $_modified;

    public function __construct(array $options = null) {
        $this->setColumnsList();
        parent::init($options);
    }

    public function setId($data) {
        $this->_id = $data;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setCourseId($data) {
        $this->_courseId = $data;
        return $this;
    }

    public function getCourseId() {
        return $this->_courseId;
    }

    public function setMemberId($data) {
        $this->_memberId = $data;
        return $this;
    }

    public function getMemberId() {
        return $this->_memberId;
    }

    public function setScoreTrainer($data) {
        $this->_scoreTrainer = $data;
        return $this;
    }

    public function getScoreTrainer() {
        return $this->_scoreTrainer;
    }

    public function setScoreLocationInfrastructure($data) {
        $this->_scoreLocationInfrastructure = $data;
        return $this;
    }

    public function getScoreLocationInfrastructure() {
        return $this->_scoreLocationInfrastructure;
    }

    public function setScoreDocumentation($data) {
        $this->_scoreDocumentation = $data;
        return $this;
    }

    public function getScoreDocumentation() {
        return $this->_scoreDocumentation;
    }

    public function setScoreRecommend($data) {
        $this->_scoreRecommend = $data;
        return $this;
    }

    public function getScoreRecommend() {
        return $this->_scoreRecommend;
    }

    public function setScoreContent($data) {
        $this->_scoreContent = $data;
        return $this;
    }

    public function getScoreContent() {
        return $this->_scoreContent;

    }

    public function setStatus($data = null) {
        $data = (is_null($data)) ? 1 : $data;
        $this->_status = $data;
        return $this;
    }

    public function getStatus() {
        return $this->_status;

    }

    public function setCreated($data = null) {
        $data = (empty($data)) ? date('Y-m-d H:i:s') : $data;
        $this->_created = $data;
        return $this;
    }

    public function getCreated() {
        return $this->_created;

    }

    public function setModified($data = null) {
        $data = (empty($data)) ? date('Y-m-d H:i:s') : $data;
        $this->_modified = $data;
        return $this;
    }

    public function getModified() {
        return $this->_modified;

    }


    public function getMapper() {
        if($this->_mapper === null) {
            $this->setMapper(new Bibliothouris_Model_CoursesFeedbackMapper());
        }
        return $this->_mapper;
    }
}
