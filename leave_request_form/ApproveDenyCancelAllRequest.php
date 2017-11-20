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


if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
}else if($_SESSION['userid'] != "" || $_SESSION['userid']!=NULL){
	$comment_by_id = $_SESSION['userid'];
	$comment_by_type = 'personal';	
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


$leave_request_id = $_REQUEST['leave_request_id'];
$notes = trim($_REQUEST['notes']);
$mode = $_REQUEST['mode'];

if(!$leave_request_id){
	die("Leave Request ID is missing.");
}

//get the subcon userid of this leave_request
$sql = $db->select()
	->from('leave_request')
	->where('id =?' ,$leave_request_id);
$leave_request = $db->fetchRow($sql);

$sql = "SELECT fname , lname , email FROM personal WHERE userid = ".$leave_request['userid'];
$staff = $db->fetchRow($sql);

$sql = "SELECT fname , lname , email, csro_id FROM leads WHERE id = ".$leave_request['leads_id'];
$leads = $db->fetchRow($sql);

$sql = "SELECT id, staff_email, job_designation FROM subcontractors WHERE leads_id=".$leave_request['leads_id']." AND userid=".$leave_request['userid']." AND status IN('ACTIVE', 'suspended') LIMIT 1;";
$subcon = $db->fetchRow($sql);


$sql =$db->select()
	->from('leave_request_dates' )
	->where('leave_request_id =?' , $leave_request_id);
$leave_request_dates = $db->fetchAll($sql);	
$i=0;
foreach($leave_request_dates as $leave_request_date ) {

		//if($leave_request_date['status'] == "cancelled" or $leave_request_date['status'] == "denied"){
				//do nothing;
		//}else{
				//make it user friendly , readable
				$det = new DateTime($leave_request_date['date_of_leave']);
				$date_of_leave_str .= " ".$det->format("F j, Y => l")."<br>";
				

				$date_of_leave_str2 .= "<li>".$det->format("F j, Y => l")."</li>";
				$data = array('status' => $mode);
				$where = "id = ".$leave_request_date['id'];
				$db->update('leave_request_dates' , $data , $where);
				$i++;
		//}
	
}
//echo $date_of_leave_str2;exit;
//insert history
$history_changes = strtoupper($mode)." ALL DATES : <br>".$date_of_leave_str."<br><em>".$notes."</em>";
$data = array(
		'leave_request_id' => $leave_request_id, 
		'notes' => $history_changes, 
		'response_by_id' => $comment_by_id, 
		'response_by_type' => $comment_by_type,
		'response_date' => $ATZ
	);
$db->insert('leave_request_history' , $data);

//send email notification the subcon
$smarty->assign('staff', $staff);
$smarty->assign('leads', $leads);
$smarty->assign('mode', $mode);
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

$attachments_array =NULL;
$text = NULL;
$html = $body;
$subject=sprintf("Remotestaff Leave Request Staff %s %s to Client %s %s.", $staff['fname'], $staff['lname'], $leads['fname'], $leads['lname']);

$from = 'Leave Request Management<attendance@remotestaff.com.au>';
$to_array = array($leads['email'], $subcon['staff_email']);

$bcc_array=NULL;
$cc_array = array('attendance@remotestaff.com.au');

//get all client's managers email
$managers_emails=array();
$managers_emails = get_client_managers_emails($leave_request['leads_id'], $leave_request['userid']);
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
//print_r($subject);
//echo "</pre>";
//exit;
echo $leave_request_id;
exit;
?>