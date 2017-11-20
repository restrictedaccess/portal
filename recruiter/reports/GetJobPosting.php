<?php
require_once dirname(__FILE__)."/StaffLister.php";
require_once dirname(__FILE__)."/MergeOrderProcessor.php";
class GetJobPosting{

	/**
	 * database connection ...
	 * @var Zend_Db_Adapter_Abstract $db
	 */
	private $db;
	private $inhouse_staff;
	private $status = "";
	private $page = 1;
	private $rows = 50;
	private $filter_type = 0, $date_from="", $date_to="", $filter_text="",  $keyword="", $recruiter="", $hiring_coordinator="";

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

	private $staffLister;

	
	private $mergeProcessor;

	
	private $limit = true, $counterOnly = false;
	
	public function __construct($db){
		session_start();
		$this->db = $db;
		$this->staffLister = new StaffLister($db);
		$this->mergeProcessor = new MergeOrderProcessor($db);
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
				$this->keyword = $_GET["keyword"];
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
			}

		}
		
		
		if (isset($_GET["closing"])){
			$this->order_status = 1;
		}
		

	}


	public function preprocess(){
		$db = $this->db;
		session_start();
		if (isset($_SESSION["started"])){
			$started = $_SESSION["started"];
		}else{
			$started = false;
		}

		$beforeasls = $db->fetchAll($db->select()->from(array("gs_jrs"=>"gs_job_role_selection"), array("gs_jrs.gs_job_role_selection_id"))->where("gs_jrs.session_id IS NOT NULL"));
		if (!empty($beforeasls)){
			foreach($beforeasls as $order){
				$row = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details_temp"))->where("gs_jtd.gs_job_role_selection_id = ?", $order["gs_job_role_selection_id"]));
				if ($row){
					$id = $row["gs_job_titles_details_id"];
					unset($row["gs_job_titles_details_id"]);
					
					$retains = array("created_reason", "service_type", "date_filled_up", "status", "gs_job_role_selection_id");
					
					foreach($row as $key=>$item){
						if (!in_array($key, $retains)){
							unset($row[$key]);	
						}
					}
					
					$db->update("gs_job_titles_details", $row, $db->quoteInto("gs_job_role_selection_id = ?", $order["gs_job_role_selection_id"]));
					$db->delete("gs_job_titles_details_temp", $db->quoteInto("gs_job_role_selection_id = ?", $order["gs_job_role_selection_id"]));
				}
			}
			
			
			//clear any unfinish create job specification form by 10 minutes to avoid immediate conflict
			foreach($beforeasls as $order){
				$row = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array("gs_job_titles_details_id"))->where("gs_jtd.gs_job_role_selection_id = ?", $order["gs_job_role_selection_id"]));
				if (!$row){
					$job_spec = $db->fetchRow($db->select()->from("gs_job_role_selection")->where("gs_job_role_selection_id = ?", $order["gs_job_role_selection_id"]));
					$creation_date = strtotime("+10 minute", strtotime($job_spec["date_created"]));
					if (strtotime(date("Y-m-d H:i:s"))>$creation_date){
						$db->delete("gs_job_role_selection", "gs_job_role_selection_id = {$order["gs_job_role_selection_id"]}");						
					}
				}
			}
		}
		
		$date = date("Y-m-d h:i:s");
		//mark basis the new custom order contains the ASL
		$temp_merge = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("moi.gs_job_title_details_id", "moi.id", "moi.merged_order_id"))->where("(moi.service_type IS NULL OR moi.service_type = '')")->where("moi.basis = 1"));
		if (!empty($temp_merge)){
			foreach($temp_merge as $merge_item){
				$db->delete("merged_order_items", "id = ".$merge_item["id"]);
				if ($merge_item["gs_job_titles_details_id"]){
					$itemBasis = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array("gs_jtd.gs_job_titles_details_id"))->where("gs_jtd.gs_job_role_selection_id = ?", $merge_item["gs_job_titles_details_id"]));
					if ($itemBasis){
						$newOrder = array();
						$newOrder["merged_order_id"] = $merge_item["merged_order_id"];
						$newOrder["service_type"] = "CUSTOM";
						$newOrder["basis"] = 1;
						$db->insert("merged_order_items", $newOrder); 
					}
				}
			}
		}
		
		$sql = "SELECT mo.id AS id, (SELECT COUNT(*)FROM merged_order_items moi WHERE moi.merged_order_id = mo.id AND moi.basis = 1) AS count FROM  `merged_orders` mo HAVING count =0";
		$unclean_merges = $db->fetchAll($sql);
		if (!empty($unclean_merges)){
			foreach($unclean_merges as $merge_item){
				$items = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("service_type", "gs_job_title_details_id", "jsca_id", "date_added", "lead_id"))->where("moi.merged_order_id = ?", $merge_item["id"])->order("date_added DESC"));
				if (empty($items)){
					$db->delete("merged_orders", $db->quoteInto("id = ?", $merge_item["id"]));
				}else{
					$db->delete("merged_order_items", $db->quoteInto("merged_order_id = ?", $merge_item["id"]));
					//mark basis
					$row = $db->fetchRow($db->select()->from("merged_orders", array("admin_id", "date_created", "service_type", "order_status", "date_closed"))->where("id = ?", $merge_item["id"]));
					
					$hasBasis = false;
					$basisServiceType = "";
					foreach($items as $key => $item){
						if ($item["service_type"]!="ASL"){
							if (!$hasBasis){
								$items[$key]["basis"] = 1;
								$hasBasis = true;
								$basisServiceType = $item["service_type"];
							}
						}
						
					}
					
					if (!$hasBasis){
						$items[0]["basis"] = 1;
						$basisServiceType = "ASL";
					}
					$db->delete("merged_orders", $db->quoteInto("id = ?", $merge_item["id"]));
					
					$row["service_type"] = $basisServiceType;
					$db->insert("merged_orders", $row);
					$merged_order_id_temp = $db->lastInsertId("merged_orders");
					
					foreach($items as $item){
						$item["merged_order_id"] = $merged_order_id_temp; 
						$db->insert("merged_order_items", $item);
					}
				}
				
				
			}
		}
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
				
			$job_order_collection = $database->selectCollection("job_orders");
			//clean non existing gs_* that is marked as basis for merged order. if found unmerge the order
			$merged_order_items = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"))->where("basis = 1")->where("gs_job_title_details_id IS NOT NULL"));
			foreach($merged_order_items as $merged_order_item){
				$gs = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array("gs_jtd.gs_job_titles_details_id"))->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id=gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id"))->where("gs_job_titles_details_id = ?", $merged_order_item["gs_job_title_details_id"]));
							
				//check if on gs table
				if (!$gs){
					//unmerge the job order
					//load first all other merge order items look for with lead_id
					$all = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"))->where("merged_order_id = ?", $merged_order_item["merged_order_id"]));
					foreach($all as $item){
						if ($item["lead_id"]){
							$job_order_collection->remove(array("leads_id"=>intval($item["lead_id"])));
							$db->delete("mongo_job_orders",$db->quoteInto("leads_id = ?",$item["lead_id"]));
							break;
						}else if ($item["gs_job_title_details_id"]){
							$gs2 = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array())->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id=gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id"))->where("gs_job_titles_details_id = ?", $merged_order_item["gs_job_title_details_id"]));
							if ($gs2){
								$job_order_collection->remove(array("leads_id"=>intval($gs2["leads_id"])));
								$db->delete("mongo_job_orders",$db->quoteInto("leads_id = ?",$gs2["leads_id"]));
								break;
							}
						}
					}
					
					
					
					
					//ultimately lets unmerge the job order
					if ($merged_order_item["merged_order_id"]){
						$db->delete("merged_orders",$db->quoteInto("id = ?", $merged_order_item["merged_order_id"]));
						$db->delete("merged_order_items",$db->quoteInto("merged_order_id = ?", $merged_order_item["merged_order_id"]));											
					}
					
				}
			}

			//loop all job_orders with 0 recruiter_id
			$cursor = $job_order_collection->find(array("recruiters.recruiters_id"=>array('$in'=>array(0))));
			while($cursor->hasNext()){
				$job_order = $cursor->getNext();
				
				$recruiters = array();
				if (!empty($job_order["recruiters"])){
					foreach($job_order["recruiters"] as $recruiter){
						if ($recruiter["recruiters_id"]!=0){
							$recruiters[] = $recruiter;
						}
					}
				}
				
				$job_order_collection->update(array("tracking_code"=>$job_order["tracking_code"]), array('$set'=>array("recruiters"=>$recruiters)));
			}
		}catch(Exception $e){
			
		}

		
		
		$sql = "SELECT session_id FROM request_for_interview_job_order_session WHERE session_id <> 0 AND (date_added IS NULL OR job_sub_category_applicants_id IS NULL OR lead_id IS NULL) GROUP BY session_id";
		$uniqueOrders = $db->fetchAll($sql);
		if (!empty($uniqueOrders)){
			foreach($uniqueOrders as $order){
				$row = $db->fetchRow(
				$db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.date_added AS date_added", "tbr.leads_id AS lead_id"))
				->joinLeft(array("jsca"=>"job_sub_category_applicants"), "tbr.job_sub_category_applicants_id = jsca.id", array(new Zend_Db_Expr("CASE WHEN jsca.sub_category_id IS NULL THEN tbr.job_sub_category_applicants_id ELSE jsca.sub_category_id END AS job_sub_category_applicants_id")))
				->where("tbr.session_id = ?", $order["session_id"])
				);
				if ($row){
					$db->update("request_for_interview_job_order_session", $row, "session_id = ".$order["session_id"]);
				}

			}
		}
	}

	public function process(){
		$this->gatherInput();

		$this->preprocess();
		if (isset($_GET["filter_type"])){
			return $this->loadJobTitleDetails();
		}else{
			return $this->loadJobTitleDetailsDefault();
		}
	}
	
	
	public function getCount($hiringCoordinator, $dateFrom, $dateTo, $params=array()){
		$this->gatherInput();
		$this->hiring_coordinator = $hiringCoordinator;
		$this->date_from = $dateFrom;
		$this->date_to = $dateTo;
		$this->counterOnly = true;
		if (!empty($params)){
			if (isset($params["order_status"])){
				$this->order_status = $params["order_status"];
			}
			if (isset($params["service_type"])){
				$this->service_type = $params["service_type"];
			}
			
		}
		$this->filter_type = 3;
		$count = $this->loadJobTitleDetails();
		return $count["records"];
	}

	public function getLastContact($lead_id, $hiring_coordinator_id){
		$db = $this->db;
		
		$sql = $db->select()->from("history", array(new Zend_Db_Expr("DATE(date_created) AS last_contact")))->where("leads_id = ?", $lead_id);
		$sql2 = $db->select()->from(array("e"=>"tb_endorsement_history"), array(new Zend_Db_Expr("DATE(e.date_endoesed) AS last_contact")))->joinInner(array("l"=>"leads"), "l.id = e.client_name", array())->where("l.id = ?", $lead_id);
		$sql3 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array(new Zend_Db_Expr("CASE WHEN tbr.date_updated IS NULL THEN DATE(tbr.date_added) ELSE DATE(tbr.date_updated) END AS last_contact")))->joinInner(array("l"=>"leads"), "l.id = tbr.leads_id", array())->where("l.id = ?", $lead_id);
		$sql = $db->select()->union(array($sql, $sql2, $sql3))->order("last_contact DESC");
		$history = $db->fetchRow($sql);
		if ($history&&$history["last_contact"]){
			return $history["last_contact"];
		}else{
			return "No Last Contact";
		}	

	}
	
	private function getSQLForKeywordSearch($sql){
		if ($this->keyword!=""){
			$sql = $this->createClientStaffSearchSelect()->order("date_filled_up DESC");
			$sort_order = array();

			if (!empty($this->sorters)){
				$ascSorters = array();
				$descSorters = array();
				foreach($this->sorters as $sorter){
					if ($sorter["column"]=="client"){
						if ($sorter["direction"]=="ASC"){
							$ascSorters[] = "lead_firstname";
							$ascSorters[] = "lead_lastname";
						}else{
							$descSorters[] = "lead_firstname";
							$descSorters[] = "lead_lastname";
						}
					}else if ($sorter["column"]=="assigned_hiring_coordinator"){
						if ($sorter["direction"]=="ASC"){
							$ascSorters[] = "hc_fname";
							$ascSorters[] = "hc_lname";
						}else{
							$descSorters[] = "hc_fname";
							$descSorters[] = "hc_lname";
						}
					}else if ($sorter["column"]=="assigned_business_developer"){
						if ($sorter["direction"]=="ASC"){
							$ascSorters[] = "bp_fname";
							$ascSorters[] = "bp_lname";
						}else{
							$descSorters[] = "bp_fname";
							$descSorters[] = "bp_lname";
						}
					}else{
						if ($sorter["direction"]=="ASC"){
							$ascSorters[] = $sorter["column"];
						}else{
							$descSorters[] = $sorter["column"];
						}
					}
				}
				$sort_order = array();
				if (!empty($ascSorters)){
					$sort_order[] = new Zend_Db_Expr(implode(",", $ascSorters)." ASC");
				}
				if (!empty($descSorters)){
					$sort_order[] = new Zend_Db_Expr(implode(",", $descSorters)." DESC");
				}
					
			}else{
				$sort_order = array("date_filled_up DESC");
			}

			$sql = $sql
			->order($sort_order);	
		}
		return $sql;
	}

	
	private function addBasicFilterASL($sqlNoJS){
		if ($this->filter_type==3){
			if (isset($_GET["today"])){
				$sqlNoJS->having("DATE(date_filled_up) <= DATE(?)", date("Y-m-d"));//->having("date_filled_up >= '2012-02-01'");
			}else if (isset($_GET["closing"])){
				$sqlNoJS->having("date_closed IS NOT NULL")
				->having("DATE(date_closed) >= ?", $this->date_from)
				->having("DATE(date_closed) <= ?", $this->date_to);
			}else{
				$sqlNoJS->having("date_filled_up IS NOT NULL")
				->having("DATE(date_filled_up) >= ?", $this->date_from)
				->having("DATE(date_filled_up) <= ?", $this->date_to);
			}
			
		}else if ($this->filter_type==7){
			$this->age_from = addslashes($this->age_from);
			$this->age_to = addslashes($this->age_to);
			$sqlNoJS->having("age >= {$this->age_from} AND age <= {$this->age_to}");
		}
		
	}
	
	private function addBasicFilter($sql, $sqlNoJS){
		if ($this->filter_type==1){
			$text = addslashes($this->filter_text);
			$sql->where("gs_jtd.selected_job_title LIKE '".$text."%'");
		}else if ($this->filter_type==2){
			$sql->where("gs_jtd.work_status = ?", $this->filter_text);
		}else if ($this->filter_type==3){
			if (isset($_GET["today"])){
				$sql->having("DATE(date_filled_up) <= ?", date("Y-m-d"))->having("date_filled_up >= '2012-02-01'");

				$sqlNoJS->having("DATE(date_filled_up) <= ?",  date("Y-m-d"))->having("date_filled_up >= '2012-02-01'");
			}else if (isset($_GET["closing"])){
				$sql->having("date_closed IS NOT NULL")
				->having("DATE(date_closed) >= ?", $this->date_from)
				->having("DATE(date_closed) <= ?", $this->date_to);
	
				$sqlNoJS->having("date_closed IS NOT NULL")
				->having("DATE(date_closed) >= ?", $this->date_from)
				->having("DATE(date_closed) <= ?", $this->date_to);
					
			}else{
				$sql->having("date_filled_up IS NOT NULL")
				->having("DATE(date_filled_up) >= ?", $this->date_from)
				->having("DATE(date_filled_up) <= ?", $this->date_to);
	
				$sqlNoJS->having("date_filled_up IS NOT NULL")
				->having("DATE(date_filled_up) >= ?", $this->date_from)
				->having("DATE(date_filled_up) <= ?", $this->date_to);
					
			}
							

		}else if ($this->filter_type==4){
			$sql->where("jcl.jr_currency = ?", $this->currency)
			->where("gs_jtd.work_status = ?", $this->work_type);

			if ($this->rate_type=="Hourly"){
				$sql->having("budget_hourly BETWEEN {$this->budget_from} AND {$this->budget_to}");
			}else{
				$sql->having("budget_monthly BETWEEN {$this->budget_from} AND {$this->budget_to}");
			}
			if ($this->cat_level == "Entry"){
				$sql->where("gs_jtd.level = 'entry'");
			}else if ($this->cat_level == "Middle"){
				$sql->where("gs_jtd.level = 'mid'");
			}else{
				$sql->where("gs_jtd.level = 'expert'");
			}

		}else if ($this->filter_type==5){
			$sql->where("gs_jtd.working_timezone = ?", $this->filter_text);
		}else if ($this->filter_type==6){
			if ($this->period_from!=""){
				$sql->where("DATE(gs_jtd.date_filled_up) = DATE(?)", $this->period_from)
				->where("gs_jrs.proposed_start_date = ?", $this->period);
			}else{
				$sql->where("gs_jrs.proposed_start_date = ?", $this->period);
			}
		}else if ($this->filter_type==7){
			if (($this->age_from!="")&&($this->age_to!="")){
				$this->age_from = addslashes($this->age_from);
				$this->age_to = addslashes($this->age_to);
				$sql->having("age >= {$this->age_from} AND age <= {$this->age_to}");
				$sqlNoJS->having("age >= {$this->age_from} AND age <= {$this->age_to}");
			}
		}			
	}
	
	private function transformASLandCustomWithoutFilters($sql,$sqlNoJS,$sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2=null){
		$sqlJS = $sql;
		$db = $this->db;		
		if ($this->keyword==""){
			
			
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
				}
				$sqlJS->having("service_type = '{$value}'");
				$sqlMergeJS->where("mo.service_type = '{$value}'");
			}else{
				$sqlJS->having("service_type IN ('CUSTOM', 'ASL', 'BACK ORDER', 'REPLACEMENT', 'INHOUSE')");
				$sqlMergeJS->where("mo.service_type IN ('CUSTOM', 'ASL', 'BACK ORDER', 'REPLACEMENT', 'INHOUSE')");
			}
			if ($this->order_status == 0){
				$sqlJS->where("gs_jtd.status = 'new' OR gs_jtd.status = 'active'");
				$sqlNoJS->having("status = 'Open' OR status='new' OR status='active' OR status IS NULL OR status = ''");
				$sqlNoJS2->having("status = 'Open' OR status='new' OR status='active' OR status IS NULL");
				$sqlMergeJS->where("mo.order_status = 'Open' OR mo.order_status = '' OR mo.order_status IS NULL");
				$sqlMergeNoJS->where("mo.order_status = 'Open' OR mo.order_status = '' OR mo.order_status IS NULL");
				$sqlMergeNoJS2->where("mo.order_status = 'Open' OR mo.order_status = '' OR mo.order_status IS NULL");
				//$sqlNoJS = $sqlNoJS->where("tbro.status = 'Open' OR tbro.status IS NULL");
			}else if ($this->order_status==1){
				$sqlJS->where("gs_jtd.status = 'finish'");
				$sqlNoJS->having("status = 'Closed' OR status = 'finish'");
				$sqlNoJS2->having("status = 'Closed' OR status = 'finish'");
				$sqlMergeJS->where("mo.order_status = 'Closed'");
				$sqlMergeNoJS->where("mo.order_status = 'Closed'");
				$sqlMergeNoJS2->where("mo.order_status = 'Closed'");
				//$sqlNoJS = $sqlNoJS->where("tbro.status = 'Closed' OR tbro.status IS NULL");
			}else if ($this->order_status==2){
				$sqlJS->where("gs_jtd.status = 'cancel'");
				$sqlNoJS->having("status = 'Cancel' OR status = 'cancel'");
				$sqlNoJS2->having("status = 'Cancel' OR status = 'cancel'");
				$sqlMergeJS->where("mo.order_status = 'Cancel'");
				$sqlMergeNoJS->where("mo.order_status = 'Cancel'");
				$sqlMergeNoJS2->where("mo.order_status = 'Cancel'");
				//$sqlNoJS = $sqlNoJS->where("tbro.status = 'Cancel' OR tbro.status IS NULL");
			}else if ($this->order_status==3){
				$sqlJS->where("gs_jtd.status = 'onhold'");
				$sqlNoJS->having("status = 'On Hold' OR status = 'onhold'");
				$sqlNoJS2->having("status = 'Cancel' OR status = 'cancel'");
				$sqlMergeJS->where("mo.order_status = 'OnHold'");
				$sqlMergeNoJS->where("mo.order_status = 'OnHold'");
				$sqlMergeNoJS2->where("mo.order_status = 'OnHold'");
			}else if ($this->order_status==4){
				$sqlJS->where("gs_jtd.status = 'ontrial'");
				$sqlNoJS->having("status = 'On Trial' OR status = 'ontrial'");
				$sqlNoJS2->having("status = 'Cancel' OR status = 'cancel'");
				$sqlMergeJS->where("mo.order_status = 'OnTrial'");
				$sqlMergeNoJS->where("mo.order_status = 'OnTrial'");
				$sqlMergeNoJS2->where("mo.order_status = 'OnTrial'");
			}

			if ($this->recruiter!=""){
				$sqlJS->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"gs_jtd.gs_job_titles_details_id = gjo_rl.link_id",
				array());
				$sqlJS->where("gjo_rl.recruiters_id = ?", $this->recruiter);
				
				$sqlNoJS->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"l.id = gjo_rl.link_id",
				array());
				$sqlNoJS->where("gjo_rl.recruiters_id = ?", $this->recruiter);
				$sqlNoJS2->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"l.id = gjo_rl.link_id",
				array());
				$sqlNoJS2->where("gjo_rl.recruiters_id = ?", $this->recruiter);
				

				$sqlMergeJS->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"gs_jtd.gs_job_titles_details_id = gjo_rl.link_id",
				array());
				$sqlMergeJS->where("gjo_rl.recruiters_id = ?", $this->recruiter);
				$sqlMergeNoJS->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"l.id = gjo_rl.link_id",
				array());
				$sqlMergeNoJS->where("gjo_rl.recruiters_id = ?", $this->recruiter);
				$sqlMergeNoJS2->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"l.id = gjo_rl.link_id",
				array());
				$sqlMergeNoJS2->where("gjo_rl.recruiters_id = ?", $this->recruiter);
			}
			if ($this->hiring_coordinator=="nohm"){
				$sqlJS->where("l.hiring_coordinator_id IS NULL");
				$sqlNoJS->where("l.hiring_coordinator_id IS NULL");
				$sqlNoJS2->where("l.hiring_coordinator_id IS NULL");
				$sqlMergeJS->where("l.hiring_coordinator_id IS NULL");
				$sqlMergeNoJS->where("l.hiring_coordinator_id IS NULL");
				$sqlMergeNoJS2->where("l.hiring_coordinator_id IS NULL");
				
			}else if ($this->hiring_coordinator!=""){
				$sqlJS->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlNoJS->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlNoJS2->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlMergeJS->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlMergeNoJS->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlMergeNoJS2->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				
			}

			$sqlJS->group("gs_jtd.gs_job_titles_details_id");
			//$sqlNoJS->group("l.id");
			$sqlMergeJS->group("gs_jtd.gs_job_titles_details_id");
			
			$sort_order = array();
			if (!empty($this->sorters)){
				foreach($this->sorters as $sorter){
					if ($sorter["column"]=="client"){
						$sort_order[] = "client ".$sorter["direction"];
					}else if ($sorter["column"]=="assigned_hiring_coordinator"){
						$sort_order[] = "hc_fname ".$sorter["direction"];
						$sort_order[] = "hc_lname ".$sorter["direction"];
					}else if ($sorter["column"]=="assigned_business_developer"){
						$sort_order[] = "bp_fname ".$sorter["direction"];
						$sort_order[] = "bp_lname ".$sorter["direction"];
					}else{
						$sort_order[] = $sorter["column"]." ".$sorter["direction"];
					}
				}
			}else{
				$sort_order = array("date_filled_up DESC");
			}
			$sort_order[] = "timestamp desc";
			if ($this->service_type!=0){
				$value = "";
				if ($this->service_type == 1){
					$value="CUSTOM";
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS))->order($sort_order);
				}else if ($this->service_type==2){
					$value="ASL";
					$sql = $db->select()->union(array($sqlJS,$sqlMergeJS,$sqlMergeNoJS, $sqlMergeNoJS2, $sqlNoJS, $sqlNoJS2) )->order($sort_order);
				}else if ($this->service_type==3){
					$value="BACK ORDER";
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS) )->order($sort_order);
				}else if ($this->service_type==4){
					$value="REPLACEMENT";
					$sql = $sqlJS;
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS))->order($sort_order);
					
				}else if ($this->service_type==5){
					$value="INHOUSE";
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS))->order($sort_order);
				}else{
					$sql = $db->select()->union(array($sqlJS, $sqlNoJS,$sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2))->order($sort_order);
				}

			}else{
				$sql = $db->select()->union(array($sqlJS, $sqlNoJS,$sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2))->order($sort_order);
			}
		}
		return $sql;
	}
	
	private function attachOrderStatus($sql, $order_status){
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
		
		
	}
	
	
	private function transformASLandCustomWithFilters($sql, $sqlNoJS, $sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2){
		$db = $this->db;
		if ($this->keyword==""){
			
			
			if ($this->service_type==2){
				$this->attachHavingOnClientStaffSearch($sql);
				$this->attachHavingOnClientStaffSearch($sqlNoJS);
				$this->attachHavingOnClientStaffSearch($sqlNoJS2);
				$this->attachHavingOnClientStaffSearch($sqlMergeJS);
				$this->attachHavingOnClientStaffSearch($sqlMergeNoJS);
				$this->attachHavingOnClientStaffSearch($sqlMergeNoJS2);
			}else{
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
					}
					$sql->having("service_type = '{$value}'");
					$sqlMergeJS->where("mo.service_type = '{$value}'");
				}else{
					$sql->having("service_type IN ('CUSTOM', 'ASL', 'BACK ORDER', 'REPLACEMENT', 'INHOUSE')");
					$sqlMergeJS->where("mo.service_type IN ('CUSTOM', 'ASL', 'BACK ORDER', 'REPLACEMENT', 'INHOUSE')");
				}
				
				$this->attachOrderStatus($sql, $this->order_status);
				$this->attachOrderStatus($sqlNoJS, $this->order_status);
				$this->attachOrderStatus($sqlNoJS2, $this->order_status);
				$this->attachOrderStatus($sqlMergeJS, $this->order_status);
				$this->attachOrderStatus($sqlMergeNoJS, $this->order_status);
				$this->attachOrderStatus($sqlMergeNoJS2, $this->order_status);
				
			}
			
			
			//attach recruiter filter
			if ($this->recruiter!=""){
				$sql->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"gs_jtd.gs_job_titles_details_id = gjo_rl.link_id",
				array());
				$sql->where("gjo_rl.recruiters_id = ?", $this->recruiter);
				$sqlMergeJS->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
											"gs_jtd.gs_job_titles_details_id = gjo_rl.link_id",
				array());
				$sqlMergeJS->where("gjo_rl.recruiters_id = ?", $this->recruiter);
				
			}
			//attach hiring manager filter
			if ($this->hiring_coordinator=="nohm"){
				$sql->where("l.hiring_coordinator_id IS NULL");
				$sqlNoJS->where("l.hiring_coordinator_id IS NULL");
				$sqlNoJS2->where("l.hiring_coordinator_id IS NULL");
				$sqlMergeJS->where("l.hiring_coordinator_id IS NULL");
				$sqlMergeNoJS->where("l.hiring_coordinator_id IS NULL");
				$sqlMergeNoJS2->where("l.hiring_coordinator_id IS NULL");
			}else if ($this->hiring_coordinator!=""){
				$sql->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlNoJS->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlNoJS2->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlMergeJS->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlMergeNoJS->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
				$sqlMergeNoJS2->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
			}
			
			//render sorters
			$sort_order = array();
			if (!empty($this->sorters)){
				foreach($this->sorters as $sorter){
					if ($sorter["column"]=="client"){
						$sort_order[] = "client ".$sorter["direction"];
					}else if ($sorter["column"]=="assigned_hiring_coordinator"){
						$sort_order[] = "hc_fname ".$sorter["direction"];
						$sort_order[] = "hc_lname ".$sorter["direction"];
					}else if ($sorter["column"]=="assigned_business_developer"){
						$sort_order[] = "bp_fname ".$sorter["direction"];
						$sort_order[] = "bp_lname ".$sorter["direction"];
					}else{
						$sort_order[] = $sorter["column"]." ".$sorter["direction"];
					}
				}
			}else{
				$sort_order = array("date_filled_up DESC");
			}
			$sort_order[] = "timestamp desc";
			
			$sqlJS = $sql;
			
			if ($this->service_type!=0){
				$value = "";
				if ($this->service_type == 1){
					$value="CUSTOM";
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS))->order($sort_order);
				}else if ($this->service_type==2){
					$value="ASL";
					$sql = $db->select()->union(array($sqlJS,$sqlMergeJS,$sqlMergeNoJS, $sqlMergeNoJS2, $sqlNoJS, $sqlNoJS2) )->order($sort_order);
				}else if ($this->service_type==3){
					$value="BACK ORDER";
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS) )->order($sort_order);
				}else if ($this->service_type==4){
					$value="REPLACEMENT";
					$sql = $sqlJS;
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS))->order($sort_order);
					
				}else if ($this->service_type==5){
					$value="INHOUSE";
					$sql = $db->select()->union(array($sqlJS, $sqlMergeJS))->order($sort_order);
				}else{
					$sql = $db->select()->union(array($sqlJS, $sqlNoJS,$sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2))->order($sort_order);
				}

			}else{
				$sql = $db->select()->union(array($sqlJS, $sqlNoJS,$sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2))->order($sort_order);
			}
			
		}
		return $sql;
	}
	
	
	private function loadJobTitleDetails(){
		$db = $this->db;
		$sql = $this->createSelect();
		$sqlNoJS = $this->createEmptyJSLeadQuery();
		$sqlNoJS2 = $this->createEmptyJSLeadQueryViaJobSubCategory();
		$sqlMergeJS = $this->mergeProcessor->getMergeOrderSelect();
		$sqlMergeNoJS = $this->mergeProcessor->getMergeASLSelect();
		$sqlMergeNoJS2 = $this->mergeProcessor->getMergeASLSelectViaJobSubCategory();
		if ($this->filter_type==0){
			if (trim($this->keyword)!=""){
				$sql = $this->getSQLForKeywordSearch($sql);
				//echo $sql->__toString();
			}			
			
		}else{
			$this->addBasicFilter($sql, $sqlNoJS);
			$this->addBasicFilter($sqlMergeJS, $sqlMergeNoJS);
			$this->addBasicFilterASL($sqlMergeNoJS2);
			$this->addBasicFilterASL($sqlNoJS2);
		}


		//filter type is zero we need to add filters for Lead with no JS
		if (trim($this->keyword)==""){
			if ($this->filter_type==0){
				$sql = $this->transformASLandCustomWithoutFilters($sql, $sqlNoJS, $sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2);
			}else{
				$sql = $this->transformASLandCustomWithFilters($sql, $sqlNoJS, $sqlNoJS2, $sqlMergeJS, $sqlMergeNoJS, $sqlMergeNoJS2);
			}
		}
		
		//$totalRecords = count($db->fetchAll($sql));
	
		//get Job List with limit
		if ($this->limit){
			if ($this->filter_type==7||$this->filter_type==3){
				$start = ($this->page - 1) * $this->rows;
				$end = $this->rows;
				$sql.=" LIMIT $start, $end";
			}else{
				$sql->limitPage($this->page, $this->rows);
					
			}	
		}
		if ($this->filter_type==7||$this->filter_type==3){
			$sql = str_replace("AS `gs_jtd`", "AS `gs_jtd` FORCE INDEX (PRIMARY)",$sql);
		}else{
			$sql = str_replace("AS `gs_jtd`", "AS `gs_jtd` FORCE INDEX (PRIMARY)",$sql->__toString());
		}
		$sql = str_replace("AS `tbr`", "AS `tbr` FORCE INDEX(PRIMARY, REQUEST_FOR_INTERVIEW_STATUS_APPLICANT)", $sql);
		$sql = str_replace("AS `moi`", "AS `moi` FORCE INDEX(MERGED_ORDER_ID)", $sql);
		$jobList = $db->fetchAll($sql);
        
		$totalRecords = $db->fetchOne("SELECT FOUND_ROWS()");
		if (!$this->counterOnly){
			$jobList = $this->transformData($jobList);	
		}
		//format data as array
		$rows = array();
		foreach($jobList as $list){
			$list["id"] = $list["posting_id"];
			$rows[] = $list;
		}

		$totalPages = ceil($totalRecords/$this->rows);
		if ($this->counterOnly){
			$result = array("records"=>$totalRecords);
		}else{
			$result = array("rows"=>$rows, "records"=>$totalRecords, "total"=>$totalPages, "page"=> $this->page, "sorters"=>$this->sorters);
		}
		
		return $result;


	}
	private function createKeywordAdditionalFilters($sql){

		if ($this->recruiter!=""){
			$sql->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"gs_jtd.gs_job_titles_details_id = gjo_rl.link_id",
			array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);

		}
		if ($this->hiring_coordinator=="nohm"){
			$sql->where("l.hiring_coordinator_id IS NULL");
		}else if ($this->hiring_coordinator!=""){
			$sql->where("l.hiring_coordinator_id = ?", $this->hiring_coordinator);
		}
		

		return $sql;
	}


	private function attachHavingOnClientStaffSearch($sql){
		if ($this->order_status!=-1){
			if ($this->order_status == 0){
				$sql->having("status = 'new' OR status = 'active' OR status = 'OPEN' OR status = 'Open' OR status IS NULL OR status = ''");
			}else if ($this->order_status==1){
				$sql->having("status IN ('finish', 'Closed')");
			}else if ($this->order_status==2){
				$sql->having("status IN ('cancel', 'Cancel')");
			}else if ($this->order_status==3){
				$sql->having("status IN ('onhold', 'OnHold')");
			}else if ($this->order_status==4){
				$sql->having("status IN ('ontrial', 'OnTrial')");
			}
		}
		
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
			}
			$sql->having("service_type = '{$value}'");
		}

		return $sql;
	}


	private function performClientStaffSearch($keyword){
		$db = $this->db;

		$sqlInterviewedAndRejected = $this->createSelect()
										->joinLeft(array("p"=>"posting"),
											"p.job_order_id = gs_jtd.gs_job_titles_details_id",
								 		array())
										->joinRight(array("end"=>"tb_endorsement_history"), "end.position = p.id", array())
										->joinInner(array("pers"=>"personal"),"end.userid = pers.userid",array())
										->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'");



		$this->createKeywordAdditionalFilters($sqlInterviewedAndRejected)->group("gs_jtd.gs_job_titles_details_id")
										->having("gs_jtd.gs_job_titles_details_id <> ''");

		$this->attachHavingOnClientStaffSearch($sqlInterviewedAndRejected);

		
		$sqlMergeInterviewedAndRejected = $this->mergeProcessor->getMergeOrderSelect()
											->joinLeft(array("p"=>"posting"),
												"p.job_order_id = gs_jtd.gs_job_titles_details_id",
								 			array())
											->joinRight(array("end"=>"tb_endorsement_history"), "end.position = p.id", array())
											->joinInner(array("pers"=>"personal"),"end.userid = pers.userid",array())
											->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'");		
		$this->createKeywordAdditionalFilters($sqlMergeInterviewedAndRejected)
											->group("mo.id")
											->having("gs_jtd.gs_job_titles_details_id <> ''");
		$this->attachHavingOnClientStaffSearch($sqlMergeInterviewedAndRejected);
		
		
		$sqlShortlisted = $this->createSelect("Right", false)
							->joinInner(array("p"=>"posting"),
								"p.job_order_id = gs_jtd.gs_job_titles_details_id",
				 			array())
							->joinRight(array("sh"=>"tb_shortlist_history"),"sh.position = p.id",array())
							->joinInner(array("pers"=>"personal"),"pers.userid = sh.userid",array())
							->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'");

		$this->createKeywordAdditionalFilters($sqlShortlisted)->group("gs_jtd.gs_job_titles_details_id")
		->having("gs_jtd.gs_job_titles_details_id <> ''");

		$this->attachHavingOnClientStaffSearch($sqlShortlisted);

		
		$sqlMergeShortlisted = $this->mergeProcessor->getMergeOrderSelect()
									->joinInner(array("p"=>"posting"),
										"p.job_order_id = gs_jtd.gs_job_titles_details_id",
						 			array())
									->joinRight(array("sh"=>"tb_shortlist_history"),"sh.position = p.id",array())
									->joinInner(array("pers"=>"personal"),"pers.userid = sh.userid",array())
									->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'");
		$this->createKeywordAdditionalFilters($sqlMergeShortlisted)->group("mo.id")
									->having("gs_jtd.gs_job_titles_details_id <> ''");
		$this->attachHavingOnClientStaffSearch($sqlMergeShortlisted);
		
		
		
		$sqlClient = $this->createSelect("Right", false)->where("CONCAT(l.fname, ' ', l.lname) LIKE '%{$keyword}%'");
			
		$this->createKeywordAdditionalFilters($sqlClient)->group("gs_jtd.gs_job_titles_details_id")
					->having("gs_jtd.gs_job_titles_details_id <> ''");

		$this->attachHavingOnClientStaffSearch($sqlClient);
		
		
		$sqlMergeClient = $this->mergeProcessor->getMergeOrderSelect()->where("CONCAT(l.fname, ' ', l.lname) LIKE '%{$keyword}%'");
		$this->createKeywordAdditionalFilters($sqlMergeClient)->group("mo.id")
							->having("gs_jtd.gs_job_titles_details_id <> ''");
		$this->attachHavingOnClientStaffSearch($sqlMergeClient);
		
		$sqlASL = $this->createEmptyJSLeadQuery()
					->joinInner(array("pers"=>"personal"),
						"pers.userid = tbr.applicant_id", array()
					)->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'")
					;
					
		
		if ($this->recruiter!=""){
			$sqlASL->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
			array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlASL);
		$sqlASLLead = $this->createEmptyJSLeadQuery()->where("CONCAT(l.fname, ' ', l.lname) LIKE '%{$keyword}%'");
		if ($this->recruiter!=""){
			$sqlASLLead->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
			array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlASLLead);
		$sqlASL2 = $this->createEmptyJSLeadQueryViaJobSubCategory()
					->joinInner(array("pers"=>"personal"),
						"pers.userid = tbr.applicant_id", array()
					)->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'");
		
		if ($this->recruiter!=""){
			$sqlASL2->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
			array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlASL2);
		$sqlASL2Lead = $this->createEmptyJSLeadQueryViaJobSubCategory()->where("CONCAT(l.fname, ' ', l.lname) LIKE '%{$keyword}%'");
							
		if ($this->recruiter!=""){
			$sqlASL2Lead->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
			array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		
		$this->attachHavingOnClientStaffSearch($sqlASL2Lead);
		
		$sqlMergeASL = $this->mergeProcessor->getMergeASLSelect()
					->joinInner(array("pers"=>"personal"),
						"pers.userid = tbr.applicant_id", array()
					)->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'");
		if ($this->recruiter!=""){
			$sqlMergeASL->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlMergeASL);
		
		$sqlMergeASLLead = $this->mergeProcessor->getMergeASLSelect()
					->where("CONCAT(l.fname, ' ', l.lname) LIKE '%{$keyword}%'");
		if ($this->recruiter!=""){
			$sqlMergeASLLead->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlMergeASLLead);
		
		$sqlMergeASL2 = $this->mergeProcessor->getMergeASLSelectViaJobSubCategory()
					->joinInner(array("pers"=>"personal"),
						"pers.userid = tbr.applicant_id", array()
					)->where("CONCAT(pers.fname, ' ', pers.lname) LIKE '%{$keyword}%'");
		if ($this->recruiter!=""){
			$sqlMergeASL2->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlMergeASL2);
		
		$sqlMergeASL2Lead = $this->mergeProcessor->getMergeASLSelectViaJobSubCategory()->where("CONCAT(l.fname, ' ', l.lname) LIKE '%{$keyword}%'");
		if ($this->recruiter!=""){
			$sqlMergeASL2Lead->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlMergeASL2Lead);
		
		
		
		if ($this->service_type==0){
			return $db->select()->union(array($sqlInterviewedAndRejected, $sqlShortlisted, $sqlClient, $sqlASL, $sqlMergeInterviewedAndRejected, $sqlMergeShortlisted, $sqlMergeClient, $sqlMergeASL, $sqlMergeASL2, $sqlASL2, $sqlASLLead, $sqlASL2Lead, $sqlMergeASLLead, $sqlMergeASL2Lead));
		}else if ($this->service_type==2){
			return $db->select()->union(array($sqlInterviewedAndRejected, $sqlShortlisted, $sqlClient, $sqlASL, $sqlMergeInterviewedAndRejected, $sqlMergeShortlisted, $sqlMergeClient, $sqlMergeASL, $sqlMergeASL2, $sqlASL2, $sqlASLLead, $sqlASL2Lead, $sqlMergeASLLead, $sqlMergeASL2Lead));
		}else{
			return $db->select()->union(array($sqlInterviewedAndRejected, $sqlShortlisted, $sqlClient, $sqlMergeClient, $sqlMergeInterviewedAndRejected, $sqlMergeShortlisted));
		}
		
	}

	private function performTrackingCodeSearch($keyword){
		$sqlCustom = $this->createSelect();
		$sqlASL1 = $this->createEmptyJSLeadQuery();
		$sqlASL2 = $this->createEmptyJSLeadQueryViaJobSubCategory();
		$sqlMergeCustom = $this->mergeProcessor->getMergeOrderSelect();
		$sqlMergeASL1 = $this->mergeProcessor->getMergeASLSelectViaJobSubCategory();
		$sqlMergeASL2 = $this->mergeProcessor->getMergeASLSelect();
		$sqlCustom->having("tracking_code LIKE '".addslashes($keyword)."%'");
		$sqlASL1->having("tracking_code LIKE '".addslashes($keyword)."%'");
		$sqlASL2->having("tracking_code LIKE '".addslashes($keyword)."%'");
		$sqlMergeCustom->having("tracking_code LIKE '".addslashes($keyword)."%'");
		$sqlMergeASL1->having("tracking_code LIKE '".addslashes($keyword)."%'");
		$sqlMergeASL2->having("tracking_code LIKE '".addslashes($keyword)."%'");
		if ($this->recruiter!=""){
			$sqlCustom->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
			$sqlASL1->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
			$sqlASL2->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
			$sqlMergeASL1->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
			$sqlMergeASL2->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
			$sqlMergeCustom->joinRight(array("gjo_rl"=>"gs_job_orders_recruiters_links"),
												"l.id = gjo_rl.link_id",
									array())->where("gjo_rl.recruiters_id = ?", $this->recruiter);
		}
		$this->attachHavingOnClientStaffSearch($sqlCustom);
		$this->attachHavingOnClientStaffSearch($sqlASL1);
		$this->attachHavingOnClientStaffSearch($sqlASL2);
		$this->attachHavingOnClientStaffSearch($sqlMergeCustom);
		$this->attachHavingOnClientStaffSearch($sqlMergeASL1);
		$this->attachHavingOnClientStaffSearch($sqlMergeASL2);
		return $this->db->select()->union(array($sqlCustom, $sqlASL1, $sqlASL2, $sqlMergeCustom, $sqlMergeASL1, $sqlMergeASL2));
	}
	


	private function createClientStaffSearchSelect(){
		$db = $this->db;
		$types = array("CUSTOM", "ASL", "REPLACEMENT", "BACK ORDER", "REPLACEMENT", "INHOUSE");
		$keyword = $this->keyword;
		$satisfiedTrackCode = false;
		$chopKeyword = explode("-", $keyword);
		if (count($chopKeyword)>=2&&count($chopKeyword)<=3){
			foreach($types as $type){
				if (strpos($keyword, $type)!==false){
					$satisfiedTrackCode = true;
					break;
				}	
			}	
		}
		if (is_numeric($keyword)||$satisfiedTrackCode){
			return $this->performTrackingCodeSearch($keyword);
		}else{
			return $this->performClientStaffSearch($keyword);
		}
		
		

	}

	
	private function createEmptyJSLeadQueryViaJobSubCategory($excludeMerge=true){
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
		array("l.fname AS lead_firstname",
								"l.lname AS lead_lastname",
								 "CONCAT(l.fname, ' ', l.lname) AS client",
						  		 "l.business_partner_id AS business_partner_id",
						  		 "l.hiring_coordinator_id AS assigned_hiring_coordinator_id",
								 "l.timestamp AS timestamp",
								 "l.id AS leads_id",
								 "CONCAT('') AS asl_order_id")				
		)->joinInner(array("jsca"=>"job_sub_category_applicants"),
								"jsca.id = tbr.job_sub_category_applicants_id",
		array()
		)
			
		->joinLeft(array("rfos"=>"request_for_interview_job_order_session"),
								new Zend_Db_Expr("rfos.job_sub_category_applicants_id = jsca.sub_category_id AND DATE(rfos.date_added) = DATE(tbr.date_added) AND rfos.lead_id = tbr.leads_id"),
		array())
			
		->joinLeft(array("adm"=>"admin"),
										"adm.admin_id = l.hiring_coordinator_id",
		array(
		new Zend_Db_Expr("case when adm.admin_fname is null then 'zzz' else adm.admin_fname end AS hc_fname"),
		new Zend_Db_Expr("case when adm.admin_lname is null then 'zzz' else adm.admin_lname end AS hc_lname"))
		)
		->joinLeft(array("agn"=>"agent"),
								"agn.agent_no = l.business_partner_id",
		array("agn.fname AS bp_fname",
									"agn.lname AS bp_lname",
								 	"CONCAT('TBA When JS is Filled') AS proposed_start_date",
									 "CONCAT('') AS gs_job_titles_details_id",
									 "CONCAT('TBA When JS is Filled') AS work_status",
		//new Zend_Db_Expr("(SELECT DISTINCT rfos1.status FROM request_for_interview_job_order_session rfos1 WHERE (rfos1.lead_id = tbr.leads_id AND DATE(rfos1.date_added) = DATE(tbr.date_added) AND rfos1.job_sub_category_applicants_id = tbr.job_sub_category_applicants_id) OR rfos1.session_id = tbr.session_id) AS status"),
									new Zend_Db_Expr("CASE WHEN DATE(tbr.date_added) < DATE('2012-02-01') THEN 'finish' ELSE CASE WHEN rfos.status IS NULL AND tbr.status='CANCELLED' THEN 'cancel' ELSE rfos.status END END AS status"),
									new Zend_Db_Expr("tbr.date_added AS date_filled_up"),
									new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(tbr.date_added)) AS age"),
							  		 "CONCAT('TBA When JS is Filled') AS working_timezone",
							  		 "CONCAT('') AS gs_job_role_selection_id",
							  		 "CONCAT('') AS jr_list_id",
							  		 "CONCAT('') AS jr_cat_id",
							  		 "CONCAT('') AS level",
							  		 "CONCAT('') AS no_of_staff_needed",
							  		 "CONCAT('') AS assigned_recruiter_id",
							  		 "CONCAT('ASL') AS service_type",
							  		 "CONCAT('TBA When JS is Filled') AS job_title",
							  		 "CONCAT('') AS budget_hourly",
							  		 "CONCAT('') AS budget_monthly",
		//new Zend_Db_Expr("CASE WHEN tbr.session_id <> 0 THEN tbr.session_id ELSE (SELECT session_id FROM tb_request_for_interview_orders tbroq WHERE tbroq.id = tbr.order_id) END AS session_id"),
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
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		return $sql;
	}

	private function createEmptyJSLeadQuery($excludeMerge=true){
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
				$merge_order_ids = implode(",", $merge_order_ids);
			}
		}
		
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "leads_id" ,"jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));
		$sql = $db->select()
		->from(array("tbr"=>"tb_request_for_interview"),
		array())
		->joinInner(array("l"=>"leads"),
							"tbr.leads_id = l.id",
		array("l.fname AS lead_firstname",
								"l.lname AS lead_lastname",
								 "CONCAT(l.fname, ' ', l.lname) AS client",
						  		 "l.business_partner_id AS business_partner_id",
						  		 "l.hiring_coordinator_id AS assigned_hiring_coordinator_id",
								 "l.timestamp AS timestamp",
								 "l.id AS leads_id",
								 "CONCAT('') AS asl_order_id")				
		)
		->joinLeft(array("rfos"=>"request_for_interview_job_order_session"),
								new Zend_Db_Expr("(CAST(rfos.job_sub_category_applicants_id AS signed) = CAST(tbr.job_sub_category_applicants_id AS signed) AND DATE(rfos.date_added) = DATE(tbr.date_added) AND (rfos.lead_id = tbr.leads_id))"),
		array())
			
		->joinLeft(array("adm"=>"admin"),
										"adm.admin_id = l.hiring_coordinator_id",
		array(
		new Zend_Db_Expr("case when adm.admin_fname is null then 'zzz' else adm.admin_fname end AS hc_fname"),
		new Zend_Db_Expr("case when adm.admin_lname is null then 'zzz' else adm.admin_lname end AS hc_lname"))
		)
		->joinLeft(array("agn"=>"agent"),
								"agn.agent_no = l.business_partner_id",
		array("agn.fname AS bp_fname",
									"agn.lname AS bp_lname",
								 	"CONCAT('TBA When JS is Filled') AS proposed_start_date",
									 "CONCAT('') AS gs_job_titles_details_id",
									 "CONCAT('TBA When JS is Filled') AS work_status",
		//new Zend_Db_Expr("(SELECT DISTINCT rfos1.status FROM request_for_interview_job_order_session rfos1 WHERE (rfos1.lead_id = tbr.leads_id AND DATE(rfos1.date_added) = DATE(tbr.date_added) AND rfos1.job_sub_category_applicants_id = tbr.job_sub_category_applicants_id) OR rfos1.session_id = tbr.session_id) AS status"),
									new Zend_Db_Expr("CASE WHEN DATE(tbr.date_added) < DATE('2012-02-01') THEN 'finish' ELSE CASE WHEN rfos.status IS NULL AND tbr.status='CANCELLED' THEN 'cancel' ELSE rfos.status END END AS status"),
									new Zend_Db_Expr("tbr.date_added AS date_filled_up"),
									new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(tbr.date_added)) AS age"),
							  		 "CONCAT('TBA When JS is Filled') AS working_timezone",
							  		 "CONCAT('') AS gs_job_role_selection_id",
							  		 "CONCAT('') AS jr_list_id",
							  		 "CONCAT('') AS jr_cat_id",
							  		 "CONCAT('') AS level",
							  		 "CONCAT('') AS no_of_staff_needed",
							  		 "CONCAT('') AS assigned_recruiter_id",
							  		 "CONCAT('ASL') AS service_type",
							  		 "CONCAT('TBA When JS is Filled') AS job_title",
							  		 "CONCAT('') AS budget_hourly",
							  		 "CONCAT('') AS budget_monthly",
		//new Zend_Db_Expr("CASE WHEN tbr.session_id <> 0 THEN tbr.session_id ELSE (SELECT session_id FROM tb_request_for_interview_orders tbroq WHERE tbroq.id = tbr.order_id) END AS session_id"),
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
		//$sql->group(array("bp_fname", "assigned_hiring_coordinator_id","date_filled_up", "jsca_id", "leads_id"))->having("leads_id IS NOT NULL");
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		return $sql;
	}

	public function getOrder($queryArray, $type, $transformed=true){
		$db = $this->db;
		if ($type=="custom"){
			
			$sql = $this->createSelect("Right", true, false)->where("gs_jtd.gs_job_titles_details_id = ?", $queryArray["order_id"]);
			$row = $db->fetchRow($sql);
			if ($transformed){
				return $this->getTransformedOrder($row);
			}else{
				return $row;
			}
		}else{
			$sql = $this->createEmptyJSLeadQuery(false)
							->where("tbr.job_sub_category_applicants_id = ?", $queryArray["jsca_id"])
							->where("tbr.leads_id = ?", $queryArray["lead_id"])
							->where("DATE(tbr.date_added) = ?", $queryArray["date_added"]);
			$row = $db->fetchRow($sql);
			if ($row){
				if ($transformed){
					return $this->getTransformedOrder($row);
				}else{
				 	return $row;
				}
			}else{
				$sql = $this->createEmptyJSLeadQueryViaJobSubCategory(false)
							->where("jsca.sub_category_id = ?", $queryArray["jsca_id"])
							->where("tbr.leads_id = ?", $queryArray["lead_id"])
							->where("DATE(tbr.date_added) = ?", $queryArray["date_added"]);
				$row = $db->fetchRow($sql);
				if ($transformed){
					return $this->getTransformedOrder($row);
				}else{
					return $row;
				}
			}			
		}
	}


	

	private function createSelect($direction="Right", $first=true, $excludeMerge=true){
		$db = $this->db;
		$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'Custom' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				$result[] = $item["link_id"];
			}
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
				$merge_order_ids = implode(",", $merge_order_ids);
			}
		}
		
		
		$join = "join$direction";

		if ($first){
			$expr = new Zend_Db_Expr("SQL_CALC_FOUND_ROWS l.fname AS lead_firstname");
		}else{
			$expr = new Zend_Db_Expr('l.fname AS lead_firstname');
		}
		
		$sql = $db->select()
		->from(array("l"=>"leads"),
		array($expr,
				"l.lname AS lead_lastname",
				"CONCAT(l.fname, ' ', l.lname) AS client",
				  		 "l.business_partner_id AS business_partner_id",
				  		 "l.hiring_coordinator_id AS assigned_hiring_coordinator_id",
						 "l.timestamp AS timestamp",
						"l.id AS leads_id",
						"CONCAT('') AS asl_order_id"
						)
						)
						->joinLeft(array("adm"=>"admin"),
					"adm.admin_id = l.hiring_coordinator_id",
						array("adm.admin_fname AS hc_fname",
						"adm.admin_lname AS hc_lname")
						)
						->joinLeft(array("agn"=>"agent"),
					"agn.agent_no = l.business_partner_id",
						array("agn.fname AS bp_fname", "agn.lname AS bp_lname"))
						->$join(array("gs_jrs"=>"gs_job_role_selection"),
					  		"gs_jrs.leads_id = l.id",
						array()
						);

						$sql->$join(array("gs_jtd"=>"gs_job_titles_details"),
					 "gs_jtd.gs_job_role_selection_id = gs_jrs.gs_job_role_selection_id",
					 array(new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jrs.proposed_start_date END AS proposed_start_date"),
					 		"gs_jtd.gs_job_titles_details_id AS gs_job_titles_details_id",
							new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.work_status END AS work_status"),
							new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END) < DATE('2012-02-01') THEN 'finish' ELSE gs_jtd.status END AS status"),
							new Zend_Db_Expr("CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE CASE WHEN gs_jrs.filled_up_date IS NOT NULL THEN DATE_FORMAT(gs_jrs.filled_up_date, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END END AS date_filled_up"),
					 new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END)) AS age"),
							new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.working_timezone END AS working_timezone"),
							"gs_jtd.gs_job_role_selection_id AS gs_job_role_selection_id",
							"gs_jtd.jr_list_id AS jr_list_id",
							"gs_jtd.jr_cat_id AS jr_cat_id",
				  			"gs_jtd.level AS level",
				  			"gs_jtd.no_of_staff_needed AS no_of_staff_needed",
							"gs_jtd.assigned_recruiter AS assigned_recruiter_id",
							new Zend_Db_Expr("CASE WHEN gs_jrs.jsca_id IS NULL OR gs_jtd.created_reason = 'Converted-From-ASL' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'Closed-To-Replacement' THEN gs_jtd.service_type ELSE 'ASL' END END AS service_type"),
					 		new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.selected_job_title END AS job_title")
					 		))

					 		->joinLeft(array("jcl"=>"job_role_cat_list"),
					"jcl.jr_list_id = gs_jtd.jr_list_id",
					 		array(new Zend_Db_Expr("CASE WHEN gs_jtd.level = 'entry' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_entry_price * 12)/52)/5)/4) ELSE ((((jcl.jr_entry_price * 12)/52)/5)/8) END WHEN gs_jtd.level = 'middle' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_mid_price * 12)/52)/5)/4) ELSE ((((jcl.jr_mid_price * 12)/52)/5)/8) END WHEN gs_jtd.level = 'expert' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_expert_price * 12)/52)/5)/4) ELSE ((((jcl.jr_expert_price * 12)/52)/5)/8) END END AS budget_hourly"),
						  		new Zend_Db_Expr("CASE WHEN gs_jtd.level = 'entry' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN jcl.jr_entry_price*.55 ELSE jcl.jr_entry_price END WHEN gs_jtd.level = 'middle' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN (jcl.jr_mid_price*.55) ELSE jcl.jr_mid_price END WHEN gs_jtd.level = 'expert' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN jcl.jr_expert_price*.55 ELSE jcl.jr_expert_price END END AS budget_monthly"),
						  		new Zend_Db_Expr("CASE WHEN gs_jrs.jsca_id IS NOT NULL THEN gs_jrs.jsca_id ELSE CONCAT('') END AS jsca_id"),
							    new Zend_Db_Expr("gs_jtd.date_closed AS date_closed"),
							    new Zend_Db_Expr("CONCAT('SINGLE') AS merge_status"),
							    new Zend_Db_Expr("CONCAT('') AS merged_order_id"),
								new Zend_Db_Expr("gs_jtd.created_reason AS created_reason"),
								new Zend_Db_Expr("CONCAT(gs_jtd.gs_job_titles_details_id, '-', CASE WHEN gs_jrs.jsca_id IS NULL OR gs_jtd.created_reason = 'Converted-From-ASL' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'Closed-To-Replacement' THEN gs_jtd.service_type ELSE 'ASL' END END) AS tracking_code")
					  		)
						  )
							->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
						  ->where("gs_jrs.leads_id <> '' OR gs_jrs.leads_id IS NOT NULL")
						  ->group(array("bp_fname", "assigned_hiring_coordinator_id", "l.id", "gs_jtd.gs_job_titles_details_id"));

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

	private function loadJobTitleDetailsDefault(){
		$this->filter_type = 0;
		$this->service_type = 0;
		$this->order_status = 0;
		$this->keyword = "";
		$this->recruiters = "";
		$this->hiring_coordinator = "";
		$this->display = "Display";
		$this->rows = 50;
		return $this->loadJobTitleDetails();

	}

	public function getNotes($gs_job_role_selection_id, $minimized=true){
		$db = $this->db;
		if ($gs_job_role_selection_id){
			$sql = $db->select()->from(array("gs_notes"=>"gs_admin_notes"), array("gs_notes.notes AS notes"))
			->where("gs_notes.gs_job_role_selection_id = ?", $gs_job_role_selection_id);
			$notes = $db->fetchAll($sql);
			if (!empty($notes)){
				if ($minimized){
					$result = "<ul class='notes-list' style='white-space:normal;width:220px;max-height:20em;overflow:hidden;'>";
				}else{
					$result = "<ul class='notes-list' style='white-space:normal;'>";				
				}
				foreach($notes as $note){
					$note["notes"] = str_replace("•", "<br/>•",$note["notes"]);
					$result.="<li>{$note["notes"]}</li>";
				}
				$result.="</ul>";
				return $result;
			}
			return "";
		}
		return "";
	}


	private function getASLOrderId($sessionId){
		$db = $this->db;
		if ($sessionId){
			$order = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("order_id"))->where("session_id = ?", $sessionId));
			return $order["order_id"];
		}else{
			return 0;
		}
	}

	private function transformData($jobList){
		$host = $_SERVER["SERVER_NAME"];
		if (!empty($jobList)){
			$i = 0;
			foreach($jobList as $list){
				//get the budget column based on Get Started Formulation
				if ($this->export){
					$jobList[$i] = $this->getTransformedOrderExport($list);			
				}else{
					$jobList[$i] = $this->getTransformedOrder($list);
				}
				$i++;
			}
		}

		return $jobList;
	}

	private function getTransformedOrderExport($list){
		$db = $this->db;
		$jr_list_id = $list["jr_list_id"];
		$jr_cat_id = $list["jr_cat_id"];
		$gs_job_titles_details_id = $list["gs_job_titles_details_id"];
		$gs_job_role_selection_id = $list["gs_job_role_selection_id"];
		$list["job_title_export"]  = $list["job_title"];
		if ($list["gs_job_titles_details_id"]!=""){
			if ($list["job_title"]!="TBA When JS is Filled"){
				$list["posting_id"] = $this->getPosting($list["gs_job_titles_details_id"]);				
			}else{
				$list["posting_id"] = null;
			}
		}else{
			$list["posting_id"] = null;
		}
		$jsca_id = $list["jsca_id"];
		if (!$gs_job_role_selection_id){
			$list["session_id"] = $this->getSessionIdForASL($list["jsca_id"], $list["date_filled_up"], $list["leads_id"]);
		}else{
			$list["session_id"] = $this->getSessionIdForCustom($gs_job_role_selection_id);
		}
		$sessionId = $list["session_id"];
		if ($list["service_type"]=="REPLACEMENT"){
			if ($list["job_title"]!="TBA When JS is Filled"){
				$id = $list["gs_job_titles_details_id"];
				while(true){
					try{
						$item = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $id));
						if ($item){
							if (isset($item["link_order_id"])){
								$list["posting_id"] = $this->getPosting($item["link_order_id"]);	
							}
						}
						if (is_null($list["posting_id"])){
							if (is_null($item["link_order_id"])){
								break;
							}else{
								$id = $item["link_order_id"];
							}
						}else{
							break;
						}
					}catch(Exception $e){
						break;
					}
											
				}	
			
			}
			$list["job_title"] = $this->renderJobAd($list["job_title"], $list["posting_id"]);
		}else{
			$list["job_title"] = $this->renderJobAd($list["job_title"], $list["posting_id"]);
		}
		$list["client_export"] = $list["client"];
		
		$list["client"] = $this->renderLeadsProfile($list["client"], $list["leads_id"]);
		if ($list["created_reason"]=="New JS Form Client"){
			$level = $list["level"];		
			if ($level=="expert"){
				$level = "advanced";
			}
			try{
				$currency = $list["currency"];
				 $jo = $db->fetchRow($db->select()->
	                from(array("jscnp"=>"job_sub_categories_new_prices"))
	                ->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jscnp.sub_category_id", array("sub_category_name"))
	                ->where("level = ?", $level)
	                ->where("currency = ?", $list["currency"])
	                ->where("jscnp.sub_category_id = ?", $list["job_order_sub_category_id"])
	                ->where("active = ?", 1));
				 
				if ($list["work_status"]=="Part-Time"){
	                $jo["value"] = number_format($jo["value"]*.6, 2);
	                $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/4, 2);
	            }else{
	                $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/8, 2);
	                $jo["value"] = number_format($jo["value"], 2);  
	            }
				$sql2 = $db->select()
				->from('currency_lookup')
				->where("code = '{$currency}'");
				$money = $db->fetchRow($sql2);
				
				$list["budget"] = sprintf("%s%s%s Hourly / %s%s Monthly", $list["currency"],$money["sign"],$jo["hourly_value"],$money["sign"],$jo["value"] );
			}catch(Exception $e){
				if ($list["budget_monthly"]&&$list["budget_hourly"]){
					$list["budget"] = $this->getBudget($jr_list_id, $list["work_status"], $list["level"]);
				}else{
					$list["budget"] = "TBA When JS is Filled";
				}
			}
		}else{
			if ($list["budget_monthly"]&&$list["budget_hourly"]){
				$list["budget"] = $this->getBudget($jr_list_id, $list["work_status"], $list["level"]);
			}else{
				$list["budget"] = "TBA When JS is Filled";
			}
		}
		if ($list["gs_job_role_selection_id"]!=""){
			if ($list["job_title"]!="TBA When JS is Filled"){
				if ($list["merge_status"]=="MERGE"){
					$list["job_specification_link"] = "<a href='/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE' target='_blank'>Click Me</a>";
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE";	
					}
					
				}else{
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}";	
					}
					
					$list["job_specification_link"] = "<a href='/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}' target='_blank'>Click Me</a>";	
				}
			}else{
				$filled = date("Y-m-d", strtotime($list["date_filled_up"]));
				if ($list["merge_status"]=="MERGE"){
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}";	
					}				
					$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}' target='_blank'>Click Me</a>";		
				}else{
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}";	
					}	
					$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}' target='_blank'>Click Me</a>";	
				}
			}
		}else{
			$filled = date("Y-m-d", strtotime($list["date_filled_up"]));
			if ($list["merge_status"]=="MERGE"){
				if (TEST){
					$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE";
				}else{
					$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE";	
				}	
				$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE' target='_blank'>Click Me</a>";		
			}else{
				if (TEST){
					$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}";
				}else{
					$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}";	
				}	
				
				$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}' target='_blank'>Click Me</a>";	
			}
			
		}
		$list["order_status"] = $this->getStatus($list["status"]);
		$list["notes"] = $this->getNotes($gs_job_role_selection_id);
		if ($list["date_filled_up"]!="TBA When JS is Filled"&&$list["proposed_start_date"]!="TBA When JS is Filled"){
			$list["proposed_start_date"] = $this->getFormattedDateRequired($list["date_filled_up"], $list["proposed_start_date"]);
		}
		if ($list["service_type"]=="REPLACEMENT"){
			$list["date_filled_up"] = date("Y-m-d", strtotime($list["date_filled_up"])).", ASAP";
		}else{
			$list["date_filled_up"] = date("Y-m-d", strtotime($list["date_filled_up"]));
		}
		if ($_SESSION['status']=="FULL-CONTROL"){
			$list["assigned_recruiter"] = $this->renderAssignedHR($list["assigned_recruiter_id"], $gs_job_titles_details_id, false, true);
			$list["assigned_hiring_coordinator"] = $this->renderAssignedHR($list["assigned_hiring_coordinator_id"], $gs_job_titles_details_id,true, true);
		}else{
			$list["assigned_recruiter"] = $this->renderAssignedHR($list["assigned_recruiter_id"], $gs_job_titles_details_id, false, false);
			$list["assigned_hiring_coordinator"] = $this->renderAssignedHR($list["assigned_hiring_coordinator_id"], $gs_job_titles_details_id, true, false);
		}
		if ($list["gs_job_role_selection_id"]!=""){
			$list["assigned_recruiters"] = $this->getRecruiterLinks($list["gs_job_titles_details_id"], "JO");
		}else{
			$list["assigned_recruiters"] = $this->getRecruiterLinks($list["leads_id"], "Lead");
		}
		$list["assigned_business_developer"] = $this->renderBusinessDeveloper($list["business_partner_id"]);
		$list["service_type"] = $list["service_type"];
		$list["order_status"] = $this->getStatus($list["status"]);
		/*
		if ($list["service_type"]=="ASL"){		
			$list["tracking_code"] = date("Ymd", strtotime($list["date_filled_up"])).$list["jsca_id"].$list["leads_id"]."-ASL";
		}else{	
			$list["tracking_code"] = $list["gs_job_titles_details_id"]."-".$list["service_type"];	
		}
		if ($list["merge_status"]=="MERGE"){
			$list["tracking_code"] = $list["merged_order_id"]."-{$list["service_type"]}-"."MERGE";
		}
		 * 
		 */
		if ($list["age"]<0){
			$list["age"] = 0;
		}
		//$list["asl_order_id"] = $this->getASLOrderId($list["session_id"]);
		$list["action"] = $this->display;
		$list["viewHistory"] = true;
		
		return $list;
		
	}

	public function getNotesForMergeOrder($merge_order_id, $minimized=true){
		$db = $this->db;
		//load all merge order which are custom based orders
		$orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"))->where("moi.merged_order_id = ?", $merge_order_id));
		//load all notes recursively
		if ($minimized){
			$result = "<ul class='notes-list' style='white-space:normal;width:220px;max-height:20em;overflow:hidden;'>";
		}else{
			$result = "<ul class='notes-list' style='white-space:normal;'>";
		}
		$count = 0;
		if (!empty($orders)){
			foreach($orders as $order){
				if (!is_null($order["gs_job_title_details_id"])){
					//get job role selection id
					$role = $db->fetchRow($db->select()->from("gs_job_titles_details", array("gs_job_role_selection_id"))->where("gs_job_titles_details_id = ?", $order["gs_job_title_details_id"]));
					if ($role){
						$sql = $db->select()->from(array("gs_notes"=>"gs_admin_notes"), array("gs_notes.notes AS notes"))
						->where("gs_notes.gs_job_role_selection_id = ?", $role["gs_job_role_selection_id"]);
						$notes = $db->fetchAll($sql);
						$item = "";
						if (!empty($notes)){
							foreach($notes as $note){
								$note["notes"] = str_replace("•", "<br/>•",$note["notes"]);
								$note["notes"] = nl2br($note["notes"]);
								$item.="<li>{$note["notes"]}</li>";
								$count++;
							}
							$result.=$item;
						}
					}			
				}

			}
		}
		if ($count==0){
			return "";
		}else{
			$result.= "</ul>";
			return $result;
		}
	}

	public function getTransformedOrder($list){
		$db = $this->db;
		
		if ($this->export){
			return 	$this->getTransformedOrderExport($list);
		}
		
		$this->staffLister->setOrder($list);
		$jr_list_id = $list["jr_list_id"];
		$jr_cat_id = $list["jr_cat_id"];
		$gs_job_titles_details_id = $list["gs_job_titles_details_id"];
		$gs_job_role_selection_id = $list["gs_job_role_selection_id"];
		$list["job_title_export"]  = $list["job_title"];
		if ($list["gs_job_titles_details_id"]!=""){
			if ($list["job_title"]!="TBA When JS is Filled"){
				$list["posting_id"] = $this->getPosting($list["gs_job_titles_details_id"]);				
			}else{
				$list["posting_id"] = null;
			}
		}else{
			$list["posting_id"] = null;
		}
		$jsca_id = $list["jsca_id"];
		if (!$gs_job_role_selection_id){
			$list["session_id"] = $this->getSessionIdForASL($list["jsca_id"], $list["date_filled_up"], $list["leads_id"]);
		}else{
			$list["session_id"] = $this->getSessionIdForCustom($gs_job_role_selection_id);
		}
		$sessionId = $list["session_id"];
		if ($list["service_type"]=="REPLACEMENT"){
			if ($list["job_title"]!="TBA When JS is Filled"){
				$id = $list["gs_job_titles_details_id"];
				while(true){
					try{
						$item = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $id));
						if ($item){
							if (isset($item["link_order_id"])){
								$list["posting_id"] = $this->getPosting($item["link_order_id"]);	
							}
						}
						if (is_null($list["posting_id"])){
							if (is_null($item["link_order_id"])){
								break;
							}else{
								$id = $item["link_order_id"];
							}
						}else{
							break;
						}
					}catch(Exception $e){
						break;
					}
											
				}	
			
			}
			$list["job_title"] = $this->renderJobAd($list["job_title"], $list["posting_id"]);
		}else{
			$list["job_title"] = $this->renderJobAd($list["job_title"], $list["posting_id"]);
		}
		$list["client_export"] = $list["client"];
		
		$list["client"] = $this->renderLeadsProfile($list["client"], $list["leads_id"]);
		
		if ($list["created_reason"]=="New JS Form Client"){
			$level = $list["level"];		
			if ($level=="expert"){
				$level = "advanced";
			}
			
			try{
				$currency = $list["currency"];
				 $jo = $db->fetchRow($db->select()->
	                from(array("jscnp"=>"job_sub_categories_new_prices"))
	                ->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jscnp.sub_category_id", array("sub_category_name"))
	                ->where("level = ?", $level)
	                ->where("currency = ?", $list["currency"])
	                ->where("jscnp.sub_category_id = ?", $list["job_order_sub_category_id"])
	                ->where("active = ?", 1));
				 
				if ($list["work_status"]=="Part-Time"){
	                $jo["value"] = number_format($jo["value"]*.6, 2);
	                $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/4, 2);
	            }else{
	                $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/8, 2);
	                $jo["value"] = number_format($jo["value"], 2);  
	            }
				$sql2 = $db->select()
				->from('currency_lookup')
				->where("code = '{$currency}'");
				$money = $db->fetchRow($sql2);
				
				$list["budget"] = sprintf("%s%s%s Hourly / %s%s Monthly", $list["currency"],$money["sign"],$jo["hourly_value"],$money["sign"],$jo["value"] );
			}catch(Exception $e){
				if ($list["budget_monthly"]&&$list["budget_hourly"]){
					$list["budget"] = $this->getBudget($jr_list_id, $list["work_status"], $list["level"]);
				}else{
					$list["budget"] = "TBA When JS is Filled";
				}
			}
			
		}else{
			if ($list["budget_monthly"]&&$list["budget_hourly"]){
				$list["budget"] = $this->getBudget($jr_list_id, $list["work_status"], $list["level"]);
			}else{
				$list["budget"] = "TBA When JS is Filled";
			}
		}
		
		
		
		
		if ($list["gs_job_role_selection_id"]!=""){
			if ($list["job_title"]!="TBA When JS is Filled"){
				if ($list["merge_status"]=="MERGE"){
					$list["job_specification_link"] = "<a href='/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE' target='_blank'>Click Me</a>";
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE";	
					}
					
				}else{
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}";	
					}
					
					$list["job_specification_link"] = "<a href='/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}' target='_blank'>Click Me</a>";	
				}
			}else{
				$filled = date("Y-m-d", strtotime($list["date_filled_up"]));
				if ($list["merge_status"]=="MERGE"){
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}&from=rec_sheet";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}&from=rec_sheet";	
					}				
					$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}&from=rec_sheet' target='_blank'>Click Me</a>";		
				}else{
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}&from=rec_sheet";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}&from=rec_sheet";	
					}	
					$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}&from=rec_sheet' target='_blank'>Click Me</a>";	
				}
			}
		}else{
			$filled = date("Y-m-d", strtotime($list["date_filled_up"]));
			if ($list["merge_status"]=="MERGE"){
				if (TEST){
					$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&from=rec_sheet";
				}else{
					$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&from=rec_sheet";	
				}	
				$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&from=rec_sheet' target='_blank'>Click Me</a>";		
			}else{
				if (TEST){
					$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&from=rec_sheet";
				}else{
					$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&from=rec_sheet";	
				}	
				
				$list["job_specification_link"] = "<a href='/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&from=rec_sheet' target='_blank'>Click Me</a>";	
			}
			
		}
		$list["order_status"] = $this->getStatus($list["status"]);
		$this->staffLister->setTrackingCode($list["tracking_code"]);

		
		if ($list["merge_status"]=="MERGE"){
			$list["endorsed"] = $this->staffLister->getMergedStaff($list["merged_order_id"],$this, StaffLister::ENDORSED);
			$list["interviewed"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $this, StaffLister::INTERVIEWED);
			$list["hired"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $this, StaffLister::HIRED);
			$list["ontrial"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $this, StaffLister::ONTRIAL);
			$list["rejected"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $this, StaffLister::REJECTED);
			$list["shortlisted"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $this, StaffLister::SHORTLISTED);	
			$list["average_endorsed"] = $this->staffLister->getAverageOnMergedOrders($list["merged_order_id"],$this, StaffLister::ENDORSED);
			$list["average_interviewed"] = $this->staffLister->getAverageOnMergedOrders($list["merged_order_id"],$this, StaffLister::INTERVIEWED);
			$list["cancelled"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $this, StaffLister::CANCELLED);
		}else{
			if ($list["service_type"]=="REPLACEMENT"&&$list["created_reason"]=="Closed-To-Replacement"){
				$list["endorsed"] = $this->staffLister->getEndorsedStaffs($list["leads_id"], $list["posting_id"],null, null, null);
				$list["interviewed"] = $this->staffLister->getInterviewedStaffs($list["posting_id"], $list["leads_id"],null, null, null);
				$list["hired"] = $this->staffLister->getHiredStaffs($list["posting_id"], $list["leads_id"],null, null, null);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],null, null, null);
				$list["shortlisted"] = $this->staffLister->getShortlistedStaffs($list["posting_id"]);
				$list["ontrial"] = $this->staffLister->getOnTrialStaffs($list["posting_id"], $list["leads_id"],null, null, null);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],null, null, null);	
				$list["average_endorsed"] = $this->staffLister->getAverageOnEndorsed($list["leads_id"], $list["posting_id"],null, null, null);
				$list["average_interviewed"] =  $this->staffLister->getAverageOnInterviewed($list["leads_id"], $list["posting_id"],null, null, null);
				$list["cancelled"] = $this->staffLister->getCancelledStaffs($list["posting_id"], $list["leads_id"],null, null, null);
			}else{
				$list["endorsed"] = $this->staffLister->getEndorsedStaffs($list["leads_id"], $list["posting_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);
				$list["interviewed"] = $this->staffLister->getInterviewedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);
				$list["hired"] = $this->staffLister->getHiredStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"]);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);
				$list["shortlisted"] = $this->staffLister->getShortlistedStaffs($list["posting_id"]);
				$list["ontrial"] = $this->staffLister->getOnTrialStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);	
				$list["average_endorsed"] = $this->staffLister->getAverageOnEndorsed($list["leads_id"], $list["posting_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);
				$list["average_interviewed"] =  $this->staffLister->getAverageOnInterviewed($list["leads_id"], $list["posting_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);
				$list["cancelled"] = $this->staffLister->getCancelledStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"]);	
			}
			
		}

		if ($list["merge_status"]=="MERGE"){
			$list["notes"] = $this->getNotesForMergeOrder($list["merged_order_id"]);
		}else{
			$list["notes"] = $this->getNotes($gs_job_role_selection_id);
		}
		if (trim($list["notes"])!=""){
			if ($list["merge_status"]=="MERGE"){
				$list["notes"] .= "<a style='margin-left:17px' href='/portal/recruiter/view_order_notes.php?merged_order_id={$list["merged_order_id"]}' class='view_notes'>View More</a>";
			}else{
				$list["notes"] .= "<a style='margin-left:17px' href='/portal/recruiter/view_order_notes.php?id={$gs_job_role_selection_id}' class='view_notes'>View More</a>";
			}
		}


		if ($list["date_filled_up"]!="TBA When JS is Filled"&&$list["proposed_start_date"]!="TBA When JS is Filled"){
			$list["proposed_start_date"] = $this->getFormattedDateRequired($list["date_filled_up"], $list["proposed_start_date"]);
		}
		$list["date_filled_up_orig"] = $list["date_filled_up"];
		if ($list["service_type"]=="REPLACEMENT"){
			$list["date_filled_up"] = date("Y-m-d", strtotime($list["date_filled_up"])).", ASAP";
		}else{
			$list["date_filled_up"] = date("Y-m-d", strtotime($list["date_filled_up"]));
		}
		if ($_SESSION['status']=="FULL-CONTROL"){
			$list["assigned_recruiter"] = $this->renderAssignedHR($list["assigned_recruiter_id"], $gs_job_titles_details_id, false, true);
			$list["assigned_hiring_coordinator"] = $this->renderAssignedHR($list["assigned_hiring_coordinator_id"], $gs_job_titles_details_id,true, true);
		}else{
			$list["assigned_recruiter"] = $this->renderAssignedHR($list["assigned_recruiter_id"], $gs_job_titles_details_id, false, false);
			$list["assigned_hiring_coordinator"] = $this->renderAssignedHR($list["assigned_hiring_coordinator_id"], $gs_job_titles_details_id, true, false);
		}
		if ($list["gs_job_role_selection_id"]!=""){
			$list["assigned_recruiters"] = $this->getRecruiterLinks($list["gs_job_titles_details_id"], "JO");
		}else{
			$list["assigned_recruiters"] = $this->getRecruiterLinks($list["leads_id"], "Lead");
		}
		$list["assigned_business_developer"] = $this->renderBusinessDeveloper($list["business_partner_id"]);
		$list["service_type"] = $list["service_type"];
		$list["order_status"] = $this->getStatus($list["status"]);
		/*
		if ($list["service_type"]=="ASL"){		
			$list["tracking_code"] = date("Ymd", strtotime($list["date_filled_up"])).$list["jsca_id"].$list["leads_id"]."-ASL";
		}else{	
			$list["tracking_code"] = $list["gs_job_titles_details_id"]."-".$list["service_type"];	
		}
		if ($list["merge_status"]=="MERGE"){
			$list["tracking_code"] = $list["merged_order_id"]."-{$list["service_type"]}-"."MERGE";
		}
		 * 
		 */
		if (intval($list["age"])<0){
			$list["age"] = 0;
		}
		//$list["asl_order_id"] = $this->getASLOrderId($list["session_id"]);
		//$list["last_contact"] = $this->getLastContact($list["leads_id"], $list["assigned_hiring_coordinator_id"]);
		if ($list["last_contact"]!="No Last Contact"){
			try{
				$list["last_contact"] = date("Y-m-d", $list["last_contact"]->sec);			
			}catch(Exception $e){
				
			}
		}
		$list["action"] = $this->display;
		$list["viewHistory"] = true;
		$list["viewNotes"] = true;
		
		
		$list["subcategory"] = true;
		
		$list["job_order_comments_count"] = $this->getJobOrderCommentsCount($list["tracking_code"]);
		
		try{
			$mjo = $db->fetchRow($db->select()->from(array("mjos"=>"mongo_job_orders_categories"), array("job_sub_category_id"))->where("tracking_code = ?", $list["tracking_code"]));
			if (!$mjo){
				$list["job_sub_category_id"] = $this->getSubcategory($list["job_title"]);
				if ($list["job_sub_category_id"]){
					$db->insert("mongo_job_orders_categories", array("tracking_code"=>$list["tracking_code"], "job_sub_category_id"=>$list["job_sub_category_id"], "date_assigned"=>date("Y-m-d H:i:s")));	
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
						$job_orders_collection->update(array("tracking_code"=>$list["tracking_code"]), array('$set'=>array("job_order_sub_category_id"=>$list["job_sub_category_id"])));
					}catch(Exception $e){
						
					}
					$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
					
				}				
			}else{
				$list["job_sub_category_id"] = $mjo["job_sub_category_id"];
			}
			
			if ($list["job_sub_category_id"]){
				$list["job_sub_category_name"] = $db->fetchOne($db->select()->from(array("jsc"=>"job_sub_category"), array("sub_category_name"))->joinInner(array("jc"=>"job_category"), "jc.category_id = jsc.category_id", array())->where("jc.status = ?", "posted")->where("sub_category_id = ?", $list["job_sub_category_id"]));
			}else{
				$list["job_sub_category_name"] = "";
			}
				
		}catch(Exception $e){
			
		}
		
		
				
		
		return $list;
	}

	
	public function getSubcategory($job_title){
		$db = $this->db;
		if ($job_title){
			$job_order = $db->fetchOne($db->select()->from(array("jsc"=>"job_sub_category"), array("sub_category_id"))->where("singular_name = ?", $job_title));
			if (!$job_order){
				try{
					$job_order = $db->fetchOne($db->select()->from(array("jsc"=>"job_sub_category"), array("sub_category_id"))->where("singular_name LIKE '%".$job_title."%'"));
					
				}catch(Exception $e){
					
				}
			}
			
			return $job_order;		
		}else{
			return "";
		}
	}

	private function renderBusinessDeveloper($businessDeveloperId){
		if ($businessDeveloperId){
			$db = $this->db;
			$sql = $db->select()->from(array("a"=>"agent"), array("lname", "fname"))
			->where("a.agent_no = ?", $businessDeveloperId)
			->where("a.work_status = 'BP'");
			$agent = $db->fetchRow($sql);
			return $agent["fname"]." ".$agent["lname"];
		}else{
			return "";
		}
	}


	private function renderServiceType($serviceType, $id){
		if ($_SESSION['status']=="FULL-CONTROL"){
			return "<span class='hr_service_update'><input type='hidden' class='service_type_value' value='{$serviceType}'/><input type='hidden' value='{$id}' class='id'/>{$serviceType}</span>";
		}else{
			return $serviceType;
		}
	}

	private function renderOrderStatus($orderStatus, $id){
		if ($_SESSION['status']=="FULL-CONTROL"){
			return "<span class='hr_status_update'><input type='hidden' class='order_status_value' value='{$orderStatus}'/><input type='hidden' value='{$id}' class='id'/>{$orderStatus}</span>";
		}else{
			return $orderStatus;
		}
	}

	private function renderJobAd($jobPosition, $jobId){
		if ($jobId){
	    
            if (TEST){
            	return "<a href='/portal/Ad.php?id={$jobId}' target='_blank'>$jobPosition</a>";         
            }else{
                return "<a href='/portal/Ad.php?id={$jobId}' target='_blank'>$jobPosition</a>";
            }
        
		}else{
			return $jobPosition;
		}
	}


	private function renderLeadsProfile($lead, $leadId){
		return "<a href='/portal/leads_information.php?id={$leadId}' target='_blank'>$lead</a>";
	}


	private function getStatus($status){
		if (($status=="new")||($status=="active")){
			return "Open";
		}else if ($status=="cancel"){
			return "Did not push through";
		}else if ($status=="finish"){
			return "Closed";
		}else if ($status=="Cancel"){
			return "Did not push through";
		}else if ($status=="onhold"){
			return "On Hold";
		}else if ($status=="ontrial"){
			return "On Trial";
		}else{
			return $status;
		}
	}

	private function getBudget($jr_list_id, $work_status, $level){
		$db = $this->db;
		if ($jr_list_id){
			$query = $db->select()
			->from('job_role_cat_list')
			->where('jr_list_id = ?' ,$jr_list_id);



			$resulta = $db->fetchRow($query);
			$currency = $resulta['jr_currency'];

			$sql2 = $db->select()
			->from('currency_lookup')
			->where("code = '{$currency}'");
			$money = $db->fetchRow($sql2);
			$currency_lookup_id = $money['id'];
			$currency = $money['code'];
			$currency_symbol = $money['sign'];


			$jr_status = $resulta['jr_status'];
			$jr_list_id = $resulta['jr_list_id'];
			$jr_cat_id = $resulta['jr_cat_id'];

			$jr_entry_price = $resulta['jr_entry_price'];
			$jr_mid_price = $resulta['jr_mid_price'];
			$jr_expert_price = $resulta['jr_expert_price'];

			if($jr_status == "system"||$jr_status=="manual"){
				if($work_status== "Part-Time"){
					//55% of the original price
					$jr_entry_price = number_format(($jr_entry_price * .55),2,'.',',');
					$jr_mid_price = number_format(($jr_mid_price * .55),2,'.',',');
					$jr_expert_price = number_format(($jr_expert_price * .55),2,'.',',');

					$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/4),2,".",",");
					$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/4),2,".",",");
					$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/4),2,".",",");


					$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
					$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
					$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );

				}else{

					$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/8),2,".",",");
					$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/8),2,".",",");
					$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/8),2,".",",");

					$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
					$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
					$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );


				}
			}else{
				$entry_price_str = "-";
				$mid_price_str = "-";
				$expert_price_str = "-";
			}



			if($level == "entry"){
				$amount_str = $entry_price_str;
			}else if($level == "mid"){
				$amount_str = $mid_price_str;
			}else{
				$amount_str = $expert_price_str;
			}

			return $amount_str;
		}else{
			return "";
		}
	}

	private function renderAssignedHR($hr_id, $id,  $hc=false, $full=false){
		$db = $this->db;
		if ($hr_id){
			$sql = $db->select()
			->from("admin", array("admin_fname", "admin_lname"))
			->where("admin_id = ?", $hr_id);
			$hr = $db->fetchRow($sql);
			if ($hr!=null){

				if ($full){
					if ($hc){
						return "<strong class='hr hc full'>{$hr["admin_fname"]} {$hr["admin_lname"]}<input type='hidden' value='{$hr_id}' class='hr_id'/><input type='hidden' value='{$id}' class='title_id'/></strong>";
					}else{
						return "<strong class='hr full'>{$hr["admin_fname"]} {$hr["admin_lname"]}<input type='hidden' value='{$hr_id}' class='hr_id'/><input type='hidden' value='{$id}' class='title_id'/></strong>";
					}
				}else{

					return "<strong class='hr'>{$hr["admin_fname"]} {$hr["admin_lname"]}<input type='hidden' value='{$hr_id}' class='hr_id'/><input type='hidden' value='{$id}' class='title_id'/></strong>";
				}
			}else{
				if ($hc){
					return "<strong class='hr hc full'>&nbsp;<input type='hidden' value='{$id}' class='title_id'/></strong>";
				}else{
					return "<strong class='hr full'>&nbsp;<input type='hidden' value='{$id}' class='title_id'/></strong>";
				}
			}
		}else{
			if ($hc){
				return "<strong class='hr hc full'>&nbsp;<input type='hidden' value='{$id}' class='title_id'/></strong>";
			}else{
				return "<strong class='hr full'>&nbsp;<input type='hidden' value='{$id}' class='title_id'/></strong>";
			}
		}
	}


	private function getFormattedDateRequired($dateStart, $interval){
		if (DateTime::createFromFormat('Y-m-d G:i:s', $interval) !== FALSE) {
		  // it's a date
		  return date("Y-m-d", strtotime($interval));
		}else{
			if ($interval=="1-Week"){
				return date("Y-m-d", strtotime("+1 week", strtotime($dateStart)));
			}else if ($interval=="2-Weeks"){
				return date("Y-m-d", strtotime("+2 week", strtotime($dateStart)));
			}else if ($interval=="3-Weeks"){
				return date("Y-m-d", strtotime("+3 week", strtotime($dateStart)));
			}else if ($interval=="1-Month"){
				return date("Y-m-d", strtotime("+1 month", strtotime($dateStart)));
			}else if ($interval=="2-Months"){
				return date("Y-m-d", strtotime("+2 month", strtotime($dateStart)));
			}else if ($interval=="3-Months"){
				return date("Y-m-d", strtotime("+3 month", strtotime($dateStart)));
			}else{
				return "Over ".date("Y-m-d", strtotime("+4 month", strtotime($dateStart)));
			}
		}
		
	}


	private function getRecruiterLinks($id, $key){
		$db = $this->db;
		if ($id&&$key){
			$sql = $db->select()->from(array("gjo_rl"=>"gs_job_orders_recruiters_links"))
			->joinInner("admin", "admin.admin_id = gjo_rl.recruiters_id", array("admin_fname", "admin_lname"))
			->where("link_type = ?",  $key)
			->where("link_id = ?", $id)
			->order("admin.admin_fname");
			return $db->fetchAll($sql);
		}else{
			return array();
		}

	}

	private function getSessionIdForASL($job_sub_cat_id, $date_added, $lead_id){
		$db = $this->db;
		if ($date_added&&$lead_id){
			$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("session_id", "order_id"))
			->where("tbr.job_sub_category_applicants_id = ?", $job_sub_cat_id)
			->where("tbr.leads_id = ?", $lead_id)
			->where("DATE(tbr.date_added) = DATE(?)", $date_added);
				
			$result = $db->fetchAll($sql);
			if (count($result)!=0){
				foreach($result as $session_id){
					if ($session_id["session_id"]!=0){
						return $session_id["session_id"];
					}
					$order =$db->fetchRow($db->select()->from(array("tbro"=>"tb_request_for_interview_orders"), array("session_id"))->where("id = ?", $session_id["order_id"]));
					if ($order["session_id"]!=0){
						return $order["session_id"];
					}
				}

			}else{
				$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("session_id", "order_id"))
				->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
				->where("jsca.sub_category_id = ?",$job_sub_cat_id)
				->where("tbr.leads_id = ?", $lead_id)
				->where("DATE(tbr.date_added) = ?", $date_added);
				$result = $db->fetchRow($sql);
				if ($result){
					return $result["session_id"];
				}else{
					return "";
				}
			}
			return "";
		}else{
			return "";
		}
	}

	private function getJobSubCategory($sessionId){
		$db = $this->db;
		if ($sessionId){

			$sql = $db->select()->from(
			array("tbro"=>"tb_request_for_interview_orders"), array())
			->joinRight(array("tbr"=>"tb_request_for_interview"),
									"tbr.order_id = tbro.id", 
			array("tbr.job_sub_category_applicants_id AS jsca_id",
									"tbr.date_added AS date_added"))
			->where("tbro.session_id = ?", $sessionId)
			->where("tbr.id IS NOT NULL");
			$jsca = $db->fetchRow($sql);
			if ($jsca){
				return $jsca;
			}else{
				$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"),
				array("tbr.job_sub_category_applicants_id AS jsca_id",
											"tbr.date_added AS date_added"))
				->where("tbro.session_id = ?", $sessionId);
					
			}
		}else{
			return "";
		}

	}

	private function getSessionIdForCustom($gs_jrs_id){
		$db = $this->db;
		if ($gs_jrs_id){
			try{
				$sql = $db->select()
				->from(array("gs_jrs"=>"gs_job_role_selection"), array("gs_jrs.session_id AS session_id"))
				->where("gs_jrs.gs_job_role_selection_id = ?", $gs_jrs_id);
				$result = $db->fetchRow($sql);
			}catch(Exception $e){
				return "";
			}
			
			return $result["session_id"];
		}else{
			return "";
		}
	}

	
	public function getPosting($gs_job_titles_id){
		$db = $this->db;
		$row = $db->fetchRow($db->select()->from(array("p"=>"posting"), array("p.id"))->where("job_order_id = ?", $gs_job_titles_id)->order("p.id DESC"));
		if ($row){
			return $row["id"];
		}else{
			return null;
		}
	}
	
	
	
	public function getMoreDetailsForMerge($item){
		$db = $this->db;
		$row = array();
		try{
			if ($item["service_type"]=="ASL"){
				$session_id = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), "session_id")->where("job_sub_category_applicants_id = ?", $item["jsca_id"])->where("DATE(date_added) = DATE(?)", $item["date_added"]));
	  			$session_id = $session_id["session_id"];
	  			if ($session_id){
					$row = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array("gs_jtd.gs_job_role_selection_id AS gs_job_role_selection_id"))
						->joinInner(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array())
						->joinLeft(array("p"=>"posting"), "p.job_order_id = gs_jtd.gs_job_titles_details_id", array("p.id AS posting_id"))
						//->where("p.job_order_source = 'rs'")
						->where("DATE(gs_jrs.request_date_added) = DATE(?)", $item["date_added"])
						->where("gs_jrs.jsca_id = ?", $item["jsca_id"])
						->where("gs_jrs.leads_id = ?", $item["lead_id"]));
	  				
		  			if (!$row){
						$row = array();	
					}
	  			}
				
				$row["date_filled_up"] = date("Y-m-d", strtotime($item["date_added"]));
				$row["jsca_id"] = $item["jsca_id"];
				$row["leads_id"] = $item["lead_id"];
			}else{
				$row = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array("gs_jtd.gs_job_role_selection_id AS gs_job_role_selection_id"))
					->joinInner(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", 
								array(
									new Zend_Db_Expr("CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END AS date_filled_up"),
									new Zend_Db_Expr("gs_jrs.leads_id AS leads_id"),
									new Zend_Db_Expr("gs_jrs.jsca_id AS jsca_id")
								))
					->joinLeft(array("p"=>"posting"), "p.job_order_id = gs_jtd.gs_job_titles_details_id", array("p.id AS posting_id"))
					//->where("p.job_order_source = 'rs'")
					->where("gs_jtd.gs_job_titles_details_id = ?", $item["gs_job_title_details_id"]));
			}
		}catch(Exception $e){
			
		}
		
		return $row;
	}


	public function getParentOrderPosting($id){
		$db = $this->db;
		$posting_id = null;
		while(true){
			try{
				$item = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $id));
				if ($item){
					if (isset($item["link_order_id"])){
						$posting_id = $this->getPosting($item["link_order_id"]);	
					}
				}
				if (is_null($posting_id)){
					if (is_null($item["link_order_id"])){
						break;
					}else{
						$id = $item["link_order_id"];
					}
				}else{
					break;
				}
			}catch(Exception $e){
				break;
			}
									
		}	
		return $posting_id;
	}
	
	
	public function getTodayOrders($hiring_coordinator, $service_type){
		$_GET["today"] = 1;
		$this->gatherInput();
		$this->limit = false;
		$this->order_status = 0;
		$this->export = true;
		$this->service_type = $service_type;
		$this->hiring_coordinator = $hiring_coordinator;
		return $this->loadJobTitleDetails();
	}
	
	public function getCloseOrders($hiring_coordinator, $service_type, $dateFrom, $dateTo){
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
		return $this->loadJobTitleDetails();
	}
	
	public function getOpenOrders($hiring_coordinator, $service_type, $order_status, $dateFrom, $dateTo){
		$this->gatherInput();
		$this->limit = false;
		$this->filter_type = 3;
		$this->order_status = $this->order_status;
		$this->export = true;
		$this->date_from = $dateFrom;
		$this->date_to = $dateTo;
		$this->service_type = $service_type;
		$this->hiring_coordinator = $hiring_coordinator;
		return $this->loadJobTitleDetails();
	}
	
	public function getJobOrderCommentsCount($tracking_code){
		$db = $this->db;
		return $db->fetchOne("SELECT COUNT(*) AS count FROM job_order_comments WHERE tracking_code = '".$tracking_code."' AND deleted = 0");
	}
}