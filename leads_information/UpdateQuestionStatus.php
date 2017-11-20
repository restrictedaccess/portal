<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']!="") {
	$change_by_id = $_SESSION['admin_id'] ;
	$change_by_type = 'admin';
}else if($_SESSION['agent_no']!="") {
	$change_by_id = $_SESSION['agent_no'] ;
	$change_by_type = 'agent';
}else{
	die("Session Expired. Please re-login");
}

$id = $_REQUEST['id'];
$status = $_REQUEST['status'];

//echo $id." ".$status;

$sql = $db->select()
   ->from('booking_lead_questions', 'leads_id')
   ->where('id=?', $id);
$leads_id = $db->fetchOne($sql);   



$data = array('status' => $status);
$where = "id = ".$id;	
$db->update('booking_lead_questions' , $data , $where);

$changes = 'Marked as '.$status;
$data = array(
    'booking_lead_questions_id' => $id, 
	'date_changed' => $ATZ, 
	'changes' => $changes, 
	'change_by_id' => $change_by_id, 
	'change_by_type' => $change_by_type
);
$db->insert('booking_lead_questions_history', $data);



//check if this lead still has 'unread' questions

$sql = $db->select()
    ->from('booking_lead_questions')
	->where('status =?' , 'unread')
	->where('leads_id =?' , $leads_id);
$result = $db->fetchAll($sql);
if(count($result) > 0){
    //marked the lead
	$data = array(
	   	'ask_question' => 'yes'
	);
	$where = "id = ".$leads_id;	
    $db->update('leads' , $data , $where);
}else{
    //marked the lead
	$data = array(
	   	'ask_question' => 'no'
	);
	$where = "id = ".$leads_id;	
    $db->update('leads' , $data , $where);
}	


echo 'ok';
?>