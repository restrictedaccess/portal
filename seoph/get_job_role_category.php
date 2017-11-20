<?php
include('../conf/zend_smarty_conf.php');
if (isset($_REQUEST["id"])){
	$job_category = $db->fetchRow($db->select()
						->from(array("jrc"=>"job_role_category"))
						->where("jrc.jr_cat_id = ?", $_REQUEST["id"]));
	if ($job_category){
		echo json_encode(array("success"=>true, "category"=>$job_category));
	}else{
		echo json_encode(array("success"=>false));
	}	
}else{
	echo json_encode(array("success"=>false));
}

