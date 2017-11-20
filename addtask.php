<?
include './conf/zend_smarty_conf_root.php';
include 'time.php';


if($_SESSION['userid']=="")
{
	header("location:index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$userid = $_SESSION['userid'];
$client_id = $_REQUEST['clients'];


$jobdetails=$_REQUEST['jobdetails'];
$start_date=$_REQUEST['start_date'];
$priority=$_REQUEST['priority'];
$finish_date=$_REQUEST['finish_date'];
$notes=$_REQUEST['notes'];
$notify = $_REQUEST['notify'];
$site = $_SERVER['HTTP_HOST'];
//echo "notify = ".$notify;


//staff details
$queryStaff="SELECT * FROM personal WHERE userid=$userid";
$results = $db->fetchRow($queryStaff);
$staff_name =$results['fname']." ".$results['lname'];
$staff_email = $results['email'];


//client details
$queryClient="SELECT lname, fname,email FROM leads WHERE id=$client_id";
$result = $db->fetchRow($queryClient);
$client_name = $result['fname']." ".$result['lname'];
$client_email = $result['email'];

//insert new record
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

if($notify == "yes"){
	//Send Email to the Client
	$subject="RemoteStaff ".$staff_name. " Added a Task .";
	$body = "<p>Dear ".$client_name.",</p>";
	$body .= "<p>Your staff member , ".$staff_name.",  have updated his/her task list. </p>";
	$body .= "<div style='margin-top:10px;margin-bottom:5px;'>".$jobdetails."</div>" . "<div>".$notes."</div>" ;;
	$body .= "<p>For more details about the task list and updates please log on to your client portal <a href='http://$site/portal/'>HERE</a>. Click on Sub Contractor Management tab  then on the  drop down menu, select specific staff you want to  check on.  Once staff is selected , click on WorkFlow sub tab. </p>";
	$body .= "<p>Should you have any questions, please don hesitate to contact us. <br /><br />Admin <br />Admin@remotestaff.com.au </p>";
	
	
	$mail = new Zend_Mail();
	$mail->setBodyHtml($body);
	$mail->setFrom($staff_email, $staff_name);
	$mail->addTo($client_email, $client_name);
	$mail->addBcc('normanm@remotestaff.com.au', 'Normaneil Macutay');// Adds a recipient to the mail with a "Cc" header
	//$mail->addCc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	$mail->setSubject($subject);
	$mail->send($transport);
}
header("Location:worktask.php?userid=$userid");


?>