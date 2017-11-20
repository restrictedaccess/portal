<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/CurrentJobProcess.php";
$info = new CurrentJobProcess($db);
echo json_encode($info->process());
