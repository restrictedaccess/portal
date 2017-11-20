<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/SkillTestEmail.php";
$test = new SkillTestEmail($db);
echo $test->getEmailTemplate($_REQUEST["userid"]);