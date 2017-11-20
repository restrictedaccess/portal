<?php
/**
 * Class responsible for updating promo code
 *
 * @version 0.2 - Added Promo Code Process
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/../forms/AddPromoCodeForm.php";
require_once dirname(__FILE__)."/../forms/UpdatePromoCodeForm.php";

class PromoCodeProcess extends EditProcess{
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		$userid = $_SESSION["userid"];
		$form = new AddPromoCodeForm();
		$form->getElement("userid")->setValue($userid);
		
		$promocodes = $db->fetchAll($db->select()->from("personal_promo_codes")->where("userid = ?", $userid)->where("deleted = 0"));
		$i = 1;
		foreach($promocodes as $key=>$promocode){
			$promocodes[$key]["i"] = $i;
			$promocodes[$key]["count"] = $db->fetchOne($db->quoteInto("SELECT COUNT(*) FROM personal_promo_code_hits WHERE promo_code = ?", $promocode["promocode"]));			
			$i++;
		}
		$smarty->assign_by_ref("form", $form);
		
		//load all referrals under promo code
		$sql = $db->select()->from("referrals")
				->joinInner("personal", "personal.userid = referrals.jobseeker_id", array("CONCAT(personal.fname,' ',personal.lname) AS referee", "personal.userid AS referee_id", "personal.promotional_code", new Zend_Db_Expr("DATE_FORMAT(datecreated,'%D %b %Y') AS date_registered")))
				
				->where("referrals.user_id = ?", $userid)
				->where("referrals.status <> 'DELETED'")
				->where("referrals.type = 'promo_code'")
				->order("date_created DESC");
				
		
		$referrals = $db->fetchAll($sql);
		
		foreach($referrals as $key=>$referral){
			$referrals[$key]["status"] = $this->getStaffStatus($referral["jobseeker_id"]);
		}
		
		$smarty->assign("promocodes", $promocodes);
		$this->setActive("promo_active");
		
		$smarty->assign("referrals", $referrals);
		$this->syncUserInfo();
		$smarty->display("promo_codes.tpl");
	}
	
	public function getPromoCode(){
		$db = $this->db;
		$promocode = $db->fetchRow($db->select()->from("personal_promo_codes")->where("id = ?", $_REQUEST["id"]));
		return $promocode;
		
	}
	
	
	public function addPromoCode(){
		$db = $this->db;
		
		
		$promocode = $db->fetchRow($db->select()->from("personal_promo_codes")->where("promocode = ?", $_REQUEST["promocode"])->where("deleted = 0"));
		
		if ($promocode){
			return array("error"=>"Promo Code already exist. Please choose another", "success"=>false);
		}
		
		$form = new AddPromoCodeForm();
		if ($form->isValid($_POST)){
			$data = $form->getValues();
			$data["date_created"] = date("Y-m-d H:i:s");
			$db->insert("personal_promo_codes", $data);
			
			$id = $db->lastInsertId("personal_promo_codes");
			$promocode = $db->fetchRow($db->select()->from("personal_promo_codes")->where("id = ?", $id));
			$history_changes = "Added new promo code <span style='color:red;'>".$promocode["promocode"]."</span>";
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			return array("success"=>true);
		}else{
			$this->errors = $form->getErrors();
			return array("errors"=>$this->errors, "success"=>false);
		}
	}
	
	public function deletePromoCode(){
		$db = $this->db;
		if (isset($_REQUEST["id"])){
			$db->update("personal_promo_codes", array("deleted"=>1), $db->quoteInto("id = ?",$_REQUEST["id"]));
			return array("success"=>true);
		}else{
			return array("error"=>"Invalid Request", "success"=>false);
		}
	}
	
	public function updatePromoCode(){
		$db = $this->db;
		$form = new UpdatePromoCodeForm();
		$promocode = $db->fetchRow($db->select()->from("personal_promo_codes")->where("promocode = ?", $_REQUEST["promocode"])->where("userid <> ?", $_SESSION["userid"])->where("deleted = 0"));
		
		if ($promocode){
			return array("error"=>"Promo Code already exist. Please choose another", "success"=>false);
		}
		
		
		
		if ($form->isValid($_POST)){
			$data = $form->getValues();
			$id = $data["id"];
			$userid = $_SESSION["userid"];
			unset($data["id"]);
			$old = $db->fetchRow($db->select()->from(array("p"=>"personal_promo_codes"))->where("id = ?", $_REQUEST["id"]));
			
			$db->update("personal_promo_codes", $data, $db->quoteInto("id = ?",$id));
			
			$new = $db->fetchRow($db->select()->from(array("p"=>"personal_promo_codes"))->where("id = ?", $_REQUEST["id"]));
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
			
			}
			
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			return array("success"=>true);
		}else{
			$this->errors = $form->getErrors();
			return array("errors"=>$this->errors, "success"=>false);
		}
	}


	public function getStaffStatus($userid){

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