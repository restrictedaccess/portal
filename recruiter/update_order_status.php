<?php
putenv("TZ=Philippines/Manila");
include ('../conf/zend_smarty_conf.php');
include ('../tools/CouchDBMailbox.php');
require_once "reports/GetJobPosting.php";
if (!(isset($_SESSION["admin_id"]) || isset($_SESSION['agent_no']))) {
	die ;
}
if ((isset($_POST["value"])) && (isset($_POST["id"]))) {
	$value = $_POST["value"];
	$id = $_POST["id"];
	$type = $_POST["type"];

	if ($type == "order") {
		$saveValue = "";

		if ($value == "Open") {
			$saveValue = "new";
		} else if ($value == "Did not push through") {
			$saveValue = "cancel";
		} else if ($value == "Closed") {
			$saveValue = "finish";
		} else if ($value == "On Trial") {
			$saveValue = "ontrial";
		} else if ($value == "On Hold") {
			$saveValue = "onhold";
		}
		$order = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = $id"));
		if ($order && ($order["status"] == "finish" || $order["status"] == "cancel" || $order["status"] == "onhold") && $saveValue == "new") {
			unset($order["gs_job_titles_details_id"]);
			
			if ($order["status"]=="onhold"||$order["status"]=="cancel"){
				if ($_REQUEST["new_order"]=="no"){
					$data = array("status" => $saveValue);
		
					if (($value == "Closed") || ($value == "Did not push through")) {
						$data["date_closed"] = date("Y-m-d H:i:s");
						
						if(isset($_POST["date_closed"])){
							$data["date_closed"] = $_POST["date_closed"];
						}
					} else if ($value == "Open") {
						$data["date_closed"] = NULL;
					}
					$db -> update("gs_job_titles_details", $data, "gs_job_titles_details_id = $id");					
				}else{
					if ($order["status"] == "finish") {
						$order["service_type"] = "REPLACEMENT";
					}
					$order["link_order_id"] = $id;
					$order["created_reason"] = "Closed-To-Replacement";
					$order["date_filled_up"] = date("Y-m-d h:i:s");
					$order["status"] = $saveValue;
					$linkedOrder = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("link_order_id = ?", $id));
					$db -> insert("gs_job_titles_details", $order);
					$id = $db -> lastInsertId("gs_job_titles_details");
				}

			}else{
				if ($order["status"] == "finish") {
					$order["service_type"] = "REPLACEMENT";
				}
				$order["link_order_id"] = $id;
				$order["created_reason"] = "Closed-To-Replacement";
				$order["date_filled_up"] = date("Y-m-d h:i:s");
				$order["status"] = $saveValue;
				$linkedOrder = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("link_order_id = ?", $id));
				$db -> insert("gs_job_titles_details", $order);
				$id = $db -> lastInsertId("gs_job_titles_details");
			}
			
			
		} else {
			$data = array("status" => $saveValue);

			if (($value == "Closed") || ($value == "Did not push through")) {
				$data["date_closed"] = date("Y-m-d H:i:s");
				if(isset($_POST["date_closed"])){
					$data["date_closed"] = $_POST["date_closed"];
				}
			} else if ($value == "Open") {
				$data["date_closed"] = NULL;
			}
			$db -> update("gs_job_titles_details", $data, "gs_job_titles_details_id = $id");

		}
		$type = "custom";
		$order = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = $id"));

		if ($order["service_type"] == "REPLACEMENT") {
			//auto archive job posting
			if (($value == "Closed") || ($value == "Did not push through") || ($value == "On Hold")) {
				$posting = new GetJobPosting($db);
				$posting_id = $posting -> getParentOrderPosting($id);
				if ($posting_id) {
					$db -> update("posting", array("status" => "ARCHIVE", "show_status" => "NO"), $db -> quoteInto("id = ?", $posting_id));
				}
			} else {
				$posting = new GetJobPosting($db);
				$posting_id = $posting -> getParentOrderPosting($id);
				if ($posting_id) {
					$db -> update("posting", array("status" => "ACTIVE", "show_status" => "YES"), $db -> quoteInto("id = ?", $posting_id));

				}
			}
		} else {
			if (($value == "Closed") || ($value == "Did not push through") || ($value == "On Hold")) {
				$posting = new GetJobPosting($db);
				$posting_id = $posting -> getPosting($id);
				if ($posting_id) {
					$db -> update("posting", array("status" => "ARCHIVE", "show_status" => "NO"), $db -> quoteInto("id = ?", $posting_id));
				}
			} else {
				$posting = new GetJobPosting($db);
				$posting_id = $posting -> getPosting($id);
				if ($posting_id) {
					$db -> update("posting", array("status" => "ACTIVE", "show_status" => "YES"), $db -> quoteInto("id = ?", $posting_id));

				}
			}
		}

	} else {

		$saveValue = "";

		if ($value == "Open") {
			$saveValue = "new";
		} else if ($value == "Did not push through") {
			$saveValue = "cancel";
		} else if ($value == "Closed") {
			$saveValue = "finish";
		} else if ($value == "On Trial") {
			$saveValue = "ontrial";
		} else if ($value == "On Hold") {
			$saveValue = "onhold";
		}
		$jsca_id = $_POST["jsca_id"];
		$date_added = $_POST["date_added"];
		$lead_id = $_POST["lead_id"];
		$data = array("status" => $saveValue);
		$data["date_closed"] = date("Y-m-d H:i:s");
		if(isset($_POST["date_closed"])){
			$data["date_closed"] = $_POST["date_closed"];
		}

		if (isset($_POST["gs"])) {
			//search on custom record then attempts to update
			$aslCustom = $db -> fetchRow($db -> select() -> from(array("gs_jtd" => "gs_job_titles_details"), array("gs_job_titles_details_id")) -> joinInner(array("gs_jrs" => "gs_job_role_selection"), "gs_jtd.gs_job_role_selection_id = gs_jrs.gs_job_role_selection_id", array()) -> where("gs_jtd.gs_job_titles_details_id = ?", $_POST["gs"]));
			if (!is_null($aslCustom)) {
				$jos = $db -> fetchRow($db -> select() -> from("request_for_interview_job_order_session", array("session_id")) -> where("lead_id = ?", $lead_id) -> where("job_sub_category_applicants_id = ?", $jsca_id) -> where("DATE(date_added) = ?", $date_added));
				if ($jos) {
					if (isset($jos["date_closed"]) && $jos["date_closed"]) {
						$data["date_closed"] = $jos["date_closed"];
					}
				}
				$db -> update("gs_job_titles_details", $data, $db -> quoteInto("gs_job_titles_details_id = ?", $aslCustom["gs_job_titles_details_id"]));

			}
			unset($data["date_closed"]);
			//proceed as normal asl
			//$db->update("request_for_interview_job_order", $data, "session_id = $id");
			if (($value == "Closed") || ($value == "Did not push through")) {
				$data["date_closed"] = date("Y-m-d h:i:s");
				if(isset($_POST["date_closed"])){
					$data["date_closed"] = $_POST["date_closed"];
				}
			} else if ($value == "Open") {
				$data["date_closed"] = NULL;
			}
			$row = $db -> fetchRow($db -> select() -> from("request_for_interview_job_order_session", array("session_id")) -> where("lead_id = ?", $lead_id) -> where("job_sub_category_applicants_id = ?", $jsca_id) -> where("DATE(date_added) = ?", $date_added));
			if ($row) {
				$data["session_id"] = $id;
				$data["lead_id"] = $lead_id;
				$data["job_sub_category_applicants_id"] = $jsca_id;
				$data["date_added"] = $date_added;
				$db -> update("request_for_interview_job_order_session", $data, "lead_id = $lead_id AND job_sub_category_applicants_id = {$jsca_id} AND DATE(date_added) = '{$date_added}'");
			} else {
				$data["session_id"] = $id;
				$data["lead_id"] = $lead_id;
				$data["job_sub_category_applicants_id"] = $jsca_id;
				$data["date_added"] = $date_added;
				$db -> insert("request_for_interview_job_order_session", $data);
			}
			
			//SELECTED ORDER STATUS IS CLOSED
			if($value == 'Closed'){
				$db -> update( 'posting', array("status"=>"ARCHIVE", "show_status"=>"NO"), $db->quoteInto('job_order_id=?',$_POST["gs"]) );
			}

		} else {
			//search on custom record then attempts to update
			$aslCustom = $db -> fetchRow($db -> select() -> from(array("gs_jtd" => "gs_job_titles_details"), array("gs_job_titles_details_id")) -> joinInner(array("gs_jrs" => "gs_job_role_selection"), "gs_jtd.gs_job_role_selection_id = gs_jrs.gs_job_role_selection_id", array()) -> where("gs_jrs.jsca_id = ?", $jsca_id) -> where("DATE(gs_jrs.request_date_added) = DATE(?)", $date_added) -> where("gs_jrs.leads_id = ?", $lead_id));
			if (!is_null($aslCustom)) {
				$jos = $db -> fetchRow($db -> select() -> from("request_for_interview_job_order_session", array("session_id")) -> where("lead_id = ?", $lead_id) -> where("job_sub_category_applicants_id = ?", $jsca_id) -> where("DATE(date_added) = ?", $date_added));
				if ($jos) {
					if (isset($jos["date_closed"]) && $jos["date_closed"]) {
						$data["date_closed"] = $jos["date_closed"];
					}
				}
				$db -> update("gs_job_titles_details", $data, $db -> quoteInto("gs_job_titles_details_id = ?", $aslCustom["gs_job_titles_details_id"]));
				
			}
			unset($data["date_closed"]);
			//proceed as normal asl
			//$db->update("request_for_interview_job_order", $data, "session_id = $id");
			if (($value == "Closed") || ($value == "Did not push through")) {
				$data["date_closed"] = date("Y-m-d h:i:s");
				if(isset($_POST["date_closed"])){
					$data["date_closed"] = $_POST["date_closed"];
				}
			} else if ($value == "Open") {
				$data["date_closed"] = NULL;
			}

			$row = $db -> fetchRow($db -> select() -> from("request_for_interview_job_order_session", array("session_id")) -> where("lead_id = ?", $lead_id) -> where("job_sub_category_applicants_id = ?", $jsca_id) -> where("DATE(date_added) = ?", $date_added));
			if ($row) {
				$data["session_id"] = $id;
				$data["lead_id"] = $lead_id;
				$data["job_sub_category_applicants_id"] = $jsca_id;
				$data["date_added"] = $date_added;
				$db -> update("request_for_interview_job_order_session", $data, "lead_id = $lead_id AND job_sub_category_applicants_id = {$jsca_id} AND DATE(date_added) = '{$date_added}'");
			} else {
				$data["session_id"] = $id;
				$data["lead_id"] = $lead_id;
				$data["job_sub_category_applicants_id"] = $jsca_id;
				$data["date_added"] = $date_added;
				$db -> insert("request_for_interview_job_order_session", $data);
			}
			//find also aslCustom
			$aslCustom = $db -> fetchRow($db -> select() -> from(array("gs_jtd" => "gs_job_titles_details"), array("gs_job_titles_details_id")) -> joinInner(array("gs_jrs" => "gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_titles_details_id", array()) -> where("gs_jrs.session_id = ?", $id) -> where("DATE(gs_jrs.request_date_added) = DATE(?)", $date_added) -> where("gs_jrs.leads_id = ?", $lead_id));

			if ($aslCustom) {
				$saveData = array();
				$saveData["date_closed"] = date("Y-m-d H:i:s");
				if(isset($_POST["date_closed"])){
					$saveData["date_closed"] = $_POST["date_closed"];
				}
				$saveData["status"] = $saveValue;
				$db -> update("gs_job_titles_details", $data, $db -> quoteInto("gs_job_titles_details_id = ?", $aslCustom["gs_job_titles_details_id"]));
			}
		}

	}

	$type = "asl";
	//email management@remotestaff.com.au when order is set did not pushed through or onhold
	if ($value == "Did not push through" || $value == "On Hold") {
		$emailSmarty = new Smarty();
		$email2Smarty = new Smarty();
		$admin_id = $_SESSION["admin_id"];
		if (isset($_SESSION["admin_id"])) {
			$admin = $db -> fetchRow($db -> select() -> from(array("a" => "admin"), array("admin_fname", "admin_lname")) -> where("a.admin_id = ?", $admin_id));
			$emailSmarty -> assign("admin_name", $admin["admin_fname"] . " " . $admin["admin_lname"]);
		} else if (isset($_SESSION["agent_no"])) {
			$admin = $db -> fetchRow($db -> select() -> from(array("a" => "agent"), array("fname", "lname")) -> where("a.agent_no = ?", $_SESSION["agent_no"]));
			$emailSmarty -> assign("admin_name", $admin["fname"] . " " . $admin["lname"]);
		}
		$tracking_code = urlencode($_REQUEST["tracking_code"]);
		if (TEST) {
			$url = "http://devs.remotestaff.com.au/portal/recruiter/test_mongo_load.php?keyword={$tracking_code}&filter_type=0&service_type=0&order_status=-1";
		} else if (TEST) {
			$url = "http://staging.remotestaff.com.au/portal/recruiter/test_mongo_load.php?keyword={$tracking_code}&filter_type=0&service_type=0&order_status=-1";
		} else {
			$url = "https://remotestaff.com.au/portal/recruiter/test_mongo_load.php?keyword={$tracking_code}&filter_type=0&service_type=0&order_status=-1";
		}
		$response = file_get_contents($url);
		$response = json_decode($response);
		$emailSmarty -> assign("status", $value);
		$email2Smarty -> assign("status", $value);
		
		foreach ($response->rows as $row) {
			$emailSmarty -> assign("lead_fname", $row -> lead_firstname);
			$emailSmarty -> assign("lead_lname", $row -> lead_lastname);
			$emailSmarty -> assign("js_form_link", $row -> job_specification_link_export);
			$emailSmarty -> assign("job_title", $row -> job_title);
			$emailSmarty -> assign("date_ordered", $row -> date_filled_up);
			
			$email2Smarty -> assign("lead_fname", $row -> lead_firstname);
			$email2Smarty -> assign("lead_lname", $row -> lead_lastname);
			$email2Smarty -> assign("js_form_link", $row -> job_specification_link_export);
			$email2Smarty -> assign("job_title", $row -> job_title);
			$email2Smarty -> assign("date_ordered", $row -> date_filled_up);
			
			$startArry = date_parse($row -> date_filled_up);
			$endArry = date_parse(date("Y-m-d"));
			$start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
			$end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);
			$emailSmarty -> assign("order_age", round(($end_date - $start_date), 0));
			$email2Smarty -> assign("order_age", round(($end_date - $start_date), 0));
			
		}
		$body = $emailSmarty -> fetch("did_not_push_through.tpl");

		//$mail = new Zend_Mail();
		$subject = "Order Report Status Update $tracking_code";
		//$to = "management@remotestaff.com.au";
		//if (TEST) {
		//	$subject = "TEST - " . $subject;
		//	$to = "devs@remotestaff.com.au";
		//}else{
		//	$mail -> addBcc("devs@remotestaff.com.au");
		//}

		//$mail -> setSubject($subject);
		//$mail -> addTo($to);
		//$mail -> setFrom("noreply@remotestaff.com.au");
		//$mail -> setBodyHtml($body);
		//$mail -> send($transport);
		
		$bcc_array = array("devs@remotestaff.com.au");
		$cc_array =null;
		$from = "noreply@remotestaff.com.au";
		$to_array = array("management@remotestaff.com.au");
		$html = $body;
		if(!isset($_POST["date_closed"])){
			SaveToCouchDBMailbox(null, $bcc_array, $cc_array, $from, $html, $subject, null, $to_array);
		}
		
		
		$body = $email2Smarty -> fetch("recruitment_oic_ping.tpl");
		
		//$mail = new Zend_Mail();
		$subject = "Order Report Status Update $tracking_code";
		//$to = "management@remotestaff.com.au";
		//if (TEST) {
		//	$subject = "TEST - " . $subject;
		//	$to = "devs@remotestaff.com.au";
		//}

		//$mail -> setSubject($subject);
		//if (TEST){
		//	$mail -> addTo("devs@remotestaff.com.au");
		//}else{
			//$mail -> addTo("paulo@remotestaff.com.ph");
			//$mail -> addTo('rowena.n@remotestaff.com.au');
			
			//$mail -> addTo('edward@remotestaff.com.au');
			//$mail -> addTo("liz@remotestaff.com.au");			
			//$mail -> addBcc("devs@remotestaff.com.au");
		//}
		
		

		
		//$mail -> setFrom("noreply@remotestaff.com.au");
		//$mail -> setBodyHtml($body);
		//$mail -> send($transport);
		
		$bcc_array = array("devs@remotestaff.com.au");
		$cc_array =null;
		$from = "noreply@remotestaff.com.au";
		$to_array = array("edward@remotestaff.com.au", "liz@remotestaff.com.au","lance@remotestaff.com.au");
		$html = $body;
		if(!isset($_POST["date_closed"])){
			SaveToCouchDBMailbox(null, $bcc_array, $cc_array, $from, $html, $subject, null, $to_array);
		}
		
	}

	echo json_encode(array("result" => true, "id" => $id, "saveValue" => $saveValue, "order" => $order, "type" => $type));
	
	if ($_POST["tracking_code"]){
		$db->delete("mongo_job_orders", $db->quoteInto("tracking_code = ?", $_POST["tracking_code"]));
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
			$job_orders_collection = $database->selectCollection('job_orders');
			$job_orders_history_collection = $database2->selectCollection('job_orders_history');
			
			$cursor = $job_orders_collection->find(array("tracking_code"=>$_POST["tracking_code"]));		
			$old_job_order = array();
		
			while($cursor->hasNext()){
				$old_job_order = $cursor->getNext();
			}			
			$job_orders_history_collection->insert(array("history"=>"Order Status has been changed from ".$old_job_order["order_status"]." to ".$value, "old_order_status"=>$old_job_order["order_status"], "new_order_status"=>$value, "type"=>"change_order_status", "new_job_order"=>array(), "old_job_order"=>$old_job_order, "tracking_code"=>$_POST["tracking_code"], "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin));	
			
			require_once dirname(__FILE__)."/../lib/JobOrderManager.php";
			$manager = new JobOrderManager($db);
			if ($value=="Closed"){
				$manager->decisionStatus($_POST["tracking_code"], JobOrderManager::CLOSED_HIRED);
			}else if ($value=="On Hold"){
				$manager->decisionStatus($_POST["tracking_code"], JobOrderManager::CLOSED_HOLD);
			}else if ($value=="On Trial"){
				$manager->decisionStatus($_POST["tracking_code"], JobOrderManager::CLOSED_TRIAL);
			}else if ($value=="Did not push through"){
				$manager->decisionStatus($_POST["tracking_code"], JobOrderManager::CLOSED_DID_NOT_PUSH_THROUGH);
			}else{
				$manager->assignStatus($_POST["tracking_code"], JobOrderManager::OPEN);
			}
			
			
			$job_orders_collection->remove(array("tracking_code"=>$_POST["tracking_code"]), array("justOne"=>true));	
		}catch(Exception $e){
			
		}
		if (TEST){
			file_get_contents("http://devs.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
			file_get_contents("http://devs.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
			file_get_contents("http://devs.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
			file_get_contents("http://devs.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
			file_get_contents("http://devs.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
			file_get_contents("http://devs.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
			
		} else if (STAGING){
			file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
			file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
			file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
			file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
			file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
			file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
			
		}else{
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
			
		}
	}	
	
} else {
	echo json_encode(array("result" => false));
}
