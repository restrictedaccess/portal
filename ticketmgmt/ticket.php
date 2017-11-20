<?php
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', TRUE);
include '../conf/zend_smarty_conf.php';
ini_set("include_path",  implode(':', array(get_include_path(), './lib', './models')) );
//include_once('./lib/Config.php');
Config::$db_conf = $db;

class ClassNotFoundException extends Exception{}

// handle request and dispatch it to the appropriate controller
try{
	Dispatcher::dispatch();
}
// catch exceptions
catch (ClassNotFoundException $e){
	echo $e->getMessage();
	exit();
}
catch (Exception $e){
	echo $e->getMessage();
	exit();
}// End front controller