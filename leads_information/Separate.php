<?php
//2011-02-14 Normaneil Macutay <normanm@remotestaff.com.au>
include '../conf/zend_smarty_conf.php';
include '../lib/addLeadsInfoHistoryChanges.php';
include '../lib/validEmail.php';
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
$leads_new_info_id = $_REQUEST['leads_new_info_id'];
$email = trim($_REQUEST['email']);

$sql = "SELECT fname , lname , email , status , ask_question, asl_orders FROM leads WHERE id = ".$leads_id;
$leads_info = $db->fetchRow($sql);

//$sql = "SELECT fname , lname , email , status FROM leads_new_info WHERE id = ".$leads_new_info_id;
//$leads_new_info = $db->fetchRow($sql);

$separate_flag = True;

if (!validEmailv2(trim($email))){
	$separate_flag = False;
	echo 'Invalid email address';
	exit;
}

//check if the email is existing
$sql = $db->select()
	->from('leads' , 'id')
	->where('email =?' ,trim($email));
$id_email_exist = $db->fetchOne($sql);	

if($id_email_exist){
	$separate_flag = False;
	echo 'This email address already Exist. Please try to enter a different email address';
	exit;
}

if($separate_flag == True){
		$sql = $db->select()
			->from('leads_new_info')
			->where('leads_id =?' , $leads_id)
			->where('id =?' , $leads_new_info_id);
		$leads_new_info = $db->fetchRow($sql);
		//print_r($leads_new_info);
		$data =  array(
			'tracking_no' => $leads_new_info['tracking_no'], 
			'agent_id' => $leads_new_info['agent_id'], 
			'business_partner_id' => $leads_new_info['business_partner_id'], 
			'timestamp' => $leads_new_info['timestamp'], 
			'status' => $leads_new_info['status'], 
			'lname' => $leads_new_info['lname'], 
			'fname' => $leads_new_info['fname'], 
			'email' => trim($email),
			'officenumber' => $leads_new_info['officenumber'], 
			'mobile' => $leads_new_info['mobile'],  
			'leads_country' => $leads_new_info['leads_country'], 
			'leads_ip' => $leads_new_info['leads_ip'],
			'location_id' => $leads_new_info['location_id'], 
			'registered_in' => $leads_new_info['registered_in'], 
			'registered_url' => $leads_new_info['registered_url'], 
			'registered_domain' => $leads_new_info['registered_domain'],
			'ask_question' =>  $leads_info['ask_question'],
			'asl_orders' => $leads_info['asl_orders'],
			'last_updated_date' => $ATZ
		);
		
		//print_r($data);
		//exit;
		$db->insert('leads' ,$data);
		$new_leads_id = $db->lastInsertId();
		
		//update all the leads messages that are associated with $leads_id
		$data = array('leads_id' => $new_leads_id, 'leads_type' => 'regular') ;
		$where = "leads_id = ".$leads_id. " AND leads_type = 'temp'";
		$db->update('leads_message', $data , $where);
		
		//DELETE the RECORD
		$where = "id = ".$leads_new_info_id;	
		$db->delete('leads_new_info' , $where);
		
		//update the personal_id of the lead
		$data = array('personal_id' => $new_leads_id);
		$where = "id = ".$new_leads_id;
		$db->update('leads', $data , $where);
		
		//update the marked of the lead
		$data = array('marked' => 'no' , 'ask_question' => 'no', 'asl_orders' => 'no', 'last_updated_date' => $ATZ );
		$where = "id = ".$leads_id;
		$db->update('leads', $data , $where);
		
		
		//important we parse all leads transactions record in this profile
		//id, leads_id, leads_new_info_id, reference_column_name, reference_no, reference_table, date_added
		$sql = $db->select()
			->from('leads_transactions')
			->where('leads_id =?' , $leads_id)
			->where('leads_new_info_id =?' , $leads_new_info_id);
		$transactions = $db->fetchAll($sql);	
		foreach($transactions as $transaction){
			//we assume that all column field name is leads_id , debug if not , must have a condition in this matter
			$data = array('leads_id' => $new_leads_id);
			$where = $transaction['reference_column_name']." = ".$transaction['reference_no'];
			$table = $transaction['reference_table'];
			$db->update($table, $data , $where);
			
			//delete the record after updating
			$where = "id = ".$transaction['id'];	
			$db->delete('leads_transactions' , $where);
		}
		
		
		
		$history_changes = "Separated from #".$leads_id." ".$leads_info['fname']." ".$leads_info['lname']." [ ".$leads_info['email']." ]";
		$changes = array(
					 'leads_id' => $new_leads_id ,
					 'date_change' => $ATZ, 
					 'changes' => $history_changes, 
					 'change_by_id' => $comment_by_id, 
					 'change_by_type' => $comment_by_type
		);
		$db->insert('leads_info_history', $changes);
		
		$history_changes = "#".$new_leads_id." ".trim($leads_new_info['fname'])." ".trim($leads_new_info['lname'])." [ ".trim($email)." ] separated to  #".$leads_id." ".$leads_info['fname']." ".$leads_info['lname']." [ ".$leads_info['email']." ]";
		$changes = array(
					 'leads_id' => $leads_id ,
					 'date_change' => $ATZ, 
					 'changes' => $history_changes, 
					 'change_by_id' => $comment_by_id, 
					 'change_by_type' => $comment_by_type
		);
		$db->insert('leads_info_history', $changes);
		
		
		
		
		
}

echo $new_leads_id;
exit;
?>