<?php
include './conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	header("location:index.php");
	exit;
}

header("location:/portal/django/subcontractors/cancellation_dashboard/");
exit;

$MONTH_NUMBERS = array('01','02','03','04','05','06','07','08','09','10','11','12');
$MONTH_NAMES = array('January','February','March','April','May','June','July','August','September','October','November','December');
$YEARS=array();
for($i=2008; $i<=date('Y'); $i++){
	$YEARS[]=$i;
}

$from_month = $_POST['from_month'];
$from_year = $_POST['from_year'];

$to_month = $_POST['to_month'];
$to_year = $_POST['to_year'];

if($from_month == ""){
	$from_month = date("m");
}

if($from_year == ""){
	$from_year = date("Y");
}

if($to_month == ""){
	$to_month = date("m");
}

if($to_year == ""){
	$to_year = date("Y");
}

$date = new DateTime();
$date->setDate($from_year, $from_month, '01');
$start_date_str = $date->format("Y-m");
//echo $start_date_str."<br>";


$date2 = new DateTime();
$date2->setDate($to_year, $to_month, '01');
$end_date = $date->format("Y-m");
$date2->modify("+1 month");
$end_date_str = $date2->format("Y-m");
//echo $end_date_str."<br>";

$file_search = sprintf('from_%s_to_%s', $start_date_str, $end_date );

$DATE_SEARCH=array();
$random_string_exists = True;
while ($random_string_exists) {
    if($start_date_str != $end_date_str){
	    $DATE_SEARCH[] = $date->format("Y-m-d");
		$date->modify("+1 month");
		$start_date_str = $date->format("Y-m");
		$random_string_exists = True;
	}else{
		$random_string_exists = False;
	}
}


//echo "<pre>";
//print_r($DATE_SEARCH);
//echo "</pre>";


if (array_key_exists('_submit_check', $_POST)) {
	
	if($_POST['hm']){
	    $conditions .= " AND l.hiring_coordinator_id = '".$_POST['hm']. "'";
	}
	
	if($_POST['csro']){
	    $conditions .= " AND l.csro_id = '".$_POST['csro']. "'";
	}
	
	if($_POST['work_status']){
	    $conditions .= " AND s.work_status = '".$_POST['work_status']. "'";
	}
	
	if($_POST['reason_type']){
	    $conditions .= " AND s.reason_type = '".$_POST['reason_type']. "'";
	}
	
	if($_POST['service_type']){
	    $conditions .= " AND s.service_type = '".$_POST['service_type']. "'";
	}
	
	if($_POST['business_partner_id']){
	    $conditions .= " AND l.business_partner_id = '".$_POST['business_partner_id']. "'";
	}
	
	if($_POST['recruiter']){
		$conditions .= " AND rs.admin_id = '".$_POST['recruiter']. "'";
	}
	
}
$url_link = sprintf('&hm=%s&csro=%s&work_status=%s&reason_type=%s&service_type=%s&business_partner_id=%s&recruiter=%s',$_POST['hm'], $_POST['csro'],$_POST['work_status'], $_POST['reason_type'], $_POST['service_type'],$_POST['business_partner_id'],$_POST['recruiter']);

$SEARCH_RESULTS =array();
foreach($DATE_SEARCH as $date_search_str){
	$date = new DateTime($date_search_str);
	$start_date_search_str = $date->format("Y-m-01 00:00:00");
	$finish_date_search_str = $date->format("Y-m-t 23:59:59");
	//echo sprintf('%s => %s<br>' , $start_date_search_str, $finish_date_search_str ) ;
	
	$data['date_search_str'] = $date_search_str;
	
	//total no. of terminated contracts
    $sql = "SELECT COUNT(s.id)AS num_count_terminated  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.status = 'terminated' AND s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	//echo $sql;
    $num_count_terminated = $db->fetchOne($sql);
	$data['num_count_terminated'] = $num_count_terminated;
	
	
	//total no. of resigned contracts
    $sql = "SELECT COUNT(s.id)AS num_count_terminated  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.status = 'resigned' AND s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";";
	//echo $sql;
    $num_count_resigned = $db->fetchOne($sql);
	$data['num_count_resigned'] = $num_count_resigned;
	
	
	//total no. of replacement request
    $sql = "SELECT COUNT(s.id)AS num_count_replacement_request FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.replacement_request='yes' AND (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions."; ";
    $num_count_replacement_request = $db->fetchOne($sql);
	$data['num_count_replacement_request'] = $num_count_replacement_request;
	
	//total no. of no replacement request
    $sql = "SELECT COUNT(s.id)AS num_count_replacement_request FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.replacement_request='no' AND (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions."; ";
    $num_count_no_replacement_request = $db->fetchOne($sql);
	$data['num_count_no_replacement_request'] = $num_count_no_replacement_request;
	
	
	//total contract cancelled
    $sql = "SELECT COUNT(s.id)AS num_count_replacement_request FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions."; ";
	//echo $sql;
    $total_contract_cancelled = $db->fetchOne($sql);
	$data['total_contract_cancelled'] = $total_contract_cancelled;
		
	$data['total_contract_ended'] =  ($total_contract_cancelled - $num_count_replacement_request);
	
	
	
	array_push($SEARCH_RESULTS, $data);

}



//CSRO
$sql = "SELECT * FROM recruitment_team r WHERE team_status='active';";
$teams = $db->fetchAll($sql);
foreach($teams as $team){
    $sql = "SELECT r.admin_id, a.admin_fname, a.admin_lname FROM recruitment_team_member r JOIN admin a ON a.admin_id = r.admin_id WHERE member_position='csro' AND team_id =".$team['id'];
	//echo $sql;
	$team_members = $db->fetchAll($sql);
	foreach($team_members as $member){
		if($_POST['csro'] == $member['admin_id']){
			$csro_Options .="<option value='".$member['admin_id']."' selected='selected'>".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}else{
			$csro_Options .="<option value='".$member['admin_id']."' >".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}
	}	
}


//HIRING MANAGER
$sql = "SELECT * FROM recruitment_team r WHERE team_status='active';";
$teams = $db->fetchAll($sql);
foreach($teams as $team){
    $sql = "SELECT r.admin_id, a.admin_fname, a.admin_lname FROM recruitment_team_member r JOIN admin a ON a.admin_id = r.admin_id WHERE member_position='hiring coordinator' AND team_id =".$team['id'];
	//echo $sql;
	$team_members = $db->fetchAll($sql);
	foreach($team_members as $member){
		if($_POST['hm'] == $member['admin_id']){
			$hm_Options .="<option value='".$member['admin_id']."' selected='selected'>".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}else{
			$hm_Options .="<option value='".$member['admin_id']."' >".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}
	}	
}

$sql = "SELECT reason_type FROM reason_type;";
$reasons = $db->fetchAll($sql);
$REASON_TYPE=array();
foreach($reasons as $type){
	array_push($REASON_TYPE, $type['reason_type']);
}


$sql = "SELECT service_type FROM service_type;";
$service_types = $db->fetchAll($sql);
$SERVICE_TYPE = array();
foreach($service_types as $type){
	array_push($SERVICE_TYPE, $type['service_type']);
}


//get all active bp
$sql = "SELECT * FROM agent a WHERE status='ACTIVE' AND work_status='BP' ORDER BY fname;";
$bps = $db->fetchAll($sql);
foreach($bps as $bp){
    if($_POST['business_partner_id'] == $bp['agent_no']){
	    $bp_Options .="<option selected value='".$bp['agent_no']."'>".$bp['fname']." ".$bp['lname']."</option>";
	}else{
	    $bp_Options .="<option value='".$bp['agent_no']."'>".$bp['fname']." ".$bp['lname']."</option>";
	}
}

//recruiter
$sql = "SELECT * FROM admin a WHERE status='HR' ORDER BY admin_fname;";
$recruiters = $db->fetchAll($sql);
foreach($recruiters as $recruiter){
   	if($_POST['recruiter'] == $recruiter['admin_id']){
		$recruiter_Options .="<option value='".$recruiter['admin_id']."' selected='selected'>".sprintf('%s %s', $recruiter['admin_fname'], $recruiter['admin_lname'])."</option>";
	}else{
		$recruiter_Options .="<option value='".$recruiter['admin_id']."' >".sprintf('%s %s', $recruiter['admin_fname'], $recruiter['admin_lname'])."</option>";
	}
}

$smarty->assign('conditions', $conditions);


$smarty->assign('recruiter_Options',$recruiter_Options);
$smarty->assign('bp_Options',$bp_Options);
$smarty->assign('from_month',$from_month);
$smarty->assign('from_year',$from_year);
$smarty->assign('to_month',$to_month);
$smarty->assign('to_year',$to_year);
$smarty->assign('work_status', $_POST['work_status']);
$smarty->assign('reason_type', $_POST['reason_type']);
$smarty->assign('service_type', $_POST['service_type']);

$smarty->assign('MONTH_NUMBERS',$MONTH_NUMBERS);
$smarty->assign('MONTH_NAMES',$MONTH_NAMES);
$smarty->assign('YEARS', $YEARS);
$smarty->assign('WORK_STATUS', Array('Full-Time', 'Part-Time'));
$smarty->assign('REASON_TYPE',$REASON_TYPE);
$smarty->assign('SERVICE_TYPE',$SERVICE_TYPE);

$smarty->assign('SEARCH_RESULTS', $SEARCH_RESULTS);
$smarty->assign('url_link', $url_link);

$smarty->assign('hm_Options', $hm_Options);
$smarty->assign('csro_Options', $csro_Options);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->display('cancellation_dashboard.tpl');
?>