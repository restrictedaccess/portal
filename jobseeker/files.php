<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/FileLoader.php";
$info = new FileLoader($db);
$info->render();
