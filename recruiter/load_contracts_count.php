<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
include '../function.php';
require_once "reports/RecruiterStaffContractCounter.php";

$counter = new RecruiterStaffContractCounter($db);

echo json_encode($counter->getCount());
