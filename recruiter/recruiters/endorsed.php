<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

include_once('../lib/staff_files_manager.php');

if(!$_SESSION['admin_id']){
	header("location:/portal/index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
	echo "This page is for HR usage only.";
	exit;
}

$admin_id = $_SESSION['admin_id'];
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);
$recruiter_full_name = $admin['admin_fname']." ".$admin['admin_lname'];
$recruiter_user_type = $admin['status'];
if (isset($_GET["staff_status"])){
	$staff_status = $_GET["staff_status"];
}else{
	$staff_status = "ALL";
}


$posting = $_GET['posting'];
$searched = $_GET["searched"];
$page = $_GET['page'];
if($page == ''){
	$page = 1;
}
/*
if ($searched=="1"){
	$page = 1;
}
*/
$date_start = $_GET['date_start']; 
$date_end = $_GET['date_end'];
$updated_date_start = $_GET['updated_date_start'];
$updated_date_end = $_GET['updated_date_end'];
$recruiter = $_GET['recruiter'];
$keyword = $_GET['keyword'];
$keyword_type = $_GET['keyword_type'];
$country = $_GET['country'];
$lead_id = $_GET["lead_id"];
$lead_name = $_GET["lead_name"];
$recruitment_team_id = $_GET["recruiter_team"];
$result_per_page = $_GET['result_per_page'];
$selected_region = $_GET["selected_region"];
$selected_city = $_GET["selected_city"];
$endorsed_date_start = $_GET["endorsed_date_start"];
$endorsed_date_end = $_GET["endorsed_date_end"];


if (isset($_GET["staff_status"])){
	$staff_status = $_GET["staff_status"];
}else{
	$staff_status = "ALL";
}


if($result_per_page == ''){
	$result_per_page = 100;
}

function getStaffStatus($userid){

	global $db;

	$statuses = array();
	
	$select = "select userid, date 
		from unprocessed_staff 
		where userid='".$userid."'";
	
	$status = $db->fetchRow($select);
	
	if($status != NULL){
		$status["label"] = "Unprocessed";
		$statuses[] = $status;
	}
	
	
	$select = "select userid, date 
		from pre_screened_staff 
		where userid='".$userid."'";
	$status = $db->fetchRow($select);
	
	if($status != NULL){
		$status["label"] = "Prescreened";
		$statuses[] = $status;
	}
	
	$select = "select userid, date 
		from inactive_staff 
		where userid='".$userid."'";
	$status = $db->fetchRow($select);
	if($status != NULL){
		$status["label"] = "Inactive";
		$statuses[] = $status;
	}
	
	$select = "select userid, date_endoesed AS date
		from tb_endorsement_history 
		where userid='".$userid."'";
	$status = $db->fetchRow($select);
	if($status != NULL){
		$status["label"] = 'Endorsed';
		$statuses[] = $status;
	}
	
	$select = "select userid, date_listed AS date
		from tb_shortlist_history 
		where userid='".$userid."'";
	$status = $db->fetchRow($select);
	if($status != NULL){ 
		$status["label"] = 'Shortlisted';
		$statuses[] = $status;
	}
	
	$select = "select userid, sub_category_applicants_date_created AS date
		from job_sub_category_applicants 
		where userid='".$userid."'";
	$status = $db->fetchRow($select);
	if($status != NULL){	
		$status["label"] = 'Categorized';
		$statuses[] = $status;
	}
	
	//calculate recent
	if (!empty($statuses)){
		$latestStatus = null;
		foreach($statuses as $status){
			if ($latestStatus==null){
				$latestStatus = $status;
			}else{
				$latestStatusDate = strtotime($latestStatus["date"]);
				$currentStatusDate = strtotime($status["date"]);
				if ($currentStatusDate>$latestStatusDate){
					$latestStatus = $status;
				}
			}
		}
		$select = "select userid, starting_date AS date FROM subcontractors AS s WHERE s.userid='".$userid."' AND status IN ('ACTIVE', 'suspended')";
		$status = $db->fetchRow($select);
		
		if ($status){
			$status["label"] = 'Hired';
			$latestStatus =  $status;
			
		}
		return $latestStatus["label"];
	}else{
		return "";
	}
	
}

function getPositionsAdvertized(){
	
	global $db;
	$sql = "SELECT p.id, p.lead_id, p.date_created, p.jobposition , l.fname, l.lname
		FROM posting as p
		left join leads as l on p.lead_id=l.id
		WHERE p.status='ACTIVE'
		order by l.fname, l.lname, p.jobposition";
	return $db->fetchAll($sql);
	
}

function getEndorsement($userid){
	global $db;
	$result = $db->fetchAll($db->select()
		->from(array("tbr"=>"tb_endorsement_history"), array("tbr.client_name AS lead_id", "tbr.date_endoesed AS date_endorsed"))
		->joinInner(array("l"=>"leads"), "l.id = tbr.client_name", array(new Zend_Db_Expr("CONCAT(l.fname, ' ', l.lname) AS client")))
		->joinLeft(array("p"=>"posting"), "p.id = tbr.position", array(new Zend_Db_Expr("p.jobposition AS jobposition")))
		->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = tbr.job_category", array(new Zend_Db_Expr("jsc.sub_category_name AS sub_category_name")))
		->where("tbr.userid = ?", $userid)
		->order("tbr.date_endoesed DESC"));
		
	foreach($result as $key=>$item){
		$result[$key]["client"] = "<a href='/portal/leads_information.php?id=".$item["lead_id"]."' target='_blank'>{$item["client"]}</a>";
		$result[$key]["date_endorsed"] = date("Y-m-d", strtotime($item["date_endorsed"]));
	}
	return $result;
}

function getRecruiters(){
	
	global $db;
	$select = "SELECT admin_id,admin_fname,admin_lname 	 
		FROM `admin`
		where (status='HR')  
		AND status <> 'REMOVED'  AND admin_id <> 161  
		order by admin_fname";
	return $db->fetchAll($select); 
	
}


function getRecruitmentTeams(){
	global $db;
	return $db->fetchAll($db->select()->from("recruitment_team")->where("team_status <> 'removed'"));
}

function getApplicants($posting,$page,$date_start,$date_end,$updated_date_start,$updated_date_end,$recruiter,$keyword,$keyword_type,$country, $lead_id, $lead_name, $recruitment_team_id){  

	global $db;
	global $db_query_only;
	global $result_per_page;
	
	$posting_filter = '';
	if($posting != ''){
		if ($posting!="All"){
			$posting_filter = ' and p.id ='.$posting;		
		}else{
			$posting_filter = ' and p.id IS NOT NULL ';
			$sql = "SELECT a.userid AS userid, COUNT(*) AS count FROM applicants a
					JOIN posting p ON p.id = a.posting_id 
					AND a.status <>'Sub-Contracted'
					AND p.status ='ACTIVE' AND a.expired = 0 GROUP BY a.userid HAVING count > 0";
			$userids = $db->fetchAll($sql);
			$items = array();
			foreach($userids as $userid){
				$items[] = $userid["userid"];
			}
			if (!empty($items)){
				$items = array_unique($items);	
				$posting_filter.=" and pe.userid IN (".implode(",", $items).") ";
			}		
			
		}

	}
	
	$reg_date_filter = '';
	if(($date_start != '')&&($date_end != '')){
		$reg_date_filter = " and date(pe.datecreated) >='".$date_start."' and date(pe.datecreated) <= '".$date_end."'" ;
	}
	
	$endorsed_date_filter = "";
	if ($_GET["endorsed_date_start"]&&$_GET["endorsed_date_end"]){
		$endorsed_date_filter = " and DATE(end.date_endoesed) >= '".addslashes($_GET["endorsed_date_start"])."' AND DATE(end.date_endoesed) <= '".addslashes($_GET["endorsed_date_end"])."' ";	
	}
	
	$city_filter = "";
	if (isset($_GET["selected_city"])&&$_GET["selected_city"]!=""){
		$city_filter.=" AND pe.city LIKE '%".addslashes($_GET["selected_city"])."%' ";	
	}
	
	
	$region_filter = "";
	if (isset($_GET["selected_region"])&&$_GET["selected_region"]!=""){
		$region_filter.=" AND pe.state = '".addslashes($_GET["selected_region"])."' ";
	}
	
	$update_date_filter = '';
	if(($updated_date_start != '')&&($updated_date_end != '')){
		$update_date_filter = " and date(pe.dateupdated) >='".$updated_date_start."' and date(pe.dateupdated) <= '".$updated_date_end."'" ;
	}
	/*
	$update_date_filter = '';
	if(($updated_date_start != '')&&($updated_date_end != '')){
		$update_date_filter = " and date(utd.date) >='".$updated_date_start."' and date(utd.date) <= '".$updated_date_end."'" ;
	}
	*/
	//availability filter
	$availability_filter = "";
	
	$available_status = $_GET["available_status"];
	if (isset($available_status)){
		$availability_filter=" AND c.available_status = '".addslashes($available_status)."'";
		if ($available_status=="a"){
			$available_notice = $_GET["available_notice"];
			if (isset($available_notice)&&$available_notice!=""){
				$availability_filter.=" AND c.available_notice = '{$available_notice}'";	
			}
		}else if ($available_status=="b"){
			$available_date = $_GET["available_date"];
			if (isset($available_date)&&$available_date!=""){		
				$availability_filter.=" AND STR_TO_DATE(CONCAT(c.amonth, ' ', c.aday, ', ', c.ayear), '%M %d, %Y') = DATE('{$available_date}')";	
			}
		}
	}
	if ($recruitment_team_id){
		$list = array();
		$team = $db->fetchAll($db->select()->from("recruitment_team_member", array("admin_id"))->where("team_id = ?", $recruitment_team_id));
		foreach($team as $member){
			$list[] = $member["admin_id"];
		}
		if($recruiter != ''){
			if ($recruiter=="NR"){
				if (!empty($list)){
					$recruiters = implode(",", $list);
					$recruiter_filter = " and (rs.admin_id IS NULL OR rs.admin_id IN ($recruiters))";	
				}else{
					$recruiter_filter = " and rs.admin_id IS NULL";
				}
			}else{
				$list[] = $recruiter;
				$recruiters = implode(",", $list);
				$recruiter_filter = " and rs.admin_id IN ($recruiters)";
			}
		}else{
			$recruiters = implode(",", $list);
			$recruiter_filter = " and rs.admin_id IN ($recruiters)";
		}
	}else{
		$recruiter_filter = '';
		if($recruiter != ''){
			if ($recruiter=="NR"){
				$recruiter_filter = " and rs.admin_id IS NULL";
			}else{
				$recruiter_filter = " and rs.admin_id=".$recruiter;
			}
		}
	}
	
	
	$country_filter = '';
	if($country != ''){
		$country_filter = " and pe.permanent_residence='".$country."'";
	}
	
	$lead_filter = "";
	if ($lead_name){
		$lead_name = addslashes($lead_name);
		$lead_filter = " and (CONCAT(l.fname, ' ', l.lname) LIKE '%{$lead_name}%' OR l.fname LIKE '%{$lead_name}%' OR l.lname LIKE '%{$lead_name}%') AND l.id IS NOT NULL";
	}
	
	
	//load all inactive list
	$inactiveList = $db->fetchAll($db->select()->from(array("ina"=>"inactive_staff"), array("userid")));
	$inactives = array();
	$inactiveUserFilter = "";
	if (!empty($inactiveList)){
		foreach($inactiveList as $inactive){
			$inactives[] = $inactive["userid"];
		}
		$list = implode(",", $inactives);
		$inactiveUserFilter = " and pe.userid NOT IN ($list)";
	}
	
	if(($keyword != NULL)&&($keyword_type != NULL)){
		$keyword = addslashes($keyword);
		if($keyword_type == 'id'){
			if(strpos($keyword,',')){
				$userids = explode(',',$keyword);
				
				$keyword_filter = ' and (';
				$count = 1;
				foreach($userids as $userid){
					$keyword_filter .= " pe.userid='".trim($userid)."' ";
					if($count < count($userids)){
						$keyword_filter .= " or ";
					}
					$count++;
				}
				$keyword_filter .= " )";
			}
			else{
				$keyword_filter = " and pe.userid='".$keyword."' ";  
			}
		}
		
		if($keyword_type == 'first_name'){
			$keyword_filter = " and pe.fname like '%".$keyword."%' ";
		}
		
		if($keyword_type == 'last_name'){
			$keyword_filter = " and pe.lname like '%".$keyword."%' ";
		}
		
		if($keyword_type == 'email'){
			$keyword_filter = " and pe.email like '%".$keyword."%' ";
		}
		
		if($keyword_type == 'resume_body'){
			
			$skipfields = array("id", "userid", "freshgrad", "years_worked",
								 "months_worked", "intern_status", "iday",
								 "imonth", "iyear", "intern_notice", "available_status",
								 "available_notice", "aday", "amonth", "ayear",
								 "salary_currency","expected_salary_neg");
			
			$resumeSchema = $db->fetchAll("DESCRIBE currentjob");
			$keyword_filter = " and (";
			
			if (!empty($resumeSchema)){
				$keyword_filter.=" (";
				$i = 0;
				foreach($resumeSchema as $schema){
					if (!in_array($schema["Field"], $skipfields)){
						if ($i==0){
							$keyword_filter.="";
						}else{
							$keyword_filter.=" OR ";
						}
						$keyword_filter.=" c.{$schema["Field"]} LIKE '%$keyword%'";
						$i++;
					}
				}
				$keyword_filter.=")";
			}
			
			$skipfields = array("userid", "grade");
			$resumeSchema = $db->fetchAll("DESCRIBE education");
			
			if (!empty($resumeSchema)){
				
				$sqlEdu = $db->select()->from(array("edu"=>"education"), array("userid"));
				
				$i = 0;
				foreach($resumeSchema as $schema){
					if (!in_array($schema["Field"], $skipfields)){
						if ($i==0){
							$sqlEdu->where("edu.{$schema["Field"]} LIKE '%$keyword%'");
						}else{
							$sqlEdu->orWhere("edu.{$schema["Field"]} LIKE '%$keyword%'");
						}
						$i++;
					}
				}
				$sqlEdu->having("userid IS NOT NULL");
				
				$ids = $db->fetchAll($sqlEdu);
				$temps = array();
				foreach($ids as $id){
					$temps[] = $id["userid"];
				}
				if (!empty($temps)){
					$temps = implode(",", $temps);
					$keyword_filter.=" OR (pe.userid IN ($temps))";
				}
				
			}
			
			$keyword_filter.=")";
		}
		
		if($keyword_type == 'evaluation_notes'){		  

			$select_enotes = "SELECT distinct userid
				FROM evaluation_comments
				where comments like '%".$keyword."%'";
			$enotes = $db->fetchAll($select_enotes);
			
			$enotes_user = array();
			foreach($enotes as $enote){
				$enotes_user[] = $enote['userid'];
			}
			
			$keyword_filter = " and pe.userid in ('".implode("','",$enotes_user)."') AND pe.userid <> 0 ";
		}
		
		if($keyword_type == 'skills'){

			$skill_filter = "";
			
			$skill_keywords = '';
			if(strpos($keyword,',')){
			
				$skill_keywords = array_filter(explode(',',strtolower($keyword)));
				$count = 1;
				foreach($skill_keywords as $skill_keyword){
					$skill_filter .= " '%".trim($skill_keyword)."' ";
					if($count < count($skill_keywords)){
						$skill_filter .= " or skill LIKE ";
					}
					$count++;
				}
				
			}else{
				$skill_filter = " '%".$keyword."' ";
			}
			
			$skill_select_1 = "SELECT userid
				FROM `skills_myisam`
				where skill LIKE ".$skill_filter;
			
			$skill_filter = "";
			if(strpos($keyword,',')){
				$skill_filter = "'";
				$skill_keywords = array_filter(explode(',',$keyword));
				$count = count($skill_keywords);
				foreach($skill_keywords as $skill_keyword){
					$skill_filter .= " +".trim($skill_keyword)." ";
				}
				$skill_filter.="'";
			}else{
				$skill_filter = " '+".$keyword."' ";
			}
			
			$skill_filter = trim($skill_filter);
			$skill_select_2 = "SELECT userid
				FROM `skills_myisam` WHERE MATCH(skill) AGAINST($skill_filter IN BOOLEAN MODE)";
			
			$skill_select = $skill_select_1." UNION ".$skill_select_2;
			
			
			//echo $skill_select;
			$skill_rows = $db->fetchAll($skill_select); 
			
			
			$skill_user = array();
			foreach($skill_rows as $skill_row){
				$skill_user[] = $skill_row['userid'];
			}
			
			$keyword_filter = " and pe.userid in ('".implode("','",$skill_user)."')  AND (SELECT COUNT(*) FROM skills s WHERE s.userid = pe.userid) > 0 ";
			
		}
		
		if($keyword_type == 'notes'){
						
			$notes_select = "SELECT userid
				FROM applicant_history
				where actions='NOTES'
				and history like '%".$keyword."%'";
			$notes_rows = $db->fetchAll($notes_select); 
			
			$notes_user = array();
			foreach($notes_rows as $notes_row){
				$notes_user[] = $notes_row['userid'];
			}
			
			$keyword_filter = " and pe.userid in ('".implode("','",$notes_user)."') AND pe.userid <> 0 ";
		}
		
		if ($keyword_type=="mobile"){
			$words = explode("+",$keyword);
			if (count($words)==1){
				$keyword_filter = " and pe.handphone_no LIKE '%{$keyword}%' ";
			}else{
				$keyword_filter = " and (CONCAT(pe.handphone_country_code,'+',pe.handphone_no) LIKE '%{$keyword}%') ";
			}
		}
		
		
	}
	$login_filter = "";
	if ($_REQUEST["date_last_login_start"]&&$_REQUEST["date_last_login_end"]){
		$login_filter = " and DATE(pu.last_login) >= DATE('".addslashes($_REQUEST["date_last_login_start"])."') AND DATE(pu.last_login) <= DATE('".addslashes($_REQUEST["date_last_login_end"])."') ";
	}
	$select_start = '';
	$selectCountQuery = "";
	
	if( $posting != ''){
		$select_start = 'select SQL_CALC_FOUND_ROWS a.userid,p.id,a.status,c.latest_job_title,ad.admin_fname,ad.admin_lname,
			pe.userid, pe.userid AS the_user, pe.fname,pe.lname,pe.email,pe.voice_path,pe.skype_id,pe.yahoo_id,pe.datecreated,pe.dateupdated,pe.permanent_residence, end.date_endoesed AS date_endorse 
			from tb_endorsement_history as end 
			left join posting AS p on end.position = p.id 
			left join applicants AS a on a.posting_id = end.position 
			inner join personal AS pe FORCE INDEX (PRIMARY) on pe.userid = end.userid 
			left join personal_user_logins AS pu on pu.userid = pe.userid 
			left join currentjob AS c on c.userid = end.userid
			left join leads AS l on l.id = end.client_name ';
		$selectCountQuery = "SELECT pe.userid 
			from tb_endorsement_history as end on end.userid = pe.userid 
			left join posting AS p on end.position = p.id 
			left join applicants AS a on a.posting_id = end.position 
			inner join personal AS pe FORCE INDEX (PRIMARY) on pe.userid = end.userid 
			left join personal_user_logins AS pu on pu.userid = pe.userid 
			left join currentjob AS c on c.userid = end.userid
			left join leads AS l on l.id = end.client_name  ";
	}
	else{
		$select_start = 'select SQL_CALC_FOUND_ROWS c.latest_job_title,ad.admin_fname,ad.admin_lname,
			pe.userid,pe.fname,pe.lname,pe.email,pe.voice_path,pe.skype_id,pe.yahoo_id,pe.datecreated,pe.dateupdated,pe.permanent_residence, end.date_endoesed AS date_endorse 
			from tb_endorsement_history end  
		    left join personal as pe FORCE INDEX (PRIMARY) on pe.userid=end.userid 
		    left join personal_user_logins AS pu on pu.userid = pe.userid 
		    left join currentjob as c on pe.userid=c.userid 
		    left join leads AS l on l.id = end.client_name ';
		$selectCountQuery = "SELECT pe.userid from tb_endorsement_history end  
		    left join personal as pe FORCE INDEX (PRIMARY) on pe.userid=end.userid 
		    left join personal_user_logins AS pu on pu.userid = pe.userid 
		    left join currentjob as c on pe.userid=c.userid 
		    left join leads AS l on l.id = end.client_name ";
	
	}
	
	$pageStart = ($page-1)*$result_per_page;
	$pageEnd = $pageStart+$result_per_page;
	
	$select = "
		".$select_start."
		left join recruiter_staff as rs on pe.userid=rs.userid 
		left join admin as ad on rs.admin_id=ad.admin_id
		left join staff_resume_up_to_date as utd on pe.userid=utd.userid
		
		where pe.fname <> '' AND pe.lname <> ''  
		".$login_filter.$posting_filter.$availability_filter.$reg_date_filter.$update_date_filter.$recruiter_filter.$keyword_filter.$country_filter.$lead_filter.$inactiveUserFilter.$region_filter.$city_filter.$endorsed_date_filter."
		group by pe.userid 
		order by pe.datecreated desc 
		";
	
	$updatedSelect = $selectCountQuery."
		left join recruiter_staff as rs on pe.userid=rs.userid
		left join admin as ad on rs.admin_id=ad.admin_id
		left join staff_resume_up_to_date as utd on pe.userid=utd.userid
		
		where pe.fname <> '' AND pe.lname <> ''  
		".$login_filter.$posting_filter.$availability_filter.$reg_date_filter.$update_date_filter.$recruiter_filter.$keyword_filter.$country_filter.$lead_filter.$inactiveUserFilter.$region_filter.$city_filter.$endorsed_date_filter.
		"group by pe.userid 
		order by pe.datecreated desc 
		";
	$select.=" limit ".($pageStart).",".$pageEnd;
	
	if($_REQUEST["mass_email"] == "on" && $_SESSION["mass_email_status"] == "waiting"){
		$results = $db_query_only->fetchAll($updatedSelect); 
	}else{
		$results = $db_query_only->fetchAll($select); 
		$total = $db_query_only->fetchOne('select FOUND_ROWS()');
	}
	
	$massStaff = array();
	foreach ($results as $key=>$result){ 
		if($_REQUEST["mass_email"] == "on" && $_SESSION["mass_email_status"] == "waiting"){
			$massStaff[] = $results[$key]['userid'];
			continue;
		}
		
		$select2 = "SELECT skill FROM skills where userid='".$result['userid']."'";
		$rows = $db->fetchAll($select2); 
		
		$results[$key]['skills'] = array();
		foreach($rows as $row){ 
			$skill = $row['skill'];
			$results[$key]['skills'][] = $skill; 
		}
		
		$results[$key]['hot'] = 0;
		$select2 = "SELECT id FROM hot_staff WHERE userid='".$result['userid']."' LIMIT 1";
		$row2 = $db->fetchRow($select2); 
		if($row2 != NULL){
			$results[$key]['hot'] = 1;
		}
		
		$results[$key]['exp'] = 0;
		$select2 = "SELECT id FROM experienced_staff WHERE userid='".$result['userid']."' LIMIT 1";
		$row2 = $db->fetchRow($select2); 
		if($row2 != NULL){
			$results[$key]['exp'] = 1;
		}
		//load endorsement of staff
		$results[$key]["endorsements"] = getEndorsement($results[$key]['userid']);
		$results[$key]["date_endorse"] = date("Y-m-d", strtotime($results[$key]["date_endorse"]));
		$results[$key]['datecreated'] = substr($results[$key]['datecreated'],0,10);
		$results[$key]['status'] =  getStaffStatus($result['userid']);
		$results[$key]["special_id"] = "";
	}
	
	//START: update emailing list
	$max = $db->fetchOne($db->select()->from(array("sm"=>"staff_mass_mail_logs"), array(new Zend_Db_Expr("MAX(batch) AS batch")))->where("admin_id = ?", $_SESSION["admin_id"]));
	if (!$max){
		$max = 1;
	}else{
		$max = $max+1;
	}
	if($_REQUEST["mass_email"] == "on" && $_SESSION["mass_email_status"] == "waiting"){
		//start: insert to emailing list
		if (!empty($massStaff)){
			//mysql_query("UPDATE personal SET mass_emailing_status='DO NOTHING'");
			$AusDate = date("Y")."-".date("m")."-".date("d");
			$AusTime = date("h:i:s");
			$selectedStaff = implode(",", $massStaff);
			$updateQuery = "waiting = 1 AND finish = 0 AND DATE(date_created) = {$AusDate} AND userid NOT IN($selectedStaff) AND admin_id = ".$_SESSION["admin_id"];
			$db->update("staff_mass_mail_logs", array("finish"=>1), $updateQuery);
			
			foreach($massStaff as $staff){
				$data = array("waiting"=>1, "userid"=>$staff, "date_created"=>$AusDate." ".$AusTime, "date_updated"=>$AusDate." ".$AusTime, "batch"=>$max, "admin_id"=>$_SESSION["admin_id"]);
				//$result = $db->fetchRow($db->select()->from("staff_mass_mail_logs")->where("userid = ?", $staff)->where("finish = 0")->where("DATE(date_created) = ?", $AusDate));
				$db->insert("staff_mass_mail_logs", $data);
			}
			//$db->update("personal", $data, "userid IN ($massStaff)");
			$_SESSION["mass_email_status"] = "executed";
			//ended: insert to emailing list
			header("location: staff_mass_emailing_new.php"); 
			exit;
		}
	}
	
	//return $results;
	return array('applicants'=>$results,'total'=>$total);
}

$positions_advertized = getPositionsAdvertized();
$positions_advertized_options = '<option value=""> Select Positions Advertized </option>';
if ($posting=="All"){
	$positions_advertized_options .= '<option value="All" selected> View All with Job Applications </option>';
}else{
	$positions_advertized_options .= '<option value="All"> View All with Job Applications </option>';
}

foreach($positions_advertized as $position){

	$is_selected = '';
	if($posting == $position['id']){
		$is_selected = 'selected';
	}
	
	$positions_advertized_options .= '<option value="'.$position['id'].'" '.$is_selected.'>'.$position['fname'].' '.$position['lname']." - ".$position['jobposition'].'</option>'; 
}

//get recruiters list
$recruiters = getRecruiters();
$recruiters_option = "<option value=''>All Recruiters</option>";
foreach($recruiters as $recruiter_option){
	
	if($recruiter_option['admin_id'] == $_GET['recruiter']){
		$recruiters_option .= "<option value='".$recruiter_option['admin_id']."' selected >".$recruiter_option['admin_fname'].' '.$recruiter_option['admin_lname']."</option>";
	}
	else{
		$recruiters_option .= "<option value='".$recruiter_option['admin_id']."' >".$recruiter_option['admin_fname'].' '.$recruiter_option['admin_lname']."</option>";
	}
}
if ($_GET['recruiter']=="NR"){
	$recruiters_option.="<option value='NR' selected>No Assigned Recruiter</option>";
}else{
	$recruiters_option.="<option value='NR'>No Assigned Recruiter</option>";
}



$recruiters_option_no_former = "<option value=''>All Recruiters</option>";
foreach($recruiters as $recruiter_option){
	if ($recruiter_option["admin_id"]==67){
		continue;
	}
	if($recruiter_option['admin_id'] == $_GET['recruiter']){
		$recruiters_option_no_former.= "<option value='".$recruiter_option['admin_id']."' selected >".$recruiter_option['admin_fname'].' '.$recruiter_option['admin_lname']."</option>";
	}
	else{
		$recruiters_option_no_former .= "<option value='".$recruiter_option['admin_id']."' >".$recruiter_option['admin_fname'].' '.$recruiter_option['admin_lname']."</option>";
	}
}




$recruitmentTeams = getRecruitmentTeams();
$recruitmentTeamOptions = "<option value=''>All Recruitment Team</option>";
foreach($recruitmentTeams as $recruitmentTeam){
	if ($recruitmentTeam["id"]==$recruitment_team_id){
		$recruitmentTeamOptions.="<option value='{$recruitmentTeam["id"]}' selected>{$recruitmentTeam["team"]}</option>";
	}else{
		$recruitmentTeamOptions.="<option value='{$recruitmentTeam["id"]}'>{$recruitmentTeam["team"]}</option>";
	}
}


$result = getApplicants($posting,$page,$date_start,$date_end,$updated_date_start,$updated_date_end,$recruiter,$keyword,$keyword_type,$country,$lead_id, $lead_name, $recruitment_team_id);



$total_result = $result['total'];
$pages_num = ceil($total_result / $result_per_page);

//pagination dropdown
$pagination = "<option value=''> - </option>";
for($i=1; $i<=$pages_num; $i++ ){
	$selected = '';
	if($i == $page) $selected = 'selected';
	$pagination .= '<option value="'.$i.'" '.$selected.'> '.$i.' </option>';
}

//pagination dropdown
$result_per_page_option = "<option value=''> - </option>";
$i=50;
while($i<=250){
	$selected = '';
	if($i == $result_per_page) $selected = 'selected';
	$result_per_page_option .= '<option value="'.$i.'" '.$selected.'> '.$i.' </option>';
	$i=$i+50;
}


//generate country options
$country_options = '<option value="">All</option>';
$countries = array('PH'=>'Philippines','CN'=>'China','IN'=>'India');
foreach($countries as $key=>$country_option){
	$selected = '';
	if($key == $country) $selected = 'selected ';
	$country_options .= '<option value="'.$key.'" '.$selected.'>'.$country_option.'</option>';
}

//generate ph state options
$ph_states_array=array('Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Reg','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas');
$ph_states_code = array("AR", "BR", "CA", "CG", "CL", "CM", "CR", "CV", "EV", "IL", "NC", "NM", "SM", "ST", "WM", "WV");
$ph_state_options = "<option value=''>Please Select</option>";
for($i=0; $i<count($ph_states_array); $i++){
	if($selected_region == $ph_states_code[$i]){
		$ph_state_options .= "<option value=\"".$ph_states_code[$i]."\" selected>".$ph_states_array[$i]."</option>";
	}else{
		$ph_state_options .= "<option value=\"".$ph_states_code[$i]."\">".$ph_states_array[$i]."</option>";
	}
}



//generate availability status

//$pagination_sliding
$total_result = $result['total'];
$pageStart = ($page-1)*$result_per_page;
$pageEnd = $pageStart+$result_per_page;

if ($pageEnd>$total_result){
	$pageEnd = $total_result;
}


$pages_num = ceil($total_result / $result_per_page);
if ($pages_num>10){
	$pagination_links_num = 10;
	$pagination_links_num_half = $pagination_links_num / 2;
}else{
	$pagination_links_num = $pages_num;
	$pagination_links_num_half = $pagination_links_num / 2;
}
$params = "&posting=".$posting."&date_start=".$date_start."&date_end=".$date_end."&"."updated_date_start=".$updated_date_start."&"."recruiter=".$recruiter."&"."keyword=".$keyword."&"."keyword_type=".$keyword_type."&"."country=".$country."&result_per_page=".$result_per_page."&selected_region=".$selected_region."&selected_city=".$selected_city."&staff_status=$staff_status";
		

if(($page >= $pagination_links_num) && ($page <= ($pages_num - $pagination_links_num_half))){
	$start = $page - $pagination_links_num_half + 1;
	if ($start==0){
		$start = 1;
	}
	$end = $page;
	for ($i=$page;$i<$page+$pagination_links_num_half;$i++){
		if ($i==$pages_num){
			break;
		}
		$end++;
	}
}
else{
	if($page < $pagination_links_num){
		$start = 1;
		$end = $pagination_links_num;
	}
	else{
		$start = $pages_num - $pagination_links_num;
		if ($start==0){
			$start = 1;
		}
		$end = $pages_num;
	}
}
				
if(($page >= $pagination_links_num) && ($page <= ($pages_num - $pagination_links_num_half))){
	$start = $page - $pagination_links_num_half + 1;
	$end = $page;
	for ($i=$page;$i<$page+$pagination_links_num_half;$i++){
		if ($i==$pages_num){
			break;
		}
		$end++;
	}
	//$end = $page + $pagination_links_num_half ;
}
else{
	if($page < $pagination_links_num){
		$start = 1;
		$end = $pagination_links_num;
	}
	else{
		$start = $pages_num - $pagination_links_num;
		$end = $pages_num;
	}
}
$pagination_sliding = '';
if($total_result > $result_per_page){
			
	$pagination_sliding .= '<div class="pagination" style="display:inline-block">';
				
	if($page > 1){
		$pagination_sliding .= '<a href="recruiter_search.php?page='.($page-1).$params.'" style="text-decoration:none;" >&lt;&lt; Previous</a> | ';
	}
				
	if ($start==0){
		$start=1;
	}
	
	for($i=$start; $i<=$end; $i++){
							
		if($i == $page){
			$class = 'text-decoration:underline;font-weight:bold;';
		}
		else{
			$class = 'text-decoration:none;';
		}
								
		$pagination_sliding .= '<a href="recruiter_search.php?page='.($i).$params.'" style="'.$class.'" >'.$i.'</a> ';
								
		if($i != $end){
			$pagination_sliding .= ' | ';
		}
	}
				
	if($page < $pages_num){
		$pagination_sliding .= ' | <a href="recruiter_search.php?page='.($page+1).$params.'" style="text-decoration:none;" >Next &gt;&gt;</a>';
	}
				
	$pagination_sliding .= '</div>';
}
if ($result['total']>10000){
	$limitedTotal = 10000;
}else{
	$limitedTotal = $result['total'];
}


//availability inputs
$options = "<option value=''></option>";
for($i=1;$i<=11;$i++){
	if ($i==$_GET["available_notice"]){
		$options.="<option value='{$i}' selected>$i</option>";	
	}else{
		$options.="<option value='{$i}'>$i</option>";		
	}

}

$smarty->assign("available_notice_options", $options);

//for the radio box in search
$available_status = $_GET["available_status"];
if ($available_status=="a"){
	$a_selected = "checked";
	$b_selected = "";
	$p_selected = "";
	$w_selected = "";
}else if ($available_status=="b"){
	$a_selected = "";
	$b_selected = "checked";
	$p_selected = "";
	$w_selected = "";
}else if ($available_status=="p"){
	$a_selected = "";
	$b_selected = "";
	$p_selected = "checked";
	$w_selected = "";
}else if ($available_status=="Work Immediately"){
	$a_selected = "";
	$b_selected = "";
	$p_selected = "";
	$w_selected = "checked";
}
$smarty->assign("a_selected", $a_selected);
$smarty->assign("b_selected", $b_selected);
$smarty->assign("p_selected", $p_selected);
$smarty->assign("w_selected", $w_selected);


$smarty->assign("recruiter_options_no_former", $recruiters_option_no_former);

$smarty->assign("ph_state_options", $ph_state_options);
$smarty->assign("selected_city", $selected_city);
$smarty->assign("endorsed_date_start", $endorsed_date_start);
$smarty->assign("endorsed_date_end", $endorsed_date_end);
$smarty->assign("limitedTotal", $limitedTotal);
$smarty->assign("pageStart", $pageStart);
$smarty->assign("pageEnd", $pageEnd);
$smarty->assign("staff_status", $staff_status);
$smarty->assign("params", $params);
$smarty->assign('positions_advertized_options', $positions_advertized_options); 
$smarty->assign('recruiters_option', $recruiters_option);
$smarty->assign("recruitment_team_options", $recruitmentTeamOptions);
$smarty->assign('country_options', $country_options);
$smarty->assign('result', $result['applicants']);
$smarty->assign('total', $result['total']);
$smarty->assign('pagination', $pagination);
$smarty->assign('pagination_sliding', $pagination_sliding);
$smarty->assign('result_per_page_option', $result_per_page_option);
$smarty->assign('date_start', $date_start);
$smarty->assign('date_end', $date_end);
$smarty->assign('page', $page);
$smarty->assign('result_per_page', $result_per_page);
$smarty->assign('updated_date_start', $updated_date_start);
$smarty->assign('updated_date_end', $updated_date_end);
$smarty->assign('get', $_GET);
$smarty->display('recruiter_search_endorsed.tpl'); 