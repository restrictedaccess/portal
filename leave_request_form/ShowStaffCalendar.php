<?php
include '../conf/zend_smarty_conf.php';
include 'leave_request_function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;


$comment_by_type="";
if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
}else if($_SESSION['userid'] != "" || $_SESSION['userid']!=NULL){
	$comment_by_id = $_SESSION['userid'];
	$comment_by_type = 'personal';	
}else if($_SESSION['manager_id'] != "" || $_SESSION['manager_id']!=NULL){
	$comment_by_id = $_SESSION['manager_id'];
	$comment_by_type = 'client_managers';
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);
	
}else{
	die("Session Expired. Please re-login");
}

$id = $_REQUEST['id'];
if(!$id){
	die('Leave Request ID is missing');
}

$sql = $db->select()
	->from('leave_request' , 'userid')
	->where('id =? ' ,$id);
$userid = $db->fetchOne($sql);	

if(!$userid){
	die('Staff USERID is missing');
}

$query="SELECT * FROM personal WHERE userid=$userid";
$staff = $db->fetchRow($query);




if($comment_by_type == 'admin'){
//the user is Admin
	$sql = $db->select()
		->from(array('r' => 'leave_request') )
		//->joinleft(array('a' => 'admin') , 'a.admin_id = r. response_by_id' , Array('admin_fname'))
		->joinleft(array('l' => 'leads') , 'l.id = r.leads_id ' , Array('leads_id' => 'id','fname' , 'lname' , 'email'))
		->where('r.id =?' , $id);
	$leave_request = $db->fetchRow($sql); 	
	require_once("./activecalendar-staff.php");
}

if($comment_by_type == 'leads'){
    //the user is client
	$sql = $db->select()
		->from(array('r' => 'leave_request') )
		//->joinleft(array('a' => 'admin') , 'a.admin_id = r. response_by_id' , Array('admin_fname'))
		->joinleft(array('l' => 'leads') , 'l.id = r.leads_id ' , Array('leads_id' => 'id','fname' , 'lname' , 'email'))
		->where('leads_id =?' , $_SESSION['client_id'])
		->where('r.id =?' , $id);
	$leave_request = $db->fetchRow($sql); 	
	require_once("./activecalendar-staff.php");
}
if($comment_by_type == 'client_managers'){
	
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);
	
	//the user is client
	$sql = $db->select()
		->from(array('r' => 'leave_request') )
		//->joinleft(array('a' => 'admin') , 'a.admin_id = r. response_by_id' , Array('admin_fname'))
		->joinleft(array('l' => 'leads') , 'l.id = r.leads_id ' , Array('leads_id' => 'id','fname' , 'lname' , 'email'))
		->where('leads_id =?' , $manager['leads_id'])
		->where('r.id =?' , $id);
	$leave_request = $db->fetchRow($sql); 	
	require_once("./activecalendar-staff.php");
}
if($comment_by_type == 'personal'){
	$sql = $db->select()
		->from(array('r' => 'leave_request') )
		//->joinleft(array('a' => 'admin') , 'a.admin_id = r. response_by_id' , Array('admin_fname'))
		->joinleft(array('l' => 'leads') , 'l.id = r.leads_id ' , Array('leads_id' => 'id','fname' , 'lname' , 'email'))
		->where('r.userid =?' , $_SESSION['userid'])
		->where('r.id =?' , $id);
	$leave_request = $db->fetchRow($sql); 	
	require_once("./activecalendar-staff.php");
}

$sql = $db->select()
	->from('leave_request_dates')
	->where('leave_request_id =?' , $leave_request['id']);
$leave_request_dates = $db->fetchAll($sql);
//echo $sql;exit;
//echo 'here '.stripslashes($leave_request['reason_for_leave']);
$sql = $db->select()
	->from('leave_request_history')
	->where('leave_request_id =?' , $leave_request['id']);
$leave_request_histories = $db->fetchAll($sql);	
//echo $sql;exit;
//id, leave_request_id, notes, response_by_id, response_by_type, response_date
foreach($leave_request_histories as $leave_request_history){
	//echo ShowName($leave_request_history['response_by_id'] , $leave_request_history['response_by_type'])."<br>";
	$det = new DateTime($leave_request_history['response_date']);
	$det->format("F j, Y");
	$leave_request_history_str .="<b>Changes made by ".ShowName($leave_request_history['response_by_id'] , $leave_request_history['response_by_type']). " ".$det->format("F j, Y")."</b><br>";
	
	$leave_request_history_str .="<div style='margin-left:20px;'>".$leave_request_history['notes']."</div>";

}

//echo $leave_request_history_str;exit;

$sql = "SELECT YEAR(date_of_leave) AS year , MONTH(date_of_leave) AS month FROM leave_request_dates l WHERE (leave_request_id ='".$leave_request['id']."') GROUP BY MONTH(date_of_leave)";
$results = $db->fetchAll($sql);
foreach($results as $result){

	$cal = new activeCalendar($result['year'] , $result['month']);
	$cal->setFirstWeekDay(0);; // '0' -> Sunday , '1' -> Monday	
	$sql = "SELECT date_of_leave , status FROM leave_request_dates WHERE (leave_request_id ='".$leave_request['id']."') AND YEAR(date_of_leave) = ".$result['year']." AND MONTH(date_of_leave) = ".$result['month'];
	//echo $sql."<br>";
	$leave_requested_dates = $db->fetchAll($sql);
	//print_r($leave_requested_dates)."<hr>";
	foreach($leave_requested_dates as $leave_requested_date){
			
			$det = new DateTime($leave_requested_date['date_of_leave']);
			$year = $det->format("Y");
			$month = $det->format("m");
			$day = $det->format("d");
			
			if($leave_requested_date['status'] == 'pending'){
				$bgcolor = '#FFFF00'; //yellow
			}else if($leave_requested_date['status'] == 'approved'){
					$bgcolor = '#00FF00'; // green
			}else if($leave_requested_date['status'] == 'denied'){
				$bgcolor = '#FF0000'; // red
			}else if($leave_requested_date['status'] == 'cancelled'){
				$bgcolor = '#CCCCCC'; // red
			}else if($leave_requested_date['status'] == 'absent'){	
				$bgcolor = '#0000FF'; // blue	
			}else{
				$bgcolor = ''; // default
			}
			
			//$bgcolor = '#FFFF00'; //yellow
			//echo $year." ".$month." ".$day."<br> ";
			$cal->setEventContent("$year","$month","$day","$bgcolor");
			//$cal->setEventContent("2011","03","01","$bgcolor");
	}		

	
	$calendar .= $cal->showMonth(false);
}

//echo $calendar;
//exit;

$smarty->assign('comment_by_type',$comment_by_type);
$smarty->assign('leave_request_history_str' , $leave_request_history_str);
$smarty->assign('leave_request_history_ctr' , count($leave_request_histories));

$smarty->assign('staff' , $staff);
$smarty->assign('userid',$userid);
$smarty->assign('id' ,$id);
$smarty->assign('calendar' , $calendar);
$smarty->assign('reason_for_leave' ,stripslashes($leave_request['reason_for_leave']) );
$smarty->assign('leave_request' , $leave_request);
$smarty->assign('leave_request_dates' , $leave_request_dates);

$smarty->display('ShowStaffCalendar.tpl');

?>