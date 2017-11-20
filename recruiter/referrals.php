<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../function.php') ;
include('../lib/validEmail.php') ;
include('../time.php') ;
include('../AgentCurlMailSender.php') ;
include('../lib/staff_history.php');
include_once('../lib/staff_files_manager.php') ;

if (!isset($_REQUEST["redirect"])){
	header("Location:/portal/recruiter/referral_list.php");
	die;
}


require_once "reports/ReferralSheet.php";



$sheet = new ReferralSheet($db);
$sheet->render();

