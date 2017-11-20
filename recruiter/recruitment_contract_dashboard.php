<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
require_once "reports/RecruitmentSheet.php";
require_once "reports/RecruiterStaffContractDashboard.php";

$dashboard = new RecruiterStaffContractDashboard($db);
$dashboard->render();