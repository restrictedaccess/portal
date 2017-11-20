<?php
include_once '../conf/zend_smarty_conf.php';
require_once "classes/UpdateCurrentJobProcess.php";
$process = new UpdateCurrentJobProcess($db);
$process->process();
