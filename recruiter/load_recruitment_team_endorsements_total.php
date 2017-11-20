<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/JobOrderRecruitmentLoader.php";
$loader = new JobOrderRecruitmentLoader($db);
$orders = $loader->getEndorsedList(false);

$job_orders = $orders["rows"];
$recruiters = $loader->getRecruiters();
foreach($recruiters as  $key=>$recruiter){
	$recruiters[$key]["assigned"] = 0;
	$recruiters[$key]["unassigned"] = 0;
	
	foreach($job_orders as $job_order){
		foreach($job_order["all_recruiters"] as $recruiter_jo){
			if ($recruiter["admin_id"]==$recruiter_jo["admin_id"]){
				$recruiters[$key]["assigned"] += $recruiter_jo["count_assigned"];
				$recruiters[$key]["unassigned"] += $recruiter_jo["count_unassigned"];
				
			}
		}
	}
}


echo json_encode($recruiters);
