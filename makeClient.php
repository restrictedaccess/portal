<?
include './conf/zend_smarty_conf_root.php';
include 'time.php';
if($_SESSION['agent_no']==""){
	header("location:index.php");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];



$sql ="SELECT * FROM leads WHERE id = $id;";
$result = $db->fetchRow($sql);
$personal_id =$result['personal_id'];
$personal_id="C".substr($personal_id,1);
$agent_id = $result['agent_id'];
$client_name = $result['fname']." ".$result['lname'];


//update the leads status and personal_id

$data = array(
	'status'   => 'Client',
	'client_since'  => $ATZ,
	'personal_id' => $personal_id
);
$where = "id = ".$id;
$db->update('leads', $data, $where);


$sql ="SELECT * FROM agent a WHERE agent_no = $agent_id;";
$result = $db->fetchRow($sql);
$agent_name = $result['fname']." ".$result['lname'];
$agent_email = $result['email'];

//echo $agent_name."<br>".$agent_email;



$body = "Dear ".$agent_name.",<br /><br />
		Good news! <br /><br /><b>".$client_name."</b> one of the leads from your business network has just decided to take a Remote Staff Service provider on board.
		<br /><br />
		All papers are in and custom recruitment will commence tomorrow. <br /><br />
		Commissions applicable for this lead will be forwarded to you in details once a staff member is placed and active. <br /><br />
		Feel free to talk more about <a href='http;//www.remotestaff.com.au'>www.remotestaff.com.au</a>   to your business network.  Surely such a great opportunity is worth spreading around!<br /><br />
		If there’s anyway we can help you with anything, please feel free to contact us. <br /><br />
		<img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='241' height='70'>";
//echo $body;
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'RemoteStaff');
$mail->addTo($agent_email, $agent_name);
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject('Information from RemoteStaff');
$mail->send($transport);
header("location:client_workflow.php?id=$id");




?>
