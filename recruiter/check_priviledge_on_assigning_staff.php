<?php
include('../conf/zend_smarty_conf.php') ;
//start: assign recruiter

$lizpau = array(335, 256);
if (in_array($_SESSION["admin_id"], $lizpau)){
	echo json_encode(array("success"=>true));
	die;
}

$userid = $_REQUEST["userid"];

$rs = $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"))->where("rs.userid = ?", $userid));
$pres = $db->fetchRow($db->select()->from(array("pres"=>"pre_screened_staff"))->where("pres.userid = ?", $userid));
if ($pres){
	if ($rs){
		if ($rs["admin_id"]!=$_SESSION["admin_id"]&&$_SESSION["status"]!="FULL-CONTROL"){
			echo json_encode(array("success"=>false, "error"=>"The staff has already been marked as prescreened.\nOnly the recruiter assigned can now transfer this candidate to other recruiter"));
			die;	
		}	
	}
	
	echo json_encode(array("success"=>true));	
}else{
	if ($rs){		
		if (($_SESSION["admin_id"] !=$rs["admin_id"])&&$_SESSION["status"]!="FULL-CONTROL"){	
			echo json_encode(array("success"=>false, "error"=>"Please ask the former recruiter to tag this candidate for you"));
			die;
		}
		if (($rs["auto_assigned_from_admin"])&&($_SESSION["admin_id"] !=$rs["admin_id"])&&$_SESSION["status"]!="FULL-CONTROL"){
			echo json_encode(array("success"=>false, "error"=>"This resume is created by a recruiter.\nPlease ask the recruiter to transfer this for you."));
			die;
		}
		$changeByType = $_SESSION["status"];
		if ($changeByType=="FULL-CONTROL"){
			$changeByType = "ADMIN";
		}
		
		$history = $db->fetchRow($db->select()->from("staff_history")->where("changes = 'admin created resume for candidate'")->where("userid = ?", $userid)->where("change_by_id = ?",$_SESSION["admin_id"])->where("change_by_type = ?", $changeByType));
		if (!$history){
			if ($rs["admin_id"]!=$_SESSION["admin_id"]&&$_SESSION["status"]!="FULL-CONTROL"){
				echo json_encode(array("success"=>false, "error"=>"Please ask the former recruiter to tag this candidate for you"));
				die;	
			}
		}
	}
	
	echo json_encode(array("success"=>true));		
}
