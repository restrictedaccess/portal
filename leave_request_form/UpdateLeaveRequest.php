<?php
include '../conf/zend_smarty_conf.php';
include 'leave_request_function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id = $_REQUEST['id'];
$leave_status = trim($_REQUEST['leave_status']);
$response_note = trim($_REQUEST['response_note']);
if(!$id){
	die('Leave Request ID is missing');
}


if($_SESSION['userid'] != "" || $_SESSION['userid']!=NULL){
	$comment_by_id = $_SESSION['userid'];
	$comment_by_type = 'personal';	
}else{
	die("Session Expired. Please re-login");
}

//get the previous note then concat it with the current

$sql = $db->select()
	->from('leave_request' , 'response_note')
	->where('id =? ' ,$id);
$existing_response_note = $db->fetchOne($sql);

if($response_note){
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
	// Processes \r\n's first so they aren't converted twice.
	$response_note = str_replace($order, $replace, $response_note);
}	
$str = $existing_response_note."<b>".strtoupper($leave_status)." by ".ShowName($comment_by_id,$comment_by_type)." - ".$ATZ."</b><p>-<em>".stripslashes($response_note)."</em></p>";
 
$data = array(
	'leave_status' => $leave_status, 
	'response_by_id' => $comment_by_id, 
	'response_by_type' => $comment_by_type, 
	'response_date' => $ATZ, 
	'response_note' => $str
);

//print_r($data);
$where = "id = ".$id;
$db->update('leave_request' , $data , $where);


$sql = $db->select()
	->from('leave_request')
	->where('id =? ' ,$id);
$leave_request = $db->fetchRow($sql);	

//get the leads email
$sql = $db->select()
	->from('leads')
	->where('id =?' , $leave_request['leads_id']);
$leads = $db->fetchRow($sql);

$query="SELECT * FROM personal WHERE userid=".$leave_request['userid'];
$staff = $db->fetchRow($query);


$det = new DateTime($leave_request['date_of_leave']);
$date_of_leave = $det->format("F j, Y");


$body = "<p>Staff ".$staff['fname']." ".$staff['lname']." request for leave or absence on";
$body .= "<p><u><b>".strtoupper($date_of_leave)."</b></u> has been <b>".strtoupper($leave_request['leave_status'])."</b></p>";
$body .= "<p>&nbsp;</p>";
$body .= "<p><span style='text-transform:capitalize;'>".$leave_request['leave_status']."</span> by ".ShowName($leave_request['response_by_id'] , $leave_request['response_by_type'])." ".$leave_request['response_date'] ."</p>";

if($leave_request['response_note']){
	$body .= "<p>NOTE : </p>";
	$body .= "<p>".stripslashes($leave_request['response_note'])."</p>";

}



$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
if(!TEST){
	$mail->addTo($staff['email'], $staff['fname']." ".$staff['lname']);
	$mail->addTo($leads['email'], $leads['fname']." ".$leads['lname']);
	$mail->addCc('attendance@remotestaff.com.au' , 'Attendance');// Adds a recipient to the mail with a "Cc" header
}else{
	$mail->addTo('devs@remotestaff.com.au' , 'Inhouse Developers');
	//$mail->addCc('rhiza@remotestaff.com.au' , 'Rhiza Lanche');// Adds a recipient to the mail with a "Cc" header
}
//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject("Remotestaff ".$staff['fname']." ".$staff['lname']." Request for Leave to Client ".$leads['fname']." ".$leads['lname']);
$mail->send($transport);

echo "Staff request is ".$leave_status;
?>
