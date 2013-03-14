<?php

abstract class Bibliothouris_Model_AbstractMapper {

    protected $_dbTable;

    public function __construct() {
    }

      public function setDbTable($dbTable) {

        if(is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if(!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Zend_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

      public function getAdapter() {
        return $this->getDbTable()->getAdapter();
    }

    public abstract function getDbTable();
    public abstract function toArray($model);
    protected abstract function loadModel($data, &$entry = null);
    public abstract function find($primaryKey);

    public function countAllRows() {
        return $this->getDbTable()->countAllRows();
    }

    public function countByQuery($where = '') {
        return $this->getDbTable()->countByQuery($where);
    }

    public function paginate(Zend_Db_Select $select, $rowCount = 50, $page = 0) {
        if(!is_numeric($rowCount)) {
            throw new Zend_Exception("invalid parameter rowCount");
        }
        if(!is_numeric($page)) {
            throw new Zend_Exception("invalid parameter page");
        }

        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage($rowCount);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange($rowCount);

        return $paginator;
    }

    public function fetchSelect(Zend_Db_Select $select) {
        $rows = $this->getAdapter()->fetchAll($select);
        return $rows;
    }

    public function fetchAll(array $array = null) {

        $primaryKey = $this->getDbTable()->getPrimaryKeyName();

        $where = "TRUE";
        if(!empty($array)) {
            foreach ($array as $column => $value) {
                if($value !== null) {
                    $where .= " AND {$column} = '{$value}'";
                } else {
                    $where .= " AND {$column} IS NULL";
                }
            }
        }

        $resultSet = $this->getDbTable()->fetchAll($where);
        $modelClass = str_replace('Mapper', '', get_class($this));
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new $modelClass();
            $this->loadModel($row, $entry);
            $entries[$entry->$primaryKey] = $entry;
            unset($row);
            unset($entry);
        }
        return $entries;
    }
}
