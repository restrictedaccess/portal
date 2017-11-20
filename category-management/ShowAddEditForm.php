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





$category_id = $_REQUEST['category_id'];
$mode = $_REQUEST['mode'];
$jr_cat_id = $_REQUEST['jr_cat_id'];

if($mode == "update"){
	if($category_id > 0){
		$query = $db->select()
			->from('job_category')
			->where('category_id =?' , $category_id);
		$category = $db->fetchRow($query);
		//category_id, job_role_category_id, status, category_name, created_by, category_date_created
		$smarty->assign('category', $category);
		
		
		$sql = $db->select()
			->from('job_role_category');
		$categories = $db->fetchAll($sql);	
		foreach($categories as $categories){
			if($category['job_role_category_id'] == $categories['jr_cat_id']){
				$category_Options .="<option value='".$categories['jr_cat_id']."' selected >".$categories['cat_name']."</option>";
			}else{
				$category_Options .="<option value='".$categories['jr_cat_id']."'>".$categories['cat_name']."</option>";
			}
		}
		
		$smarty->assign('category_Options', $category_Options);

	}
}


$smarty->assign('jr_cat_id', $jr_cat_id);
$smarty->assign('category_id', $category_id);
$smarty->assign('mode', $mode);



header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=utf-8');
$smarty->display('ShowAddEditForm.tpl');
?>
