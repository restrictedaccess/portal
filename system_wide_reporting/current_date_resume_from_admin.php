<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$year = $_REQUEST['year'];
$year_search = $_REQUEST['year_search'];
$month = $_REQUEST['month'];
$month_search = $_REQUEST['month_search'];
$date_search = $_REQUEST['date_search'];
$specific_date = $_REQUEST['specific_date'];

if($year_search == "yes"){
	if($year == ""){
		$year=date("Y");
	}
	$conditions = " YEAR(r.date_created) = '".$year."' ";
	$from = $year."-01-01";
	$to = $year."-12-31";
}else if($month_search == "yes"){
	if($month == ""){
		$month=date("m");
	}
	if($year == ""){
		$year=date("Y");
	}
	$conditions = " YEAR(r.date_created) = '".$year."' AND  MONTH(r.date_created) = '".$month."' ";
	$date = new DateTime();
	$date->setDate($year, $month, date("d"));
	$start_date_ref = $date->format('Y-m-01');
	$end_date_ref = $date->format('Y-m-t');
	if(!$from){
		$from = $start_date_ref;
	}
	if(!$to){
		$to = $end_date_ref;
	}
}else if($date_search == 'yes'){
	$from = $_REQUEST['from'];
	$to = $_REQUEST['from'];
	$conditions = " DATE(r.date_created) ='".$from."'  ";
	//echo $from;exit;	
}else{
	
	$from = $_REQUEST['from'];
	$to = $_REQUEST['to'];
	$staff_list ="";
	
	if(!$from){
		$from = date("Y-m-d");
	}
	
	if(!$to){
		$date = new DateTime();
		$to = $date->format('Y-m-t');
	}
	/*
	$start_date_of_leave = explode('-',$to);
	$year = $start_date_of_leave[0];
	$month = $start_date_of_leave[1];
	$day = $start_date_of_leave[2];
	
	$date = new DateTime();
	$date->setDate($year, $month, $day);
	$date->modify("+1 day");
	
	$date_end_str = $date->format("Y-m-d");
	*/
	$conditions = " r.date_created BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59' ";
}
		
$sql = "SELECT r.userid , p.fname , p.lname , p.email , r.date_created  FROM resume_creation_history r JOIN personal p ON p.userid=r.userid WHERE $conditions ORDER BY datecreated ASC , fname ASC";
$applicants = $db_query_only->fetchAll($sql);
//echo "<pre>";
//print_r($applicants);
//echo "</pre>";
$ctr = 0;
foreach($applicants as $applicant){
	$ctr=$ctr + 1;
	$data[]=array(
		'counter' => $ctr,
		'userid' => $applicant['userid'],
		'fname' => $applicant['fname'],
		'lname' => $applicant['lname'],
		'email' => $applicant['email'],
		'date_created' => $applicant['date_created']
	);
}

$smarty->assign('row_results',count($applicants));
$smarty->assign('applicants' , $data);
$smarty->display('total_no_of_resume_from_admin.tpl');
?>