<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();
/*	
//get all currencies
$sql = $db->select()
	->from('currency_lookup','code');
	//->group('jr_currency')
	//->where('jr_status = ?' , 'system' );
$currencies = $db->fetchAll($sql);
*/

// get different categories
//SELECT * FROM job_role_category j;
//jr_cat_id, cat_name


$sql = $db->select()
	->from('job_role_category');
$categories = $db->fetchAll($sql);

foreach($categories as $category){
	$CategoryOptions .="<option value=".$category['jr_cat_id'].">".$category['cat_name']."</option>";
}



$smarty->assign('CategoryOptions',$CategoryOptions);
//$smarty->assign('currencies',$currencies);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('showAddJobTitleForm.tpl');

?>