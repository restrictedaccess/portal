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
	$conditions = " YEAR(datecreated) = '".$year."' ";
	$from = $year."-01-01";
	$to = $year."-12-31";
}else if($month_search == "yes"){
	if($month == ""){
		$month=date("m");
	}
	if($year == ""){
		$year=date("Y");
	}
	$conditions = " YEAR(datecreated) = '".$year."' AND  MONTH(datecreated) = '".$month."' ";
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
	$conditions = " DATE(datecreated) ='".$from."'  ";
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
	$conditions = " datecreated BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59' ";
}
		
$sql = "SELECT userid , fname ,lname , email , datecreated  FROM personal WHERE $conditions ORDER BY datecreated ASC , fname ASC";
//echo $sql;exit;

$staffs = $db->fetchAll($sql);
foreach($staffs as $staff){
	
	if($bgcolor == '#FFFFCC'){
		$bgcolor = '#eeeeee';
	}else{
		$bgcolor = '#FFFFCC';
	}
		$counter++;
		
	$det = new DateTime($staff['datecreated']);
	$datecreated = $det->format("F j, Y");
				
	$staff_list .="<tr bgcolor='".$bgcolor."'>
					<td ><strong>".$counter."</strong></td>
					<td >".$staff['userid']."</td>
					<td style='text-transform:capitalize;' ><span class='leads_list' page='../application_apply_action.php?userid=".$staff['userid']."&page_type=popup' >".$staff['fname']." ".$staff['lname']."</span></td>
					<td >".$staff['email']."</td>					";
	//working hours
	$staff_list .="<td >";
		$staff_list .=$datecreated;
	$staff_list .="</td>";
	
	
	
	
	$staff_list .="</tr>";
					
}	

$smarty->assign('year_search',$year_search);
$smarty->assign('year',$year);

$smarty->assign('from',$from);
$smarty->assign('to',$to);
$smarty->assign('staff_list',$staff_list);
$smarty->display('ApplicantsSheet.tpl');
?>