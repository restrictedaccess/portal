<?php
/*
2011-02-14 Normaneil Macutay <normanm@remotestaff.com.au>


2014-12-24 Normaneil Macutay <normanm@remotestaff.com.au>
    - Added column "registration_date" in leads table to record the leads_new_info.timestamp 
*/


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
$leads_new_info_id = $_REQUEST['leads_new_info_id'];

$sql = "SELECT fname , lname , email , status, registration_dates, timestamp FROM leads WHERE id = ".$leads_id;
$leads_info = $db->fetchRow($sql);

$sql = "SELECT fname , lname , email , status, timestamp FROM leads_new_info WHERE id = ".$leads_new_info_id;
$leads_new_info = $db->fetchRow($sql);



$registration_dates_str = $leads_info['registration_dates'];
if($registration_dates_str){
    $registration_dates_str = sprintf('%s,%s', $registration_dates_str, $leads_info['timestamp']);
}else{
    $registration_dates_str = sprintf('%s', $leads_info['timestamp']);
}


//echo "<pre>";
//print_r($registration_dates_str);
//echo "</pre>";
//exit;


//reference code MergeLeadsInfo.php
if($merge_fields){

		$sql = "SELECT ".$merge_fields." FROM leads WHERE id = ".$leads_id;
		$leads_orig_info = $db->fetchRow($sql);
		
		$sql = "SELECT ".$merge_fields." FROM leads_new_info WHERE id = ".$leads_new_info_id;
		$leads_merge_info = $db->fetchRow($sql);
		
		
		foreach(array_keys($leads_merge_info) as $array_key){
				//echo $array_key."\n";
				if($array_key == 'fname' or $array_key == 'lname'){
				
						$data = array($array_key => $leads_merge_info[$array_key] );
						//$history_changes .= sprintf('%s => from %s to %s<br>' , $array_key , $leads_orig_info[$array_key], $leads_merge_info[$array_key] );
						//insert history
						addLeadsInfoHistoryChanges($data , $leads_id , $created_by_id , $created_by_type);
				}else{
					
						if($leads_merge_info[$array_key] != ""){
							$str = $leads_orig_info[$array_key]." / ".$leads_merge_info[$array_key];
						}else{
							$str = $leads_merge_info[$array_key];
						}
						
						$data = array($array_key => $str );
						//$history_changes .= sprintf('%s => from %s to %s<br>' , $array_key , $leads_orig_info[$array_key], $str );
						//insert history
						addLeadsInfoHistoryChanges($data , $leads_id , $created_by_id , $created_by_type);
				}
				
				//exit;
				$data['last_updated_date'] = date('Y-m-d H:i:s');
				$where = "id = ".$leads_id;
				$db->update('leads', $data , $where);
				
		}
	

}




function CountLeadsCustomOrder($leads_id){
	global $db;
	$order_counter =0;
	$total_order_counter = 0;
	$str = '';
	$sql = "SELECT * FROM gs_job_role_selection WHERE leads_id = ".$leads_id;
	$orders = $db->fetchAll($sql);
	if(count($orders) > 0){
		foreach($orders as $o){
			 $sql = "SELECT COUNT(gs_job_titles_details_id)AS order_counter FROM gs_job_titles_details g WHERE form_filled_up = 'yes' AND gs_job_role_selection_id =".$o['gs_job_role_selection_id'];
			 //echo $sql;
			 $order_counter = $db->fetchOne($sql);
			 $total_order_counter = $total_order_counter + $order_counter;
		}
	}
	return $total_order_counter;
}

//update the leads_message
$data = array('leads_type' => 'regular');
$where = "leads_id = ".$leads_id." AND leads_type = 'temp'";
$db->update('leads_message', $data , $where);


//remove the marked flag
$data = array('marked' => 'no' , 'last_updated_date' => $ATZ, 'timestamp' => $leads_new_info['timestamp'], 'registration_dates' => $registration_dates_str);
if(CountLeadsCustomOrder($leads_id) == 0){
    $data['custom_recruitment_order'] = 'no';
}
$where = "id = ".$leads_id;
$db->update('leads', $data , $where);


//delete leads new information in the leads_new_info table
$where = "id = ".$leads_new_info_id;
$db->delete('leads_new_info', $where);

//important we parse all leads transactions record in this profile
$where = "leads_id = ".$leads_id." AND leads_new_info_id = ".$leads_new_info_id;	
$db->delete('leads_transactions' , $where);

$history_changes = "Merged Data";
$changes = array('leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $comment_by_id, 
			 'change_by_type' => $comment_by_type);
$db->insert('leads_info_history', $changes);
//check if there is remote ready order and clear leads_new_info_id
$db->update("remote_ready_orders", array("leads_new_info_id"=>null), $db->quoteInto("remote_ready_lead_id = ?",$leads_id));



echo "merged";
exit;
?>