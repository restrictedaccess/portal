<?php
include('../conf/zend_smarty_conf.php') ;
require_once "classes/AbstractProcess.php";
require_once "forms/UpdateSkillForm.php";
require_once "classes/UpdateSkillProcess.php";

$process = new UpdateSkillProcess($db);
$process->renderUpdate();
