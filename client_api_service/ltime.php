<?php
require('../conf/zend_smarty_conf.php');
$request_body = file_get_contents('php://input');
$request_body = json_decode($request_body);
try{
	if (isset($_SESSION["client_id"])){
		$client_id = $_SESSION["client_id"];
	}else{
		$client_id = 0;
	}
	if (isset($_SESSION["admin_id"])){
		$admin_id = $_SESSION["admin_id"];
	}else{
		$admin_id = 0;
	}
	if (isset($_SESSION["userid"])){
		$userid = $_SESSION["userid"];
	}else{
		$userid = 0;
	}
	$ms = $request_body->ms;
	$page = $request_body->p;
	
	if ($page){
		$retries = 0;
		
		while (true) {
			try{
				if (TEST){
					$mongo = new MongoClient(MONGODB_TEST);
					$database = $mongo->selectDB('prod');
				}else{
					$mongo = new MongoClient(MONGODB_SERVER);
					$database = $mongo->selectDB('prod');
				}
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
			
		$client_log_time_collection = $database->selectCollection('client_log_time');
		
		$data = array(
			"client_id"=>intval($client_id),
			"userid"=>intval($userid),
			"admin_id"=>intval($admin_id),
			
			"millisecond"=>intval($ms),
			"page"=>$page,
			"date_created"=>new MongoDate(strtotime(date("Y-m-d H:i:s")))
		);
		
		$client_log_time_collection->insert($data);
		echo json_encode(array("success"=>true));		
	}

		
}catch(Exception $e){
	
}	