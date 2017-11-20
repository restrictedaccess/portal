<?php
include '../conf/zend_smarty_conf.php';
if (!isset($_SESSION["admin_id"])){
	echo json_encode(array("success"=>false));	
	die;
}
if (isset($_POST["merged_order_ids"])){
	$merged_order_ids = $_POST["merged_order_ids"];
	foreach($merged_order_ids as $merged_order_id){
		$db->delete("merged_order_items", $db->quoteInto("merged_order_id = ?", $merged_order_id));
		$db->delete("merged_orders", $db->quoteInto("id = ?", $merged_order_id));
	}
	$lead_name = "";
	foreach($_POST["selected_tracking_codes"] as $tracking_code){
		try{
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
				
					if (TEST) {
						$mongo = new MongoClient(MONGODB_TEST);
						$database2 = $mongo -> selectDB('prod');
					} else {
						$mongo = new MongoClient(MONGODB_SERVER);
						$database2 = $mongo -> selectDB('prod');
					}
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}
								
			
			$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
			$job_orders_history_collection = $database2->selectCollection('job_orders_history');
			
			$cursor = $job_orders_history_collection->find(array("tracking_code"=>$tracking_code));
			while($cursor->hasNext()){
				$merge_history = $cursor->getNext();
				if ($merge_history){
					$job_orders_history_collection->insert(array("type"=>"unmerged_orders", "history"=>"Unmerged ".$tracking_code." into ".implode(", ", $merge_history["merged_orders"]), "tracking_code"=>$tracking_code, "unmerged_orders"=>$merge_history["merged_orders"], "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin));
				}
			}
			
			
			$job_orders_collection = $database->selectCollection('job_orders');
			
			$job_orders_to_delete = $job_orders_collection->find(array("tracking_code"=>$tracking_code));
			while($job_orders_to_delete->hasNext()){
				$item = $job_orders_to_delete->getNext();
				$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $item["leads_id"]));
				$lead = $db->fetchRow($db->select()->from("leads", array("lname", "fname"))->where("id = ?", $item["leads_id"]));
				$lead_name = $lead["fname"]." ".$lead["lname"];
			}
			
			
			$job_orders_collection->remove(array("tracking_code"=>$tracking_code), array("justOne"=>true));	
			
		}catch(Exception $e){
			
		}
		
	}
	if (TEST){
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
		
	}else{
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
		
	}
	echo json_encode(array("success"=>true, "lead_name"=>$lead_name));
}else{
	echo json_encode(array("success"=>false));
}
