<?php
include '../../conf/zend_smarty_conf.php';
include '../../leave_request_form/leave_request_function.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

if($_SESSION['admin_id']){
	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$_SESSION['admin_id']);
	$admin = $db->fetchRow($sql);
	if($admin['csro'] == 'Y'){
		$csro_id_search = $_SESSION['admin_id'];
	}
}else{
    die("Session expires. Please re-login.");
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

if($_POST['csro_id']){
	$csro_id_search = $_POST['csro_id'];
}

$search= true;
if($csro_id_search){
	$csro_assigned_staffs = get_assigned_staffs($csro_id_search);
	foreach($csro_assigned_staffs as $staff){
		$assigned_staffs[] = (int)$staff['userid'];
		$staff_search_str .=sprintf('%s,', $staff['userid']);
	}
	$staff_search_str = substr($staff_search_str,0,(strlen($staff_search_str)-1));
	
	/*
    if(!$_POST['userid']){	
		$csro_conditions = " AND l.csro_id = '".$csro_id_search. "' ";
		$sql="SELECT s.userid FROM subcontractors AS s INNER JOIN leads AS l ON l.id = s.leads_id WHERE (s.status IN ('ACTIVE', 'suspended') ".$csro_conditions." );";
		$csro_staffs = $db->fetchAll($sql);
		if($csro_staffs){
			foreach($csro_staffs as $staff){
				$staff_search_str .=sprintf('%s,', $staff['userid']);
			}
			$staff_search_str = substr($staff_search_str,0,(strlen($staff_search_str)-1));
			$search_str=sprintf('AND l.userid IN(%s)', $staff_search_str);		
		}
	}
	*/
	if($_POST['userid']){	
		if (in_array((int)$_POST['userid'], $assigned_staffs)){
			$search_str .= " AND l.userid=".$_POST['userid'];
		}else{
			//echo "Match not found<br>";
			$search=false;
		}
	}else{
		if($csro_assigned_staffs){
			$search_str .= sprintf('AND l.userid IN(%s)', $staff_search_str);			
		}else{
			//echo "No assigned staffs<br>";
			$search=false;
		}
	}
}

$pending_ids=array();
$absent_ids=array();
$cancelled_ids=array();
$approved_ids=array();
$denied_ids=array();

//echo $search."<br>";
if($search){
	$sql="SELECT l.id, (d.id)AS date_id, d.date_of_leave, d.status, l.userid, p.fname, p.lname
	FROM leave_request_dates d
	JOIN leave_request l ON l.id = d.leave_request_id
	JOIN personal p ON p.userid = l.userid
	WHERE l.leads_id IS NOT NULL ".$search_str." ORDER BY d.date_of_leave;";
	//echo $sql;
	//exit;
	$leaves = $db->fetchAll($sql);

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
//$smarty->assign('leads_id' , $_SESSION['client_id']);
$smarty->display('StaffLeaveRequestSearch.tpl');
?>