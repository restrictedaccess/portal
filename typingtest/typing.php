<?php
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', TRUE);
include '../conf/zend_smarty_conf.php';
ini_set("include_path",  implode(';', array(get_include_path(), '.')) );
include_once('../ticketmgmt/lib/View.php');
include_once('../ticketmgmt/lib/Input.php');
//include_once('skills_test_class.php');
//skills_test::$dbase = $db;
//Config::$db_conf = $db;

//$admin_id = $_SESSION['admin_id'];


if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
	exit;
}

//$userid = $_SESSION['userid'];

//$emailaddr = $_SESSION['emailaddr'];

class ClassNotFoundException extends Exception{}

try{
	$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
		//echo $_SERVER['REQUEST_URI'];
    array_shift($url);
		
    // get controller name
    $controller = !empty($url[1]) ? ucfirst(strstr($url[1], '.', TRUE)) . 'Controller' : 'DefaultController';

    $method = !empty($url[2]) ? $url[2] : 'index';
	
    // get argument passed in to the method
    $arg = !empty($url[3]) ? $url[3] : NULL;


	$controller::$dbase = $db;
	
	$cont = new $controller(2);
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