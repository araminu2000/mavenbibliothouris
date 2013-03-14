<?php

class Bibliothouris_Model_DbTable_Courses extends Bibliothouris_Model_DbTable_AbstractTable {

    protected $_name = 'courses';
    protected $_id = 'id';
    protected $_sequence = true;

    protected function _setupDatabaseAdapter() {
        $this->_db = Zend_Registry::get('dbBibliothouris');
    }
}
