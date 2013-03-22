<?php

class Bibliothouris_Model_CoursesFeedbackMail extends Bibliothouris_Model_AbstractModel {

    protected $_id;
    protected $_courseId;
    protected $_memberId;
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

    public function setStatus($data = null) {
        $data = (is_null($data)) ? 0 : $data;
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
            $this->setMapper(new Bibliothouris_Model_CoursesFeedbackMailMapper());
        }
        return $this->_mapper;
    }
}
