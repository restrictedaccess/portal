<?php
require_once dirname(__FILE__)."/GetJobPosting.php";
require_once dirname(__FILE__)."/MergeOrderProcessor.php";
require_once dirname(__FILE__)."/StaffLister.php";

class JobOrderLoader{
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
				$this->date_to = date("Y-m-d", strtotime($_GET["date_to"] . " 23:59:59"));
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
				$this->date_to = date("Y-m-d", strtotime($_GET["date_to"] . " 23:59:59"));
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
				$this->filter['$and'][] = array("job_title"=>$this->filter_text);
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
				$this -> filter['$and'][] = array("leads_id" =>array('$nin'=>array(11)));
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

			//add service type filter
			if ($this->service_type!=0){
				$value = "";
				if ($this->service_type == 1){
					$value="CUSTOM";
				}else if ($this->service_type==2){
					$value="ASL";
				}else if ($this->service_type==3){
					$value="BACK ORDER";
				}else if ($this->service_type==4){
					$value="REPLACEMENT";
				}else if ($this->service_type==5){
					$value="INHOUSE";

				}else{
					$value = array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE"));
				}
				$this->filter['$and'][] = array("service_type"=>$value);
			}else{
				$this->filter['$and'][] = array("service_type"=>array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE")));
			}

			//add order status filter
			if ($this->order_status == 0){
				$this->filter['$and'][] = array("order_status"=>"Open");
			}else if ($this->order_status==1){
				$this->filter['$and'][] = array("order_status"=>"Closed");
			}else if ($this->order_status==2){
				$this->filter['$and'][] = array("order_status"=>"Did not push through");
			}else if ($this->order_status==3){
				$this->filter['$and'][] = array("order_status"=>"On Hold");
			}else if ($this->order_status==4){
				$this->filter['$and'][] = array("order_status"=>"On Trial");
			}

            if ($_REQUEST["business_developer"]&&$_REQUEST["business_developer"]!=""){
                $this->filter['$and'][] = array("bp_lname"=>$_REQUEST["business_developer"]);
            }



			if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
				$this->filter['$and'][] = array("date_filled_up"=> array('$gte'=>new MongoDate(strtotime("2012-02-01"))));
			}
			if ($this->display=="Display"||$this->display=="Displayed"){
				$this->filter["deleted"] = array('$ne'=>true);
			}else{
				$this->filter["deleted"] = true;
			}
			$this->filter["merged"] = array('$ne'=>true);

		}else{
			if ($this->filter_type==1){
				$this->filter["job_title"] = $this->filter_text;
			}else if ($this->filter_type==2){
				$this->filter["work_status"] = $this->filter_text;
			}else if ($this->filter_type==3){
				if (isset($_GET["today"])){
					$this->filter["date_filled_up"] = array('$lte'=>new MongoDate(strtotime(date("Y-m-d")." 23:59:59")), '$gte'=>new MongoDate(strtotime("2012-02-01")));
				}else if ($_GET["closing"]){
					$this->filter["date_closed"] = array('$lte'=>new MongoDate(strtotime($this->date_to." 23:59:59")), '$gte'=>new MongoDate(strtotime($this->date_from)));
				}else{
					$this->filter["date_filled_up"] = array('$lte'=>new MongoDate(strtotime($this->date_to." 23:59:59")), '$gte'=>new MongoDate(strtotime($this->date_from)));
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
			}

			if ($this->hiring_coordinator=="nohm"){
				$this->filter["assigned_hiring_coordinator_id"] = null;
			}else{
				if ($this->hiring_coordinator){
					$this->filter["assigned_hiring_coordinator_id"] = intval($this->hiring_coordinator);

				}
			}
			if($this -> inhouse_staff) {
			if( $this -> inhouse_staff == 'no' ) {
				$this -> filter['$and'][] = array("leads_id" =>array('$nin'=>array(11)));
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

			//add service type filter
			if ($this->service_type!=0){
				$value = "";
				if ($this->service_type == 1){
					$value="CUSTOM";
				}else if ($this->service_type==2){
					$value="ASL";
				}else if ($this->service_type==3){
					$value="BACK ORDER";
				}else if ($this->service_type==4){
					$value="REPLACEMENT";
				}else if ($this->service_type==5){
					$value="INHOUSE";
				}else{
					$value = array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE"));
				}
				$this->filter["service_type"] = $value;
			}else{
				$this->filter["service_type"] = array('$in'=>array("CUSTOM", "ASL", "BACK ORDER", "REPLACEMENT", "INHOUSE"));
			}

			//add order status filter
			if ($this->order_status == 0){
				$this->filter["order_status"] = "Open";
			}else if ($this->order_status==1){
				$this->filter["order_status"] = "Closed";
			}else if ($this->order_status==2){
				$this->filter["order_status"] = "Did not push through";
			}else if ($this->order_status==3){
				$this->filter["order_status"] = "On Hold";
			}else if ($this->order_status==4){
				$this->filter["order_status"] = "On Trial";
			}

            if ($_REQUEST["business_developer"]&&$_REQUEST["business_developer"]!=""){
                $this->filter["bp_lname"]=$_REQUEST["business_developer"];
            }

			if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
				$this->filter["date_filled_up"] = array('$gte'=>new MongoDate(strtotime("2012-02-01")));
			}
			if ($this->display=="Display"||$this->display=="Displayed"){
				$this->filter["deleted"] = array('$ne'=>true);
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

	public function getOpenOrders(){
		$this->filter_type = 0;
		$this->service_type = 0;
		$this->order_status = 0;
		$this->keyword = "";
		$this->recruiters = "";
		$this->hiring_coordinator = "";
		$this->display = "Display";
		$this->rows = -1;
		$this->setFilter();
		return $this->getList();
	}



	public function getTodayOrdersHM($hiring_coordinator, $service_type){
		$_GET["today"] = 1;
		$this->gatherInput();
		$this->limit = false;
		$this->order_status = 0;
		$this->export = true;
		$this->service_type = $service_type;
		$this->hiring_coordinator = $hiring_coordinator;
		$this->setFilter();
		return $this->getList();
	}

	public function getCloseOrdersHM($hiring_coordinator, $service_type, $dateFrom, $dateTo){
		$_GET["closing"] = 1;
		$this->gatherInput();
		$this->limit = false;
		$this->filter_type = 3;
		$this->order_status = 1;
		$this->export = true;
		$this->date_from = $dateFrom;
		$this->date_to = $dateTo;
		$this->service_type = $service_type;
		$this->hiring_coordinator = $hiring_coordinator;
		$this->setFilter();
		return $this->getList();
	}

	public function getOpenOrdersHM($hiring_coordinator, $service_type, $order_status, $dateFrom, $dateTo){
		$this->gatherInput();
		$this->limit = false;
		$this->filter_type = 3;
		$this->order_status = $this->order_status;
		$this->export = true;
		$this->date_from = $dateFrom;
		$this->date_to = $dateTo;
		$this->service_type = $service_type;
		$this->hiring_coordinator = $hiring_coordinator;
		$this->setFilter();
		return $this->getList();
	}

	public function getOpenOrderServiceType($service_type){
		if ($service_type=="CUSTOM"){
			$this->service_type = 1;
		}else if ($service_type=="ASL"){
			$this->service_type = 2;
		}else if ($service_type=="BACK ORDER"){
			$this->service_type = 3;
		}else if ($service_type=="REPLACEMENT"){
			$this->service_type = 4;
		}else if ($service_type=="INHOUSE"){
			$this->service_type = 5;
		}else{
			$this->service_type = 0;
		}
		$this->filter_type = 0;
		$this->order_status = 0;
		$this->keyword = "";
		$this->recruiters = "";
		$this->hiring_coordinator = "";
		$this->display = "Display";
		$this->rows = -1;
		$this->setFilter();
		return $this->getList();
	}

	public function process(){

		if (isset($_GET["filter_type"])){
			$this->setFilter();
		}else{
			$this->setFilterDefault();
		}
		return $this->getList();
	}


	public function getList(){
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
				}catch(Exception $e){
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
				$cursor->sort(array("date_filled_up"=>-1, "gs_job_titles_details_id"=>-1))->skip($skip)->limit($this->rows);
			}else{
				$cursor->sort(array("date_filled_up"=>-1, "gs_job_titles_details_id"=>-1));
			}

			$results = array();
			$posting = new GetJobPosting($this->db);
			$db = $this->db;
			while($cursor->hasNext()){
				$result = $cursor->getNext();


				$result["date_filled_up"] = date("Y-m-d", $result["date_filled_up"]->sec);
				$result["date_closed"] = date("Y-m-d", $result["date_closed"]->sec);

				$result = $posting->getTransformedOrder($result);

				$proposed_start_date = $db->fetchOne($db->select()->from("gs_job_titles_details", "proposed_start_date")->where("gs_job_titles_details_id = ?", $result["gs_job_titles_details_id"]));

				if ($proposed_start_date){
					$result["proposed_start_date"] = date("Y-m-d", strtotime($proposed_start_date));
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
