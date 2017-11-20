<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
header('Cache-control: no-cache="set-cookie"');
include "conf/zend_smarty_conf.php";
if (!isset($_GET["department"])){
	$department = "account";
}else{
	$department = $_GET["department"];		
}
$hash = $_REQUEST["session_hash"];

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
$cursor = $session_collection->find(array("session_hash"=>$hash));
while($cursor->hasNext()){
	$_SESSION = $cursor->getNext();
}
echo json_encode(array("success"=>true));
exit;