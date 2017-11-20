<?php
ini_set("max_execution_time", 300);
include '../conf/zend_smarty_conf.php';

	$job_orders = $db->fetchAll($db->select()->from("mongo_job_orders"));
	if (TEST){
		$mongo = new Mongo();
		$database = $mongo->selectDB('test');
	}else{
		$mongo = new Mongo(MONGODB_SERVER);
		$database = $mongo->selectDB('prod');
	}
	$job_orders_collection = $database->selectCollection('job_orders');
	
	foreach($job_orders as $job_order){
		$cursor = $job_orders_collection->find(array("tracking_code"=>$job_order["tracking_code"]));	
		$foundOrders = array();
		while($cursor->hasNext()){
			$mongo_job_order = $cursor->getNext();
			$foundOrders[] = $mongo_job_order;			
		}
		echo $job_order["tracking_code"].":".count($foundOrders)."<br/>";
		if (count($foundOrders)>1){
			for($i=1;$i<count($foundOrders);$i++){
				$item_to_delete = $foundOrders[$i];
				$job_orders_collection->remove(array('_id'=>$item_to_delete['_id']));
			}
		}
	}

