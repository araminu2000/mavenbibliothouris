<?php

class Bibliothouris_Model_Courses extends Bibliothouris_Model_AbstractModel {

    protected $_id;
    protected $_title;
    protected $_dateStart;
    protected $_dateEnd;
    protected $_trainerName;
    protected $_content;
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

    public function setTitle($data) {
        $this->_title = $data;
        return $this;
    }

    public function getTitle() {
        return $this->_title;

    }

    public function setDateStart($data) {
        $this->_dateStart = $data;
        return $this;
    }

    public function getDateStart() {
        return $this->_dateStart;

    }

    public function setDateEnd($data) {
        $this->_dateEnd = $data;
        return $this;
    }

    public function getDateEnd() {
        return $this->_dateEnd;

    }

    public function setTrainerName($data) {
        $this->_trainerName = $data;
        return $this;
    }

    public function getTrainerName() {
        return $this->_trainerName;

    }

    public function setContent($data) {
        $this->_content = $data;
        return $this;
    }

    public function getContent() {
        return $this->_content;

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
            $this->setMapper(new Bibliothouris_Model_CoursesMapper());
        }
        return $this->_mapper;
    }
}
