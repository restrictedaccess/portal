<?php
/**
 * Ajax call for saving selected staff for endorsement
 */

include_once '../conf/zend_smarty_conf.php';
include_once '../config.php';
include_once '../conf.php';

session_start();
if (!isset($_SESSION["TO_BE_ENDORSED"])){
	$_SESSION["TO_BE_ENDORSED"] = array(); 
}
if (isset($_POST["userid"])){
	$found = false;
	foreach($_SESSION["TO_BE_ENDORSED"] as $userid){
		if ($userid==$_POST["userid"]){
			$found = true;
			break;
		}
	}
	if (!$found){
		$_SESSION["TO_BE_ENDORSED"][] = $_POST["userid"];		
	}
}
$included = true;
include "load_endorsement.php";