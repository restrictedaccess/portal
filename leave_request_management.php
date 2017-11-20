<?php
include('conf/zend_smarty_conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

require_once("./leave_request_form/activecalendar-leave-request-management.php");

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

if($_SESSION['manager_id'] != ""){
	header("location:./leave_request/manager/");
	exit;
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);	
	$_SESSION['client_id'] = $manager['leads_id'];
}

if($_SESSION['client_id']){
	header("location:./leave_request/client/");
	exit;
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$_SESSION['client_id']);
	$lead = $db->fetchRow($sql);
	$smarty->assign('leads_id' , $_SESSION['client_id']);
	$smarty->assign('client_section',True);
	$smarty->assign('user_type','leads');
	
	$sql="SELECT DISTINCT(d.date_of_leave) FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND YEAR(d.date_of_leave)='".$yearID."';";
	$leave_request_dates = $db->fetchAll($sql);

	
}else if($_SESSION['admin_id']){
	header("location:./leave_request/admin/");
	exit;
	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
		
	$admin = $db->fetchRow($sql);
	$smarty->assign('admin_section',True);	
	$smarty->assign('leads_id' , 'all');
	$smarty->assign('user_type','admin');
	
	$sql="SELECT DISTINCT(date_of_leave) FROM leave_request_dates WHERE YEAR(date_of_leave)='".$yearID."';";
	//$sql="SELECT DISTINCT(date_of_leave) FROM leave_request_dates WHERE date_of_leave='2013-03-09';";
	$leave_request_dates = $db->fetchAll($sql);
	
}else{
	header("location:index.php");
	exit;
}

function showName($id , $type){
	global $db;
	if($id){
			if($type == "admin"){
				$sql = $db->select()
					 ->from('admin')
					 ->where('admin_id = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Administrator  ".$result['admin_fname']." ".$result['admin_lname'];
					 
			}else {
				$sql = $db->select()
					 ->from('leads')
					 ->where('id = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Client  ".$result['fname']." ".$result['lname'];
					 
			}
	
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
$pending_num =0;
$approved_num =0;
$denied_num =0;
$cancelled_num =0;
$absent_num =0;
//echo "<pre>";
//print_r($leave_request_dates);
//echo "</pre>";
//exit;
foreach($leave_request_dates as $leave_request_date){

	//check each date pending status
	if($_SESSION['client_id']){
		$sql="SELECT COUNT(d.id)AS pending_num FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status='pending' GROUP BY d.status;";
		$pending_num = $db->fetchOne($sql);
		$sql="SELECT COUNT(d.id)AS approved_num FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status='approved' GROUP BY d.status;";
		$approved_num = $db->fetchOne($sql);
	}else{
		$sql = "SELECT COUNT(id)AS pending_num FROM leave_request_dates WHERE date_of_leave='".$leave_request_date['date_of_leave']."' AND status='pending' GROUP BY status;";
		$pending_num = $db->fetchOne($sql);
		$sql = "SELECT COUNT(id)AS approved_num FROM leave_request_dates WHERE date_of_leave='".$leave_request_date['date_of_leave']."' AND status='approved' GROUP BY status;";
		$approved_num = $db->fetchOne($sql);
	}
	//echo $sql."<br>";
	//echo $pending_num."<br>";
	//echo "<hr>";
	//echo $sql."<br>";
	//echo $approved_num."<br>";
	if($pending_num == 0 and $approved_num==0){
	
	    
		if($_SESSION['client_id']){
			$sql="SELECT * FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE l.leads_id=".$_SESSION['client_id']." AND d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status not in ('pending', 'approved');";
		}else{
			$sql = "SELECT * FROM leave_request_dates WHERE date_of_leave='".$leave_request_date['date_of_leave']."' AND status not in ('pending', 'approved');";
		}
	    $dates = $db->fetchAll($sql);	
		foreach($dates as $date){
	
			$year = date('Y', strtotime($date['date_of_leave']));
		    $month = date('m', strtotime($date['date_of_leave']));
		    $day = date('d', strtotime($date['date_of_leave']));
			$bgcolor = ''; // default
			if($date['status'] == 'pending'){
				$bgcolor = '#FFFF00'; //yellow
			}else if($date['status'] == 'approved'){
				$bgcolor = '#00FF00'; // green
			}else if($date['status'] == 'denied'){
				$bgcolor = '#FF0000'; // red
			}else if($date['status'] == 'cancelled'){
				$bgcolor = '#CCCCCC'; // gray
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

if (isset($_REQUEST["page_type"])){
	$smarty->assign("page_type", $_REQUEST["page_type"]);
}else{
	$smarty->assign("page_type", "");
}

$smarty->assign('calendar',$calendar);
$smarty->assign('yearOptions',$yearOptions);
$smarty->display('leave_request_management.tpl');
?>