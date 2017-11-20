<?php
include '../conf/zend_smarty_conf.php';
include 'leave_request_function.php';
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


$userid = $_REQUEST['userid'];
	
$query="SELECT * FROM personal WHERE userid=$userid";
$staff = $db->fetchRow($query);


$leave_type = $_REQUEST['leave_type'];
$leave_duration = $_REQUEST['leave_duration'];
$start_date_of_leave = $_REQUEST['start_date_of_leave'];
$end_date_of_leave = $_REQUEST['end_date_of_leave'];
$reason_for_leave = trim($_REQUEST['reason_for_leave']) ;
$leads = explode(',',$_REQUEST['leads']);

$start_date_of_leave = explode('-',$start_date_of_leave);
$year = $start_date_of_leave[0];
$month = $start_date_of_leave[1];
$day = $start_date_of_leave[2];

//$date = new DateTime();
//$date->setDate($year, $month, $day);

//get the difference
if(!$end_date_of_leave){
	$end_date_of_leave = $_REQUEST['start_date_of_leave'];
}

$today = strtotime($end_date_of_leave);
$myBirthDate = strtotime($_REQUEST['start_date_of_leave']);
$diff = round(abs($today-$myBirthDate)/60/60/24);

$response_note = "<p><span style='text-transform:capitalize;'>Manually Added in behalf of Staff </span> by ".ShowName($_SESSION['admin_id'] , 'admin')." <em>".$ATZ ."</em></p>";

for($i=0 ; $i<count($leads); $i++ ){
		//get the leads info
		$sql = $db->select()
			->from('leads')
			->where('id =?' , $leads[$i]);
		$leads_info = $db->fetchRow($sql);
		//echo $leads_info['fname']." ".$leads_info['lname']."\n";
		
		//get the staff timezone in timesheet
		$sql = $db->select()
			->from('timesheet' , 'timezone_id')
			->where('userid =?' , $userid)
			->where('leads_id =?' ,$leads[$i]);
		$timezone_id = $db->fetchOne($sql);
		
		if(!$timezone_id){
			$timezone_id = 1;
		}
		
		$data = array(
					'userid' => $userid, 
					'leads_id' => $leads[$i], 
					'leave_type' => $leave_type, 
					'reason_for_leave' => $reason_for_leave, 
					'date_requested' => $ATZ,
					'leave_duration' => $leave_duration,
					'timezone_id' => $timezone_id
				);
		$db->insert('leave_request' , $data);
		$leave_request_id = $db->lastInsertId();
		
		$start_date_of_leave = explode('-',$_REQUEST['start_date_of_leave']);
		$year = $start_date_of_leave[0];
		$month = $start_date_of_leave[1];
		$day = $start_date_of_leave[2];
		
		$date = new DateTime();
		$date->setDate($year, $month, $day);

		//$date->modify("-1 day");
		$date_of_leave ="";
		for($j=0; $j<=$diff; $j++ ){	
				
				
				$date_of_leave .= "<li>".$date->format("F j, Y => l")."</li>";
				$data = array('leave_request_id' => $leave_request_id, 'date_of_leave' => $date->format("Y-m-d")  );
				if($leave_type == 'Absent'){
				    $data['status'] = 'absent';
				}
				$db->insert('leave_request_dates' , $data);
				$date->modify("+1 day");
			
		}
		
				
		$order   = array("\r\n", "\n", "\r");
		$replace = '<br />';
		// Processes \r\n's first so they aren't converted twice.
		$reason_for_leave = str_replace($order, $replace, $reason_for_leave);
		
		$body = "<p>Dear ".$leads_info['fname']." ".$leads_info['lname']."</p>";
		$body .= "<p>Staff ".$staff['fname']." ".$staff['lname']." is ".$leave_type." :  </p>";
		
		
		$body .= "<ol><strong><u>Days ".$leave_type."</u></strong>";
		$body .= $date_of_leave;
		$body .= "</ol>";
		
		$body .= "<p>&nbsp;</p>";
		$body .= "<p><b><u>Details</u></b></p>";
		$body .= "<p>Leave Type :  ".$leave_type." [ ".$leave_duration." ]</p>";
		$body .= "<p>Reason : ".stripslashes($reason_for_leave)."</p>";
		
		$body .= "<p>&nbsp;</p>";
		
		$body .= "<p>NOTE : </p>";
		$body .= $response_note;
		
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom('attendance@remotestaff.com.au' , 'Attendance');
		if(!TEST){
			$mail->addTo($staff['email'], $staff['fname']." ".$staff['lname']);
			$mail->addTo($leads_info['email'], $leads_info['fname']." ".$leads_info['lname']);
			$mail->addCc('attendance@remotestaff.com.au' , 'Attendance');// Adds a recipient to the mail with a "Cc" header
			$mail->setSubject("Remotestaff ".$staff['fname']." ".$staff['lname']." is ".$leave_type." to Client ".$leads_info['fname']." ".$leads_info['lname']);
		}else{
			$mail->addTo('devs@remotestaff.com.au' , 'Inhouse Developers');
			$mail->setSubject("TEST Remotestaff ".$staff['fname']." ".$staff['lname']." is ".$leave_type." to Client ".$leads_info['fname']." ".$leads_info['lname']);
		}
		
		$mail->send($transport);
		
		$leads_name .=$leads_info['fname']." ".$leads_info['lname']."<br>";
		
		//insert history
		if($leave_type == 'Absent'){
		    $history_changes = "MARKED ABSENT by ".ShowName($_SESSION['admin_id'] , 'admin');
		}else{
		    $history_changes = "Manually added in behalf of the staff by ".ShowName($_SESSION['admin_id'] , 'admin');
		}
		
		
		$data = array(
				'leave_request_id' => $leave_request_id, 
				'notes' => $history_changes, 
				'response_by_id' => $comment_by_id, 
				'response_by_type' => $comment_by_type,
				'response_date' => $ATZ
			);
		$db->insert('leave_request_history' , $data);
		
		//$history_id .= $db->lastInsertId()."<br>";
		
}


echo "<div style='padding:20px;'>Staff ".$staff['fname']." ".$staff['lname']." marked ".$leave_type." successfully. <br>An email notification was sent to client(s) : <br>".$leads_name."</div>";;

//echo $history_id;
exit;
?>