<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'bp';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}


$leads_id = $_REQUEST['leads_id'];
$lead_status = $_REQUEST['lead_status'];


$sql = "SELECT fname , lname , email FROM leads WHERE id = ".$leads_id;
$leads_info = $db->fetchRow($sql);



//get all leads_id existing_leads_ids
$queryIdentical = $db->select()
	->from('leads_indentical')
	->where('leads_id =?' , $leads_id);
$identicals = $db->fetchAll($queryIdentical);

$identical_ids = array();
foreach($identicals as $identical){
	
		//update the marked
		$data = array('marked' => 'no' , 'contacted_since' => $ATZ, 'last_updated_date' => $ATZ);
		$where = "id = ".$identical['existing_leads_id'];
		$db->update('leads', $data , $where);
		
		//create history 
		//get the existing_leads_id info
		$sql = $db->select()
			->from('leads')
			->where('id =?' , $identical['existing_leads_id'] );
		$identical_leads_info = $db->fetchRow($sql);
		//echo $sql;exit;
		
		$hitory_changes .= sprintf('Lead #%s %s %s [%s] separated from #%s %s %s [%s].<br>',$leads_id , $leads_info['fname'] , $leads_info['lname'] , $leads_info['email'] , $identical['existing_leads_id'] , $identical_leads_info['fname'] , $identical_leads_info['lname'] , $identical_leads_info['email'] );
		
		$identical_ids[] = array('leads_id' => $identical['existing_leads_id']);
		
		//delete the record
		$where = "id = ".$identical['id'];
		$db->delete('leads_indentical', $where);
		
}	

//print_r($identical_ids);exit;

foreach($identical_ids as $identical_id){
	//echo $identical_id['leads_id']."\n";
	$changes = array('leads_id' => $identical_id['leads_id'] ,
		'date_change' => $ATZ, 
		'changes' => $hitory_changes, 
		'change_by_id' => $comment_by_id, 
		'change_by_type' => $comment_by_type);
	$db->insert('leads_info_history', $changes);

}

$changes = array('leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $hitory_changes, 
			 'change_by_id' => $comment_by_id, 
			 'change_by_type' => $comment_by_type);
$db->insert('leads_info_history', $changes);

//remove the marked flag
$data = array('marked' => 'no' ,'contacted_since' => $ATZ, 'last_updated_date' => $ATZ);
$where = "id = ".$leads_id;
$db->update('leads', $data , $where);

//important we parse all leads transactions record in this profile
$where = "leads_id = ".$leads_id." AND leads_new_info_id = ".$leads_id;	
$db->delete('leads_transactions' , $where);

echo "separated";
exit;
?>