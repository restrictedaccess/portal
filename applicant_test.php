<?php
include('conf/zend_smarty_conf.php');
/*include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';*/
include('skillstest/skills_test_class.php');

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

skills_test::$dbase = $db;

if( isset($_POST['test_id']) ) $test_id = $_POST['test_id'];
elseif (isset($_GET['test_id'])) $test_id = $_GET['test_id']; else $link = 0;


$test = skills_test::getInstance(); //new skills_test();

if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
	exit;
}

$userid = $_SESSION['userid'];

$emailaddr = $_SESSION['emailaddr'];

//var_dump($test->tests);

$smarty = new Smarty;


$admin_id = $_SESSION['admin_id'];

/*if($admin_id == ''){
	header("location:index.php");
    exit();
}*/

/*$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);*/

if( $test_id ) {
	//print_r($test->test_questions($test_id));
}
else {
	$smarty->assign('test_array', $test->tests);
}
$smarty->assign('userid', $userid);

$smarty->display('applicant_test.tpl');

?>