<?php

abstract class Bibliothouris_Model_AbstractModel {

    protected $_mapper;
    protected $_columnsList;

    protected function init(array $options = null) {
    	if(is_array($options)) {
    	    $this->getMapper()->loadModel($options, $this);
        }
    }

    public function __construct(array $options = null) {
        $this->init($options);
    }

    public function __set($name, $value) {
        $name = $this->columnNameToVar($name);

        $method = 'set' . ucfirst($name);

        if(('mapper' == $name) || !method_exists($this, $method)) {
            throw new Zend_Exception("name:$name value:$value - Invalid property");
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . ucfirst($name);

        if(('mapper' == $name) || ! method_exists($this, $method)) {
            $name = $this->columnNameToVar($name);
            $method = 'get' . ucfirst($name);
            if(('mapper' == $name) || ! method_exists($this, $method)) {
                    throw new Zend_Exception("name:$name  - Invalid property");
            }
        }

        return $this->$method();
    }

    public function columnNameToVar($column) {
        if(! isset($this->_columnsList[$column])) {
            throw new Zend_Exception("column '$column' not found!");
        }

        return $this->_columnsList[$column];
    }

    public function varNameToColumn($thevar) {
        foreach($this->_columnsList as $column => $var) {
            if($var == $thevar) {
                return $column;
            }
        }

        return null;
    }

    public function setColumnsList(array $data = null) {
        if(is_null($data)) {
            $filterCamelCaseToUnderscore = new Zend_Filter_Word_CamelCaseToUnderscore();
            $filterStringToLower = new Zend_Filter_StringToLower();
            $properties = get_object_vars($this);
            foreach ($properties as $property => $value) {
                if(!in_array($property, array('_mapper', '_columnsList', '_parentList', '_dependentList'))) {
                    $name = preg_replace('/^_/', '', $property);

                    $dbColumn = preg_replace('/^_/', '', $property);
                    $dbColumn = $filterCamelCaseToUnderscore->filter($dbColumn);
                    $dbColumn = $filterStringToLower->filter($dbColumn);

                    $data[$dbColumn] = $name;
                }
            }
        }
        $this->_columnsList = $data;
        return $this;
    }

    public function getColumnsList() {
        return $this->_columnsList;
    }

    public function setMapper($mapper){
        $this->_mapper = $mapper;
        return $this;
    }

    public abstract function getMapper();
}