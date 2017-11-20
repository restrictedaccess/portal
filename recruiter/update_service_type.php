<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../function.php') ;
include('../lib/validEmail.php') ;
include('../time.php') ;
include('../AgentCurlMailSender.php') ;
include('../lib/staff_history.php');
if (!isset($_SESSION["admin_id"])){
	die;
}
if ((isset($_POST["value"]))&&(isset($_POST["id"]))){
	$value = $_POST["value"];
	$id = $_POST["id"];
	$service_type = $_POST["service_type"];
	$created_by_id = $_SESSION["admin_id"];
	$created_by_type = "admin";
	//query old order data
	
	$order = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $id));
	if ($order){
		if ($order["status"]=="finish"&&$value=="REPLACEMENT"){
			unset($order["gs_job_titles_details_id"]);
			$order["service_type"] = $value;
			$order["link_order_id"] = $id;
			$order["created_reason"] = "Closed-To-Replacement";
			$order["date_filled_up"] = date("Y-m-d h:i:s");
			$order["status"] = "new";
			$linkedOrder = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("link_order_id = ?", $id));
			if ($linkedOrder){
				$db->update("gs_job_titles_details", $order, $db->quoteInto("gs_job_titles_details_id = ?", $linkedOrder["gs_job_titles_details_id"]));
				$id = $linkedOrder["gs_job_titles_details_id"];						
			}else{
				$db->insert("gs_job_titles_details", $order);
				$id = $db->lastInsertId("gs_job_titles_details");
			}
			
		}else{
			$data = array("service_type"=>$value);
			$db->update("gs_job_titles_details", $data, "gs_job_titles_details_id = $id");
		}
		
		//get the leads_id
		$lead = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array())->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id"))->where("gs_jtd.gs_job_titles_details_id = ?", $id));
		
		
		if ($_POST["tracking_code"]){
			if ($_POST["tracking_code"]){
				$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $lead["leads_id"]));
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
				$job_orders_collection = $database->selectCollection('job_orders');
				$job_orders_history_collection = $database2->selectCollection('job_orders_history');
				
				$cursor = $job_orders_collection->find(array("tracking_code"=>$_POST["tracking_code"]));		
				$old_job_order = array();
			
				while($cursor->hasNext()){
					$old_job_order = $cursor->getNext();
				}
				$job_orders_history_collection->insert(array("type"=>"service_type_change", "history"=>"Service type changed from ".$old_job_order["service_type"]." to ".$value, "old_tracking_code"=>$old_job_order["tracking_code"], "new_tracking_code"=>$id."-".$value, "tracking_code"=>$_POST["tracking_code"], "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin));
				
				$job_orders_collection->remove(array("leads_id"=>intval($lead["leads_id"])), array("justOne"=>false));							


			
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
			
		}
		
		
		echo json_encode(array("result"=>true, "id"=>$id, "status"=>$order["status"], "service_type"=>$_POST["value"]));
	}else{
		if ($service_type=="ASL"&&$value!="ASL"){
			$leads_id = $_POST["leads_id"];
			$jsca_id = $_POST["jsca_id"];
			$date_added = $_POST["date_added"];
			$AusTime = date("H:i:s"); 
			$AusDate = date("Y")."-".date("m")."-".date("d");
			$ATZ = $AusDate." ".$AusTime;
			
			//find Old Record
			
			$gs_jrs = $db->fetchRow($db->select()->from("gs_job_role_selection", array("gs_job_role_selection_id"))->where("leads_id = ?", $leads_id)->where("jsca_id = ?", $jsca_id)->where("DATE(request_date_added) = ?", $date_added));
			
			if (!$gs_jrs){
				$session_id = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), "session_id")->where("job_sub_category_applicants_id = ?", $jsca_id)->where("DATE(date_added) = DATE(?)", $date_added)->where("leads_id = ?", $leads_id));
	  			$session_id = $session_id["session_id"];			
				$data = array(
					'leads_id' => $leads_id,
					'created_by_id' => $created_by_id,
					'created_by_type' => $created_by_type,
					'date_created' => $ATZ,
					'status' => 'new',
					'ran' => $ran,
					'session_id' => $session_id,
					"jsca_id" =>$jsca_id,
					"request_date_added"=>$date_added
				);	
				$db->insert('gs_job_role_selection', $data);
				
				$id = $db->lastInsertId("gs_job_role_selection");
				
				$order["service_type"] = $value;
				//$order["link_order_id"] = $id;
				$order["date_filled_up"] = date("Y-m-d h:i:s");
				$order["status"] = "new";
				$order["gs_job_role_selection_id"] = $id;
				$order["created_reason"] = "Converted-From-ASL";
				
				$db->insert("gs_job_titles_details", $order);
				$id = $db->lastInsertId("gs_job_titles_details");
			}else{
				$db->update("gs_job_titles_details", array("service_type"=>$value), $db->quoteInto("gs_job_role_selection_id = ?", $gs_jrs["gs_job_role_selection_id"]));
				$gs_jtd = $db->fetchRow($db->select()->from("gs_job_titles_details", array("gs_job_titles_details_id"))->where("gs_job_role_selection_id = ?", $gs_jrs["gs_job_role_selection_id"]));
				if ($gs_jtd){
					$id = $gs_jtd["gs_job_titles_details_id"];
				}
			}
			
			
			if ($_POST["tracking_code"]){
				if ($_POST["tracking_code"]){
					$mongo_order = $db->fetchRow($db->select()->from("mongo_job_orders")->where("tracking_code = ?", $_POST["tracking_code"]));
					
					
					$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $mongo_order["leads_id"]));
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
								break;
							} catch(Exception $e){
								++$retries;
								
								if($retries >= 100){
									break;
								}
							}
						}
											
						$job_orders_collection = $database->selectCollection('job_orders');
						$job_orders_collection->remove(array("leads_id"=>intval($mongo_order["leads_id"])), array("justOne"=>false));		
					}catch(Exception $e){
						
					}
						
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
				file_get_contents("http://remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
				file_get_contents("http://remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
				file_get_contents("http://remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
				file_get_contents("http://remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
				file_get_contents("http://remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
				file_get_contents("http://remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
				
			}
			echo json_encode(array("result"=>true, "id"=>$id, "status"=>"Open", "service_type"=>$_POST["value"]));
			
			
		}else{	
			echo json_encode(array("result"=>false));	
		}
	}
	
}else{
	echo json_encode(array("result"=>false));
}