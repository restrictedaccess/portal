<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
require_once "classes/SingleEndorsementProcess.php";
require_once "classes/AvailableStaffResume.php";
require_once "classes/ShowPrice.php";
session_start();
//if send is request
if(isset($_POST["send"])||isset($_GET["send"])){
	$process = new SingleEndorsementProcess($db);
	echo json_encode($process->process());
}else{
	$smarty = new Smarty();
	//render list of to be endorsed staffs
	$smarty->assign("userid", $_GET["userid"]);
	$smarty->display("single-endorse.tpl");
}