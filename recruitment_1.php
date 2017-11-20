<?php
mb_language('uni'); 
mb_internal_encoding('UTF-8');
include('conf/zend_smarty_conf.php');
include ('./leads_information/AdminBPActionHistoryToLeads.php');
include 'config.php';
include 'function.php';
include 'conf.php';

header('Content-type: text/html; charset=utf-8');

$smarty = new Smarty;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$update_page ="updateinquiry.php";
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$update_page ="admin_updateinquiry.php";

}else{
	header("location:index.php");
}

$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}

$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';


//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);		
$leads_of = checkAgentAffiliates($leads_id);
$date_registered = format_date($leads_info['timestamp']);
$name =  $leads_info['fname']." ".$leads_info['lname'];


//LEADS RATINGS
$rating = $leads_info['rating'];
if($rating == "") $rating =0;
for($i=0; $i<=5;$i++){
	//rate
	if($leads_info['rating'] == $i){
		$rate_Options .="<option value=".$i." selected='selected'>".$i."</option>";
	}else{
		$rate_Options .="<option value=".$i.">".$i."</option>";
	}	
}
//stars to be displayed
for($i=1; $i<=$rating;$i++){
	$starOptions.='<img src="images/star.png" align="top">';
}

//START: generate job advertisements applicants
$bgcolor="#FFFFFF";
$q="SELECT p.id, p.date_created, p.companyname, p.jobposition, p.job_order_id
FROM posting p WHERE p.lead_id='$leads_id' AND p.status='ACTIVE' GROUP BY p.id";
$job_advertisement_applicants_set = Array();
$ja = $db->fetchAll($q);	
foreach($ja as $row)
{
	$job_advertisement_applicants['id']=$row["id"];
	$job_advertisement_applicants['date_created']=$row["date_created"];
	$job_advertisement_applicants['companyname']=$row["companyname"];
	$job_advertisement_applicants['jobposition']=$row["jobposition"];
    $job_advertisement_applicants['job_order_id']=$row["job_order_id"];
	$job_advertisement_applicants['bgcolor']=$bgcolor;
	
	//start: get UNPROCESSED total
	$total_number_of_unprocessed = 0;
	$sql = "SELECT DISTINCT(a.userid) FROM unprocessed_staff u, applicants a
	WHERE a.posting_id='".$row["id"]."' AND a.userid = u.userid";
	$t = $db->fetchAll($sql);	
	$total_number_of_unprocessed = count($t);
	//ended: get UNPROCESSED total
	
	//start: get PRE-SCREENED total
	$total_number_of_pre_screened = 0;
	$sql = "SELECT DISTINCT(a.userid) FROM pre_screened_staff u, applicants a
	WHERE a.posting_id='".$row["id"]."' AND a.userid = u.userid";
	$t = $db->fetchAll($sql);	
	$total_number_of_pre_screened = count($t);
	//ended: get PRE-SCREENED total
	
	//start: get SHORTLISTED total
	$total_number_of_shortlisted = 0;
	//$sql = "SELECT DISTINCT(userid) FROM tb_shortlist_history WHERE position = {$row["id"]}";
	$sql = $db->select()->distinct()->from(array("sh"=>"tb_shortlist_history"), array("userid"))->where("position = ?", $row["id"]);
	$total_number_of_shortlisted = count($db->fetchAll($sql));
	//ended: get SHORTLISTED total
	
	//start: get INACTIVE total
	$total_number_of_inactive_staff = 0;
	$sql = "SELECT DISTINCT(a.userid) FROM inactive_staff u, applicants a
	WHERE a.posting_id='".$row["id"]."' AND a.userid = u.userid";
	$t = $db->fetchAll($sql);	
	$total_number_of_inactive_staff = count($t);
	//ended: get INACTIVE total
	
	//start: get endorsed total
	$total_number_of_endorsed = 0;
	/*
	$sql = "SELECT DISTINCT(a.userid) FROM tb_endorsement_history e, applicants a
	WHERE a.posting_id='".$row["id"]."' AND a.userid = e.userid";
	*/
	$sql = $db->select()->distinct()
			->from(array("end"=>"tb_endorsement_history"), array("end.userid"))
			->where("end.position = ?", $row["id"]);
	
	$t = $db->fetchAll($sql);	
	$total_number_of_endorsed = count($t);
	//ended: get endorsed total
	
	//start: get ON ASL total
	$total_number_on_of_asl = 0;
	$sql = "SELECT DISTINCT(ap.userid) FROM job_sub_category_applicants a, applicants ap
	WHERE ap.posting_id='".$row["id"]."' AND ap.userid = a.userid AND a.ratings = 0";
	$t = $db->fetchAll($sql);	
	$total_number_on_of_asl = count($t);
	//ended: get ON ASL total
		
	$job_advertisement_applicants['total_number_of_unprocessed'] = $total_number_of_unprocessed;
	$job_advertisement_applicants['total_number_of_pre_screened'] = $total_number_of_pre_screened;
	$job_advertisement_applicants['total_number_of_shortlisted'] = $total_number_of_shortlisted;
	$job_advertisement_applicants['total_number_of_inactive_staff'] = $total_number_of_inactive_staff;
	$job_advertisement_applicants['total_number_of_endorsed'] = $total_number_of_endorsed;
	$job_advertisement_applicants['total_number_on_of_asl'] = $total_number_on_of_asl;

	$job_advertisement_applicants_set[]=$job_advertisement_applicants;
	if($bgcolor=="#f5f5f5") { $bgcolor="#FFFFFF"; }
	else { $bgcolor="#f5f5f5"; }	
}
//ENDED: generate job advertisements applicants


$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}

$smarty->assign('job_advertisement_applicants_set', $job_advertisement_applicants_set);
$smarty->assign('agent_section',$_SESSION['agent_no']);
$smarty->assign('admin_section',$_SESSION['admin_id']);
$smarty->assign('admin_status',$admin_status);
$smarty->assign('page_type',$page_type);
$smarty->assign('update_page',$update_page);
$smarty->assign('url' ,$url);
$smarty->assign('leads_id',$leads_id);
$smarty->assign('lead_status' , $lead_status);
$smarty->assign('starOptions' , $starOptions);
$smarty->assign('rate_Options' , $rate_Options);
$smarty->assign('leads_info', $leads_info);
$smarty->assign('date_registered' , $date_registered);
$smarty->assign('leads_of' , $leads_of);
$smarty->assign('leads_info' , $smarty->fetch('leads_info.tpl'));
$smarty->display('recruitment_1.tpl');
?>