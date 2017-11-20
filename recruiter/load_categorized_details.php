<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/RecruiterASLReports.php";
if (TEST){
	$report = new RecruiterASLReports($db);	
}else{
	$report = new RecruiterASLReports($db_query_only);	
}
$recruiter_id = $_REQUEST["recruiter_id"];
$sub_category_id = $_REQUEST["sub_category_id"];
$categorized = $report->getCategorized($recruiter_id, $sub_category_id);
foreach($categorized as $key=>$candi){
	$categorized[$key]["date"] = date("Y-m-d", strtotime($candi["date"]));
}
$smarty = new Smarty();
if ($recruiter_id!="ALL"){
	$recruiter = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_lname", "admin_id"))->where("admin_id = ?", $recruiter_id));
	$smarty->assign("recruiter_name",$recruiter["admin_fname"]." ".$recruiter["admin_lname"]);
}else{
	$smarty->assign("recruiter_name","ALL");
}
if ($sub_category_id){
	$subcategory = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $sub_category_id));
	$smarty->assign("sub_category_name", $subcategory["sub_category_name"]);
}else{
	$smarty->assign("sub_category_name", "ALL");
}
$smarty->assign("categorized", $categorized);
$smarty->display("recruitment_categorized_details.tpl");
