<?php
include '../conf/zend_smarty_conf.php';
include '../tools/CouchDBMailbox.php';
include './admin_subcon_function.php';
include './subcon_function.php';

$smarty = new Smarty();

//default timezone is Asia/Manila
date_default_timezone_set("Asia/Manila");
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}
$site = $_SERVER['HTTP_HOST'];

$id = $_REQUEST['id']; //subcontractors.id
$admin_id = $_SESSION['admin_id'];
$userid = $_REQUEST['userid'];
$leads_id = $_REQUEST['leads_id'];
$admin_notes = $_REQUEST['admin_notes'];
$status = $_REQUEST['status'];
$end_date_str = $_REQUEST['end_date_str'];	
$scheduled_close_contract_id = $_REQUEST['scheduled_close_contract_id'];
$reason_type = $_REQUEST['reason_type'];
$replacement_request = $_REQUEST['replacement_request'];
$service_type = $_REQUEST['service_type'];

//get the starting_date
$sql = $db->select()
    ->from('subcontractors')
	->where('id=?', $id);
$subcontractors = $db->fetchRow($sql);
$starting_date = $subcontractors['starting_date'];
$job_designation = $subcontractors['job_designation'];
$date = new DateTime($starting_date);	
$starting_date_str = $date->format("Y-m-d");
	
$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
$result = $db->fetchRow($sql);
$admin_name = $result['admin_fname']." ".$result['admin_lname'];
$admin_email=$result['admin_email'];


//Get the agent_id of the leads
$sql = "SELECT * FROM leads WHERE id = $leads_id;";
$result = $db->fetchRow($sql);
$agent_id = $result['agent_id'];
$client_name = $result['fname']." ".$result['lname'];

//Get the CSRO of client
$csro_name="";
$csro_email="";
if($result['csro_id']!=""){
	$sql=$db->select()
	    ->from('admin')
		->where('admin_id =?', $result['csro_id']);
	$csro = $db->fetchRow($sql);
    $csro_name = $csro['admin_fname']." ".$csro['admin_lname'];
    $csro_email = $csro['admin_email'];	
}

$sql="SELECT * FROM personal WHERE userid = $userid;";
$result = $db->fetchRow($sql);
$staff_name = $result['fname']." ".$result['lname'];
$staff_email = $result['email']; 
$staff_skype = $result['skype_id'];
$registered_email = $result['registered_email'];

$sql = $db->select()
    ->from('subcontractors_scheduled_close_cotract')
	->where('subcontractors_id =?', $id)
	->where('status =?', 'waiting')
	->order('scheduled_date DESC')
	->limit(1);
$schedules = $db->fetchAll($sql);

$staff_name = utf8_encode($staff_name);
$staff_name = utf8_decode($staff_name);

//scheduled date is today
if($_REQUEST['end_date_str'] == date('Y-m-d')){ 

	//echo "today\n";
	if($_REQUEST['status'] == "resigned"){
		//SUBMITTED DATA
		$data = array (
			'status' => $_REQUEST['status'],
			'reason' => $_REQUEST['admin_notes'],
			'reason_type' => $reason_type,
			'service_type' => $service_type,
			'replacement_request' => $replacement_request,
			'resignation_date' => $_REQUEST['end_date_str']." ".$AusTime,
			'end_date' => $_REQUEST['end_date_str']." ".$AusTime	
		);
	}		
	
	
	if($_REQUEST['status'] == "terminated"){
		//SUBMITTED DATA
		$data = array (
			'status' => $_REQUEST['status'],
			'reason' => $_REQUEST['admin_notes'],
			'reason_type' => $reason_type,
			'service_type' => $service_type,
			'replacement_request' => $replacement_request,
			'date_terminated' => $_REQUEST['end_date_str']." ".$AusTime,
			'end_date' => $_REQUEST['end_date_str']." ".$AusTime		
		);
	}
	
	
	//COMPARE AND GET THE CHANGES
	$history_changes .= sprintf("[STATUS] => ACTIVE to %s <br>[REASON TYPE] => %s <br>[REPLACEMENT REQUEST] => %s <br>[SERVICE TYPE] => %s", $_REQUEST['status'], $reason_type, $replacement_request,  $service_type );
	$where = "id = ".$id;	
	$db->update('subcontractors', $data , $where);
	
	//HISTORY
	$changes = "Contract status has been changed.<br>";
	$changes .= "<b>Changes made : </b><br>".$history_changes;
	$data = array (
		'subcontractors_id' => $id, 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $_SESSION['admin_id'],
		'changes_status' => $_REQUEST['status'],
		'note' => $_REQUEST['admin_notes']
	);
	$db->insert('subcontractors_history', $data);
		
	$comparing_date = date("Y-m-d");
	$smarty->assign('contract_length', dateDiff($comparing_date,$starting_date_str));
	$smarty->assign('admin_name',$admin_name);
	$smarty->assign('admin_email',$admin_email);
	$smarty->assign('client_name', $client_name);
	$smarty->assign('staff_name', $staff_name);
	$smarty->assign('admin_notes', $admin_notes);
	$smarty->assign('status', $status);
	$smarty->assign('reason_type', $reason_type);
	$smarty->assign('replacement_request', $replacement_request);
	$smarty->assign('service_type', $service_type);
    $smarty->assign('ATZ', $comparing_date);	
	$smarty->assign('msg', sprintf("Your client <strong>%s</strong> cancelled the contract with subcon %s.", $client_name, $staff_name));
	$body = $smarty->fetch('contract_termination_autoresponder.tpl');
	
	$details =  "<h3>STAFF CONTRACT STATUS HAS BEEN CHANGED TO ".strtoupper($status)."</h3>
			<p>Staff : ".$staff_name."</p>
			<p><hr></p>
			<p>".$changes."</p>
			<p><hr></p>
			<p>Updated by : ".$admin_name."</p>";



	//SEND MAIL
	$subject = sprintf("REMOTESTAFF CLIENT %s CANCELLED THE CONTRACT WITH %s", $client_name, $staff_name);	
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = $admin_email;
    $html = $body;
    $to_array[] = $admin_email;
	if($csro_email!=""){
		$to_array[] = $csro_email;
	}
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	//Send email to Accounts
	$smarty->assign('csro_name', $csro_name);
	$smarty->assign('client_name', $client_name);
	$smarty->assign('staff_name', $staff_name);
	$smarty->assign('ATZ', $comparing_date);
	$body=$smarty->fetch('accounts_contract_termination_autoresponder.tpl');
    $html = $body;
    $to_array = array('accounts@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);	
	
}else{
	// future schedule date
	$data = array(
		'subcontractors_id' => $id, 
		'subcontractors_status' => $status, 
		'scheduled_date' => $end_date_str." ".$AusTime, 
		'date_created' => $ATZ, 
		'added_by_id' => $_SESSION['admin_id'],
		'reason' => $admin_notes,
		'reason_type' => $reason_type,
		'service_type' => $service_type,
		'replacement_request' => $replacement_request
	);
	$db->insert('subcontractors_scheduled_close_cotract', $data);
	
	//update and set the end date of staff contract
	$data = array ('end_date' => $end_date_str." ".$AusTime);
	$where = "id = ".$id;	
	$db->update('subcontractors', $data , $where);
	
	//HISTORY
	//INSERT NEW RECORD TO THE subcontractors_history
	$history_changes = "Staff contract scheduled to [ ".$status." ] on ".$end_date_str;
	$history_changes .= sprintf("<br>[REASON TYPE] => %s <br>[REPLACEMENT REQUEST] => %s <br>[SERVICE TYPE] => %s", $reason_type, $replacement_request, $service_type );
	$changes = "Contract has been scheduled to ".$status.".<br>";
	$changes .= "<b>Changes made : </b><br>".$history_changes;
	$data = array (
		'subcontractors_id' => $id, 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $admin_id ,
		'changes_status' => 'new',
		'note' => $admin_notes
	);
	$db->insert('subcontractors_history', $data);

	$comparing_date = $end_date_str;
	$smarty->assign('contract_length', dateDiff($end_date_str,$starting_date_str));
	$smarty->assign('admin_name',$admin_name);
	$smarty->assign('admin_email',$admin_email);
	$smarty->assign('client_name', $client_name);
	$smarty->assign('staff_name', $staff_name);
	$smarty->assign('admin_notes', $admin_notes);
	$smarty->assign('status', $status);
	$smarty->assign('reason_type', $reason_type);
	$smarty->assign('replacement_request', $replacement_request);
	$smarty->assign('service_type', $service_type);
    $smarty->assign('ATZ', $comparing_date);	
	$smarty->assign('msg', sprintf("Your client <strong>%s</strong> requested a scheduled cancellation of contract with subcon %s.", $client_name, $staff_name));
	$body = $smarty->fetch('contract_termination_autoresponder.tpl');
	
	$details =  "<h3>STAFF CONTRACT HAS BEEN SCHEDULED TO ".strtoupper($status)."</h3>
			<p>Staff : ".$staff_name."</p>
			<p><hr></p>
			<p>Scheduled Finish Date : ".$end_date_str."</p>
			<p>Status : ".$status."</p>
			<p>Reason : ".$admin_notes."</p>
			<p>Scheduled by : ".$admin_name."</p>";

	
	//SEND MAIL
	$subject = sprintf("REMOTESTAFF SCHEDULED CONTRACT CANCELLATION OF %s", $staff_name);
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = $admin_email;
    $html = $body;
    $to_array[] = $admin_email;
	if($csro_email!=""){
		$to_array[] = $csro_email;
	}
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	//Send email to Accounts
	$smarty->assign('csro_name', $csro_name);
	$smarty->assign('client_name', $client_name);
	$smarty->assign('staff_name', $staff_name);
	$smarty->assign('ATZ', $comparing_date);
	$body=$smarty->fetch('accounts_contract_termination_autoresponder.tpl');
    $html = $body;
    $to_array = array('accounts@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	
	//send email to recruiter staff
	$sql = "SELECT r.id, r.userid, a.admin_fname, a.admin_email FROM recruiter_staff r JOIN admin a ON a.admin_id = r.admin_id WHERE r.userid=".$userid;
	$recruiter_staff = $db->fetchRow($sql);
	if($recruiter_staff['id']){
		$smarty->assign('recruiter_staff',$recruiter_staff);
		$smarty->assign('client_name', $client_name);
		$smarty->assign('staff_name', $staff_name);
		$smarty->assign('job_designation', $job_designation);
		$smarty->assign('end_date', $_REQUEST['end_date_str']);
		
		$smarty->assign('reason', $admin_notes);
		$smarty->assign('reason_type', $_REQUEST['reason_type']);
		$smarty->assign('service_type', $_REQUEST['service_type']);
		$smarty->assign('replacement_request', $_REQUEST['replacement_request']);
		$smarty->assign('contract_length', dateDiff($starting_date, $_REQUEST['end_date_str']));
		$smarty->assign('csro_name', $csro_name);
		$body = $smarty->fetch('recruiter_staff_scheduled_terminatation_autoresponder.tpl');
		
		
		$subject = sprintf("Your candidate %s has been scheduled to terminate.", $staff_name);
		$attachments_array =NULL;
		$bcc_array=array('devs@remotestaff.com.au');
		$cc_array = NULL;
		$from = 'RS System<noreply@remotestaff.com.au>';
		$html = $body;
		$text=NULL;
		$to_array = array($recruiter_staff['admin_email']);
		SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);		
	}
			
}

if($schedules){
	
	foreach($schedules as $schedule){
		//$new_date = new Zend_Date($schedule['scheduled_date']);
		//$date = new DateTime($new_date);
		//$scheduled_date = $date->format('Y-m-d');
		
		//update the existing schedule and add history
		$data = array('status' => 'removed');
		$db->update('subcontractors_scheduled_close_cotract', $data, 'id='.$schedule['id']);
	}
	
	//INSERT NEW RECORD TO THE subcontractors_history
	$history_changes = "Staff contract termination has been rescheduled on ".$_REQUEST['end_date_str'];
	$data = array (
		'subcontractors_id' => $id, 
		'date_change' => $ATZ, 
		'changes' => $history_changes, 
		'change_by_id' => $_SESSION['admin_id'] ,
		'changes_status' => 'new',
		'note' => $_REQUEST['admin_notes']
	);
	$db->insert('subcontractors_history', $data);
	
}

/*

//Check if staff still has any active contracts
$sql = "SELECT COUNT(id)AS no_of_active_contracts FROM subcontractors s WHERE status IN('suspended', 'ACTIVE') AND userid = ".$subcontractors['userid'].";";
$no_of_active_contracts = $db->fetchOne($sql);
if($no_of_active_contracts == 0){
	//No active contracts
	//Update personal.email

	if($registered_email){
		$data = array('email' => $registered_email);
		$db->update('personal', $data, 'userid='.$subcontractors['userid']);
		
		//INSERT history
		$data = array (
			'userid' => $id, 
			'date_change' => $ATZ, 
			'changes' => sprintf('Reverted back staff personal email from %s to %s', $staff_email, $registered_email), 
			'change_by_id' => $_SESSION['admin_id'] ,
			'change_by_type' => 'ADMIN'
		);
		$db->insert('staff_history', $data);
	}
	
	//send email to Rhine Ramos <rine.r@remotestaff.com.au> to disable rs email of staff
	$subject = sprintf("Please disable remotestaff email [ %s ] of staff #%s %s", $staff_email, $subcontractors['userid'], $staff_name);
	$body = sprintf('<p>%s</p><p><strong>Note : </strong>Personal email of staff has already been reverted back from %s to %s</p>', $subject, $staff_email, $registered_email);
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
	$cc_array = NULL;
	$from = 'RS System<noreply@remotestaff.com.au>';
	$html = $body;
	$text=NULL;
	$to_array = array('rine.r@remotestaff.com.au');
	SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);	
}
*/


$smarty->assign('details',$details);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('processContract.tpl');
?>