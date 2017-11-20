<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/SMSLogPortal.php";
$portal = new SMSLogPortal($db);
$portal->render();
