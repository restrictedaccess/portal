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
$id = $data["Query"]["id"];
$str="";
$sql=$db->select()
    ->from('rs_contact_nos')
	->where('id =?', $id);
$rs_contact_no = $db->fetchRow($sql);	

//Check for changes

//echo sprintf('Updated contact number from %s to %s.<br>', $rs_contact_no['contact_no'],  $contact_no);

if($rs_contact_no['contact_no'] != $contact_no){
	$str .= sprintf('Updated contact number from %s to %s.<br>', $rs_contact_no['contact_no'],  $contact_no);
}

if($rs_contact_no['description'] != $description){
	$str .= sprintf('Updated description from %s to %s.<br>', $rs_contact_no['description'],  $description);
}


if($rs_contact_no['site'] != $site){
	$str .= sprintf('Updated site from %s to %s.<br>', $rs_contact_no['site'],  $site);
}

if($rs_contact_no['type'] != $type){
	$str .= sprintf('Updated type from %s to %s.<br>', $rs_contact_no['type'],  $type);
}
//echo $str;exit;

$data = array(
	'contact_no' => $contact_no, 
	'description' => $description, 
	'site' => $site,
	'type' => $type
);
$where = "id=".$id;
$db->update('rs_contact_nos', $data, $where);


//Add history
if($str!=""){
	$data = array(
		'rs_contact_no_id' => $id, 
		'admin_id' => $_SESSION['admin_id'], 
		'date_created' => $ATZ,
		'changes' => $str
	);
	$db->insert('rs_contact_nos_history' , $data);
}
echo json_encode(array("success"=>true, "type" => $rs_contact_no['type'], 'msg' => 'Successfully Updated'));
exit;
?>