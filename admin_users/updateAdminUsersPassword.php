<?php
/*
2010-03-12 Lawrence Sunglao<lawrence.sunglao@remotestaff.com.au>
- sets the email to devs if testing

*/
include '../conf/zend_smarty_conf.php';
include '../time.php';
include('../blowfish/blowfish_password.php');


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
	exit;
}

$admin_id = $_REQUEST['admin_id'];
$admin_password = $_REQUEST['admin_password'];
$admin_name = $_REQUEST['admin_name'];
$admin_email = $_REQUEST['admin_email'];

//echo $admin_password."<br>";
//echo $admin_password."<br>";

//update password
$data = array(
	'admin_password' => doEncryptPassword($admin_password)
	);
$where = "admin_id = ".$admin_id;	
$db->update('admin', $data , $where);

//insert history
$changes = "Updated the password";
$data = array(
    'admin_id' => $admin_id, 
    'changes' => $changes, 
    'changed_by_id' => $_SESSION['admin_id'], 
    'date_changes' => $ATZ
);
$db->insert('admin_history', $data);



//send the login details via email
$to = "normanm@remotestaff.com.au";
$recipient_name = "Normaneil E. Macutay";
$body = "<p>Remote Staff Admin user Login Details.</p>
<p>Date Changed : $ATZ</p>
<hr>
<p>Name : $admin_name</p>
<p>Login Details</p>
<p><b>Email : $admin_email</b></p>
<p><b>Password : $admin_password</b></p>";


$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'remotestaff');
if (TEST) {
    $admin_email = 'devs@remotestaff.com.au';
	$mail->setSubject('TEST RemoteStaff Admin Login Details');
}else{
	$mail->setSubject('RemoteStaff Admin Login Details');
}
$mail->addTo($admin_email, $admin_name);
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->send($transport);
echo "Admin user password [ ".$admin_name." ] successfully changed.  An email was sent to ".$admin_email;
exit;
?>