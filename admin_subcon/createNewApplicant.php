<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}
$admin_id = $_SESSION['admin_id'];

$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$email = $_REQUEST['email'];
$skype = $_REQUEST['skype'];
$phone = $_REQUEST['phone'];
$pass=sha1('remote');

$data = array (
		'fname' => $fname,
		'lname' => $lname,
		'email' => $email,
		'handphone_no' => $phone,
		'pass'  => $pass, 
		'skype_id' => $skype,
		'datecreated' => $ATZ,
		'status' => 'New'
		);
//print_r($data);		
$db->insert('personal', $data);
$userid = $db->lastInsertId();
echo $userid;

?>