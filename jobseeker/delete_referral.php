<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/ReferFriendProcess.php";
$process = new ReferFriendProcess($db);
echo json_encode($process->deleteReferral());
