<?php
define('TEST', False); // change False in production

include './conf/zend_smarty_conf_root.php';
$userid = $_SESSION['userid'];
if($_SESSION['userid']=="")
{
	header("location:index.php");
}

$site = $_SERVER['HTTP_HOST'];
$query="SELECT * FROM personal WHERE userid=$userid";
$result = $db->fetchRow($query);
$staff_name = $result['fname']." ".$result['lname'];
$staff_email =$result['email'];

$details =  "<h3>STAFF ACKNOWLEDGE THE HSBC NOTICE BY ADMIN</h3>
			 <p>Staff : ".$staff_name."</p>";



//SEND MAIL
if(! TEST){
	//admin email
	$to = 'admin@remotestaff.com.au'; // replace admin@remotestaff.com.au
	$fullname = "Rica J.";
}else{
	$to = 'normanm@remotestaff.com.au'; //replace devs@remotestaff.co.uk
	$fullname = "Remotestaff Developers";
}

$mail = new Zend_Mail();
$mail->setBodyHtml($details);
$mail->setFrom($staff_email, $staff_name);
$mail->addTo($to, $fullname);
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject($site." ".$staff_name." ACKNOWLEDGE THE HSBC NOTICE");
$mail->send($transport);

header("Location:subconHome.php?flag=0");
?>