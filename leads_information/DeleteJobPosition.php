<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'bp';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}



$id = $_REQUEST['id'];
$leads_id = $_REQUEST['leads_id'];
//get the category id
	
$sql = $db->select()
	->from('leads_inquiry' , 'category_id')
	->where('id =?' ,$id);	
$category_id = $db->fetchOne($sql);	


$sql = $db->select()
	->from('job_category' , 'category_name')
	->where('category_id =?' ,$category_id);
$category_name = $db->fetchOne($sql);


$where = "id = " .$id;
$db->delete('leads_inquiry' , $where);

$history_changes = 'Deleted Leads Inquiring about : '.$category_name;
$changes = array(
			 'leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $created_by_id, 
			 'change_by_type' => $created_by_type
			 );
$db->insert('leads_info_history', $changes);

$data = array('last_updated_date' => date('Y-m-d H:i:s'));
$db->update('leads', $data, 'id='.$leads_id);
?>