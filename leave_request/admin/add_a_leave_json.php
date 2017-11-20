<?php
include '../../conf/zend_smarty_conf.php';
require('../../tools/CouchDBMailbox.php');
include '../../leave_request_form/leave_request_function.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$data = json_decode(file_get_contents('php://input'), true);
//echo "<pre>";
//print_r($data["Query"]);
//echo "</pre>";
//exit;
$comment_by_id = $_SESSION['admin_id'];
$comment_by_type = 'admin';

$userid = $data["Query"]["userid"];
$leave_type = $data["Query"]["leave_type"];
$start_date_of_leave = $data["Query"]["start_date_of_leave"];
$end_date_of_leave = $data["Query"]["end_date_of_leave"];
$leave_duration = $data["Query"]["leave_duration"];
$reason_for_leave = $data["Query"]["reason_for_leave"];
$clients = $data["Query"]["clients"]; //array



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

//echo "<pre>";
//print_r($DATE_SEARCH);
//echo "</pre>";
//exit;


//Staff info
$sql = "SELECT fname , lname , email FROM personal WHERE userid = ".$userid;
$staff = $db->fetchRow($sql);

//clients
foreach($clients as $leads_id){
	$sql="SELECT fname, lname, email FROM leads WHERE id=".$leads_id;
	$client = $db->fetchRow($sql);
	
	
	$sql="SELECT staff_email FROM subcontractors WHERE userid=".$userid." AND leads_id=".$leads_id." AND status in('ACTIVE', 'suspended');";
    $staff_email = $db->fetchOne($sql);
	
	
	
	//get the staff timezone in timesheet
	$sql = $db->select()
		->from('timesheet' , 'timezone_id')
		->where('userid =?' , $userid)
		->where('leads_id =?' ,$leads_id);
	$timezone_id = $db->fetchOne($sql);
	
	if(!$timezone_id){
		$timezone_id = 1;
	}
	
	$data = array(
		'userid' => $userid, 
		'leads_id' => $leads_id, 
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
			'date_of_leave' => $date
		);
		if($leave_type == 'Absent'){
			$data['status'] = 'absent';
		}
		$db->insert('leave_request_dates' , $data);
		
	}
	
	//Send Email
	//get all client's managers email
	$managers_emails=array();
	$managers_emails = get_client_managers_emails($leads_id, $userid);
	//echo "<pre>";
	//print_r($managers_emails);
	//echo "</pre>";
	
	$response_note = "<p><span style='text-transform:capitalize;'>Manually Added in behalf of Staff </span> by ".ShowName($_SESSION['admin_id'] , 'admin')." <em>".$ATZ ."</em></p>";
	$smarty->assign('client',$client);
	$smarty->assign('staff',$staff);
	$smarty->assign('DATE_SEARCH',$DATE_SEARCH);
	$smarty->assign('leave_type',$leave_type);
	$smarty->assign('leave_duration',$leave_duration);
	$smarty->assign('reason_for_leave',$reason_for_leave);
	$smarty->assign('response_note',$response_note);
	$body = $smarty->fetch('admin_leave_request_autoresponder.tpl');
	
	$attachments_array =NULL;
	$text = NULL;
	$html = $body;
	if($leave_type == 'Absent'){
		$subject = sprintf("Staff %s %s is absent to Client %s %s", $staff['fname'], $staff['lname'], $client['fname'], $client['lname']);
	}else{
		$subject = sprintf("Staff %s %s is on leave to Client %s %s", $staff['fname'], $staff['lname'], $client['fname'], $client['lname']);
	}
	
	$from = 'Attendance<attendance@remotestaff.com.au>';
	$to_array = array($client['email'], $staff_email);
	$bcc_array=NULL;
	$cc_array = array('attendance@remotestaff.com.au');
	if($managers_emails){
		foreach($managers_emails as $manager_email){
			$cc_array[]=$manager_email;
		}
	}
	SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	//echo "<pre>";
	//print_r($body);
	//echo "</pre>";
	
	if($leave_type == 'Absent'){
		$history_changes = "MARKED ABSENT by ".ShowName($_SESSION['admin_id'] , 'admin');
	}else{
		$history_changes = "Manually added in behalf of staff by ".ShowName($_SESSION['admin_id'] , 'admin');
	}
	
	$data = array(
		'leave_request_id' => $leave_request_id, 
		'notes' => $history_changes, 
		'response_by_id' => $comment_by_id, 
		'response_by_type' => $comment_by_type,
		'response_date' => $ATZ
	);
	$db->insert('leave_request_history' , $data);
	
	
}

echo json_encode(array("success"=>true, "leave_request_id" => $leave_request_id, 'msg' => 'Successfully Added'));
exit;
?>