<?php
include('../conf/zend_smarty_conf.php');
require_once "reports/JobOrderLoader.php";
$loader = new JobOrderLoader($db);
echo json_encode($loader->process());
