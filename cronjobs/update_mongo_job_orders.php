<?php
include '../conf/zend_smarty_conf.php';
ini_set("memory_limit", -1);
$retries = 0;
while(true){
	try{
		if (TEST) {
			$mongo = new MongoClient(MONGODB_TEST);
			$database = $mongo -> selectDB('prod');
	    } else {
	        $mongo = new MongoClient(MONGODB_SERVER);
	        $database = $mongo -> selectDB('prod');
	    }
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}
   
$job_orders_collection = $database -> selectCollection('job_orders');

$cursor = $job_orders_collection->find(array("order_status"=>"Open"));
while($cursor->hasNext()){
    $job_order = $cursor->getNext();
    $tracking_code = $job_order["tracking_code"];
    $db -> delete("mongo_job_orders", $db -> quoteInto("tracking_code = ?", $tracking_code));
}

$job_orders = $db->fetchAll($db->select()->from("mongo_job_orders", array("tracking_code")));
foreach($job_orders as $job_order){
	$cursor = $job_orders_collection->find(array("tracking_code"=>$job_order["tracking_code"]));
		
	if (!$cursor->hasNext()){
		$db -> delete("mongo_job_orders", $db -> quoteInto("tracking_code = ?", $job_order["tracking_code"]));
	}
}
