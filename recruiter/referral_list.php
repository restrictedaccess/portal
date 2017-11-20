<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
require_once "reports/ReferralSheet.php";

$sheet = new ReferralSheet($db);
$sheet->render_new();

