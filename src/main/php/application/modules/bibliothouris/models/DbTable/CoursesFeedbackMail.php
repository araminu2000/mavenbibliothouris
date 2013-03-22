<?php

class Bibliothouris_Model_DbTable_CoursesFeedbackMail extends Bibliothouris_Model_DbTable_AbstractTable {

    protected $_name = 'courses_feedback_mail';
    protected $_id = 'id';
    protected $_sequence = true;

    protected function _setupDatabaseAdapter() {
        $this->_db = Zend_Registry::get('dbBibliothouris');
    }
}
