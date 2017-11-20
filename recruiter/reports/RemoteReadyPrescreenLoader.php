<?php
class RemoteReadyPrescreenLoader{
	private $smarty;
	private $db;
	
	public function __construct($db){
		$this->smarty = new Smarty();
		$this->db = $db;
		$this->authCheck();
	}
	
	protected function authCheck(){
	
		session_start();
		
		if (!isset($_SESSION["admin_id"])){
			header("location:/portal/index.php");
		}
	
		if($_SESSION['status'] <> "FULL-CONTROL"){ 
			echo "This page is for HR usage only.";
			exit;
		}		
		
		$_SESSION["started"] = true;
	}
	
	protected function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' 
		OR admin_id='41'
		OR admin_id='67'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')  
		AND status <> 'REMOVED'  AND status <> 'REMOVED'  AND admin_id <> 161   ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
	
	private function getASLCount($userid){
		return $this->db->fetchOne("SELECT COUNT(*) AS count FROM job_sub_category_applicants WHERE userid = $userid");
	}
	
	private function getShortlistCount($userid){
		return $this->db->fetchOne("SELECT COUNT(*) AS count FROM tb_shortlist_history WHERE userid = $userid");
	}
	
	private function getEndorseCount($userid){
		return $this->db->fetchOne("SELECT COUNT(*) AS count FROM tb_endorsement_history WHERE userid = $userid");
	}
	
	
	private function getContracts($userid){
		return $this->db->fetchAll($this->db->select()->from(array("s"=>"subcontractors"))
				->joinInner(array("l"=>"leads"), "l.id = s.leads_id", array("l.fname AS lead_firstname", "l.lname AS lead_lastname"))->where("userid = ?", $userid));
	}
	
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		
		
		
		$keywordTypes = array(array("key"=>"id", "val"=>"ID"), array("key"=>"first_name", "val"=>"First Name"),array("key"=>"last_name", "val"=>"Last Name"),array("key"=>"email", "val"=>"Email"),array("key"=>"skills", "val"=>"Skills"));
		
		$smarty->assign("keyword_types", $keywordTypes);
		
		if (isset($_REQUEST["keyword"])){
			$smarty->assign("keyword", $_REQUEST["keyword"]);
		}
		
		if (isset($_REQUEST["keyword_type"])&&$_REQUEST["keyword_type"]){
			$smarty->assign("selected_keyword_type", $_REQUEST["keyword_type"]);
		}
		
		if (isset($_REQUEST["date_updated_from"])&&$_REQUEST["date_updated_from"]){
			$smarty->assign("date_updated_from", $_REQUEST["date_updated_from"]);
		}
		
		if (isset($_REQUEST["date_updated_to"])&&$_REQUEST["date_updated_to"]){
			$smarty->assign("date_updated_to", $_REQUEST["date_updated_to"]);
		}
		
		if (isset($_REQUEST["date_registered_from"])&&$_REQUEST["date_registered_from"]){
			$smarty->assign("date_registered_from", $_REQUEST["date_registered_from"]);
		}
		
		
		if (isset($_REQUEST["date_registered_to"])&&$_REQUEST["date_registered_to"]){
			$smarty->assign("date_registered_to", $_REQUEST["date_registered_to"]);
		}
		
		if (isset($_REQUEST["job_position"])){
			$smarty->assign("job_position", $_REQUEST["job_position"]);
		}
		
		if (isset($_REQUEST["recruiter"])){
			$smarty->assign("selected_recruiter", $_REQUEST["recruiter"]);
		}
		if (isset($_REQUEST["availability_status"])){
			$smarty->assign("selected_availability_status", $_REQUEST["availability_status"]);
		}
		$categories = $db->fetchAll($db->select()->from(array("jc"=>"job_category"), array("jc.category_id", "jc.category_name")));
		foreach($categories as $keyCat=>$category){
			$categorySql = $db->select()->from(array("jsc"=>"job_sub_category"), array("sub_category_id", "sub_category_name"))->where("category_id = ?", $category["category_id"])->where("sub_category_name != ''");
			if (isset($_REQUEST["job_position"])&&$_REQUEST["job_position"]){
				$categorySql->where("jsc.sub_category_id = ?", $_REQUEST["job_position"]);
			}
				
			$subcategories = $db->fetchAll($categorySql);
			foreach($subcategories as $keyItem=>$subcategory){
				$sql = $db->select()->from(array("rroi"=>"remote_ready_order_items"), 
											array("rroi.id AS id",
											 "rroi.work_status AS work_status", 
											 "rroi.working_timezone",
											  "rroi.start_work", 
											  "rroi.end_work",
											   "rroi.availability_status",
											    "rroi.userid AS userid",
												"rroi.remote_ready_order_id"))
										->joinInner(array("rro"=>"remote_ready_orders"), "rroi.remote_ready_order_id = rro.id", array())
										->joinInner(array("l"=>"leads"), "l.id = rro.remote_ready_lead_id", array())
										->joinRight(array("pce"=>"personal_categorization_entries"), "pce.userid = rroi.userid AND pce.sub_category_id = rroi.sub_category_id", array())
										->joinInner(array("p"=>"personal"), "p.userid=rroi.userid", array())
										->joinInner(array("c"=>"currentjob"), "c.userid = p.userid", array("c.expected_salary AS expected_salary", "c.salary_currency AS salary_currency"))
										
										->where("rroi.sub_category_id = ?", $subcategory["sub_category_id"])
										->where("rroi.id IS NOT NULL");
										
				if (isset($_REQUEST["date_updated_from"])&&isset($_REQUEST["date_updated_to"])&&$_REQUEST["date_updated_from"]&&$_REQUEST["date_updated_to"]){
					$sql->where("p.dateupdated >= ?", $_REQUEST["date_updated_from"])
					->where("p.dateupdated <= ?", $_REQUEST["date_updated_to"]);					
				}
				
				
				if (isset($_REQUEST["date_registered_from"])&&isset($_REQUEST["date_registered_to"])&&$_REQUEST["date_registered_from"]&&$_REQUEST["date_registered_to"]){
					$sql->where("DATE(p.datecreated) >= ?", $_REQUEST["date_registered_from"])
					->where("DATE(p.datecreated) <= ?", $_REQUEST["date_registered_to"]);			
				}
				
				if (isset($_REQUEST["recruiter"])&&$_REQUEST["recruiter"]){
					if ($_REQUEST["recruiter"]=="None"){
						$sql->joinInner(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())->where("rs.admin_id IS NULL");					
					}else{
						$sql->joinInner(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())->where("rs.admin_id = ?", $_REQUEST["recruiter"]);	
					}
					
				}
				
				if (isset($_REQUEST["availability_status"])&&$_REQUEST["availability_status"]){
					$sql->where("rroi.availability_status = ?", $_REQUEST["availability_status"]);
				}
				
				if (isset($_REQUEST["keyword"])&&isset($_REQUEST["keyword_type"])&&$_REQUEST["keyword"]&&$_REQUEST["keyword_type"]){
					$keywordType = $_REQUEST["keyword_type"];
					$keyword = $_REQUEST["keyword"];
					if ($keywordType=="id"){
						$sql->where("p.userid = ?", $keyword);
					}else if ($keywordType=="first_name"){
						$sql->where("p.fname = ?", $keyword);
					}else if ($keywordType=="last_name"){
						$sql->where("p.lname = ?", $keyword);
					}else if ($keywordType=="email"){
						$sql->where("p.email = ?", $keyword);
					}else if ($keywordType=="skills"){
						$sql->joinRight(array("s"=>"skills_myisam"), "s.userid = p.userid", array())
						->where("MATCH(s.skill) AGAINST ('".addslashes($keyword)."' IN BOOLEAN MODE)")
						->group("rroi.id");
					}
				}
				
				
				$result = $db->fetchAll($sql);
			
				if (!empty($result)){
					foreach($result as $key=>$item){
						$result[$key]["personal"] = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("image", "userid", "fname", "lname", "email"))->where('userid = ?',$item["userid"] ));
						$result[$key]["personal"]["recruiter"] = $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"), array())->joinLeft(array("adm"=>"admin"), "adm.admin_id=rs.admin_id", array("adm.admin_fname", "adm.admin_lname", "adm.admin_id"))->where("rs.userid = ?", $item["userid"]));
						$result[$key]["personal"]["shortlist"] = $this->getShortlistCount($item["userid"]);
						
						$result[$key]["personal"]["endorsed"] = $this->getEndorseCount($item["userid"]);
						$result[$key]["personal"]["asl"] = $this->getASLCount($item["userid"]);
						$result[$key]["personal"]["contracts"] = $this->getContracts($item["userid"]);
						//get all skills
						$skills = $db->fetchAll($db->select()->from(array("s"=>"skills"))->where("s.userid = ?", $item["userid"]));
						
						$skillList = array();
						foreach($skills as $skill){
							$skillList[] = $skill["skill"];
						}
						
						$result[$key]["personal"]["skills"] = implode(", ", $skillList);
						
						
						
						$order = $db->fetchRow($db->select()->from(array("rro"=>"remote_ready_orders"))->where("id = ?", $item["remote_ready_order_id"]));
						if ($order){
							$order["date_created"] = date("Y-m-d", strtotime($order["date_created"]));
							$result[$key]["order"] = $order;
							$result[$key]["jobspec"] = $db->fetchRow($db->select()->from(array("rrojs"=>"remote_order_item_job_specifications"))->where("rrojs.job_sub_category_id = ?", $subcategory["sub_category_id"])->where("userid = ?", $item["userid"])->where("remote_ready_order_id = ?", $order["id"]));
							
							
							$result[$key]["lead"] = $db->fetchRow($db->select()->from(array("l"=>"leads"), array("id", "fname", "lname"))->where("id = ?",$result[$key]["order"]["remote_ready_lead_id"]));		
							
						}else{
							$result[$key]["order"] = array();
							$result[$key]["jobspec"] = array();
							$result[$key]["lead"] = array();
						}
	
					}
					$subcategories[$keyItem]["orders"] = $result;
				}else{
					$subcategories[$keyItem]["orders"] = array();
				}
			}
			$categories[$keyCat]["subcategories"] = $subcategories;
		}
		//finalize list
		$finalList = array();
		foreach($categories as $category){
			$isEmpty = true;	
			foreach($category["subcategories"] as $subcategory){
				if (!empty($subcategory["orders"])){
					$isEmpty = false;
					break;	
				}
			}
			if (!$isEmpty){
				$finalList[] = $category;
			}
		}
		$categoriesDrop = $db->fetchAll($db->select()->from(array("jc"=>"job_category"), array("jc.category_id", "jc.category_name")));
		foreach($categoriesDrop as $keyCat=>$category){
			$subcategories = $db->fetchAll($db->select()->from(array("jsc"=>"job_sub_category"), array("sub_category_id", "sub_category_name"))->where("category_id = ?", $category["category_id"])->where("sub_category_name != ''"));
			$categoriesDrop[$keyCat]["subcategories"] = $subcategories;
		}
		$smarty->assign("availability_status", array("Checking", "Available to Interview", "No Longer Available"));
		$smarty->assign("categories", $finalList);
		$smarty->assign("categoriesDrop", $categoriesDrop);
		$smarty->assign("recruiters", $this->getRecruiters());
		$smarty->display("request_for_prescreen.tpl");
	}
}
