<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/ApplicationLoader.php";
$info = new ApplicationLoader($db);
$info->render();
