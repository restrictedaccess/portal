<?php
include('conf/zend_smarty_conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-Type: text/html; charset=ISO-8859-1');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	//the user is a business partner
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
	$smarty->assign('agent_section',True);
	
	

}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){
	// the user is an admin
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
	$smarty->assign('admin_section',True);	
    $admin_status=$_SESSION['status'];
}else{
	header("location:index.php");
}


include './lib/addLeadsInfoHistoryChanges.php';
include './leads_information/BuildEmailTemplate.php';
include ('./leads_information/AdminBPActionHistoryToLeads.php');

include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';
include 'steps_taken.php';



$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}


$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';
$site = $_SERVER['HTTP_HOST'];

$host = $_SERVER['HTTP_HOST'];
if($host == "localhost") $host = "remotestaff.com.au";


//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);		
	
$leads_of = checkAgentAffiliates($leads_id);
$date_registered = format_date($leads_info['timestamp']);
//



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


/*		
$sql = $db->select()
	->from(array('p' => 'personal') , array('userid' , 'fname' , 'lname'))	
	->join(array('s' => 'subcontractors') , 's.userid = p.userid' , array('s.starting_date' , 's.client_price', 's.currency_rate'))	
	->join(array('c'=> 'currentjob') , 'c.userid = p.userid' , array('latest_job_title'))
	
	->where('s.leads_id = ?' ,$leads_id)
	->where('s.status = ?' , 'ACTIVE')
	->order('fname ASC');
*/
$sql = "SELECT s.id , s.starting_date, s.currency, s.job_designation, s.client_timezone, s.client_start_work_hour, s.client_price,  p.userid, p.fname, p.lname
FROM subcontractors s
JOIN personal p ON p.userid = s.userid
WHERE s.status IN ('ACTIVE')
AND s.leads_id = ".$leads_id."
ORDER BY fname;";	
//echo $sql;	
$staffs = $db->fetchAll($sql);	
$active_staff_list = array();
foreach($staffs as $staff){
	if($leads_id == 11){
		$staff['client_price']="";
	}
    $data = array(
	    'id' => $staff['id'], 
		'starting_date' => $staff['starting_date'], 
		'currency' => $staff['currency'],
		'client_price' => $staff['client_price'], 
		'job_designation' => $staff['job_designation'], 
		'client_timezone' => $staff['client_timezone'], 
		'client_start_work_hour' => $staff['client_start_work_hour'], 
		'client_start_work_hour_str' => ConvertTime($staff['client_timezone'], $staff['client_timezone'] , $staff['client_start_work_hour']),
		'userid' => $staff['userid'], 
		'fname' => $staff['fname'], 
		'lname' => $staff['lname']
	);
	array_push($active_staff_list, $data);
	
}
	
//print_r($staff);



$sql = "SELECT s.id , s.starting_date, s.currency, s.job_designation, s.client_timezone, s.client_start_work_hour, s.status, s.resignation_date, s.date_terminated, s.client_price,  p.userid, p.fname, p.lname, s.reason , s.end_date
FROM subcontractors s
JOIN personal p ON p.userid = s.userid
WHERE  s.status IN ('terminated', 'resigned' )
AND s.leads_id = ".$leads_id."
ORDER BY fname;";
	
//echo $sql;	
$previous_staff = $db->fetchAll($sql);	
$inactive_staff_list = array();
foreach($previous_staff as $staff){
	if($leads_id == 11){
		$staff['client_price']="";
	}
    $data = array(
	    'id' => $staff['id'], 
		'starting_date' => $staff['starting_date'], 
		'currency' => $staff['currency'],
		'client_price' => $staff['client_price'], 
		'job_designation' => $staff['job_designation'], 
		'client_timezone' => $staff['client_timezone'], 
		'client_start_work_hour' => $staff['client_start_work_hour'], 
		'client_start_work_hour_str' => ConvertTime($staff['client_timezone'], $staff['client_timezone'] , $staff['client_start_work_hour']),
		'status' => $staff['status'],
		'resignation_date' => $staff['resignation_date'],
		'date_terminated' => $staff['date_terminated'],
		'end_date' => $staff['end_date'],
		'userid' => $staff['userid'], 
		'fname' => $staff['fname'], 
		'lname' => $staff['lname'],
		'reason' => $staff['reason'],
		
	);
	array_push($inactive_staff_list, $data);
	
}


$sql = "SELECT s.id , s.starting_date, s.currency, s.job_designation, s.client_timezone, s.client_start_work_hour, s.client_price,  p.userid, p.fname, p.lname
FROM subcontractors s
JOIN personal p ON p.userid = s.userid
WHERE s.status = 'suspended'
AND s.leads_id = ".$leads_id."
ORDER BY fname;";	
//echo $sql;	
$staffs = $db->fetchAll($sql);	
$suspended_staff_list = array();
foreach($staffs as $staff){
	if($leads_id == 11){
		$staff['client_price']="";
	}
    $data = array(
	    'id' => $staff['id'], 
		'starting_date' => $staff['starting_date'], 
		'currency' => $staff['currency'],
		'client_price' => $staff['client_price'], 
		'job_designation' => $staff['job_designation'], 
		'client_timezone' => $staff['client_timezone'], 
		'client_start_work_hour' => $staff['client_start_work_hour'], 
		'client_start_work_hour_str' => ConvertTime($staff['client_timezone'], $staff['client_timezone'] , $staff['client_start_work_hour']),
		'userid' => $staff['userid'], 
		'fname' => $staff['fname'], 
		'lname' => $staff['lname']
	);
	array_push($suspended_staff_list, $data);
	
}
//echo "<pre>";
//print_r($inactive_staff_list);
//echo "</pre>";
//exit;
$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}
//echo $page_type;exit;
$smarty->assign('admin_status',$admin_status);
$smarty->assign('page_type',$page_type);
$smarty->assign('update_page',$update_page);
$smarty->assign('url' ,$url);
$smarty->assign('host',$host);
$smarty->assign('staff',$active_staff_list);
$smarty->assign('previous_staff',$inactive_staff_list);
$smarty->assign('suspended_staff',$suspended_staff_list);
$smarty->assign('starOptions' , $starOptions);
$smarty->assign('rate_Options' , $rate_Options);

$smarty->assign('lead_status' , $lead_status);
$smarty->assign('date_registered' , $date_registered);
$smarty->assign('leads_of' , $leads_of);
$smarty->assign('leads_info' , $leads_info);
$smarty->assign('leads_id' , $leads_id);
$smarty->assign('tab3' , "class='selected'");
$smarty->display('client_account.tpl');
?>