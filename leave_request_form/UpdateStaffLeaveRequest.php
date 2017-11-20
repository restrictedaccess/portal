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


if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
}else if($_SESSION['manager_id'] != "" || $_SESSION['manager_id']!=NULL){
	$comment_by_id = $_SESSION['manager_id'];
	$comment_by_type = 'client_managers';
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);	
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
$date_of_leave = $det->format("F j, Y => l");

//send email notification the subcon
$smarty->assign('staff', $staff);
$smarty->assign('leads', $leads);
$smarty->assign('mode', $mode);
$smarty->assign('date_of_leave_str2', $date_of_leave);
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

//recipients
$recipients_str=$staff['email'];		
$recipients_str.=', '.$leads['email'];
$recipients_str.=', attendance@remotestaff.com.au';
if($csro){
    $recipients_str.=', '.$csro['admin_email'];
}
if($manager['email'] !=""){
	$recipients_str.=', '.$manager['email'];
}

//get all client's managers email
$managers_emails=array();
$managers_emails = get_client_managers_emails($leave_request['leads_id'], $leave_request['userid']);
if(count($managers_emails) >0){
    foreach($managers_emails as $manager_email){
		$recipients_str.=', '.$manager_email;
	}
}

$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($body);
$mail->setFrom('attendance@remotestaff.com.au' , 'Leave Request Management');
$subject=sprintf("Remotestaff Leave Request Staff %s %s to Client %s %s.", $staff['fname'], $staff['lname'], $leads['fname'], $leads['lname']);

if(!TEST){
	$mail->addTo($leads['email'], $leads['fname']." ".$leads['lname']);
	$mail->addTo($staff['email'], $staff['fname']." ".$staff['lname']);
	$mail->addCc('attendance@remotestaff.com.au' , 'Attendance');
	if(count($managers_emails) >0){
	    foreach($managers_emails as $manager_email){
			$mail->addCc($manager_email , 'Manager');
		}
	}
	if($csro){
		$mail->addCc($csro['admin_email'] , 'CSRO');
	}
	if($manager['email'] !=""){
		$mail->addCc($manager['email'] , $manager['fname']." ".$manager['fname']);
	}
	$mail->setSubject($subject);
}else{
	$mail->addTo('devs@remotestaff.com.au' , 'Inhouse Developers');
	$mail->setSubject(sprintf('TEST %s Recipients => [%s]', $subject, $recipients_str ));
}

$mail->send($transport);

echo "Staff request is ".$leave_status;
?>
