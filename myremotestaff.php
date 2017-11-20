<?php
include('conf/zend_smarty_conf.php');
include 'function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];

$sql="SELECT s.userid , p.fname, p.lname ,a.status, s.client_timezone, s.client_start_work_hour, s.job_designation, s.starting_date, (s.status)AS contract_status FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid LEFT JOIN activity_tracker a ON s.userid = a.userid WHERE s.status IN ('ACTIVE','suspended') AND s.leads_id = ".$client_id." GROUP BY s.userid ORDER BY p.fname ASC ;";
//echo $sql;
$staffs = $db->fetchAll($sql);
$details = array();
foreach($staffs as $staff){

    $det = new DateTime($staff['starting_date']);
	$starting_date = $det->format("F j, Y");
	$starting_date_str = $det->format("Y-m-d");
			
	if($staff['client_start_work_hour']){
	    //$date = new DateTime($staff['client_start_work_hour']);
	    //$staff_start_work_hour = $date->format('H:i');
	    //$staff_start_work_hour_str = $date->format('h:i a');
	}
			
    $data = array(
	    'userid' => $staff['userid'],
		'fname' => $staff['fname'],
		'lname' => $staff['lname'],
		'contract_status' => $staff['contract_status'],
		'login_status' => $staff['status'],
		'client_timezone' => $staff['client_timezone'],
		'client_start_work_hour' => ConvertTime($staff['client_timezone'], $staff['client_timezone'] , $staff['client_start_work_hour']),
		'job_designation' => $staff['job_designation'],
		'starting_date' => $starting_date
	);
	
	array_push($details, $data);
}

//echo "<pre>";
//print_r($details);
//echo "</pre>";
//exit;
$smarty->assign('staffs', $details);
$smarty->display('myremotestaff.tpl');
exit;
?>