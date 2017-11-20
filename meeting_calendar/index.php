<?php
include "../conf/zend_smarty_conf.php";
if (isset($_SESSION["admin_id"])){
	$location = "Location:/portal/django/meeting_calendar/view/?admin_id=".$_SESSION["admin_id"];
	if (isset($_REQUEST["interview_id"])){
		$location.="&request_for_interview_id=".$_REQUEST["interview_id"]."&view_mode=interview";
	}else{
		$location.="&view_mode=my_sched";
	}
	if (isset($_REQUEST["view_type"])){
		$viewType = $_REQUEST["view_type"];
		if ($viewType=="view"){
			$location.="&view_other_admin=0";
		}else{
			$location.="&view_other_admin=1";
		}
	}
	if (isset($_REQUEST["is_rescheduled"])){
		$location.="&is_rescheduled=".$_REQUEST["is_rescheduled"];
	}
	if (isset($_REQUEST["userid"])){
		$location.="&userid=".$_REQUEST["userid"];
	}
	header($location);
}else{
	header("Location:/portal/");
}

