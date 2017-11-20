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



if($_SESSION['userid'] != "" || $_SESSION['userid'] !=NULL){
	$comment_by_id = $_SESSION['userid'];
	$userid = $_SESSION['userid'];
	$comment_by_type = 'staff';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
	$userid = $_REQUEST['userid'];
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
	$userid = $_REQUEST['userid'];
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

if(!$userid){
	die("Staff ID is missing");
}

$query="SELECT * FROM personal WHERE userid=$userid";
$staff = $db->fetchRow($query);

$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$id = $_REQUEST['id'];
$det = new DateTime($year."-".$month."-".$day);
$date_of_leave = $det->format("Y-m-d");

//echo 'comment_by_id ' .$comment_by_id.'<br>comment_by_type '.$comment_by_type.'<br>userid'.$userid.'<br>'; 
//echo $date_of_leave;

//parse the selected Leave Request
//id, userid, leads_id, leave_type, date_of_leave, reason_for_leave, date_requested, leave_status, response_by_id, response_by_type, response_date, response_note

if($id > 0){
	$sql = $db->select()
		->from('leave_request')
		->where('id =?' , $id);
	$leave_request = $db->fetchRow($sql);
}else{
	$sql = $db->select()
		->from('leave_request')
		->where('date_of_leave =?' , $date_of_leave)
		->where('userid =?' , $userid);
	$leave_request = $db->fetchRow($sql);

}

if($leave_request['leads_id']){
	$sql = $db->select()
		->from('leads')
		->where('id =?' , $leave_request['leads_id']);
	$lead = $db->fetchRow($sql);	
}

if($leave_request['leave_status'] != 'pending'){
	$response_by = ShowName($leave_request['response_by_id'] , $leave_request['response_by_type']);
}

$smarty->assign('response_by',$response_by);
$smarty->assign('comment_by_type' , $comment_by_type);
$smarty->assign('lead' ,$lead);
$smarty->assign('staff' , $staff);
$smarty->assign('leave_request' , $leave_request);
$smarty->display('ShowLeaveRequest.tpl');
?>