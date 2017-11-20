<?php
require_once dirname(__FILE__)."/GetJobPosting.php";
require_once dirname(__FILE__)."/MergeOrderProcessor.php";
require_once dirname(__FILE__)."/StaffLister.php";
require_once dirname(__FILE__)."/../../lib/JobOrderManager.php";
class NewJobOrderLoader{
	private $page = 1;
	private $rows = 50;
	private $filter_type = 0, $date_from="", $date_to="", $filter_text="",  $keyword="", $recruiter="", $hiring_coordinator="";
	private $inhouse_staff;
	private $sorters = array();
	private $order_status = "", $service_type = "";
	private $export = false;
	/**
	 * Budget related variables ...
	 * @var string
	 */
	private $budget_from="", $budget_to="", $currency="", $cat_level="", $rate_type="", $work_type="";


	private $period_from = "", $period = "";

	private $age_from="", $age_to="";
	
	private $display = "Display";
	
	
	private $filter = array();	
	
	public function __construct($db){
		$this->db = $db;
		$this->staffLister = new StaffLister($db);
		$this->gatherInput();
	}
	
	private function gatherInput(){
		$this->service_type = $_GET["service_type"];
		$this->order_status = $_GET["order_status"];

		if (isset($_GET["display"])){
			if ($_GET["display"]!="Displayed"){
				$this->display = $_GET["display"];
			}
		}

		if (isset($_GET["status"])){
			$this->status = $_GET["status"];
		}else{
			$this->status = "";
		}

		if (isset($_GET["page"])){
			$this->page = $_GET["page"];
		}else{
			$this->page = 1;
		}

		if (isset($_GET["rows"])){
			$this->rows = $_GET["rows"];
		}else{
			$this->rows = 100;
		}

		if (isset($_GET["filter_type"])){
			$this->filter_type = $_GET["filter_type"];
		}

		if (isset($_GET["recruiters"])){
			$this->recruiter = $_GET["recruiters"];
		}
		if (isset($_GET["hiring_coordinator"])){
			$this->hiring_coordinator = $_GET["hiring_coordinator"];
		}
		if($_REQUEST['inhouse_staff']) {
			$this->inhouse_staff = $_REQUEST["inhouse_staff"];
			}
		if (isset($_GET["age_from"])&&isset($_GET["age_to"])){
			$this->age_from = $_GET["age_from"];
			$this->age_to = $_GET["age_to"];
		}

		if (isset($_GET["today"])){
			$this->order_status = 0;
		}

		if (isset($_GET["sorter_length"])){
			$sorterLength = $_GET["sorter_length"];
			for($i=0;$i<$sorterLength;$i++){
				if (isset($_GET["column_".$i])){
					$this->sorters[] = array("column"=>$_GET["column_".$i], "direction"=>$_GET["direction_".$i]);
				}
			}
		}
		
		if ($this->filter_type==0){
			if (isset($_GET["keyword"])){
				$this->keyword = trim($_GET["keyword"]);
			}


		}else{
			//Filter type

			if (($this->filter_type==1)||($this->filter_type==2)){
				$this->filter_text = $_GET["filter_text"];
			}else if ($this->filter_type==3){
				$this->date_from = $_GET["date_from"];
				$this->date_to = date("Y-m-d", strtotime("+1 day", strtotime($_GET["date_to"])));
			}else if ($this->filter_type==4){
				$this->budget_from = $_GET["budget_from"];
				$this->budget_to = $_GET["budget_to"];
				$this->currency = $_GET["currency"];
				$this->cat_level = $_GET["level"];
				$this->rate_type = $_GET["rate_type"];
				$this->work_type = $_GET["work_type"];
			}else if ($this->filter_type==5){
				$this->filter_text = $_GET["filter_text"];
			}else if ($this->filter_type==6){
				$this->period_from = $_GET["period_from"];
				$this->period = $_GET["period"];
			}else if ($this->filter_type==8){
				$this->date_from = $_GET["date_from"];
				$this->date_to = date("Y-m-d", strtotime("+1 day", strtotime($_GET["date_to"])));
			}else if ($this->filter_type==9){
				$this->date_from = $_GET["date_from"];
				$this->date_to = date("Y-m-d", strtotime("+1 day", strtotime($_GET["date_to"])));
			}

		}
		
		
		if (isset($_GET["closing"])){
			$this->order_status = 1;
		}
	}

	private function setFilter(){
		
		if ($this->keyword!=""){
			$this->filter['$and'] = array();
			$or = array();	
			$regex = new MongoRegex('/'.$this->keyword.'/i');
			
			$or['$or'] = array(
									array("client"=>$regex),
									array("endorsed.fullname"=>$regex),
									array("interviewed.fullname"=>$regex),
									array("hired.fullname"=>$regex),
									array("ontrial.fullname"=>$regex),
									array("rejected.fullname"=>$regex),
									array("shortlisted.fullname"=>$regex),
									array("cancelled.fullname"=>$regex),
									array("tracking_code"=>$regex),
									
									);
			$this->filter['$and'][] = $or;
			if ($this->filter_type==1){
				$this->filter['$and'][] = array("job_title"=>new MongoRegex('/'.$this->filter_text.'/i'));	
			}else if ($this->filter_type==2){
				$this->filter['$and'][] = array("work_status"=>$this->filter_text);	
			}else if ($this->filter_type==3){
				if (isset($_GET["today"])){
					$this->filter['$and'][] = array("date_filled_up"=> array('$lte'=>new MongoDate(strtotime(date("Y-m-d"))), '$gte'=>new MongoDate(strtotime("2012-02-01"))));	
				}else if ($_GET["closing"]){
					$this->filter['$and'][] = array("date_closed"=>array('$lte'=>new MongoDate(strtotime($this->date_to)), '$gte'=>new MongoDate(strtotime($this->date_from))));	
				}else{
					$this->filter['$and'][] = array("date_filled_up"=>array('$lte'=>new MongoDate(strtotime($this->date_to)), '$gte'=>new MongoDate(strtotime($this->date_from))));	
				}
			}else if ($this->filter_type==4){
				$this->filter['$and'][] = array("currency"=>$this->currency);
				$this->filter['$and'][] = array("work_status"=>$this->work_type);
				
				if ($this->rate_type=="Hourly"){
					$this->filter['$and'][] = array("budget_hourly"=>array('$lte'=>floatval($this->budget_to), '$gte'=>floatval($this->budget_from)));	
				}else{
					$this->filter['$and'][] = array("budget_monthly"=>array('$lte'=>floatval($this->budget_to), '$gte'=>floatval($this->budget_from)));	
				}
				
				if ($this->cat_level == "Entry"){
					$this->filter['$and'][]	 = array("level"=>"entry");
				}else if ($this->cat_level == "Middle"){
					$this->filter['$and'][]	 = array("level"=>"mid");
				}else{
					$this->filter['$and'][]	 = array("level"=>"expert");
				}
				
			}else if ($this->filter_type==5){
				$this->filter['$and'][] = array("working_timezone"=>$this->filter_text);	
			}else if ($this->filter_type==6){
				if ($this->period_from!=""){
					$this->filter['$and'][] = array("date_filled_up"=>new MongoDate(strtotime($this->date_filled_up)));	
					$this->filter['$and'][] = array("proposed_start_date"=>$this->period);	
					
				}else{
					$this->filter['$and'][] = array("proposed_start_date"=>$this->period);	
					
				}
			}else if ($this->filter_type==7){
				if (($this->age_from!="")&&($this->age_to!="")){
					$this->filter['$and'][] = array("age"=>array('$lte'=>intval($this->age_to), '$gte'=>intval($this->age_from)));
				}
			}else if ($this->filter_type==8){
				if ($this->date_from&&$this->date_to){
					$this->filter['$and'][] = array("last_contact"=>array('$lte'=>new MongoDate(strtotime($this->date_to)), '$gte'=>new MongoDate(strtotime($this->date_from))));	
				}	
			}else if ($this->filter_type==9){
				if ($this->date_from&&$this->date_to){
					$this->filter['$and'][] = array("status_last_update"=>array('$lte'=>new MongoDate(strtotime($this->date_to)), '$gte'=>new MongoDate(strtotime($this->date_from))));	
				}	
			}
			
			if ($this->hiring_coordinator=="nohm"){
				$this->filter['$and'][] = array("assigned_hiring_coordinator_id"=>null);
			}else{
				if ($this->hiring_coordinator){
					$this->filter['$and'][] = array("assigned_hiring_coordinator_id"=>intval($this->hiring_coordinator));					
				}
			}
				if($this -> inhouse_staff) {
			if( $this -> inhouse_staff == 'no' ) {
				$this -> filter['$and'][] = array("leads_id" =>array('$ne'=>11));
			}
		}
			
			if ($this->recruiter){
				if ($this->recruiter=="any_rec"){
					$this->filter['$and'][] = array("recruiters"=>array('$ne'=>null));
				}else if ($this->recruiter=="no_rec"){
					$this->filter['$and'][] = array("recruiters"=>array('$in'=>array(null, array())));		
				}else{
					$this->filter['$and'][] = array("recruiters.recruiters_id"=>intval($this->recruiter));				
				}
			}
			
			if ($this->service_type){
				if ($this->service_type!="VIEW ALL"){
					$this->filter['$and'][] = array("service_type"=>$this->service_type);				
				}else{
					$this->filter['$and'][] = array("service_type"=>array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE")));
				}
			}else{
				$this->filter['$and'][] = array("service_type"=>array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE")));
			}
			
			if ($this->order_status!="VIEW ALL"){
				$this->filter['$and'][] = array("sub_order_status"=>$this->order_status);				
			}
			
			
			if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
				$this->filter['$and'][] = array("date_filled_up"=> array('$gte'=>new MongoDate(strtotime("2012-02-01"))));	
			}
			if ($this->display=="Display"||$this->display=="Displayed"){
				$this->filter['$and'][] = array("deleted"=>array('$ne'=>true));
			}else{
				$this->filter['$and'][] = array("deleted"=>true);
			}
			$this->filter["merged"] = array('$ne'=>true);
		
		}else{
			if ($this->filter_type==1){
				$this->filter["job_title"] = new MongoRegex('/'.$this->filter_text.'/i');
			}else if ($this->filter_type==2){
				$this->filter["work_status"] = $this->filter_text;
			}else if ($this->filter_type==3){
				if (isset($_GET["today"])){
					$this->filter["date_filled_up"] = array('$lte'=>new MongoDate(strtotime(date("Y-m-d")." +1 day")), '$gte'=>new MongoDate(strtotime("2012-02-01")));
				}else if ($_GET["closing"]){
					$this->filter["date_closed"] = array('$lte'=>new MongoDate(strtotime($this->date_to." +1 day")), '$gte'=>new MongoDate(strtotime($this->date_from)));
				}else{
					$this->filter["date_filled_up"] = array('$lte'=>new MongoDate(strtotime($this->date_to." +1 day")), '$gte'=>new MongoDate(strtotime($this->date_from)));
				}
			}else if ($this->filter_type==4){
				$this->filter["currency"] = $this->currency;
				$this->filter["work_status"] = $this->work_type;
				
				if ($this->rate_type=="Hourly"){
					$this->filter["budget_hourly"] = array('$lte'=>floatval($this->budget_to), '$gte'=>floatval($this->budget_from));	
				}else{
					$this->filter["budget_monthly"] = array('$lte'=>floatval($this->budget_to), '$gte'=>floatval($this->budget_from));	
				}
				
				if ($this->cat_level == "Entry"){
					$this->filter["level"] = "entry";
				}else if ($this->cat_level == "Middle"){
					$this->filter["level"] = "mid";
				}else{
					$this->filter["level"] = "expert";	
				}
				
			}else if ($this->filter_type==5){
				$this->filter["working_timezone"] = $this->filter_text;
			}else if ($this->filter_type==6){
				if ($this->period_from!=""){
					$this->filter["date_filled_up"] = new MongoDate(strtotime($this->period_from));
					$this->filter["proposed_start_date"] = $this->period;
				}else{
					$this->filter["proposed_start_date"] = $this->period;
				}
			}else if ($this->filter_type==7){
				if (($this->age_from!="")&&($this->age_to!="")){
					$this->filter["age"] = array('$lte'=>intval($this->age_to), '$gte'=>intval($this->age_from));
				}
			}else if ($this->filter_type==8){
				if ($this->date_from&&$this->date_to){
					$this->filter['last_contact'] = array('$lte'=>new MongoDate(strtotime($this->date_to)), '$gte'=>new MongoDate(strtotime($this->date_from)));	
				}	
			}else if ($this->filter_type==9){
				if ($this->date_from&&$this->date_to){
					$this->filter['status_last_update'] = array('$lte'=>new MongoDate(strtotime($this->date_to)), '$gte'=>new MongoDate(strtotime($this->date_from)));	
				}	
			}
			
			if ($this->hiring_coordinator=="nohm"){
				$this->filter["assigned_hiring_coordinator_id"] = null;
			}else{
				if ($this->hiring_coordinator){
					$this->filter["assigned_hiring_coordinator_id"] = intval($this->hiring_coordinator);
					
				}
			}
				
			if ($this->recruiter){
				if ($this->recruiter=="any_rec"){
					$this->filter["recruiters"] = array('$ne'=>array());
					$this->filter["recruiters.recruiters_id"] = array('$nin'=>array(0));
				}else if ($this->recruiter=="no_rec"){
					$this->filter["recruiters"] = array('$in'=>array(null, array()));
					//$this->filter["recruiters.recruiters_id"] = array('$in'=>array(0));
				}else{
					$this->filter["recruiters.recruiters_id"] = intval($this->recruiter);				
				}
			}
			if($this -> inhouse_staff) {
			if( $this -> inhouse_staff == 'no' ) {
				$this -> filter['$and'][] = array("leads_id" =>array('$ne'=>11));
			}
		}
			
			//add service type filter
			if ($this->service_type){
				if ($this->service_type=="VIEW ALL"){
					$this->filter["service_type"] = array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE"));
				}else{
					$this->filter["service_type"] = $this->service_type;
					
				}
			}else{
				$this->filter["service_type"] = array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE"));
			}
			
			//add order status filter
			if ($this->order_status!="VIEW ALL"){
				$this->filter["sub_order_status"] = $this->order_status;			
			}
			
			if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
				$this->filter["date_filled_up"] = array('$gte'=>new MongoDate(strtotime("2012-02-01")));		
			}
			if ($this->display=="Display"||$this->display=="Displayed"){
				$this->filter["deleted"] = array('$nin'=>array(true));
			}else{
				$this->filter["deleted"] = true;
			}
			$this->filter["merged"] = array('$ne'=>true);
			
		}
		
		

		
	}

	/**
	 * Set Filter Default
	 */
	private function setFilterDefault(){
		$this->filter_type = 0;
		$this->service_type = 0;
		$this->order_status = 0;
		$this->keyword = "";
		$this->recruiters = "";
		$this->hiring_coordinator = "";
		$this->display = "Display";
		$this->rows = 50;
		$this->setFilter();
	}	

	public function process(){
		
		if (isset($_GET["filter_type"])){
			$this->setFilter();
		}else{
			$this->setFilterDefault();
		}
		return $this->getList();
	}
	
	public function render(){
		return $this->process();
	}
	public function getList(){
		try{
			$db  = $this->db;
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
			$cursor = $job_orders_collection->find($this->filter);
			$totalJobOrders = $cursor->count();
			$totalPages = (int)ceil($totalJobOrders/$this->rows);
			if ($this->rows!=-1){
				$cursor->sort(array("date_filled_up"=>-1))->skip($skip)->limit($this->rows);
			}else{
				$cursor->sort(array("date_filled_up"=>-1));
			}
			
			$results = array();
			$posting = new GetJobPosting($this->db);
			while($cursor->hasNext()){
				$result = $cursor->getNext();
				
				
				$result["date_filled_up"] = date("Y-m-d", $result["date_filled_up"]->sec);
				$result["date_closed"] = date("Y-m-d", $result["date_closed"]->sec);
				
				$result = $posting->getTransformedOrder($result);
				
				//customized for new recruiter view
				$latest_status = $db->fetchRow($db->select()->from("mongo_job_orders_multi_statuses")->where("tracking_code = ?", $result["tracking_code"])->order("date_created DESC"));
				$result["latest_status"] = $latest_status;
				if ($latest_status){
					if ($latest_status["assigning_status"]){
						$assigning_status = $latest_status["assigning_status"];
						if ($assigning_status==JobOrderManager::OPEN){
							$result["attention_to"] = "All";
							$result["sub_status"] = "Open";
						}else if ($assigning_status==JobOrderManager::SC_ASSIGNED){
							$result["attention_to"] = "All";
							$result["sub_status"] = "Staffing Consultant Assigned";
						}else if ($assigning_status==JobOrderManager::REC_ASSIGNED){
							$result["attention_to"] = "All";
							$result["sub_status"] = "Recruiter Assigned";
						}else if ($assigning_status==JobOrderManager::AD_UP){
							$result["attention_to"] = "All";
							$result["sub_status"] = "Ad Up";
						}else{
							$result["attention_to"] = "All";
							$result["sub_status"] = "Open";
						}
						$result["lock_manual"] = false;
					}else if ($latest_status["hiring_status"]){
						$hiring_status = $latest_status["hiring_status"];
						if ($hiring_status==JobOrderManager::NEW_SHORTLIST){
							$result["attention_to"] = "Staffing Consultant";
							$result["sub_status"] = "New Shortlist";
						}else if ($hiring_status==JobOrderManager::NEED_MORE_CANDIDATE){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Need More Candidate";
						}else if ($hiring_status==JobOrderManager::SC_REVIEWING_SHORTLIST){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Staffing Consultant Reviewing Shortlist";
						}else if ($hiring_status==JobOrderManager::SKILL_TEST){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Skill Test";
						}else if ($hiring_status==JobOrderManager::POST_ENDORSEMENT){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Waiting For Feedback from Client: Post Endorsement";
						}else if ($hiring_status==JobOrderManager::POST_INTERVIEW){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Waiting For Feedback from Client: Post Interview";
						}else if ($hiring_status==JobOrderManager::CLIENT_INTERVIEWING){
							$result["attention_to"] = "Staffing Consultant";
							$result["sub_status"] = "Client Interviewing";
						}else if ($hiring_status==JobOrderManager::SC_REVIEWING_ORDER){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Staffing Consultant Reviewing Order";
						}
						$result["lock_manual"] = false;
						
					}else if ($latest_status["decision_status"]){
						$decision_status = $latest_status["decision_status"];
						if ($decision_status==JobOrderManager::CLOSED_DID_NOT_PUSH_THROUGH){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Closed: Did not push through";
						}else if ($decision_status==JobOrderManager::CLOSED_HIRED){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Closed: Hired";
						}else if ($decision_status==JobOrderManager::CLOSED_HOLD){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Closed: On Hold";
						}else if ($decision_status==JobOrderManager::CLOSED_TRIAL){
							$result["attention_to"] = "Recruitment Team";
							$result["sub_status"] = "Closed: On Trial";
						}
						$result["lock_manual"] = true;
					}	
				}else{
					if (in_array($result["sub_order_status"], array(JobOrderManager::OPEN, JobOrderManager::SC_ASSIGNED, JobOrderManager::REC_ASSIGNED, JobOrderManager::AD_UP))){
						$result["attention_to"] = "All";
					}else if (in_array($result["sub_order_status"], array(JobOrderManager::NEW_SHORTLIST, JobOrderManager::CLIENT_INTERVIEWING))){
						$result["attention_to"] = "Staffing Consultant";
					}else{
						$result["attention_to"] = "Recruitment Team";
					}
					
					$result["lock_manual"] = false;
					$status = $result["sub_order_status"];
					if ($status==JobOrderManager::OPEN){
						$result["sub_status"] = "Open";
					}else if ($status==JobOrderManager::SC_ASSIGNED){
						$result["sub_status"] = "Staffing Consultant Assigned";
					}else if ($status==JobOrderManager::REC_ASSIGNED){
						$result["sub_status"] = "Recruiter Assigned";
					}else if ($status==JobOrderManager::AD_UP){
						$result["sub_status"] = "Ad Up";
					}else if ($status==JobOrderManager::NEW_SHORTLIST){
						$result["sub_status"] = "New Shortlist";
					}else if ($status==JobOrderManager::NEED_MORE_CANDIDATE){
						$result["sub_status"] = "Need More Candidate";
					}else if ($status==JobOrderManager::SC_REVIEWING_SHORTLIST){
						$result["sub_status"] = "Staffing Consultant Reviewing Shortlist";
					}else if ($status==JobOrderManager::SKILL_TEST){
						$result["sub_status"] = "Skill Test";
					}else if ($status==JobOrderManager::POST_ENDORSEMENT){
						$result["sub_status"] = "Waiting For Feedback from Client: Post Endorsement";
					}else if ($status==JobOrderManager::POST_INTERVIEW){
						$result["attention_to"] = "Recruitment Team";
						$result["sub_status"] = "Waiting For Feedback from Client: Post Interview";
					}else if ($status==JobOrderManager::CLIENT_INTERVIEWING){
						$result["sub_status"] = "Client Interviewing";
					}else if ($status==JobOrderManager::SC_REVIEWING_ORDER){
						$result["sub_status"] = "Staffing Consultant Reviewing Order";
					}else if ($status==JobOrderManager::CLOSED_DID_NOT_PUSH_THROUGH){
						$result["attention_to"] = "Recruitment Team";
						$result["sub_status"] = "Closed: Did not push through";
						$result["lock_manual"] = true;
					}else if ($status==JobOrderManager::CLOSED_HIRED){
						$result["attention_to"] = "Recruitment Team";
						$result["sub_status"] = "Closed: Hired";
						$result["lock_manual"] = true;
					}else if ($status==JobOrderManager::CLOSED_HOLD){
						$result["attention_to"] = "Recruitment Team";
						$result["sub_status"] = "Closed: On Hold";
						$result["lock_manual"] = true;
					}else if ($status==JobOrderManager::CLOSED_TRIAL){
						$result["sub_status"] = "Closed: On Trial";
						$result["lock_manual"] = true;
					}else{
						$result["sub_status"] = "Open";
					}
				}
				
				foreach($result["recruiters"] as $key_rec=>$recruiter){
					$result["recruiters"][$key_rec]["recruiter"] = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("admin_fname", "admin_lname"))->where("admin_id = ?", $recruiter["recruiters_id"]));
				}
				
				if ($latest_status){
					$result["date_updated_attention_to"] = $latest_status["date_created"];
				}else{
					$result["date_updated_attention_to"] = "N/A";
				}
				
				$results[] = $result;
			}
		
			return array("success"=>true, "rows"=>$results, "records"=>$totalJobOrders, "total"=>$totalPages, "page"=> $this->page, );
		} catch(MongoConnectionException $e) {
			//handle connection error
			die($e->getMessage());
		}	
	}
	
	
	
}
