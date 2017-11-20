<?php
putenv("TZ=Philippines/Manila") ;
include_once '../conf/zend_smarty_conf.php';
include_once '../config.php';
include_once '../conf.php';
if (isset($_POST["shortlist_id"])){
	
	$shortlist = $db->fetchRow($db->select()->from(array("ss"=>"tb_shortlist_history"), array("ss.userid AS userid"))
			->joinInner(array("pos"=>"posting"), "pos.id = ss.position", array("jobposition AS job_title"))
			->joinInner(array("l"=>"leads"), "l.id = pos.lead_id", array("CONCAT(l.fname, ' ', l.lname) AS client"))
			
			->where("ss.id = ?", $_POST["shortlist_id"]));
	if ($_SESSION["status"]=="FULL-CONTROL"){
		$status = "ADMIN";
	}else{
		$status = $_SESSION['status'];
	}
			
	$history = array(
		"changes"=>"Removed From <font color=#FF0000>SHORTLIST</font>, <font color=#FF0000>[{$shortlist["job_title"]}]</font>, <font color=#FF0000>[{$shortlist["client"]}]</font>",
		"userid"=>$shortlist["userid"],
		"date_change"=>date("Y-m-d h:i:s"),
		"change_by_type"=>$status,
		"change_by_id"=>$_SESSION["admin_id"]
	);
	
	$db->insert("staff_history", $history);
	
	$db->delete("tb_shortlist_history", "id = ".$_POST["shortlist_id"]);
	$db->delete("applicant_status", "link_id = ".$_POST["shortlist_id"]." AND status = 'SHORTLISTED'");
	
	$result = array("success"=>true, "shortlist"=>$shortlist);
}else{
	$result = array("success"=>false);
}
echo json_encode($result);