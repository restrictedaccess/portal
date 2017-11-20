<?php
include('../conf/zend_smarty_conf.php') ;
require_once "classes/UpdateSkillProcess.php";
$process = new UpdateSkillProcess($db);
echo json_encode($process->deleteSkill());