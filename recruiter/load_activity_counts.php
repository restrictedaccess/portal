<?php
ini_set("memory_limit", -1);
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
include '../function.php';
require_once "reports/RecruitmentActivityCounter.php";

$counter = new RecruitmentActivityCounter($db);

echo json_encode($counter->getCount());
