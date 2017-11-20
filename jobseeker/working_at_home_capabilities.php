<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/WorkAtHomeCapabilitiesProcess.php";
$info = new WorkAtHomeCapabilitiesProcess($db);
$info->render();
