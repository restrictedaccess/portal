<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/LanguagesProcess.php";
$info = new LanguagesProcess($db);
$info->renderUpdate();
