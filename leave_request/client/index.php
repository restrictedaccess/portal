<?php
include '../../conf/zend_smarty_conf.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;



require_once("../../leave_request_form/activecalendar-leave-request-management.php");


if(!$_POST['year']){
	$yearID = date('Y');
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['manager_id']){
    
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);	
	$_SESSION['client_id'] = $manager['leads_id'];
}

	
if($_SESSION['client_id']){
    
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$_SESSION['client_id']);
	$lead = $db->fetchRow($sql);
	
}else{
    header("location:/portal/");
    exit;
}

$pending_num =0;
$approved_num =0;
$denied_num =0;
$cancelled_num =0;
$absent_num =0;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$yearID = $_POST['year'];
	
	if($_POST['userid']){
		$search_str = " AND l.userid=".$_POST['userid'];
	}
}
//echo $search_str;exit;
$monthID=false; // init false to display current month
$dayID=false; // init false to display current day
$cal = new activeCalendar($yearID,$monthID,$dayID);
$cal->setFirstWeekDay(0);; // '0' -> Sunday , '1' -> Monday
$cal->enableDayLinks($myurl); // enables day links


$sql="SELECT DISTINCT(d.date_of_leave) FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND YEAR(d.date_of_leave)='".$yearID."' ".$search_str.";";


$leave_request_dates = $db->fetchAll($sql);

foreach($leave_request_dates as $leave_request_date){

	$sql="SELECT COUNT(d.id)AS pending_num FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status='pending' ".$search_str." GROUP BY d.status;";
	//echo $sql;
	$pending_num = $db->fetchOne($sql);
	$sql="SELECT COUNT(d.id)AS approved_num FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status='approved' ".$search_str." GROUP BY d.status;";
	$approved_num = $db->fetchOne($sql);

	if($pending_num == 0 and $approved_num==0){
	
	    
	$sql="SELECT * FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status not in ('pending', 'approved') ".$search_str.";";
    $dates = $db->fetchAll($sql);
	
	
		foreach($dates as $date){
	
			$year = date('Y', strtotime($date['date_of_leave']));
		    $month = date('m', strtotime($date['date_of_leave']));
		    $day = date('d', strtotime($date['date_of_leave']));
			$bgcolor = ''; // default
			if($date['status'] == 'pending'){
				$bgcolor = '#FFFF00'; //yellow
			}else if($date['status'] == 'approved'){
				$bgcolor = '#009900'; // green
			}else if($date['status'] == 'denied'){
				$bgcolor = '#FF0000'; // red
			}else if($date['status'] == 'cancelled'){
				$bgcolor = '#999999'; // gray
			}else if($date['status'] == 'absent'){	
				$bgcolor = '#0000FF'; // blue	
			}else{
				$bgcolor = ''; // default
			}
			$cal->setEventContent("$year","$month","$day","$bgcolor");
		
	    }
	    
	}else{
		
		
		if($approved_num > 0 and  $pending_num == 0){
			$year = date('Y', strtotime($leave_request_date['date_of_leave']));
			$month = date('m', strtotime($leave_request_date['date_of_leave']));
			$day = date('d', strtotime($leave_request_date['date_of_leave']));
			$cal->setEventContent("$year","$month","$day","#00FF00");
		}else{
			$year = date('Y', strtotime($leave_request_date['date_of_leave']));
			$month = date('m', strtotime($leave_request_date['date_of_leave']));
			$day = date('d', strtotime($leave_request_date['date_of_leave']));
			$cal->setEventContent("$year","$month","$day","#FFFF00");
		}
	}
		    
}

//exit;
$calendar = $cal->showYear();

$sql = "SELECT DISTINCT(p.userid) , p.fname , p.lname, s.id FROM personal p JOIN subcontractors s ON s.userid = p.userid WHERE s.status IN('ACTIVE', 'suspended') AND s.leads_id=".$_SESSION['client_id']." ORDER BY p.fname";
//echo $sql;exit;
$staffs = $db->fetchAll($sql);

$year = date("Y");
if(date("m") > 10){
	$year = (date("Y") + 1);
}
for($i=$year; $i >=2010; $i-- ){
	if($yearID == $i){
		$yearOptions.="<option value='".$i."' selected>".$i."</option>";
	}else{
		$yearOptions.="<option value='".$i."' >".$i."</option>";
	}
}

$calendar_indication_str="All Staff Leave Calendar";
if($_POST['userid']){
	$sql="SELECT fname, lname FROM personal WHERE userid=".$_POST['userid'];
	$personal=$db->fetchRow($sql);
	$calendar_indication_str = sprintf('%s %s Leave Request Calendar', $personal['fname'], $personal['lname']);
}

$smarty->assign('calendar_indication_str', $calendar_indication_str);
$smarty->assign('userid', $_POST['userid']);
$smarty->assign('yearID', $yearID);
$smarty->assign('yearOptions',$yearOptions);
$smarty->assign('calendar',$calendar);
$smarty->assign('staffs' , $staffs);
$smarty->assign('lead' , $lead);
$smarty->assign('leads_id' , $_SESSION['client_id']);
$smarty->display('index.tpl');
?>