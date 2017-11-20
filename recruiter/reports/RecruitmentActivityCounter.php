<?php
require_once dirname(__FILE__)."/RecruitmentActivityLister.php";
class RecruitmentActivityCounter{
	
	private $dateFrom, $dateTo;
	private $rec_support = array(236, 239, 228, 227, 175, 225, 167, 227, 242, 226, 169);
	
	public function __construct($db){
		$this->db = $db;
		$this->gatherInput();
	}
	
	private function gatherInput(){
		if (isset($_GET["date_from"])){
			$this->dateFrom = $_GET["date_from"];
		}else{
			$this->dateFrom = date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
		}
		if (isset($_GET["date_to"])){
			$this->dateTo = $_GET["date_to"];
		}else{
			$this->dateTo = date("Y-m-d");			
		}
	}
	
	public function getCount(){
		$recruiters = $this->getRecruiters();
		return $this->getRecruitersCount($recruiters);
	}
	
	private function getRecruitersCount($recruiters){
		$result = array();
		$lister = new RecruitmentActivityLister($this->db);
		foreach($recruiters as $recruiter){
			$resultItem = array();
			$resultItem["admin_id"] = $recruiter["admin_id"];
			$recruiter_id = $recruiter["admin_id"];
			$lister->getAssignedCandidates($recruiter_id);
			$resultItem["number_of_candidate"] = $lister->getCount();
			$lister->getEmailCount($recruiter_id);
			$resultItem["email"] = $lister->getCount();
			$lister->getHistory($recruiter_id, "CALL");
			$resultItem["initial_call"] = $lister->getCount();
			$lister->getHistory($recruiter_id, "MEETING FACE TO FACE");
			$resultItem["face_to_face"] = $lister->getCount();
			$lister->getHistory($recruiter_id, "NOTES");
			$resultItem["evaluated"] = $lister->getCount();
			$lister->getViewedResume($recruiter_id);
			$resultItem["opened_resume"] = $lister->getCount();
			$lister->getCreatedResume($recruiter_id);
			$resultItem["created_resume"] = $lister->getCount();
			$lister->getSMSSent($recruiter_id);
			$resultItem["sms_sent"] = $lister->getCount();
			$lister->getEvaluationComments($recruiter_id);
			$resultItem["evaluation_comments"] = $lister->getCount();
			$resultItem["total_activity"] = $resultItem["evaluation_comments"]+$resultItem["number_of_candidate"]+$resultItem["email"]+$resultItem["initial_call"]+$resultItem["face_to_face"]+$resultItem["evaluated"]+$resultItem["opened_resume"]+$resultItem["created_resume"]+$resultItem["sms_sent"];
			$result[] = $resultItem;
		}
		return $result;
	}
	
	
	public function getRecSupportCount(){
		$recruiters = $this->getRecSupportOnly();
		return $this->getRecruitersCount($recruiters);
	}
	
	public function getRecruitersOnlyCount(){
		$recruiters = $this->getRecruitersOnly();
		return $this->getRecruitersCount($recruiters);
	}
	
	private function getCountHistory($recruiter_id, $history_type){
		$db = $this->db;
		$row = $db->fetchRow($db->select()
			->from(array("ap"=>"applicant_history"), 
				array(new Zend_Db_Expr("COUNT(*) AS count")))
			->joinInner(array("rs"=>"recruiter_staff"), "rs.admin_id = ap.admin_id", array())
			
			->where("ap.admin_id = ?", $recruiter_id)
			->where("rs.admin_id = ?", $recruiter_id)
			->where("ap.userid IN (SELECT userid FROM recruiter_staff WHERE admin_id='{$recruiter_id}')")
			->where("actions = ?", $history_type)
			->where("DATE(ap.date_created) >= DATE(?)", $this->dateFrom)
			->where("DATE(ap.date_created) <= DATE(?)", $this->dateTo));
		return $row["count"];		
	}
	
	
	private function getCountEmail($recruiter_id){
		$db = $this->db;
		$sql = $db->select()
			->from(array("ap"=>"applicant_history"), 
				array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS ap.id")))
			->joinInner(array("rs"=>"recruiter_staff"), "rs.admin_id = ap.admin_id", array())
						
			->where("ap.admin_id = ?", $recruiter_id)
			->where("rs.admin_id = ?", $recruiter_id)
			->where("ap.userid IN (SELECT userid FROM recruiter_staff WHERE admin_id='{$recruiter_id}')")
			->where("actions = ?", "EMAIL")
			->where("DATE(ap.date_created) >= DATE(?)", $this->dateFrom)
			->where("DATE(ap.date_created) <= DATE(?)", $this->dateTo)
			->group("ap.id");
		$sql2 = $db->select()
			->from(array("m"=>"staff_mass_mail_logs"), 
				array(new Zend_Db_Expr("m.id")))
			->joinInner(array("rs"=>"recruiter_staff"), "rs.admin_id = m.admin_id", array())
			->where("m.userid IN (SELECT userid FROM recruiter_staff WHERE admin_id='{$recruiter_id}')")
			->where("m.admin_id = ?", $recruiter_id)
			->where("rs.admin_id = ?", $recruiter_id)
			
			->where("DATE(m.date_created) >= DATE(?)", $this->dateFrom)
			->where("DATE(m.date_created) <= DATE(?)", $this->dateTo)
			->group("m.id");
		
		$sql = $db->select()->union(array($sql, $sql2))->limit(1);
		$row = $db->fetchRow($sql);
		$count = $db->fetchOne("SELECT FOUND_ROWS() AS count");
		return $count;
	}
	
	private function getAssignedCandidatesCount($recruiter_id){
		$db = $this->db;
		$row = $db->fetchRow($db->select()
						->from(array("rs"=>"recruiter_staff"), array(new Zend_Db_Expr("COUNT(*) AS count")))
						
						->where("rs.admin_id = ?",$recruiter_id)
						->where("DATE(rs.date) >= DATE(?)", $this->dateFrom)
						->where("DATE(rs.date) <= DATE(?)", $this->dateTo));
		return $row["count"];
	}
	
	private function getViewedResumeCount($recruiter_id){
		$db = $this->db;
		$row = $db->fetchRow($db->select()
						->from(array("rh"=>"resume_viewing_history"), array(new Zend_Db_Expr("COUNT(DISTINCT rh.id) AS count")))
						->joinInner(array("rs"=>"recruiter_staff"), "rs.admin_id = rh.admin_id", array())
						->where("rh.admin_id = ?",$recruiter_id)
						->where("rh.userid IN (SELECT userid FROM recruiter_staff WHERE admin_id='{$recruiter_id}')")
						->where("rs.admin_id = ?",$recruiter_id)
						->where("DATE(rh.date_created) >= DATE(?)", $this->dateFrom)
						->where("DATE(rh.date_created) <= DATE(?)", $this->dateTo));
		return $row["count"];
	}
	private function getCreatedResumeCount($recruiter_id){
		$db = $this->db;
		$row = $db->fetchRow($db->select()
						->from(array("rh"=>"resume_creation_history"), array(new Zend_Db_Expr("COUNT(DISTINCT rh.id) AS count")))
						->joinInner(array("rs"=>"recruiter_staff"), "rs.admin_id = rh.admin_id", array())
						->where("rh.userid IN (SELECT userid FROM recruiter_staff WHERE admin_id='{$recruiter_id}')")
						->where("rh.admin_id = ?",$recruiter_id)
						->where("DATE(rh.date_created) >= DATE(?)", $this->dateFrom)
						->where("DATE(rh.date_created) <= DATE(?)", $this->dateTo))
						
						;
		return $row["count"];
	}
	
	private function getUniqueNotes($recruiter_id){
		$db = $this->db;
		$innerSql = $db->select()->from(array("ah"=>"applicant_history"), array("ah.id"))
				->joinInner(array("rs"=>"recruiter_staff"), "rs.admin_id = ah.admin_id", array())
				->where("rs.admin_id = ?", $recruiter_id)
				->where("ah.admin_id = ?", $recruiter_id)
				->where("ah.userid IN (SELECT userid FROM recruiter_staff WHERE admin_id='{$recruiter_id}')")
				->where("DATE(date_created) >= DATE(?)", $this->dateFrom)
				->where("DATE(date_created) <= DATE(?)", $this->dateTo)			
				->where("actions = 'NOTES'")
				->group(array("ah.id"));
		
		
		$innerSql = $innerSql->__toString();
		$sql = "SELECT COUNT(*) AS count FROM ($innerSql) AS temp_table";
		$row = $db->fetchRow($sql);
		return $row["count"];
	}
	
	private function getSMSSentCount($recruiter_id){
		$db = $this->db;
		$sql = $db->select()->from(array("sms"=>"staff_admin_sms_out_messages"), array(new Zend_Db_Expr("COUNT(DISTINCT sms.id) AS count")))
				->joinInner(array("rs"=>"recruiter_staff"), "rs.admin_id = sms.admin_id", array())
				->where("sms.admin_id = ?", $recruiter_id)	
				->where("rs.admin_id = ?", $recruiter_id)	
				->where("sms.userid IN (SELECT userid FROM recruiter_staff WHERE admin_id='{$recruiter_id}')")		
				->where("DATE(date_created) >= DATE(?)", $this->dateFrom)
				->where("DATE(date_created) <= DATE(?)", $this->dateTo);
		return $db->fetchOne($sql);
	}
	
	protected function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` where (status='HR' OR admin_id IN (236, 239, 228, 225, 167, 242, 226,169))   AND status <> 'REMOVED' AND admin_id <> 161 ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
	
	protected function getRecruitersOnly(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` where (status='HR' OR admin_id NOT IN (236, 239, 228, 225, 167, 242, 226,169))   AND status <> 'REMOVED' AND admin_id <> 161 ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
	protected function getRecSupportOnly(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` where (admin_id IN (236, 239, 228, 225, 167, 242, 226,169))   AND status <> 'REMOVED' AND admin_id <> 161 ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
	
	private function dateDiff($startDate, $endDate){
		$startArry = date_parse($startDate);
		$endArry = date_parse($endDate);
		$start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
		$end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);
		return round(($end_date - $start_date), 0);
	}
	
	
}
