<?php
include ('../conf/zend_smarty_conf.php');
include '../function.php';
require_once "classes/RegisterStep3.php";
$step = new RegisterStep3($db);
echo json_encode($step->process());
