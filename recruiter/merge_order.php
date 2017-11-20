<?php
include '../conf/zend_smarty_conf.php';
include('../time.php') ;
require_once "reports/GetJobPosting.php";
if ((isset($_POST["selectedLinkIds"]))&&(isset($_POST["selectedLinkTypes"]))&&(isset($_SESSION["admin_id"]))){
	$collectedOrders = array();
	$collectedTypes = array();
	$posting = new GetJobPosting($db);
	for($i=0;$i<count($_POST["selectedLeads"]);$i++){
		$searchLead = $_POST["selectedLeads"][$i];
		for($j=$i+1;$j<count($_POST["selectedLeads"]);$j++){
			$searchedLead = $_POST["selectedLeads"][$j];
			if ($searchLead!=$searchedLead){
				echo json_encode(array("success"=>false, "message"=>"You can only merge orders with the same client."));
				die;
			}
		}
	}
	
	$uniqueTrackingCodes = array();
	
	foreach($_POST["selectedTrackingCodes"] as $tracking_code){
		if (!in_array($tracking_code, $uniqueTrackingCodes)){
			$uniqueTrackingCodes[] = $tracking_code;
		}
	}
	
	if (count($uniqueTrackingCodes)<=1){
		echo json_encode(array("success"=>false, "message"=>"You can only merge orders with the different tracking codes.\nPlease check with admin."));
		die;
	}
	
	$_POST["selectedTrackingCodes"] = $uniqueTrackingCodes;
	
	$retries = 0;
	while(true){
		try{
			if (TEST){
				$mongo = new MongoClient(MONGODB_TEST);
				$database = $mongo->selectDB('prod');
			}else{
				$mongo = new MongoClient(MONGODB_SERVER);
				$database = $mongo->selectDB('prod');
			}
		
			if (TEST){
				$mongo = new MongoClient(MONGODB_TEST);
				$database2 = $mongo->selectDB('prod');
			}else{
				$mongo = new MongoClient(MONGODB_SERVER);
				$database2 = $mongo->selectDB('prod');
			}
			break;
		} catch(Exception $e){
			++$retries;
			
			if($retries >= 100){
				break;
			}
		}
	}
			
	
	$job_orders_collection = $database->selectCollection('job_orders');
	$job_orders_history_collection = $database2->selectCollection('job_orders_history');
		
	$selectedDate = "";
	$basisType = "";
	$orderStatus = "";
	$mongo_job_orders = array();
	//collect all selected job order	
	foreach($_POST["selectedTrackingCodes"] as $tracking_code){
		$cursor = $job_orders_collection->find(array("tracking_code"=>$tracking_code));
		while($cursor->hasNext()){
			$order = $cursor->getNext();
			$mongo_job_orders[] = $order;			
		}
	}
	
	$mergedItems = array();
	foreach($mongo_job_orders as $job_order){
		//if merge we need to get all merged order items
		if ($job_order["merged_order_id"]){
			$orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"))->where("moi.merged_order_id = ?", $job_order["merged_order_id"]));
			foreach($orders as $order){
				if ($order["service_type"]=="ASL"){
					//check if pure ASL
					$queryItem = array("jsca_id"=>$order["jsca_id"],
										"date_added"=>$order["date_added"],
										"lead_id"=>$order["lead_id"],
										"type"=>$order["service_type"]
									);
					//check if asl is on custom order
					$customDetails = $db->fetchRow($db->select()->from(array("gs_jrs"=>"gs_job_role_selection"), array())
						->joinInner(array("gs_jtd"=>"gs_job_titles_details"), "gs_jtd.gs_job_role_selection_id = gs_jrs.gs_job_role_selection_id", array("gs_jtd.gs_job_titles_details_id"))
						->where("gs_jtd.created_reason IS NULL")		
						->where("DATE(gs_jrs.request_date_added) = ?", $order["date_added"])
						->where("gs_jrs.leads_id = ?", $order["lead_id"])
						->where("gs_jrs.jsca_id = ?", $order["jsca_id"]));
	
					if ($customDetails){
						$queryItem["gs_job_titles_details_id"] = $customDetails["gs_job_titles_details_id"];
					}	
					$mergedItems[] = $queryItem;				
				}else{
					$mergedItems[] = array(
										"order_id"=>$order["gs_job_title_details_id"],
										"type"=>$order["service_type"]
									);
				}
			}
			$db->delete("merged_order_items", $db->quoteInto("merged_order_id = ?", $job_order["merged_order_id"]));
			
		}else{
			if ($job_order["service_type"]=="ASL"){
				$queryItem = array(
					"jsca_id"=>$job_order["jsca_id"],
					"date_added"=>date("Y-m-d", $job_order["date_filled_up"]->sec),
					"lead_id"=>$job_order["leads_id"],
				);
				if ($job_order["gs_job_titles_details_id"]){
					$queryItem["order_id"] = $job_order["gs_job_titles_details_id"];
				}
			}else{
				$queryItem["order_id"] = $job_order["gs_job_titles_details_id"];
			}
			$queryItem["type"] = $job_order["service_type"];
			$mergedItems[] = $queryItem;
		}
	}
	
	$collectedOrders = array();
	foreach($mergedItems as $query){
		$type = $query["type"];
		if ($type=="ASL"){
			if ($query["order_id"]){			
				$collectedOrders[] = $posting->getOrder($query, "custom");
			}else{
				$collectedOrders[] = $posting->getOrder($query, "ASL");
			}
		}else{
			$collectedOrders[] = $posting->getOrder($query, "custom");
		}
	}
	
	
	//check if all ASL
	$allAsl = true;
	foreach($collectedOrders as $collectedOrder){
		if ($collectedOrder["service_type"]!="ASL"){
			$allAsl = false;
			break;
		}
	}	
	
	//find the index to mark as basis
	$markASLKey = 0;
	foreach($collectedOrders as $key=>$collectedOrder){
		if ($collectedOrder["service_type"]=="ASL"){
			if ($collectedOrder["gs_job_titles_details_id"]){
				$markASLKey = $key;
				break;
			}
		}
	}	
	
	$basisType = "";
	$basisKey = 0;
	$savedOrders = array();
	$selectedDate = "";
	$orderStatus = "";
	foreach($collectedOrders as $key=>$collectedOrder){
		$data = array();
		$data["service_type"] = $collectedOrder["service_type"];
		if ($collectedOrder["service_type"]=="ASL"){
			
			$data["jsca_id"] = $collectedOrder["jsca_id"];
			$data["date_added"] = $collectedOrder["date_filled_up"];
			$data["lead_id"] = $collectedOrder["leads_id"];
			if ($collectedOrder["gs_job_titles_details_id"]){
				$data["gs_job_title_details_id"] = $collectedOrder["gs_job_titles_details_id"];			
			}
			
		}else{		
			$data["gs_job_title_details_id"] = $collectedOrder["gs_job_titles_details_id"];
		}
		if ($key==$markASLKey&&$allAsl){
			$data["basis"] = 1;
			$selectedDate = date("Y-m-d H:i:s", strtotime($collectedOrder["date_filled_up"]));
			$orderStatus = $collectedOrder["status"];
			$basisType = "ASL";
		}else{
			if ($collectedOrder["service_type"]!="ASL"&&$key==0){
				$data["basis"] = 1;
				$basisType = $collectedOrder["service_type"];
				$selectedDate = date("Y-m-d H:i:s", strtotime($collectedOrder["date_filled_up"]));
				$orderStatus = $collectedOrder["status"];
			}else if ($collectedOrder["service_type"]=="ASL"&&$key==0){
				$data["basis"] = 0;
				//remember basis based on the next order
				for($i=1;$i<count($collectedOrders);$i++){
					$temp = $collectedOrders[$i];
					if ($temp["service_type"]!="ASL"){
						$basisType = $temp["service_type"];
						$basisKey = $i;
						break;
					}
				}
			}else{
				if ($basisKey!=0&&$key==$basisKey){
					$data["basis"] = 1;
					$basisType = $collectedOrder["service_type"];
					$selectedDate = date("Y-m-d H:i:s", strtotime($collectedOrder["date_filled_up"]));
					$orderStatus = $collectedOrder["status"];
				}else{
					$data["basis"] = 0;
				}
			}
		}
		$db->insert("merged_order_items", $data);	
		$savedOrders[] = $db->lastInsertId("merged_order_items");
	}
	if (!empty($savedOrders)){
		
		if (!$selectedDate){
			foreach($_POST["selectedTrackingCodes"] as $tracking_code){
				$cursor = $job_orders_collection->find(array("tracking_code"=>$tracking_code));
				while($cursor->hasNext()){
					$order = $cursor->getNext();
					if ($order["date_filled_up"]){
						$selectedDate = date("Y-m-d H:i:s", $order["date_filled_up"]->sec);					
					}
				}
			}			
		}
		if (!$basisType){
			foreach($_POST["selectedTrackingCodes"] as $tracking_code){
				$cursor = $job_orders_collection->find(array("tracking_code"=>$tracking_code));
				while($cursor->hasNext()){
					$order = $cursor->getNext();
					if ($order["service_type"]){
						$basisType = $order["service_type"];					
					}
				}
			}	
		}
		
		
		$selectedDate2 = date("Y-m-d", strtotime($selectedDate));
		if ($selectedDate2=="1970-01-01"){
			$selectedDate = date("Y-m-d");
		}
		
		if (($selectedDate==""||$selectedDate2=="1970-01-01")&&$orderStatus!=""){
			$db->insert("merged_orders", array("service_type"=>$basisType, "order_status"=>$orderStatus, "date_created"=>$selectedDate, "admin_id"=>$_SESSION["admin_id"]));
		}else if (($selectedDate!=""&&$selectedDate2!="1970-01-01")&&$orderStatus==""){
			$db->insert("merged_orders", array("service_type"=>$basisType, "order_status"=>"Open", "date_created"=>$selectedDate, "admin_id"=>$_SESSION["admin_id"]));
		}else{
			$db->insert("merged_orders", array("service_type"=>$basisType, "order_status"=>$orderStatus, "date_created"=>$selectedDate, "admin_id"=>$_SESSION["admin_id"]));
		}
		$orderId = $db->lastInsertId("merged_orders");
		$db->update("merged_order_items", array("merged_order_id"=>$orderId), "id IN (".implode(",", $savedOrders).")");
		
		
		foreach($_POST["selectedTrackingCodes"] as $tracking_code){
			try{
				$retries = 0;
				while(true){
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
					
				$job_orders_collection = $database->selectCollection('job_orders');
				foreach($_POST["selectedTrackingCodes"] as $tracking_code){
					$job_orders_collection->remove(array("tracking_code"=>$tracking_code), array('justOne'=>true));	
					$db->delete("mongo_job_orders", $db->quoteInto("tracking_code = ?", $tracking_code));
				}
				//ensure that the merged order is also deleted on mongodb
				$db->delete("mongo_job_orders", $db->quoteInto("tracking_code = ?", $orderId."-".$basisType."-MERGE"));
				$job_orders_collection->remove(array("tracking_code"=>$orderId."-".$basisType."-MERGE"), array("justOne"=>true));
				
			}catch(Exception $e){
				
			}
		}
		
		$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
		
		$job_orders_history_collection->insert(array("type"=>"merged_orders", "history"=>"Merged ".implode(", ", $_POST["selectedTrackingCodes"])." into ".$orderId."-".$basisType."-MERGE", "merged_orders"=>$_POST["selectedTrackingCodes"], "tracking_code"=>$orderId."-".$basisType."-MERGE", "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin));
		
		if (TEST){
			file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
			file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
			file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
			
			file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
			file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
			file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
			
		}else{
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
			
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
			
			
		}
		
		$lead_name = "";
		foreach($_POST["selectedLeads"] as $lead_id){
			if ($lead_id){
				$lead = $db->fetchRow($db->select()->from("leads", array("lname", "fname"))->where("id = ?", $lead_id));
				$lead_name = $lead["fname"]." ".$lead["lname"];
			}
		}
		
		echo json_encode(array("success"=>true, "lead_name"=>$lead_name));
	}else{
		echo json_encode(array("success"=>false));
	}
}else{
	echo json_encode(array("success"=>false));
}