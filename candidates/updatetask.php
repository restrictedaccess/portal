<?php
include('../conf/zend_smarty_conf.php') ;
require_once "classes/AbstractProcess.php";
require_once "forms/UpdateTaskForm.php";
require_once "classes/UpdateTasksProcess.php";
$process = new UpdateTasksProcess($db);
echo json_encode($process->updateTask());
