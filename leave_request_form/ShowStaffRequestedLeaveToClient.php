<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['userid']=="")
{
	die("Session Expires. Please re-login!");
}

$userid = $_SESSION['userid'];
$leads_id = $_REQUEST['leads_id'];

if(!$leads_id){
	echo "No client selected.";
	exit;
}	

//pending
$sql = $db->select()
	->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
	->join(array('l' => 'leads') , 'l.id = r.leads_id' , Array('fname' , 'lname'))
	->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
	->where('r.leads_id = ?' , $leads_id)
	->where('userid =?' ,$userid)
	->where('d.status =?' ,'pending')
	->group('r.id');
//echo $sql;	
$pending_leave_requests = $db->fetchAll($sql);



//approved
$sql = $db->select()
	->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
	->join(array('l' => 'leads') , 'l.id = r.leads_id' , Array('fname' , 'lname'))
	->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
	->where('r.leads_id = ?' , $leads_id)
	->where('userid =?' ,$userid)
	->where('d.status =?' ,'approved')
	->group('r.id');
//echo $sql;	
$approved_leave_requests = $db->fetchAll($sql);

//denied
$sql = $db->select()
	->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
	->join(array('l' => 'leads') , 'l.id = r.leads_id' , Array('fname' , 'lname'))
	->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
	->where('r.leads_id = ?' , $leads_id)
	->where('userid =?' ,$userid)
	->where('d.status =?' ,'denied')
	->group('r.id');
//echo $sql;	
$denied_leave_requests = $db->fetchAll($sql);

//cancelled
$sql = $db->select()
	->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
	->join(array('l' => 'leads') , 'l.id = r.leads_id' , Array('fname' , 'lname'))
	->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
	->where('r.leads_id = ?' , $leads_id)
	->where('userid =?' ,$userid)
	->where('d.status =?' ,'cancelled')
	->group('r.id');
//echo $sql;	
$cancelled_leave_requests = $db->fetchAll($sql);

//absent
$sql = $db->select()
	->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
	->join(array('l' => 'leads') , 'l.id = r.leads_id' , Array('fname' , 'lname'))
	->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
	->where('r.leads_id = ?' , $leads_id)
	->where('userid =?' ,$userid)
	->where('d.status =?' ,'absent')
	->group('r.id');
//echo $sql;	
$absent_leave_requests = $db->fetchAll($sql);

//echo $sql;exit;
//print_r($leave_requests);exit;
$smarty->assign('pending_leave_requests',$pending_leave_requests);
$smarty->assign('approved_leave_requests',$approved_leave_requests);
$smarty->assign('denied_leave_requests',$denied_leave_requests);
$smarty->assign('cancelled_leave_requests',$cancelled_leave_requests);
$smarty->assign('absent_leave_requests',$absent_leave_requests);

$smarty->display('ShowStaffRequestedLeaveToClient.tpl');

?>