<?php 
include('../conf/zend_smarty_conf.php');
require_once "classes/SkillTaskManager.php";

$search = new SkillTaskManager($db);
echo json_encode($search->deleteTask());
