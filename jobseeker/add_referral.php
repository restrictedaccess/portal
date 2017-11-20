<?php
include('../conf/zend_smarty_conf.php');
require_once "classes/ReferFriendProcess.php";
$process = new ReferFriendProcess($db);
echo json_encode($process->addReferral());