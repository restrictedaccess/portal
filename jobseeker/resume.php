<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/ResumeLoader.php";
$loader = new ResumeLoader($db);
$loader->render();