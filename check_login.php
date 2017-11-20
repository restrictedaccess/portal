<?php
include('conf/zend_smarty_conf.php');
if(TEST){
	header('Access-Control-Allow-Origin: '.$_GET["ip"]);
} else if (STAGING) {
	header('Access-Control-Allow-Origin: http://staging.compliance.remotestaff.com.au');
} else {
	header('Access-Control-Allow-Origin: http://compliance.remotestaff.com.au');
}

// header('Access-Control-Allow-Origin: http://192.168.2.13:8080, http://staging.remotestaff.com.au, http://sc.remotestaff.com.au, https://remotestaff.com.au, http://staging.compliance.remotestaff.com.au, http://compliance.remotestaff.com.au');
header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
header('Cache-control: no-cache="set-cookie"');


$success = true;
$result = $_SESSION;

if(empty($_SESSION)){
	$success = false;
}


echo json_encode(array("success"=>$success, "result"=>$_SESSION));

?>