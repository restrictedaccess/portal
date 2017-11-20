<?php
include '../../conf/zend_smarty_conf.php';
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
}else{
	die("Session Expired. Please re-login");
}

if(!$_POST['userid']){
	die("Please select a staff");
}

$query="SELECT * FROM personal WHERE userid=".$_POST['userid'];
$staff = $db->fetchRow($query);

//$date_of_leave = date('Y-m-d', strtotime(sprintf('%s-%s-%s', $_POST['year'], $_POST['month'], $_POST['day'])));
//echo $date_of_leave;exit;
	

//leads details

$sql = "SELECT s.leads_id, l.fname, l.lname, l.email FROM subcontractors s LEFT JOIN leads l ON l.id = s.leads_id WHERE userid=".$_POST['userid']." AND s.status IN('ACTIVE', 'suspended');";
//echo $sql;exit;
$leads = $db->fetchAll($sql);


$leave_type_array = array('Absent', 'Sick Leave' , 'Vacation Leave' , 'Personal Leave', 'Client Public Holiday', 'Staff Public Holiday', 'Paid Personal Leave', 'Paid Vacation Leave', 'Paid Client Public Holiday', 'Paid Sick Leave', 'Paid Staff Public Holiday');

$duration_array = array('Whole Day' , 'Half Day');

$smarty->assign('date_of_leave' ,date("Y-m-d"));
$smarty->assign('staff',$staff);
$smarty->assign('leave_type_array',$leave_type_array);
$smarty->assign('duration_array',$duration_array);
$smarty->assign('leads' ,$leads);
$smarty->display('ShowAddLeaveForm.tpl');
?>