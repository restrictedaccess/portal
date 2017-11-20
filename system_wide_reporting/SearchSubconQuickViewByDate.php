<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = date("d");

$date = new DateTime();
$date->setDate($year, $month, $day);

$one_year_date = $date->format("m-d");
//echo $year."-".$month."<br>";
//$current_date = $date->format("Y-m-d");
$current_date = date("Y-m-d");
//echo $current_date."<br>";
$current_year_month = $date->format("Y-m");//date("Y-m");
$current_year = $date->format("Y");//date("Y");
//$current_month_day = $date->format("m-d");
$current_month_day = date("m-d");
//echo $current_month_day;
$current_month = $date->format("m");//date("m");

$monthFullName=array(
	1 => 'January',
	2 => 'February',
	3 => 'March',
	4 => 'April',
	5 => 'May',
	6 => 'June',
	7 => 'July',
	8 => 'August',
	9 => 'September',
	10 => 'October',
	11 => 'November',
	12 => 'December' 
);

//MONTH SEARCH
//$sql = "SELECT DISTINCT(s.userid) FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status IN('ACTIVE', 'suspended') AND YEAR(starting_date) = '".$year."' AND MONTH(starting_date)= '".$month."'";
$sql = "SELECT COUNT(id)as active_staff_monthly_result FROM subcontractors s WHERE s.status IN('ACTIVE', 'suspended') AND YEAR(starting_date) = '".$year."' AND MONTH(starting_date)= '".$month."'";
//echo $sql."<br>";
$active_staff_monthly_result = $db_query_only->fetchOne($sql);

//$sql = "SELECT DISTINCT(s.userid) FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status IN('terminated', 'resigned') AND YEAR(starting_date) = '".$year."' AND MONTH(starting_date)= '".$month."'";
$sql = "SELECT COUNT(id)as non_active_staff_monthly_result FROM subcontractors s WHERE s.status IN('terminated', 'resigned') AND YEAR(starting_date) = '".$year."' AND MONTH(starting_date)= '".$month."'";
//echo $sql;exit;
$non_active_staff_monthly_result = $db_query_only->fetchOne($sql);
//echo $sql."<br>";
//exit;

$six_months_anni = 0;
$six_months_count = 0;
$year_anni = 0;
$year_anni_count = 0;

$sql = "SELECT id , userid , starting_date from subcontractors WHERE status IN('ACTIVE', 'suspended')";
/*
$sql = $db->select()
	->from('subcontractors' , Array('id' , 'userid' , 'starting_date'))
	->where('status =?' , 'ACTIVE');
	//->limit(1);
*/	
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
			//echo $staff['id']."<br>";
			
		}
		//filters the staff celebrating 6 months (current month)
		if($current_year_month == $six_months){
			$six_months_count++;
		}
		
		if($year!=date("Y")){
			//filter the staff celebrating yearly anni (current date)
			if($current_month_day == $one_year_date){
			//if($staff['starting_date'] == date("Y-m-d")){
				$year_anni++;
			}
			
			//filter the staff celebrating yearly anni (current month)
			if($current_month == $one_year_month){
				$year_anni_count++;
			}
		}
	}
}	

//echo "result : ".$six_months_anni." ".$six_months_count;
//exit;









//applicants results
//yearky result
$years = array();
$total_applicant_count = 0;

$sql = "SELECT YEAR(datecreated)AS year FROM personal p GROUP BY YEAR(datecreated);";
$years_date = $db_query_only->fetchAll($sql);
foreach($years_date as $year){
	if($year['year']!=""){ 
		$sql = "SELECT COUNT(userid)as count FROM personal WHERE YEAR(datecreated) = '".$year['year']."' ";
		$count = $db_query_only->fetchOne($sql);
		$total_applicant_count = ($total_applicant_count + $count); 
		$data=array('year'=>$year['year'] , 'count' => $count);
		array_push($years , $data);
	}
}
//current day result
$sql = "SELECT COUNT(userid)as count FROM personal WHERE DATE(datecreated) = '".date("Y-m-d")."' ";
$current_count = $db_query_only->fetchOne($sql);
//echo $sql;
//currrent month
$sql = "SELECT COUNT(userid)as count FROM personal WHERE MONTH(datecreated) = '".$_REQUEST['month']."' AND YEAR(datecreated) = '".$_REQUEST['year']."' ";
//echo $sql;
$current_month_count = $db_query_only->fetchOne($sql);


//manually created by Admin
$sql="SELECT count(id)AS total_no_of_resume_from_admin FROM `resume_creation_history`;";
$total_no_of_resume_from_admin = $db_query_only->fetchOne($sql);
$smarty->assign('total_no_of_resume_from_admin', $total_no_of_resume_from_admin);

$sql="SELECT count(id)AS current_date_resume_from_admin FROM `resume_creation_history` WHERE DATE(date_created) = '".date("Y-m-d")."' ";
$current_date_resume_from_admin = $db_query_only->fetchOne($sql);
$smarty->assign('current_date_resume_from_admin', $current_date_resume_from_admin);

$sql="SELECT count(id)AS current_month_resume_from_admin FROM `resume_creation_history` WHERE MONTH(date_created) = '".$_REQUEST['month']."' AND YEAR(date_created) = '".$_REQUEST['year']."' ";
$current_month_resume_from_admin = $db_query_only->fetchOne($sql);
$smarty->assign('current_month_resume_from_admin', $current_month_resume_from_admin);






//load job order counts synced in the database

require_once "../recruiter/reports/JobOrderCounter.php";

$counter = new JobOrderCounter($db);
$fifteenDaySummary = $counter->get15DaySummaryView();
$openSummary = $counter->getSummaryView();

$asl_15_counts = $fifteenDaySummary["totalASL"];
$custom_15_counts = $fifteenDaySummary["totalCustom"];
$backorder_15_counts = $fifteenDaySummary["totalBackOrder"];
$inhouse_15_counts = $fifteenDaySummary["totalInhouse"];
$replacement_15_counts = $fifteenDaySummary["totalReplacement"];
$asl_open_counts = $openSummary["totalASL"];
$custom_open_counts = $openSummary["totalCustom"];
$backorder_open_counts = $openSummary["totalBackOrder"];
$replacement_open_counts = $openSummary["totalReplacement"];
$inhouse_open_counts = $openSummary["totalInhouse"];

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
$smarty->assign('years',$years);
$smarty->assign('year_report_str',$year_report_str);
$smarty->assign('current_count',$current_count);
$smarty->assign('current_month_count',$current_month_count);

$smarty->assign('active_staff_monthly_result_count', $active_staff_monthly_result);
$smarty->assign('non_active_staff_monthly_result_count', $non_active_staff_monthly_result);
$smarty->assign('active_staff_year_count',count($active_staff_year));
$smarty->assign('non_active_staff_year_count',count($non_active_staff_year));

$smarty->assign('six_months_anni',$six_months_anni);
$smarty->assign('six_months_count',$six_months_count);
$smarty->assign('year_anni',$year_anni);
$smarty->assign('year_anni_count',$year_anni_count);



$smarty->assign('active_staff_second_six_months_count',count($active_staff_second_six_months));
$smarty->assign('non_active_second_first_six_months_count',count($non_active_second_first_six_months));
$smarty->assign('month',$_REQUEST['month']);
$smarty->assign('month_str',$monthFullName[$_REQUEST['month']]);
$smarty->assign('year',$_REQUEST['year']);
$smarty->assign('from' , date("Y-m-d"));
$smarty->assign('view_anni_staff_mode' , 'month_year');
$smarty->display('SearchSubconQuickViewByDate.tpl');
?>