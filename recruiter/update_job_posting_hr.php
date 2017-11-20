<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
require_once dirname(__FILE__)."/../lib/JobOrderManager.php";
if (!isset($_SESSION["admin_id"])){
	die;
}
$manager = new JobOrderManager($db);
if (isset($_POST["hr_id"])&&isset($_POST["column"])){
	$column = $_POST["column"];
	if ($column=="hr"){
		
		$data = array(
			"recruiters_id"=>$_POST["hr_id"],
			"link_id"=>$_POST["link_id"],
			"link_type"=>$_POST["link_type"]
		);
		
		
		
		if (isset($_POST["recruiter_id"])){
			$sql = $db->select()->from(array("gjo_rl"=>"gs_job_orders_recruiters_links"))
					->where("gjo_rl.link_id = ?", $_POST["link_id"])
					->where("gjo_rl.link_type = ?", $_POST["link_type"])
					->where("gjo_rl.recruiters_id = ?", $_POST["recruiter_id"]);
			$jo = $db->fetchRow($sql);
			
			if ($jo){
				$db->update("gs_job_orders_recruiters_links", $data, "gs_job_orders_recruiters_link_id = {$jo["gs_job_orders_recruiters_link_id"]}");			
			}else{
				$db->insert("gs_job_orders_recruiters_links", $data);	
						
			}
		}else{
			$sql = $db->select()->from(array("gjo_rl"=>"gs_job_orders_recruiters_links"))
					->where("gjo_rl.link_id = ?", $_POST["link_id"])
					->where("gjo_rl.link_type = ?", $_POST["link_type"])
					->where("gjo_rl.recruiters_id = ?", $_POST["hr_id"]);
			$jo = $db->fetchRow($sql);
			if (!$jo){
				$db->insert("gs_job_orders_recruiters_links", $data);	
			}
		}
		if ($_POST["tracking_code"]){
			$manager->assignStatus($_POST["tracking_code"], JobOrderManager::REC_ASSIGNED);		
		}
	//IF HIRING COORDINATOR IS UPDATED
	}else if ($column=="hc"){
		$data = array(
			hiring_coordinator_id=>$_POST["hr_id"],
		);
		$leads_id = $_POST["leads_id"];
		$db->update("leads", $data, "leads.id={$leads_id}");
		
	}
	
	//update content of cell from database
	
	
	$sql = $db->select()->from("admin", array("admin_fname", "admin_lname", "admin_id"))->where("admin_id = ?", $_POST["hr_id"]);
	$admin = $db->fetchRow($sql);
	
	
	if ($_POST["tracking_code"]){
		if ($column=="hc"){
			$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $_POST["leads_id"]));
		}else{
			$db->delete("mongo_job_orders", $db->quoteInto("tracking_code = ?", $_POST["tracking_code"]));
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
						$mongo = new MongoClient();
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
			$hr_assigned = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_POST["hr_id"]));
			
			//sync to job order history
			if ($column=="hc"){
				$cursor = $job_orders_collection->find(array("leads_id"=>intval($_POST["leads_id"])));		
				
				while($cursor->hasNext()){
					$job_order = array();
					$old_job_order = array();
					
					$job_order = $cursor->getNext();
					$old_job_order = $job_order;
					
					$job_order["hc_fname"] = $hr_assigned["admin_fname"];
					$job_order["hc_lname"] = $hr_assigned["hc_lname"];
					$job_order["assigned_hiring_coordinator_id"] = intval($hr_assigned["admin_id"]);				
					$job_orders_history_collection->insert(array("history"=>"Hiring Manager ".$hr_assigned["admin_fname"]." ".$hr_assigned["admin_lname"]." is Assigned to Job Order", "type"=>"assigned_hiring_manager", "job_order"=>$job_order, "tracking_code"=>$job_order["tracking_code"], "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin, "hr"=>$hr_assigned));	
					$manager->assignStatus($job_order["tracking_code"], JobOrderManager::SC_ASSIGNED);		
			
				}
				
				$cursor = $job_orders_collection->find(array("leads_id"=>intval($_POST["leads_id"])));		
				while($cursor->hasNext()){
					$job_order = $cursor->getNext();
					$job_orders_collection->update(array("tracking_code"=>$job_order["tracking_code"]), array('$set'=>array("assigned_hiring_coordinator_id"=>intval($_POST["hr_id"]))));
				}
				
			}else{
				$cursor = $job_orders_collection->find(array("tracking_code"=>$_POST["tracking_code"]));		
				$job_order = array();
				while($cursor->hasNext()){
					$job_order = $cursor->getNext();
				}
				$cursor = $job_orders_collection->find(array("tracking_code"=>$_POST["tracking_code"]));		
				$old_job_order = array();
				while($cursor->hasNext()){
					$old_job_order = $cursor->getNext();
				}
				
				$job_orders_collection->update(array("tracking_code"=>$_POST["tracking_code"]), array('$set'=>array("assigned_hiring_coordinator_id"=>intval($_POST["hr_id"]))));
				
			
				$jo = array();
				if (isset($_POST["recruiter_id"])){
					$sql = $db->select()->from(array("gjo_rl"=>"gs_job_orders_recruiters_links"))
							->where("gjo_rl.link_id = ?", $_POST["link_id"])
							->where("gjo_rl.link_type = ?", $_POST["link_type"])
							->where("gjo_rl.recruiters_id = ?", $_POST["recruiter_id"]);
					$jo = $db->fetchRow($sql);
				}else{
					$jo = array();
				}
				$job_order["recruiters"][] = $jo;
				$job_orders_history_collection->insert(array("history"=>"Recruiter ".$hr_assigned["admin_fname"]." ".$hr_assigned["admin_lname"]." is Assigned to Job Order", "type"=>"assigned_recruiter", "new_job_order"=>$job_order, "old_job_order"=>$old_job_order, "tracking_code"=>$_POST["tracking_code"], "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin, "hr"=>$hr_assigned));	
				
			}
			
		}catch(Exception $e){
			
		}
	}

	

	$result = array("result"=>true, "hr"=>$admin, "title_id"=>$_POST["title_id"]);
	
	
	
	
}else{
	$result = array("result"=>false);
}
echo json_encode($result);	
