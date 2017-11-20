<?
include './conf/zend_smarty_conf_root.php';
include 'time.php';

if($_SESSION['client_id']=="")
{
	header("location:index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$client_id = $_SESSION['client_id'];
$queryClient="SELECT lname, fname,email FROM leads WHERE id=$client_id";
$result = $db->fetchRow($queryClient);
$client_name = $result['fname']." ".$result['lname'];
$client_email = $result['email'];

$userid=$_REQUEST['userid'];
$jobdetails=$_REQUEST['jobdetails'];
$start_date=$_REQUEST['start_date'];
$priority=$_REQUEST['priority'];
$finish_date=$_REQUEST['finish_date'];
$notes=$_REQUEST['notes'];


$work_task_id=$_REQUEST['work_task_id'];
$jobdetails =$jobdetails;
$notes = $notes;

$id=$_REQUEST['id'];
$client_reply=$_REQUEST['client_reply'];
$client_reply= $client_reply;
$subject=""; //default null it is a flag to use when to use zend mail

$site = $_SERVER['HTTP_HOST'];
//New task created by the client
if(isset($_POST['add']))
{
	$data = array(
			'client_id' => $client_id,
			'userid' => $userid ,
			'date_start' => $start_date ,
			'date_finished' => $finish_date, 
			'date_created' => $ATZ, 
			'work_details' => $jobdetails, 
			'notes' => $notes, 
			'priority' => $priority
			);
	$db->insert('workflow', $data);	
	
	$subject= "RemoteStaff [".$site."] New Task from Client ".$client_name;

}
//Task updated by the client
if(isset($_POST['update']))
{
	$data = array(
		'date_start' => $start_date ,
		'date_finished' => $finish_date, 
		'date_created' => $ATZ, 
		'work_details' => $jobdetails, 
		'notes' => $notes, 
		'priority' => $priority
	);
	$where = "id = ".$work_task_id;
	$db->update('workflow', $data, $where);
	$subject= "RemoteStaff [".$site."]  Updated Task from Client ".$client_name;
}





if(isset($_POST['reply']))
{
	//id, workflow_id, client_id, subcon_id, message, chat_date, created_by
	$data = array(
		'workflow_id' => $id, 
		'client_id' => $client_id,  
		'subcon_id' => $userid,
		'message' => $client_reply,
		'chat_date' => $ATZ,
		'created_by' => 'CLIENT'
			);
	$db->insert('workflow_chat', $data);
	$subject=""; //default null it is a flag to use when to use zend mail	
}


if($subject!=""){
	// Send Email to the Staff	
	$queryStaff="SELECT * FROM personal WHERE userid=$userid";
	$results = $db->fetchRow($queryStaff);
	$staff_name =$results['fname']." ".$results['lname'];
	$staff_email = $results['email'];
	
	$body = "<p>Dear ".$staff_name.",</p>";
	$body .= "<p>Your workflow has been updated by your client. </p>";
	$body .= "<p>Click on the <a href='http://$site/portal/worktask.php'>Work Task</a> sub-tab on your <a href='http://$site/portal/subconHome.php'>Sub Contractor Portal</a> to know more details about this task and to update your client via the portal. </p>";
	$body .= "<img src='http://$site/portal/images/staff_leftnav.jpg'<br>";
	$body .= "<p>Should you have any questions, please don’t hesitate to contact Remotestaff team at admin@remotestaff.com.au  </p>";
	
	
	$mail = new Zend_Mail();
	$mail->setBodyHtml($body);
	$mail->setFrom($client_email, $client_name);
	$mail->addTo($staff_email, $staff_name);
	$mail->addBcc('normanm@remotestaff.com.au', 'Normaneil Macutay');// Adds a recipient to the mail with a "Cc" header
	//$mail->addCc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	$mail->setSubject($subject);
	$mail->send($transport);
}
	
	
	header("Location:workflow.php?userid=$userid");


?>