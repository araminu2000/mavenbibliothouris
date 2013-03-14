<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoloader() {
        Zend_Loader_Autoloader::getInstance()->registerNamespace('ErrLib');

    }

	protected function _initFront() {
        $this->_frontController = Zend_Controller_Front::getInstance();
        $this->_frontController->registerPlugin(new ErrLib_Controller_Plugin_OverideErrorModule());
    }

    protected function _initDbAdapters() {

        $this->bootstrap('multidb');
        $adapters=$this->getPluginResource('multidb');
        Zend_Registry::set('db_adapters', $adapters);

        $dbBibliothouris=$adapters->getDb('bibliothouris');
        $dbBibliothouris->query("SET NAMES utf8");
        Zend_Registry::set('dbBibliothouris', $dbBibliothouris);

        Zend_Db_Table_Abstract::setDefaultAdapter($dbBibliothouris);
    }

	protected function _initPlaceholders() {

        $this->bootstrap('layout');

        $layout =   $this->getResource('layout');
        $view   =   $layout->getView();

        $view->strictVars();

        // Main Application CSS
        $view->headLink()->appendStylesheet('/common/css/app.css');

        // jquery UI CSS
        $view->headLink()->appendStylesheet('/common/jquery-ui/css/custom-theme/jquery-ui-1.10.1.custom.css');

        // jquery / jquery UI
        $view->headScript()->appendFile('/common/jquery-ui/js/jquery-1.9.1.js');
        $view->headScript()->appendFile('/common/jquery-ui/js/jquery-ui-1.10.1.custom.min.js');

        // datatable CSS
        $view->headLink()->appendStylesheet('/common/datatable/media/css/jquery.dataTables.css');
        $view->headLink()->appendStylesheet('/common/datatable/media/css/jquery.dataTables_themeroller.css');

        // datatable JS
        $view->headScript()->appendFile('/common/datatable/media/js/jquery.dataTables.js');

        // application JS
        $view->headScript()->appendFile('/common/js/app.js');

        $view->headTitle()->setSeparator(' - ');

        /*
        // QUnit CSS
        $view->headLink()->appendStylesheet('/common/qunit/qunit.css');
        if("development" == APPLICATION_ENV) {

            // Qunit JS
            $view->headScript()->appendFile('/common/qunit/qunit.js');

            // Qunit JS Tests File
            $oRequest   = new Zend_Controller_Request_Http();
            $jsTestFile = '/common/jstests/' . str_replace("/", "-", trim($oRequest->getRequestUri(), '/')) . '.js';

            if (file_exists(APPLICATION_PATH . '../../public' . $jsTestFile)) {
                $view->headScript()->appendFile($jsTestFile);
            }

            $view->headScript()->appendFile('/common/jstests/global-tests.js');

        }
        */
    }
}

