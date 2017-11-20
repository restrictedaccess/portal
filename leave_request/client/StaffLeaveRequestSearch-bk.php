<?php
include '../../conf/zend_smarty_conf.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;


$search_str = "";
if($_POST['userid']){
	$sql="SELECT fname, lname FROM personal WHERE userid=".$_POST['userid'];
	$personal=$db->fetchRow($sql);
	$calendar_indication_str = sprintf('%s %s Leave Request', $personal['fname'], $personal['lname']);
	$search_str = " AND l.userid=".$_POST['userid'];
}else{
	$calendar_indication_str = 'All Staff Leave Request';
}


$sql="SELECT l.id, d.date_of_leave, d.status, l.userid, p.fname, p.lname FROM leave_request_dates d
JOIN leave_request l ON l.id = d.leave_request_id
JOIN personal p ON p.userid = l.userid
WHERE l.leads_id=".$_SESSION['client_id']." AND YEAR(d.date_of_leave)='".$_POST['year']."' ".$search_str." ORDER BY d.date_of_leave;";
echo $sql;
$leaves = $db->fetchAll($sql);


foreach($leaves as $leave){
	if($leave['status'] == 'pending'){
		$pending[] = $leave;
	}
	
	if($leave['status'] == 'absent'){
		$absent[] = $leave;
	}
	
	if($leave['status'] == 'cancelled'){
		$cancelled[] = $leave;
	}
	
	if($leave['status'] == 'approved'){
		$approved[] = $leave;
	}
	
	if($leave['status'] == 'denied'){
		$denied[] = $leave;
	}
}

$data=array(
    'pending' => $pending,
	'absent' => $absent,
	'approved' => $approved,
	'denied' => $denied,
	'cancelled' => $cancelled
);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
$smarty->assign('leaves', $data);
$smarty->assign('leads_id' , $_SESSION['client_id']);
$smarty->display('StaffLeaveRequestSearch.tpl');
?>