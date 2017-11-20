<?php
class GetJobPostingCounters{
	private $db;
	private $posting;
	
	private $dateFrom = "";
	private $dateTo = "";
	private $order_status="";
	private $display = "Display";
	private $filter_type;
	
	public function __construct($db){
		$this->db = $db;
		$this->posting = new GetJobPosting($db);
		$this->gatherInputs();
	}
	
	private function gatherInputs(){
		if (isset($_GET["date_from"])){
			$this->dateFrom = $_GET["date_from"];
		}else{
			$this->dateFrom = date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
		}
		if (isset($_GET["date_to"])){
			$this->dateTo = $_GET["date_to"];
		}else{
			$this->dateTo = date("Y-m-d");
		}
		if (isset($_GET["order_status"])){
			$this->order_status = $_GET["order_status"];
			if ($this->order_status==1||$this->order_status==-1){
				$this->filter_type = 7;	
			}else{
				$this->filter_type = 1;
			}
		
		}else{
			$this->filter_type = 1;
		}
		
		
	}
	
	
	private function executeSQL($sqlCustom, $sqlASL1, $sqlASL2, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2, $admin_id, $service_type, $order_status){
		$db = $this->db;	

		$this->attachHavingOnClientStaffSearch($sqlCustom, $order_status, $service_type);
		$this->attachHavingOnClientStaffSearch($sqlASL1, $order_status, $service_type);
		$this->attachHavingOnClientStaffSearch($sqlASL2, $order_status, $service_type);
		$this->attachHavingOnClientStaffSearch($sqlMergeASL1, $order_status, $service_type);
		$this->attachHavingOnClientStaffSearch($sqlMergeASL2, $order_status, $service_type);
		$this->attachHavingOnClientStaffSearch($sqlMergeCustom, $order_status, $service_type);

		if ($admin_id=="nohm"){
			$sqlCustom->where("l.hiring_coordinator_id IS NULL");
			$sqlASL1->where("l.hiring_coordinator_id IS NULL");
			$sqlASL2->where("l.hiring_coordinator_id IS NULL");
			$sqlMergeCustom->where("l.hiring_coordinator_id IS NULL");
			$sqlMergeASL1->where("l.hiring_coordinator_id IS NULL");
			$sqlMergeASL2->where("l.hiring_coordinator_id IS NULL");
		}else if ($admin_id!=""){
			$sqlCustom->where("l.hiring_coordinator_id = ?", $admin_id);
			
			
			$sqlASL1->where("l.hiring_coordinator_id = ?", $admin_id);
			$sqlASL2->where("l.hiring_coordinator_id = ?", $admin_id);
			$sqlMergeCustom->where("l.hiring_coordinator_id = ?", $admin_id);
			$sqlMergeASL1->where("l.hiring_coordinator_id = ?", $admin_id);
			$sqlMergeASL2->where("l.hiring_coordinator_id = ?", $admin_id);
		}
		
		if ($service_type!=0){
			$value = "";
			if ($service_type == 1){
				$value="CUSTOM";
				$sql = $db->select()->union(array($sqlCustom, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2));
			}else if ($service_type==2){
				$value="ASL";
				$sql = $db->select()->union(array($sqlCustom,$sqlMergeASL1, $sqlMergeASL2,  $sqlASL1, $sqlASL2, $sqlMergeCustom) );
			}else if ($service_type==3){
				$value="BACK ORDER";
				$sql = $db->select()->union(array($sqlCustom, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2 ) );
			}else if ($service_type==4){
				$value="REPLACEMENT";
				$sql = $db->select()->union(array($sqlCustom, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2));
				
			}else if ($service_type==5){
				$value="INHOUSE";
				$sql = $db->select()->union(array($sqlCustom, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2));
			}else{
				$sql = $db->select()->union(array($sqlCustom, $sqlMergeASL1, $sqlMergeASL2, $sqlMergeCustom, $sqlASL1, $sqlASL2) );
			}

		}else{
			$sql = $db->select()->union(array($sqlCustom, $sqlMergeASL1, $sqlMergeASL2, $sqlMergeCustom, $sqlASL1, $sqlASL2) );
		}
		
		
		$sql->limit(1);
		if ($this->filter_type==7||$this->filter_type==3){
			$sql = str_replace("AS `gs_jtd`", "AS `gs_jtd` FORCE INDEX (PRIMARY)",$sql);
			$sql = str_replace("AS `moi`", "AS `moi` FORCE INDEX(MERGED_ORDER_ID)", $sql);
			$sql = str_replace("AS `tbr`", "AS `tbr` FORCE INDEX(PRIMARY,REQUEST_FOR_INTERVIEW_STATUS_APPLICANT)", $sql);
			
		}else{
			$sql = str_replace("AS `gs_jtd`", "AS `gs_jtd` FORCE INDEX (PRIMARY)",$sql->__toString());
			$sql = str_replace("AS `moi`", "AS `moi` FORCE INDEX(MERGED_ORDER_ID)", $sql);
			$sql = str_replace("AS `tbr`", "AS `tbr` FORCE INDEX(PRIMARY, REQUEST_FOR_INTERVIEW_STATUS_APPLICANT)", $sql);
		}
		
		$db->fetchRow($sql);
	}
	
	
	
	
	
	private function getTodayCount($admin_id, $order_status, $service_type){
		$db = $this->db;	
			
		$sqlCustom = $this->createSelect();
		$sqlASL1 = $this->createEmptyJSLeadQuery();
		$sqlASL2 = $this->createEmptyJSLeadQueryViaJobSubCategory();
		$sqlMergeCustom = $this->getMergeOrderSelect();
		$sqlMergeASL1 = $this->getMergeASLSelect();
		$sqlMergeASL2 = $this->getMergeASLSelectViaJobSubCategory();
		
		$sqlCustom->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlASL1->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlASL2->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeCustom->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeASL1->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeASL2->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		
		$this->executeSQL($sqlCustom, $sqlASL1, $sqlASL2, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2, $admin_id, $service_type, $order_status);
		$count = $db->fetchRow("SELECT FOUND_ROWS() AS count");
		return $count["count"];
	}
	
	private function getClosedOrderCounts($admin_id, $order_status, $service_type, $date_from, $date_to){
		$db = $this->db;	
			
		$sqlCustom = $this->createSelect();
		$sqlASL1 = $this->createEmptyJSLeadQuery();
		$sqlASL2 = $this->createEmptyJSLeadQueryViaJobSubCategory();
		$sqlMergeCustom = $this->getMergeOrderSelect();
		$sqlMergeASL1 = $this->getMergeASLSelect();
		$sqlMergeASL2 = $this->getMergeASLSelectViaJobSubCategory();
		
		
		$sqlCustom->having("DATE(date_closed) >= DATE(?)", $date_from);
		$sqlCustom->having("DATE(date_closed) <= DATE(?)", $date_to);
		$sqlASL1->having("DATE(date_closed) >= DATE(?)", $date_from);
		$sqlASL1->having("DATE(date_closed) <= DATE(?)", $date_to);
		$sqlASL2->having("DATE(date_closed) >= DATE(?)", $date_from);
		$sqlASL2->having("DATE(date_closed) <= DATE(?)", $date_to);
		$sqlMergeCustom->having("DATE(date_closed) >= DATE(?)", $date_from);
		$sqlMergeCustom->having("DATE(date_closed) <= DATE(?)", $date_to);
		$sqlMergeASL1->having("DATE(date_closed) >= DATE(?)", $date_from);
		$sqlMergeASL1->having("DATE(date_closed) <= DATE(?)", $date_to);
		$sqlMergeASL2->having("DATE(date_closed) >= DATE(?)", $date_from);
		$sqlMergeASL2->having("DATE(date_closed) <= DATE(?)", $date_to);
		
		$this->executeSQL($sqlCustom, $sqlASL1, $sqlASL2, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2, $admin_id, $service_type, $order_status);
		$count = $db->fetchRow("SELECT FOUND_ROWS() AS count");
		return $count["count"];
	}
	
	
	
	private function getOrderCounts($admin_id, $order_status, $service_type, $date_from, $date_to){
		$db = $this->db;	
			
		$sqlCustom = $this->createSelect();
		$sqlASL1 = $this->createEmptyJSLeadQuery();
		$sqlASL2 = $this->createEmptyJSLeadQueryViaJobSubCategory();
		$sqlMergeCustom = $this->getMergeOrderSelect();
		$sqlMergeASL1 = $this->getMergeASLSelect();
		$sqlMergeASL2 = $this->getMergeASLSelectViaJobSubCategory();
		
		
		$sqlCustom->having("DATE(date_filled_up) >= DATE(?)", $date_from);
		$sqlCustom->having("DATE(date_filled_up) <= DATE(?)", $date_to);
		$sqlASL1->having("DATE(date_filled_up) >= DATE(?)", $date_from);
		$sqlASL1->having("DATE(date_filled_up) <= DATE(?)", $date_to);
		$sqlASL2->having("DATE(date_filled_up) >= DATE(?)", $date_from);
		$sqlASL2->having("DATE(date_filled_up) <= DATE(?)", $date_to);
		$sqlMergeCustom->having("DATE(date_filled_up) >= DATE(?)", $date_from);
		$sqlMergeCustom->having("DATE(date_filled_up) <= DATE(?)", $date_to);
		$sqlMergeASL1->having("DATE(date_filled_up) >= DATE(?)", $date_from);
		$sqlMergeASL1->having("DATE(date_filled_up) <= DATE(?)", $date_to);
		$sqlMergeASL2->having("DATE(date_filled_up) >= DATE(?)", $date_from);
		$sqlMergeASL2->having("DATE(date_filled_up) <= DATE(?)", $date_to);
		
		$this->executeSQL($sqlCustom, $sqlASL1, $sqlASL2, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2, $admin_id, $service_type, $order_status);
		$count = $db->fetchRow("SELECT FOUND_ROWS() AS count");
		return $count["count"];
	}
	
	private function attachHavingOnClientStaffSearch($sql, $order_status, $service_type){
		if ($order_status!=-1){
			if ($order_status == 0){
				$sql->having("(status IN ('new', 'active', 'OPEN', 'Open', '') OR status IS NULL)");
			}else if ($order_status==1){
				$sql->having("status IN ('finish', 'Closed')");
			}else if ($order_status==2){
				$sql->having("status IN ('cancel', 'Cancel')");
			}else if ($order_status==3){
				$sql->having("status IN ('onhold', 'OnHold')");
			}else if ($order_status==4){
				$sql->having("status IN ('ontrial', 'OnTrial')");
			}
		}
		
		if ($service_type!=0){
			$value = "";
			if ( $service_type== 1){
				$value="CUSTOM";
			}else if ( $service_type==2){
				$value="ASL";
			}else if ( $service_type==3){
				$value="BACK ORDER";
			}else if ( $service_type==4){
				$value="REPLACEMENT";
			}else if ( $service_type==5){
				$value="INHOUSE";
			}
			$sql->having("service_type = '{$value}'");
		}

	}
	
	
	private function getAllTodayOpenCounts($service_type){
		$db = $this->db;		
		$sqlCustom = $this->createSelect();
		$sqlASL1 = $this->createEmptyJSLeadQuery();
		$sqlASL2 = $this->createEmptyJSLeadQueryViaJobSubCategory();
		$sqlMergeCustom = $this->getMergeOrderSelect();
		$sqlMergeASL1 = $this->getMergeASLSelect();
		$sqlMergeASL2 = $this->getMergeASLSelectViaJobSubCategory();
		$sqlCustom->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlASL1->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlASL2->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeCustom->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeASL1->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeASL2->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$this->executeSQL($sqlCustom, $sqlASL1, $sqlASL2, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2, "", $service_type, 0);
		$count = $db->fetchRow("SELECT FOUND_ROWS() AS count");
		return $count["count"];
	}
	private function getAllOpenOrder15daysCounts($service_type){
		$db = $this->db;		
		$sqlCustom = $this->createSelect();
		$sqlASL1 = $this->createEmptyJSLeadQuery();
		$sqlASL2 = $this->createEmptyJSLeadQueryViaJobSubCategory();
		$sqlMergeCustom = $this->getMergeOrderSelect();
		$sqlMergeASL1 = $this->getMergeASLSelect();
		$sqlMergeASL2 = $this->getMergeASLSelectViaJobSubCategory();
		$sqlCustom->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlASL1->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlASL2->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeCustom->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeASL1->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		$sqlMergeASL2->having("DATE(date_filled_up) <= ?", date("Y-m-d"));
		
		
		$sqlCustom->having("DATE(date_filled_up) >= ?", date("Y-m-d", strtotime("-15 day", strtotime(date("Y-m-d")))));
		$sqlASL1->having("DATE(date_filled_up) >= ?", date("Y-m-d", strtotime("-15 day", strtotime(date("Y-m-d")))));
		$sqlASL2->having("DATE(date_filled_up) >= ?", date("Y-m-d", strtotime("-15 day", strtotime(date("Y-m-d")))));
		$sqlMergeCustom->having("DATE(date_filled_up) >= ?", date("Y-m-d", strtotime("-15 day", strtotime(date("Y-m-d")))));
		$sqlMergeASL1->having("DATE(date_filled_up) >= ?", date("Y-m-d", strtotime("-15 day", strtotime(date("Y-m-d")))));
		$sqlMergeASL2->having("DATE(date_filled_up) >= ?", date("Y-m-d", strtotime("-15 day", strtotime(date("Y-m-d")))));
		$this->executeSQL($sqlCustom, $sqlASL1, $sqlASL2, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2, "", $service_type, 0);
		$count = $db->fetchRow("SELECT FOUND_ROWS() AS count");
		return $count["count"];
	}
	
	
	
	public function getTodayOpenCountersDashboard(){
		$data = array();
		$data["asl"] = $this->getAllTodayOpenCounts(2);
		$data["custom"] = $this->getAllTodayOpenCounts(1);
		$data["backorder"] = $this->getAllTodayOpenCounts(3);
		$data["replacement"] = $this->getAllTodayOpenCounts(4);
		$data["inhouse"] = $this->getAllTodayOpenCounts(5);
		return $data;
	}
	
	
	public function getOpenOrder15daysCounts(){
		$data = array();
		$data["asl"] = $this->getAllOpenOrder15daysCounts(2);
		$data["custom"] = $this->getAllOpenOrder15daysCounts(1);
		$data["backorder"] = $this->getAllOpenOrder15daysCounts(3);
		$data["replacement"] = $this->getAllOpenOrder15daysCounts(4);
		$data["inhouse"] = $this->getAllOpenOrder15daysCounts(5);
		return $data;
		
	}
	
	public function getTodaysOpenCounters(){
		$hiringManagers = $this->getHiringCoordinators();
		$result = array();
		$data = array();
		$this->order_status = 0;
		$this->filter_type = 3;
		$data["asl"] = $this->getTodayCount("nohm", $this->order_status, 2);
		$data["custom"] = $this->getTodayCount("nohm", $this->order_status, 1);
		$data["backorder"] = $this->getTodayCount("nohm", $this->order_status, 3);
		$data["replacement"] = $this->getTodayCount("nohm", $this->order_status, 4);
		$data["inhouse"] = $this->getTodayCount("nohm", $this->order_status, 5);
		$data["manager_id"] = 0;
		$data["total"] = $data["asl"]+$data["custom"]+$data["replacement"]+$data["inhouse"]+$data["backorder"];
		$result[] = $data;
		foreach($hiringManagers as $manager){	
			$data = array();
			$data["asl"] = $this->getTodayCount($manager["admin_id"], $this->order_status,2);
			$data["custom"] = $this->getTodayCount($manager["admin_id"], $this->order_status,1);
			$data["backorder"] = $this->getTodayCount($manager["admin_id"], $this->order_status,3);
			$data["replacement"] = $this->getTodayCount($manager["admin_id"], $this->order_status,4);
			$data["inhouse"] = $this->getTodayCount($manager["admin_id"], $this->order_status,5);
			$data["manager_id"] = $manager["admin_id"];
			$data["total"] = $data["asl"]+$data["custom"]+$data["replacement"]+$data["inhouse"]+$data["backorder"];
			$result[] = $data;
		}
		$response = array("success"=>true, "dataLoaded"=>$result);
		return $response;
	}
	
	public function getClosedOrderStatusCounters(){
		$hiringManagers = $this->getHiringCoordinators();
		$result = array();
		$data = array();
		$data["asl"] = $this->getClosedOrderCounts("nohm", $this->order_status, 2, $this->dateFrom, $this->dateTo);
		$data["custom"] = $this->getClosedOrderCounts("nohm", $this->order_status, 1, $this->dateFrom, $this->dateTo);
		$data["backorder"] = $this->getClosedOrderCounts("nohm", $this->order_status, 3, $this->dateFrom, $this->dateTo);
		$data["replacement"] = $this->getClosedOrderCounts("nohm", $this->order_status, 4, $this->dateFrom, $this->dateTo);
		$data["inhouse"] = $this->getClosedOrderCounts("nohm", $this->order_status, 5, $this->dateFrom, $this->dateTo);		
		$data["manager_id"] = 0;
		$data["total"] = $data["asl"]+$data["custom"]+$data["replacement"]+$data["inhouse"]+$data["backorder"];
			
		$result[] = $data;
								 												 
		foreach($hiringManagers as $manager){	
			$data = array();
			$data["asl"] = $this->getClosedOrderCounts($manager["admin_id"], $this->order_status, 2, $this->dateFrom, $this->dateTo);
			$data["custom"] = $this->getClosedOrderCounts($manager["admin_id"], $this->order_status, 1, $this->dateFrom, $this->dateTo);
			$data["backorder"] =$this->getClosedOrderCounts($manager["admin_id"], $this->order_status, 3, $this->dateFrom, $this->dateTo);
			$data["replacement"] =$this->getClosedOrderCounts($manager["admin_id"], $this->order_status, 4, $this->dateFrom, $this->dateTo);
			$data["inhouse"] = $this->getClosedOrderCounts($manager["admin_id"], $this->order_status, 5, $this->dateFrom, $this->dateTo);		
			$data["total"] = $data["asl"]+$data["custom"]+$data["replacement"]+$data["inhouse"]+$data["backorder"];
			$data["manager_id"] = $manager["admin_id"];
			$result[] = $data;
											  
		}
		$response = array("success"=>true, "dataLoaded"=>$result);
		return $response;
	}
	
	public function getOrderStatusCounters(){
		$hiringManagers = $this->getHiringCoordinators();
		$result = array();
		$data = array();
		$data["asl"] = $this->getOrderCounts("nohm", $this->order_status, 2, $this->dateFrom, $this->dateTo);
		$data["custom"] = $this->getOrderCounts("nohm", $this->order_status, 1, $this->dateFrom, $this->dateTo);
		$data["backorder"] = $this->getOrderCounts("nohm", $this->order_status, 3, $this->dateFrom, $this->dateTo);
		$data["replacement"] = $this->getOrderCounts("nohm", $this->order_status, 4, $this->dateFrom, $this->dateTo);
		$data["inhouse"] = $this->getOrderCounts("nohm", $this->order_status, 5, $this->dateFrom, $this->dateTo);		
		$data["manager_id"] = 0;
		$data["total"] = $data["asl"]+$data["custom"]+$data["replacement"]+$data["inhouse"]+$data["backorder"];
			
		$result[] = $data;
								 												 
		foreach($hiringManagers as $manager){	
			$data = array();
			$data["asl"] = $this->getOrderCounts($manager["admin_id"], $this->order_status, 2, $this->dateFrom, $this->dateTo);
			$data["custom"] = $this->getOrderCounts($manager["admin_id"], $this->order_status, 1, $this->dateFrom, $this->dateTo);
			$data["backorder"] = $this->getOrderCounts($manager["admin_id"], $this->order_status, 3, $this->dateFrom, $this->dateTo);
			$data["replacement"] = $this->getOrderCounts($manager["admin_id"], $this->order_status, 4, $this->dateFrom, $this->dateTo);
			$data["inhouse"] = $this->getOrderCounts($manager["admin_id"], $this->order_status, 5, $this->dateFrom, $this->dateTo);		
			$data["total"] = $data["asl"]+$data["custom"]+$data["replacement"]+$data["inhouse"]+$data["backorder"];
			$data["manager_id"] = $manager["admin_id"];
			$result[] = $data;
											  
		}
		$response = array("success"=>true, "dataLoaded"=>$result);
		return $response;
	}
	
	private function getHiringCoordinators(){
		$db = $this->db;
		$select = "SELECT admin_id FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select);
	}
	
	
	public function createEmptyJSLeadQueryViaJobSubCategory($excludeMerge=true){
		$db = $this->db;

		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'ASL' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				try{
					$lead = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("leads_id"))->where("tbr.session_id = {$item["link_id"]}"));
					$lead = $lead["leads_id"];
						
					$requests = $db->fetchAll($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $lead)
					->where("DATE(tbr.date_added) = DATE('{$item["date_added"]}')")
					->where("tbr.job_sub_category_applicants_id = {$item["jsca_id"]} OR jsca.sub_category_id = {$item["jsca_id"]}"));

					foreach($requests as $request){
						$result[] = $request["id"];
					}
				}catch(Exception $e){
						
				}
			}
			if (!empty($result)){
				$result = implode(",", $result);
			}else{
				$result="";
			}
		}
		
		//load all merge orders that are asl for exclusion
		if ($excludeMerge){
			$merged_orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("jsca_id", "date_added", "lead_id"))->where("service_type = 'ASL'"));
			$merge_order_ids = array();
			if (!empty($merged_orders)){
				
				foreach($merged_orders as $merged_order){
					try{
						$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
							->where("tbr.job_sub_category_applicants_id = ?", $merged_order["jsca_id"])
							->where("tbr.leads_id = ?", $merged_order["lead_id"])
							->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
						$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
								->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
								->where("jsca.sub_category_id = ?", $merged_order["jsca_id"])
								->where("tbr.leads_id = ?", $merged_order["lead_id"])
								->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
						$requests = $db->fetchAll($db->select()->union(array($sql2, $sql1)));
						foreach($requests as $request){
							$merge_order_ids[] = $request["id"];
						}
					}catch(Exception $e){
						try{
							$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
							->where("tbr.job_sub_category_applicants_id = ?", $merged_order["jsca_id"])
							->where("tbr.leads_id = ?", $merged_order["lead_id"])
							->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
							$requests = $db->fetchAll($sql1);
							foreach($requests as $request){
								$merge_order_ids[] = $request["id"];
							}
						}catch(Exception $e){
							
						}
						try{
							$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
								->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
								->where("jsca.sub_category_id = ?", $merged_order["jsca_id"])
								->where("tbr.leads_id = ?", $merged_order["lead_id"])
								->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
							$requests = $db->fetchAll($sql2);
							foreach($requests as $request){
								$merge_order_ids[] = $request["id"];
							}
						}catch(Exception $e){
							
						}
					}	
					
				}
				$merge_order_ids = implode(",", $merge_order_ids);
			}
		}
		
		
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "leads_id" ,"jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));
		$sql = $db->select()
		->from(array("tbr"=>"tb_request_for_interview"),
		array())
		->joinInner(array("l"=>"leads"),
							"tbr.leads_id = l.id",
		array("l.id AS leads_id")
		)
		->joinLeft(array("adm"=>"admin"), "adm.admin_id = l.hiring_coordinator_id", array())
		->joinInner(array("jsca"=>"job_sub_category_applicants"),
								"jsca.id = tbr.job_sub_category_applicants_id",
		array()
		)
			
		->joinLeft(array("rfos"=>"request_for_interview_job_order_session"),
								new Zend_Db_Expr("rfos.job_sub_category_applicants_id = jsca.sub_category_id AND DATE(rfos.date_added) = DATE(tbr.date_added) AND rfos.lead_id = tbr.leads_id"),
		array("CONCAT('') AS gs_job_titles_details_id",
									
			new Zend_Db_Expr("CASE WHEN DATE(tbr.date_added) < DATE('2012-02-01') THEN 'finish' ELSE CASE WHEN rfos.status IS NULL AND tbr.status='CANCELLED' THEN 'cancel' ELSE rfos.status END END AS status"),
			new Zend_Db_Expr("tbr.date_added AS date_filled_up"),
			"CONCAT('') AS gs_job_role_selection_id",
			"CONCAT('ASL') AS service_type",
			new Zend_Db_Expr("jsca.sub_category_id AS jsca_id"),
			new Zend_Db_Expr("rfos.date_closed AS date_closed"),
			new Zend_Db_Expr("CONCAT('SINGLE') AS merge_status"),
			new Zend_Db_Expr("CONCAT('') AS merged_order_id"),
			new Zend_Db_Expr("CONCAT('') AS created_reason"),
			new Zend_Db_Expr("CONCAT(DATE_FORMAT(tbr.date_added, '%Y%m%d'), jsca.sub_category_id, tbr.leads_id, '-ASL') AS tracking_code")
		))
		->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
		->where("tbr.service_type = 'ASL'")
		->where("tbr.status <> 'ARCHIVED'")
		->group("tracking_code");
			
		if (!empty($onCustomOrder)){
			$orders = array();
			$ids = array();
			foreach($onCustomOrder as $order){
				try{
					$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("tbr.job_sub_category_applicants_id = ?", $order["jsca_id"]);
					
					$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("jsca.sub_category_id = ?", $order["jsca_id"]);
					
					$requests = $db->fetchAll($db->select()->union(array($sql1, $sql2)));
					foreach($requests as $request){
						$ids[] = $request["id"];
					}
				}catch(Exception $e){
					continue;
				}
					
			}

			if (!empty($ids)){
				$ids = array_unique($ids);
				$ids = implode(",", $ids);
				$sql->where("tbr.id NOT IN ($ids)");
			}
		}
			
		if (!empty($job_orders_exclude)&&$result!=""){
			if ($this->display=="Displayed"||$this->display=="Display"){
				$sql->where("tbr.id NOT IN ($result)");
			}else{
				$sql->where("tbr.id IN ($result)");
			}
		}else{
			if ($this->display=="Deleted"){
				$sql->having("leads_id < 0");
			}
		}
		if ($excludeMerge&&!empty($merged_orders)){
			$sql->where("tbr.id NOT IN($merge_order_ids)");
		}
		$sql->having("leads_id IS NOT NULL");
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		return $sql;
	}
	
	
	public function createEmptyJSLeadQuery($excludeMerge=true){
		$db = $this->db;

		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'ASL' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				try{
					$lead = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("leads_id"))->where("tbr.session_id = {$item["link_id"]}"));
					$lead = $lead["leads_id"];
						
					$requests = $db->fetchAll($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $lead)
					->where("DATE(tbr.date_added) = DATE('{$item["date_added"]}')")
					->where("tbr.job_sub_category_applicants_id = {$item["jsca_id"]} OR jsca.sub_category_id = {$item["jsca_id"]}"));

					foreach($requests as $request){
						$result[] = $request["id"];
					}
				}catch(Exception $e){
						
				}
			}
			if (!empty($result)){
				$result = array_unique($result);
				$result = implode(",", $result);
			}else{
				$result="";
			}
		}
		
		//load all merge orders that are asl for exclusion
		if ($excludeMerge){
			$merged_orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("jsca_id", "date_added", "lead_id"))->where("service_type = 'ASL'"));
			$merge_order_ids = array();
			if (!empty($merged_orders)){
				foreach($merged_orders as $merged_order){
					try{
						$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
							->where("tbr.job_sub_category_applicants_id = ?", $merged_order["jsca_id"])
							->where("tbr.leads_id = ?", $merged_order["lead_id"])
							->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
						$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
								->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
								->where("jsca.sub_category_id = ?", $merged_order["jsca_id"])
								->where("tbr.leads_id = ?", $merged_order["lead_id"])
								->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
						$requests = $db->fetchAll($db->select()->union(array($sql2, $sql1)));
						foreach($requests as $request){
							$merge_order_ids[] = $request["id"];
						}
					}catch(Exception $e){
						//individual fixed trapper
						try{
							$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
								->where("tbr.job_sub_category_applicants_id = ?", $merged_order["jsca_id"])
								->where("tbr.leads_id = ?", $merged_order["lead_id"])
								->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
							$requests = $db->fetchAll($sql1);
							foreach($requests as $request){
								$merge_order_ids[] = $request["id"];
							}	
						}catch(Exception $e){
							
						}
						
						try{
							$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
								->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
								->where("jsca.sub_category_id = ?", $merged_order["jsca_id"])
								->where("tbr.leads_id = ?", $merged_order["lead_id"])
								->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
							$requests = $db->fetchAll($sql2);	
							foreach($requests as $request){
								$merge_order_ids[] = $request["id"];
							}	
						}catch(Exception $e){
							
						}
						
					}
					
				}
				$merge_order_ids = array_unique($merge_order_ids);
				$merge_order_ids = implode(",", $merge_order_ids);
			}
		}
		
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "leads_id" ,"jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));
		$sql = $db->select()
		->from(array("tbr"=>"tb_request_for_interview"),
		array())
		->joinInner(array("l"=>"leads"),
							"tbr.leads_id = l.id",
		array("l.id AS leads_id")			
			
		)->joinLeft(array("adm"=>"admin"), "adm.admin_id = l.hiring_coordinator_id", array())
		->joinLeft(array("jsca"=>"job_sub_category_applicants"),
								"jsca.id = tbr.job_sub_category_applicants_id",
		array()
		)
		->joinLeft(array("agn"=>"agent"),
								"agn.agent_no = l.business_partner_id", 
				array())
		->joinLeft(array("rfos"=>"request_for_interview_job_order_session"),
								new Zend_Db_Expr("(CAST(rfos.job_sub_category_applicants_id AS signed) = CAST(tbr.job_sub_category_applicants_id AS signed) AND DATE(rfos.date_added) = DATE(tbr.date_added) AND (rfos.lead_id = tbr.leads_id))"),
		array("CONCAT('') AS gs_job_titles_details_id",
			    new Zend_Db_Expr("CASE WHEN DATE(tbr.date_added) < DATE('2012-02-01') THEN 'finish' ELSE CASE WHEN rfos.status IS NULL AND tbr.status='CANCELLED' THEN 'cancel' ELSE rfos.status END END AS status"),
			     new Zend_Db_Expr("tbr.date_added AS date_filled_up"),
			    "CONCAT('') AS gs_job_role_selection_id",
				"CONCAT('ASL') AS service_type",
				new Zend_Db_Expr("tbr.job_sub_category_applicants_id AS jsca_id"),
				new Zend_Db_Expr("rfos.date_closed AS date_closed"),
				new Zend_Db_Expr("CONCAT('SINGLE') AS merge_status"),
				new Zend_Db_Expr("CONCAT('') AS merged_order_id"),
				new Zend_Db_Expr("CONCAT('') AS created_reason"),
				new Zend_Db_Expr("CONCAT(DATE_FORMAT(tbr.date_added, '%Y%m%d'), tbr.job_sub_category_applicants_id, tbr.leads_id, '-ASL') AS tracking_code")
			))
			
		->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
		->where("tbr.service_type = 'ASL'")
		->where("tbr.status <> 'ARCHIVED'")
		->where("tbr.job_sub_category_applicants_id = 0")
		//->where("tbr.status NOT IN ('CANCELLED')")
		->group("tracking_code");
			
		if (!empty($onCustomOrder)){
			$orders = array();
			$ids = array();
			foreach($onCustomOrder as $order){
				try{
					$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("tbr.job_sub_category_applicants_id = ?", $order["jsca_id"]);
					
					$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("jsca.sub_category_id = ?", $order["jsca_id"]);
					
					$requests = $db->fetchAll($db->select()->union(array($sql1, $sql2)));
					foreach($requests as $request){
						$ids[] = $request["id"];
					}
				}catch(Exception $e){
					continue;
				}
					
			}

			if (!empty($ids)){
				$ids = array_unique($ids);
				$ids = implode(",", $ids);
				$sql->where("tbr.id NOT IN ($ids)");
			}
		}
			
		if (!empty($job_orders_exclude)&&$result!=""){
			if ($this->display=="Displayed"||$this->display=="Display"){
				$sql->where("tbr.id NOT IN ($result)");
			}else{
				$sql->where("tbr.id IN ($result)");
			}
		}else{
			if ($this->display=="Deleted"){
				$sql->having("leads_id < 0");
			}
		}
		if ($excludeMerge&&!empty($merged_orders)){
			$sql->where("tbr.id NOT IN($merge_order_ids)");
		}
		$sql->having("leads_id IS NOT NULL");
		//$sql->group(array("agn.fname", "l.hiring_coordinator_id", "jsca_id"));
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		return $sql;
	}
	
	
	
	
	
	
	public function createSelect($direction="Right", $first=true, $excludeMerge=true){
		$db = $this->db;
		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'Custom' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				$result[] = $item["link_id"];
			}
			$result = array_unique($result);
			$result = implode(",", $result);
		}

		
		//load all merge orders that are custom for exclusion
		if ($excludeMerge){
			$merged_orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("gs_job_title_details_id"))->where("service_type <> 'ASL'"));
			$merge_order_ids = array();
			if (!empty($merged_orders)){
				foreach($merged_orders as $merged_order){
					$merge_order_ids[] = $merged_order["gs_job_title_details_id"];
				}
				$merge_order_ids = array_unique($merge_order_ids);
				$merge_order_ids = implode(",", $merge_order_ids);
			}
		}
		
		
		$join = "join$direction";

		if ($first){
			$expr = new Zend_Db_Expr("SQL_CALC_FOUND_ROWS l.id AS leads_id");
		}else{
			$expr = new Zend_Db_Expr('l.id AS leads_id');
		}
		
		$sql = $db->select()
		->from(array("l"=>"leads"),
		array($expr))
		->joinLeft(array("adm"=>"admin"), "adm.admin_id = l.hiring_coordinator_id", array())
		->$join(array("gs_jrs"=>"gs_job_role_selection"),
					  		"gs_jrs.leads_id = l.id",
						array()
						)->$join(array("gs_jtd"=>"gs_job_titles_details"),
					 "gs_jtd.gs_job_role_selection_id = gs_jrs.gs_job_role_selection_id",
					 array(
					 		"gs_jtd.gs_job_titles_details_id AS gs_job_titles_details_id",
							new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END) < DATE('2012-02-01') THEN 'finish' ELSE gs_jtd.status END AS status"),
							new Zend_Db_Expr("CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE CASE WHEN gs_jrs.filled_up_date IS NOT NULL THEN DATE_FORMAT(gs_jrs.filled_up_date, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END END AS date_filled_up"),
					 		"gs_jtd.gs_job_role_selection_id AS gs_job_role_selection_id",
							new Zend_Db_Expr("CASE WHEN gs_jrs.session_id IS NULL OR gs_jtd.created_reason = 'Converted-From-ASL' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'Closed-To-Replacement' THEN gs_jtd.service_type ELSE 'ASL' END END AS service_type"),
					 		new Zend_Db_Expr("CASE WHEN gs_jrs.jsca_id IS NOT NULL THEN gs_jrs.jsca_id ELSE CONCAT('') END AS jsca_id"),
						    new Zend_Db_Expr("gs_jtd.date_closed AS date_closed"),
						    new Zend_Db_Expr("CONCAT('SINGLE') AS merge_status"),
						    new Zend_Db_Expr("CONCAT('') AS merged_order_id"),
							new Zend_Db_Expr("gs_jtd.created_reason AS created_reason"),
							new Zend_Db_Expr("CONCAT(gs_jtd.gs_job_titles_details_id, '-', CASE WHEN gs_jrs.session_id IS NULL OR gs_jtd.created_reason = 'Converted-From-ASL' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'Closed-To-Replacement' THEN gs_jtd.service_type ELSE 'ASL' END END) AS tracking_code")
							))
						  ->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
						  ->where("gs_jrs.leads_id <> '' OR gs_jrs.leads_id IS NOT NULL")
						  ->group(array( "gs_jtd.gs_job_titles_details_id"));

		  if (!empty($job_orders_exclude)){
		  	if ($this->display=="Display"){
		  		$sql->where("gs_jtd.gs_job_titles_details_id NOT IN ($result)");
		  	}else{
		  		$sql->where("gs_jtd.gs_job_titles_details_id IN ($result)");
		  	}
		  }else{
		  	if ($this->display=="Deleted"){
		  		$sql->having("leads_id < 0");
		  	}
		  }
		  
		 if (!empty($merged_orders)){
		 	$sql->where("gs_jtd.gs_job_titles_details_id NOT IN ($merge_order_ids)");
		 }
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}
		
		return $sql;
	}
	
	
	


	private function getDeletedCustomOrders(){
		$db = $this->db;
		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'Custom' AND job_orders_status.status = 'Deleted'"));
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				$result[] = $item["link_id"];
			}
			return $result;
		}
		return array();
	}
	
	private function getDeletedASLOrders(){
		$db = $this->db;
		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'ASL' AND job_orders_status.status = 'Deleted'"));
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				$result[] = $item["link_id"];
			}
			return $result;
		}
		return array();
	}
	
	private function getMergeCustomOrders(){
		$db = $this->db;
		$merged_orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("gs_job_title_details_id"))->where("service_type <> 'ASL'"));
		$merge_order_ids = array();
		if (!empty($merged_orders)){
			foreach($merged_orders as $merged_order){
				$merge_order_ids[] = $merged_order["gs_job_title_details_id"];
			}
		}
		return $merge_order_ids;
	}
	
	
	private function getMergeASLOrders(){
		$db = $this->db;
		$merged_orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("jsca_id", "date_added", "lead_id"))->where("service_type = 'ASL'"));
		$merge_order_ids = array();
		if (!empty($merged_orders)){
			foreach($merged_orders as $merged_order){
				$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
						->where("tbr.job_sub_category_applicants_id = ?", $merged_order["jsca_id"])
						->where("tbr.leads_id = ?", $merged_order["lead_id"])
						->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
				$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
						->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
						->where("jsca.sub_category_id = ?", $merged_order["jsca_id"])
						->where("tbr.leads_id = ?", $merged_order["lead_id"])
						->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
				$requests = $db->fetchAll($db->select()->union(array($sql2, $sql1)));
				foreach($requests as $request){
					$merge_order_ids[] = $request["id"];
				}
			}
		}
		return $merge_order_ids;
	}
	
	
	
	public function getMergeOrderSelect(){
		$db = $this->db;
		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'Custom' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				$result[] = $item["link_id"];
			}
			$result = array_unique($result);
			$result = implode(",", $result);
		}
		
		
		$sql = $db->select()->from(array("moi"=>"merged_order_items"),
								array()
							)->joinInner(array("mo"=>"merged_orders"), 
								"mo.id = moi.merged_order_id",
								array()
							)->joinInner(array("gs_jtd"=>"gs_job_titles_details"), 
								 "gs_jtd.gs_job_titles_details_id = moi.gs_job_title_details_id",
								array()
							)->joinInner(array("gs_jrs"=>"gs_job_role_selection"),
								"gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id",
							array())
							->joinInner(array("l"=>"leads"), "l.id = gs_jrs.leads_id", array(
					
								"l.id AS leads_id",
							))
							->joinLeft(array("adm"=>"admin"), "adm.admin_id = l.hiring_coordinator_id", array())
					 		->joinLeft(array("jcl"=>"job_role_cat_list"),
									"jcl.jr_list_id = gs_jtd.jr_list_id",
					 				array(
								  		"gs_jtd.gs_job_titles_details_id AS gs_job_titles_details_id",
										new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END) < DATE('2012-02-01') THEN 'Closed' ELSE mo.order_status END AS status"),
										new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END AS date_filled_up"),
								 		"gs_jtd.gs_job_role_selection_id AS gs_job_role_selection_id",
										new Zend_Db_Expr("mo.service_type AS service_type"),
								 		new Zend_Db_Expr("CASE WHEN gs_jrs.jsca_id IS NOT NULL THEN gs_jrs.jsca_id ELSE CONCAT('') END AS jsca_id"),
								  		new Zend_Db_Expr("mo.date_closed AS date_closed"),
							 			new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
							 			new Zend_Db_Expr("mo.id AS merged_order_id"),
						 				new Zend_Db_Expr("gs_jtd.created_reason AS created_reason"),
						 				new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code")
						 				
							 
						  ))
						  ->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
						  ->where("moi.basis = 1")
						  ->where("moi.service_type <> 'ASL'");
						  
		if (!empty($job_orders_exclude)){
		  	if ($this->display=="Display"){
		  		$sql->where("gs_jtd.gs_job_titles_details_id NOT IN ($result)");
		  	}else{
		  		$sql->where("gs_jtd.gs_job_titles_details_id IN ($result)");
		  	}
		  }else{
		  	if ($this->display=="Deleted"){
		  		$sql->having("leads_id < 0");
		  	}
		}
		
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}
		$sql->group("gs_jtd.gs_job_titles_details_id");
		return $sql;
							
	}
	
	public function getMergeASLSelect(){
		$db = $this->db;

		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'ASL' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				try{
					$lead = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("leads_id"))->where("tbr.session_id = {$item["link_id"]}"));
					$lead = $lead["leads_id"];
						
					$requests = $db->fetchAll($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $lead)
					->where("DATE(tbr.date_added) = DATE('{$item["date_added"]}')")
					->where("tbr.job_sub_category_applicants_id = {$item["jsca_id"]} OR jsca.sub_category_id = {$item["jsca_id"]}"));

					foreach($requests as $request){
						$result[] = $request["id"];
					}
				}catch(Exception $e){
						
				}
			}
			if (!empty($result)){
				$result = array_unique($result);
				$result = implode(",", $result);
			}else{
				$result="";
			}
		}
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));
		$sql = $db->select()->from(array("moi"=>"merged_order_items"), array())
						->joinInner(array("mo"=>"merged_orders"), "mo.id = moi.merged_order_id", array())
						->joinInner(array("tbr"=>"tb_request_for_interview"), "moi.jsca_id = tbr.job_sub_category_applicants_id AND DATE(moi.date_added) = DATE(tbr.date_added) AND (moi.lead_id = tbr.leads_id)",array())
						->joinInner(array("l"=>"leads"),"tbr.leads_id = l.id",
									array(
									 "l.id AS leads_id"))
						->joinLeft(array("adm"=>"admin"), "adm.admin_id = l.hiring_coordinator_id", array())
						->joinLeft(array("agn"=>"agent"), "agn.agent_no = l.business_partner_id",array(
							 new Zend_Db_Expr("CONCAT('') AS gs_job_titles_details_id"),
							new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END) < DATE('2012-02-01') THEN 'Closed' ELSE CASE WHEN mo.order_status IS NULL AND tbr.status = 'CANCELLED' THEN 'Cancel' ELSE mo.order_status END END AS status"),
							 new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END AS date_filled_up"),
						  		 "CONCAT('') AS gs_job_role_selection_id",
						  		 "mo.service_type AS service_type",
						     new Zend_Db_Expr("tbr.job_sub_category_applicants_id AS jsca_id"),
							 new Zend_Db_Expr("mo.date_closed AS date_closed"),
							 new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
							 new Zend_Db_Expr("mo.id AS merged_order_id"),
						 	new Zend_Db_Expr("CONCAT('') AS created_reason"),
						 	new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code")
						))
					  ->where("moi.basis = 1")
					  ->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
					 ->where("mo.service_type = 'ASL'")
					 ->where("tbr.service_type = 'ASL'")
					 ->where("tbr.status <> 'ARCHIVED'")
					 ->group("merged_order_id");//->where("tbr.status NOT IN ('CANCELLED')");
		
		if (!empty($onCustomOrder)){
			$orders = array();
			$ids = array();
			foreach($onCustomOrder as $order){
				try{
					$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->where("tbr.session_id = ?", $order["session_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("tbr.job_sub_category_applicants_id = ?", $order["jsca_id"]);
					
					$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
					->where("tbr.session_id = ?", $order["session_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("jsca.sub_category_id = ?", $order["jsca_id"]);
					
					$requests = $db->fetchAll($db->select()->union(array($sql1, $sql2)));
					foreach($requests as $request){
						$ids[] = $request["id"];
					}
				}catch(Exception $e){
					continue;
				}
					
			}
			if (!empty($ids)){
				$ids = implode(",", $ids);
				$sql = $sql->where("tbr.id NOT IN ($ids)");
			}
			
		}

		
		//load merge order with details
		$mergeCustoms  = $db->fetchAll($db->select()->from("merged_order_items", array("merged_order_id"))->where("basis = 1")->where("service_type <> 'ASL'"));
		$mergeIds = array();
		foreach($mergeCustoms as $mergeCustom){
			$mergeIds[] = $mergeCustom["merged_order_id"];
		}
		if (!empty($mergeIds)){
			$mergeIds = array_unique($mergeIds);
			$sql->where("moi.merged_order_id NOT IN (".implode(",", $mergeIds).")");
		}
		
		if (!empty($job_orders_exclude)&&$result!=""){
			if ($this->display=="Displayed"||$this->display=="Display"){
				$sql = $sql->where("tbr.id NOT IN ($result)");
			}else{
				$sql = $sql->where("tbr.id IN ($result)");
			}
		}else{
			if ($this->display=="Deleted"){
				$sql->having("leads_id < 0");
			}
		}
		$sql->having("leads_id IS NOT NULL");
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		
		return $sql;
	}
	
	
	
	public function getMergeASLSelectViaJobSubCategory(){
		$db = $this->db;

		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'ASL' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				try{
					$lead = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("leads_id"))->where("tbr.session_id = {$item["link_id"]}"));
					$lead = $lead["leads_id"];
						
					$requests = $db->fetchAll($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $lead)
					->where("DATE(tbr.date_added) = DATE('{$item["date_added"]}')")
					->where("tbr.job_sub_category_applicants_id = {$item["jsca_id"]} OR jsca.sub_category_id = {$item["jsca_id"]}"));

					foreach($requests as $request){
						$result[] = $request["id"];
					}
				}catch(Exception $e){
						
				}
			}
			if (!empty($result)){
				$result = array_unique($result);
				$result = implode(",", $result);
			}else{
				$result="";
			}
		}
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "leads_id" ,"jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));

		$sql = $db->select()->from(array("moi"=>"merged_order_items"), array())
						->joinInner(array("mo"=>"merged_orders"), "mo.id = moi.merged_order_id", array())
						->joinInner(array("tbr"=>"tb_request_for_interview"), "DATE(moi.date_added) = DATE(tbr.date_added) AND (moi.lead_id = tbr.leads_id)",array())
						->joinInner(array("jsca"=>"job_sub_category_applicants"),"jsca.sub_category_id = moi.jsca_id",array())
						->joinInner(array("l"=>"leads"),"tbr.leads_id = l.id",
									array(
									 "l.id AS leads_id"))
						->joinLeft(array("adm"=>"admin"), "adm.admin_id = l.hiring_coordinator_id", array())
						->joinLeft(array("agn"=>"agent"), "agn.agent_no = l.business_partner_id",array(
							 new Zend_Db_Expr("CONCAT('') AS gs_job_titles_details_id"),
							 new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END) THEN 'Closed' ELSE CASE WHEN mo.order_status IS NULL AND tbr.status = 'CANCELLED' THEN 'Cancel' ELSE mo.order_status END END AS status"),
							 new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END AS date_filled_up"),
							 	 "CONCAT('') AS gs_job_role_selection_id",
						  		 "mo.service_type AS service_type",
						  		 new Zend_Db_Expr("tbr.job_sub_category_applicants_id AS jsca_id"),
							 new Zend_Db_Expr("mo.date_closed AS date_closed"),
							 new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
							 new Zend_Db_Expr("mo.id AS merged_order_id"),
							 new Zend_Db_Expr("CONCAT('') AS created_reason"),
							 new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code")
							 
						))
						->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
					  ->where("moi.basis = 1")
					 ->where("mo.service_type = 'ASL'")
					 ->where("tbr.service_type = 'ASL'")		 
					 ->where("tbr.status <> 'ARCHIVED'")
					 ->group("merged_order_id");
					 //->where("tbr.status NOT IN ('CANCELLED')");
		
		
		if (!empty($onCustomOrder)){
			$orders = array();
			$ids = array();
			foreach($onCustomOrder as $order){
				try{
					$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("tbr.job_sub_category_applicants_id = ?", $order["jsca_id"]);
					
					$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("jsca.sub_category_id = ?", $order["jsca_id"]);
					
					$requests = $db->fetchAll($db->select()->union(array($sql1, $sql2)));
					foreach($requests as $request){
						$ids[] = $request["id"];
					}
				}catch(Exception $e){
					continue;
				}
					
			}

			if (!empty($ids)){
				$ids = array_unique($ids);
				$ids = implode(",", $ids);
				$sql = $sql->where("tbr.id NOT IN ($ids)");
			}
			
		
		}
		
		
		//load merge order with details
		
	
		$mergeCustoms  = $db->fetchAll($db->select()->from("merged_order_items", array("merged_order_id"))->where("basis = 1")->where("service_type <> 'ASL'"));
		$mergeIds = array();
		foreach($mergeCustoms as $mergeCustom){
			$mergeIds[] = $mergeCustom["merged_order_id"];
		}
		if (!empty($mergeIds)){
			$mergeIds = array_unique($mergeIds);
			$sql->where("moi.merged_order_id NOT IN (".implode(",", $mergeIds).")");
		}
			
		if (!empty($job_orders_exclude)&&$result!=""){
			if ($this->display=="Displayed"||$this->display=="Display"){
				$sql = $sql->where("tbr.id NOT IN ($result)");
			}else{
				$sql = $sql->where("tbr.id IN ($result)");
			}
		}else{
			if ($this->display=="Deleted"){
				$sql->having("leads_id < 0");
			}
		}
		$sql = $sql->having("leads_id IS NOT NULL");
		
		
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		
		return $sql;
	}
	
	
	
	
	
	
	private function getASLFilledOrders(){
		$db = $this->db;
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));
		return $onCustomOrder;
	}

}