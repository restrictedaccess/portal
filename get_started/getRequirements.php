<?php
include '../conf/zend_smarty_conf.php';
$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id'];
$box = $_REQUEST['box'];



$sql = $db->select()
	->from('gs_job_titles_details' , 'jr_cat_id')
	->where('gs_job_titles_details_id = ?' ,$gs_job_titles_details_id);
$jr_cat_id = $db->fetchOne($sql);	

if($jr_cat_id == 1 or $jr_cat_id == 4){
	$class = 'skill_desc';
}else{
	$class = 'skill_desc2';
}


//TABLE : gs_job_titles_credentials
//gs_job_titles_credentials_id, gs_job_titles_details_id, gs_job_role_selection_id, description, rating, box
$query = "SELECT * FROM gs_job_titles_credentials WHERE gs_job_titles_details_id = $gs_job_titles_details_id AND box = '$box';";
$result = $db->fetchAll($query);


$smarty = new Smarty();
$smarty->assign('class', $class);
$smarty->assign('result', $result);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('getRequirements.tpl');
?>
