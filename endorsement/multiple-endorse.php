<?php
if($_REQUEST["REQUEST_METHOD"] == "OPTIONS"){
    exit;
}

include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
require_once "classes/EndorsementProcess.php";
require_once "classes/AvailableStaffResume.php";
require_once "classes/ShowPrice.php";
session_start();
//if send is request
if(isset($_POST["send"])||isset($_GET["send"])){
	$process = new EndorsementProcess($db);
	echo json_encode($process->process());
}else{
	$smarty = new Smarty();
	//render list of to be endorsed staffs
	$job_category_option = "";
	$job_categories = $db->fetchAll($db->select()->from(array("jc"=>"job_category"))->where("jc.category_name <> ''")->where("status = 'posted' OR jc.category_name = 'In-House'")->order("jc.category_name"));
	
	foreach($job_categories as $category){
		$job_sub_categories = $db->fetchAll($db->select()->from(array("jsc"=>"job_sub_category"))->where("jsc.category_id = ?", $category["category_id"])->joinLeft(array("jc"=>"job_category"), "jc.category_id = jsc.sub_category_id", array())->where("jsc.sub_category_name <> ''")->where("jsc.status = 'posted' OR jc.category_name = 'In-House'"));	
			
		if (!empty($job_sub_categories)){
			$job_category_option.="<optgroup label='{$category["category_name"]}'>{$category["category_name"]}";
			foreach($job_sub_categories as $sub_category){
				$job_category_option.="<option value='{$sub_category['sub_category_id']}'>{$sub_category['sub_category_name']}</option>";
			}
			$job_category_option.="</optgroup>";
				
		}	
		
	}
	
	$smarty->assign("job_category_option", $job_category_option);
	$smarty->display("multiple-endorse.tpl");
}