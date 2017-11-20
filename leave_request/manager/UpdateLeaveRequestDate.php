<?php
include '../../conf/zend_smarty_conf.php';
require('../../tools/CouchDBMailbox.php');
include '../../leave_request_form/leave_request_function.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

//default timezone is Asia/Manila
date_default_timezone_set("Asia/Manila");

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$data = json_decode(file_get_contents('php://input'), true);
//echo "<pre>";
//print_r($data["Query"]);
//echo "</pre>";

$comment_by_id = $_SESSION['manager_id'];
$comment_by_type = 'client_managers';

$leave_request_id = $data["Query"]["leave_request_id"];
$dates = $data["Query"]["dates"];
$status = $data["Query"]["status"];
$notes = $data["Query"]["notes"];

$sql =$db->select()
	->from('leave_request_dates' )
	->where('leave_request_id =?' , $leave_request_id);
$leave_request_dates = $db->fetchAll($sql);	


//get the subcon userid of this leave_request
$sql = $db->select()
	->from('leave_request')
	->where('id =?' ,$leave_request_id);
$leave_request = $db->fetchRow($sql);

$sql = "SELECT fname , lname  FROM personal WHERE userid = ".$leave_request['userid'];
$staff = $db->fetchRow($sql);

$sql = "SELECT fname , lname , email, csro_id FROM leads WHERE id = ".$leave_request['leads_id'];
$leads = $db->fetchRow($sql);

//Get the subcontractors.staff_email
$sql="SELECT staff_email FROM subcontractors s where userid=".$leave_request['userid']." and leads_id=".$leave_request['leads_id'].";";
$staff_email = $db->fetchOne($sql);


foreach($dates as $d){
	$data = array('status' => $status);
	$where = "id=".$d;
	//echo "<pre>";
	//print_r($data);
	//echo $where."<br>";
	//echo "</pre>";
	$db->update('leave_request_dates', $data, $where);	
	$sql="SELECT date_of_leave FROM leave_request_dates l where id=".$d;
	$date_of_leave = $db->fetchOne($sql);

	$date_of_leave_str .= " ".date('F j, Y => l', strtotime($date_of_leave))."<br>";
	$date_of_leave_str2 .= "<li>".date('F j, Y => l', strtotime($date_of_leave))."</li>";
}

$history_changes = strtoupper($status)." ALL DATES : <br>".$date_of_leave_str."<br><em>".$notes."</em>";
$data = array(
	'leave_request_id' => $leave_request_id, 
	'notes' => $history_changes, 
	'response_by_id' => $comment_by_id, 
	'response_by_type' => $comment_by_type,
	'response_date' => $ATZ
);
$db->insert('leave_request_history' , $data);

file_get_contents($nodejs_api."/sync/leave-request/?id={$leave_request_id}");

//send email notification the subcon
$smarty->assign('staff', $staff);
$smarty->assign('leads', $leads);
$smarty->assign('mode', $status);
$smarty->assign('date_of_leave_str2', $date_of_leave_str2);
$smarty->assign('comment_by', ShowName($comment_by_id , $comment_by_type));
$smarty->assign('ATZ', $ATZ);
$body = $smarty->fetch('leave_request_autoresponder.tpl');

$csro=array();
if($leads['csro_id'] !=""){
	$sql = $db->select()
	    ->from('admin')
		->where('admin_id =?', $leads['csro_id']);
    $csro = $db->fetchRow($sql);
}


//get all client's managers email
$managers_emails=array();
$managers_emails = get_client_managers_emails($leave_request['leads_id'], $leave_request['userid']);

//send email
$to_array = array();
if($leads['email']){
	$to_array[] = $leads['email'];
}

if($staff_email){
	$to_array[] = $staff_email;
}


$cc_array = array('attendance@remotestaff.com.au');
if($csro){
	$cc_array[]= $csro['admin_email'];
}
if(count($managers_emails) >0){
	foreach($managers_emails as $manager_email){
		$cc_array[]=$manager_email;
	}
}

if($manager['email'] !=""){
	$cc_array[]=$manager['email'];
}

$attachments_array =NULL;
$bcc_array=NULL;
$from = 'Leave Request Management<attendance@remotestaff.com.au>';
$html = $body;
$subject=sprintf("Remotestaff Leave Request Staff %s %s to Client %s %s.", $staff['fname'], $staff['lname'], $leads['fname'], $leads['lname']);
$text = NULL;
if(count($to_array)>0){
	SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	echo json_encode(array("success"=>true, "leave_request_id" => $leave_request_id, 'status' => $status, 'msg' => 'Message sent'));
}else{
	echo json_encode(array("success"=>false, "leave_request_id" => $leave_request_id, 'status' => $status, 'msg' => 'No recipients detected'));
}
//echo "<pre>";
//print_r($body);
//echo "</pre>";

?>