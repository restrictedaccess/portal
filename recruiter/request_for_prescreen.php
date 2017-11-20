<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
require_once "reports/StaffLister.php";
require_once "reports/RemoteReadyPrescreenLoader.php";

$sheet = new RemoteReadyPrescreenLoader($db);
$sheet->render();
