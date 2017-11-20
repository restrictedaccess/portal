<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/JobLoader.php";
$info = new JobLoader($db);
$info->render();
