<?php
class JobOrderCounter{
	private $db;
	private $posting;
	private $inhouse_staff;
	private $dateFrom = "";
	private $dateTo = "";
	private $order_status="";
	private $display = "Display";
	private $filter_type;
	
	public function __construct($db){
		$this->db = $db;
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
		if($_REQUEST['inhouse_staff']) {
			$this->inhouse_staff = $_REQUEST["inhouse_staff"];
			}
		
		
	}
	private function getClosedOrderCounts($admin_id, $order_status, $service_type, $date_from, $date_to){
		try{
			$filter = array();
			$filter["deleted"] = array('$nin'=>array(true));
			if ($admin_id=="nohm"){
				$filter["assigned_hiring_coordinator_id"] = null;
			}else{
				if ($admin_id){
					$filter["assigned_hiring_coordinator_id"] = intval($admin_id);
					
				}
			}

			
			if ($service_type!=0){
				$value = "";
				if ($service_type == 1){
					$value="CUSTOM";
				}else if ($service_type==2){
					$value="ASL";
				}else if ($service_type==3){
					$value="BACK ORDER";
				}else if ($service_type==4){
					$value="REPLACEMENT";
				}else if ($service_type==5){
					$value="INHOUSE";
				}
				if ($value!=""){
					$filter["service_type"] = $value;
				}
			}
		
		
			if ($order_status!=-1){
				if ($order_status == 0){
					$filter["order_status"] = "Open";
				}else if ($order_status==1){
					$filter["order_status"] = "Closed";
				}else if ($order_status==2){
					$filter["order_status"] = "Did not push through";
				}else if ($order_status==3){
					$filter["order_status"] = "On Hold";
				}else if ($order_status==4){
					$filter["order_status"] = "On Trial";
				}
			}
			if($this->inhouse_staff=='no'){
				$filter['leads_id']=array('$nin'=>array(11));
			}
				
			if ($date_from&&$date_to){
				$filter["date_closed"] = array('$lte'=>new MongoDate(strtotime($date_to)), '$gte'=>new MongoDate(strtotime($date_from)));
			}
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
			
			$skip = ($this->page - 1)*$this->rows;
			
			$cursor = $job_orders_collection->find($filter);
			return $cursor->count();
		}catch(Exception $e){
			return 0;
		}
			
	}
	
	private function getTodayCount($admin_id, $order_status, $service_type){
		try{
			$filter = array();
			$filter["deleted"] = array('$nin'=>array(true));
			$date_to = date("Y-m-d");
			$date_to = date("Y-m-d", strtotime($date_to."+1 day"));
			$date_from = "2012-02-01";
			
			if ($admin_id=="nohm"){
				$filter["assigned_hiring_coordinator_id"] = null;
			}else{
				if ($admin_id){
					$filter["assigned_hiring_coordinator_id"] = intval($admin_id);
					
				}
			}
	
			if ($service_type!=0){
				$value = "";
				if ($service_type == 1){
					$value="CUSTOM";
				}else if ($service_type==2){
					$value="ASL";
				}else if ($service_type==3){
					$value="BACK ORDER";
				}else if ($service_type==4){
					$value="REPLACEMENT";
				}else if ($service_type==5){
					$value="INHOUSE";
				}
				if ($value!=""){
					$filter["service_type"] = $value;
				}
			}
		
		
			if ($order_status!=-1){
				if ($order_status == 0){
					$filter["order_status"] = "Open";
				}else if ($order_status==1){
					$filter["order_status"] = "Closed";
				}else if ($order_status==2){
					$filter["order_status"] = "Did not push through";
				}else if ($order_status==3){
					$filter["order_status"] = "On Hold";
				}else if ($order_status==4){
					$filter["order_status"] = "On Trial";
				}
			}
				if($this->inhouse_staff=='no'){
				$filter['leads_id']=array('$nin'=>array(11));
			}
			if ($date_from&&$date_to){
				$filter["date_filled_up"] = array('$lte'=>new MongoDate(strtotime($date_to)), '$gte'=>new MongoDate(strtotime($date_from)));
			}
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
			
			$skip = ($this->page - 1)*$this->rows;
			
			$cursor = $job_orders_collection->find($filter);
			return $cursor->count();
		}catch(Exception $e){
			return 0;
		}
		
	}

	private function get15DayCount($admin_id, $order_status, $service_type){
		try{
			$filter = array();
			$filter["deleted"] = array('$nin'=>array(true));
			$date_to = date("Y-m-d");
			$date_to = date("Y-m-d", strtotime($date_to."+1 day"));
			$date_from = date("Y-m-d", strtotime(date("Y-m-d")."-15 day"));
			
			if ($admin_id=="nohm"){
				$filter["assigned_hiring_coordinator_id"] = null;
			}else{
				if ($admin_id){
					$filter["assigned_hiring_coordinator_id"] = intval($admin_id);
					
				}
			}
			if($this->inhouse_staff=='no'){
				$filter['leads_id']=array('$nin'=>array(11));
			}
			
			if ($service_type!=0){
				$value = "";
				if ($service_type == 1){
					$value="CUSTOM";
				}else if ($service_type==2){
					$value="ASL";
				}else if ($service_type==3){
					$value="BACK ORDER";
				}else if ($service_type==4){
					$value="REPLACEMENT";
				}else if ($service_type==5){
					$value="INHOUSE";
				}
				if ($value!=""){
					$filter["service_type"] = $value;
				}
			}
		
		
			if ($order_status!=-1){
				if ($order_status == 0){
					$filter["order_status"] = "Open";
				}else if ($order_status==1){
					$filter["order_status"] = "Closed";
				}else if ($order_status==2){
					$filter["order_status"] = "Did not push through";
				}else if ($order_status==3){
					$filter["order_status"] = "On Hold";
				}else if ($order_status==4){
					$filter["order_status"] = "On Trial";
				}
			}
				
			if ($date_from&&$date_to){
				$filter["date_filled_up"] = array('$lte'=>new MongoDate(strtotime($date_to)), '$gte'=>new MongoDate(strtotime($date_from)));
			}
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
			
			$skip = ($this->page - 1)*$this->rows;
			
			$cursor = $job_orders_collection->find($filter);
			return $cursor->count();
		}catch(Exception $e){
			return 0;
		}
		
	}
	

	private function getHiringCoordinators(){
		$db = $this->db;
		$select = "SELECT admin_id FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select);
	}
	
	
	
	private function getOrderCounts($admin_id, $order_status, $service_type, $date_from, $date_to){
		try{
			$filter = array();
			$filter["deleted"] = array('$nin'=>array(true));
			if ($admin_id=="nohm"){
				$filter["assigned_hiring_coordinator_id"] = null;
			}else{
				if ($admin_id){
					$filter["assigned_hiring_coordinator_id"] = intval($admin_id);
					
				}
			}
			if($this->inhouse_staff=='no'){
				$filter['leads_id']=array('$nin'=>array(11));
			}
			if ($service_type!=0){
				$value = "";
				if ($service_type == 1){
					$value="CUSTOM";
				}else if ($service_type==2){
					$value="ASL";
				}else if ($service_type==3){
					$value="BACK ORDER";
				}else if ($service_type==4){
					$value="REPLACEMENT";
				}else if ($service_type==5){
					$value="INHOUSE";
				}
				if ($value!=""){
					$filter["service_type"] = $value;
				}
			}
		
			
			if ($order_status!=-1){
				if ($order_status == 0){
					$filter["order_status"] = array('$in'=>array("Open", "", null));
				}else if ($order_status==1){
					$filter["order_status"] = "Closed";
				}else if ($order_status==2){
					$filter["order_status"] = "Did not push through";
				}else if ($order_status==3){
					$filter["order_status"] = "On Hold";
				}else if ($order_status==4){
					$filter["order_status"] = "On Trial";
				}
			}
			
			if ($date_from&&$date_to){
				$date_to = date("Y-m-d", strtotime($date_to."+1 day"));
				$filter["date_filled_up"] = array('$lte'=>new MongoDate(strtotime($date_to)), '$gte'=>new MongoDate(strtotime($date_from)));
			}
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
			
			$skip = ($this->page - 1)*$this->rows;
			
			$cursor = $job_orders_collection->find($filter);
			return $cursor->count();
		}catch(Exception $e){
			return 0;
		}
			
	}
	
	
	public function getLast15Days(){
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

	public function get15DaysOpenCounters(){
		$hiringManagers = $this->getHiringCoordinators();
		$result = array();
		$data = array();
		$this->order_status = 0;
		$this->filter_type = 3;
		$data["asl"] = $this->get15DayCount("nohm", $this->order_status, 2);
		$data["custom"] = $this->get15DayCount("nohm", $this->order_status, 1);
		$data["backorder"] = $this->get15DayCount("nohm", $this->order_status, 3);
		$data["replacement"] = $this->get15DayCount("nohm", $this->order_status, 4);
		$data["inhouse"] = $this->get15DayCount("nohm", $this->order_status, 5);
		$data["manager_id"] = 0;
		$data["total"] = $data["asl"]+$data["custom"]+$data["replacement"]+$data["inhouse"]+$data["backorder"];
		$result[] = $data;
		foreach($hiringManagers as $manager){	
			$data = array();
			$data["asl"] = $this->get15DayCount($manager["admin_id"], $this->order_status,2);
			$data["custom"] = $this->get15DayCount($manager["admin_id"], $this->order_status,1);
			$data["backorder"] = $this->get15DayCount($manager["admin_id"], $this->order_status,3);
			$data["replacement"] = $this->get15DayCount($manager["admin_id"], $this->order_status,4);
			$data["inhouse"] = $this->get15DayCount($manager["admin_id"], $this->order_status,5);
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
	public function get15DaySummaryView(){
		$db = $this->db;
		$openOrders = $this->get15DaysOpenCounters();
		$totalOpenOrders = array();
		$totalOpenOrderSum = 0;
		$totalCustom = 0;
		$totalASL = 0;
		$totalBackOrder = 0;
		$totalReplacement = 0;
		$totalInhouse = 0;
		foreach($openOrders["dataLoaded"] as $result){
			
			$admin = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_lname", "admin_id"))->where("admin_id = ?", $result["manager_id"]));
			$totalOpenOrders[] = array("admin"=>$admin, "total_open"=>$result["total"]);
			$totalOpenOrderSum+=$result["total"];
			$totalCustom+=$result["custom"];
			$totalASL+=$result["asl"];
			$totalBackOrder+=$result["backorder"];
			$totalReplacement+=$result["replacement"];
			$totalInhouse+=$result["inhouse"];
		}
		if ($totalOpenOrderSum==0){
			$totalPercentageCustom = number_format(0, 2);
			$totalPercentageASL = number_format(0, 2);
			$totalPercentageBackOrder = number_format(0, 2);
			$totalPercentageReplacement = number_format(0, 2);
			$totalPercentageInhouse = number_format(0, 2);
		}else{
			$totalPercentageCustom = number_format(($totalCustom/$totalOpenOrderSum)*100, 2);
			$totalPercentageASL = number_format(($totalASL/$totalOpenOrderSum)*100, 2);
			$totalPercentageBackOrder = number_format(($totalBackOrder/$totalOpenOrderSum)*100, 2);
			$totalPercentageReplacement = number_format(($totalReplacement/$totalOpenOrderSum)*100, 2);
			$totalPercentageInhouse = number_format(($totalInhouse/$totalOpenOrderSum)*100, 2);			
		}

		
		return array("totalOpenOrders"=>$totalOpenOrders,
					"totalOpenOrderSum"=>$totalOpenOrderSum,
					 "totalCustom"=>$totalCustom,
					 "totalASL"=>$totalASL, 
					 "totalBackOrder"=>$totalBackOrder, 
					 "totalReplacement"=>$totalReplacement, 
					 "totalInhouse"=>$totalInhouse, 
					 "totalPercentageCustom"=>$totalPercentageCustom,
					 "totalPercentageASL"=>$totalPercentageASL,
					 "totalPercentageBackOrder"=>$totalPercentageBackOrder,
					 "totalPercentageReplacement"=>$totalPercentageReplacement,
					 "totalPercentageInhouse"=>$totalPercentageInhouse);
	}

	
	public function getSummaryView(){
		$db = $this->db;
		$openOrders = $this->getTodaysOpenCounters();
		$totalOpenOrders = array();
		$totalOpenOrderSum = 0;
		$totalCustom = 0;
		$totalASL = 0;
		$totalBackOrder = 0;
		$totalReplacement = 0;
		$totalInhouse = 0;
		foreach($openOrders["dataLoaded"] as $result){
			
			$admin = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_lname", "admin_id"))->where("admin_id = ?", $result["manager_id"]));
			$totalOpenOrders[] = array("admin"=>$admin, "total_open"=>$result["total"]);
			$totalOpenOrderSum+=$result["total"];
			$totalCustom+=$result["custom"];
			$totalASL+=$result["asl"];
			$totalBackOrder+=$result["backorder"];
			$totalReplacement+=$result["replacement"];
			$totalInhouse+=$result["inhouse"];
		}
		$totalPercentageCustom = number_format(($totalCustom/$totalOpenOrderSum)*100, 2);
		$totalPercentageASL = number_format(($totalASL/$totalOpenOrderSum)*100, 2);
		$totalPercentageBackOrder = number_format(($totalBackOrder/$totalOpenOrderSum)*100, 2);
		$totalPercentageReplacement = number_format(($totalReplacement/$totalOpenOrderSum)*100, 2);
		$totalPercentageInhouse = number_format(($totalInhouse/$totalOpenOrderSum)*100, 2);
		
		return array("totalOpenOrders"=>$totalOpenOrders,
					"totalOpenOrderSum"=>$totalOpenOrderSum,
					 "totalCustom"=>$totalCustom,
					 "totalASL"=>$totalASL, 
					 "totalBackOrder"=>$totalBackOrder, 
					 "totalReplacement"=>$totalReplacement, 
					 "totalInhouse"=>$totalInhouse, 
					 "totalPercentageCustom"=>$totalPercentageCustom,
					 "totalPercentageASL"=>$totalPercentageASL,
					 "totalPercentageBackOrder"=>$totalPercentageBackOrder,
					 "totalPercentageReplacement"=>$totalPercentageReplacement,
					 "totalPercentageInhouse"=>$totalPercentageInhouse);
	}
}
