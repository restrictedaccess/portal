<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/FileLoader.php";
$loader = new FileLoader($db);
echo json_encode($loader->uploadPhoto());
