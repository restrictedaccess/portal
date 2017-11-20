<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
require "classes/AbstractProcess.php";
require "classes/UpdateEducationProcess.php";
$personal = new UpdateEducationProcess($db);
if (isset($_POST["process"])){
	$personal->process();
	$personal->render();
}else{
	$personal->render();
}