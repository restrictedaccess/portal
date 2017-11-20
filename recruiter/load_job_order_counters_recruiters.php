<?php
ini_set("max_execution_time", 300);
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
include '../function.php';
require_once 'reports/GetJobPosting.php';
require_once 'reports/JobOrderRecruiterCounter.php';
$counter = new JobOrderRecruiterCounter($db);
if (isset($_GET["today"])){
	echo json_encode($counter->getTodaysOpenCounters());
}else if (isset($_GET["closing"])){
	echo json_encode($counter->getClosedOrderStatusCounters());
}else{
	echo json_encode($counter->getOrderStatusCounters());
}
