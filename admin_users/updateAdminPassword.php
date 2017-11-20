<?php
//  2010-03-12 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   used devs@remotestaff.com.au for testing
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
}

$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin WHERE admin_id = $admin_id;";
$result = $db->fetchRow($query);

$admin_name = $result['admin_fname']." ".$result['admin_lname'];
$admin_email = $result['admin_email'];
$admin_password = $result['admin_password'];
$new_password = $_REQUEST['new_password'];
$old_password = $_REQUEST['old_password'];

//echo "Current Password ".$admin_password."<hr>";
//echo "Old Password ".$old_password."<br>";
//echo "New Password ".$new_password."<br>";


// check first the old password
if($admin_password != doEncryptPassword($old_password)){
	die("error");
}


$data = array(
	'admin_password' => doEncryptPassword($new_password)
	);
$where = "admin_id = ".$admin_id;	
$db->update('admin', $data , $where);
echo "Admin [$admin_name] password successfully changed. An email was sent to $admin_email \n You will be automatically logout please re-login.";



//send the login details via email
$to = "normanm@remotestaff.com.au";
$recipient_name = "Normaneil E. Macutay";
$body = "<p>Remote Staff Admin user Login Details! ".$_SERVER['HTTP_HOST']."</p>
<p>Date Changed : $ATZ</p>
<hr>
<p>Name : $admin_name</p>
<p>Login Details</p>
<p><b>Email : $admin_email</b></p>
<p><b>Password : $new_password</b></p>";


$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'remotestaff');
if (TEST) {
    $admin_email = 'devs@remotestaff.com.au';
}
$mail->addTo($admin_email, $admin_name);
$mail->setSubject('RemoteStaff Admin Login Details ' .$_SERVER['HTTP_HOST'] );
$mail->send($transport);
session_destroy();

?>
