<?php
ini_set("max_execution_time", 300);
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;

require_once 'reports/JobOrderRecruitmentLoader.php';

$loader = new JobOrderRecruitmentLoader($db);

echo json_encode($loader->getList());
