<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
require "classes/AbstractProcess.php";
require "classes/UpdateWorkingAtHomeCapabilitiesProcess.php";
$update = new UpdateWorkingAtHomeCapabilities($db);
if (isset($_POST["process"])){
	$update->process();
	$update->render();
}else{
	$update->render();
}