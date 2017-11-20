<?php
//error_reporting(-1);
//NEW CANDIDATE STATUS REPORT FUNCTIONS START==============================================

function getUnprocessedCount($start,$end){

	global $db;

	$select = "SELECT rs.admin_id, count(us.userid) as num
		FROM unprocessed_staff as us
		left join recruiter_staff as rs on us.userid=rs.userid 
		where date(rs.date) >= '".$start."'
		and date(rs.date) <= '".$end."'
		group by rs.admin_id";
		
	$rows = $db->fetchAll($select); 

	$results = array();
	foreach($rows as $row){
		
		if($row['admin_id'] != NULL){

			$select = "select count(distinct us.userid)
				from unprocessed_staff as us
				left join recruiter_staff as rs on us.userid=rs.userid 
				where date(rs.date) >= '".$start."'
				and date(rs.date) <= '".$end."'
				and rs.admin_id = ".$row['admin_id']."
				and us.userid not in ( select userid from pre_screened_staff)
				and us.userid not in ( select userid from inactive_staff)
				and us.userid not in ( select userid from job_sub_category_applicants)
				and us.userid not in ( select userid from tb_shortlist_history)
				and us.userid not in ( select userid from tb_endorsement_history)";
			$candidates = $db->fetchOne($select);
		
			$results[$row['admin_id']]['total_candidate'] = $candidates;
			$results[$row['admin_id']]['total_status'] = $row['num'];
		}
	}
	return $results; 
}  

function getPrescreenedCount($start,$end){

	global $db;
	
	$select = "SELECT rs.admin_id, COUNT( pss.userid ) as num
		from pre_screened_staff as pss
		left join recruiter_staff as rs on pss.userid=rs.userid
		WHERE DATE( pss.DATE ) >=  '".$start."'
		AND DATE( pss.DATE ) <=  '".$end."'
		GROUP BY rs.admin_id";
	$rows = $db->fetchAll($select);

	$results = array();
	foreach($rows as $row){
		
		if($row['admin_id'] != NULL){
			$select = "select count(distinct pss.userid)
				from pre_screened_staff as pss
				left join recruiter_staff as rs on pss.userid=rs.userid
				where date(pss.date) >= '".$start."'
				and date(pss.date) <= '".$end."'
				and rs.admin_id = ".$row['admin_id']."
				and pss.userid not in ( select userid from inactive_staff)
				and pss.userid not in ( select userid from job_sub_category_applicants)
				and pss.userid not in ( select userid from tb_shortlist_history)
				and pss.userid not in ( select userid from tb_endorsement_history)";
			$candidates = $db->fetchOne($select);
		
			$results[$row['admin_id']]['total_candidate'] = $candidates;
			$results[$row['admin_id']]['total_status'] = $row['num'];
		}
		
	}
	return $results; 
} 

function getInactiveCount($start,$end){

	global $db;
	
	$select = "SELECT rs.admin_id, COUNT( ins.userid ) as num
		from inactive_staff as ins
		left join recruiter_staff as rs on ins.userid=rs.userid
		WHERE DATE( ins.DATE ) >=  '".$start."'
		AND DATE( ins.DATE ) <=  '".$end."'
		GROUP BY rs.admin_id";
	$rows = $db->fetchAll($select);

	$results = array();
	foreach($rows as $row){
	
		if($row['admin_id'] != NULL){
			$select = "select count(distinct ins.userid)
				from inactive_staff as ins
				left join recruiter_staff as rs on ins.userid=rs.userid
				where date(ins.date) >= '".$start."'
				and date(ins.date) <= '".$end."'
				and rs.admin_id = ".$row['admin_id'];
			$candidates = $db->fetchOne($select);
		
			$results[$row['admin_id']]['total_candidate'] = $candidates;
			$results[$row['admin_id']]['total_status'] = $row['num'];
		}
	}
	return $results; 
} 

function getOnAslCount($start,$end){

	global $db;
	
	$select = "select rs.admin_id,count(jsca.userid) as num
		from job_sub_category_applicants as jsca
		left join recruiter_staff as rs on rs.userid=jsca.userid
		where date(jsca.sub_category_applicants_date_created) >= '".$start."'
		and date(jsca.sub_category_applicants_date_created) <= '".$end."'
		group by rs.admin_id";
	$rows = $db->fetchAll($select);

	$results = array();
	foreach($rows as $row){
	
		if($row['admin_id'] != ''){
			$select = "select count(*)
				from job_sub_category_applicants as jsca
				left join recruiter_staff as rs on rs.userid=jsca.userid
				where (date(jsca.sub_category_applicants_date_created) >= DATE('".$start."')
				and date(jsca.sub_category_applicants_date_created) <= DATE('".$end."'))
				and admin_id=".$row['admin_id']." group by jsca.userid";
				
			
			$candidates = count($db->fetchAll($select));
			
			$results[$row['admin_id']]['total_candidate'] = $candidates;
			$results[$row['admin_id']]['total_status'] = $row['num'];
		}
	}
	return $results; 
} 

function getShortlistedCount($start,$end){

	global $db;
	
	$select = "select rs.admin_id,count(tsh.userid) as num
		from tb_shortlist_history as tsh
		left join recruiter_staff as rs on rs.userid=tsh.userid
		where tsh.date_listed >= '".$start."'
		and tsh.date_listed <= '".$end."'
		group by rs.admin_id";
	$rows = $db->fetchAll($select);

	$results = array();
	foreach($rows as $row){
		
		if($row['admin_id'] != NULL){
			$select = "select count(distinct tsh.userid) 
				from tb_shortlist_history as tsh
				left join recruiter_staff as rs on rs.userid=tsh.userid
				where tsh.date_listed >= '".$start."'
				and tsh.date_listed <= '".$end."'
				and rs.admin_id = ".$row['admin_id'];
			$candidates = $db->fetchOne($select);
		
			$results[$row['admin_id']]['total_candidate'] = $candidates;
			$results[$row['admin_id']]['total_status'] = $row['num'];
		}
	}
	return $results; 
} 

function getEndorsedCount($start,$end){

	global $db;
	
	$select = "select rs.admin_id,count(teh.userid) as num
		from tb_endorsement_history as teh
		left join recruiter_staff as rs on rs.userid=teh.userid
		where date(teh.date_endoesed) >= '".$start."'
		and date(teh.date_endoesed) <= '".$end."'
		group by rs.admin_id";
	$rows = $db->fetchAll($select);

	$results = array();
	foreach($rows as $row){
	
		if($row['admin_id'] != NULL){
			$select = "select count(distinct teh.userid)
				from tb_endorsement_history as teh
				left join recruiter_staff as rs on rs.userid=teh.userid
				where date(teh.date_endoesed) >= '".$start."'
				and date(teh.date_endoesed) <= '".$end."'
				and rs.admin_id = ".$row['admin_id'];
			$candidates = $db->fetchOne($select);
		
			$results[$row['admin_id']]['total_candidate'] = $candidates;
			$results[$row['admin_id']]['total_status'] = $row['num'];
		}
	}
	return $results; 
}

function getRecruiters(){

	global $db;
	
	$select = "SELECT admin_id, admin_fname, admin_lname 
		FROM admin 
		WHERE (status='HR') AND status <> 'REMOVED'  AND admin_id <> 161  
		order by admin_fname";
	$rows = $db->fetchAll($select);
	
	$results = array();
	$i = 1;
	foreach($rows as $row){
		$results[$i]['id'] = $row['admin_id'];
		$results[$i]['fname'] = $row['admin_fname'];
		$results[$i]['lname'] = $row['admin_lname'];
		$i++;
	}
	return $results; 
} 

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
//NEW CANDIDATE STATUS REPORT FUNCTIONS END==============================================


//START: date query
if(isset($_REQUEST["registered_advance_search"]))
{
	if($_REQUEST["search_date_check"] <> "" || $_REQUEST["search_date_check"] <> NULL)
	{
		$_REQUEST["search_date1"] = ""; 
		$_REQUEST["search_date2"] = "";
	}
}
else
{
	$a_1 = mktime(0, 0, 0, date("n"), -30, date("Y"));
	$b_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
	$a_ = date("Y-m-d",$a_1);
	$b_ = date("Y-m-d");
	
	$_REQUEST["search_date1"] = date("Y-m")."-01"; //date("Y-m-d",$a_1);
	$_REQUEST["search_date2"] = date("Y-m-d");
	//$_REQUEST["search_date_check"] = "on";
}

$where_date_registered = "";
if($_REQUEST["search_date1"] <> "" && $_REQUEST["search_date2"] <> "")
{
	//NEW CANDIDATE STATUS REPORT START================================================
	$unprocessed = getUnprocessedCount($_REQUEST['search_date1'],$_REQUEST['search_date2']);
	$prescreened = getPrescreenedCount($_REQUEST['search_date1'],$_REQUEST['search_date2']);
	$inactive = getInactiveCount($_REQUEST['search_date1'],$_REQUEST['search_date2']);
	$onasl = getOnAslCount($_REQUEST['search_date1'],$_REQUEST['search_date2']);
	$shortlisted = getShortlistedCount($_REQUEST['search_date1'],$_REQUEST['search_date2']);
	$endorsed = getEndorsedCount($_REQUEST['search_date1'],$_REQUEST['search_date2']);
	$recruiters = getRecruiters($_REQUEST['search_date1'],$_REQUEST['search_date2']);

	$total_unprocessed = 0;
	$total_prescreened = 0;
	$total_inactive = 0;
	$total_onasl = 0;
	$total_shortlisted = 0;
	$total_endorsed = 0;
	$total_tnc = 0;
	$total_status = 0;
		
	foreach($recruiters as $key=>$recruiter){

		//$recruiters[$recruiter['id']]['tnc'] = getTnc($recruiter['id']);

		if(isset($unprocessed[$recruiter['id']]['total_status'])){
			$recruiters[$key]['unprocessed'] = $unprocessed[$recruiter['id']]['total_candidate'];
		}
		else{
			$recruiters[$key]['unprocessed'] = 0;
		}
		
		if(isset($prescreened[$recruiter['id']]['total_status'])){
			$recruiters[$key]['prescreened'] = $prescreened[$recruiter['id']]['total_candidate'];
		}
		else{
			$recruiters[$key]['prescreened'] = 0;
		}
		
		if(isset($inactive[$recruiter['id']]['total_status'])){
			$recruiters[$key]['inactive'] = $inactive[$recruiter['id']]['total_candidate'];
		}
		else{
			$recruiters[$key]['inactive'] = 0;
		}
		
		if(isset($onasl[$recruiter['id']]['total_status'])){
			$recruiters[$key]['onasl'] = $onasl[$recruiter['id']]['total_candidate'];
		}
		else{
			$recruiters[$key]['onasl'] = 0;
		}
		
		if(isset($shortlisted[$recruiter['id']]['total_status'])){
			$recruiters[$key]['shortlisted'] = $shortlisted[$recruiter['id']]['total_candidate'];
		}
		else{
			$recruiters[$key]['shortlisted'] = 0;
		}
		
		if(isset($endorsed[$recruiter['id']]['total_status'])){
			$recruiters[$key]['endorsed'] = $endorsed[$recruiter['id']]['total_candidate'];
		}
		else{
			$recruiters[$key]['endorsed'] = 0;
		}

		$recruiters[$key]['total_status'] = $recruiters[$key]['unprocessed'] + $recruiters[$key]['prescreened'] + $recruiters[$key]['inactive']
			+ $recruiters[$key]['onasl'] + $recruiters[$key]['shortlisted'] + $recruiters[$key]['endorsed'];
			
		$tnc_list = getAdminStaff($recruiter['id'],$_REQUEST['search_date1'],$_REQUEST['search_date2']);		
		$recruiters[$key]['tnc'] = count($tnc_list);

		//compute totals
		$total_unprocessed += $recruiters[$key]['unprocessed'];
		$total_prescreened += $recruiters[$key]['prescreened'];
		$total_inactive += $recruiters[$key]['inactive'];
		$total_onasl += $recruiters[$key]['onasl'];
		$total_shortlisted += $recruiters[$key]['shortlisted'];
		$total_endorsed += $recruiters[$key]['endorsed'];
		$total_tnc += $recruiters[$key]['tnc'];
		$total_status += $recruiters[$key]['total_status'];
	}

	$totals = array();
	$totals['fname'] = 'Total';
	$totals['unprocessed'] = $total_unprocessed;
	$totals['prescreened'] = $total_prescreened;
	$totals['inactive'] = $total_inactive;
	$totals['onasl'] = $total_onasl;
	$totals['shortlisted'] = $total_shortlisted;
	$totals['endorsed'] = $total_endorsed;
	$totals['tnc'] = $total_tnc;
	$totals['total_status'] = $total_status;
	//$recruiters[' '] = $totals;


	//NEW CANDIDATE STATUS REPORT END================================================
	$total_number_of_candidates_date = " AND (DATE(rs.date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";

	$total_number_of_custom_booking_date = " AND (DATE(r.date_added) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_asl_booking_date = " AND (DATE(r.date_added) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
			
	$total_number_of_hired_trial_staff_date = "";
	$total_number_of_hired_asl_staff_date = " AND (DATE(s.starting_date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_hired_custom_staff_date = " AND (DATE(s.starting_date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
			
	$total_number_of_no_show_date = " AND (DATE(ns.date) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
	$total_number_of_cancel_date = " AND (DATE(s.date_contracted) BETWEEN '".$_REQUEST["search_date1"]."' AND '".$_REQUEST["search_date2"]."')";
}
//ENDED: date query


//START: recruitment summary report
$q ="SELECT admin_id, admin_fname, admin_lname 
		FROM admin 
		WHERE (status='HR') AND status <> 'REMOVED'  AND admin_id <> 161  
		order by admin_fname";
		
$result = $db->fetchAll($q);
$counter_checker = 1;
$total_number_of_recruiter = 0;
$bgcolor = "#E4E4E4";
$counter = 0;

foreach($result as $r)
{
	
	$counter++;

	//start: get total number of candidates
	$total_number_of_candidates = 0;
	$sql = "SELECT rs.id FROM recruiter_staff rs
	WHERE rs.admin_id = ".$r['admin_id'].$total_number_of_candidates_date;	
	$t = $db->fetchAll($sql);	
	$total_number_of_candidates = count($t);
	//ended: get total number of candidates

	//start: get CUSTOM BOOKING total
	$total_number_of_custom_booking = 0;
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, tb_request_for_interview r
	WHERE rs.admin_id = '".$r['admin_id']."' AND rs.userid = r.applicant_id AND service_type='CUSTOM'".$total_number_of_custom_booking_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_custom_booking = $db->fetchOne("SELECT FOUND_ROWS()");
	//ended: get CUSTOM BOOKING total

	//start: get ASL BOOKING total
	$total_number_of_asl_booking = 0;
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, tb_request_for_interview r
	WHERE rs.admin_id = '".$r['admin_id']."' AND rs.userid = r.applicant_id AND service_type='ASL'".$total_number_of_asl_booking_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_asl_booking = $db->fetchOne("SELECT FOUND_ROWS()");
	//ended: get ASL BOOKING total

	//start: get TRIAL STAFF total
	$total_number_of_hired_trial_staff = 0;
	//ended: get TRIAL STAFF total

	//start: get ASL STAFF total
	$total_number_of_hired_asl_staff = 0;
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
	WHERE rs.admin_id = '".$r['admin_id']."' AND r.applicant_id = s.userid AND rs.userid = s.userid AND s.status='ACTIVE' AND r.service_type='ASL'".$total_number_of_hired_asl_staff_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_hired_asl_staff = $db->fetchOne("SELECT FOUND_ROWS()");
	//ended: get ASL STAFF total

	//start: get CUSTOM STAFF total
	$total_number_of_hired_custom_staff = 0;
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, tb_request_for_interview r, subcontractors s
	WHERE rs.admin_id = '".$r['admin_id']."' AND r.applicant_id = s.userid AND rs.userid = s.userid AND s.status='ACTIVE' AND r.service_type='CUSTOM'".$total_number_of_hired_asl_staff_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_hired_custom_staff = $db->fetchOne("SELECT FOUND_ROWS()");
	//ended: get CUSTOM STAFF total

	//start: get no shows total
	$total_number_of_no_show_initial = 0;
	$total_number_of_no_show_asl = 0;
	$total_number_of_no_show_custom = 0;
	$total_number_of_no_show_first_day = 0;
	
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, staff_no_show ns
	WHERE rs.admin_id = '".$r['admin_id']."' AND service_type='INITIAL' AND ns.userid = rs.userid".$total_number_of_no_show_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_no_show_initial = $db->fetchOne("SELECT FOUND_ROWS()");
	
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, staff_no_show ns
	WHERE rs.admin_id = '".$r['admin_id']."' AND service_type='ASL' AND ns.userid = rs.userid".$total_number_of_no_show_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_no_show_asl = $db->fetchOne("SELECT FOUND_ROWS()");
	
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, staff_no_show ns
	WHERE rs.admin_id = '".$r['admin_id']."' AND service_type='CUSTOM' AND ns.userid = rs.userid".$total_number_of_no_show_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_no_show_custom = $db->fetchOne("SELECT FOUND_ROWS()");	
	
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, staff_no_show ns
	WHERE rs.admin_id = '".$r['admin_id']."' AND service_type='FIRST DAY' AND ns.userid = rs.userid".$total_number_of_no_show_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_no_show_custom = $db->fetchOne("SELECT FOUND_ROWS()");	
	//ended: get no shows total

	//start: get ASL cancelled total
	$total_number_of_resigned = 0;
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, subcontractors s
	WHERE rs.admin_id = '".$r['admin_id']."' AND rs.userid = s.userid AND s.status='resigned'".$total_number_of_cancel_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_resigned = $db->fetchOne("SELECT FOUND_ROWS()");	
	
	$total_number_of_terminated = 0;
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, subcontractors s
	WHERE rs.admin_id = '".$r['admin_id']."' AND rs.userid = s.userid AND s.status='terminated'".$total_number_of_cancel_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_terminated =  $db->fetchOne("SELECT FOUND_ROWS()");

	$total_number_of_replacement = 0;
	$sql = "SELECT SQL_CALC_FOUND_ROWS rs.userid FROM recruiter_staff rs, subcontractors s
	WHERE rs.admin_id = '".$r['admin_id']."' AND rs.userid = s.userid AND s.status='replacement'".$total_number_of_cancel_date." GROUP BY userid LIMIT 1";
	$t = $db->fetchAll($sql);	
	$total_number_of_replacement =  $db->fetchOne("SELECT FOUND_ROWS()");
	//ended: get ASL cancelled total	


	//start: get hired percentage
	$total_number_of_hired_percentage = ($total_number_of_hired_trial_staff + $total_number_of_hired_asl_staff + $total_number_of_hired_custom_staff) / $total_number_of_candidates * 100;
	//ended: get hired percentage

	//start: generate list										
		
		//start: get interview request
		$tnc_list = getAdminStaff($r['admin_id'],$_REQUEST['search_date1'],$_REQUEST['search_date2']);		
		$count_tnc = count($tnc_list);
		
		$interview_request_report_total = $total_number_of_custom_booking+$total_number_of_asl_booking;
		$interview_request_report = $interview_request_report.'
		<tr>
			<td class="td_info td_la">'.$counter.'</td>
			<td class="td_info">'.$r['admin_fname'].' '.$r['admin_lname'].'</td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'TNC\'); ">('.$count_tnc.')</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'custom_booking\'); ">'.$total_number_of_custom_booking.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'asl_booking\'); ">'.$total_number_of_asl_booking.'</a></td>
			<td class="td_info" align="center">'.$interview_request_report_total.'</td>
		</tr>';
		//ended: get interview request
		
		//start: get hired staff
		$tnc_list = getAdminStaff($r['admin_id'],$_REQUEST['search_date1'],$_REQUEST['search_date2']);		
		$count_tnc = count($tnc_list);
		
		$hired_staff_report_total = $total_number_of_hired_trial_staff+$total_number_of_hired_asl_staff+$total_number_of_hired_custom_staff;
		$hired_staff_report = $hired_staff_report.'
		
		
		<tr>
			<td class="td_info td_la">'.$counter.'</td>
			<td class="td_info">'.$r['admin_fname'].' '.$r['admin_lname'].'</td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'TNC\'); ">('.$count_tnc.')</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'trial_staff\'); ">'.$total_number_of_hired_trial_staff.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'hired_asl_staff\'); ">'.$total_number_of_hired_asl_staff.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'hired_custom_staff\'); ">'.$total_number_of_hired_custom_staff.'</a></td>
			<td class="td_info" align="center">'.intval($total_number_of_hired_percentage).'%</td>
			<td class="td_info" align="center">'.$hired_staff_report_total.'</td>
		</tr>';
		//ended: get hired staff
		
		//start: get drop outs
		$drop_outs_report_total = $total_number_of_no_show_initial+$total_number_of_no_show_asl+$total_number_of_no_show_custom+$total_number_of_no_show_first_day;
		
		$tnc_list = getAdminStaff($r['admin_id'],$_REQUEST['search_date1'],$_REQUEST['search_date2']);		
		$count_tnc = count($tnc_list);
	
		$drop_outs_report = $drop_outs_report.'
		<tr>
			<td class="td_info td_la">'.$counter.'</td>
			<td class="td_info">'.$r['admin_fname'].' '.$r['admin_lname'].'</td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'TNC\'); ">('.$count_tnc.')</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'now_show_initial\'); ">'.$total_number_of_no_show_initial.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'now_show_asl\'); ">'.$total_number_of_no_show_asl.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'now_show_custom\'); ">'.$total_number_of_no_show_custom.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'now_show_first_day\'); ">'.$total_number_of_no_show_first_day.'</a></td>
			
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'cancel_resigned\'); ">'.$total_number_of_resigned.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'cancel_terminated\'); ">'.$total_number_of_terminated.'</a></td>
			<td class="td_info" align="center"><a href="javascript: show_popup_report(\''.$_REQUEST["search_date1"].'\',\''.$_REQUEST["search_date2"].'\','.$r['admin_id'].',\'cancel_replacement\'); ">'.$total_number_of_replacement.'</a></td>
			<td class="td_info" align="center">'.$drop_outs_report_total.'</td>
		</tr>';
		//ended: get drop outs
	//ended: generate list
	
	//start: code footer
	$total_number_of_candidates_footer = $total_number_of_candidates_footer + $total_number_of_candidates;
	
	$total_number_of_recruiter_footer = $total_number_of_recruiter_footer + 1;
	$total_number_of_candidates_footer = $total_number_of_candidates_footer + $total_number_of_candidates;
	$total_number_of_unprocessed_footer = $total_number_of_unprocessed_footer + $total_number_of_unprocessed;
	$total_number_of_pre_screened_footer = $total_number_of_pre_screened_footer + $total_number_of_pre_screened;
	$total_number_of_shortlisted_footer = $total_number_of_shortlisted_footer + $total_number_of_shortlisted;
	$total_number_of_inactive_staff_footer = $total_number_of_inactive_staff_footer + $total_number_of_inactive_staff;
	$total_number_of_endorsed_footer = $total_number_of_endorsed_footer + $total_number_of_endorsed;
	$total_number_on_of_asl_footer = $total_number_on_of_asl_footer + $total_number_on_of_asl;
	$candidate_status_report_total_footer = $candidate_status_report_total_footer + $candidate_status_report_total;
	
	$total_number_of_custom_booking_footer = $total_number_of_custom_booking_footer + $total_number_of_custom_booking;
	$total_number_of_asl_booking_footer = $total_number_of_asl_booking_footer + $total_number_of_asl_booking;
	$interview_request_report_total_footer = $interview_request_report_total_footer + $interview_request_report_total;
	
	$total_number_of_hired_trial_staff_footer = $total_number_of_hired_trial_staff_footer + $total_number_of_hired_trial_staff;
	$total_number_of_hired_asl_staff_footer = $total_number_of_hired_asl_staff_footer + $total_number_of_hired_asl_staff;
	$total_number_of_hired_custom_staff_footer = $total_number_of_hired_custom_staff_footer + $total_number_of_hired_custom_staff;
	$hired_staff_report_total_footer = $hired_staff_report_total_footer + $hired_staff_report_total;
	
	$total_number_of_no_show_initial_footer = $total_number_of_no_show_initial_footer + $total_number_of_no_show_initial;
	$total_number_of_no_show_asl_footer = $total_number_of_no_show_asl_footer + $total_number_of_no_show_asl;
	$total_number_of_no_show_custom_footer = $total_number_of_no_show_custom_footer + $total_number_of_no_show_custom;
	$total_number_of_no_show_first_day_footer = $total_number_of_no_show_first_day_footer + $total_number_of_no_show_first_day;
	
	$total_number_of_resigned_footer = $total_number_of_resigned_footer + $total_number_of_resigned;
	$total_number_of_terminated_footer = $total_number_of_terminated_footer + $total_number_of_terminated;
	$total_number_of_replacement_footer = $total_number_of_replacement_footer + $total_number_of_replacement;
	
	$drop_outs_report_total_footer = $drop_outs_report_total_footer + $drop_outs_report_total;
	
	$total_number_of_hired_percentage_footer = total_number_of_hired_percentage_footer + ($total_number_of_hired_trial_staff_footer + $total_number_of_hired_asl_staff_footer + $total_number_of_hired_custom_staff_footer) / $total_number_of_candidates_footer * 100;	
	//ended: code footer
}

	//start: generate output for footer
		//start: get candidate status report list
		$candidate_status_report_total = $total_number_of_unprocessed+$total_number_of_pre_screened+$total_number_of_shortlisted+$total_number_of_inactive_staff+$total_number_of_endorsed+$total_number_on_of_asl;
		$candidate_status_report = $candidate_status_report.'
		<tr>
			<td class="td_info td_la" colspan=2>Total</td>
			<td class="td_info" align="center">'.$total_number_of_candidates_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_unprocessed_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_pre_screened_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_shortlisted_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_inactive_staff_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_endorsed_footer.'</td>
			<td class="td_info" align="center">'.$total_number_on_of_asl_footer.'</td>
			<td class="td_info" align="center">'.$candidate_status_report_total_footer.'</td>
		</tr>';
		//ended: get candidate status report list											
		
		//start: get interview request
		$interview_request_report_total = $total_number_of_custom_booking+$total_number_of_asl_booking;
		$interview_request_report = $interview_request_report.'
		<tr>
			<td class="td_info td_la" colspan=2>Total</td>
			<td class="td_info" align="center">'.$total_tnc.'</td>
			<td class="td_info" align="center">'.$total_number_of_custom_booking_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_asl_booking_footer.'</td>
			<td class="td_info" align="center">'.$interview_request_report_total_footer.'</td>
		</tr>';
		//ended: get interview request
		
		//start: get hired staff
		$hired_staff_report_total = $total_number_of_hired_trial_staff+$total_number_of_hired_asl_staff+$total_number_of_hired_custom_staff;
		$hired_staff_report = $hired_staff_report.'
		<tr>
			<td class="td_info td_la" colspan=2>Total</td>
			<td class="td_info" align="center">'.$total_tnc.'</td>
			<td class="td_info" align="center">'.$total_number_of_hired_trial_staff_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_hired_asl_staff_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_hired_custom_staff_footer.'</td>
			<td class="td_info" align="center">'.intval($total_number_of_hired_percentage_footer).'%</td>
			<td class="td_info" align="center">'.$hired_staff_report_total_footer.'</td>
		</tr>';
		//ended: get hired staff
		
		//start: get drop outs
		$drop_outs_report_total = $total_number_of_no_show_initial+$total_number_of_no_show_asl+$total_number_of_no_show_custom+$total_number_of_no_show_first_day;
		$drop_outs_report = $drop_outs_report.'
		<tr>
			<td class="td_info td_la" colspan=2>Total</td>
			<td class="td_info" align="center">'.$total_tnc.'</td>
			<td class="td_info" align="center">'.$total_number_of_no_show_initial_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_no_show_asl_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_no_show_custom_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_no_show_first_day_footer.'</td>
			
			<td class="td_info" align="center">'.$total_number_of_resigned_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_terminated_footer.'</td>
			<td class="td_info" align="center">'.$total_number_of_replacement_footer.'</td>
			
			<td class="td_info" align="center">'.$drop_outs_report_total_footer.'</td>
		</tr>';
		//ended: get drop outs
	//ended: generate output for footer
//START: recruitment summary report


//START: caledar date picker jscript
$search_date_requested1 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "search_date1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$search_date_requested2 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "search_date2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
//ENDED: caledar date picker jscript



//START: search date
$search_date1 = $_REQUEST["search_date1"];
$search_date2 = $_REQUEST["search_date2"];
$search_date_check = $_REQUEST["search_date_check"];
//ENDED: search date
?>