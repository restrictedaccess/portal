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


$id = $data["Query"]["id"];
/*
$sql=$db->select()
    ->from('rs_contact_nos')
	->where('id =?', $id);
$rs_contact_no = $db->fetchRow($sql);	

$where = "id=".$id;
$db->delete('rs_contact_nos', $where);
*/

$data = array(
	'active' => 'no', 
);
$where = "id=".$id;
$db->update('rs_contact_nos', $data, $where);


//Add history
$data = array(
	'rs_contact_no_id' => $id, 
	'admin_id' => $_SESSION['admin_id'], 
	'date_created' => $ATZ,
	'changes' => sprintf('Removed contact number. Set active value from yes to no.<br>')
);
$db->insert('rs_contact_nos_history' , $data);
	
echo json_encode(array("success"=>true, "type" => $rs_contact_no['type'], 'msg' => 'Successfully deleted'));
exit;
?>