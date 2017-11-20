<?php
class RecruiterStaffContractCounter{
	
	private $db;
	private $dateFrom;
	private $dateTo;
	private $contractStatus;
	private $inhouseStaff;
	
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
		
		if (isset($_GET["contract_status"])){
			$this->contractStatus = $_GET["contract_status"];		
		}else{
			$this->contractStatus = "All";			
		}
		
		if (isset($_GET["inhouse_staff"])){
			$this->inhouseStaff = $_GET["inhouse_staff"];		
		}else{
			$this->inhouseStaff = "yes";			
		}

	}
	
	
	private function getCountServiceType($service_type, $recruiter){
		$db = $this->db;
			$sql = $db->select()->from(array("s"=>"subcontractors"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS s.id AS id"), "s.userid AS userid", "s.date_contracted", "s.starting_date", "s.leads_id AS lead_id", "s.service_type AS service_type", "s.status AS status", "s.resignation_date", "s.date_terminated"))
				->joinLeft(array("rs"=>"recruiter_staff"), "s.userid = rs.userid", array());
		
		if ($recruiter!="All"){
			if ($recruiter=="Resigned"){
				$sql->where("rs.admin_id NOT IN (SELECT admin_id FROM admin WHERE status = 'HR')");
			}else{
				if ($recruiter["admin_id"]!=0){
					$sql->where("rs.admin_id = ?", $recruiter["admin_id"]);	
				}else{
					$sql->where("rs.admin_id IS NULL");	
				}
					
			}
		}
		
		if ($service_type!="All"){
			$sql->where("s.service_type = ?", $service_type);			
		}		
		
		$sql->where("s.service_type IS NOT NULL");
		
		//CONTRACT STATUS
		if ($this->contractStatus=="Active"){
			$sql->where("s.status IN ('ACTIVE', 'suspended')");	
		}else if ($this->contractStatus=="Inactive"){
			$sql->where("s.status IN ('resigned', 'terminated')");
		}else{
			$sql->where("s.status IN ('ACTIVE', 'terminated', 'resigned', 'suspended')");
		}
		
		//DATE FROM AND DATE TO
		$sql->where("s.starting_date >= DATE('".$this->dateFrom."') AND s.starting_date <= DATE('".$this->dateTo."')")->limit(1);
		
		//INHOUSE
		if($this->inhouseStaff =='no') {
			$sql->where("s.leads_id != 11");
		}
		
		$count = $db->fetchAll($sql);		
	
		$count = $db->fetchOne("SELECT FOUND_ROWS()");
		return $count;
	}
	
	public function getList($service_type, $recruiter, $inhouseStaff){
		$db = $this->db;
		$sql = $db->select()
					->from(array("s"=>"subcontractors"), array("s.id AS id", "s.userid AS userid", "s.date_contracted", "s.starting_date", "s.leads_id AS lead_id", "s.service_type AS service_type", "s.status AS status", "s.resignation_date", "s.date_terminated"))
					->joinLeft(array("rs"=>"recruiter_staff"), "s.userid = rs.userid", array());
		
		if ($recruiter!="All"){
			if ($recruiter=="Resigned"){
				$sql->where("rs.admin_id NOT IN (SELECT admin_id FROM admin WHERE status = 'HR')");
			}else{
				if ($recruiter["admin_id"]!=0){
					$sql->where("rs.admin_id = ?", $recruiter["admin_id"]);	
				}else{
					$sql->where("rs.admin_id IS NULL");	
				}
					
			}
		}		
		if ($service_type!="All"){
			$sql->where("s.service_type = ?", $service_type);			
		}
		
		//CONTRACT STATUS
		if ($this->contractStatus=="Active"){
			$sql->where("s.status IN ('ACTIVE', 'suspended')");	
		}else if ($this->contractStatus=="Inactive"){
			$sql->where("s.status IN ('resigned', 'terminated')");
		}else{
			$sql->where("s.status IN ('ACTIVE', 'terminated', 'resigned', 'suspended')");
		}
		
		//DATE FROM AND DATE TO
		$sql->where("s.starting_date >= DATE('".$this->dateFrom."') AND s.starting_date <= DATE('".$this->dateTo."')");
		
		//INHOUSE
		if($inhouseStaff =='no') {
			$sql->where("s.leads_id != 11");
		}
		
		$sql->order(array("s.starting_date DESC"));
		
		$rows = $db->fetchAll($sql);
		$i = 1;
		foreach($rows as $key=>$row){
			$rows[$key]["count"] = $i;
			$rows[$key]["staff"] = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("p.userid", "p.fname", "p.lname"))->where("p.userid = ?", $row["userid"])); 
			if ($row["status"]=="ACTIVE"||$row["status"]=="suspended"){
				$rows[$key]["end_date"] = date("Y-m-d");
				$rows[$key]["end_label"] = "";
			}else if ($row["status"]=="resigned"){
				$rows[$key]["end_date"] = date("Y-m-d", strtotime($row["resignation_date"]));
				$rows[$key]["end_label"] = date("Y-m-d", strtotime($row["resignation_date"]));
			}else if ($row["status"]=="terminated"){
				$rows[$key]["end_date"] = date("Y-m-d", strtotime($row["date_terminated"]));
				$rows[$key]["end_label"] = date("Y-m-d", strtotime($row["date_terminated"]));
			}
			$rows[$key]["start_date"] = date("Y-m-d", strtotime($row["starting_date"]));
			$rows[$key]["contract_length"] = $this->dateDiff($rows[$key]["start_date"], $rows[$key]["end_date"]);
			$rows[$key]["lead"] = $db->fetchRow($db->select()->from(array("l"=>"leads"), array("id", "fname", "lname"))->where("id = ?", $row["lead_id"]));		
			if (!isset($rows[$key]["service_type"])!=""){
				$rows[$key]["service_type"] = "ASL";
			}
			$i++;
		}
		return $rows;
	}
	
	
	public function getCount(){
		$db = $this->db;
		$recruiters = $this->getRecruiters();
		$result = array();
		foreach($recruiters as $recruiter){
			$resultItem = array();
			$resultItem["admin_id"] = $recruiter["admin_id"];
			$resultItem["admin_name"] = $recruiter["admin_fname"]." ".$recruiter["admin_lname"];
			$resultItem["aslcount"] = $this->getCountServiceType("ASL", $recruiter);
			$resultItem["customcount"] = $this->getCountServiceType("Customs", $recruiter);
			$resultItem["inhousecount"] = $this->getCountServiceType("Inhouse", $recruiter);
			$resultItem["backordercount"] = $this->getCountServiceType("Back Order", $recruiter);
			$resultItem["replacementcount"] = $this->getCountServiceType("Replacement", $recruiter);
			$resultItem["projectbasedcount"] = $this->getCountServiceType("Project Based", $recruiter);
			$resultItem["trialcount"] = $this->getCountServiceType("Trial", $recruiter);
			
			$resultItem["totalcount"] = $resultItem["aslcount"]+$resultItem["customcount"]+$resultItem["inhousecount"]+$resultItem["backordercount"]+$resultItem["replacementcount"]+$resultItem["projectbasedcount"]+$resultItem["trialcount"];
			$result[] = $resultItem;
		}
		$resultItem = array(); 
		$recruiter = array();
		$recruiter["admin_id"]  = 0;
		$resultItem["admin_id"] = 0;
		$resultItem["admin_name"] = "No Recruiter Assigned";
		$resultItem["aslcount"] = $this->getCountServiceType("ASL", $recruiter);
		$resultItem["customcount"] = $this->getCountServiceType("Customs", $recruiter);
		$resultItem["inhousecount"] = $this->getCountServiceType("Inhouse", $recruiter);
		$resultItem["backordercount"] = $this->getCountServiceType("Back Order", $recruiter);
		$resultItem["replacementcount"] = $this->getCountServiceType("Replacement", $recruiter);
		$resultItem["projectbasedcount"] = $this->getCountServiceType("Project Based", $recruiter);
		$resultItem["trialcount"] = $this->getCountServiceType("Trial", $recruiter);
		
		$resultItem["totalcount"] = $resultItem["aslcount"]+$resultItem["customcount"]+$resultItem["inhousecount"]+$resultItem["backordercount"]+$resultItem["replacementcount"]+$resultItem["projectbasedcount"]+$resultItem["trialcount"];
		$result[] = $resultItem;
		
		
		$recruiter = array();
		$recruiter = "Resigned";
		$resultItem["admin_id"] = "Resigned";
		$resultItem["admin_name"] = "No Recruiter Assigned";
		$resultItem["aslcount"] = $this->getCountServiceType("ASL", $recruiter);
		$resultItem["customcount"] = $this->getCountServiceType("Customs", $recruiter);
		$resultItem["inhousecount"] = $this->getCountServiceType("Inhouse", $recruiter);
		$resultItem["backordercount"] = $this->getCountServiceType("Back Order", $recruiter);
		$resultItem["replacementcount"] = $this->getCountServiceType("Replacement", $recruiter);
		$resultItem["projectbasedcount"] = $this->getCountServiceType("Project Based", $recruiter);
		$resultItem["trialcount"] = $this->getCountServiceType("Trial", $recruiter);
		
		$resultItem["totalcount"] = $resultItem["aslcount"]+$resultItem["customcount"]+$resultItem["inhousecount"]+$resultItem["backordercount"]+$resultItem["replacementcount"]+$resultItem["projectbasedcount"]+$resultItem["trialcount"];
		$result[] = $resultItem;
		
		return $result;
	}
	
	
	private function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` where (status='HR' OR admin_id IN (236, 239, 228, 225, 227, 167, 242, 226,169)) AND status <> 'REMOVED' AND admin_id <> 161 ORDER by admin_fname";
		
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
