<?php
class Bibliothouris_IndexController extends Zend_Controller_Action {

    public function init() {
		$this->_helper->layout->setLayout('layout');
		#var_dump(Zend_Version::VERSION);
    }

    public function preDispatch() {

    }

    public function indexAction() {
        $this->_redirect('bibliothouris/courses/index');
    }

    public function postDispatch() {

    }
}
