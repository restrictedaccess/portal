<?php
include '../conf/zend_smarty_conf.php';
include '../lib/addLeadsInfoHistoryChanges.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'bp';
	$merged_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
	$merged_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}


$leads_id = $_REQUEST['leads_id'];
$merge_fields = $_REQUEST['merge_fields'];
$lead_status = $_REQUEST['lead_status'];
$identical_id = $_REQUEST['identical_id'];
$email_use = $_REQUEST['email_use'];


//echo $email_use;exit;

//get the existing_leads_id

$sql = $db->select()
	->from('leads_indentical' , 'existing_leads_id')
	->where('id =?' , $identical_id);
$existing_leads_id = $db->fetchOne($sql);	




$sql = "SELECT fname , lname , email , status, ask_question, asl_orders FROM leads WHERE id = ".$leads_id;
$leadsinfo = $db->fetchRow($sql);
//echo $sql."<br>";

$sql = "SELECT fname , lname , email , status, ask_question, asl_orders FROM leads WHERE id = ".$existing_leads_id;
$leadsmergeinfo = $db->fetchRow($sql);

//echo $sql."<br>";
//echo "make ".$email_use." : ".$leadsinfo['email']." \n ".$leadsmergeinfo['email'];
//exit;

if($merge_fields){
		//echo $merge_fields;
		$sql = "SELECT ".$merge_fields." FROM leads WHERE id = ".$existing_leads_id;
		$leads_merge_info = $db->fetchRow($sql);
		
		
		$sql = "SELECT ".$merge_fields." FROM leads WHERE id = ".$leads_id;
		$leads_info = $db->fetchRow($sql);
		
		
		
		
		 
		foreach(array_keys($leads_merge_info) as $array_key){
			
			//$history_changes .= sprintf("%s => %s to Lead [<b> #%s %s %s </b>] %s<br>", $array_key, $leads_info[$array_key] , $leads_id, $leadsmergeinfo['fname'] , $leadsmergeinfo['lname'],$leads_merge_info[$array_key] );
			$history_changes .= sprintf('Lead #%s %s %s [ <strong>%s => %s</strong> ] information merged to Lead #%s %s %s [ %s ].<br>' , $leads_id , $leadsinfo['fname'] , $leadsinfo['lname'] , $array_key , $leads_info[$array_key] , $existing_leads_id , $leadsmergeinfo['fname'] , $leadsmergeinfo['lname'] , $array_key);
			
			if($array_key == 'email'){
				$data = array($array_key => $leads_info[$array_key] );
				$history_changes .= sprintf('%s => from %s to %s<br>' , $array_key , $leads_merge_info[$array_key], $leads_info[$array_key] );
				
			}else if($array_key == 'status'){
				
				$data = array($array_key => $leads_info[$array_key] );
				$history_changes .= sprintf('%s => from %s to %s<br>' , $array_key , $leads_merge_info[$array_key], $leads_info[$array_key] );
				
			}else{
				
				if($leads_merge_info[$array_key] != ""){
					$str = $leads_merge_info[$array_key]." / ".$leads_info[$array_key];
				}else{
					$str = $leads_info[$array_key];
				}
				
				$data = array($array_key => $str );
			}
			$data['last_updated_date'] = date('Y-m-d H:i:s');
			$where = "id = ".$existing_leads_id;
			$db->update('leads', $data , $where);
		}
}

//echo $history_changes;exit;

//remove the identical lead in the lead_identical table
$queryIdentical = $db->select()
	->from('leads_indentical')
	->where('leads_id =?' , $leads_id);
$identicals = $db->fetchAll($queryIdentical);
foreach($identicals as $identical){
	$removed_marked_leads_id = $identical['existing_leads_id'];
	$data = array('marked' => 'no' , 'contacted_since' => $ATZ);
	$where = "id = ".$removed_marked_leads_id;
	$db->update('leads', $data , $where);

}	
$where = "leads_id = ".$leads_id;
$db->delete('leads_indentical', $where);





//update the leads_id in the leads table
$data = array('marked' => 'no' , 'status' => 'REMOVED' , 'contacted_since' => $ATZ, 'email' => $leadsinfo['email'].'.MERGED', 'ask_question' => 'no', 'asl_orders' => 'no', 'last_updated_date' => $ATZ );
addLeadsInfoHistoryChanges($data , $leads_id , $comment_by_id , $comment_by_type);
$where = "id = ".$leads_id;
$db->update('leads', $data , $where);


//remove the marked flag
if($email_use == 'primary'){
	 
	
	//MAKE THE IDENTICAL LEADS EMAIL BE THE PRIMARY EMAIL OF THE CHOSEN EXISTING LEAD
	$data = array('marked' => 'no' ,'contacted_since' => $ATZ , 'email' => $leadsinfo['email'], 'last_updated_date' => $ATZ);
	addLeadsInfoHistoryChanges($data , $existing_leads_id , $comment_by_id , $comment_by_type);
	$where = "id = ".$existing_leads_id;
	$db->update('leads', $data , $where);
	
	//MAKE THE EXISTING PRIMARY EMAIL OF THE CHOSEN EXISTING LEAD AS AN ALTERNATE EMAIL
	$data = array('leads_id' => $existing_leads_id, 'email' => $leadsmergeinfo['email'] , 'date_added' => $ATZ, 'added_by_id' => $comment_by_id, 'added_by_type' => $merged_by_type);
	$db->insert('leads_alternate_emails' , $data);
	
	//ADD HISTORY
	$email_use_str = "Changed the Primary email address of #".$existing_leads_id." ".$leadsmergeinfo['fname']." ".$leadsmergeinfo['lname']." from ".$leadsmergeinfo['email']." to ".$leadsinfo['email']."<br>";
	$email_use_str .= "Changed the Primary email address of #".$leads_id." ".$leadsinfo['fname']." ".$leadsinfo['lname']." from ".$leadsinfo['email']." to ".$leadsinfo['email'].".MERGED<br>";
	$email_use_str .= "Makes the old Primary email address of #".$existing_leads_id." ".$leadsmergeinfo['fname']." ".$leadsmergeinfo['lname']." [ ".$leadsmergeinfo['email']." ] into an alternative email.<br>";

}else{

	$data = array('marked' => 'no' ,'contacted_since' => $ATZ, 'last_updated_date' => $ATZ );
	addLeadsInfoHistoryChanges($data , $existing_leads_id , $comment_by_id , $comment_by_type);
	$where = "id = ".$existing_leads_id;
	$db->update('leads', $data , $where);
	
	//MAKE THE IDENTICAL LEAD EMAIL AS AN ALTERNATE EMAIL OF THE CHOSEN EXISTING LEAD
	$data = array('leads_id' => $existing_leads_id, 'email' => $leadsinfo['email'] , 'date_added' => $ATZ, 'added_by_id' => $comment_by_id, 'added_by_type' => $merged_by_type);
	$db->insert('leads_alternate_emails' , $data);
	
	//ADD HISTORY
	$email_use_str = "Changed the Primary email address of #".$leads_id." ".$leadsinfo['fname']." ".$leadsinfo['lname']." from ".$leadsinfo['email']." to ".$leadsinfo['email'].".MERGED<br>";
	$email_use_str .= "Makes the Primary email address of #".$leads_id." ".$leadsinfo['fname']." ".$leadsinfo['lname']." [ ".$leadsinfo['email']." ] into an alternative email of #" .$existing_leads_id." ".$leadsmergeinfo['fname']." ".$leadsmergeinfo['lname']."<br>";
	
}


$data = array('contacted_since' => $ATZ, 'ask_question' => $leadsinfo['ask_question'], 'asl_orders' => $leadsinfo['asl_orders'], 'last_updated_date' => $ATZ );
addLeadsInfoHistoryChanges($data , $existing_leads_id , $comment_by_id , $comment_by_type);
$where = "id = ".$existing_leads_id;
$db->update('leads', $data , $where);

//update leads_id current transactions
$sql = $db->select()
    ->from('leads_transactions')
	->where('leads_id =?' , $leads_id)
	->where('leads_new_info_id =?' , $leads_id);
$transactions = $db->fetchAll($sql);	
foreach($transactions as $transaction){
	//we assume that all column field name is leads_id , debug if not , must have a condition in this matter
	$data = array('leads_id' => $existing_leads_id);
	$where = $transaction['reference_column_name']." = ".$transaction['reference_no'];
	$table = $transaction['reference_table'];
	$db->update($table, $data , $where);
			
	//delete the record after updating
	$where = "id = ".$transaction['id'];	
	$db->delete('leads_transactions' , $where);
}



//update the leads_message
$data = array('leads_id' => $existing_leads_id);
$where = "leads_id = ".$leads_id;
$db->update('leads_message', $data , $where);


//insert record
$data = array('leads_id' => $leads_id, 'merged_to_leads_id' => $existing_leads_id, 'merged_by_id' => $comment_by_id, 'merged_by_type' => $merged_by_type, 'date_merged' => $ATZ);
$db->insert('leads_merged_info' , $data);


$updates_history = "#".$leads_id." ".$leadsinfo['fname']." ".$leadsinfo['lname']." [ ".$leadsinfo['email']." ] <strong>removed</strong> from the Leads list.<br>Status => REMOVED.<BR>";


$changes = array('leads_id' => $existing_leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes.$updates_history.$email_use_str, 
			 'change_by_id' => $comment_by_id, 
			 'change_by_type' => $comment_by_type);
$db->insert('leads_info_history', $changes);

$changes = array('leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes.$updates_history.$email_use_str, 
			 'change_by_id' => $comment_by_id, 
			 'change_by_type' => $comment_by_type);
$db->insert('leads_info_history', $changes);

//check if there is remote ready order and clear leads_new_info_id
$db->update("remote_ready_orders", array("leads_new_info_id"=>null), $db->quoteInto("remote_ready_lead_id = ?",$leads_id));

echo "merged";
exit;
?>