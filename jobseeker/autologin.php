<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_REQUEST["c"])){
	$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("userid"))->where("mass_responder_code = ?", $_REQUEST["c"]));
	if ($personal){
		$_SESSION["userid"] = $personal["userid"];
		header("Location:/portal/jobseeker/");	
	}else{
		header("Location:/portal/");	
	}
	
}else{
	echo "Invalid link";
}
