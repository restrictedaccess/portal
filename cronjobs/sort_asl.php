<?php
include '../conf/zend_smarty_conf.php';
$sorted_applicants = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("id"))->order(array(new Zend_Db_Expr("RAND()")))->where("jsca.ratings = 0"));
$applicants = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("id"))->where("jsca.ratings = 0"));
foreach($applicants as $key=>$applicant){
	$db->update("job_sub_category_applicants", array("ordering"=>$sorted_applicants[$key]["id"]), $db->quoteInto("id = ?", $applicant["id"]));
}
$sorted_applicants = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("id"))->order(array(new Zend_Db_Expr("RAND()")))->where("jsca.ratings = 0"));
$applicants = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("id"))->where("jsca.ratings = 0"));
foreach($applicants as $key=>$applicant){
	$db->update("job_sub_category_applicants", array("homepage_ordering"=>$sorted_applicants[$key]["id"]), $db->quoteInto("id = ?", $applicant["id"]));
}

