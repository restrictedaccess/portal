<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if(!$_SESSION['admin_id']){
	die("Session Expires. Please re-login");
}


$mode = $_REQUEST['mode'];

$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = date("d");

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
if(!$from){
	$from=date("Y-m-d");
}

$anni = $_REQUEST['anni'];
$list = $_REQUEST['list'];

if($mode == 'month_year'){
	$date = new DateTime();
	$date->setDate($year, $month, $day);
}else{
	$date = new DateTime($from);
}

$one_year_date = $date->format("m-d");
//echo $year."-".$month."<br>";
//$current_date = $date->format("Y-m-d");
$current_date = date("Y-m-d");
//echo $current_date."<br>";
$current_year_month = $date->format("Y-m");
$current_year = $date->format("Y");
//$current_month_day = $date->format("m-d");
$current_month = $date->format("m");

//$current_year_month = date("Y-m");
//$current_year = date("Y");
//echo $current_year; 
$current_month_day = date("m-d");
//$current_month = date("m");


$six_months_staffs_month = array();
$six_months_staff_ann_today = array();

$one_year_staffs_ann = array();
$one_year_staffs_ann_today = array();


$sql = "SELECT s.id , s.userid , (p.fname)AS staff_fname , (p.lname)AS staff_lname , (p.email)AS staff_email ,(s.job_designation) AS staff_designation, s.leads_id , (l.fname)AS client_fname , (l.lname)AS client_lname , (l.email)AS client_email,l.status, s.starting_date  FROM subcontractors s JOIN personal p ON p.userid = s.userid JOIN leads l ON l.id = s.leads_id WHERE s.status IN ('ACTIVE', 'suspended')   ORDER BY p.fname;";
//echo $sql;exit;
$staffs = $db->fetchAll($sql);
//print_r($staffs);exit;
foreach($staffs as $staff){
	if($staff['starting_date']){
		$starting_date = explode('-',$staff['starting_date']);
		$year = $starting_date[0];
		$month = $starting_date[1];
		$day = $starting_date[2];
		
		$date = new DateTime();
		$date->setDate($year, $month, $day);
		$starting_date_str = $date->format("F j Y");
		$one_year_date = $date->format("m-d");
		$one_year_month = $date->format("m");
		
		
		$date->modify("+6 month");
		$six_months_date = $date->format("Y-m-d");
		$six_months = $date->format("Y-m");
		
		$data = array(
			'id' => $staff['id'],
			'userid' => $staff['userid'],
			'leads_id' => $staff['leads_id'],
			'staff_fname' => $staff['staff_fname'],
			'staff_lname' => $staff['staff_lname'],
			'staff_email' => $staff['staff_email'],
			'staff_designation' => $staff['staff_designation'],
			'starting_date' => $starting_date_str,
			'client_fname' => $staff['client_fname'],
			'client_lname' => $staff['client_lname'],
			'client_email' => $staff['client_email'],
			'status' => $staff['status']
		);
			
		//filters the staff celebrating 6 months (current date)
		if($current_date == $six_months_date){
			array_push($six_months_staff_ann_today,$data);
			
		}
		//filters the staff celebrating 6 months (current month)
		if($current_year_month == $six_months){
			array_push($six_months_staffs_month,$data);
		}
		
		if($year!=date("Y")){
			//filter the staff celebrating yearly anni (current date)
			if($current_month_day == $one_year_date){
				array_push($one_year_staffs_ann_today,$data);
			}
			
			//filter the staff celebrating yearly anni (current month)
			if($current_month == $one_year_month){
				array_push($one_year_staffs_ann,$data);
			}
		}
	}
}

//print_r($one_year_staffs_ann);exit;

if($anni == 6){
	if( $list == 'month'){
		$staffs = $six_months_staffs_month;
		$ann_str = "Hired 6 Months ago";
	}else{
		$staffs = $six_months_staff_ann_today;
		$ann_str = "Hired 6 Months ago<br />Celebrating today";
		//echo $ann_str;exit;
	}	
	
}else{
	if( $list == 'month'){
		$staffs = $one_year_staffs_ann;
		$ann_str = "Yearly anniversary";
	}else{
		$staffs = $one_year_staffs_ann_today;
		$ann_str = "Yearly anniversary<br />Celebrating today";
	}
	
}
//echo count($staffs);exit;
$smarty->assign('list',$list);
$smarty->assign('anni',$anni);
$smarty->assign('ann_str',$ann_str);
$smarty->assign('staffs',$staffs);
$smarty->display('ViewAnniStaff.tpl');
?>