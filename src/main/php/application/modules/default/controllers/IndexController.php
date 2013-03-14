<?php
class IndexController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->setLayout('layout');
    }

    public function preDispatch() {

    }

    public function indexAction() {
        $this->_redirect('bibliothouris/courses/index');
    }

    public function postDispatch() {

    }
}
