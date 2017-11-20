<?php
require_once dirname(__FILE__)."/JobOrderUtility.php";
require_once dirname(__FILE__)."/JobOrderLoader.php";
require_once dirname(__FILE__)."/GetJobPosting.php";

class JobOrderRecruitmentLoader {
	
	private $db;
	private $date_from; 
	private $date_to;
	private $order_status = "Open";
	private $service_type = "";
	private $shortlist_type = "";
	private $hiring_coordinator;
	private $inhouse_staff;
	private $keyword = "";
	private $rows = 50;
	private $page = 1;
	private $filter = array();
	
	

	public function __construct($db) {
		$this -> db = $db;
		$this -> gatherInput();
	}

	private function gatherInput() {
		
		//DATE FROM AND DATE TO
		if ($_REQUEST["date_from"] && $_REQUEST["date_to"]) {
			$this -> date_from = $_REQUEST["date_from"];
			$this -> date_to = $_REQUEST["date_to"];
		}
		
		//ORDER STATUS
		if (isset($_REQUEST["order_status"])) {
			$this -> order_status = $_REQUEST["order_status"];
		}
		
		//SERVICE TYPE
		if (isset($_REQUEST["service_type"])) {
			$this -> service_type = $_REQUEST["service_type"];
		}
		
		//SHORTLIST TYPE
		if ($_REQUEST["shortlist_type"]){
			$this->shortlist_type = $_REQUEST["shortlist_type"];
		}

		//HIRING MANAGER
		if ($_REQUEST["hiring_coordinator"]) {
			if ($_REQUEST["hiring_coordinator"] == "nohm") {
				$this -> hiring_coordinator = $_REQUEST["hiring_coordinator"];
			} else {
				$this -> hiring_coordinator = intval($_REQUEST["hiring_coordinator"]);

			}
		}
		
		//INHOUSE STAFF
		if($_REQUEST['inhouse_staff']) {
			$this->inhouse_staff = $_REQUEST["inhouse_staff"];
		}
		
		//KEYWORDS
		if ($_REQUEST["keyword"]) {
			$this -> keyword = $_REQUEST["keyword"];
		}

		//PAGE
		if ($_REQUEST["page"]){
			$this->page = intval($_REQUEST["page"]);
		}

	}

	private function setFilter() {
		
		$this -> filter['$and'] = array();
		
		//DATE FROM AND DATE TO
		if ($this -> date_from && $this -> date_to) {
			$this -> filter['$and'][] = array("date_filled_up" => array('$lte' => new MongoDate(strtotime($this -> date_to)), '$gte' => new MongoDate(strtotime($this -> date_from))));
		}
		
		//ORDER STATUS
		if ($this -> order_status) {
			$this -> filter['$and'][] = array("order_status" => $this -> order_status);
		}
		
		//SERVICE TYPE
		if ($this -> service_type) {
			$this -> filter['$and'][] = array("service_type" => $this -> service_type);
		}
		
		//HIRING MANAGER
		if ($this -> hiring_coordinator) {
			if ($this -> hiring_coordinator == "nohm") {
				$this -> filter['$and'][] = array("assigned_hiring_coordinator_id" => null);
			} else {
				$this -> filter['$and'][] = array("assigned_hiring_coordinator_id" => $this -> hiring_coordinator);
			}
		}
		
		//INHOUSE STAFF
		if($this -> inhouse_staff) {
			if( $this -> inhouse_staff == 'no' ) {
				$this -> filter['$and'][] = array("leads_id" =>array('$ne'=>11));
			}
		}
		
		//KEYWORDS
		if ($this -> keyword) {
			$or = array();
			$regex = new MongoRegex("/{$this->keyword}/");
			$or['$or'] = array( array("client" => $regex), array("tracking_code" => $regex), );
			$this -> filter['$and'][] = $or;
		}


		$this->filter['$and'][] = array("posting_id"=>array('$ne'=>null));
		$this->filter['$and'][] = array("deleted"=>array('$nin'=>array(true)));
	}


	public function getList($limit = true) {
		$this -> setFilter();
		$db = $this->db;
		$recruiters = $this->getRecruiters();
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
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}
							

			$job_orders_collection = $database -> selectCollection('job_orders');

			$skip = ($this -> page - 1) * $this -> rows;

			$cursor = $job_orders_collection -> find($this -> filter);
			$totalJobOrders = $cursor -> count();
			$totalPages = (int)ceil($totalJobOrders / $this -> rows);
			
			if ($limit){
				$cursor -> sort(array("date_filled_up" => -1)) -> skip($skip) -> limit($this -> rows);			
			}

			$results = array();
			$util = new JobOrderUtility($this->db);
			while ($cursor -> hasNext()) {
				$listedRecruiters = array();
				foreach($recruiters as $recruiter){
					$listedRecruiters[] = array("admin_id"=>$recruiter["admin_id"]);
				}
				
				$result = $cursor -> getNext();
				$result["date_filled_up"] = date("Y-m-d", $result["date_filled_up"] -> sec);
				$result["date_closed"] = date("Y-m-d", $result["date_closed"] -> sec);
				
				$result["category"] = $util->getCategory($result["posting_id"]);
				$result["job_order_comments_count"] = $util->getJobOrderCommentsCount($result["tracking_code"]);
				
				$assigned_recruiters = array();
				$result["assigned_recruiters"] = array();
				foreach($result["recruiters"] as $rec){
					$assigned_recruiters[] = $rec["recruiters_id"];
					//admin
					$result["assigned_recruiters"][] = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("a.admin_id", "a.admin_fname", "a.admin_lname"))->where("a.admin_id = ?", $rec["recruiters_id"]));
				}
				
				$totalShortlist = 0;
				
				foreach($listedRecruiters as $key=>$recruiter){
					if (in_array(intval($recruiter["admin_id"]), $assigned_recruiters)){
						$listedRecruiters[$key]["count_assigned"] = count($this->getShortlistedStaffs($result["posting_id"], $recruiter["admin_id"]));
						$listedRecruiters[$key]["count_unassigned"] = 0;
					}else{
						$listedRecruiters[$key]["count_assigned"] = 0;	
						$listedRecruiters[$key]["count_unassigned"] = count($this->getShortlistedStaffs($result["posting_id"], $recruiter["admin_id"]));						
					}
					
					if ($this->shortlist_type=="Assigned"){
						$listedRecruiters[$key]["count"] = $listedRecruiters[$key]["count_assigned"];
					}else if ($this->shortlist_type=="Unassigned"){
						$listedRecruiters[$key]["count"] = $listedRecruiters[$key]["count_unassigned"];
					}else{
						$listedRecruiters[$key]["count"] = $listedRecruiters[$key]["count_assigned"]+$listedRecruiters[$key]["count_unassigned"];
					}
					
					$totalShortlist+= $listedRecruiters[$key]["count"];
				}
				
				$result["total_shortlist"] = $totalShortlist;
				$result["all_recruiters"] = $listedRecruiters;
				$results[] = $result;
				
			}
			
			return array("success" => true, "rows" => $results, "records" => $totalJobOrders, "total" => $totalPages, "page" => $this -> page, );
		} catch(MongoConnectionException $e) {
			//handle connection error
			die($e -> getMessage());
		}
	}
	
	
	public function getEndorsedList($limit = true){
		$this -> setFilter();
		$db = $this->db;
		$recruiters = $this->getRecruiters();
		try {
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
				
			$job_orders_collection = $database -> selectCollection('job_orders');

			$skip = ($this -> page - 1) * $this -> rows;

			$cursor = $job_orders_collection -> find($this -> filter);
			$totalJobOrders = $cursor -> count();
			$totalPages = (int)ceil($totalJobOrders / $this -> rows);
			
			if ($limit){
				$cursor -> sort(array("date_filled_up" => -1)) -> skip($skip) -> limit($this -> rows);			
			}

			$results = array();
			$util = new JobOrderUtility($this->db);
			while ($cursor -> hasNext()) {
				$listedRecruiters = array();
				foreach($recruiters as $recruiter){
					$listedRecruiters[] = array("admin_id"=>$recruiter["admin_id"]);
				}
				
				$result = $cursor -> getNext();
				$result["date_filled_up"] = date("Y-m-d", $result["date_filled_up"] -> sec);
				$result["date_closed"] = date("Y-m-d", $result["date_closed"] -> sec);
				
				$result["category"] = $util->getCategory($result["posting_id"]);
				$result["job_order_comments_count"] = $util->getJobOrderCommentsCount($result["tracking_code"]);
				
				$assigned_recruiters = array();
				$result["assigned_recruiters"] = array();
				foreach($result["recruiters"] as $rec){
					$assigned_recruiters[] = $rec["recruiters_id"];
					//admin
					$result["assigned_recruiters"][] = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("a.admin_id", "a.admin_fname", "a.admin_lname"))->where("a.admin_id = ?", $rec["recruiters_id"]));
				}
				
				$totalShortlist = 0;
				
				foreach($listedRecruiters as $key=>$recruiter){
					if (in_array(intval($recruiter["admin_id"]), $assigned_recruiters)){
						$listedRecruiters[$key]["count_assigned"] = count($this->getEndorsedStaffs($result["tracking_code"], $recruiter["admin_id"]));
						$listedRecruiters[$key]["count_unassigned"] = 0;
					}else{
						$listedRecruiters[$key]["count_assigned"] = 0;	
						$listedRecruiters[$key]["count_unassigned"] = count($this->getEndorsedStaffs($result["tracking_code"], $recruiter["admin_id"]));						
					}
					
					if ($this->shortlist_type=="Assigned"){
						$listedRecruiters[$key]["count"] = $listedRecruiters[$key]["count_assigned"];
					}else if ($this->shortlist_type=="Unassigned"){
						$listedRecruiters[$key]["count"] = $listedRecruiters[$key]["count_unassigned"];
					}else{
						$listedRecruiters[$key]["count"] = $listedRecruiters[$key]["count_assigned"]+$listedRecruiters[$key]["count_unassigned"];
					}
					
					$totalShortlist+= $listedRecruiters[$key]["count"];
				}
				
				$result["total_shortlist"] = $totalShortlist;
				$result["all_recruiters"] = $listedRecruiters;
				$results[] = $result;
				
			}

			return array("success" => true, "rows" => $results, "records" => $totalJobOrders, "total" => $totalPages, "page" => $this -> page, );
		} catch(MongoConnectionException $e) {
			//handle connection error
			die($e -> getMessage());
		}
	}
	

	public function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' OR admin_id IN (167,242,236,239))  
			AND status <> 'REMOVED'  AND admin_id <> 161   AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
	public function getShortlistedStaffs($posting_id,$admin_id){
		$db = $this->db;
		$staffs = array();
		if ($posting_id){
			$sql = $db->select()
					   ->from(array("sh"=>"tb_shortlist_history"),
					   		array("sh.userid AS userid", "sh.date_listed AS date"))
					   ->joinInner(array("pers"=>"personal"),
				   		  "pers.userid = sh.userid",
				   		  array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					   ->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = sh.userid", array())
						 ->where("sh.position = ?", $posting_id)
					     ->order("sh.date_listed DESC")
					     ->group("sh.id");
			if ($admin_id!="ALL"){
				$sql->where("rs.admin_id = ?", $admin_id);
			}else{
				$sql->where("rs.admin_id IN (SELECT admin_id FROM admin WHERE status <> 'REMOVED' AND status = 'HR')");
			}
			try{
				$staffs = $db->fetchAll($sql);
			}catch(Exception $e){
				
			}
		}
		return $staffs;
	}
	
	
	public function getEndorsedStaffs($tracking_code, $admin_id){
		$db = $this->db;
		try {
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
				
			$job_orders_collection = $database -> selectCollection('job_orders');
			$cursor = $job_orders_collection->find(array("tracking_code"=>$tracking_code));
			$active_admins = array();
			if ($admin_id=="ALL"){
				$result = $db->fetchAll($db->select()->from("admin", array("admin_id"))->where("status <> 'REMOVED'")->where("status = 'HR'"));
				foreach($result as $temp){
					$active_admins[] = $temp["admin_id"];
				}
			}
			$candidates = array();
			while($cursor->hasNext()){
				$job_order = $cursor->getNext();
				if ($admin_id!="ALL"){
					//get recruiter assigned
					foreach($job_order["endorsed"] as $candidate){
						$assigned_recruiter = $db->fetchOne($db->select()->from("recruiter_staff", array("admin_id"))->where("userid = ?", $candidate["userid"]));
						if ($assigned_recruiter==$admin_id){
							$candidates[] = $candidate;
						}
					}
				}else{
					foreach($job_order["endorsed"] as $candidate){
						$assigned_recruiter = $db->fetchOne($db->select()->from("recruiter_staff", array("admin_id"))->where("userid = ?", $candidate["userid"]));
						if (in_array($assigned_recruiter, $active_admins)){
							$candidates[] = $candidate;
						}
					}
				}
			}
			return $candidates;
		} catch(MongoConnectionException $e) {
			//handle connection error
			die($e -> getMessage());
		}
	}
	
	public function getShortlistedStaffsViaPosting($posting_id){
		$db = $this->db;
		$staffs = array();
		if ($posting_id){
			$sql = $db->select()
					   ->from(array("sh"=>"tb_shortlist_history"),
					   		array("sh.userid AS userid", "sh.date_listed AS date"))
					   ->joinInner(array("pers"=>"personal"),
				   		  "pers.userid = sh.userid",
				   		  array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					   ->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = sh.userid", array())
						 ->where("sh.position = ?", $posting_id)
					     ->order("sh.date_listed DESC")
					     ->group("sh.id");
					     
			
			try{
				$staffs = $db->fetchAll($sql);
			}catch(Exception $e){
				
			}
		}
		return $staffs;
	}
	
	public function getOpenOrdersRecruiters(){
		$recruiters = $this->getRecruiters();
		
		foreach($recruiters as $key=>$recruiter){
			$recruiters[$key]["open_orders"] = $this->getOpenOrdersByRecruiter($recruiter["admin_id"]);
		}
		
		return $recruiters;
		
	}
	
	public function getOpenOrdersByRecruiter($recruiter_id){
		try{
			$filter = array();
			$filter["recruiters.recruiters_id"] = intval($recruiter_id);
			$filter["order_status"] = "Open";
			$filter["deleted"] = array('$nin'=>array(true));
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
	
	public function getOpenOrdersByRecruiterList($recruiter_id){
		try{
			$filter = array();
			$filter["recruiters.recruiters_id"] = intval($recruiter_id);
			$filter["order_status"] = "Open";
			$filter["deleted"] = array('$nin'=>array(true));
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
			$results = array();
			$posting = new GetJobPosting($this->db);
			while($cursor->hasNext()){
				$result = $cursor->getNext();
				
				
				$result["date_filled_up"] = date("Y-m-d", $result["date_filled_up"]->sec);
				$result["date_closed"] = date("Y-m-d", $result["date_closed"]->sec);
				$result = $posting->getTransformedOrder($result);
				$results[] = $result;
			}
			return $results;
		}catch(Exception $e){
			return 0;
		}
	}
	
	public function getShortlistedOpenOrderServiceType($service_type){
		$db = $this->db;	
		$loader = new JobOrderLoader($db);
		$result = $loader->getOpenOrderServiceType($service_type);
		$orders = $result["rows"];
		$shortlisted = array();
		foreach($orders as $order){
			$staff = $this->getShortlistedStaffs($order["posting_id"],"ALL");
			foreach($staff as $candi){
				$candi["tracking_code"] = $order["tracking_code"];
				$shortlisted[] = $candi;
			}
		}
		return  $shortlisted;
	}
	
	public function getShortlistedOpenOrder(){
		$db = $this->db;	
		$recruiters = $this->getRecruiters();
		
		$list = array();
		foreach($recruiters as $key=>$recruiter){
			$list[] = $this->getShortlistedOpenOrderRecruiter($recruiter["admin_id"]);
		}
		return $list;
	}
	
	public function getShortlistedOpenOrderRecruiter($recruiter_id){
		$db = $this->db;	
		$recruiter = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("admin_id","admin_fname","admin_lname","recruiter_type"))->where("admin_id = ?", $recruiter_id));
		$loader = new JobOrderLoader($db);
		$result = $loader->getOpenOrders();
		$orders = $result["rows"];
		$recruiter["assigned"] = array();
		$recruiter["unassigned"] = array();
		foreach($orders as $order){
				
			//get assigned_recruiter
			$assigned_recruiters = array();
			foreach($order["recruiters"] as $rec){
				$assigned_recruiters[] = $rec["recruiters_id"];
			}
			$shortlisted = $this->getShortlistedStaffs($order["posting_id"], $recruiter["admin_id"]);
			if (in_array($recruiter["admin_id"], $assigned_recruiters)){
				foreach($shortlisted as $key_s=>$candidate){
					$candidate["tracking_code"] = $order["tracking_code"];
					$recruiter["assigned"][] = $candidate;	
				}
			}else{
				foreach($shortlisted as $key_s=>$candidate){
					$candidate["tracking_code"] = $order["tracking_code"];
					$recruiter["unassigned"][] = $candidate;	
				}
			}
			
		}
		return $recruiter;
	}
	
	public function getShortlistedOpenOrdersRecruiters(){
		$db = $this->db;	
		$recruiters = $this->getRecruiters();
		$loader = new JobOrderLoader($db);
		$result = $loader->getOpenOrders();
		$orders = $result["rows"];
		$totalShortlist = 0;
		$totalShortlistCustom = 0;
		$totalShortlistASL = 0;
		$totalShortlistBackOrder = 0;
		$totalShortlistReplacement = 0;
		$totalShortlistInhouse = 0;
		$totalAssigned = 0;
		$totalUnassigned = 0;
		$totalAssignedPooling = 0;
		$totalUnassignedPooling = 0;
		$totalAssignedCustom = 0;
		$totalUnassignedCustom = 0;
		$totalAssignedOther = 0;
		$totalUnassignedOther = 0;
		
		foreach($recruiters as $key=>$recruiter){
			$recruiters[$key]["assigned"] = 0;
			$recruiters[$key]["unassigned"] = 0;
				
			foreach($orders as $order){
				
				//get assigned_recruiter
				$assigned_recruiters = array();
				foreach($order["recruiters"] as $rec){
					$assigned_recruiters[] = $rec["recruiters_id"];
				}
				$count = count($this->getShortlistedStaffs($order["posting_id"], $recruiter["admin_id"]));
				if (in_array($recruiter["admin_id"], $assigned_recruiters)){
					$recruiters[$key]["assigned"] += $count;
					$totalAssigned += $count;
					
					if ($recruiter["recruiter_type"]=="pooling"){
						$totalAssignedPooling+=$count;
					}else if ($recruiter["recruiter_type"]=="custom"){
						$totalAssignedCustom+=$count;
					}else if ($recruiter["recruiter_type"]=="n/a"){
						$totalAssignedOther+=$count;
					}
					
					
				}else{
					$recruiters[$key]["unassigned"] += $count;
					$totalUnassigned += $count;
					
					if ($recruiter["recruiter_type"]=="pooling"){
						$totalUnassignedPooling+=$count;
					}else if ($recruiter["recruiter_type"]=="custom"){
						$totalUnassignedCustom+=$count;
					}else if ($recruiter["recruiter_type"]=="n/a"){
						$totalUnassignedOther+=$count;
					}
				}
				if ($order["service_type"]=="CUSTOM"){
					$totalShortlistCustom += $count;
				}else if ($order["service_type"]=="ASL"){
					$totalShortlistASL += $count;
				}else if ($order["service_type"]=="BACK ORDER"){
					$totalShortlistBackOrder += $count;
				}else if ($order["service_type"]=="REPLACEMENT"){
					$totalShortlistReplacement += $count;
				}else if ($order["service_type"]=="INHOUSE"){
					$totalShortlistInhouse += $count;
				}
				$totalShortlist += $count;
			}
			
			
		}
		
		$totalPercentageCustom = number_format(($totalShortlistCustom/$totalShortlist)*100, 2);
		$totalPercentageASL = number_format(($totalShortlistASL/$totalShortlist)*100, 2);
		$totalPercentageBackOrder = number_format(($totalShortlistBackOrder/$totalShortlist)*100, 2);
		$totalPercentageReplacement = number_format(($totalShortlistReplacement/$totalShortlist)*100, 2);
		$totalPercentageInhouse = number_format(($totalShortlistInhouse/$totalShortlist)*100, 2);
		
		
		return array("recruiter"=>$recruiters, 
					"totalShortlist"=>$totalShortlist,
					"totalAssigned"=>$totalAssigned,
					"totalUnassigned"=>$totalUnassigned,
					"totalAssignedCustom"=>$totalAssignedCustom,
					"totalUnassignedCustom"=>$totalUnassignedCustom,
					"totalAssignedPooling"=>$totalAssignedPooling,
					"totalUnassignedPooling"=>$totalUnassignedPooling,
					"totalAssignedOther"=>$totalAssignedOther,
					"totalUnassignedOther"=>$totalUnassignedOther,
					
					"totalShortlistCustom"=>$totalShortlistCustom,
					"totalShortlistASL"=>$totalShortlistASL, 
					"totalShortlistBackOrder"=>$totalShortlistBackOrder,
					"totalShortlistReplacement"=>$totalShortlistReplacement,
					"totalShortlistInhouse"=>$totalShortlistInhouse,
					"totalPercentageCustom"=>$totalPercentageCustom,
					"totalPercentageASL"=>$totalPercentageASL,
					"totalPercentageBackOrder"=>$totalPercentageBackOrder,
					"totalPercentageReplacement"=>$totalPercentageReplacement,
					"totalPercentageInhouse"=>$totalPercentageInhouse,
					);
	}
}
