<?php
putenv("TZ=Philippines/Manila") ;

if (!isset($_REQUEST["redirect"])){
	header("Location:/portal/recruiter/recruitment_sheet_dashboard_enhanced.php");
	die;
}


include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
require_once "reports/RecruitmentSheet.php";
require_once "reports/RecruitmentSheetDashboard.php";

$dashboard = new RecruitmentSheetDashboard($db);
$dashboard->render();