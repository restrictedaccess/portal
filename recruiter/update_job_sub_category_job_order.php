<?php
include('../conf/zend_smarty_conf.php');
$tracking_code = $_REQUEST["tracking_code"];
$sub_category_id = $_REQUEST["sub_category_id"];
if ($tracking_code&&$sub_category_id){
    try{
	$mjo = $db->fetchRow($db->select()->from(array("mjos"=>"mongo_job_orders_categories"), array("job_sub_category_id"))->where("tracking_code = ?", $tracking_code));
	if ($mjo){
		$db->update("mongo_job_orders_categories", array("job_sub_category_id"=>$sub_category_id), $db->quoteInto("tracking_code = ?", $tracking_code));		
	}else{
		$db->insert("mongo_job_orders_categories", array("tracking_code"=>$tracking_code, "job_sub_category_id"=>$sub_category_id, "date_assigned"=>date("Y-m-d H:i:s")));	
	}	
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
						
		$job_orders_collection = $database->selectCollection('job_orders');
		//get the old job order
		$old_job_order = array();
		$cursor_old = $job_orders_collection->find(array("tracking_code"=>$tracking_code));		
		while($cursor_old->hasNext()){
			$old_job_order = $cursor_old->getNext();
		}
		$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
		
		$job_orders_collection->update(array("tracking_code"=>$tracking_code), array('$set'=>array("job_order_sub_category_id"=>$sub_category_id)));
		$retries = 0;
		while(true){
			try{
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
						
		$job_orders_history_collection = $database2->selectCollection('job_orders_history');
		$old_subcategory = "";
		try{
			$old_subcategory = $db->fetchOne($db->select()->from(array("jsc"=>"job_sub_category"), array("sub_category_name"))->where("sub_category_id = ?", $old_job_order["job_order_sub_category_id"]));
		}catch(Exception $e){
			$old_subcategory = "No Sub Category";
		}
		
		$new_subcategory = $db->fetchOne($db->select()->from(array("jsc"=>"job_sub_category"), array("sub_category_name"))->where("sub_category_id = ?", $sub_category_id));
		
		$job_orders_history_collection->insert(array("history"=>"Job Order's sub category has been set from ".$old_subcategory." to ".$new_subcategory, "type"=>"assign_subcategory", "tracking_code"=>$tracking_code, "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin));
	
		echo json_encode(array("success"=>true, "subcategory"=>$new_subcategory));	
	}catch(Exception $e){
		echo json_encode(array("success"=>false));
	}
}else{
	echo json_encode(array("success"=>false));
        
        
        
        
}
