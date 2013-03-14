<?php

class Bibliothouris_Model_Members extends Bibliothouris_Model_AbstractModel {

    protected $_id;
    protected $_fname;
    protected $_lname;
    protected $_email;
    protected $_password;
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

    public function setFname($data) {
        $this->_fname = $data;
        return $this;
    }

    public function getFname() {
        return $this->_fname;

    }

    public function setLname($data) {
        $this->_lname = $data;
        return $this;
    }

    public function getLname() {
        return $this->_lname;

    }

    public function setEmail($data) {
        $this->_email = $data;
        return $this;
    }

    public function getEmail() {
        return $this->_email;

    }

    public function setPassword($data) {
        $this->_password = $data;
        return $this;
    }

    public function getPassword() {
        return $this->_password;

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
            $this->setMapper(new Bibliothouris_Model_MembersMapper());
        }
        return $this->_mapper;
    }
}
