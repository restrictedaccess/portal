<?php
include ('../conf/zend_smarty_conf.php');
include '../function.php';
require_once "classes/RegisterStep2.php";
$step = new RegisterStep2($db);
echo json_encode($step->process());
