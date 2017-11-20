<?php
ini_set("max_execution_time", 300);
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
include '../function.php';

require_once "reports/GetJobPosting.php";

$posting = new GetJobPosting($db);
echo json_encode($posting->process());