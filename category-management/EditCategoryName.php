<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="" or $_SESSION['admin_id']==NULL){
	die('Invalid ID for Admin. Session Expires');
}


$jr_cat_id = $_REQUEST['jr_cat_id'];

$sql = $db->select()
	->from('job_role_category')
	->where('jr_cat_id =?',$jr_cat_id);
$category = $db->fetchRow($sql);	

$smarty->assign('category', $category);
$smarty->assign('jr_cat_id', $jr_cat_id);



header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=utf-8');
$smarty->display('EditCategoryName.tpl');


?>