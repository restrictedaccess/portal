<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/RecruiterASLDashboard.php";
if (TEST){
	$report = new RecruiterASLDashboard($db);
}else{
	$report = new RecruiterASLDashboard($db_query_only);
}

$report->render();
