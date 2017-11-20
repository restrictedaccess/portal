<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
if(!$_SESSION['admin_id']){
	header("location:/portal/index.php");
}
//load categories
$jcs = $db->fetchAll($db->select()->from(array("jc"=>"job_category")));
foreach($jcs as $key=>$jc){
	
	$sql = $db->select()->from(array("jsc"=>"job_sub_category"))->where("jsc.category_id = ?", $jc["category_id"]);
	$subcategories = $db->fetchAll($sql);
	
	foreach($subcategories as $key_s=>$subcategory){
		$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array(new Zend_Db_Expr("COUNT(*) AS count")))->where("sub_category_id = ?", $subcategory["sub_category_id"])->where("ratings = 0");
		$subcategories[$key_s]["count"] = $db->fetchOne($sql);
	}
	
	
	$jcs[$key]["job_sub_categories"] = $subcategories; 
}

$smarty = new Smarty();
$smarty->assign("job_categories", $jcs);
$smarty->display("seo.tpl");