<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/PersonalInformationProcess.php";
$info = new PersonalInformationProcess($db);
$info->render();
