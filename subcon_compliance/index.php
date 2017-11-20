<?php
include '../conf/zend_smarty_conf.php';
ini_set("include_path",  implode(':', array(get_include_path(), './models')) );

include_once('../lib/users_class.php');
include_once('../ticketmgmt/lib/Input.php');
include_once('../payroll/library/ParallelRequest.php');
include_once('checkRsscUser.php');

Zend_Db_Table::setDefaultAdapter($db);

class ClassNotFoundException extends Exception{}

try{
	$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    array_shift($url);

    // controller name
    $controller = !empty($url[1]) && $url[1]!='?' ? ucfirst(strstr($url[1], '.', TRUE)) . 'Controller' : 'IndexController';

    $method = !empty($url[2]) ? $url[2] : 'index';
	
    // argument passed to the method
    $arg = !empty($url[3]) ? $url[3] : NULL;

	//$controller::$db = $db;
	$controller::$couch_dsn = $couch_dsn;

	$cont = $controller::get_instance($db);

	if( method_exists($cont, $method) )
		$cont->$method($arg);
	else throw new ClassNotFoundException('Method ' . $method . ' not found.');
}
// catch exceptions
catch (ClassNotFoundException $e){
	echo $e->getMessage();
	exit();
}
catch (Exception $e){
	echo $e->getMessage();
	exit();
}