<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;


//echo $_SESSION['manager_id'];
//exit;


if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
	require_once("./activecalendar-admin.php");
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
	require_once("./activecalendar-client.php");
}else if($_SESSION['userid'] != "" || $_SESSION['userid']!=NULL){
	$comment_by_id = $_SESSION['userid'];
	$comment_by_type = 'personal';	
	require_once("./activecalendar-staff.php");
}else if($_SESSION['manager_id'] != "" || $_SESSION['manager_id']!=NULL){
	$comment_by_id = $_SESSION['manager_id'];
	$comment_by_type = 'client_managers';
	require_once("./activecalendar-client.php");
	
}else{
	die("Session Expired. Please re-login");
}

$userid = $_REQUEST['userid'];
if(!$userid){
	if(!$_SESSION['userid']){
		echo "Please click on the name of the staff shown in the Select Staff List.";
	}else{
		echo "USERID is Missing";
	}
	exit;
}

$query="SELECT * FROM personal WHERE userid=$userid";
$staff = $db->fetchRow($query);



//multiple client
$sql = $db->select()
->from(array('s' => 'subcontractors') , Array('leads_id'))
->joinleft(array('l' => 'leads') , 'l.id = s.leads_id' , Array('fname' , 'lname' ,'email'))
->where('userid = ?' ,$userid)
->where('s.status =?' , 'ACTIVE');
//echo $sql;	
$leads = $db->fetchAll($sql);
foreach($leads as $leads){
	$leads_options .= "<div>".$leads['fname']." ".$leads['lname']." - ".$leads['email']."</div>";
}


//$sql = "SELECT * FROM leave_request WHERE YEAR(date_of_leave) = ".date('Y')." AND userid = ".$userid;	
$sql = $db->select()
	->from('leave_request' , Array('id'))
	->where('userid =?' , $userid);
$leave_requests = $db->fetchAll($sql);


$bgcolor = ''; // default


//print_r($leave_requests);exit;
		
			
$yearID=false; // init false to display current year
$monthID=false; // init false to display current month
$dayID=false; // init false to display current day

extract($_GET); // get the new values (if any) of $yearID,$monthID,$dayID
$arrowBack="<img src=\"images/back.png\" border=\"0\" alt=\"&lt;&lt;\" />"; // use png arrow back
$arrowForw="<img src=\"images/forward.png\" border=\"0\" alt=\"&gt;&gt;\" />"; // use png arrow forward


$cal = new activeCalendar($yearID,$monthID,$dayID);
//$cal = new activeCalendar();

if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$cal->enableDayLinks($myurl); // enables day links
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	//$cal->enableDayLinks($myurl); // enables day links
}else if($_SESSION['userid'] != "" || $_SESSION['userid']!=NULL){
	$cal->enableDayLinks($myurl); // enables day links
}else if($_SESSION['manager_id'] != "" || $_SESSION['manager_id']!=NULL){
    //$cal->enableDayLinks($myurl); // enables day links 	
}else{
	die("Session Expired. Please re-login");
}
//$cal->enableWeekNum("Week"); // enables week number column
$cal->setFirstWeekDay(0);; // '0' -> Sunday , '1' -> Monday


foreach($leave_requests as $leave_request){

	$sql = $db->select()
		->from('leave_request_dates')
		->where('leave_request_id =?' , $leave_request['id']);
	$leave_request_dates = $db->fetchAll($sql);	
	foreach($leave_request_dates as $leave_request_date){
	
			$det = new DateTime($leave_request_date['date_of_leave']);
			$year = $det->format("Y");
			$month = $det->format("m");
			$day = $det->format("d");
			
			if($leave_request_date['status'] == 'pending'){
				$bgcolor = '#FFFF00'; //yellow
			}else if($leave_request_date['status'] == 'approved'){
					$bgcolor = '#00FF00'; // green
			}else if($leave_request_date['status'] == 'denied'){
				$bgcolor = '#FF0000'; // red
			}else if($leave_request_date['status'] == 'cancelled'){
				$bgcolor = '#CCCCCC'; // red
			}else if($leave_request_date['status'] == 'absent'){	
				$bgcolor = '#0000FF'; // blue	
			}else{
				$bgcolor = ''; // default
			}
			$cal->setEventContent("$year","$month","$day","$bgcolor");
		
	}


}

$calendar = $cal->showYear(4);

$smarty->assign('leads_options',$leads_options);
$smarty->assign('staff',$staff);
$smarty->assign('comment_by_type',$comment_by_type);
$smarty->assign('calendar' , $calendar);
$smarty->display('ShowStaffAllRequestedLeave.tpl');

?>