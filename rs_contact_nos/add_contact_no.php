<?php
include '../conf/zend_smarty_conf.php';


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;



if($_SESSION['admin_id']==""){
	die('Session expires.');
}


	
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$data = json_decode(file_get_contents('php://input'), true);

$contact_no = $data["Query"]["contact_no"];
$description = $data["Query"]["description"];
$site = $data["Query"]["site"];
$type = $data["Query"]["type"];

$data = array(
	'contact_no' => $contact_no, 
	'description' => $description, 
	'site' => $site,
	'type' => $type
);
$db->insert('rs_contact_nos' , $data);
$id = $db->lastInsertId();

//Add history
$data = array(
	'rs_contact_no_id' => $id, 
	'admin_id' => $_SESSION['admin_id'], 
	'date_created' => $ATZ,
	'changes' => sprintf('Added new contact number.')
);
$db->insert('rs_contact_nos_history' , $data);


echo json_encode(array("success"=>true, "site" => $site, 'msg' => 'Successfully Added'));
exit;
?>