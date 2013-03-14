<?php

class Bibliothouris_Model_DbTable_Members extends Bibliothouris_Model_DbTable_AbstractTable {

    protected $_name = 'members';
    protected $_id = 'id';
    protected $_sequence = true;

    protected function _setupDatabaseAdapter() {
        $this->_db = Zend_Registry::get('dbBibliothouris');
    }
}
