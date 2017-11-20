<?php
include '../../conf/zend_smarty_conf.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');

$smarty = new Smarty;
$smarty->template_dir = dirname(__FILE__)."/../templates";
$smarty->compile_dir = dirname(__FILE__)."/../templates_c";



if($_SESSION['admin_id']){
	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$_SESSION['admin_id']);
	$admin = $db->fetchRow($sql);
}else{
    header("location:/portal/");
    exit;
}


//echo date('Y-m-t');

//http://test.api.remotestaff.com.au/collections/get/?date_from=2014-02-01&date_to=2014-12-30

$API_URL = "//staging.api.remotestaff.com.au";
if(TEST){
	$API_URL = "//test.api.remotestaff.com.au";
}

$smarty->assign('API_URL' , $API_URL);
$smarty->assign('start_date' , date('Y-m-01'));
$smarty->assign('end_date' , date('Y-m-t'));
$smarty->assign('admin' , $admin);
$smarty->display('index.tpl');
?>