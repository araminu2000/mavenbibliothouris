<?php

class Bibliothouris_Model_DbTable_Enrollments extends Bibliothouris_Model_DbTable_AbstractTable {

    protected $_name     = 'enrollments';
    protected $_id       = 'record_id';
    protected $_sequence = true;

    protected function _setupDatabaseAdapter() {
        $this->_db = Zend_Registry::get('dbBibliothouris');
    }
}