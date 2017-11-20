<?php
class ReferAFriendProcess extends AbstractProcess{
	private $referred;
	
	public function __construct($db){
		$this->referred = array();
		parent::__construct($db);
	}
	
	public function process(){
		$db = $this->db;
		
		if (isset($_POST["userid"])){
			$userid = $_POST["userid"];
			for ($i=0;$i<3;$i++){
				if (isset($_POST["firstname"][$i])){
					$firstname = trim($_POST["firstname"][$i]);
					$lastname = trim($_POST["lastname"][$i]);
					$currentposition = trim($_POST["currentposition"][$i]);
					$emailaddress = trim($_POST["emailaddress"][$i]);
					$contactnumber = trim($_POST["contactnumber"][$i]);		
		
					if (!(($firstname!="")&&($lastname!="")&&($currentposition!="")&&(($contactnumber!="")||($emailaddress!="")))){
						continue;
					}
					
				
					$AusTime = date("h:i:s"); 
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
				}
				
			}
			
			return true;
		}else{
			return false;
		}
	}
	
	public function render(){
		$db = $this->db;
		$userid = $_SESSION['userid'];
		//load user from db
		$user = $db->fetchRow("SELECT * FROM personal WHERE userid = ".$userid);
		
		$sql = $db->select()->from("referrals")
				->joinInner("personal", "personal.userid = referrals.user_id", array("CONCAT(personal.fname,' ',personal.lname) AS referee", "personal.userid AS referee_id"))
				->where("referrals.user_id = ?", $userid)
				->where("referrals.status <> 'DELETED'")
				->order("date_created DESC");
		$referrals = $db->fetchAll($sql);
		$smarty = $this->smarty;
		if (count($this->referred)>0){
			$smarty->assign("success", "true");
		}else{
			$smarty->assign("success", "");			
		}
		
		$referralOutput = "";
		foreach($referrals as $referral){
			$referralOutput.="<tr>";
			$referralOutput.=("<td>".$referral["firstname"]."</td>");
			$referralOutput.=("<td>".$referral["lastname"]."</td>");
			$referralOutput.=("<td>".$referral["position"]."</td>");
			$referralOutput.=("<td>".$referral["email"]."</td>");
			$referralOutput.=("<td>".$referral["contactnumber"]."</td>");
			$status = "";
			if (isset($referral["jobseeker_id"])&&!is_null($referral["jobseeker_id"])){
				$status = $this->getApplicationStatus($referral["jobseeker_id"]);
			}else{
				$status = "No Contact";
			}
			$referralOutput.=("<td>".$status."</td>");
			if ($status=="No Contact"){
				$referralOutput.=("<td><a href='#' data-id='".$referral["id"]."' class='delete-referral'>Delete</a></td>");
			}else{
				$referralOutput.=("<td>&nbsp;</td>");				
			}
			
			$referralOutput.="</tr>";
		}
		$smarty->assign("referralOutput", $referralOutput);
		$smarty->assign('fname',$user["fname"]);
		$smarty->assign("userid", $userid);
		$smarty->display("refer-a-friend.tpl");
	}


	private function getApplicationStatus($userid){
		$db = $this->db;
		$status = "Unprocessed";
		//check if prescreened first
		$pres = $db->fetchRow($db->select()->from(array("pres"=>"pre_screened_staff"), array("userid"))->where("userid = ?", $userid));
		if ($pres){
			$status = "Pre-screened";
		}		
		$shortlisted = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("userid"))->where("userid = ?", $userid));
		if ($shortlisted){
			$status = "Shortlisted";
		}
		$endorsed = $db->fetchRow($db->select()->from(array("end"=>"tb_endorsement_history"), array("userid"))->where("userid = ?", $userid));
		if ($endorsed){
			$status = "Endorsed";
		}
		if ($lead_id){
			$new = $db->fetchRow($db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
					->where("end.userid = ?", $userid)
					->where("tbr.status = 'NEW'")
					->where("tbr.service_type = 'CUSTOM'"));
			if ($new){
				$status = "Interview Set";
			}
			$hired = $db->fetchRow($db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
					->where("end.userid = ?", $userid)
					->where("tbr.status = 'HIRED'")
					->where("tbr.service_type = 'CUSTOM'"));
			if ($hired){
				$status = "Hired";
			}
			$rejected = $db->fetchRow($db->select()
						->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
						->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
						->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
						->where("end.userid = ?", $userid)
						->where("tbr.status = 'REJECTED'")
						->where("tbr.service_type = 'CUSTOM'"));
			if ($rejected){
				$status = "Rejected";
			}
		}
		return $status;
	}
}