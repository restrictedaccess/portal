<?php
//putenv("TZ=Philippines/Manila") ;
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

date_default_timezone_set("Asia/Manila");
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


//echo $from_month." ".$from_year."<br>".$to_month." ".$to_year."<hr>";
//$start_date_str =  date("Y-m-d", strtotime($from_year."-".$from_month."-01"));
//echo $start_date_str."<hr>";

$date = new DateTime();
$date->setDate($from_year, $from_month, '01');
$start_date_str = $date->format("Y-m");
//echo $start_date_str."<br>";


$date2 = new DateTime();
$date2->setDate($to_year, $to_month, '01');
$end_date = $date2->format("Y-m");
$date2->modify("+1 month");
$end_date_str = $date2->format("Y-m");
//echo $end_date_str."<br>";

$file_search = sprintf('from_%s_to_%s', $start_date_str, $end_date );

$DATE_SEARCH=array();
$random_string_exists = True;
while ($random_string_exists) {
	//$DATE_SEARCH[] = $date->format("Y-m-d");
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

$conditions .= " AND s.status IN ('ACTIVE', 'terminated', 'resigned', 'suspended')";
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
		
	if($_POST['service_type']){
	    $conditions .= " AND s.service_type = '".$_POST['service_type']. "'";
	}
	
	if($_POST['business_partner_id']){
	    $conditions .= " AND l.business_partner_id = '".$_POST['business_partner_id']. "'";
	}
	
	if($_POST['recruiter']){
		$conditions .= " AND rs.admin_id = '".$_POST['recruiter']. "'";
	}
	
	if($_POST['status']){
		if($_POST['status'] == 'ACTIVE'){
	        $conditions .= " AND s.status IN ('ACTIVE', 'suspended') ";
		}
		
		if($_POST['status'] == 'INACTIVE'){
	        $conditions .= " AND  s.status IN ('terminated', 'resigned') ";
		}
	}
	
	//if($_POST['include_inhouse_staff'] == 'no'){
	//	$conditions .= " AND s.leads_id != 11 ";
	//}
	
}
$url_link = sprintf('&hm=%s&csro=%s&work_status=%s&status=%s&recruiter=%s&business_partner_id=%s&include_inhouse_staff=%s',$_POST['hm'], $_POST['csro'],$_POST['work_status'],$_POST['status'],$_POST['recruiter'], $_POST['business_partner_id'], $_POST['include_inhouse_staff']);

$SEARCH_RESULTS =array();
$total_num_count_asl=0;
$total_num_count_back_order=0;
$total_num_count_replacement=0;
$total_num_count_customs =0;
$total_num_count_inhouse=0;
$total_num_count_project_based=0;
$total_num_count_trial=0;

foreach($DATE_SEARCH as $date_search_str){
	$date = new DateTime($date_search_str);
	$start_date_search_str = $date->format("Y-m-01");
	$finish_date_search_str = $date->format("Y-m-t");
	//echo sprintf('%s => %s<br>' , $start_date_search_str, $finish_date_search_str ) ;
	
	$data['date_search_str'] = $date_search_str;
	
	//service_type=ASL
    $sql = "SELECT COUNT(s.id)AS num_count_asl  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='ASL'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	//echo $sql."<br>";
	$num_count_asl = $db->fetchOne($sql);
	$data['num_count_asl'] = $num_count_asl;
	$total_num_count_asl = $total_num_count_asl + $num_count_asl;
	
	//service_type=Back Order
    $sql = "SELECT COUNT(s.id)AS num_count_back_order  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Back Order'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_back_order = $db->fetchOne($sql);
	//echo $sql."<br>";
	$data['num_count_back_order'] = $num_count_back_order;
	$total_num_count_back_order = $total_num_count_back_order + $num_count_back_order;
	
	
	//service_type=Replacement
    $sql = "SELECT COUNT(s.id)AS num_count_replacement  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Replacement'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_replacement = $db->fetchOne($sql);
	//echo $sql."<br>";
	$data['num_count_replacement'] = $num_count_replacement;
    $total_num_count_replacement = $total_num_count_replacement + $num_count_replacement;	
	
	//service_type=Customs
    $sql = "SELECT COUNT(s.id)AS num_count_customs  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Customs'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_customs = $db->fetchOne($sql);
	//echo $sql."<br>";
	$data['num_count_customs'] = $num_count_customs;
	$total_num_count_customs = $total_num_count_customs + $num_count_customs;
	
	if($_POST['include_inhouse_staff'] == 'yes'){
		//service_type=Inhouse
		$sql = "SELECT COUNT(s.id)AS num_count_inhouse  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Inhouse'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
		$num_count_inhouse = $db->fetchOne($sql);
		//echo $sql."<br>";
		$data['num_count_inhouse'] = $num_count_inhouse;
		$total_num_count_inhouse = $total_num_count_inhouse + $num_count_inhouse;
	}
	
	//service_type=Project Based
    $sql = "SELECT COUNT(s.id)AS num_count_inhouse  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Project Based'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	//echo $sql."<br>";
	$num_count_project_based = $db->fetchOne($sql);
	$data['num_count_project_based'] = $num_count_project_based;
    $total_num_count_project_based = $total_num_count_project_based + $num_count_project_based;
	
	//service_type=Trial
    $sql = "SELECT COUNT(s.id)AS num_count_inhouse  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Trial'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	//echo $sql."<br>";
	$num_count_trial = $db->fetchOne($sql);
	$data['num_count_trial'] = $num_count_trial;
    $total_num_count_trial = $total_num_count_trial + $num_count_trial;
	
	
	$data['num_count'] = $num_count_asl + $num_count_back_order + $num_count_replacement + $num_count_customs + $num_count_inhouse + $num_count_project_based + $num_count_trial;
	$total_num_count = $total_num_count + $data['num_count']; 
	array_push($SEARCH_RESULTS, $data);

}
/*
echo "<pre>";
echo count($SEARCH_RESULTS)."<BR>";
print_r($SEARCH_RESULTS);
echo "</pre>";
exit;
*/
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

$smarty->assign('bp_Options',$bp_Options);
$smarty->assign('recruiter_Options',$recruiter_Options);
$smarty->assign('total_num_count_asl', $total_num_count_asl);
$smarty->assign('total_num_count_back_order', $total_num_count_back_order);
$smarty->assign('total_num_count_replacement', $total_num_count_replacement);
$smarty->assign('total_num_count_customs', $total_num_count_customs);
$smarty->assign('total_num_count_inhouse', $total_num_count_inhouse);
$smarty->assign('total_num_count_project_based', $total_num_count_project_based);
$smarty->assign('total_num_count_trial', $total_num_count_trial);


$smarty->assign('total_num_count', $total_num_count);


$smarty->assign('from_month',$from_month);
$smarty->assign('from_year',$from_year);
$smarty->assign('to_month',$to_month);
$smarty->assign('to_year',$to_year);
$smarty->assign('work_status', $_POST['work_status']);
$smarty->assign('reason_type', $_POST['reason_type']);
$smarty->assign('service_type', $_POST['service_type']);
$smarty->assign('status', $_POST['status']);
$smarty->assign('include_inhouse_staff', $_POST['include_inhouse_staff']);

$smarty->assign('STATUS', Array('ACTIVE', 'INACTIVE'));
$smarty->assign('MONTH_NUMBERS',$MONTH_NUMBERS);
$smarty->assign('MONTH_NAMES',$MONTH_NAMES);
$smarty->assign('YEARS', $YEARS);
$smarty->assign('WORK_STATUS', Array('Full-Time', 'Part-Time'));
$smarty->assign('ANSWERS', Array('yes', 'no'));
$smarty->assign('SERVICE_TYPE',$SERVICE_TYPE);

$smarty->assign('SEARCH_RESULTS', $SEARCH_RESULTS);
$smarty->assign('url_link', $url_link);

$smarty->assign('hm_Options', $hm_Options);
$smarty->assign('csro_Options', $csro_Options);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->display('new_hires_reporting.tpl');
?>