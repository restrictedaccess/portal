<?php
include('../conf/zend_smarty_conf.php') ;
if ($_GET["mobile_number"]){
	$sql1 = $db->select()
						->from(array("p"=>"personal"), 
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
							))
						->joinInner(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())
						->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", 
									array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS recruiter_fullname"), "a.admin_id AS recruiter_id" ))
						
						->where("REPLACE(p.handphone_no, ' ', '') LIKE '%".addslashes($_GET["mobile_number"])."%'");
	$sql2  = $db->select()
						->from(array("p"=>"personal"), 
									array("p.userid",
											new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS candidate_fullname")
							))
						->joinInner(array("rs"=>"recruiter_staff"), "rs.userid = p.userid", array())
						->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", 
									array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS recruiter_fullname"), "a.admin_id AS recruiter_id" ))
						
						->where("REPLACE(CONCAT('0', p.handphone_no), ' ', '') LIKE '%".addslashes($_GET["mobile_number"])."%'");
						
	$sql = $db->select()->union(array($sql1, $sql2));
	
	$personal = $db->fetchAll($sql);
	if ($personal&&!empty($personal)){
		if (count($personal)>1){
			foreach($personal as $key=>$candidate){
				//load all assigned csro's
				$csros = $db->fetchAll($db->select()->from(array("s"=>"subcontractors"), array())
						->joinInner(array("l"=>"leads"), "l.id = s.leads_id", array())
						->joinInner(array("a"=>"admin"), "a.admin_id = l.csro_id",
							 array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS csro")))
						->where("s.userid = ?", $candidate["userid"])
						->where("s.status = 'ACTIVE'")
						->group("a.admin_id")
						);
				
				$csro_assigned = array();
				foreach($csros as $csro){
					$csro_assigned[] = $csro["csro"];
				}		
						
				$personal[$key]["csros"] = $csro_assigned;
			}
			echo json_encode(array("success"=>true, "candidates"=>$personal));	
		}else{
			$candidate = $personal[0];	
			//load all assigned csro's
			$csros = $db->fetchAll($db->select()->from(array("s"=>"subcontractors"), array())
					->joinInner(array("l"=>"leads"), "l.id = s.leads_id", array())
					->joinInner(array("a"=>"admin"), "a.admin_id = l.csro_id",
						 array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS csro")))
					->where("s.userid = ?", $candidate["userid"])
					->where("s.status = 'ACTIVE'")
					->group("a.admin_id")
					);
			
			$csro_assigned = array();
			foreach($csros as $csro){
				$csro_assigned[] = $csro["csro"];
			}		
			$candidate["csros"] = $csro_assigned;
			echo json_encode(array("success"=>true, "candidate"=>$candidate, "candidates"=>array($candidate)));
		}
		
	}else{
		echo json_encode(array("success"=>false, "error"=>"No Candidate Found"));
	}
	
}else{
	echo json_encode(array("success"=>false, "error"=>"Invalid Request"));
	
}
