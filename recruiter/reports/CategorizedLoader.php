<?php
require_once dirname(__FILE__)."/AbstractCategorized.php";
class CategorizedLoader extends AbstractCategorized{
	
	private $filter = array();
	private $limit = false;
	
	
	private $recruitment_collection;
	
	public function __construct($db){
		ini_set("memory_limit", -1);
		parent::__construct($db);
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
			
		
		$recruitment_collection = $database->selectCollection("recruitment");
		$this->recruitment_collection = $recruitment_collection;	
	}
	
	private function setFilter(){
		$this->filter["table"] = "job_sub_category_applicants";
		if ($_REQUEST["recruiter"]){
			$this->filter["assigned_recruiter_id"] = intval($_REQUEST["recruiter"]);
		}
		if ($_REQUEST["on_asl"]!=""){
			$on_asl = $_REQUEST["on_asl"];
			if ($on_asl=="0"||$on_asl=="1"){
				$this->filter["ratings"] = intval($_REQUEST["on_asl"]);
			//	$this->filter["under_consideration"] = 0;			
			}else{
				$this->filter["under_consideration"] = 1;
			}
		}
		if ($_REQUEST["work_availability"]){
			$work_availability = $_REQUEST["work_availability"];
			if ($work_availability=="Full-Time"){
				$this->filter["evaluation.work_fulltime"] = "yes";
				$this->filter["evaluation.work_parttime"] = "no";
			}else if ($work_availability=="Part-Time"){
				$this->filter["evaluation.work_fulltime"] = "no";
				$this->filter["evaluation.work_parttime"] = "yes";
			}else if ($work_availability=="Full-Time/Part-Time"){
				$this->filter["evaluation.work_fulltime"] = "yes";
				$this->filter["evaluation.work_parttime"] = "yes";
			}
		}
		if ($_REQUEST["time_availability"]){
			$time_availability = $_REQUEST["time_availability"];	
			if ($time_availability=="Any"){
			//	$this->filter["staff_selected_timezones.time_zone"] = array('$in'=>array("UK", "US", "AU"));
			}else{
				$this->filter["staff_selected_timezones.time_zone"] = $time_availability;
			}
		}
		if ($_REQUEST["date_added_from"]&&$_REQUEST["date_added_to"]){
			$this->filter["date"] = array('$gte'=>new MongoDate(strtotime($_REQUEST["date_added_from"])), '$lte'=>new MongoDate(strtotime($_REQUEST["date_added_to"]." +1 day")));
		}else{
			$this->filter["date"] = array('$gte'=>new MongoDate(strtotime(date("Y")."-01-01")), '$lte'=>new MongoDate(strtotime(date("Y-m-d")." +1 day")));
		}
		
		if ($_REQUEST["date_updated_from"]&&$_REQUEST["date_updated_to"]){
			$this->filter["personal.dateupdated"] = array('$gte'=>new MongoDate(strtotime($_REQUEST["date_updated_from"])), '$lte'=>new MongoDate(strtotime($_REQUEST["date_updated_to"]." +1 day")));
		}
		
		if ($_REQUEST["date_registered_from"]&&$_REQUEST["date_registered_to"]){
			$this->filter["personal.datecreated"] = array('$gte'=>new MongoDate(strtotime($_REQUEST["date_registered_from"])), '$lte'=>new MongoDate(strtotime($_REQUEST["date_registered_to"]." +1 day")));
		}
		if ($_REQUEST["keyword"]&&$_REQUEST["keyword_type"]){
			$keyword = $_REQUEST["keyword"];
			$keyword_type = $_REQUEST["keyword_type"];
			$regex = new MongoRegex('/'.$keyword.'/i');
			if ($keyword_type=="id"){
				$this->filter["userid"] = intval($keyword);
			}else if ($keyword_type=="first_name"){
				$this->filter["personal.fname"] = $regex;
			}else if ($keyword_type=="last_name"){
				$this->filter["personal.lname"] = $regex;
			}else if ($keyword_type=="email"){
				$this->filter["personal.email"] = $regex;
			}else if ($keyword_type=="evaluation_notes"){
				$this->filter["evaluation_comments.comments"] = $regex;
			}else if ($keyword_type=="skills"){
				$this->filter["skills.skill"] = $regex;
			}else if ($keyword_type=="notes"){
				$this->filter["notes.note"] = $regex;
			}
		}
		
		if ($_REQUEST["inactive"]){
			$this->filter["inactive.inactive_type"] = $_REQUEST["inactive"];
		}
		
		if ($_REQUEST["city"]){
			$regex = new MongoRegex('/'.$_REQUEST["city"].'/i');
			$this->filter["personal.city"] = $regex;
		}
		if ($_REQUEST["region"]){
			$this->filter["personal.state"] = $_REQUEST["region"];
		}
		if ($_REQUEST["gender"]){
			$this->filter["personal.gender"] = $_REQUEST["gender"];
		}
		if ($_REQUEST["marital_status"]){
			$this->filter["personal.marital_status"] = $_REQUEST["marital_status"];
		}
		if ($_REQUEST["available_status"]){
			$this->filter["currentjob.available_status"] = $_REQUEST["available_status"];
			if ($_REQUEST["available_status"]=="a"){
				if ($_REQUEST["available_notice"]){
					$this->filter["currentjob.available_notice"] = intval($_REQUEST["available_notice"]);
				}
			}else if ($_REQUEST["available_status"]=="b"){
				if ($_REQUEST["available_date"]){
					$this->filter["currentjob.available_month"] = array('$gte'=>new MongoDate(strtotime($_REQUEST["available_date"])));
				}
			}
		}
	}

	public function render(){
		return $this->getList();
	}

	public function setLimit($limit){
		$this->limit = $limit;
	}	
	
	private function getRateIN($userid,$adv_rate,$availability){	
		
		$db = $this->db;
		
		if($availability == 'FT'){
			$column = 'product_id';
		}
		else{
			$column = 'part_time_product_id';
		}
		
		$select="SELECT p.code FROM `staff_rate` as s 
			left join products as p on s.{$column}=p.id 
			where s.userid=".$userid." ORDER BY date_updated DESC";
		$row = $db->fetchRow($select); 
		if($availability == 'FT'){
			$per_m = str_replace(',','',str_replace('PHP-'.$availability.'-','',str_replace('INR-FT-','',$row['code'])));
		    $yearly = $per_m * 12;
		    $weekly = $yearly / 52;
		    $daily = $weekly / 5;
		    $per_h = $daily / 8;
		}else{
			$per_m = str_replace(',','',str_replace('PHP-'.$availability.'-','',str_replace('INR-FT-','',$row['code'])));
			
			
			$yearly = $per_m * 12;
		    $weekly = $yearly / 52;
		    $daily = $weekly / 5;
		    $per_h = $daily / 4;
		}
		 
		if($adv_rate == 'monthly'){
			$result = $per_m;
		}
		else{
			$result = $per_h;
		}
		$result = floatval($result);
		if (is_string($result)&&$result==""){
			return 0;
		}
		if (!$result){
			return 0;
		}
		return $result;
	}
	
	private function getList(){
		$this->setFilter();
		$categories = $this->getCategories();
		$nonEmptyCategories = array();
		foreach($categories as $key_cat=>$category){
			$subcategories = $this->getSubCategories($category["category"]["id"]);
			$nonEmptySubcategories = array();
			foreach($subcategories as $subcategory){
				$applicants = $this->getApplicants($subcategory["sub_category_id"]);
				if (!empty($applicants)){
					$subcategory["applicants"] = $applicants;
					$nonEmptySubcategories[] = $subcategory;
				}
			}
			if (!empty($nonEmptySubcategories)){
				$category["subcategories"] = $nonEmptySubcategories;
				$nonEmptyCategories[] = $category;				
			}
		}
		return $nonEmptyCategories;
	}
	
	public function renderMassMail(){
		$_SESSION["mass_email_status"] = "waiting";
		$db = $this->db;
		$this->setFilter();
		$categories = $this->getCategories();
		$nonEmptyCategories = array();
		$userids = array();
		
		foreach($categories as $key_cat=>$category){
			$subcategories = $this->getSubCategories($category["category"]["id"]);
			$nonEmptySubcategories = array();
			foreach($subcategories as $subcategory){
				$applicants = $this->getApplicants($subcategory["sub_category_id"]);
				foreach($applicants as $applicant){
					if (!in_array($applicant["userid"], $userids)){
						$userids[] = $applicant["userid"];
					}
				}
			}
			if (!empty($nonEmptySubcategories)){
				$category["subcategories"] = $nonEmptySubcategories;
				$nonEmptyCategories[] = $category;				
			}
		}
		if (empty($userids)){
			header("location: /portal/recruiter/categorized.php?error=0"); 
			exit;
		}
		
		//START: update emailing list
		$max = $db->fetchOne($db->select()->from(array("sm"=>"staff_mass_mail_logs"), array(new Zend_Db_Expr("MAX(batch) AS batch")))->where("admin_id = ?", $_SESSION["admin_id"]));
		if (!$max){
			$max = 1;
		}else{
			$max = $max+1;
		}
		if($_REQUEST["mass_email"] == "on" && $_SESSION["mass_email_status"] == "waiting"){
			//start: insert to emailing list
			if (!empty($userids)){
				//mysql_query("UPDATE personal SET mass_emailing_status='DO NOTHING'");
				$AusDate = date("Y")."-".date("m")."-".date("d");
				$AusTime = date("h:i:s");
				$selectedStaff = implode(",", $userids);
				$batch = $max-1;
				$updateQuery = "waiting = 1 AND finish = 0 AND DATE(date_created) = {$AusDate} AND userid NOT IN($selectedStaff) AND batch = {$batch} AND admin_id = ".$_SESSION["admin_id"];
				$db->update("staff_mass_mail_logs", array("finish"=>1), $updateQuery);
				
				foreach($userids as $staff){
					$data = array("waiting"=>1, "userid"=>$staff, "date_created"=>$AusDate." ".$AusTime, "date_updated"=>$AusDate." ".$AusTime, "batch"=>$max, "admin_id"=>$_SESSION["admin_id"]);
					//$result = $db->fetchRow($db->select()->from("staff_mass_mail_logs")->where("userid = ?", $staff)->where("finish = 0")->where("DATE(date_created) = ?", $AusDate));
					$db->insert("staff_mass_mail_logs", $data);
				}
				//$db->update("personal", $data, "userid IN ($massStaff)");
				$_SESSION["mass_email_status"] = "executed";
				//ended: insert to emailing list
				header("location: staff_mass_emailing_new.php"); 
				exit;
			}else{
				header("location: /portal/recruiter/categorized.php?error=0"); 
				exit;
			}
		}
	
		
	}
	public function getUniqueResume(){
		$this->setFilter();
		try{
			$group = array('_id'=>'$userid', 'categorized_dates'=>array('$addToSet'=>'$date'));
		
			$filter = $this->filter;
			$recruitment_collection = $this->recruitment_collection;
			$aggregate = array(
				array('$match'=>$filter),
				array('$group'=>$group)
			
			);
			$cursor = $recruitment_collection->aggregate($aggregate);
			return count($cursor["result"]);
		}catch(Exception $e){
			return 0;
		}
	}
	
	private function getApplicants($subcategory_id){
		$db = $this->db;
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
				
			$recruitment_collection = $database->selectCollection("recruitment");
			
			$filter = $this->filter;
			$filter["sub_category_id"] = intval($subcategory_id);
			$cursor = $recruitment_collection->find($filter);
			if ($this->limit){
			}
			$recruitment = array();
			while($cursor->hasNext()){
				$item = $cursor->getNext();
				
				
				if ($item["evaluation"]["work_fulltime"]=="yes"&&$item["evaluation"]["work_parttime"]=="yes"){
					$item["work_availability"] = "Full-Time/Part-Time";
				}else if ($item["evaluation"]["work_fulltime"]=="yes"&&$item["evaluation"]["work_parttime"]=="no"){
					$item["work_availability"] = "Full-Time";
				}else if ($item["evaluation"]["work_fulltime"]=="no"&&$item["evaluation"]["work_parttime"]=="yes"){
					$item["work_availability"] = "Part-Time";
				}else{
					$item["work_availability"] = "Full-Time/Part-Time";
				}
				
				
				if ($item["under_consideration"]==1){
					$item["on_asl"] = "Under Consideration";
				}else{
					if ($item["ratings"]==0||!$item["ratings"]||$item["ratings"]=="0"){
						$item["on_asl"] = "Yes";					
					}else{
						$item["on_asl"] = "No";
					}
				}
				
				
				$part_time_zones = array();
				foreach($item["staff_selected_timezones"] as $timezone){
					if ($timezone["type"]=="part_time"){
						$part_time_zones[] = $timezone["time_zone"];
					}
				}
				
				$full_time_zones = array();
				foreach($item["staff_selected_timezones"] as $timezone){
					if ($timezone["type"]=="full_time"){
						$full_time_zones[] = $timezone["time_zone"];
					}
				}
				
				if ($item["work_availability"]=="Full-Time/Part-Time"){
					$item["part_time_zones"] = $part_time_zones;
					$item["full_time_zones"] = $full_time_zones;
				}else if ($item["work_availability"]=="Full-Time"){
					$item["part_time_zones"] = array();
					$item["full_time_zones"] = $full_time_zones;
				}else{
					$item["part_time_zones"] = $part_time_zones;
					$item["full_time_zones"] = array();
				}
				
				
				if ($_REQUEST["advertised_rates"]){
					$adv_rates = $_REQUEST["advertised_rates"];
					$full_time_rates = array();
					$part_time_rates = array();
					
					if ($adv_rates=="hourly"){
							
						foreach($item["hourly_full_time_rates"] as $key=>$rate){
							$full_time_rates[] = strtoupper($key)." ".number_format($rate, 2);
						}
						foreach($item["hourly_part_time_rates"] as $key=>$rate){
							$part_time_rates[] = strtoupper($key)." ".number_format($rate, 2);
						}
						
					}else{
						foreach($item["monthly_full_time_rates"] as $key=>$rate){
							if ($rate&&$rate>=0){
								$full_time_rates[] = strtoupper($key)." ".number_format($rate, 2);							
							}
						}
						foreach($item["monthly_part_time_rates"] as $key=>$rate){
							if ($rate&&$rate>=0){
								$part_time_rates[] = strtoupper($key)." ".number_format($rate, 2);
							}
						}
						
					}
					
					if ($item["work_availability"] == "Full-Time/Part-Time"){
						$full_time_rates[] = strtoupper("PH")." ".number_format($this->getRateIN($item["userid"], $adv_rates, "FT"), 2);
						$part_time_rates[] = strtoupper("PH")." ".number_format($this->getRateIN($item["userid"], $adv_rates, "PT"), 2);
						$item["full_time_rates"] = $full_time_rates;
						$item["part_time_rates"] = $part_time_rates;	
					}else if ($item["work_availability"]=="Part-Time"){
						$part_time_rates[] = strtoupper("PH")." ".number_format($this->getRateIN($item["userid"], $adv_rates, "PT"), 2);
							
						$item["full_time_rates"] = array();
						$item["part_time_rates"] = $part_time_rates;
					}else{
						$full_time_rates[] = strtoupper("PH")." ".number_format($this->getRateIN($item["userid"], $adv_rates, "FT"), 2);
						$item["full_time_rates"] = $full_time_rates;
						$item["part_time_rates"] = array();
					}
					
					unset($item["monthly_full_time_rates"]);
					unset($item["monthly_part_time_rates"]);
					unset($item["hourly_full_time_rates"]);
					unset($item["hourly_part_time_rates"]);
					
				}
				
				$item["endorsement_count"] = count($item["endorsements"]);
				$item["shortlist_count"] = count($item["shortlists"]);
				unset($item["evaluation"]);
				unset($item["evaluation_comments"]);
				unset($item["notes"]);
				unset($item["endorsements"]);
				unset($item["shortlists"]);
				unset($item["_id"]);
				unset($item["date"]);
				unset($item["date_added"]);
				unset($item["inactive"]);
				
				$recruitment[] =$item;
			}			
			return $recruitment;
		}catch(Exception $e){
			
		}
	}
}
