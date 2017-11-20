<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/SMSLister.php";
$lister = new SMSLister($db);
echo json_encode($lister->getList());
