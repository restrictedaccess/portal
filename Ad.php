<?php
include './conf/zend_smarty_conf.php';
include 'category-management/ads-function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$get_job_order_id_sql = $db -> select()
                        -> from("posting")
                        -> where("id = ?", $_REQUEST['id']);
$get_job_order_id = $db -> fetchRow($get_job_order_id_sql);

header("Location:/portal/convert_ads/ads.php?job_order_id=". $get_job_order_id['job_order_id']); 
/*
if(!empty($get_job_order_id['sub_category_id']) && !is_null($get_job_order_id['sub_category_id']) && $get_job_order_id['sub_category_id'] != ""){
header("Location:/portal/convert_ads/ads.php?job_order_id=". $get_job_order_id['job_order_id']);  
exit;  
}
*/
      
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['userid']!=""){
	
	$smarty->assign('userid' , $userid);
	$smarty->assign('applicant_used' , True);
	
}else if($_SESSION['admin_id']!=""){
	
	$smarty->assign('applicant_used' , False);
	
}else if($_SESSION['agent_no']!=""){
	
	$smarty->assign('applicant_used' , False);
	
}else{
	
	$smarty->assign('applicant_used' , True);
}
$userid = $_SESSION['userid'];
$id=$_REQUEST['id'];



if(isset($_POST['apply'])){
	$apply_status = 0;
	
	if($_SESSION['userid']){
		
		
			
			//expire applications older than 3 months

			$apps = $db->fetchAll($db->select()
				->from(array("a"=>"applicants"), array("a.id"))
				->joinInner(array("p"=>"posting"), "p.id = a.posting_id", array())
				->where("a.userid = ?", $_SESSION['userid'])
				->where("p.status = 'ACTIVE'")
				->where("a.status <>'Sub-Contracted'")
				->where("a.expired = 0"));
			
			if (count($apps)>9){
				$smarty->assign('apply_msg' , 'Sorry, you cannot apply for this job ad. You currently have reached the limit of 10 job applications. If you want to be considered for this job , please contact <a href="mailto:recruitment@remotestaff.com.au">recruitment@remotestaff.com.au</a>');
				$apply_status = 1;
			}else{
				$sql= $db->select()
					->from('applicants')
					->where('posting_id =?' , $id)
					->where("expired = 0")
					->where('userid =?' , $_SESSION['userid']);
				$result = $db->fetchAll($sql);	
				if(count($result)>0){
					$smarty->assign('apply_msg' , 'YOUVE ALREADY APPLIED FOR THIS JOB');
					$apply_status = 1;
				}
			
			}
		
			
			
			if($apply_status == 0){
				$data = array(
						'posting_id' => $id, 
						'userid' => $_SESSION['userid'], 
						'status'=> 'Unprocessed', 
						'date_apply' => $ATZ
						);
				$db->insert('applicants' , $data);
				
				//autoresponder
				$sql = $db->select()
					->from(array("p"=>'posting'), array("p.jobposition"))
					->joinInner(array("l"=>"leads"), "l.id = p.lead_id", array("l.fname AS lead_firstname", "l.lname AS lead_lastname"))
					->where('p.id =?' ,$id);
				$ad = $db->fetchRow($sql);	
				$emailSmarty = new Smarty();
				$recruiter_staff = $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"), array())
																			->joinInner(array("p"=>"personal"), "p.userid = rs.userid", array("p.fname", "p.lname"))
																			->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", array("a.admin_fname", "a.admin_lname", "a.admin_email"))->where("rs.userid = ?", $_SESSION["userid"]));
				if ($recruiter_staff){
					$emailSmarty->assign("recruiter_full_name", $recruiter_staff["admin_fname"]." ".$recruiter_staff["admin_lname"]);
					$emailSmarty->assign("candidate_full_name", $recruiter_staff["fname"]." ".$recruiter_staff["lname"]);
					$emailSmarty->assign("candidate_id", $userid);
					$emailSmarty->assign("today", date("F j, Y"));
					$emailSmarty->assign("lead_fullname", $ad["lead_firstname"]." ".$ad["lead_lastname"]);
					$emailSmarty->assign("ad_name", $ad["jobposition"]);
					
					$output = $emailSmarty->fetch("applicant_assigned_applied.tpl");													
					$mail = new Zend_Mail();
					$mail->setBodyHtml($output);
					if (!TEST){
						$mail->setSubject("The applicant assigned to you applied for the position {$ad["jobposition"]}.");
					}else{
						$mail->setSubject("TEST - The applicant assigned to you applied for the position {$ad["jobposition"]}");
					}
					$mail->setFrom("noreply@remotestaff.com.au", "noreply@remotestaff.com.au");
					if (!TEST){
						$mail->addTo($recruiter_staff["admin_email"]);					
					}else{
						$mail->addTo("devs@remotestaff.com.au");
					}
		
					$mail->send($transport);
				}
													
				
					
				$smarty->assign('apply_msg' , 'THANK YOU FOR APPLYING PLEASE WAIT FOR FURTHER NOTICE FROM US!');	
				//send email to admin recruiters
			}
	}else{
			$smarty->assign('apply_msg' , "YOU NEED TO LOGIN FIRST BEFORE YOU CAN APPLY TO THIS JOB POSITION<br /><a href='index.php'>Login</a>");	
	}
		
}


if(!$id){
	die("Advertisement ID is missing!");
}

$sql = $db->select()
	->from('posting')
	->where('id =?' ,$id);
$ad = $db->fetchRow($sql);	


if($ad['category_id']){
	$sql = $db->select()
		->from(array('s' => 'job_category') , Array('category_name'))
		->join(array('c' => 'job_role_category') , 's.job_role_category_id = c.jr_cat_id' , Array('cat_name'))
		->where('category_id =?' , $ad['category_id']);
	$category_results = $db->fetchRow($sql);
	$smarty->assign('category_results' , $category_results);
}	

if($ad['date_created']){
	$det = new DateTime($ad['date_created']);
	$date_created = $det->format("F j, Y");
}	

if($ad['lead_id']){
	$sql = $db->select()
		->from('leads' , Array('fname','lname'))
		->where('id =?' , $ad['lead_id']);
	$lead = $db->fetchRow($sql);
	$smarty->assign('lead' , $lead);	
}	


$sql= $db->select()
			->from('gs_job_titles_credentials')
			->where('gs_job_titles_details_id =?' , $ad["job_order_id"]);
$job_title_details = $db->fetchAll($sql);	
						

$requirements = array();
$responsibilities = array();

foreach($job_title_details as $detail){
	if (trim($detail["description"])==""){
		continue;
	}
	
	if ($detail["box"]=="responsibility"||$detail["box"]=="tasks"){
		if ($detail["box"]=="tasks"){
			try{
				
				$item = $db->fetchOne($db->select()->from("job_position_skills_tasks", array("value"))->where("id = ?", $detail["description"]));	
				
				if (!in_array($item, $responsibilities)){
					$responsibilities[] = $item;
				}
			}catch(Exception $e){
				
			}
		}else{
			
			if (!in_array( trim($detail["description"]), $responsibilities)){
				$responsibilities[] = trim($detail["description"]);
			}
			
		}
	}else{
		if ($detail["box"]=="skills"){
			try{
				$item = $db->fetchOne($db->select()->from("job_position_skills_tasks", array("value"))->where("id = ?", $detail["description"]));					
				if (!in_array($item, $requirements)){
					$requirements[] = $item;
				}
			}catch(Exception $e){
				
			}
		}else{
			$not_to_display = array("onshore", "staff_phone", "comments", "campaign_type", "call_type", "q1", "q2", "q3", "q4", "telemarketer_hrs", "lead_generation", "writer_type", "require_graphic", "staff_provide_training", "staff_make_calls", "staff_first_time", "staff_report_directly", "increase_demand", "replacement_post", "support_current", "experiment_role", "meet_new","special_instruction");
			
			if (!in_array($detail["box"], $not_to_display)){
				if (!in_array( trim($detail["description"]), $requirements)){
					$requirements[] = trim($detail["description"]);
				}
				
			}
			
		}
	}
	
}
foreach($requirements as $requirement){
	$requirement_str .="<li>".stripslashes($requirement)."</li>";
}

foreach($responsibilities as $responsibility){
	$responsibility_str .= "<li>".stripslashes($responsibility)."</li>";
}

/*

$sql = $db->select()
	->from('posting_requirement' , 'requirement')
	->where('posting_id = ?' , $id);
$requirements = $db->fetchAll($sql);		

foreach($requirements as $requirement){
	$requirement_str .="<li>".stripslashes($requirement['requirement'])."</li>";
}


$sql = $db->select()
	->from('posting_responsibility' , 'responsibility')
	->where('posting_id = ?' , $id);
$responsibilities = $db->fetchAll($sql);	

foreach($responsibilities as $responsibility){
	$responsibility_str .= "<li>".stripslashes($responsibility['responsibility'])."</li>";
}

*/


$smarty->assign('history_changes',ShowAdsHistory($id));

$smarty->assign('requirements_count' , count($requirements));
$smarty->assign('requirements' , $requirements);				
$smarty->assign('requirement_str' , $requirement_str);				


$smarty->assign('responsibility_count' , count($responsibilities));
$smarty->assign('responsibilities' , $responsibilities);
$smarty->assign('responsibility_str' , $responsibility_str);				

$smarty->assign('id' , $id);			
$smarty->assign('date_created' , $date_created);
$smarty->assign('ad' , $ad);
$smarty->assign('heading' , stripslashes($ad['heading']));
$smarty->display('Ad.tpl');
?>
