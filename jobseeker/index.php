<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/HomeLoader.php";
$loader = new HomeLoader($db);
$loader->render();