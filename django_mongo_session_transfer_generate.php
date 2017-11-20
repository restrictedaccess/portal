<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
header('Cache-control: no-cache="set-cookie"');
include "conf/zend_smarty_conf.php";

while(true){
	$length = 20;
	$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	$session = array();
	$session = $_SESSION;
	unset($session["_id"]);
	$session["session_hash"] = $randomString;
	$session["session_expire"] = new MongoDate(strtotime(date("Y-m-d H:i:s", strtotime("+1 day"))));
	
	if (!isset($_GET["department"])){
		$department = "account";
	}else{
		$department = $_GET["department"];		
	}
	
	$retries = 0;
	while(true){
		try{
			if (TEST) {
		        $client = new MongoClient(MONGODB_TEST);
				$database = $client -> selectDB('sessions');
		    } else {
		        $client = new MongoClient(MONGODB_SERVER);
				$database = $client -> selectDB('sessions');
		    }
			break;
		} catch(Exception $e){
			++$retries;
			
			if($retries >= 100){
				break;
			}
		}
	}
	
	
	$session_collection = $database->selectCollection($department."_sessions");
	$cursor = $session_collection->find(array("session_hash"=>$randomString));
	
	if (!$cursor->hasNext()){
		$session_collection->insert($session);
		echo json_encode(array("success"=>true, "session_hash"=>$randomString));
		break;
	}		
}


