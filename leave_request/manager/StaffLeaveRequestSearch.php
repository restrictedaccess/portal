<?php
include '../../conf/zend_smarty_conf.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

if($_SESSION['manager_id']){
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);	
	$_SESSION['client_id'] = $manager['leads_id'];
	
}else{
    die("Session expires. Please re-login.");
}
$staff_search_str="";
//Get all assigned staff
if($manager['view_staff'] == 'specific'){
	$sql = "SELECT subcontractor_id FROM client_managers_specific_staffs c where client_manager_id=".$_SESSION['manager_id'];
	//echo $sql;exit;
	$subcons = $db->fetchAll($sql);
	
	foreach($subcons as $subcon){
		$sql = $db->select()
			->from('subcontractors', 'userid')
			->where('id=?', $subcon['subcontractor_id']);
		$userid = $db->fetchOne($sql);
		//$userids[] = $userid;
		$staff_search_str .=sprintf('%s,', $userid);
	}
	$staff_search_str=substr($staff_search_str,0,(strlen($staff_search_str)-1));
	$staff_search_str =sprintf(" AND l.userid IN(".$staff_search_str.") "); 
}


$search_str = " AND YEAR(d.date_of_leave)='".$_POST['year']."' ";
if($_POST['month'] and $_POST['day']){
	$date = date('Y-m-d',strtotime(sprintf('%s-%s-%s', $_POST['year'], $_POST['month'] , $_POST['day'] )));
	$search_str = " AND DATE(d.date_of_leave)='".$date."' ";
}

if($_POST['userid']){
	$sql="SELECT fname, lname FROM personal WHERE userid=".$_POST['userid'];
	$personal=$db->fetchRow($sql);
	$calendar_indication_str = sprintf('%s %s Leave Request', $personal['fname'], $personal['lname']);
	$search_str = $search_str ." AND l.userid=".$_POST['userid'];
}else{
	$calendar_indication_str = 'All Staff Leave Request';
}




$sql="SELECT l.id, (d.id)AS date_id, d.date_of_leave, d.status, l.userid, p.fname, p.lname
FROM leave_request_dates d
JOIN leave_request l ON l.id = d.leave_request_id
JOIN personal p ON p.userid = l.userid
WHERE l.leads_id=".$_SESSION['client_id'].$staff_search_str.$search_str." ORDER BY d.date_of_leave;";
//echo $sql;
//exit;
$leaves = $db->fetchAll($sql);

$pending_ids=array();
$absent_ids=array();
$cancelled_ids=array();
$approved_ids=array();
$denied_ids=array();
foreach($leaves as $leave){
	if($leave['status'] == 'pending'){
		if(in_array($leave['id'], $pending_ids)==false){
			$pending[] = $leave;
			$pending_ids[] = $leave['id'];
		}
		
	}
	
	if($leave['status'] == 'absent'){
		if(in_array($leave['id'], $absent_ids)==false){
			$absent[] = $leave;
			$absent_ids[] = $leave['id'];
		}
	}
	
	if($leave['status'] == 'cancelled'){
		if(in_array($leave['id'], $cancelled_ids)==false){
			$cancelled[] = $leave;;
			$cancelled_ids[] = $leave['id'];
		}
	}
	
	if($leave['status'] == 'approved'){
		if(in_array($leave['id'], $approved_ids)==false){
			$approved[] = $leave;
			$approved_ids[] = $leave['id'];
		}
	}
	
	if($leave['status'] == 'denied'){
		if(in_array($leave['id'], $denied_ids)==false){
			$denied[] = $leave;
			$denied_ids[] = $leave['id'];
		}
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