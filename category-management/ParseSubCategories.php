<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

if($_SESSION['admin_id']=="" or $_SESSION['admin_id']==NULL){
	die('Invalid ID for Admin. Session Expires');
}


$jr_cat_id = $_REQUEST['jr_cat_id'];
if(!$jr_cat_id){
	die("Category ID is missing.");
}

$query = $db->select()
	->from('job_category')
	->where('job_role_category_id =?' , $jr_cat_id)
	->where('status != ?','removed');
$sub_cats = $db->fetchAll($query);



$smarty->assign('jr_cat_id', $jr_cat_id);
$smarty->assign('sub_cats', $sub_cats);



header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=utf-8');
$smarty->display('ParseSubCategories.tpl');

?>

