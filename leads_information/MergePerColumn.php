<?php
//2010-11-08 Normaneil Macutay <normanm@remotestaff.co.au>
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}

$leads_id = $_REQUEST['leads_id'];
$leads_new_info_id = $_REQUEST['leads_new_info_id'];
$field_name = $_REQUEST['field_name'];
$column_value = $_REQUEST['column_value'];	

if(!$leads_id){
	echo "Leads Id is Missing.";
	exit;
}

if(!$leads_new_info_id){
	echo "Leads new information Id is Missing.";
	exit;
}

if(!$field_name){
	echo "Column name is missing";
	exit;
}

if(!$column_value){
	echo "There is no value to merge";
	exit;
}


//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);	
/*
$sql = $db->select()
	->from('leads_new_info')
	->where('id =?' , $leads_new_info_id);
$leads_new_info = $db->fetchRow($sql);
*/

if($leads_info['officenumber']){
	$officenumber = $leads_info['officenumber']." / ";
}else{
	$officenumber = $leads_info['officenumber'];
}

if($leads_info['mobile']){
	$mobile = $leads_info['mobile']." / ";
}else{
	$mobile = $leads_info['mobile'];
}

if($leads_info['remote_staff_competences']){
	$remote_staff_competences = $leads_info['remote_staff_competences']."\n\n";
}else{
	$remote_staff_competences = $leads_info['remote_staff_competences'];
}

if($field_name == 'leads_message'){

	$data = array('leads_type' => 'regular');
	$where = "leads_id = ".$leads_id;
	$db->update('leads_message', $data , $where);
	$history_changes = "All leads messages was merged to Leads Profile Information 1";

}else if($field_name =='officenumber') {
	
	$data = array('officenumber' => $officenumber.$column_value, 'last_updated_date' => $ATZ);
	$where = "id = ".$leads_id;
	$db->update('leads', $data , $where);
	$history_changes = "Leads Information 2 field Name [ ".$field_name." ] with a value of => '".$column_value. "' was merged to Leads Profile Information 1";

	$data = array('officenumber' => $column_value);
	$where = "id = ".$leads_new_info_id;
	$db->update('leads_new_info', $data , $where);
	
}else if($field_name =='mobile') {

	$data = array('mobile' => $mobile.$column_value, 'last_updated_date' => $ATZ);
	$where = "id = ".$leads_id;
	$db->update('leads', $data , $where);
	$history_changes = "Leads Information 2 field Name [ ".$field_name." ] with a value of => '".$column_value. "' was merged to Leads Profile Information 1";
	
	$data = array('mobile' => $column_value);
	$where = "id = ".$leads_new_info_id;
	$db->update('leads_new_info', $data , $where);
	
}else if($field_name =='remote_staff_competences') {

	$data = array('remote_staff_competences' => $remote_staff_competences.$column_value, 'last_updated_date' => $ATZ);
	$where = "id = ".$leads_id;
	$db->update('leads', $data , $where);
	$history_changes = "Leads Information 2 field Name [ ".$field_name." ] with a value of => '".$column_value. "' was merged to Leads Profile Information 1";
	
	$data = array('remote_staff_competences' => $column_value);
	$where = "id = ".$leads_new_info_id;
	$db->update('leads_new_info', $data , $where);
	
}else{
	
	$data = array($field_name => $column_value, 'last_updated_date' => $ATZ);
	$where = "id = ".$leads_id;
	$db->update('leads', $data , $where);
	$history_changes = "Leads Information 2 field Name [ ".$field_name." ] with a value of => '".$column_value. "' was merged to Leads Profile Information 1";
	
	$data = array($field_name => $column_value);
	$where = "id = ".$leads_new_info_id;
	$db->update('leads_new_info', $data , $where);
	

}
	
$changes = array(
			 'leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $created_by_id, 
			 'change_by_type' => $created_by_type
);
$db->insert('leads_info_history', $changes);	
//check if there is remote ready order and clear leads_new_info_id
$db->update("remote_ready_orders", array("leads_new_info_id"=>null), $db->quoteInto("remote_ready_lead_id = ?",$leads_id));


//print_r($data);exit;
echo "Successfully merged!";
exit;

?>

