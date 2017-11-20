<?php
include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];


$id=$_REQUEST['id'];
$page = $_REQUEST['page'];

if($page == "newleads"){
	$url = "adminnewleads.php";
}
if($page == "followup"){
	$url = "admin_follow_up_leads.php";
}
if($page == "keeptouch"){
	$url = "admin_keep_in_touch_leads.php";
}
if($page == "client"){
	$url = "adminclient_listings.php";
}

$status = 'REMOVED';
$data = array('status' => $status);
//add history
addLeadsInfoHistoryChanges($data , $id , $admin_id , 'admin');

$where = "id = ".$id;	
$db->update('leads' ,  $data , $where);
header("location:$url");




?>
