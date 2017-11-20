<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
class RecruitmentActivityLister extends Portal{
	
	private $dateFrom, $dateTo, $rows = 100, $page = 1, $count = 0;

	private $recruiter_query = "SELECT admin_id FROM `admin` where (status='HR' OR admin_id IN (236, 239,227, 228, 225, 167, 242, 226,169))  AND status <> 'REMOVED'  AND admin_id <> 161";
	//Recruiter Support no longer available to the current operation
	//private $rec_support = array(236, 239, 228, 227, 175, 225, 167, 227, 242, 226, 169);
	private $rec_support = array();
	private $recruiter_only = "SELECT admin_id FROM admin WHERE admin_id NOT IN (236, 239, 227, 228, 225, 167, 242, 226,169) AND status = 'HR' AND status <> 'REMOVED' AND admin_id <> 161";
	
	public function render(){
		
	}
	public function __construct($db) {
		$this -> db = $db;
		$this -> gatherInput();
	}

	public function getCount() {
		return $this -> count;
	}

	private function gatherInput() {
		if (isset($_GET["date_from"])) {
			$this -> dateFrom = $_GET["date_from"];
		} else {
			$this -> dateFrom = date("Y-m-d", strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
		}
		if (isset($_GET["date_to"])) {
			$this -> dateTo = $_GET["date_to"];
		} else {
			$this -> dateTo = date("Y-m-d");
		}
		if (isset($_GET["page"])) {
			$this -> page = $_GET["page"];
		}
	}

	public function getHistory($recruiter_id, $history_type) {
		$db = $this -> db;
		$recs = $this -> getRecruiters();

		$rec_ids = array();
		foreach ($recs as $rec) {
			$rec_ids[] = $rec["admin_id"];
		}

		$rec_ids = implode(",", $rec_ids);

		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
			$rec_support = implode(",", $this -> rec_support);
			$sql = $db -> select() -> from(array("ap" => "applicant_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS ap.date_created AS date"), "ap.admin_id", "ap.history", "ap.id")) -> joinLeft(array("p" => "personal"), "p.userid = ap.userid", array("p.fname", "p.lname", "p.userid")) -> where("actions = ?", $history_type) -> where("DATE(ap.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(ap.date_created) <= DATE(?)", $this -> dateTo) ;

			$sql -> order("date DESC") -> limitPage($this -> page, $this -> rows)->where("ap.admin_id IN ({$this->recruiter_query})");

			
			if ($recruiter_id=="recruiter"){
				$sql->where("ap.admin_id IN ({$this->recruiter_only})");			
			}else{
				$sql->where("ap.admin_id IN ({$rec_support})");
			}

			$rows = $db -> fetchAll($sql);
		} else {
			$sql = $db -> select() -> from(array("ap" => "applicant_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS ap.date_created AS date"), "ap.admin_id", "ap.history", "ap.id")) -> joinLeft(array("p" => "personal"), "p.userid = ap.userid", array("p.fname", "p.lname", "p.userid")) -> where("actions = ?", $history_type) -> where("DATE(ap.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(ap.date_created) <= DATE(?)", $this -> dateTo) -> order("ap.date_created DESC")  -> limitPage($this -> page, $this -> rows);
			$sql -> where("ap.admin_id = ?", $recruiter_id);

			$rows = $db -> fetchAll($sql);

		}

		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");
		foreach ($rows as $key => $row) {
			$rows[$key]["history"] = substr($row["history"], 0, 100)."...";
			
			$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
		}
		return $rows;
	}

	public function getEmailCount($recruiter_id) {
		$db = $this -> db;
		$rows = array();
		$recs = $this -> getRecruiters();

		$rec_ids = array();
		foreach ($recs as $rec) {
			$rec_ids[] = $rec["admin_id"];
		}

		$rec_ids = implode(",", $rec_ids);

		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
			$rec_support = implode(",", $this -> rec_support);
			$sql = $db -> select() -> from(array("ap" => "applicant_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS ap.date_created AS date"), "ap.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = ap.userid", array("p.fname", "p.lname", "p.userid")) -> where("actions = ?", "EMAIL") -> where("DATE(ap.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(ap.date_created) <= DATE(?)", $this -> dateTo) -> group(array("ap.id"))->where("ap.admin_id IN ({$this->recruiter_query})");
			$sql3 = $db -> select() -> from(array("m" => "staff_mass_mail_logs"), array("m.date_created AS date", "m.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = m.userid", array("p.fname", "p.lname", "p.userid"))  -> where("DATE(m.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(m.date_created) <= DATE(?)", $this -> dateTo) -> group(array("m.id"))->where("m.admin_id IN ({$this->recruiter_query})");
			if ($recruiter_id=="recruiter"){
				$sql->where("ap.admin_id IN ({$this->recruiter_only})");	
				$sql3->where("m.admin_id IN ({$this->recruiter_only})");							
			}else{
				$sql->where("ap.admin_id IN ({$rec_support})");
				$sql3->where("m.admin_id IN ({$rec_support})");
			}
			$sql = $db -> select() -> union(array($sql,  $sql3)) -> order("date DESC") -> limitPage($this -> page, $this -> rows);

			
			$rows = $db -> fetchAll($sql);
		} else {

			$sql = $db -> select() -> from(array("ap" => "applicant_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS ap.date_created AS date"), "ap.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = ap.userid", array("p.fname", "p.lname", "p.userid")) -> where("actions = ?", "EMAIL") -> where("DATE(ap.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(ap.date_created) <= DATE(?)", $this -> dateTo) -> group(array("ap.id"));

			$sql2 = $db -> select() -> from(array("m" => "staff_mass_mail_logs"), array("m.date_created AS date", "m.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = m.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(m.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(m.date_created) <= DATE(?)", $this -> dateTo) -> group(array("m.id"));

			$sql -> where("ap.admin_id = ?", $recruiter_id);
			$sql2 -> where("m.admin_id = ?", $recruiter_id);

			$sql = $db -> select() -> union(array($sql, $sql2)) -> order("date ASC") -> limitPage($this -> page, $this -> rows);

			$rows = $db -> fetchAll($sql);
		}
		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");
		foreach ($rows as $key => $row) {
			$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
		}
		return $rows;
	}

	public function getAssignedCandidates($recruiter_id) {
		$db = $this -> db;
		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
		    $rec_support = implode(",", $this -> rec_support);
            
		    $sql = $db -> select() -> from(array("rs" => "recruiter_staff"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rs.date AS date"))) -> joinLeft(array("p" => "personal"), "p.userid = rs.userid", array("p.fname", "p.lname", "p.userid")) -> joinLeft(array("a" => "admin"), "a.admin_id = rs.admin_id", array()) -> where("DATE(rs.date) >= DATE(?)", $this -> dateFrom) -> where("DATE(rs.date) <= DATE(?)", $this -> dateTo) -> order("rs.date DESC") -> where("rs.admin_id IN ({$this->recruiter_query})") -> where("a.status <> 'REMOVED'") -> limitPage($this -> page, $this -> rows);    
		    if ($recruiter_id=="recruiter"){
		        $sql->where("rs.admin_id IN ({$this->recruiter_only})");
            }else{
                $sql->where("rs.admin_id IN ({$rec_support})");
            }
			$rows = $db -> fetchAll($sql);
		} else {
			if ($recruiter_id == "Others") {
				$rows = $db -> fetchAll($db -> select() -> from(array("rs" => "recruiter_staff"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rs.date AS date"), "rs.id")) -> joinLeft(array("p" => "personal"), "p.userid = rs.userid", array("p.fname", "p.lname", "p.userid")) -> where("rs.admin_id IN (SELECT admin_id FROM admin WHERE status = 'REMOVED' OR admin_id = 161)") -> where("DATE(rs.date) >= DATE(?)", $this -> dateFrom) -> where("DATE(rs.date) <= DATE(?)", $this -> dateTo) -> order("rs.date DESC") -> limitPage($this -> page, $this -> rows));
			} else {
				$rows = $db -> fetchAll($db -> select() -> from(array("rs" => "recruiter_staff"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rs.date AS date"), "rs.id")) -> joinLeft(array("p" => "personal"), "p.userid = rs.userid", array("p.fname", "p.lname", "p.userid")) -> where("rs.admin_id = ?", $recruiter_id) -> where("DATE(rs.date) >= DATE(?)", $this -> dateFrom) -> where("DATE(rs.date) <= DATE(?)", $this -> dateTo) -> order("rs.date DESC") -> limitPage($this -> page, $this -> rows));
			}

		}

		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");

		foreach ($rows as $key => $row) {
			try {

				$history = $db -> fetchAll($db -> select() -> from("staff_history") -> where("userid = ?", $row["userid"]));

				$assigned_recruiter = $db -> fetchRow($db -> select() -> from(array("rs" => "recruiter_staff"), array()) -> joinLeft(array("a" => "admin"), "a.admin_id = rs.admin_id", array("a.admin_fname", "a.admin_lname", "a.admin_id")) -> where("rs.id = ?", $row["id"]));

				if (!empty($history)) {
					foreach ($history as $staff_history) {
						$changes = $staff_history["changes"];
						if ((strpos($changes, "admin created resume for candidate") !== false)) {
							$row["admin_id"] = $assigned_recruiter["admin_id"];

						}

						if ((strpos($changes, "candidate assigned to recruiter") !== false)) {
							$row["admin_id"] = $staff_history["change_by_id"];
						}

					}
				}

				if (!$row["admin_id"]) {
					$row["admin_id"] = $db -> fetchOne($db -> select() -> from("recruiter_staff_transfer_logs", "admin_id") -> where("recruiter_staff_id = ?", $row["id"]));

				}
				if ($row["admin_id"]) {
					$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
				}
			} catch(Exception $e) {

			}

		}

		return $rows;
	}

	public function getViewedResume($recruiter_id) {
		$db = $this -> db;
		$recs = $this -> getRecruiters();

		$rec_ids = array();
		foreach ($recs as $rec) {
			$rec_ids[] = $rec["admin_id"];
		}

		$rec_ids = implode(",", $rec_ids);
		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
			$rec_support = implode(",", $this -> rec_support);
			$sql = $db -> select() -> from(array("rh" => "resume_viewing_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rh.date_created AS date"), "rh.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = rh.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(rh.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(rh.date_created) <= DATE(?)", $this -> dateTo)  -> group(array("rh.id"))->where("rh.admin_id IN ({$this->recruiter_query})");
			
			$sql -> order("date DESC") -> limitPage($this -> page, $this -> rows);
			
			if ($recruiter_id=="recruiter"){
				$sql->where("rh.admin_id IN ({$this->recruiter_only})");	
			}else{
				$sql->where("rh.admin_id IN ({$rec_support})");	
			}
			
			$rows = $db -> fetchAll($sql);
		} else {
			$sql = $db -> select() -> from(array("rh" => "resume_viewing_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rh.date_created AS date"), "rh.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = rh.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(rh.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(rh.date_created) <= DATE(?)", $this -> dateTo) -> order("rh.date_created DESC") -> group(array("rh.id")) -> limitPage($this -> page, $this -> rows);
			$sql -> where("rh.admin_id = ?", $recruiter_id);

			$rows = $db -> fetchAll($sql);
		}

		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");
		foreach ($rows as $key => $row) {
			$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
		}
		return $rows;
	}

	public function getCreatedResume($recruiter_id) {
		$db = $this -> db;
		$recs = $this -> getRecruiters();

		$rec_ids = array();
		foreach ($recs as $rec) {
			$rec_ids[] = $rec["admin_id"];
		}

		$rec_ids = implode(",", $rec_ids);
		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
			$rec_support = implode(",", $this -> rec_support);
			$sql = $db -> select() -> from(array("rh" => "resume_creation_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rh.date_created AS date"), "rh.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = rh.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(rh.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(rh.date_created) <= DATE(?)", $this -> dateTo) -> group(array("rh.id"))->where("rh.admin_id IN ({$this->recruiter_query})");
			$sql -> order("date DESC") -> limitPage($this -> page, $this -> rows);
			
			if ($recruiter_id=="recruiter"){
				$sql->where("rh.admin_id IN ({$this->recruiter_only})");	
			}else{
				$sql->where("rh.admin_id IN ({$rec_support})");	
			}
			
			$rows = $db -> fetchAll($sql);
		} else {
			$sql = $db -> select() -> from(array("rh" => "resume_creation_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rh.date_created AS date"), "rh.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = rh.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(rh.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(rh.date_created) <= DATE(?)", $this -> dateTo) -> order("rh.date_created DESC") -> group(array("rh.id")) -> limitPage($this -> page, $this -> rows);
			$sql -> where("rh.admin_id = ?", $recruiter_id);
			
			$rows = $db -> fetchAll($sql);
		}

		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");
		foreach ($rows as $key => $row) {
			$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
		}
		return $rows;
	}

	public function getUniqueNotes($recruiter_id) {
		$db = $this -> db;
		$recs = $this -> getRecruiters();

		$rec_ids = array();
		foreach ($recs as $rec) {
			$rec_ids[] = $rec["admin_id"];
		}

		$rec_ids = implode(",", $rec_ids);
		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
			$rec_support = implode(",", $this -> rec_support);
			$sql = $db -> select() -> from(array("rh" => "resume_evaluation_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rh.date_created AS date"), "rh.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = rh.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(rh.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(rh.date_created) <= DATE(?)", $this -> dateTo) -> group(array("rh.id"))->where("rh.admin_id IN ({$this->recruiter_query})");
			$sql -> order("date DESC") -> limitPage($this -> page, $this -> rows);
			
			if ($recruiter_id=="recruiter"){
				$sql->where("rh.admin_id IN ({$this->recruiter_only})");	
			}else{
				$sql->where("rh.admin_id IN ({$rec_support})");	
			}
			
			$rows = $db -> fetchAll($sql);
		} else {
			$sql = $db -> select() -> from(array("rh" => "resume_evaluation_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS rh.date_created AS date"), "rh.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = rh.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(rh.date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(rh.date_created) <= DATE(?)", $this -> dateTo) -> order("rh.date_created DESC") -> group(array("rh.id")) -> limitPage($this -> page, $this -> rows);
			$sql -> where("rh.admin_id = ?", $recruiter_id);

			$rows = $db -> fetchAll($sql);
		}

		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");
		foreach ($rows as $key => $row) {
			$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
		}
		return $rows;
	}

	
	public function getEvaluationComments($recruiter_id) {
		$db = $this -> db;
		$recs = $this -> getRecruiters();

		$rec_ids = array();
		foreach ($recs as $rec) {
			$rec_ids[] = $rec["admin_id"];
		}

		$rec_ids = implode(",", $rec_ids);
		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
			$rec_support = implode(",", $this -> rec_support);
			$sql = $db -> select() -> from(array("evl" => "evaluation_comments"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS evl.comment_date AS date"), "evl.comment_by AS admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = evl.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(comment_date) >= DATE(?)", $this -> dateFrom) -> where("DATE(comment_date) <= DATE(?)", $this -> dateTo)  -> group(array("evl.id"))->where("evl.comment_by IN ({$this->recruiter_query})");
			
			$sql -> limitPage($this -> page, $this -> rows) -> order("date DESC"); ;
			
			if ($recruiter_id=="recruiter"){
				$sql->where("evl.comment_by IN ({$this->recruiter_only})");	
			}else{
				$sql->where("evl.comment_by IN ({$rec_support})");	
			}
			
			
		}else{
			$sql = $db -> select() -> from(array("evl" => "evaluation_comments"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS evl.comment_date AS date"), "evl.comment_by AS admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = evl.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(comment_date) >= DATE(?)", $this -> dateFrom) -> where("DATE(comment_date) <= DATE(?)", $this -> dateTo) -> group(array("evl.id"))-> limitPage($this -> page, $this -> rows) -> order("date DESC");
			if ($recruiter_id == "Others") {					
				$sql -> where("evl.comment_by IN (SELECT admin_id FROM admin WHERE admin_id NOT IN ($rec_ids))");					
			}else{
				
				$sql -> where("evl.comment_by = ?", $recruiter_id);
				
			}
				
			
		}
		$rows = $db -> fetchAll($sql);

		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");

		foreach ($rows as $key => $row) {
			$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
		}

		return $rows;
	}
	public function getSMSSent($recruiter_id) {
		$db = $this -> db;
		$recs = $this -> getRecruiters();

		$rec_ids = array();
		foreach ($recs as $rec) {
			$rec_ids[] = $rec["admin_id"];
		}

		$rec_ids = implode(",", $rec_ids);
		if ($recruiter_id == "rec_support" ||$recruiter_id == "recruiter") {
			$rec_support = implode(",", $this -> rec_support);

			$sql = $db -> select() -> from(array("sms" => "staff_admin_sms_out_messages"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS sms.date_created AS date"), "sms.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = sms.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(date_created) <= DATE(?)", $this -> dateTo)  -> group(array("sms.id"))->where("sms.admin_id IN ({$this->recruiter_query})");
			$sql -> limitPage($this -> page, $this -> rows) -> order("date DESC"); ;
			
			if ($recruiter_id=="recruiter"){
				$sql->where("sms.admin_id IN ({$this->recruiter_only})");	
			}else{
				$sql->where("sms.admin_id IN ({$rec_support})");	
			}
			
		} else {
			$sql = $db -> select() -> from(array("sms" => "staff_admin_sms_out_messages"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS sms.date_created AS date"), "sms.admin_id")) -> joinLeft(array("p" => "personal"), "p.userid = sms.userid", array("p.fname", "p.lname", "p.userid")) -> where("DATE(date_created) >= DATE(?)", $this -> dateFrom) -> where("DATE(date_created) <= DATE(?)", $this -> dateTo) -> group(array("sms.id")) -> limitPage($this -> page, $this -> rows) -> order("date_created DESC");
			if ($recruiter_id == "Others") {
				$sql -> where("sms.admin_id IN (SELECT admin_id FROM admin WHERE admin_id NOT IN ($rec_ids))");

			} else {
				$sql -> where("sms.admin_id = ?", $recruiter_id);
			}

		}

		$rows = $db -> fetchAll($sql);

		$this -> count = $db -> fetchOne("SELECT FOUND_ROWS() AS count");

		foreach ($rows as $key => $row) {
			$rows[$key]["admin"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_id", "admin_fname", "admin_lname")) -> where("admin_id = ?", $row["admin_id"]));
		}

		return $rows;
	}

	
	private function dateDiff($startDate, $endDate) {
		$startArry = date_parse($startDate);
		$endArry = date_parse($endDate);
		$start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
		$end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);
		return round(($end_date - $start_date), 0);
	}

}
