<?php
include('../conf/zend_smarty_conf.php');
if (!isset($_SESSION["admin_id"])){
	die;
}
if ((isset($_POST["selectedLinkIds"]))&&(isset($_POST["selectedLinkTypes"]))&&(isset($_POST["status"]))){
	$status = $_POST["status"];
	if ($status=="Displayed"){
		$status = "Deleted";
	}else{
		$status = "Display";
	}
	
	for($i=0;$i<count($_POST["selectedLinkIds"]);$i++){
		
		$data = array(
			"link_id"=>$_POST["selectedLinkIds"][$i],
			"link_type"=>$_POST["selectedLinkTypes"][$i],
			"status"=>$status
		);
		$sql = $db->select()->from("job_orders_status", array("id"))->where("link_id = ?", $_POST["selectedLinkIds"][$i])
							->where("link_type = ?",$_POST["selectedLinkTypes"][$i]);
		
		if ($_POST["selectedJscaIds"][$i]!=""){
			$data["jsca_id"] = $_POST["selectedJscaIds"][$i];
			$data["date_added"] = $_POST["selectedDateAddeds"][$i];
			$sql = $sql->where("jsca_id = ?", $_POST["selectedJscaIds"][$i])
					->where("date_added = ?", $_POST["selectedDateAddeds"][$i]);
			
		}
		//echo $_POST["selectedLinkTypes"][$i];
							
		$found = $db->fetchRow($sql);
		if ($status=="Deleted"){
			$db->insert("job_orders_status", $data);			
		}else{ 
			$cond = "link_id = ".$_POST["selectedLinkIds"][$i]." AND link_type = '".$_POST["selectedLinkTypes"][$i]."'";
			if ($_POST["selectedJscaIds"][$i]!=""){
				$cond.=" AND jsca_id = {$_POST["selectedJscaIds"][$i]}";
				$cond.=" AND date_added = '{$_POST["selectedDateAddeds"][$i]}'";
			}
			$db->delete("job_orders_status", $cond);
		}
	}
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
						
		$job_orders_collection = $database->selectCollection('job_orders');
		$job_orders_history_collection = $database2->selectCollection('job_orders_history');
		
		
		$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
		foreach($_POST["selectedTrackingCodes"] as $tracking_code){
			//get the old job order
			$old_job_order = array();
			$cursor_old = $job_orders_collection->find(array("tracking_code"=>$tracking_code));		
			while($cursor_old->hasNext()){
				$old_job_order = $cursor_old->getNext();
			}
				
			
			if ($status=="Deleted"){
				$job_orders_collection->update(array("tracking_code"=>$tracking_code), array('$set'=>array("deleted"=>true)));	
			}else{
				$job_orders_collection->update(array("tracking_code"=>$tracking_code), array('$set'=>array("deleted"=>false)));
			}
			$db->delete("mongo_job_orders", $db->quoteInto("tracking_code = ?", $tracking_code));
			
			//get the new job order
			$new_job_order = array();
			$cursor_new = $job_orders_collection->find(array("tracking_code"=>$tracking_code));		
			while($cursor_new->hasNext()){
				$new_job_order = $cursor_new->getNext();
			}
			$job_orders_history_collection->insert(array("history"=>"Deleted Job Order", "type"=>"delete_jo", "old_record"=>$old_job_order, "new_record"=>$new_job_order, "tracking_code"=>$tracking_code, "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin));
			
			$db->insert("deleted_job_orders", array("tracking_code"=>$tracking_code, "date_deleted"=>date("Y-m-d H:i:s")));	

	}
		
		
		
		
	}catch(Exception $e){
		
	}
	
	
	echo json_encode(array("result"=>true));
}else{
	echo json_encode(array("result"=>false));
}