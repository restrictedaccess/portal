<?php
include('../conf/zend_smarty_conf.php') ;
require_once "classes/AbstractProcess.php";
require_once "forms/AddTaskForm.php";
require_once "classes/UpdateTasksProcess.php";
$process = new UpdateTasksProcess($db);
$process->render();
