<?php
include '../conf/zend_smarty_conf.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	header("location:index.php");
	exit;
}

$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

$smarty->assign('admin' , $admin);
$smarty->display('index.tpl');
?>