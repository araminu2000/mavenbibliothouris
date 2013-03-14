<?php

$rootDir = dirname(dirname(__FILE__));

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', $rootDir . DIRECTORY_SEPARATOR . 'application');
}
if (!defined('LIB_PATH')) {
    define('LIB_PATH', $rootDir . DIRECTORY_SEPARATOR . 'library');
}
if (!defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', 'development');
}
if (!defined('APP_RESOURCE')) {
    define('APP_RESOURCE', $rootDir . DIRECTORY_SEPARATOR . 'resource');
}
if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', dirname(__FILE__));
}

set_include_path(implode(PATH_SEPARATOR, array(realpath(LIB_PATH), get_include_path())));

date_default_timezone_set('Europe/Bucharest');

require_once 'Zend/Console/Getopt.php';

$getopt = new Zend_Console_Getopt(array(
    'action|a=s' => 'action to perform in format of "module/controller/action/param1/param2/param3/.."',
    'env|e-s' => 'defines application environment (defaults to "production")',
    'help|h' => 'displays usage information',
));

try {
    $getopt->parse();
} catch (Zend_Console_Getopt_Exception $e) {
    echo $e->getUsageMessage();
    return false;
}

if ($getopt->getOption('h') || !$getopt->getOption('a')) {
    echo $getopt->getUsageMessage();
    return true;
}

$env = $getopt->getOption('e');
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (null === $env) ? 'production' : $env);

require_once 'Zend/Config/Ini.php';
$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
if(!is_null($config->constants)) {
    foreach ($config->constants as $key => $value) {
        defined($key) || define($key, $value);
    }
}

require_once 'Zend/Application.php';
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');

$application->bootstrap();

$front = $application->getBootstrap()
    ->bootstrap('frontController')
    ->getResource('frontController');

$params = explode('/', $getopt->getOption('a'));

$module = array_shift($params);
$controller = array_shift($params);
$action = array_shift($params);

$request = new Zend_Controller_Request_Simple($action, $controller, $module);

$front->setRouter(new Zend_Controller_Router_Cli())
    ->setRequest($request)
    ->setResponse(new Zend_Controller_Response_Cli())
    ->throwExceptions(true);

$application->run();
