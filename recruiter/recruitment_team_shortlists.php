<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/RecruitmentJobOrderDashboard.php";

$dashboard = new RecruitmentJobOrderDashboard($db);
$dashboard->render();
