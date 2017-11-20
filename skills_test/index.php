<?php
/*error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);*/
ini_set("default_socket_timeout", 120);
include '../conf/zend_smarty_conf.php';
ini_set("include_path",  implode(':', array(get_include_path(), './models')) );

include_once('../ticketmgmt/lib/View.php');
include_once('../ticketmgmt/lib/Input.php');
include_once('../ticketmgmt/lib/Utils.php');
include_once('../lib/users_class.php');

Users::$dbase = $db;
$test_script = '/portal/skills_test/index.php';
class ClassNotFoundException extends Exception{}

try{
	$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    array_shift($url);
    
	$url[1] = '';
    
    // get controller name
    $controller = !empty($url[1]) ? ucfirst(strstr($url[1], '.', TRUE)) . 'Controller' : 'TestController';

	$method = !empty($url[2]) ? $url[2] : 'index';
	
	$login = $_SESSION['userid'] ? 'jobseeker' : ( $_SESSION['admin_id'] ? 'admin' :( $_SESSION['client_id'] ? 'client' : '' ) );
	$required_login_methods = array('request_session', 'request_result');
	
	//if( !in_array($method, $exception_methods) ) {
	if( in_array($method, $required_login_methods) ) {
		if( !$login ) {
			header("location: {$test_script}?/login_form");
			exit();
		}
	} elseif( $method == "index" ) {
		if( !$login ) {
			header("location: {$test_script}?/login_form");
			exit();
		} elseif( $login == "admin" ) {
			header("location: {$test_script}?/reports");
			exit();
		}
		
	} elseif( in_array($method, array('reports','request_assessment_list','get_staging_reports')) && $login != "admin" ) {
		header("location: /portal/index.php");
		exit();
	}	
	
    // get argument passed in to the method
	$arg = !empty($url[3]) ? $url[3] : NULL;

	$controller::$dbase = $db;
	$controller::$login_type = $login;

	$cont = new $controller;

	if( method_exists($cont, $method) ){
		
		$cont->$method($arg);;
	}
		
		
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