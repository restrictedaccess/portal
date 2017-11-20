<?php
include '../../conf/zend_smarty_conf.php';
include '../../leave_request_form/leave_request_function.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;


$sql="SELECT * FROM leave_request l where id=".$_POST['leave_request_id'];
$leave_request = $db->fetchRow($sql);

$sql="SELECT * FROM leave_request_dates l where leave_request_id=".$_POST['leave_request_id']." AND YEAR(date_of_leave)='".$_POST['year']."' AND status='".$_POST['status']."';";
$dates = $db->fetchAll($sql);

$sql="SELECT fname, lname FROM personal WHERE userid=".$leave_request['userid'];
$personal=$db->fetchRow($sql);

$sql="SELECT fname, lname FROM leads WHERE id=".$leave_request['leads_id'];
$lead=$db->fetchRow($sql);

$sql="SELECT id, job_designation FROM subcontractors WHERE leads_id=".$leave_request['leads_id']." AND userid=".$leave_request['userid']." AND status IN('ACTIVE', 'suspended');";
$subcon=$db->fetchRow($sql);


$sql = $db->select()
	->from('leave_request_history')
	->where('leave_request_id =?' , $leave_request['id']);
$leave_request_histories = $db->fetchAll($sql);	
foreach($leave_request_histories as $leave_request_history){

	$data=array(
		'comment' => $leave_request_history['notes'],
		'comment_by' => ShowName($leave_request_history['response_by_id'] , $leave_request_history['response_by_type']),
		'date_comment' => $leave_request_history['response_date']
	);
    $histories[]=$data;
}


$smarty->assign('status',$_POST['status']);
$smarty->assign('histories', $histories);
$smarty->assign('leave_request', $leave_request);
$smarty->assign('dates' , $dates);
$smarty->assign('personal', $personal);
$smarty->assign('lead', $lead);
$smarty->assign('subcon', $subcon);
$smarty->display('ShowLeaveRequest.tpl');
?>