<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/ReferFriendProcess.php";
$info = new ReferFriendProcess($db);
$info->render();
