<?php
class ResumeDetector{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	
	public function detectMatch($userid){
		$db = $this->db;
		$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));
		
		$matches = array();
		$matchIds = array();
		
		$candidatesPhone = $this->detectViaMobileNumber($personal);
		foreach($candidatesPhone as $candidate){
			if (!in_array(intval($candidate["userid"]), $matchIds)){
				$matches[] = $candidate;
				$matchIds[] = $candidate["userid"];
			}
		}
		
		$candidatesBasic = $this->detectViaBasicInfo($personal);
		foreach($candidatesBasic as $candidate){
			if (!in_array(intval($candidate["userid"]), $matchIds)){
				$matches[] = $candidate;
				$matchIds[] = $candidate["userid"];
			}
		}
		
		
		$candidatesName = $this->detectViaName($personal);
		foreach($candidatesName as $candidate){
			if (!in_array(intval($candidate["userid"]), $matchIds)){
				$matches[] = $candidate;
				$matchIds[] = $candidate["userid"];
			}
		}
		$candidatesName2 = $this->detectViaName2($personal);	
		foreach($candidatesName2 as $candidate){
			if (!in_array(intval($candidate["userid"]), $matchIds)){
				$matches[] = $candidate;
				$matchIds[] = $candidate["userid"];
			}
		}
		//$candidatesReference = $this->detectViaCharacterReference($personal);	
		$candidatesReference = array();
		foreach($candidatesReference as $candidate){
			if (!in_array(intval($candidate["userid"]), $matchIds)){
				$matches[] = $candidate;
				$matchIds[] = $candidate["userid"];
			}
		}
		
		
		return $matches;
	}
	
	private function detectViaMobileNumber($personal){
		$db = $this->db;
		$candidates = array();
		if ($personal["handphone_no"]){
			$sql1 = $db->select()
						->from(array("p"=>"personal"), 
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
							))
						
						->where("p.handphone_no LIKE '".addslashes($personal["handphone_no"])."'")
						->where("p.userid <> ?", $personal["userid"])
						->where("length(p.fname) >= 2")
						->where("length(p.lname) >= 2")
						->limit(10)
							;
			$candidates = $db->fetchAll($sql1);	
			
		}
		return $candidates;
	}
	
	private function detectViaBasicInfo($personal){
		$db = $this->db;
		
		if ($personal["byear"]&&$personal["bmonth"]&&$personal["bday"]&&$personal["userid"]&&$personal["fname"]&&$personal["lname"]){
			$sql1 = $db->select()
						->from(array("p"=>"personal"),
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
							))
							->where("p.fname LIKE '%".addslashes($personal["fname"])."%'")
							->where("p.lname LIKE '%".addslashes($personal["lname"])."%'")
							->where("p.byear = ?", $personal["byear"])
							->where("p.bmonth = ?", $personal["bmonth"])
							->where("p.bday = ?", $personal["bday"])
							->where("p.userid <> ?", $personal["userid"])
							->where("length(p.fname) >= 2")
							->where("length(p.lname) >= 2")
							->limit(10)
							;
			$candidates = $db->fetchAll($sql1);		
			return $candidates;
								
		}else{
			return array();
		}
		
		
						
	}
	
	private function detectViaName($personal){
		$db = $this->db;
		if ($personal["byear"]&&$personal["bmonth"]&&$personal["bday"]&&$personal["userid"]&&$personal["fname"]&&$personal["lname"]){
		
			$sql1 = $db->select()
					->from(array("p"=>"personal"),
								array("p.userid",
										new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
						))
						->where("INSTR(p.fname, ?) > 0", $personal["fname"])
						->where("INSTR(p.lname, ?) > 0", $personal["lname"])
						->where("p.userid <> ?", $personal["userid"])
						->where("length(p.fname) >= 2")
						->where("length(p.lname) >= 2")
						->limit(10)
							;
			if ($personal["bday"]){
				$sql1->where("p.bday = ?", $personal["bday"]);
			}
			if ($personal["bmonth"]){
				$sql1->where("p.bmonth = ?", $personal["bmonth"]);
			}
			if ($personal["byear"]){
				$sql1->where("p.byear = ?", $personal["byear"]);
			}				
			
			$candidates = $db->fetchAll($sql1);		
			return $candidates;
						
		}else{
			return array();
		}
	}
	
	private function detectViaName2($personal){
		$db = $this->db;
		if (strlen($personal["fname"])>=2&&strlen($personal["lname"])>=2){
			$sql1 = $db->select()
						->from(array("p"=>"personal"),
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
							))
							->where("INSTR(?, p.fname) > 0", trim($personal["fname"]))
							->where("INSTR(?, p.lname) > 0", trim($personal["lname"]))
							->where("p.userid <> ?", $personal["userid"])
							->where("length(p.fname) >= 2")
							->where("length(p.lname) >= 2")
							
							->where("p.fname <> ''")
							->limit(10)
							;
							
			if ($personal["bday"]){
				$sql1->where("p.bday = ?", $personal["bday"]);
			}
			if ($personal["bmonth"]){
				$sql1->where("p.bmonth = ?", $personal["bmonth"]);
			}
			if ($personal["byear"]){
				$sql1->where("p.byear = ?", $personal["byear"]);
			}
			
			$candidates = $db->fetchAll($sql1);					
		}else{
			return array();
		}

		return $candidates;
	}
	
	private function detectViaCharacterReference($personal){
		$db = $this->db;
		$character_references = $db->fetchAll($db->select()->from(array("ch"=>"character_references"))->where("ch.userid = ?", $personal["userid"])->where("email_address <> ''")->where("email_address IS NOT NULL"));
		
		
		$userids = array();
		foreach($character_references as $character_reference){
			if (!$character_reference["email_address"]){
				continue;
			}
			
			if (trim($character_reference["email_address"])==""){
				continue;
			}
			if (trim($character_reference["email_address"])=="none@yahoo.com"){
				continue;
			}
			$other_character_references = $db->fetchAll($db->select()->from(array("cho"=>"character_references"))->where("userid <> ?", $personal["userid"])->where("email_address = ?", $character_reference["email_address"]));
			foreach($other_character_references as $other_character_reference){
				if (!$other_character_reference["email_address"]){
					continue;
				}
				if (!in_array($other_character_reference["userid"], $userids)){
					$userids[] = $other_character_reference["userid"];
				}
			}
		}
		
		if (!empty($userids)){
			$sql1 = $db->select()
						->from(array("p"=>"personal"),
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
							))
							->where("p.userid IN (".implode(",", $userids).")");
			$candidates = $db->fetchAll($sql1);	
			return $candidates;			
		}else{
			return array();
		}
	
	}
}
