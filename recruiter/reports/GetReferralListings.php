<?php
class GetReferralListings{
	/**
	 * database connection ...
	 * @var Zend_Db_Adapter_Abstract $db
	 */
	private $db;
	
	private $page = 1;
	private $rows = 100;
	
	private $date_to = "", $date_from = "", $filter_text="", $status="referred";
	
	public function __construct($db){
		session_start();
		$this->db = $db;
	}
	
	private function gatherInput(){
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
		
		if (isset($_GET["date_to"])){
			$this->date_to = $_GET["date_to"];
		}else{
			$this->date_to = "";
		}
		
		if (isset($_GET["date_from"])){
			$this->date_from = $_GET["date_from"];
		}else{
			$this->date_from = "";
		}
		
		
		if (isset($_GET["filter_text"])){
			$this->filter_text = $_GET["filter_text"];
		}else{
			$this->filter_text = "";
		}
		
		if (isset($_GET["status"])){
			if ($_GET["status"]=="all"){
				$this->status = "";			
			}else{
				$this->status = $_GET["status"];				
			}

		}else{
			$this->status = "referred";
		}
		
		
		
	}
	
	public function process(){
		$this->gatherInput();
		if (isset($_GET["filter_type"])){
			return json_encode($this->loadReferralListings());
		}else{
			return json_encode($this->loadReferralListingsDefault());
		}
	}
	
	private function loadReferralListingsDefault(){
		
		$db = $this->db;
		
		$sql = $db->select()
		
				->from("referrals")
		
				->joinInner("personal", "personal.userid = referrals.user_id", array("CONCAT(personal.fname,' ',personal.lname) AS referee", "personal.userid AS referee_id"))
				
				->where("referrals.type = ?", "referred")
				
				->order("date_created DESC");
				
		$referrals = $db->fetchAll($sql);
		
		$total = count($referrals);
		
		$sql = $sql->limitPage($this->page, $this->rows);
		
		$referrals = $db->fetchAll($sql);
		
		$totalPages = ceil($total/$this->rows);
		foreach($referrals as $key=>$value){
			$referrals[$key]["date_created"] = date("Y-m-d", strtotime($value["date_created"]));
			if (!is_null($value["jobseeker_id"]) && $value['jobseeker_id'] != NULL && !empty($value['jobseeker_id'])){
				$referrals[$key]["referral_status"] = $this->getApplicationStatus($value["jobseeker_id"]);		
				$referrals[$key]["fullname"] = "<a href='/portal/recruiter/staff_information.php?userid={$value["jobseeker_id"]}' target='_blank'>{$value["firstname"]} {$value["lastname"]}</a>";	
					
			}else{
				$referrals[$key]["referral_status"] = "No Contact";			
				$referrals[$key]["fullname"] = "{$value["firstname"]} {$value["lastname"]}";
			}
			
		}
		$result = array("rows"=>$referrals, "records"=>$total, "total"=>$totalPages, "page"=> $this->page, );
		return $result;
	}
	
	private function loadReferralListings(){
		
		$db = $this->db;
		
		$sql = $db->select()
		
				->from("referrals")
				
				->joinInner("personal", "personal.userid = referrals.user_id", array("CONCAT(personal.fname,' ',personal.lname) AS referee", "personal.userid AS referee_id"));
		
		if (($this->date_from!="")&&($this->date_to!="")){
			$sql = $sql->where("DATE(date_created) >= ?", $this->date_from);
			$sql = $sql->where("DATE(date_created) <= ?", $this->date_to);			
		}
		
		if ($this->filter_text!=""){
			$sql=$sql->where("CONCAT(referrals.firstname, ' ', referrals.lastname) LIKE '%{$this->filter_text}%' OR CONCAT(personal.fname, ' ', personal.lname) LIKE '%{$this->filter_text}%' OR referrals.position LIKE '%{$this->filter_text}%' OR referrals.contactnumber LIKE '%{$this->filter_text}%' OR referrals.email LIKE '%{$this->filter_text}%'");
		}
		
		$sql = $sql->order("date_created DESC");
		
		if ($this->status!=""){
			$sql->where("referrals.type = ?", $this->status);
		}
		
		$referrals = $db->fetchAll($sql);
		
		$total = count($referrals);
		
		$sql = $sql->limitPage($this->page, $this->rows);
		
		$referrals = $db->fetchAll($sql);
		
		foreach($referrals as $key=>$value){
			$referrals[$key]["date_created"] = date("Y-m-d", strtotime($value["date_created"]));
			if (!is_null($value["jobseeker_id"]) && $value['jobseeker_id'] != NULL && !empty($value['jobseeker_id'])){
				$referrals[$key]["referral_status"] = $this->getApplicationStatus($value["jobseeker_id"]);		
				$referrals[$key]["fullname"] = "<a href='/portal/recruiter/staff_information.php?userid={$value["jobseeker_id"]}' target='_blank'>{$value["firstname"]} {$value["lastname"]}</a>";	
					
			}else{
				//check on personal 
				$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("userid"))->where("email = ?", $value["email"])->orWhere("alt_email = ?", $value["email"])->orWhere("registered_email = ?", $value["email"]));			
				
				if ($personal['userid']){
					$referrals[$key]["referral_status"] = $this->getApplicationStatus($personal["userid"]);		
				
					$referrals[$key]["jobseeker_id"] = $personal["userid"];
					$referrals[$key]["fullname"] = "<a href='/portal/recruiter/staff_information.php?userid={$personal["userid"]}' target='_blank'>{$value["firstname"]} {$value["lastname"]}</a>";	
				}else{
					$referrals[$key]["referral_status"] = "No Contact";			
					$referrals[$key]["fullname"] = "{$value["firstname"]} {$value["lastname"]}";
					$referrals[$key]["jobseeker_id"] = false;
				}
					
				
			}
			if ($referrals[$key]["contacted"]==="0"){
				$referrals[$key]["contacted"] = false;
			}else{
				$referrals[$key]["contacted"] = true;
			}

		}
		$totalPages = ceil($total/$this->rows);
		$result = array("rows"=>$referrals, "records"=>$total, "total"=>$totalPages, "page"=> $this->page, );
		return $result;
	}


	private function getApplicationStatus($userid){
		$status = $this->getStaffStatus($userid);
		return $status;
	}
	
	private function getStaffStatus($userid){

		$db = $this->db;
	
		$statuses = array();
		
		$select = "select userid, date 
			from unprocessed_staff 
			where userid='".$userid."'";
		
		$status = $db->fetchRow($select);
		
		if($status != NULL){
			$status["label"] = "Unprocessed";
			$statuses[] = $status;
		}
		
		
		$select = "select userid, date 
			from pre_screened_staff 
			where userid='".$userid."'";
		$status = $db->fetchRow($select);
		
		if($status != NULL){
			$status["label"] = "Prescreened";
			$statuses[] = $status;
		}
		
		$select = "select userid, date 
			from inactive_staff 
			where userid='".$userid."'";
		$status = $db->fetchRow($select);
		if($status != NULL){
			$status["label"] = "Inactive";
			$statuses[] = $status;
		}
		
		$select = "select userid, date_endoesed AS date
			from tb_endorsement_history 
			where userid='".$userid."'";
		$status = $db->fetchRow($select);
		if($status != NULL){
			$status["label"] = 'Endorsed';
			$statuses[] = $status;
		}
		
		$select = "select userid, date_listed AS date
			from tb_shortlist_history 
			where userid='".$userid."'";
		$status = $db->fetchRow($select);
		if($status != NULL){ 
			$status["label"] = 'Shortlisted';
			$statuses[] = $status;
		}
		
		$select = "select userid, sub_category_applicants_date_created AS date
			from job_sub_category_applicants 
			where userid='".$userid."'";
		$status = $db->fetchRow($select);
		if($status != NULL){	
			$status["label"] = 'Categorized';
			$statuses[] = $status;
		}
		
		
		//calculate recent
		if (!empty($statuses)){
			$latestStatus = null;
			foreach($statuses as $status){
				if ($latestStatus==null){
					$latestStatus = $status;
				}else{
					$latestStatusDate = strtotime($latestStatus["date"]);
					$currentStatusDate = strtotime($status["date"]);
					if ($currentStatusDate>$latestStatusDate){
						$latestStatus = $status;
					}
				}
			}
			return $latestStatus["label"];
		}else{
			return "";
		}
		
	}
	
}
