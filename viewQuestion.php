<?php
include './conf/zend_smarty_conf.php';
include './time.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;





$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$change_by_type = 'agent';
	$smarty->assign('agent_section',True);
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$change_by_type = 'admin';
	$smarty->assign('admin_section',True);	

}else{

	die("Session Expires . Please re-login");
}



$id=$_REQUEST['id'];
if(!$id){
	die("Book An Interview Question ID is missing");
}


$sql = $db->select()
	->from(array('b' => 'booking_lead_questions'), Array('b.id', 'question', 'b.status', 'date_created', 'b.userid', 'b.leads_id','b.status'))
	->join(array('l' => 'leads') , 'l.id = b.leads_id', Array('leads_fname' => 'l.fname', 'leads_lname' => 'l.lname'))
	->join(array('p' => 'personal'), 'p.userid = b.userid', Array('staff_fname' => 'p.fname', 'staff_lname' => 'p.lname' ))
	->where('b.id =?' , $id);
//echo $sql;exit;
$question = $db->fetchRow($sql);

//$data = array('status' => 'read');
//$where = "id = ".$id;	
//$db->update('booking_lead_questions' , $data , $where);

//id, booking_lead_questions_id, changes, change_by_id, change_by_type, date_changed
$data = array(
    'booking_lead_questions_id' => $id, 
	'date_changed' => $ATZ, 
	'changes' => "Viewed", 
	'change_by_id' => $created_by_id, 
	'change_by_type' => $change_by_type
);
$db->insert('booking_lead_questions_history', $data);


function MadeBy($id , $table){
    global $db;
    if($table == 'admin'){
	    $sql = $db->select()
		    ->from('admin')
			->where('admin_id =?' , $id);
	    $result = $db->fetchRow($sql);
		return sprintf('Admin %s' , $result['admin_fname']);		
	}else{
	    $sql = $db->select()
		    ->from('agent')
			->where('agent_no =?' , $id);
	    $result = $db->fetchRow($sql);
		return sprintf('BP %s' , $result['fname']);
	}
}
$sql = $db->select()
    ->from('booking_lead_questions_history')
	->where('booking_lead_questions_id =?', $id );
$histories = $db->fetchAll($sql);
$history_results = array();
foreach($histories as $history){
    $data = array(
	    'changes' => $history['changes'], 
		'change_by' => MadeBy($history['change_by_id'], $history['change_by_type']), 
		'date_changed' => $history['date_changed']
	);
	array_push($history_results , $data);
}

	
$smarty->assign('histories' , $history_results);
$smarty->assign('question' , $question);
$smarty->display('viewQuestion.tpl');
?>