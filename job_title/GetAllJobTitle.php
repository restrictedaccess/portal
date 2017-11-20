<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();



//SELECT * FROM job_role_category j;
//jr_cat_id, cat_name
$sql = $db->select()
		->from('job_role_category');
$categories = $db->fetchAll($sql);		

foreach($categories as $category){
	$str.= sprintf("<ul><b>%s</b>",$category['cat_name']);
	
	$jr_cat_id = $category['jr_cat_id'];
	$sql = $db->select()
		->from('job_role_cat_list')
		->group('jr_name')
		->order('jr_name')
		->where('jr_cat_id = ?' , $jr_cat_id)
		->where('jr_status = ?' , 'system' );
	$jr_names = $db->fetchAll($sql);
	
	foreach($jr_names as $jr_name){
		$title_name = $jr_name['jr_name'];
		$str.= "<li><a href=\"javascript:showJobTitlePrice('$title_name')\">".$jr_name['jr_name']."</a></li>";
	}
	$str.="</ul>";
}

//echo $str;







/*
//SELECT * FROM job_role_cat_list j;
$sql = $db->select()
	->from('job_role_cat_list')
	->group('jr_name')
	->order('jr_name')
	->where('jr_status = ?' , 'system' );
$jr_names = $db->fetchAll($sql);
//echo $sql;
$smarty->assign('jr_names',$jr_names);
*/
$smarty->assign('str',$str);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//header('Content-type: text/plain');
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('GetAllJobTitle.tpl');

?>
