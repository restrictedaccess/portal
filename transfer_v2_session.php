<?php

include "conf/zend_smarty_conf.php";

$retries = 0;
while(true){
	try{
		if (TEST) {
			$mongo = new MongoClient(MONGODB_TEST);
		} else {
			$mongo = new MongoClient(MONGODB_SERVER);
		}
		$database = $mongo -> selectDB('sessions');
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}



$session_collection = $database -> selectCollection("sessions");
$key = $_REQUEST["k"];
$cursor = $session_collection -> find(array("_id" => new MongoId($key)));
while ($cursor -> hasNext()) {
	$session_data = $cursor -> getNext();
	$_SESSION = $session_data["SESSION"];
	break;
}
//redirect if already has a session
if (isset($_SESSION["logintype"])) {
	$login_type = $_SESSION["logintype"];
	if ($login_type == "staff") {
		header("Location:/portal/subconHome.php");
		//header("Refresh:2; url=../../subconHome.php");

	} else if ($login_type == "jobseeker") {

		header("Location:/portal/applicantHome.php");

	} else if ($login_type == "business_partner") {

		header("Location:/portal/agentHome.php");

	} else if ($login_type == "client") {

		if (isset($_SESSION["manager_id"])) {

			header("Location:/portal/django/Manager/");

		} else {

			header("Location:/portal/clientHome.php");

		}

	} else if ($login_type == "referral_partner") {

		header("Location:/portal/affHome.php");

	} else if ($login_type == "admin") {

		$location = "Location:/portal/v2/" . $_SESSION["slug"] . "/";

		if ($_SESSION["slug"] == "recruiter" || $_SESSION["slug"] == "information-technology" || $_SESSION["slug"] == "staffing-consultant") {
			$location .= "head-dashboard/";

			header($location);
			exit ;
		} else {
			header("Location:/portal/adminHome.php");
		}

		/*
		 else if($_SESSION["is_head"]){
		 $location .= "head-dashboard/";
		 header($location);
		 } else{
		 $location .= "dashboard/";
		 header($location);
		 }
		 */
	}

	exit ;
}
