<?php
include ('../conf/zend_smarty_conf.php');
include '../function.php';
require_once "classes/RegisterOptionalStep4.php";
$step = new RegisterOptionalStep4($db);
echo json_encode($step->process());
