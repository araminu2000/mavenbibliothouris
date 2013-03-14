<?php

class ErrLib_Controller_Plugin_OverideErrorModule extends Zend_Controller_Plugin_Abstract {
        public function preDispatch(Zend_Controller_Request_Abstract $request) {
            $module = $request->getModuleName();
            if (file_exists(APPLICATION_PATH . "/modules/{$module}/controllers/ErrorController.php")) {
                $errorHandler = Zend_Controller_Front::getInstance()
                            ->getPlugin('Zend_Controller_Plugin_ErrorHandler');
                $errorHandler->setErrorHandlerModule($module);
            }
        }
}