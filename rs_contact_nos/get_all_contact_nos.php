<?php
include '../conf/zend_smarty_conf.php';


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;



if($_SESSION['admin_id']==""){
	die('Session expires.');
}


	
//$sql = "select * from rs_contact_nos where site='".$_POST['site']."'";
$sql = "select * from rs_contact_nos where active='yes';";
$contact_nos = $db->fetchAll($sql);	



$smarty->assign('contact_nos', $contact_nos);
$smarty->display('get_all_contact_nos.tpl');
?>