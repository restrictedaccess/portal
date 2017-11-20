<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];

if(!$from){
	$from = date("Y-m-d");
}

if(!$to){
	$to = $from;
	$start_date_of_leave = explode('-',$to);
	$year = $start_date_of_leave[0];
	$month = $start_date_of_leave[1];
	$day = $start_date_of_leave[2];
	
	$date = new DateTime();
	$date->setDate($year, $month, $day);
	$date->modify("+1 day");
	
	$date_end_str = $date->format("Y-m-d");
}else{
	$date_end_str = $to;
}



$date = new DateTime($from);
$from_str = $date->format("F j, Y");

$one_year_date = $date->format("m-d");
//echo $year."-".$month."<br>";
//$current_date = $date->format("Y-m-d");
$current_date = date("Y-m-d");
//echo $current_date."<br>";
$current_year_month = $date->format("Y-m");//date("Y-m");
$current_year = $date->format("Y");//date("Y");
//$current_month_day = $date->format("m-d");//date("m-d");
$current_month_day = date("m-d");
$current_month = $date->format("m");//date("m");

$det = new DateTime($to);
$to_str = $det->format("F j, Y");


$sql = "SELECT DISTINCT(userid) from subcontractors WHERE status IN('ACTIVE', 'suspended') AND starting_date BETWEEN  '".$from."' AND '".$date_end_str."'";
$active_staff_result = $db->fetchAll($sql);
//echo $sql;
$sql = "SELECT DISTINCT(userid) from subcontractors WHERE status IN('terminated', 'resigned') AND starting_date BETWEEN  '".$from."' AND '".$date_end_str."'";
$non_active_staff_result = $db->fetchAll($sql);






//$sql = "SELECT id, userid , starting_date from subcontractors WHERE status = 'ACTIVE' AND starting_date BETWEEN  '".$from."' AND '".$date_end_str."'";
$sql = "SELECT id , userid , starting_date from subcontractors  WHERE status IN('ACTIVE', 'suspended')";

//echo $sql;

$staffs = $db->fetchAll($sql);	
//echo $sql;
//echo date("m-d")."<br>";
foreach($staffs as $staff){
	//echo $staff['starting_date']."<br> ";
	if($staff['starting_date']){
		$starting_date = explode('-',$staff['starting_date']);
		$year = $starting_date[0];
		$month = $starting_date[1];
		$day = $starting_date[2];
		
		$date = new DateTime();
		$date->setDate($year, $month, $day);
		$one_year_date = $date->format("m-d");
		$one_year_month = $date->format("m");
		
		
		$date->modify("+6 month");
		$six_months_date = $date->format("Y-m-d");
		$six_months = $date->format("Y-m");
		//echo "6 months ann. today ".$six_months_date."<br>";
		//echo "6 months anni. this month ".$six_months."<br>";
		
		//filters the staff celebrating 6 months (current date)
		if($current_date == $six_months_date){
			$six_months_anni++;
			
		}
		//filters the staff celebrating 6 months (current month)
		if($current_year_month == $six_months){
			$six_months_count++;
		}
		
		if($current_year != $year){
			//filter the staff celebrating yearly anni (current date)
			if($current_month_day == $one_year_date){
				$year_anni++;
			}
			
			//filter the staff celebrating yearly anni (current month)
			if($current_month == $one_year_month){
				$year_anni_count++;
			}
		}
	}
}



















//applicants results
//yearky result
$years = array();
$total_applicant_count = 0;

$sql = "SELECT YEAR(datecreated)AS year FROM personal p GROUP BY YEAR(datecreated);";
$years_date = $db->fetchAll($sql);
foreach($years_date as $year){
	if($year['year']!=""){ 
		$sql = "SELECT COUNT(userid)as count FROM personal WHERE YEAR(datecreated) = '".$year['year']."' ";
		$count = $db->fetchOne($sql);
		$total_applicant_count = ($total_applicant_count + $count); 
		$data=array('year'=>$year['year'] , 'count' => $count);
		array_push($years , $data);
	}
}
//current day result
//$sql = "SELECT COUNT(userid)as count FROM personal WHERE DATE(datecreated) = '".$from."' ";
$sql = "SELECT COUNT(userid)as count FROM personal WHERE DATE(datecreated) = '".date("Y-m-d")."' ";
$current_count = $db->fetchOne($sql);
//echo $sql;
//currrent month
$det = new DateTime($from);
$current_month = $det->format("m");
$current_month_str = $det->format("F");

$sql = "SELECT COUNT(userid)as count FROM personal WHERE datecreated BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59' ";
//echo $sql;
$current_month_count = $db->fetchOne($sql);



//load job order counts synced in the database
$countsOrder = $db->fetchAll($db->select()->from(array("joc"=>"job_orders_count")));
$asl_15_counts = 0;
$custom_15_counts = 0;
$backorder_15_counts = 0;
$inhouse_15_counts = 0;
$replacement_15_counts = 0;
$asl_open_counts = 0;
$custom_open_counts = 0;
$backorder_open_counts = 0;
$replacement_open_counts = 0;
$inhouse_open_counts = 0;

foreach($countsOrder as $countOrder){
	if ($countOrder["service_type"]=="ASL"&&$countOrder["summary_type"]=="LAST 15 DAYS"){
		$asl_15_counts = $countOrder["count"];	
	}
	if ($countOrder["service_type"]=="CUSTOM"&&$countOrder["summary_type"]=="LAST 15 DAYS"){
		$custom_15_counts = $countOrder["count"];	
	}
	if ($countOrder["service_type"]=="BACK ORDER"&&$countOrder["summary_type"]=="LAST 15 DAYS"){
		$backorder_15_counts = $countOrder["count"];	
	}
	if ($countOrder["service_type"]=="REPLACEMENT"&&$countOrder["summary_type"]=="LAST 15 DAYS"){
		$replacement_15_counts = $countOrder["count"];	
	}
	if ($countOrder["service_type"]=="INHOUSE"&&$countOrder["summary_type"]=="LAST 15 DAYS"){
		$inhouse_15_counts = $countOrder["count"];	
	}
	if ($countOrder["service_type"]=="ASL"&&$countOrder["summary_type"]=="OPEN ORDERS"){
		$asl_open_counts = $countOrder["count"];
	}
	if ($countOrder["service_type"]=="CUSTOM"&&$countOrder["summary_type"]=="OPEN ORDERS"){
		$custom_open_counts = $countOrder["count"];
	}
	if ($countOrder["service_type"]=="BACK ORDER"&&$countOrder["summary_type"]=="OPEN ORDERS"){
		$backorder_open_counts = $countOrder["count"];
	}
	if ($countOrder["service_type"]=="INHOUSE"&&$countOrder["summary_type"]=="OPEN ORDERS"){
		$inhouse_open_counts = $countOrder["count"];
	}
	if ($countOrder["service_type"]=="REPLACEMENT"&&$countOrder["summary_type"]=="OPEN ORDERS"){
		$replacement_open_counts = $countOrder["count"];
	}
}


$smarty->assign("asl_15_counts", $asl_15_counts);
$smarty->assign("custom_15_counts", $custom_15_counts);
$smarty->assign("backorder_15_counts", $backorder_15_counts);
$smarty->assign("replacement_15_counts", $replacement_15_counts);
$smarty->assign("inhouse_15_counts", $inhouse_15_counts);

$smarty->assign("asl_open_counts", $asl_open_counts);
$smarty->assign("custom_open_counts", $custom_open_counts);
$smarty->assign("backorder_open_counts", $backorder_open_counts);
$smarty->assign("replacement_open_counts", $replacement_open_counts);
$smarty->assign("inhouse_open_counts", $inhouse_open_counts);
$smarty->assign("date_from_jo", date("Y-m-d", strtotime("-15 day", strtotime(date("Y-m-d")))));
$smarty->assign("date_to_jo", date("Y-m-d"));


$smarty->assign('total_applicant_count',$total_applicant_count);
$smarty->assign('six_months_anni',$six_months_anni);
$smarty->assign('six_months_count',$six_months_count);
$smarty->assign('year_anni',$year_anni);
$smarty->assign('year_anni_count',$year_anni_count);


$smarty->assign('years',$years);
$smarty->assign('year_report_str',$year_report_str);
$smarty->assign('current_count',$current_count);
$smarty->assign('current_month_count',$current_month_count);
$smarty->assign('current_month_str',$current_month_str);
$smarty->assign('from' , $from);
$smarty->assign('today_date' , date("Y-m-d"));
$smarty->assign('to' , $to);
$smarty->assign('from_str' , $from_str);
$smarty->assign('to_str' , $to_str);
$smarty->assign('active_staff_result_count',count($active_staff_result));
$smarty->assign('non_active_staff_result_count',count($non_active_staff_result));
$smarty->assign('view_anni_staff_mode' , 'from_to');
$smarty->display('SearchSubconQuickViewByFromTo.tpl');
?>