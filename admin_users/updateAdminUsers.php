<?php
//2011-01-06    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added timezone
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

$admin_fname = $_REQUEST['admin_fname'];
$admin_lname = $_REQUEST['admin_lname'];
$admin_email = $_REQUEST['admin_email'];
$timezone_id = $_REQUEST['timezone_id'];



$signature_notes = $_REQUEST['signature_notes'];
$signature_contact_nos = $_REQUEST['signature_contact_nos'];
$signature_company = $_REQUEST['signature_company'];
$signature_websites = $_REQUEST['signature_websites'];


$data = array(
	'admin_fname' => $admin_fname, 
	'admin_lname' => $admin_lname, 
	'admin_email' => $admin_email ,
	'signature_notes' => $signature_notes,
	'signature_contact_nos' => $signature_contact_nos,
	'signature_company' => $signature_company,
	'signature_websites' => $signature_websites,
    'timezone_id' => $timezone_id
	);
$where = "admin_id = ".$admin_id;	
$db->update('admin', $data , $where);
echo "Admin user [ $admin_fname $admin_lname ] updated successfully";


?>
