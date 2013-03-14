<?php

abstract class Bibliothouris_Model_DbTable_AbstractTable extends Zend_Db_Table_Abstract {

    protected $_name;
    protected $_id;

    public function getPrimaryKeyName() {
        return $this->_id;
    }

    public function getTableName() {
        return $this->_name;
    }

    public function countAllRows() {
        $query = $this->select()->from($this->_name, 'count(*) AS all_count');
        $numRows = $this->fetchRow($query);

        return $numRows['all_count'];
    }

    public function countByQuery($where = '') {
        $query = $this->select()->from($this->_name, 'count(*) AS all_count');

        if (! empty($where)) {
            $query->where($where);
        }

        $row = $this->getAdapter()->query($query)->fetch();

        return $row['all_count'];
    }
}