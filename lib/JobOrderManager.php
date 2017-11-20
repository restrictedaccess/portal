<?php
require_once dirname(__FILE__)."/Portal.php";
class JobOrderManager extends Portal{
		
	const OPEN = "OPEN";	
	const SC_ASSIGNED = "SC_ASSIGNED";
	const REC_ASSIGNED = "REC_ASSIGNED";
	const AD_UP = "AD_UP";
	const NEW_SHORTLIST = "NEW_SHORTLIST";
	const NEED_MORE_CANDIDATE = "NEED_MORE_CANDIDATE";
	const SC_REVIEWING_SHORTLIST = "SC_REVIEWING_SHORTLIST";
	const SKILL_TEST = "SKILL_TEST";
	const POST_ENDORSEMENT = "POST_ENDORSEMENT";
	const CLIENT_INTERVIEWING = "CLIENT_INTERVIEWING";
	const POST_INTERVIEW = "POST_INTERVIEW";
	const SC_REVIEWING_ORDER = "SC_REVIEWING_ORDER";
	const CLOSED_HIRED = "CLOSED_HIRED";
	const CLOSED_TRIAL = "CLOSED_TRIAL";
	const CLOSED_HOLD = "CLOSED_HOLD";
	const CLOSED_DID_NOT_PUSH_THROUGH = "CLOSED_DID_NOT_PUSH_THROUGH";
	
	public function assignStatus($tracking_code, $status){
		$db = $this->db;
		$db->insert("mongo_job_orders_multi_statuses", array("tracking_code"=>$tracking_code, "assigning_status"=>$status, "date_updated"=>date("Y-m-d H:i:s"), "date_created"=>date("Y-m-d H:i:s")));
				
		$this->logToMongo($tracking_code, $status);
	
	}
	
	public function render(){
		
	}
	private function logToMongo($tracking_code, $status){
		$db = $this->db;
		$retries = 0;
		while(true){
			try{
				if (TEST){
					$mongo2 = new MongoClient(MONGODB_TEST);
					$database2 = $mongo2->selectDB('prod');
				}else{
					$mongo2 = new MongoClient(MONGODB_SERVER);
					$database2 = $mongo2->selectDB('prod');
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
		$job_orders_collection = $database2->selectCollection("job_orders");
		$admin = $admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));		
		$job_orders_history_collection->insert(array("type"=>"multi_status_changed", "history"=>"Updated job order status to <span style='color:#ff0000'>".$status."</span>",  "tracking_code"=>$tracking_code, "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin));
		$job_orders_collection->update(array("tracking_code"=>$tracking_code), array('$set'=>array("sub_order_status"=>$status)));
		
		
	}
	
	public function hiringStatus($tracking_code, $status){
		$db = $this->db;
		$db->insert("mongo_job_orders_multi_statuses", array("tracking_code"=>$tracking_code, "hiring_status"=>$status, "date_updated"=>date("Y-m-d H:i:s"), "date_created"=>date("Y-m-d H:i:s")));
		$this->logToMongo($tracking_code, $status);
	
	}
	
	public function decisionStatus($tracking_code, $status){
		$db = $this->db;
		$db->insert("mongo_job_orders_multi_statuses", array("tracking_code"=>$tracking_code, "decision_status"=>$status, "date_updated"=>date("Y-m-d H:i:s"), "date_created"=>date("Y-m-d H:i:s")));
		$this->logToMongo($tracking_code, $status);
	
	}
	
}
