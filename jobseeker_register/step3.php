<?php
include('../conf/zend_smarty_conf.php') ;
require('../tools/CouchDBMailbox.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true"); 
header("Access-Control-Allow-Methods: OPTIONS, GET, POST"); 
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
require_once "classes/RegisterProcess.php";
$process = new RegisterProcess($db);
echo json_encode($process->savePreferredSchedule());
