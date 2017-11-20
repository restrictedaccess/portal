<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
require "classes/AbstractProcess.php";
require "classes/UpdateCurrentJobProcess.php";

$personal = new UpdateCurrentJobProcess($db);
if ($_POST){
	$personal->process();
	$personal->render();
}else{
	$personal->render();
}

