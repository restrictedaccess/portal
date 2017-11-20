<?php
include '../conf/zend_smarty_conf.php';
require('../tools/CouchDBMailbox.php');

include 'leave_request_function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if(!$_SESSION['userid']){
	die("Staff ID is missing");
}

$comment_by_id = $_SESSION['userid'];
$comment_by_type = 'personal';	

$query="SELECT userid, fname, lname FROM personal WHERE userid=".$_SESSION['userid'];
$staff = $db->fetchRow($query);


$status = 1;
	
$leave_type = $_REQUEST['leave_type'];
$leave_duration = $_REQUEST['leave_duration'];
$start_date_of_leave = $_REQUEST['start_date_of_leave'];
$end_date_of_leave = $_REQUEST['end_date_of_leave'];
$reason_for_leave = trim($_REQUEST['reason_for_leave']) ;
$leads = explode(',',$_REQUEST['leads']);


//get the difference
if(!$end_date_of_leave){
	$end_date_of_leave = $_REQUEST['start_date_of_leave'];
}


$DATE_SEARCH=array();
$random_string_exists = True;
$start_date_str = date('Y-m-d', strtotime($start_date_of_leave));
$date_end_str = date('Y-m-d', strtotime($end_date_of_leave));
while ($random_string_exists) {
    if($start_date_str <= $date_end_str){
	    $DATE_SEARCH[] = $start_date_str;
		$start_date_str = date("Y-m-d", strtotime("+1 day", strtotime($start_date_str)));
		$random_string_exists = True;
	}else{
		$random_string_exists = False;
	}
}


foreach($leads as $lead){
	//get staff rs email
	$sql = "SELECT id, staff_email, job_designation FROM subcontractors WHERE leads_id=".$lead." AND userid=".$_SESSION['userid']." AND status IN('ACTIVE', 'suspended') LIMIT 1;";
	$subcon = $db->fetchRow($sql);
	
	//get client info
	$sql = $db->select()
		->from('leads', Array('id', 'fname', 'lname', 'email', 'csro_id'))
		->where('id =?' , $lead);
	$leads_info = $db->fetchRow($sql);
	
	//get client csro
	if($leads_info['csro_id'] != ""){
		$sql = $db->select()
			->from('admin', Array('admin_id', 'admin_fname', 'admin_lname', 'admin_email'))
			->where('admin_id =?', $leads_info['csro_id']);
		$csro = $db->fetchRow($sql);	
	}
	
	//get the staff timezone in timesheet
	$sql = $db->select()
		->from('timesheet' , 'timezone_id')
		->where('userid =?' , $_SESSION['userid'])
		->where('leads_id =?' ,$lead);
	$timezone_id = $db->fetchOne($sql);
	
	if(!$timezone_id){
		$timezone_id = 1;
	}
	
	$data = array(
		'userid' => $_SESSION['userid'], 
		'leads_id' => $lead, 
		'leave_type' => $leave_type, 
		'reason_for_leave' => $reason_for_leave, 
		'date_requested' => $ATZ,
		'leave_duration' => $leave_duration,
		'timezone_id' => $timezone_id
	);
	
	$db->insert('leave_request' , $data);
	$leave_request_id = $db->lastInsertId();	
	
	
	foreach($DATE_SEARCH as $date){
		$data = array(
			'leave_request_id' => $leave_request_id, 
			'date_of_leave' => $date,
			'status' => 'pending'
		);
		$db->insert('leave_request_dates' , $data);
	}
	
	
	
	//Send Email
	//get all client's managers email
	$managers_emails=array();
	$managers_emails = get_client_managers_emails($lead, $_SESSION['userid']);
		
	$smarty->assign('leads_info',$leads_info);
	$smarty->assign('staff', $staff);
	$smarty->assign('subcon', $subcon);
	$smarty->assign('DATE_SEARCH',$DATE_SEARCH);
	$smarty->assign('leave_type',$leave_type);
	$smarty->assign('leave_duration',$leave_duration);
	$smarty->assign('reason_for_leave',$reason_for_leave);
	$smarty->assign('response_note',$response_note);
	$smarty->assign('leave_request_id', $leave_request_id);
	$body = $smarty->fetch('workflow_autoresponder.tpl');
	
	$attachments_array =NULL;
	$text = NULL;
	$html = $body;
	$subject=sprintf("Remotestaff Leave Request Staff %s %s to Client %s %s.", $staff['fname'], $staff['lname'], $leads_info['fname'], $leads_info['lname']);
	
	$from = 'Leave Request Management<attendance@remotestaff.com.au>';
	$to_array = array($leads_info['email'], $subcon['staff_email']);
	
	$bcc_array=NULL;
	$cc_array = array('attendance@remotestaff.com.au');
	if($managers_emails){
		foreach($managers_emails as $manager_email){
			$cc_array[]=$manager_email;
		}
	}
	if($csro){
		$cc_array[] = $csro['admin_email'];
	}
	
	SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	//echo "<pre>";
	//print_r($body);
	//echo "</pre>";
	//exit;	
	
}
		

//exit;
//$leads_name_str=substr($leads_name_str,0,(strlen($leads_name_str)-2));
echo "An email notification was sent to your client(s) : \n".$leads_name_str;
exit;
?>