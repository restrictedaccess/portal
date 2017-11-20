<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/UpdateEducationProcess.php";
$info = new UpdateEducationProcess($db);
$info->render();
