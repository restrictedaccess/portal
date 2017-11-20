<?php
/**
 * Class responsible for listing applications
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";

class ApplicationLoader extends EditProcess{
	
	
	/**
	 * Expire applications older than 3 months
	 */
	public function expireApplications($userid){
		$db = $this->db;	
		if ($userid&&is_null($userid)){
			$apps = $db->fetchAll($db->select()
				->from(array("a"=>"applicants"), array("a.id", new Zend_Db_Expr("DATE_ADD(`date_apply`, INTERVAL 3 MONTH) AS expiration_date")))
				->joinInner(array("p"=>"posting"), "p.id = a.posting_id", array())
				->where("a.userid = ?", $userid)
				->where("p.status = 'ACTIVE'")
				->where("a.status <>'Sub-Contracted'")
				->where("a.expired = 0")
				->having("DATE_ADD(expiration_date, INTERVAL 3 MONTH) < CURDATE()"));
			if (!empty($apps)){
				foreach($apps as $app){
					$db->update("applicants", array("expired"=>1), $db->quoteInto("id = ?", $app["id"]));
				}		
			}
		}
		
	}
	
	
	
	public function countActiveApplication($userid){
		$db = $this->db;	
		if ($userid&&!is_null($userid)){
			$sql = $db->select()->from(array("a"=>"applicants"), array(new Zend_Db_Expr("COUNT(*) AS count")))
					->joinLeft(array("p"=>"posting"), "p.id = a.posting_id", array())
					->where("p.status = 'ACTIVE'")
					->where("a.userid = ?", $userid)
					->where("a.status <> 'Sub-Contracted'")
					->where("a.expired = 0")
					->order(array("a.id DESC"));
			return $db->fetchOne($sql);
		}else{
			return 0;
		}
		
	}
	
	/**
	 * Load All applications of applicant
	 * @param $userid - The User ID of the applicant
	 */
	public function loadAllApplication($userid, $limit=-1){
		$db = $this->db;
		$sql = $db->select()->from(array("a"=>"applicants"), array("a.id AS application_id", "a.status", 
														new Zend_Db_Expr("DATE_FORMAT(a.date_apply,'%D %b %Y') AS date_apply")
														))
					->joinLeft(array("p"=>"posting"), "p.id = a.posting_id", array("p.id", "p.companyname", "p.jobposition", "p.id AS posting_id", "p.lead_id AS lead_id", "p.status AS posting_status", "p.job_order_id AS job_order_id", "p.ads_title AS ads_title", "p.sub_category_id AS sub_category_id"))
					->where("a.userid = ?", $userid)
					->where("a.status <> 'Sub-Contracted'")
					->where("a.expired = 0")
					->order(array("a.id DESC"));
					
		if ($limit!=-1){
			$sql->limit($limit);
		}
		$userid = $_SESSION["userid"];
		$applications = $db->fetchAll($sql);
		if (!empty($applications)){
			foreach($applications as $key=>$application){
			    $job_order_id = $application["job_order_id"];
				$status = "Unprocessed";
				$posting_status = $application["posting_status"];
				$posting_id = $application["posting_id"];
				$lead_id = $application["lead_id"];
				if ($posting_status=="ACTIVE"){
					//check if prescreened first
						$pres = $db->fetchRow($db->select()->from(array("pres"=>"pre_screened_staff"), array("userid"))->where("userid = ?", $userid));
						if ($pres){
							$status = "Pre-screened";
						}		
						$shortlisted = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("userid"))->where("userid = ?", $userid)->where("position = ?", $posting_id));
						if ($shortlisted){
							$status = "Shortlisted";
						}
						$endorsed = $db->fetchRow($db->select()->from(array("end"=>"tb_endorsement_history"), array("userid"))->where("userid = ?", $userid)->where("position = ?", $posting_id));
						if ($endorsed){
							$status = "Endorsed";
						}
						if ($lead_id){
							$new = $db->fetchRow($db->select()
									->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
									->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
									->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
									->where("end.client_name = ?", $lead_id)
									->where("end.position = ?", $posting_id)
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
									->where("end.client_name = ?", $lead_id)
									->where("end.position = ?", $posting_id)
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
										->where("end.client_name = ?", $lead_id)
										->where("end.position = ?", $posting_id)
										->where("end.userid = ?", $userid)
										->where("tbr.status = 'REJECTED'")
										->where("tbr.service_type = 'CUSTOM'"));
							if ($rejected){
								$status = "Rejected";
							}
					}
				}else{
					$status = "Job Advertisement Closed";
				}
				$applications[$key]["status"] = $status;
			}
		}
		return $applications;
												
	}
	
	
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		$applications = $this->loadAllApplication($_SESSION["userid"]);
		$smarty->assign("remaining_application", 10-$this->countActiveApplication($_SESSION["userid"]));
		
		$smarty->assign("applications", $applications);
		$this->syncUserInfo();
		$this->setActive("application_active");
		$smarty->display("applications.tpl");
	}
	
}
