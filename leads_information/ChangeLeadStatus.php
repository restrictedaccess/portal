<?php
include '../conf/zend_smarty_conf.php';
include '../lib/addLeadsInfoHistoryChanges.php';
include '../time.php';

//id, leads_id, date_change, changes, change_by_id, change_by_type
if($_SESSION['admin_id']!="") {
	
	$change_by_id = $_SESSION['admin_id'] ;
	$change_by_type = 'admin';
	
}else if($_SESSION['agent_no']!="") {

	$change_by_id = $_SESSION['agent_no'] ;
	$change_by_type = 'bp';
	
}else{
	die("Session Expired. Please re-login");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id=$_REQUEST['id'];
$lead_status = $_REQUEST['lead_status'];

//echo $leads_id ."<br>".$lead_status;
$sql = $db->select()
	->from('leads' , 'status')
	->where('id =?' , $leads_id);
$status = $db->fetchOne($sql);	


if($lead_status == 'duplicate'){
	
	$data = array('status' => 'REMOVED' , 'marked' => 'no', 'last_updated_date' => $ATZ);
	addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);
	
	//delete record in the leads_indentical
	$where = "leads_id = ".$leads_id;	
	$db->delete('leads_indentical' ,  $where);
	
	
	$changes = array(
				 'leads_id' => $leads_id ,
				 'date_change' => $ATZ, 
				 'changes' => 'Removed this identical profile', 
				 'change_by_id' => $change_by_id, 
				 'change_by_type' => $change_by_type
	);
	$db->insert('leads_info_history', $changes);	
	$lead_status = $status;
	$url = "../leads_information.php?id=".$leads_id."&lead_status=".$lead_status;

}else if($lead_status == 'identical'){
	
	$data = array('marked' => 'no', 'last_updated_date' => $ATZ);
	addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);
	
	//delete record in the leads_indentical
	$where = "leads_id = ".$leads_id;	
	$db->delete('leads_indentical' ,  $where);
	
	$changes = array(
				 'leads_id' => $leads_id ,
				 'date_change' => $ATZ, 
				 'changes' => 'Removed the identical name flag', 
				 'change_by_id' => $change_by_id, 
				 'change_by_type' => $change_by_type
	);
	$db->insert('leads_info_history', $changes);	
	
	$lead_status = $status;
	$url = "../leads_information.php?id=".$leads_id."&lead_status=".$lead_status;

}else if($lead_status == 'REMOVED'){
	
	$sql = $db->select()
		->from('leads','email')
		->where('id =?' , $leads_id);
	$email = $db->fetchOne($sql);
	
		
	$data = array('marked' => 'no' ,'status' => $lead_status , 'contacted_since' => $ATZ , 'email' => $email.".".$lead_status, 'last_updated_date' => $ATZ );
	addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);
	
	$lead_status = $status;
	
	$url = "../leads.php?lead_status=".$lead_status;

}else if($lead_status == 'Inactive'){
	
	
	$data = array('marked' => 'no' ,'status' => $lead_status , 'contacted_since' => $ATZ, 'last_updated_date' => $ATZ);
	addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);
	
	$lead_status = $status;
	
	$url = "../leads.php?lead_status=".$lead_status;
}else if($lead_status == 'Client'){

	$data = array('status' => $lead_status , 'contacted_since' => $ATZ, 'last_updated_date' => $ATZ);
	addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where); 
	
	//insert new record in the clients table
	//check if the lead is existing in the leads table
	$sql = $db->select()
		->from('clients' , 'id')
		->where('leads_id =?' , $leads_id);
	$id = $db->fetchOne($sql);
	if(!$id){
		$data = array('leads_id' => $leads_id);
		$db->insert('clients' , $data);
	}
	
	
	$url = "../leads_information.php?id=".$leads_id."&lead_status=".$lead_status;

}else{
	
	$data = array('status' => $lead_status , 'contacted_since' => $ATZ, 'last_updated_date' => $ATZ);
	addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);
	
	$url = "../leads_information.php?id=".$leads_id."&lead_status=".$lead_status;
}



header("Location: $url");
?>

