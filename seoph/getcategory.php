<?php
include('../conf/zend_smarty_conf.php');
if (isset($_REQUEST["id"])){
	$job_category = $db->fetchRow($db->select()
						->from(array("jc"=>"job_category"), array("jc.category_name AS category_name", "jc.category_id AS category_id"))
						->joinLeft(array("acc"=>"ad_category_contents"), "acc.category_id = jc.category_id", 
									array("acc.id AS ad_category_id", "acc.url AS ad_category_url",
										  "acc.meta_description AS ad_category_meta_description", "acc.meta_title AS ad_category_meta_title",
										  "acc.meta_keyword AS ad_category_meta_keyword"))
						->where("jc.category_id = ?", $_REQUEST["id"]));
	if ($job_category){
		echo json_encode(array("success"=>true, "category"=>$job_category));
	}else{
		echo json_encode(array("success"=>false));
	}	
}else{
	echo json_encode(array("success"=>false));
}

