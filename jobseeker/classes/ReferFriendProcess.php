<?php
/**
 * Class responsible for updating personal information
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
class ReferFriendProcess extends EditProcess{
	
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		$this->syncUserInfo();
		$userid = $_SESSION["userid"];
		$sql = $db->select()->from("referrals")
				->joinInner("personal", "personal.userid = referrals.user_id", array("CONCAT(personal.fname,' ',personal.lname) AS referee", "personal.userid AS referee_id"))
				->where("referrals.user_id = ?", $userid)
				->where("referrals.status <> 'DELETED'")
				->where("referrals.type = 'referred'")
				->order("date_created DESC");
		$referrals = $db->fetchAll($sql);
		if (isset($_GET["success"])){
			$smarty->assign("success", "true");
		}else{
			$smarty->assign("success", "false");
		}
		
		foreach($referrals as $key=>$referral){
			if (isset($referral["jobseeker_id"])&&!is_null($referral["jobseeker_id"])){
				$status = $this->getApplicationStatus($referral["jobseeker_id"]);
			}else{
				$status = "No Contact";
			}
			$referrals[$key]["application_status"] = $status;
		}
		$this->setActive("referfriend_active");
		
		//position desired
		$categories = $this->getCategories();
		$position_first_choice_options = "<option value=''>Select Position</option>";
		$position_second_choice_options = "<option value=''>Select Position</option>";
		$position_third_choice_options = "<option value=''>Select Position</option>";

		foreach($categories as $key=>$category){

			$categories[$key]['subcategories'] = $this->getSubCategories($category['category']['id']);
			
		}
		$smarty->assign("categories", $categories);
		$smarty->assign("referrals", $referrals);
		$smarty->display("refer_friend.tpl");
	}
	
	public function deleteReferral(){
		$db =  $this->db;
		//check if referral exist and referral belongs to userid
		$referral = $db->fetchRow($db->select()->from("referrals")->where("id = ?", $_GET["id"]));
		if ($referral){
			if ($referral["user_id"]!=$_SESSION["userid"]){
				return array("success"=>false, "error"=>"Invalid Referral");
			}else{
				$db->delete("referrals", $db->quoteInto("id = ?", $_GET["id"]));
				return array("success"=>true);
			}
			
		}else{
			return array("success"=>false, "error"=>"Referral does not exist");
		}

	}
	
	
	public function addReferral(){
		$db = $this->db;
		
		if (isset($_SESSION["userid"])){
			$userid = $_SESSION["userid"];
			$personal = $db->fetchRow($db->select()->from("personal", array("email", "alt_email", "registered_email"))->where("userid = ?", $userid));
					
			$count = 0;
			for ($i=0;$i<3;$i++){
				if (isset($_POST["firstname"][$i])){
					$firstname = trim($_POST["firstname"][$i]);
					$lastname = trim($_POST["lastname"][$i]);
					$currentposition = trim($_POST["position"][$i]);
					$emailaddress = trim($_POST["emailaddress"][$i]);
					$contactnumber = trim($_POST["contactnumber"][$i]);		
			
					if ($firstname==""&&$lastname==""&&$currentposition==""){
						continue;
					}
					
					if ($emailaddress){
						//get personal info
						if ($personal["email"]==$emailaddress||$personal["alt_email"]==$emailaddress||$personal["registered_email"]==$emailaddress){
							return array("success"=>false, "error"=>"You cannot refer yourself.");
						}
					}
					
				
					$AusTime = date("H:i:s"); 
					$AusDate = date("Y")."-".date("m")."-".date("d");
					$ATZ = $AusDate." ".$AusTime;
					$date = $ATZ;
					$data = array("firstname"=>$firstname, 
								  "lastname"=>$lastname,
					 			  "position"=>$currentposition,
								  "email"=>$emailaddress,
								  "contactnumber"=>$contactnumber,
								  "user_id"=>$userid,
								  "contacted"=>0,
								  "date_created"=>$date);
					
					$db->insert("referrals", $data);
					$this->referred[] = $data;
					$count++;
				}
				
			}
			if ($count!=0){
				return array("success"=>true);	
			}else{
				return array("success"=>false);
			}
			
		}else{
			return array("success"=>false);
		}
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

	/**
	 * Get All Categories
	 */
	private function getCategories($category = null){

		$db = $this->db;

		$category_filter = '';
		if($category != null){
			$category_filter = 'and  category_id = '.$category;
		}

		$select="SELECT category_id, category_name FROM job_category
			WHERE status='posted' ".$category_filter." 
			ORDER BY category_name";
		$rows = $db->fetchAll($select);

		$categories = array();
		foreach($rows as $row){
			$category = array();
			$category['category']['id'] = $row['category_id'];
			$category['category']['name'] = $row['category_name'];
			$categories[] = $category;
		}
		return $categories;
	}
	/**
	 * Get All subcategory under the given category
	 */
	private function getSubCategories($category_id){

		$db = $this->db;
		$select = "SELECT sub_category_id, singular_name
				FROM job_sub_category 
				WHERE category_id='".$category_id."' AND 
				status = 'posted' 
				ORDER BY sub_category_name";
		$rows = $db->fetchAll($select);
		return $rows;
	}
}
