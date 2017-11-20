<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
include "classes/AbstractProcess.php";
include "classes/UpdateLanguagesProcess.php";
$personal = new UpdateLanguagesProcess($db);
if (isset($_POST["process"])){
	$personal->process();
	$personal->render();
}else{
	$personal->render();
}
