<?php
class RecruiterASLReports{
	private $db;
	private $date_from;
	private $date_to;
	
	public function __construct($db){
		$this->db = $db;
		$this->gatherInput();
	}	
	
	
	private function gatherInput(){
		if ($_REQUEST["date_from"]&&$_REQUEST["date_to"]){
			$this->date_from = $_REQUEST["date_from"];
			$this->date_to = $_REQUEST["date_to"];
			
		}
	}
	public function getList(){
		$db = $this->db;
		//load all subcategories
		$jcs = $db->fetchAll($db->select()->from(array("jc"=>"job_category"), array("jc.category_id", "jc.category_name"))->order("category_name"));
		foreach($jcs as $key=>$jc){
			
			$sql = $db->select()->from(array("jsc"=>"job_sub_category"), array("jsc.sub_category_id", "jsc.sub_category_name", "jsc.singular_name"))->where("jsc.category_id = ?", $jc["category_id"]);
			$subcategories = $db->fetchAll($sql);
			foreach($subcategories as $key_s=>$subcategory){
				$subcategories[$key_s]["average"] = round($this->getAverage($subcategory), 2);
				$subcategories[$key_s]["total_orders"] = $this->getJobOrderCount($subcategory);
				$subcategories[$key_s]["pool"] = round($this->getPool($subcategory), 2);
				$subcategories[$key_s]["average_handling_time"] = round($this->getAverageHandlingTime($subcategory), 2);	
				
				$recruiters = $this->getRecruiters();
				//load recruiters orders
				foreach($recruiters as $key_recruiter=>$recruiter){
					$recruiters[$key_recruiter]["total_categorized"] = $this->getCategorizedCount($recruiter["admin_id"], $subcategory["sub_category_id"]);
				}
				
				$subcategories[$key_s]["recruiters"] = $recruiters;
			}
			$jcs[$key]["job_sub_categories"] = $subcategories; 
			
			
		}
		return $jcs;
	}
	
	public function getCategorizedCount($recruiter_id, $sub_category_id){
		$db = $this->db;
		$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array(new Zend_Db_Expr("COUNT(*) AS count_asl")))
				->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = jsca.userid", array())
				->where("jsca.sub_category_id = ?", $sub_category_id)
				->where("rs.admin_id = ?", $recruiter_id);
		if ($this->date_from&&$this->date_to){
			$sql->where("DATE(jsca.sub_category_applicants_date_created) >= DATE(?)", $this->date_from)
				->where("DATE(jsca.sub_category_applicants_date_created) <= DATE(?)", $this->date_to);
		}		
		return $db->fetchOne($sql);
	}
	
	public function getCategorized($recruiter_id, $sub_category_id){
		$db = $this->db;
		$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array(new Zend_Db_Expr("DATE(jsca.sub_category_applicants_date_created) AS date")))
				->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = jsca.userid", array())
				->joinLeft(array("p"=>"personal"), "p.userid = jsca.userid", array("p.fname", "p.lname", "p.userid"))
				
				->order(array("jsca.sub_category_applicants_date_created DESC"));
		if ($sub_category_id){
			$sql->where("jsca.sub_category_id = ?", $sub_category_id);
		}
		if ($recruiter_id!="ALL"){
			$sql->where("rs.admin_id = ?", $recruiter_id);	
		}else{
			$sql->where("rs.admin_id IN (SELECT admin_id FROM admin WHERE admin.status = 'HR')");
		}
		if ($this->date_from&&$this->date_to){
			$sql->where("DATE(jsca.sub_category_applicants_date_created) >= DATE(?)", $this->date_from)
				->where("DATE(jsca.sub_category_applicants_date_created) <= DATE(?)", $this->date_to);
		}		
		return $db->fetchAll($sql);
	}
	
	
	
	public function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' 
		OR admin_id='41'
		OR admin_id='67'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')   AND admin_id <> 161  
		AND status <> 'REMOVED'  AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
	public function getJobOrderCount($subcategory){
		return count($this->getJobOrders($subcategory));
		
	}
	
	
	public function getJobOrders($subcategory){
		$db = $this->db;
		$names = $subcategory["singular_name"];
		$names = explode(" ", $names);
		foreach($names as $key=>$name){
			$names[$key] = trim($name);
		}
		$names = implode(" ", $names);
		
		$sql = $db->select()->from(array("jo"=>"mongo_job_orders"))->where("MATCH(job_title) AGAINST('\"{$names}\"' IN BOOLEAN MODE)");
		$sql2 = $db->select()->from(array("jo"=>"mongo_job_orders"))->joinInner(array("joc"=>"mongo_job_orders_categories"), "joc.tracking_code = jo.tracking_code", array())->where("joc.job_sub_category_id = ?", $subcategory["sub_category_id"]);
		if ($this->date_from&&$this->date_to){
			$sql->where("DATE(date_ordered) >= DATE(?)", $this->date_from);
			$sql->where("DATE(date_ordered) <= DATE(?)", $this->date_to);		
			$sql2->where("DATE(date_ordered) >= DATE(?)", $this->date_from);
			$sql2->where("DATE(date_ordered) <= DATE(?)", $this->date_to);		
			
		}
		$sql->where("date_closed IS NOT NULL")->where("date_closed <> '0000-00-00 00:00:00'");
		$sql2->where("date_closed IS NOT NULL")->where("date_closed <> '0000-00-00 00:00:00'");
		
		$sql = $db->select()->union(array($sql, $sql2))->order("date_closed DESC");
		$result = $db->fetchAll($sql);
		if ($result){
			$refineList = array();
			foreach($result as $item){
				$found = false;
				foreach($refineList as $listItem){
					if ($listItem["tracking_code"]==$item["tracking_code"]){
						$found = true;	
						break;
					}
				}
				if (!$found){
					$refineList[] = $item;
				}
			}
			
			return $refineList;
		}else{
			return array();
		}	
	}
	
	public function getAverage($subcategory){
		$job_order_count  = $this->getJobOrderCount($subcategory);
		$date1 = date(strtotime($this->date_from));
		$date2 = date(strtotime($this->date_to));
		
		$difference = $date2 - $date1;
		$months = floor($difference / 86400 / 30 );
		if ($months>0){
			return $job_order_count/$months;			
		}else{
			return $job_order_count;
		}
	}
	
	public function getPool($subcategory){
		$average = $this->getAverage($subcategory);
		$pool = $average*4;
		if ($pool==0){
			return 1;
		}else{
			return $pool;
		}
	}
	
	public function getAverageHandlingTime($subcategory){
		$db = $this->db;
		$names = $subcategory["singular_name"];
		$names = explode(" ", $names);
		foreach($names as $key=>$name){
			$names[$key] = trim($name);
		}
		$names = implode(" ", $names);
		
		$sql = $db->select()->from(array("jo"=>"mongo_job_orders"))->where("MATCH(job_title) AGAINST('\"{$names}\"' IN BOOLEAN MODE)");
		$sql2 = $db->select()->from(array("jo"=>"mongo_job_orders"))->joinInner(array("joc"=>"mongo_job_orders_categories"), "joc.tracking_code = jo.tracking_code", array())->where("joc.job_sub_category_id = ?", $subcategory["sub_category_id"]);
		if ($this->date_from&&$this->date_to){
			$sql->where("DATE(date_ordered) >= DATE(?)", $this->date_from);
			$sql->where("DATE(date_ordered) <= DATE(?)", $this->date_to);		
			$sql2->where("DATE(date_ordered) >= DATE(?)", $this->date_from);
			$sql2->where("DATE(date_ordered) <= DATE(?)", $this->date_to);						
		}
		$sql->where("date_closed IS NOT NULL")->where("date_closed <> '0000-00-00 00:00:00'");
		$sql2->where("date_closed IS NOT NULL")->where("date_closed <> '0000-00-00 00:00:00'");
		
		$sql = $db->select()->union(array($sql, $sql2));
		
		$job_orders = $db->fetchAll($sql);
		$total_number_of_days = 0;
		$count = 0;
		
		$refineList = array();
		foreach($job_orders as $item){
			$found = false;
			foreach($refineList as $listItem){
				if ($listItem["tracking_code"]==$item["tracking_code"]){
					$found = true;	
					break;
				}
			}
			if (!$found){
				$refineList[] = $item;
			}
		}
		
		
		
		foreach($refineList as $job_order){
			$from = strtotime($job_order["date_ordered"]);
			$to = strtotime($job_order["date_closed"]);
			$diff = $to - $from;
			$number_of_days = floor($diff/(60*60*24));
			$total_number_of_days += $number_of_days;
			$count++;
		}
		if ($count>0){
			return $total_number_of_days/$count;
			
		}else{
			return 0;
		}
	}
	
}