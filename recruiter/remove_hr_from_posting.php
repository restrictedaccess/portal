<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
if (isset($_POST["recruiter_id"])){
	$sql = $db->select()->from(array("gjo_rl"=>"gs_job_orders_recruiters_links"))
			->where("gjo_rl.link_id = ?", $_POST["link_id"])
			->where("gjo_rl.link_type = ?", $_POST["link_type"])
			->where("gjo_rl.recruiters_id = ?", $_POST["recruiter_id"]);
	$jo = $db->fetchRow($sql);
	if ($jo){
		$db->delete("gs_job_orders_recruiters_links", "gs_job_orders_recruiters_link_id = {$jo["gs_job_orders_recruiters_link_id"]}");			
		$result = array("result"=>true, "link"=>$jo);
	}else{
		$result = array("result"=>false);
	}
	
	if ($_POST["tracking_code"]){
		$db->delete("mongo_job_orders", $db->quoteInto("tracking_code = ?", $_POST["tracking_code"]));
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
			$job_orders_collection->remove(array("tracking_code"=>$_POST["tracking_code"]), array("justOne"=>true));	
		}catch(Exception $e){
			
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
}else{
	$result = array("result"=>false);
}
echo json_encode($result);	
