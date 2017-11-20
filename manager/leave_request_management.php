<?php
include('../conf/zend_smarty_conf.php');
include('../leave_request_form/leave_request_function.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

require_once("../leave_request_form/activecalendar-leave-request-management.php");

$yearID = $_REQUEST['year'];
if(!$yearID){
	$yearID = date('Y');
}
$monthID=false; // init false to display current month
$dayID=false; // init false to display current day
$cal = new activeCalendar($yearID,$monthID,$dayID);
$cal->setFirstWeekDay(0);; // '0' -> Sunday , '1' -> Monday
$cal->enableDayLinks($myurl); // enables day links

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['manager_id'] == ""){
	die("Session expires. Please re-login.");
}

if($_SESSION['manager_id'] != ""){
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);	
	$leads_id = $manager['leads_id'];
	$subcons=array();
	if($manager['view_staff'] == 'specific'){
		$sql = $db->select()
		    ->from('client_managers_specific_staffs')
			->where('client_manager_id=?', $_SESSION['manager_id']);
		//echo $sql;	
		$subcontractors=$db->fetchAll($sql);
		foreach($subcontractors as $subcon){
			array_push($subcons, $subcon['subcontractor_id']);
		}
	}
}

if($leads_id){
	
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$leads_id);
	$lead = $db->fetchRow($sql);
	$smarty->assign('leads_id' , $leads_id);
	$smarty->assign('client_section',True);
	$smarty->assign('user_type','leads');
	
	$sql = "SELECT r.id, s.userid, (s.id)AS subcon_id FROM leave_request r JOIN subcontractors s ON s.userid = r.userid WHERE s.leads_id = ".$leads_id." AND s.status='ACTIVE';";
	//echo $sql;	
	$leaves = $db->fetchAll($sql);
	$leave_requests=array();
	
	if($manager['view_staff'] == 'specific'){
		foreach($leaves as $leave){
		     if(in_array($leave['subcon_id'], $subcons)){
				 array_push($leave_requests, $leave);
			 }
	    }
	}
	
	if($manager['view_staff'] == 'all'){
		$leave_requests = $leaves;
	}
	
    if($manager['view_staff'] == 'none'){
		$leave_requests=array();
	}
	
}

if(isset($_POST['save'])){
	
	$status = 1;
	
	$userid = $_POST['userid'];
	
	$query="SELECT * FROM personal WHERE userid=$userid";
	$staff = $db->fetchRow($query);

	
	$leave_type = $_POST['leave_type'];
	$reason_for_leave = trim($_POST['reason_for_leave']) ;
	$leads = explode(',',$_POST['leads']);
	
	
$response_note = "<p><span style='text-transform:capitalize;'>Absent manually </span> by ".showName($_SESSION['admin_id'] , 'admin')." ".$leave_request['response_date'] ."</p>";
	
	
	//print_r($leads);
	for($i=0 ; $i<count($leads); $i++ ){
			//echo $leads[$i]."<br>";
			$data =  array(
				'userid' => $userid,
				'leads_id' => $leads[$i],
				'leave_type' => $leave_type,
				'date_of_leave' => $_POST['date_of_leave'],
				'reason_for_leave' => $reason_for_leave,
				'leave_status' => 'absent',
				'date_requested' => $ATZ,
				'response_by_id' => $_SESSION['admin_id'],
				'response_by_type' => 'admin',
				'response_note' => $response_note
			);
		
			//print_r($data);
			$db->insert('leave_request' , $data);
			//send email
			//get the leads email
			$sql = $db->select()
				->from('leads')
				->where('id =?' , $leads[$i]);
			$leads_info = $db->fetchRow($sql);	
			
			$det = new DateTime($_POST['date_of_leave']);
			$date_of_leave = $det->format("F j, Y");
			
			$order   = array("\r\n", "\n", "\r");
			$replace = '<br />';
			// Processes \r\n's first so they aren't converted twice.
			$reason_for_leave = str_replace($order, $replace, $reason_for_leave);
			
			$body = "<p>Dear ".$leads_info['fname']." ".$leads_info['lname']."</p>";
			$body .= "<p>Staff ".$staff['fname']." ".$staff['lname']." is absent on </p>";
			$body .= "<p><b><u>Details</u></b></p>";
			$body .= "<p><strong>Date of Leave/Absence</strong> : ".$date_of_leave."</p>";
			$body .= "<p><strong>Leave Type</strong> : ".$leave_type."</p>";
			$body .= "<p><strong>Reason for Leave</strong> : ".stripslashes($reason_for_leave)."</p>";
			
			$body .= "<p>&nbsp;</p>";
			
			$body .= "<p>NOTE : </p>";
			$body .= $response_note;
			

			
			$mail = new Zend_Mail();
			$mail->setBodyHtml($body);
			$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
			if(!TEST){
				$mail->addTo($staff['email'], $staff['fname']." ".$staff['lname']);
				$mail->addTo($leads_info['email'], $leads_info['fname']." ".$leads_info['lname']);
				$mail->addCc('attendance@remotestaff.com.au' , 'Attendance');// Adds a recipient to the mail with a "Cc" header
			}else{
				$mail->addTo('devs@remotestaff.com.au' , 'Inhouse Developers');
				//$mail->addCc('rhiza@remotestaff.com.au' , 'Rhiza Lanche');// Adds a recipient to the mail with a "Cc" header
			}
			//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
			$mail->setSubject("Remotestaff ".$staff['fname']." ".$staff['lname']." is Absent to Client ".$leads_info['fname']." ".$leads_info['lname']);
			$mail->send($transport);
		
	}
	
	//exit;
	
	$smarty->assign('result_msg' , 'Staff marked absent successfully');
	//header("location:leave_request_form.php?");

}

for($i=date("Y"); $i >=2010; $i-- ){
	if($yearID == $i){
		$yearOptions.="<option value='".$i."' selected>".$i."</option>";
	}else{
		$yearOptions.="<option value='".$i."' >".$i."</option>";
	}
}

//echo "<pre>";
//print_r($leave_requests);
//echo "</pre>";
if(count($leave_requests) > 0){
	foreach($leave_requests as $leave_request){
	
		$sql = $db->select()
			->from('leave_request_dates')
			->where('leave_request_id =?' , $leave_request['id']);
		//echo $sql;	
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
}

$calendar = $cal->showYear();

$smarty->assign('calendar',$calendar);
$smarty->assign('yearOptions',$yearOptions);
$smarty->display('leave_request_management.tpl');
?>