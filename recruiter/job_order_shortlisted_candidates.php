<?php
include_once '../conf/zend_smarty_conf.php';
$url = "";
if ($_REQUEST["view"]){
	$view=true;
}else{
	$view=false;
}
if (TEST){
	$url = "http://test.remotestaff.com.au/portal/recruiter/load_job_postings.php?filter_type=0&service_type=0&order_status=0&display=Displayed&rows=1&page=1";
}else{
	$url = "http://remotestaff.com.au/portal/recruiter/load_job_postings.php?filter_type=0&service_type=0&order_status=0&display=Displayed&rows=1&page=1";
}
if ($_REQUEST["keyword"]){
	$url.="&keyword=".$_REQUEST["keyword"];
	$result = json_decode(file_get_contents($url));
	$posting_id = $result->rows[0]->posting_id;
}else if ($_REQUEST["posting_id"]){
	$posting_id = $_REQUEST["posting_id"];
}else{
	if (!$view){
		echo json_encode(array("success"=>false, "shortlisted_candidates"=>array()));
		die;		
	}

}
if ($posting_id){
	$sql = $db->select()
			   ->from(array("sh"=>"tb_shortlist_history"),
			   		array("sh.userid AS userid", "DATE(sh.date_listed) AS date"))
			   ->joinInner(array("pers"=>"personal"),
			   		  "pers.userid = sh.userid",
			   		  array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
			     ->where("sh.position = ?", $posting_id)
			     ->where("sh.status = 'ACTIVE'")
			     ->order("sh.date_listed DESC")
			     ->group("sh.id")
			     ->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = sh.userid", array())
				 ->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", array("a.admin_fname", "a.admin_lname"));	
				 
	if ($_REQUEST["recruiter"]){
	
		$sql->where("rs.admin_id = ?", $_REQUEST["recruiter"]);
		
	}
	
	if ($_REQUEST["date_from"]&&$_REQUEST["date_to"]){
		$sql->where("DATE(sh.date_listed) >= DATE(?)", $_REQUEST["date_from"])->where("DATE(sh.date_listed) <= DATE(?)",$_REQUEST["date_to"]);
	}
	
	$shortlisted_candidates = $db->fetchAll($sql);
	if (!$view){
		echo json_encode(array("success"=>true, "shortlisted_candidates"=>$shortlisted_candidates));	
	}else{
		$smarty = new Smarty;
		$smarty->assign("shortlisted_candidates", $shortlisted_candidates);
		$ads = $db->fetchRow($db->select()->from("posting")->where("id = ?", $posting_id));	
		if ($ads){
			$smarty->assign("jobposition", $ads["jobposition"]);
		}
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' 
		OR admin_id='41'
		OR admin_id='67'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')  
		AND status <> 'REMOVED'  AND status <> 'REMOVED'  AND admin_id <> 161   ORDER by admin_fname";
		$recruiters = $db->fetchAll($select); 
		$recruiter_options = "<option value=''>Please Select</option>";
		foreach($recruiters as $recruiter){
			$fullname = $recruiter['admin_fname']." ".$recruiter['admin_lname'];
			$recruiter_options.="<option value='{$recruiter['admin_id']}'>{$fullname}</option>";
		}
		$smarty->assign("posting_id", $posting_id);
		$smarty->assign("recruiter_options", $recruiter_options);
		$smarty->display("shortlisted_candidate_job_order.tpl");	
	}
}else{
	if (!$view){
		echo json_encode(array("success"=>false, "shortlisted_candidates"=>array()));	
	}
}
