<?php
class SMSLister{
	private $db;
	private $page = 1;
	private $rows = 50;
	
	private $csro_id = "";
	private $recruiter_id = "";
	
	private $keyword_type = "";
	private $keyword = "";
	
	private $date_from = "";
	private $date_to = "";
	
	private $mode = "";
	private $read = "";
	private $show_type = "";
	private $show_only_not_in_system = "";
	private $show_only_compliance = "";
	
	private $hasFilter = false;
	
	public function __construct($db){
		$this->db = $db;
		$this->gatherInput();
	}
	
	private function gatherInput(){
		if ($_REQUEST["csro_id"]){
			$this->csro_id = $_REQUEST["csro_id"];
			$this->hasFilter = true;
		}
		if ($_REQUEST["recruiter_id"]){
			$this->recruiter_id = $_REQUEST["recruiter_id"];
			$this->hasFilter = true;
		}
		if ($_REQUEST["page"]){
			$this->page = $_REQUEST["page"];
		}
		
		if ($_REQUEST["keyword"]){
			$this->keyword = $_REQUEST["keyword"];
			
			$this->hasFilter = true;
			
		}
		
		if ($_REQUEST["date_from"]&&$_REQUEST["date_to"]){
			$this->date_from = $_REQUEST["date_from"];
			$this->date_to = $_REQUEST["date_to"];
			$this->hasFilter = true;
			
		}else{
			$this->date_from = date("Y-m-d", strtotime("-1 DAY"));
			$this->date_to = date("Y-m-d");
			$this->hasFilter = true;
			
		}
		
		if ($_REQUEST["mode"]){
			$this->mode = $_REQUEST["mode"];
			$this->hasFilter = true;
			
		}
		
		if ($_REQUEST["read"]){
			$this->read = $_REQUEST["read"];
			$this->hasFilter = true;
			
		}
		
		if ($_REQUEST["show_type"]){
			$this->show_type = $_REQUEST["show_type"];
			$this->hasFilter = true;
		}
		
		if ($_REQUEST["show_only_not_in_system"]){
			$this->show_only_not_in_system = $_REQUEST["show_only_not_in_system"];
			$this->hasFilter = true;
		}
		
		if ($_REQUEST["show_only_compliance"]){
			$this->hasFilter = true;
			$this->show_only_compliance = $_REQUEST["show_only_compliance"];
		}
	}
	
	public function getList(){
		$db = $this->db;
		$sql = $db->select()->from(array("sms"=>"sms_messages"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS sms.id"), "sms.mobile_number", "sms.message", "sms.date_received", "sms.read", "sms.mode", "sms.date_sent", new Zend_Db_Expr("CASE WHEN sms.mode = 'reply' THEN sms.date_received ELSE sms.date_sent END AS order_date")))
				->joinLeft(array("p"=>"personal"), "p.handphone_no = sms.mobile_number", array("p.userid", "p.fname", "p.lname"))
				->joinLeft(array("ca"=>"admin"), "ca.admin_id = sent_by", array(new Zend_Db_Expr("CONCAT(ca.admin_fname, ' ', ca.admin_lname) AS sender_admin")))				
				->where("sms.mode = 'reply'")
				;
			
		$sql->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())
			->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", 
									array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS recruiter_fullname") ));
		
		
		$sql2 = $db->select()->from(array("sms"=>"sms_messages"), array(new Zend_Db_Expr("sms.id"), "sms.mobile_number", "sms.message", "sms.date_received", "sms.read", "sms.mode", "sms.date_sent", new Zend_Db_Expr("CASE WHEN sms.mode = 'reply' THEN sms.date_received ELSE sms.date_sent END AS order_date")))
				->joinLeft(array("p"=>"personal"), "p.handphone_no = SUBSTR(sms.mobile_number, 2)", array("p.userid", "p.fname", "p.lname"))
				->joinLeft(array("ca"=>"admin"), "ca.admin_id = sent_by", array(new Zend_Db_Expr("CONCAT(ca.admin_fname, ' ', ca.admin_lname) AS sender_admin")))				
				->where("sms.mode = 'reply'")
				;
		$sql2->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())
			->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", 
									array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS recruiter_fullname") ));
		
		$sql3 = $db->select()->from(array("sms"=>"sms_messages"), array("sms.id"))
				->joinLeft(array("p"=>"personal"), "p.handphone_no = sms.mobile_number", array())
				->where("sms.mode = 'reply'");
		$sql3->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())
			->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", 
									array());
		
		
		$sql4 = $db->select()->from(array("sms"=>"sms_messages"), array("sms.id", "sms.mobile_number", "sms.message", "sms.date_received", "sms.read", "sms.mode", "sms.date_sent", new Zend_Db_Expr("CASE WHEN sms.mode = 'reply' THEN sms.date_received ELSE sms.date_sent END AS order_date")))
			->joinLeft(array("smsout"=>"staff_admin_sms_out_messages"), "smsout.mobile_number = sms.mobile_number", array())
			->joinLeft(array("p"=>"personal"), "smsout.userid = p.userid", array("p.userid", "p.fname", "p.lname"))
			->joinLeft(array("ca"=>"admin"), "ca.admin_id = sent_by", array(new Zend_Db_Expr("CONCAT(ca.admin_fname, ' ', ca.admin_lname) AS sender_admin")))				
			->where("sms.mode = 'send'")
			;
		
		$sql4->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())
			->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", 
									array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS recruiter_fullname") ));
		
		
		if ($this->hasFilter){
			if ($this->read){
				if ($this->read=="read"){
					$sql->where("sms.read = ?", 1);
					$sql2->where("sms.read = ?", 1);
					$sql3->where("sms.read = ?", 1);
					
					$sql4->where("sms.read = ?", 1);
					
				}else{
					$sql->where("sms.read = ?", 0);
					$sql2->where("sms.read = ?", 0);
					$sql4->where("sms.read = ?", 0);
				}
				
			}
			
			if ($this->mode){
				$sql->where("sms.mode = ?", $this->mode);
				$sql2->where("sms.mode = ?", $this->mode);
				$sql3->where("sms.mode = ?", $this->mode);
				
				$sql4->where("sms.mode = ?", $this->mode);
				
			}
			
			if ($this->date_from&&$this->date_to){
				if ($this->mode=="reply"){
					$sql->where("DATE(sms.date_received) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_received) <= DATE(?)", $this->date_to);	
					$sql2->where("DATE(sms.date_received) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_received) <= DATE(?)", $this->date_to);	
					$sql3->where("DATE(sms.date_received) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_received) <= DATE(?)", $this->date_to);	
						
					$sql4->where("DATE(sms.date_received) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_received) <= DATE(?)", $this->date_to);			
				}else if ($this->mode=="sent"){
					$sql->where("DATE(sms.date_sent) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_sent) <= DATE(?)", $this->date_to);
					$sql2->where("DATE(sms.date_received) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_received) <= DATE(?)", $this->date_to);	
					$sql3->where("DATE(sms.date_received) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_received) <= DATE(?)", $this->date_to);	
						
					$sql4->where("DATE(sms.date_received) >= DATE(?)", $this->date_from)
						->where("DATE(sms.date_sent) <= DATE(?)", $this->date_to);		
					
				}else{
					$this->date_from = addslashes($this->date_from);
					$this->date_to = addslashes($this->date_to);				
					$where = "((DATE(sms.date_received) >= DATE('{$this->date_from}') AND DATE(sms.date_received) <= DATE('{$this->date_to}')) OR (DATE(sms.date_sent) >= DATE('{$this->date_from}') AND DATE(sms.date_sent) <= DATE('{$this->date_to}')))";
					$sql->where($where);
					$sql2->where($where);
					$sql3->where($where);
					
					$sql4->where($where);
				}
	
			}


			if ($this->keyword){
				$sql->where("sms.mobile_number LIKE '%".addslashes($this->keyword)."%'");
				$sql2->where("sms.mobile_number LIKE '%".addslashes($this->keyword)."%'");
				$sql3->where("sms.mobile_number LIKE '%".addslashes($this->keyword)."%'");
				$sql4->where("sms.mobile_number LIKE '%".addslashes($this->keyword)."%'");
			}
			
			if ($this->recruiter_id){
				$sql->where("rs.admin_id = ?", $this->recruiter_id);
				$sql2->where("rs.admin_id = ?", $this->recruiter_id);
				$sql3->where("rs.admin_id = ?", $this->recruiter_id);
				$sql4->where("rs.admin_id = ?", $this->recruiter_id);
			}
			
			if ($this->show_type=="show_only_active_subcon"||$this->csro_id){
				$sql->joinRight(array("s"=>"subcontractors"), "s.userid = p.userid", array())
					->joinLeft(array("l"=>"leads"), "s.leads_id = l.id", array())
					->group("p.userid");
				$sql2->joinRight(array("s"=>"subcontractors"), "s.userid = p.userid", array())
					->joinLeft(array("l"=>"leads"), "s.leads_id = l.id", array())
					->group("p.userid");
				$sql3->joinRight(array("s"=>"subcontractors"), "s.userid = p.userid", array())
					->joinLeft(array("l"=>"leads"), "s.leads_id = l.id", array())
					->group("p.userid");
					
				$sql4->joinRight(array("s"=>"subcontractors"), "s.userid = p.userid", array())
					->joinLeft(array("l"=>"leads"), "s.leads_id = l.id", array())
					->group("p.userid");
				if ($this->show_type){
					if ($this->show_type=="show_only_active_subcon"){
						$sql->where("s.status IN ('Active', 'suspended')");
						$sql2->where("s.status IN ('Active', 'suspended')");
						$sql3->where("s.status IN ('Active', 'suspended')");
					
						$sql4->where("s.status IN ('Active', 'suspended')");
					}else if ($this->show_type=="show_only_nonactive_subcon"){
						$sql->where("s.status NOT IN ('Active', 'suspended')");
						$sql2->where("s.status NOT IN ('Active', 'suspended')");
						$sql3->where("s.status IN ('Active', 'suspended')");
					
						$sql4->where("s.status NOT IN  ('Active', 'suspended')");
					}
				}else{
					$sql->where("s.status IN ('Active', 'suspended')");
					$sql2->where("s.status IN ('Active', 'suspended')");
					$sql3->where("s.status IN ('Active', 'suspended')");
					
					$sql4->where("s.status IN ('Active', 'suspended')");
				}
				
				if ($this->csro_id){
					$sql->where("l.csro_id = ?", $this->csro_id);
					$sql2->where("l.csro_id = ?", $this->csro_id);
					$sql3->where("l.csro_id = ?", $this->csro_id);
					
					$sql4->where("l.csro_id = ?", $this->csro_id);
					
				}
			}
			if ($this->show_only_not_in_system=="yes"){
				$sql->where("p.userid IS NULL");
				$sql2->where("p.userid IS NULL");
				$sql3->where("p.userid IS NULL");
				$sql4->where("p.userid IS NULL");
			}
			
			if ($this->show_only_compliance=="yes"){
				$sql->where("sms.reply_number = '09175337949'");
				$sql2->where("sms.reply_number = '09175337949'");
				$sql3->where("sms.reply_number = '09175337949'");
				$sql4->where("sms.reply_number = '09175337949'");
			}
		}

		
		if ($this->read){
			$sql->group(array("id", "mobile_number"));
		}else{
			$sql2->where("sms.id NOT IN (".$sql3->__toString().")");
			$sql = $db->select()->union(array($sql, $sql2, $sql4))->group(array("id", "mobile_number"));
		
		}
		$sql->order(array("order_date DESC"))
			->limitPage($this->page, $this->rows);
			
		
		$rows = $db->fetchAll($sql);
		$total = $db->fetchOne("SELECT FOUND_ROWS() AS count");
		
		foreach($rows as $key=>$row){
			//load all assigned csro's
			$rows[$key]["mobile_number"] = str_replace("+639", "09", $row["mobile_number"]);
			if ($row["mobile_number"]&&!$row["userid"]){
				$foundOwner = $this->getOwner($row["mobile_number"]);
				$rows[$key]["fname"] = $foundOwner["fname"];
				$rows[$key]["lname"] = $foundOwner["lname"];
				$rows[$key]["userid"] = $foundOwner["userid"];
				$row["userid"] = $rows[$key]["userid"];
			}	
			
			if (!$rows[$key]["fname"]&&$row["userid"]){
				$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname", "lname"))->where("userid = ?", $row["userid"]));
				if ($personal){
					$rows[$key]["fname"] = $personal["fname"];
					$rows[$key]["lname"] = $personal["lname"];
						
				}
			}
			
			$rows[$key]["date_received"] = date("F d, Y h:i:s A", strtotime($row["date_received"]));
			$rows[$key]["date_sent"] = date("F d, Y h:i:s A", strtotime($row["date_sent"]));
			
			if ($row["read"]=="0"){
				$rows[$key]["read"] = false;
			}else{
				$rows[$key]["read"] = true;
			}
			if (!$row["userid"]){
				continue;
			}
			
			
			
			$csros = $db->fetchAll($db->select()->from(array("s"=>"subcontractors"), array())
					->joinInner(array("l"=>"leads"), "l.id = s.leads_id", array())
					->joinInner(array("a"=>"admin"), "a.admin_id = l.csro_id",
						 array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS csro")))
					->where("s.userid = ?", $row["userid"])
					->where("s.status = 'ACTIVE'")
					->group("a.admin_id")
					);
			
			$csro_assigned = array();
			foreach($csros as $csro){
				$csro_assigned[] = $csro["csro"];
			}		
			$rows[$key]["csros"] = $csro_assigned;
		
			$rows[$key]["owners"] = $this->getOwners($row["mobile_number"], $row["userid"]);
			
		}		
		
		$totalPages = ceil($total/$this->rows);
		return array("success"=>true, "rows"=>$rows, "total"=>$totalPages, "records"=>intval($total));
	}
	
	private function getOwner($mobile_number){
		$db = $this->db;
		$mobile_number = addslashes($mobile_number);
		$mobile_number = str_replace("+639", "09", $mobile_number);
		$sql1 = $db->select()
						->from(array("p"=>"personal"), 
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
							))
							
							->where("p.handphone_no = SUBSTR('".$mobile_number."', 2)")
							;
		$sql2  = $db->select()
							->from(array("p"=>"personal"), 
										array("p.userid",
												new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
								))
							
							->where("p.handphone_no = '".$mobile_number."'")
							;
							
		$sql = $db->select()->union(array($sql1, $sql2));
		
		return $db->fetchRow($sql);
	}
	
	private function getOwners($mobile_number, $userid){
		$db = $this->db;
		$mobile_number = str_replace("+639", "09", $mobile_number);
		$sql1 = $db->select()
						->from(array("p"=>"personal"), 
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname"), "p.fname", "p.lname"
							))
							
							->where("REPLACE(p.handphone_no, ' ', '') LIKE '%".addslashes($mobile_number)."%'")
							->where("p.userid <> ?", $userid);
		$sql2  = $db->select()
							->from(array("p"=>"personal"), 
										array("p.userid",
												new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname"), "p.fname", "p.lname"
								))
							
							->where("REPLACE(CONCAT('0', p.handphone_no), ' ', '') LIKE '%".addslashes($mobile_number)."%'")
							->where("p.userid <> ?", $userid);
							
		$sql = $db->select()->union(array($sql1, $sql2));
		return $db->fetchAll($sql);
	}
}
