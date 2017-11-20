<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include_once('../lib/staff_files_manager.php') ;

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

function getAdminStaff($admin_id,$from,$to){

	global $db;
	$userids = array();
	
	//get unprocessed users
	$sql = "select distinct us.userid
		from unprocessed_staff as us
		left join recruiter_staff as rs on us.userid=rs.userid
		where date(rs.date) >= '".$from."'
		and date(rs.date) <= '".$to."'
		and rs.admin_id = ".$admin_id;
	$unprocessed_staffs = $db->fetchAll($sql);
	
	//$userids = $unprocessed_staffs;
	foreach($unprocessed_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get prescreened users
	$sql = "select distinct pss.userid
		from pre_screened_staff as pss
		left join recruiter_staff as rs on pss.userid=rs.userid
		where date(pss.date) >= '".$from."'
		and date(pss.date) <= '".$to."'
		and rs.admin_id = ".$admin_id;
	$prescreened_staffs = $db->fetchAll($sql);
	
	foreach($prescreened_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get inactive users
	$sql = "select distinct ins.userid
		from inactive_staff as ins
		left join recruiter_staff as rs on ins.userid=rs.userid
		where date(ins.date) >= '".$from."'
		and date(ins.date) <= '".$to."'
		and rs.admin_id = ".$admin_id;
	$inactive_staffs = $db->fetchAll($sql);
	
	foreach($inactive_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get onasl users
	$sql = "SELECT distinct jsca.userid
		from job_sub_category_applicants as jsca
		left join recruiter_staff as rs on rs.userid=jsca.userid
		where date(jsca.sub_category_applicants_date_created) >= '".$from."'
		and date(jsca.sub_category_applicants_date_created) <= '".$to."'
		and rs.admin_id =".$admin_id;
	$onasl_staffs = $db->fetchAll($sql);
	
	foreach($onasl_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get shortlisted users
	$select = "select distinct tsh.userid
		from tb_shortlist_history as tsh
		left join recruiter_staff as rs on rs.userid=tsh.userid
		where tsh.date_listed >= '".$from."'
		and tsh.date_listed <= '".$to."'
		and rs.admin_id = ".$admin_id;
	$shortlisted_staffs = $db->fetchAll($select);
	
	foreach($shortlisted_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get endorsed users
	$select = "select distinct teh.userid
		from tb_endorsement_history as teh
		left join recruiter_staff as rs on rs.userid=teh.userid
		where date(teh.date_endoesed) >= '".$from."'
		and date(teh.date_endoesed) <= '".$to."'
		and rs.admin_id = ".$admin_id;
	$endorsed_staffs = $db->fetchAll($select);
	
	foreach($endorsed_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get custom booked users
	$select = "SELECT rs.userid, r.date_interview as date_created, r.leads_id, r.status, r.time 
		FROM tb_request_for_interview r
		left join recruiter_staff as rs on rs.userid=r.applicant_id
		where ((r.date_added)) >= '".$from."'
		and date((r.date_added)) <= '".$to."'
		AND rs.userid = r.applicant_id AND service_type='CUSTOM'
		and rs.admin_id = ".$admin_id;
	$cbooked_staffs = $db->fetchAll($select);
	
	foreach($cbooked_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get asl booked users
	$select = "SELECT rs.userid, r.date_interview as date_created, r.leads_id, r.status, r.time 
		FROM tb_request_for_interview r
		left join recruiter_staff as rs on rs.userid=r.applicant_id
		where ((r.date_added)) >= '".$from."'
		and date((r.date_added)) <= '".$to."'
		AND rs.userid = r.applicant_id AND service_type='ASL'
		and rs.admin_id = ".$admin_id;
	$abooked_staffs = $db->fetchAll($select);
	
	foreach($abooked_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get hired asl
	$select = "SELECT rs.userid, s.starting_date as date_created FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
		where ((s.starting_date)) >= '".$from."'
		and date((s.starting_date)) <= '".$to."'
		AND r.applicant_id = s.userid 
		AND rs.userid = s.userid AND s.status='ACTIVE' 
		AND r.service_type='ASL'
		and rs.admin_id = ".$admin_id;
	$ahired_staffs = $db->fetchAll($select); 
	
	foreach($ahired_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get hired asl
	$select = "SELECT rs.userid, s.starting_date as date_created FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
		where ((s.starting_date)) >= '".$from."'
		and date((s.starting_date)) <= '".$to."'
		AND r.applicant_id = s.userid AND rs.userid = s.userid AND s.status='ACTIVE' AND r.service_type='CUSTOM'
		and rs.admin_id = ".$admin_id;
	$chired_staffs = $db->fetchAll($select); 
	
	foreach($chired_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get no show custom
	$select = "SELECT rs.userid, ns.date as date_created FROM recruiter_staff rs, staff_no_show ns
		where ((ns.date)) >= '".$from."'
		and date((ns.date)) <= '".$to."'
		 AND ns.userid = rs.userid AND service_type='CUSTOM'
		and rs.admin_id = ".$admin_id;
	$chired_staffs = $db->fetchAll($select); 
	
	foreach($chired_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//get no show first day
	$select = "SELECT rs.userid, ns.date as date_created FROM recruiter_staff rs, staff_no_show ns
		where ((ns.date)) >= '".$from."'
		and date((ns.date)) <= '".$to."'
		AND ns.userid = rs.userid AND service_type='FIRST DAY'
		and rs.admin_id = ".$admin_id;
	$chired_staffs = $db->fetchAll($select); 
	
	foreach($chired_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//cancel resigned
	$select = "SELECT rs.userid, s.date_terminated as date_created FROM recruiter_staff rs, subcontractors s
		where ((s.date_contracted)) >= '".$from."'
		and date((s.date_contracted)) <= '".$to."'
		AND rs.userid = s.userid AND s.status='resigned'
		and rs.admin_id = ".$admin_id;
	$chired_staffs = $db->fetchAll($select); 
	
	foreach($chired_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//cancel terminated
	$select = "SELECT rs.userid, s.date_terminated as date_created FROM recruiter_staff rs, subcontractors s
		where ((s.date_contracted)) >= '".$from."'
		and date((s.date_contracted)) <= '".$to."'
		AND rs.userid = s.userid AND s.status='replacement'
		and rs.admin_id = ".$admin_id;
	$chired_staffs = $db->fetchAll($select); 
	
	foreach($chired_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	
	//cancel replacement
	$select = "SELECT rs.userid, s.date_terminated as date_created FROM recruiter_staff rs, subcontractors s
		where ((s.date_contracted)) >= '".$from."'
		and date((s.date_contracted)) <= '".$to."'
		AND rs.userid = s.userid AND s.status='replacement'
		and rs.admin_id = ".$admin_id;
	$chired_staffs = $db->fetchAll($select); 
	
	foreach($chired_staffs as $staff){
		if((!in_array($staff['userid'],$userids))&&($staff['userid']!='')){
			$userids[] = $staff['userid'];
		}
	}
	

	
	//print_r($userids);
	return $userids;
 
}

//START: validate user session
if(!$_SESSION['admin_id'])
{
	exit;
}
if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL")
{ 
	exit;
}
//ENDED: validate user session


//START: get posts
$recruiter_id = $_REQUEST["recruiter_id"];
$field = $_REQUEST["field"];
$search_date1 = $_REQUEST["search_date1"];
$search_date2 = $_REQUEST["search_date2"];
//ENDED: get posts


//START: filter date
if($_REQUEST["search_date1"] <> "" && $_REQUEST["search_date2"] <> "")
{
	$total_number_of_candidates_date = " AND (DATE(rs.date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_unprocessed_date = " AND (DATE(u.date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_pre_screened_date = " AND (DATE(u.date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_shortlisted_date = " AND (DATE(u.date_listed) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_inactive_staff_date = " AND (DATE(u.date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_endorsed_date = " AND (DATE(e.date_endoesed) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_on_of_asl_date = " AND (DATE(a.sub_category_applicants_date_created) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_custom_booking_date = " AND (DATE(r.date_added) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_asl_booking_date = " AND (DATE(r.date_added) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
			
	$total_number_of_hired_trial_staff_date = "";
	$total_number_of_hired_asl_staff_date = " AND (DATE(s.starting_date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_hired_custom_staff_date = " AND (DATE(s.starting_date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
			
	$total_number_of_no_show_date = " AND (DATE(ns.date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_cancel_date = " AND (DATE(s.date_contracted) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
}
//ENDED: filter date


//START: get recruiter's name
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?', $recruiter_id);
$a = $db->fetchRow($sql);
$recruiter = $a['admin_fname']." ".$a['admin_lname'];
//ENDED: get recruiter's name


//START: generate content list
switch($field)
{
	case "TNC":
		$tnc_userids = getAdminStaff($recruiter_id,$_REQUEST["search_date1"],$_REQUEST["search_date2"]);
		$userid_list = implode(',',$tnc_userids);
		if($userid_list != ''){
			$sql = "SELECT rs.userid, rs.date as date_created FROM recruiter_staff rs 
			where rs.userid in (".$userid_list.")";
			$result = $db->fetchAll($sql);
		}
		else{
			$result = array();
		}
		$field = "Total Number of Candidates";
		$date_caption = "Date Recruitted";
		break;
	case "unprocessed":
		$sql = "select rs.admin_id, us.userid, p.datecreated as date_created
			from unprocessed_staff as us
			left join recruiter_staff as rs on us.userid=rs.userid
			left join personal as p on us.userid=p.userid
			where date(rs.date) >= '".$_REQUEST["search_date1"]."'
			and date(rs.date) <= '".$_REQUEST["search_date2"]."'
			and rs.admin_id = ".$recruiter_id."
			and us.userid not in ( select userid from pre_screened_staff)
			and us.userid not in ( select userid from inactive_staff)
			and us.userid not in ( select userid from job_sub_category_applicants)
			and us.userid not in ( select userid from tb_shortlist_history)
			and us.userid not in ( select userid from tb_endorsement_history)";
		$result = $db->fetchAll($sql);	
		$field = "Unprocessed";
		$date_caption = "Date Unprocessed";
		break;
	case "pre_screened":
		$sql = "select rs.admin_id, pss.userid, pss.date as date_created
			from pre_screened_staff as pss
			left join recruiter_staff as rs on pss.userid=rs.userid
			where date(pss.date) >= '".$_REQUEST["search_date1"]."'
			and date(pss.date) <= '".$_REQUEST["search_date2"]."'
			and rs.admin_id = ".$recruiter_id."
			and pss.userid not in ( select userid from inactive_staff)
			and pss.userid not in ( select userid from job_sub_category_applicants)
			and pss.userid not in ( select userid from tb_shortlist_history)
			and pss.userid not in ( select userid from tb_endorsement_history)";
		$result = $db->fetchAll($sql);		
		$field = "Pre-screened";		
		$date_caption = "Date Pre-screened";
		break;
	case "shortlisted":
		$sql = "select tsh.userid, tsh.position, tsh.date_listed as date_created,p.jobposition, l.fname AS lead_fname, l.lname AS lead_lname 
			from tb_shortlist_history as tsh
			left join recruiter_staff as rs on rs.userid=tsh.userid
			left join posting as p on tsh.position=p.id
			left join leads as l on l.id = p.lead_id 
			where tsh.date_listed >= '".$_REQUEST["search_date1"]."'
			and tsh.date_listed <= '".$_REQUEST["search_date2"]."'
			and rs.admin_id = ".$recruiter_id;
		$result = $db->fetchAll($sql);		
		$field = "Shortlisted";	
		$date_caption = "Date Shortlisted";
		break;
	case "inactive_staff":
		$sql = "select rs.admin_id, ins.userid, ins.date as date_created
			from inactive_staff as ins
			left join recruiter_staff as rs on ins.userid=rs.userid
			where date(ins.date) >= '".$_REQUEST["search_date1"]."'
			and date(ins.date) <= '".$_REQUEST["search_date2"]."'
			and rs.admin_id = ".$recruiter_id;
		$result = $db->fetchAll($sql);		
		$field = "Inactive";
		$date_caption = "Inactive Date";
		break;
	case "endorsed":
		/*$sql = "SELECT rs.userid, e.date_endoesed as date_created, e.client_name FROM recruiter_staff rs, tb_endorsement_history e
		WHERE rs.admin_id = '".$recruiter_id."' AND rs.userid = e.userid".$total_number_of_endorsed_date." GROUP BY e.userid, e.client_name";*/
		$sql = "select distinct teh.userid, teh.date_endoesed as date_created, teh.rejected AS rejected 
			from tb_endorsement_history as teh
			left join recruiter_staff as rs on rs.userid=teh.userid
			where date(teh.date_endoesed) >= '".$_REQUEST["search_date1"]."'
			and date(teh.date_endoesed) <= '".$_REQUEST["search_date2"]."'
			and rs.admin_id = ".$recruiter_id;
		$result = $db->fetchAll($sql);		
		$field = "Endorsed";
		$date_caption = "Date Endorsed";
		break;
	case "asl":
		$sql = "select jsca.userid, jsca.sub_category_applicants_date_created as date_created
			from job_sub_category_applicants as jsca
			left join recruiter_staff as rs on rs.userid=jsca.userid
			where date(jsca.sub_category_applicants_date_created) >= '".$_REQUEST["search_date1"]."'
			and date(jsca.sub_category_applicants_date_created) <= '".$_REQUEST["search_date2"]."'
			and admin_id = ".$recruiter_id;
		$result = $db->fetchAll($sql);		 
		$field = "ASL";	
		$date_caption = "Date Added on ASL";
		break;
	case "custom_booking":
		$sql = "SELECT rs.userid, r.date_interview as date_created, r.leads_id, r.status, r.time FROM recruiter_staff rs, tb_request_for_interview r
		WHERE rs.admin_id = '".$recruiter_id."' AND rs.userid = r.applicant_id AND service_type='CUSTOM'".$total_number_of_custom_booking_date;
		$result = $db->fetchAll($sql);		
		$field = "Custom Booking";		
		$date_caption = "Interview Schedule";
		break;
	case "asl_booking":
		$sql = "SELECT rs.userid, r.date_interview as date_created, r.leads_id, r.status, r.time FROM recruiter_staff rs, tb_request_for_interview r
		WHERE rs.admin_id = '".$recruiter_id."' AND rs.userid = r.applicant_id AND service_type='ASL'".$total_number_of_asl_booking_date;
		$result = $db->fetchAll($sql);		
		$field = "ASL Booking";		
		$date_caption = "Interview Schedule";
		break;
	case "trial_staff":
		break;
	case "hired_asl_staff":
		$sql = "SELECT rs.userid, s.starting_date as date_created FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
		WHERE rs.admin_id = '".$recruiter_id."' AND r.applicant_id = s.userid AND rs.userid = s.userid AND s.status='ACTIVE' AND r.service_type='ASL'".$total_number_of_hired_asl_staff_date;
		$result = $db->fetchAll($sql);		
		$field = "ASL Hired Staff";	
		$date_caption = "Date Hired";
		break;
	case "hired_custom_staff":
		$sql = "SELECT rs.userid, s.starting_date as date_created FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
		WHERE rs.admin_id = '".$recruiter_id."' AND r.applicant_id = s.userid AND rs.userid = s.userid AND s.status='ACTIVE' AND r.service_type='CUSTOM'".$total_number_of_hired_custom_staff_date;
		$result = $db->fetchAll($sql);		
		$field = "Custom Hired Staff";
		$date_caption = "Date Hired";
		break;
		
	case "now_show_initial":
		$sql = "SELECT rs.userid, ns.date as date_created FROM recruiter_staff rs, staff_no_show ns
		WHERE rs.admin_id = '".$recruiter_id."' AND ns.userid = rs.userid AND service_type='INITIAL'".$total_number_of_no_show_date;
		$result = $db->fetchAll($sql);		
		$field = "Initial Type of No-Show";
		$date_caption = "Date No-Show";
		break;
	case "now_show_asl":
		$sql = "SELECT rs.userid, ns.date as date_created FROM recruiter_staff rs, staff_no_show ns
		WHERE rs.admin_id = '".$recruiter_id."' AND ns.userid = rs.userid AND service_type='ASL'".$total_number_of_no_show_date;
		$result = $db->fetchAll($sql);	
		$field = "ASL Type of No-Show";
		$date_caption = "Date No-Show";
		break;
	case "now_show_custom":
		$sql = "SELECT rs.userid, ns.date as date_created FROM recruiter_staff rs, staff_no_show ns
		WHERE rs.admin_id = '".$recruiter_id."' AND ns.userid = rs.userid AND service_type='CUSTOM'".$total_number_of_no_show_date;
		$result = $db->fetchAll($sql);		
		$field = "Custom Type of No-Show";	
		$date_caption = "Date No-Show";
		break;	
	case "now_show_first_day":
		$sql = "SELECT rs.userid, ns.date as date_created FROM recruiter_staff rs, staff_no_show ns
		WHERE rs.admin_id = '".$recruiter_id."' AND ns.userid = rs.userid AND service_type='FIRST DAY'".$total_number_of_no_show_date;
		$result = $db->fetchAll($sql);	
		$field = "First Day Type of No-Show";	
		$date_caption = "Date No-Show";
		break;		
		
	case "cancel_resigned":
		$sql = "SELECT rs.userid, s.date_terminated as date_created FROM recruiter_staff rs, subcontractors s
		WHERE rs.admin_id = '".$recruiter_id."' AND rs.userid = s.userid AND s.status='resigned'".$total_number_of_cancel_date;
		$result = $db->fetchAll($sql);		
		$field = "Resigned";
		$date_caption = "Date Resigned";
		break;
	case "cancel_terminated":
		$sql = "SELECT rs.userid, s.date_terminated as date_created FROM recruiter_staff rs, subcontractors s
		WHERE rs.admin_id = '".$recruiter_id."' AND rs.userid = s.userid AND s.status='terminated'".$total_number_of_cancel_date;
		$result = $db->fetchAll($sql);		
		$field = "Terminated";		
		$date_caption = "Date Terminated";
		break;
	case "cancel_replacement":
		$sql = "SELECT rs.userid, s.date_terminated as date_created FROM recruiter_staff rs, subcontractors s
		WHERE rs.admin_id = '".$recruiter_id."' AND rs.userid = s.userid AND s.status='replacement'".$total_number_of_cancel_date;
		$result = $db->fetchAll($sql);	
		$field = "Replacement";
		$date_caption = "Date Replaced";
		break;		
}

$counter = 0;
$u = array();
foreach($result as $rows)
{
			
		
	
	$pos = strpos($u, $rows['userid']);
	//if ($pos === false || $_REQUEST["field"] == "endorsed")
	if (!in_array($rows["userid"], $u))
	{
			$u[] = $rows["userid"];
			$counter++;
			$status = $rows['status_result'];
			$date = $rows['date_created'];
			if($date <> "" && $date <> "0000-00-00" && $date <> "0000-00-00 00:00:00") 
			{ 
				//$date = new Zend_Date($date, 'YYYY-MM-dd HH:mm:ss');	
				$date = date('F j, Y',strtotime($date));
			}
			
			
			//start: get candidate's name
			$sql=$db->select()
				->from('personal')
				->where('userid = ?', $rows['userid']);
			$a = $db->fetchRow($sql);
			$name = $a['fname']." ".$a['lname'];
			$email = $a['email'];
			//ended: get candidate's name	
		
			//start: get client's name
			if($_REQUEST["field"] == "endorsed")
			{
				$client_full_name = "";
				$sql = "SELECT e.date_endoesed as date_created, e.client_name, e.rejected FROM recruiter_staff rs, tb_endorsement_history e
				WHERE e.userid = '".$rows['userid']."' AND rs.admin_id = '".$recruiter_id."' 
				AND date(e.date_endoesed) >= '".$_REQUEST["search_date1"]."'
				AND date(e.date_endoesed) <= '".$_REQUEST["search_date2"]."'
				AND rs.userid = e.userid".$total_number_of_endorsed_date." 
				GROUP BY e.userid, e.client_name";
				$result = $db->fetchAll($sql);		
				$date = "";
				foreach($result as $end_rows)
				{
					$sql=$db->select()
						->from('leads')
						->where('id = ?', $end_rows['client_name']);
					$lead_result = $db->fetchRow($sql);
					
					if ($end_rows["rejected"]==1){
						$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a> <span style='color:#ff0000'>[rejected]</span><br />";
					}else{
						$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a><br />";
					}
					$date_counter = $end_rows['date_created'];
					if($date_counter <> "" && $date_counter <> "0000-00-00" && $date_counter <> "0000-00-00 00:00:00") 
					{ 
						$date .= "> ".date('F j, Y',strtotime($date_counter))."<br />";
					}
					else
					{
						$date .= "> ".$date_counter."<br />";
					}
				}
			}else if ($_REQUEST["field"]=="shortlisted"){
				$client_full_name = "";
				$date ="";
				$job_ads = "";
				$sql = $db->select()->from(array("sh"=>"tb_shortlist_history"), array("sh.date_listed", "sh.position"))
					->joinLeft(array("p"=>"posting"), "sh.position=p.id", array("p.jobposition"))
					->joinInner(array("l"=>"leads"), "p.lead_id = l.id", 
						array("l.id AS leads_id", "l.fname AS lead_fname", "l.lname AS lead_lname"))
					->where("sh.userid = ?", $rows["userid"])
					->where("DATE(sh.date_listed) >= DATE(?)", $_REQUEST["search_date1"])
					->where("DATE(sh.date_listed) <= DATE(?)", $_REQUEST["search_date2"])
					;
					
				$result = $db->fetchAll($sql);
				foreach($result as $end_rows)
				{
					$client_full_name .= "&gt; <a href='javascript:lead(".$end_rows["leads_id"].")'>".$end_rows["lead_fname"]." ".$end_rows["lead_lname"]."</a><br/>";
					$date .= "&gt; ".date("F j, Y", strtotime($end_rows["date_listed"]))."<br/>";
					$job_ads .= "&gt; <a href='javascript:ads(".$end_rows["position"].")'>".$end_rows["jobposition"]."</a><br/>";
				}
			}elseif($_REQUEST["field"] == "asl")
			{	
				$date = "";
				$client_full_name = "";
				$sql = "select jsca.sub_category_id, jsca.sub_category_applicants_date_created as date_created
					from job_sub_category_applicants as jsca
					left join recruiter_staff as rs on rs.userid=jsca.userid
					where date(jsca.sub_category_applicants_date_created) >= '".$_REQUEST["search_date1"]."'
					and date(jsca.sub_category_applicants_date_created) <= '".$_REQUEST["search_date2"]."'
					and admin_id = ".$recruiter_id."
					and jsca.userid = ".$rows['userid'];
				$result = $db->fetchAll($sql);	
				foreach($result as $h_rows)
				{
					$sql=$db->select()
						->from('job_sub_category')
						->where('sub_category_id = ?', $h_rows['sub_category_id']);
					$lead_result = $db->fetchRow($sql);
					$client_full_name .= "> ".$lead_result['sub_category_name']."<br />";
					$date_counter = $h_rows['date_created'];
					if($date_counter <> "" && $date_counter <> "0000-00-00" && $date_counter <> "0000-00-00 00:00:00") 
					{ 
						$date .= "> ".date('F j, Y',strtotime($date_counter))."<br />";
					}
					else
					{
						$date .= "> ".$date_counter."<br />";
					}					
				}			
			}
			elseif($_REQUEST["field"] == "asl_booking")
			{	
				$date = "";
				$client_full_name = "";
				
				$sql = $db->select()
							->from(array("rs"=>"recruiter_staff"), array("rs.userid"))
							->joinInner(array("r"=>"tb_request_for_interview"), 
										"r.applicant_id = rs.userid",
										 array("r.date_interview AS date_created", "r.leads_id", "r.status", "r.time"))
							->where("rs.userid = ?", $rows["userid"])
							->where("rs.admin_id = ?", $recruiter_id)
							->where("r.service_type = 'ASL'");
				$sql = $sql->__toString();		
				
				$sql.=$total_number_of_custom_booking_date;
				$result = $db->fetchAll($sql);	
				foreach($result as $h_rows)
				{
					$sql=$db->select()
						->from('leads')
						->where('id = ?', $h_rows['leads_id']);
					$lead_result = $db->fetchRow($sql);
					switch ($h_rows['status']) 
					{
						case "ACTIVE":
							$stat = "New";
							break;
						case "ARCHIVED":
							$stat = "Archived";
							break;
						case "ON-HOLD":
							$stat = "On Hold";
							break;															
						case "HIRED":
							$stat = "Hired";
							break;															
						case "REJECTED":
							$stat = "Rejected";
							break;		
						case "CONFIRMED":
							$stat = "Confirmed/In Process";	
							break;		
						case "YET TO CONFIRM":
							$stat = "Client contacted, no confirmed date";
							break;		
						case "DONE":
							$stat = "Interviewed; waiting for feedback";
							break;
						case "RE-SCHEDULED":
							$stat = "Confirmed/Re-Booked";
							break;	
						case "CANCELLED":
							$stat = "Cancelled";
							break;	
					}						
					if ($stat!=""){
						$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a>(".$stat.")<br />";	
					}else{
						$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a><br/>";					
					}
					
					$date_counter = $h_rows['date_created'];
					if($date_counter <> "" && $date_counter <> "0000-00-00" && $date_counter <> "0000-00-00 00:00:00") 
					{ 
						$date .= "> ".date('F j, Y',strtotime($date_counter))."<br />";
					}
					else
					{
						$date .= "> ".$date_counter."<br />";
					}		
					$stat = "";			
				}			
			}
			elseif($_REQUEST["field"] == "custom_booking")
			{	
				$date = "";
				$client_full_name = "";
				$sql = "SELECT rs.userid, r.date_interview as date_created, r.leads_id, r.status, r.time FROM recruiter_staff rs, tb_request_for_interview r
				WHERE rs.userid = '".$rows['userid']."' AND rs.admin_id = '".$recruiter_id."' AND rs.userid = r.applicant_id AND service_type='CUSTOM'".$total_number_of_custom_booking_date;
				$result = $db->fetchAll($sql);	
				foreach($result as $h_rows)
				{
					$sql=$db->select()
						->from('leads')
						->where('id = ?', $h_rows['leads_id']);
					$lead_result = $db->fetchRow($sql);
					switch ($h_rows['status']) 
					{
						case "ACTIVE":
							$stat = "New";
							break;
						case "ARCHIVED":
							$stat = "Archived";
							break;
						case "ON-HOLD":
							$stat = "On Hold";
							break;															
						case "HIRED":
							$stat = "Hired";
							break;															
						case "REJECTED":
							$stat = "Rejected";
							break;		
						case "CONFIRMED":
							$stat = "Confirmed/In Process";	
							break;		
						case "YET TO CONFIRM":
							$stat = "Client contacted, no confirmed date";
							break;		
						case "DONE":
							$stat = "Interviewed; waiting for feedback";
							break;
						case "RE-SCHEDULED":
							$stat = "Confirmed/Re-Booked";
							break;	
						case "CANCELLED":
							$stat = "Cancelled";
							break;	
						case "CHATNOW INTERVIEWED":
							$stat = "Chat Now Interviewed";
							break;	
						case "ON TRIAL":
							$stat = "On Trial";
							break;								
					}		
					if ($stat!=""){				
						$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a>(".$stat.")<br />";
					}else{
						$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a><br />";
					}
					$date_counter = $h_rows['date_created'];
					if($date_counter <> "" && $date_counter <> "0000-00-00" && $date_counter <> "0000-00-00 00:00:00") 
					{ 
						$date .= "> ".date('F j, Y',strtotime($date_counter))."<br />";
					}
					else
					{
						$date .= "> ".$date_counter."<br />";
					}		
					$stat = "";			
				}				
			}	
			elseif($_REQUEST["field"] == "hired_asl_staff")
			{	
			
				$date = "";
				$client_full_name = "";
				$sql = "SELECT DISTINCT(s.leads_id), s.status, s.starting_date as date_created FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
				WHERE s.userid = '".$rows['userid']."' AND rs.admin_id = '".$recruiter_id."' AND r.applicant_id = s.userid AND rs.userid = s.userid AND s.status='ACTIVE' AND r.service_type='ASL'".$total_number_of_hired_asl_staff_date;
				$result = $db->fetchAll($sql);		
				foreach($result as $h_rows)
				{
					$sql=$db->select()
						->from('leads')
						->where('id = ?', $h_rows['leads_id']);
					$lead_result = $db->fetchRow($sql);
					$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a>(".$h_rows['status'].")<br />";
					$date_counter = $h_rows['date_created'];
					if($date_counter <> "" && $date_counter <> "0000-00-00" && $date_counter <> "0000-00-00 00:00:00") 
					{ 
						$date .= "> ".date('F j, Y',strtotime($date_counter))."<br />";
					}
					else
					{
						$date .= "> ".$date_counter."<br />";
					}					
				}		
			}	
			elseif($_REQUEST["field"] == "hired_custom_staff")
			{	
			
				$date = "";
				$client_full_name = "";
				$sql = "SELECT DISTINCT(s.leads_id), s.status, s.starting_date as date_created FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
				WHERE s.userid = '".$rows['userid']."' AND rs.admin_id = '".$recruiter_id."' AND r.applicant_id = s.userid AND rs.userid = s.userid AND s.status='ACTIVE' AND r.service_type='CUSTOM'".$total_number_of_hired_asl_staff_date;
				$result = $db->fetchAll($sql);		
				foreach($result as $h_rows)
				{
					$sql=$db->select()
						->from('leads')
						->where('id = ?', $h_rows['leads_id']);
					$lead_result = $db->fetchRow($sql);
					$client_full_name .= "> <a href=\"javascript: lead('".$lead_result['id']."'); \">".$lead_result['fname']." ".$lead_result['lname']."</a>(".$h_rows['status'].")<br />";
					$date_counter = $h_rows['date_created'];
					if($date_counter <> "" && $date_counter <> "0000-00-00" && $date_counter <> "0000-00-00 00:00:00") 
					{ 
						$date .= "> ".date('F j, Y',strtotime($date_counter))."<br />";
					}
					else
					{
						$date .= "> ".$date_counter."<br />";
					}					
				}		
			}			
			elseif($_REQUEST["field"] == "shortlisted")
			{
				$client_full_name = $rows['jobposition'];
			}
			else
			{
				$client_full_name = "";
			}
			//ended: get client's name		
		
			$file_manager = new staff_files_manager('../',$rows['userid']) ;
			$staff_photo = $file_manager->retrieve_photo_small();
			
			if ($_REQUEST["field"]=="shortlisted"){
				$report_result .= '
				<tr>
					<td align="left" valign="top" class="td_info td_la">'.$counter.'</td>                            
					<td align="left" valign="top" class="td_info">
						<table>
							<tr>
								<td>'.$staff_photo.'</td>
								<td valign="middle">
									<a href="javascript: open_popup_profile('.$rows['userid'].'); ">'.$name.'</a><br />
									<font size=1>UserID: '.$rows['userid'].'</font><br /><font size=1>Email: '.$email.'</font>
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top" class="td_info"><font size=1>'.$job_ads.'</font></td>
					<td align="left" valign="top" class="td_info"><font size=1>'.$client_full_name.'</font></td>
					<td align="center" valign="top" class="td_info"><font size=1>'.$date.'</font></td>
				</tr>
				';
			}else{
				$report_result .= '
				<tr>
					<td align="left" valign="top" class="td_info td_la">'.$counter.'</td>                            
					<td align="left" valign="top" class="td_info">
						<table>
							<tr>
								<td>'.$staff_photo.'</td>
								<td valign="middle">
									<a href="javascript: open_popup_profile('.$rows['userid'].'); ">'.$name.'</a><br />
									<font size=1>UserID: '.$rows['userid'].'</font><br /><font size=1>Email: '.$email.'</font>
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top" class="td_info"><font size=1>'.$client_full_name.'</font></td>
					<td align="center" valign="top" class="td_info"><font size=1>'.$date.'</font></td>
				</tr>
				';	
			}
			
	}
}
//ENDED: generate content list


//START: generate report header

if($_REQUEST["field"] == "endorsed")
{
	$field_caption = 'Client';
}
elseif($_REQUEST["field"] == "shortlisted")
{
	$field_caption = 'Job Advertisement';
}
elseif($_REQUEST["field"] == "asl")
{
	$field_caption = 'Category';
}
elseif($_REQUEST["field"] == "custom_booking" || $_REQUEST["field"] == "asl_booking")
{
	$field_caption = 'Lead / Status';
}
elseif($_REQUEST["field"] == "hired_asl_staff" || $_REQUEST["field"] == "hired_custom_staff")
{
	$field_caption = 'Lead / Status';
}
else
{
	$field_caption = "";
}

if ($_REQUEST["field"]=="shortlisted"){
	$header = '
	<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#FFFFCC>
		<tr>
			<td valign=top>
				<table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
					<tr bgcolor="#FFFFFF">
						<td width="100%" align="left" valign="top"><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>'.$recruiter.'</strong> - '.$field.'</font></td><td align="right"><a href=\'javascript: hide_popup_report(); \'><img src="../../portal/images/closelabel.gif" border="0" /></a></td></tr></table></div></td>
					</tr>
					<tr>
						<td valign="top">  
							<div align="center" style=\'overflow-y:scroll; height:260px; width: 720px; overflow-x:hidden \'>	
							<table width="100%" height="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
								<tr>
									<td width="5%" align="left" valign="top" class="td_info td_la">#</td>
									<td width="25%" align="left" valign="top" class="td_info td_la">Candidate</td>
									<td width="30%" align="left" valign="top" class="td_info td_la">'.$field_caption.'</td>
									<td width="25%" align="left" valign="top" class="td_info td_la">Client</td>
									<td width="25%" align="center" valign="top" class="td_info td_la">'.$date_caption.'</td>
								</tr>
	';	
}else{
	$header = '
	<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#FFFFCC>
		<tr>
			<td valign=top>
				<table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
					<tr bgcolor="#FFFFFF">
						<td width="100%" align="left" valign="top"><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>'.$recruiter.'</strong> - '.$field.'</font></td><td align="right"><a href=\'javascript: hide_popup_report(); \'><img src="../../portal/images/closelabel.gif" border="0" /></a></td></tr></table></div></td>
					</tr>
					<tr>
						<td valign="top">  
							<div align="center" style=\'overflow-y:scroll; height:260px; width: 720px; overflow-x:hidden \'>	
							<table width="100%" height="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
								<tr>
									<td width="5%" align="left" valign="top" class="td_info td_la">#</td>
									<td width="40%" align="left" valign="top" class="td_info td_la">Candidate</td>
									<td width="35%" align="left" valign="top" class="td_info td_la">'.$field_caption.'</td>
									<td width="20%" align="center" valign="top" class="td_info td_la">'.$date_caption.'</td>
								</tr>
	';		
}

//ENDED: generate report header


//START: generate report footer
$footer = '
							<tr>
								<td colspan=3 height=100%></td>
							</tr>
						</table>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table> 
';
//ENDED: generate report footer

?>
<script type="text/javascript" src="js/RecruiterHome.js"></script>


<?php
//return report result
echo $header.$report_result.$footer;
?>
