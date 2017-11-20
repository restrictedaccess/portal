<?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../conf/zend_smarty_conf.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id = $_SESSION['client_id'];
$commission_staff_id = $_REQUEST['commission_staff_id'];
$commission_staff_status = $_REQUEST['status'];

if($commission_staff_status == "approved"){
	$date =" date_approved = '$ATZ' ";
	$status = "APPROVED";
}

if($commission_staff_status == "cancel"){
	$date =" date_cancelled = '$ATZ' ";
	$status = "CANCELLED";
}


$query = "SELECT DISTINCT(l.id),CONCAT(l.fname,' ',l.lname),l.email,CONCAT(p.fname,' ',p.lname),p.email, c.commission_title , c.commission_amount , c.commission_id
			FROM commission c
			LEFT JOIN commission_staff s ON s.commission_id = c.commission_id
			LEFT JOIN leads l ON l.id = c.leads_id
			LEFT JOIN personal p ON  p.userid = s.userid
			WHERE s.commission_staff_id = $commission_staff_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
list($leads_id,$leads_name,$leads_email,$staff_name,$staff_email, $commission_title , $commission_amount , $commission_id) = mysql_fetch_array($result);

// send a notification email to the client that a staff is claiming a commission to the client's commission rule
$body = "RemoteStaff Commission Claims Notice <br><br>".$leads_name."  <b>".$status."</b> Commission Rule : ".$commission_title ."<br><br>".
		"AMOUNT : ".$commission_amount."<br><br>".
		"DATE ".$status." : ".$ATZ."<br><br>".
		"STAFF NAME : ".$staff_name; 

$leads_email = "ricag@remotestaff.com.au";
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'Remotestaff');
$mail->addTo($leads_email, $leads_name);
// Adds a recipient to the mail with a "BCC" header
$mail->addBcc('normanm@remotestaff.com.au');
//$mail->addBcc('ricag@remotestaff.com.au');
//$mail->addBcc('daniel@remotestaff.com.au');
$mail->setSubject('REMOTESTAFF [ Staff Commission Claims ]');
$mail->send($transport);


$query ="UPDATE commission_staff SET 
		commission_staff_status = '$commission_staff_status' ,
		$date
		WHERE commission_staff_id = $commission_staff_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);

?>