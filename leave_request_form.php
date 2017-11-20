<?php
include './conf/zend_smarty_conf.php';
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['userid']=="")
{
	header("location:index.php");
	exit;
	//die("Session Expires. Please re-login!");
}
header("location:/portal/django/staff/leave_request");
exit;
$userid = $_SESSION['userid'];
$query="SELECT * FROM personal WHERE userid=$userid";
$staff = $db->fetchRow($query);
$smarty->assign('user_type','personal');

if(isset($_POST['save'])){
	
	$status = 1;
	
	$leave_type = $_POST['leave_type'];
	$reason_for_leave = trim($_POST['reason_for_leave']) ;
	$leads = explode(',',$_POST['leads']);
	
	
	$sql = $db->select()
		->from('leave_request' , 'id')
		->where('userid =?' , $_SESSION['userid'])
		//->where('leave_status !=?', 'cancelled')
		->where('date_of_leave =?' , $_POST['date_of_leave']);
	$existing_dates = $db->fetchAll($sql);
	if(count($existing_dates) > 0){
		$status = 0;
		$smarty->assign('result_msg' , 'You have already filed a request for leave in this specific date');
		
	}
	
	
	//print_r($leads);
	for($i=0 ; $i<count($leads); $i++ ){
			//echo $leads[$i]."<br>";
			$data =  array(
				'userid' => $_SESSION['userid'],
				'leads_id' => $leads[$i],
				'leave_type' => $leave_type,
				'date_of_leave' => $_POST['date_of_leave'],
				'reason_for_leave' => $reason_for_leave,
				'date_requested' => $ATZ
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
			
			//autoresponders for Client
			$body = "<p>Dear ".$leads_info['fname']." ".$leads_info['lname'].",</p>";
			$body .= "<p>&nbsp;</p>";
			$body .= "<p>Your Staff ".$staff['fname']." ".$staff['lname']." is requesting for leave or absence for ".$date_of_leave.".</p>";
			$body .= "<p>&nbsp;</p>";
			$body .= "<p>More Details about this leave request below. </p>";
			$body .= "<ul>";
			$body .= "<p>Leave Type :  ".$leave_type."</p>";
			$body .= "<p>Reason for Leave : ".stripslashes($reason_for_leave)."</p>";
			$body .= "</ul>";
			
			$body .= "<p>&nbsp;</p>";
			$body .= "<p>To approve or deny  this leave request, please login to <a href='https://".$_SERVER['HTTP_HOST']."/portal/'>Remotestaff Portal Homepage</a> and click on Staff Leave Request Management sub tab on the lower left hand side of the page. You can also email your feedback regarding this leave request to <a href='mailto:csro@remotestaff.com.au'>CSRO@remotestaff.com.au</a> </p>";
			$body .= "<p>&nbsp;</p>";
			$body .= "<p><strong>Note</strong> that hours not worked will be refunded and credited back to you.  Your staff can offset this hours as well by working extra, let them know if you prefer this. </p>";
			
			$body .= "<p>&nbsp;</p>";
			$body .= "<p>Remote Staff Team </p>";
			
			
			$mail = new Zend_Mail();
			$mail->setBodyHtml($body);
			$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
			if(!TEST){
				$mail->addTo($leads_info['email'], $leads_info['fname']." ".$leads_info['lname']);
				$mail->addCc('attendance@remotestaff.com.au' , 'Attendance');// Adds a recipient to the mail with a "Cc" header
			}else{
				$mail->addTo('devs@remotestaff.com.au' , 'Inhouse Developers');
			}
			//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
			$mail->setSubject("Remotestaff ".$staff['fname']." ".$staff['lname']." Request for Leave to Client ".$leads_info['fname']." ".$leads_info['lname']);
			$mail->send($transport);
			
		
	}
	
	//exit;
	
	$smarty->assign('result_msg' , 'Your request for leave has been successfully submitted. Please wait for further response');
	//header("location:leave_request_form.php?");

}





//Staff existing clients
$sql = $db->select()
	->from(array('s' => 'subcontractors') , Array('leads_id'))
	->joinleft(array('l' => 'leads') , 'l.id = s.leads_id' , Array('fname' , 'lname' ,'email'))
	->where('userid = ?' ,$userid)
	->where('s.status =?' , 'ACTIVE');
//echo $sql;	
$leads = $db->fetchAll($sql);
if(count($leads)>1){
	//$leads_Options ="<option value='all'>All Client</option>";	
	foreach($leads as $lead){
		$leads_Options .="<option value='".$lead['leads_id']."'>".$lead['fname']." ".$lead['lname']." [ ".$lead['email']."]</option>";
	}
}else{
	foreach($leads as $lead){
		$leads_Options .="<option value='".$lead['leads_id']."'>".$lead['fname']." ".$lead['lname']." [ ".$lead['email']."]</option>";
	}

}	

$smarty->assign('userid' ,$userid);
$smarty->assign('leads_id',$leads_id);
$smarty->assign('leads_Options',$leads_Options);
$smarty->assign('staff' , $staff);
$smarty->display('leave_request_form.tpl');
?>