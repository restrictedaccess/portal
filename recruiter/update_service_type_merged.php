<?php
putenv("TZ=Philippines/Manila");
include ('../conf/zend_smarty_conf.php');
include '../function.php';
if (!isset($_SESSION["admin_id"])) {
	die ;
}
if ((isset($_POST["value"])) && (isset($_POST["id"]))) {
	$value = $_POST["value"];
	$id = $_POST["id"];
	$db -> update("merged_orders", array("service_type" => $value), "id = " . $_POST["id"]);

	//get merge order status
	$order_status = $db -> fetchOne($db -> select() -> from("merged_orders", array("order_status")) -> where("id = ?", $_POST["id"]));

	//find basis
	$row = $db -> fetchRow($db -> select() -> from("merged_order_items") -> where("basis = 1") -> where("merged_order_id = ?", $_POST["id"]));
	if ($row) {
		if ($value != "ASL" && $row["service_type"] == "ASL" && !$row["gs_job_title_details_id"]) {
			$jsca_id = $row["jsca_id"];
			$date_added = $row["date_added"];
			$leads_id = $row["lead_id"];
			$gs_jrs = $db -> fetchRow($db -> select() -> from("gs_job_role_selection", array("gs_job_role_selection_id")) -> joinInner("gs_job_titles_details", "gs_job_titles_details.gs_job_role_selection_id = gs_job_role_selection.gs_job_role_selection_id", array()) -> where("gs_job_role_selection.leads_id = ?", $leads_id) -> where("gs_job_role_selection.jsca_id = ?", $jsca_id) -> where("DATE(gs_job_role_selection.request_date_added) = ?", $date_added) -> where("gs_job_titles_details.created_reason = 'Converted-From-ASL'"));
			if (!$gs_jrs) {
				$session_id = $db -> fetchRow($db -> select() -> from(array("tbr" => "tb_request_for_interview"), "session_id") -> where("job_sub_category_applicants_id = ?", $jsca_id) -> where("DATE(date_added) = DATE(?)", $date_added) -> where("leads_id = ?", $leads_id));
				$session_id = $session_id["session_id"];
				$created_by_id = $_SESSION["admin_id"];
				$created_by_type = "admin";
				$data = array('leads_id' => $leads_id, 'created_by_id' => $created_by_id, 'created_by_type' => $created_by_type, 'date_created' => $ATZ, 'status' => 'new', 'ran' => $ran, 'session_id' => $session_id, "jsca_id" => $jsca_id, "request_date_added" => $date_added);
				$db -> insert('gs_job_role_selection', $data);

				$id = $db -> lastInsertId("gs_job_role_selection");

				$order["service_type"] = $value;
				$order["date_filled_up"] = date("Y-m-d h:i:s");
				$order["status"] = "new";
				$order["gs_job_role_selection_id"] = $id;
				$order["created_reason"] = "Converted-From-ASL";

				$db -> insert("gs_job_titles_details", $order);
				$order_id = $db -> lastInsertId("gs_job_titles_details");
				//make the old basis as no basis then create a new basis
				$db -> update("merged_order_items", array("basis" => 0), $db -> quoteInto("id = ?", $row["id"]));
				$db -> insert("merged_order_items", array("gs_job_title_details_id" => $order_id, "service_type" => $value, "basis" => 1, "merged_order_id" => $row["merged_order_id"]));
			}
		} else {
			$db -> update("merged_order_items", array("service_type" => $_POST["value"]), "id = " . $row["id"]);
		}
		if ($_POST["tracking_code"]) {

			$mongo_order = $db -> fetchRow($db -> select() -> from("mongo_job_orders") -> where("tracking_code = ?", $_POST["tracking_code"]));

			$db -> delete("mongo_job_orders", $db -> quoteInto("leads_id = ?", $mongo_order["leads_id"]));
			try {
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
				
				$admin = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $_SESSION["admin_id"]));
				$job_orders_collection = $database -> selectCollection('job_orders');
				$job_orders_history_collection = $database2 -> selectCollection('job_orders_history');

				$cursor = $job_orders_collection -> find(array("tracking_code" => $_POST["tracking_code"]));
				$old_job_order = array();

				while ($cursor -> hasNext()) {
					$old_job_order = $cursor -> getNext();
				}

				$job_orders_history_collection -> insert(array("type" => "service_type_change", "history" => "Service type changed from " . $old_job_order["service_type"] . " to " . $value, "old_tracking_code" => $old_job_order["tracking_code"], "tracking_code" => $old_job_order["tracking_code"], "new_tracking_code" => $id . "-" . $value . "-MERGE", "date" => new MongoDate(strtotime(date("Y-m-d H:i:s"))), "tracking_code" => $id . "-" . $value . "-MERGE", "admin" => $admin));

				$job_orders_collection -> remove(array("leads_id" => intval($mongo_order["leads_id"])));

			} catch(Exception $e) {

			}
			if (TEST) {
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");

			} else {
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");

			}

			echo json_encode(array("result" => true, "id" => $id, "status" => $order_status, "service_type" => $value));
		} else {
			echo json_encode(array("result" => false));
		}
	}
} else {
	echo json_encode(array("result" => false));
}
