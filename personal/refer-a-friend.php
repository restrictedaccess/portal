<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
require "classes/AbstractProcess.php";
require "classes/ReferAFriendProcess.php";
$process = new ReferAFriendProcess($db);
if (isset($_POST["userid"])){
	$process->process();
	$process->render();
}else{
	$process->render();	
}