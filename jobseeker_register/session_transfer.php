<?php
include('../conf/zend_smarty_conf.php') ;
$code = $_REQUEST["c"];
$validation = $db->fetchRow($db->select()->from("jobseeker_session_transfer")->where("hashcode = ?", $code));
if ($validation){
	$session = json_decode($validation["session_data"]);
	$_SESSION["userid"] = $session->userid;
	$_SESSION["emailaddr"] = $session->emailaddr;
	if (TEST){
		header("Location:http://devs.remotestaff.com.ph/register/step3.php?c=".$code);
	}else{
		if ($_SERVER["SERVER_NAME"]=="staging.remotestaff.com.au"){
			header("Location:http://staging.remotestaff.com.ph/register/step3.php?c=".$code);
		}else{
			header("Location:http://remotestaff.com.ph/register/step3.php?c=".$code);		
		}
	}
}

