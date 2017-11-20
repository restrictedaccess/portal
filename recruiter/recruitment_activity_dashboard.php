<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
require_once "reports/RecruitmentSheet.php";
require_once "reports/RecruitmentActivityDashboard.php";

$dashboard = new RecruitmentActivityDashboard($db);
$dashboard->render();
