<?php
ini_set("max_execution_time", 5000);
include('../conf/zend_smarty_conf.php');
$db->query("TRUNCATE resume_viewing_history");

$page = 1;
$limit = 1000;
while(true){
	$view_history = $db->fetchAll($db->select()
			->from(array("sh"=>"staff_history"), array("sh.userid", "sh.change_by_id", "sh.date_change"))
			->where("changes =  \"admin viewed applicant's resume\"")
			->limitPage($page, $limit))
			;
	if (!empty($view_history)){
		foreach($view_history as $history){
			$db->insert("resume_viewing_history", array("userid"=>$history["userid"], "admin_id"=>$history["change_by_id"], "date_created"=>$history["date_change"]));
		}
		$page += 1;		
	}else{
		break;
	}

}
