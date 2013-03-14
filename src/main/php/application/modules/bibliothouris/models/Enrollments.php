<?php

class Bibliothouris_Model_Enrollments extends Bibliothouris_Model_AbstractModel {

    protected $_recordId;
    protected $_courseId;
    protected $_memberId;

    public function __construct(array $options = null) {
        $this->setColumnsList();
        parent::init($options);
    }

    public function setId($data) {
        $this->_recordId = $data;
        return $this;
    }

    public function getId() {
        return $this->_recordId;

    }

    public function setMemberId($data) {
        $this->_memberId = $data;
        return $this;
    }

    public function getMemberId() {
        return $this->_memberId;

    }

    public function setCourseId($data) {
        $this->_courseId = $data;
        return $this;
    }

    public function getCourseId() {
        return $this->_courseId;

    }

    public function getMapper() {
        if($this->_mapper === null) {
            $this->setMapper(new Bibliothouris_Model_EnrollmentsMapper());
        }
        return $this->_mapper;
    }
}
