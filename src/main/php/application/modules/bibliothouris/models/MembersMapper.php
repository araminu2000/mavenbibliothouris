<?php

class Bibliothouris_Model_MembersMapper extends Bibliothouris_Model_AbstractMapper {

    public function getDbTable() {
        if(null === $this->_dbTable) {
            $this->setDbTable('Bibliothouris_Model_DbTable_Members');
        }
        return $this->_dbTable;
    }

    public function toArray($model) {
        if(!$model instanceof Bibliothouris_Model_Members) {
            throw new Zend_Exception("Invalid parameter model");
        }

        $result = array(
            'id' => $model->getId(),
            'fname' => $model->getFname(),
            'lname' => $model->getLname(),
            'email' => $model->getEmail(),
            'password' => $model->getPassword(),
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
            return array();
        }

        $row = $result->current();
        $model = new Bibliothouris_Model_Members();

        $this->loadModel($row, $model);

        if(!$model instanceof  Bibliothouris_Model_Members) {
            throw new Zend_Exception("Invalid Model");
        }
        return $model;
    }

    public function fetchUserData($email, $password) {
        $count = $this->getDbTable()->countByQuery("email = '{$email}' AND password = '" . md5($password) . "'");

        if ($count > 0) {
            $select = $this->getAdapter()->select()
                    ->from('members', array('id', 'fname', 'lname', 'email', 'created', 'modified'))
                    ->where('email = ?' , $email)
                    ->where('password = ?', md5($password));

            $results = $this->getAdapter()->fetchAll($select);

            return $results;
        }

        return false;
    }

    public function loadModel($data, &$entry = null) {

        if(!is_array($data) && !$data instanceof Zend_Db_Table_Row_Abstract && !$data instanceof stdClass) {
            throw new Zend_Exception("Invalid parameter data");
        }
        if(null !== $entry &&  !$entry instanceof Bibliothouris_Model_Members) {
            throw new Zend_Exception("Invalid parameter entry");
        }

        if ($data instanceof Zend_Db_Table_Row_Abstract) {
            $data = $data->toArray();
        }
        if ($entry === null) {
            $entry = new Bibliothouris_Model_Members();
        }

        $entry->setId($data['id'])
            ->setFname($data['fname'])
            ->setLname($data['lname'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setStatus($data['status'])
            ->setCreated($data['created'])
            ->setModified($data['modified']);

        return $entry;
    }
}