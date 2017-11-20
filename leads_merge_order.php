<?php
include('conf/zend_smarty_conf_root.php');
include 'time.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;
//echo ip2long('112.210.130.165');
$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$transfer_status = False;
if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$change_by_id = $_SESSION['agent_no'] ;
	$change_by_type = 'bp';
	$created_by_type = 'agent';
	
	
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
	$change_by_id = $_SESSION['admin_id'] ;
	$created_by_type = 'admin';
	$change_by_type = 'admin';
	$smarty->assign('admin_section',True);	
	
}else{

	header("location:index.php");
}


include './lib/addLeadsInfoHistoryChanges.php';

$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}


$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';
$site = $_SERVER['HTTP_HOST'];

//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);		

if(isset($_POST['transfer'])){
	//echo "Hello World ".$leads_id;
	$merged_to_leads_id =  $_POST['leads'];
	if($merged_to_leads_id){
			
			$data = array('merged_to_leads_id' => $merged_to_leads_id);
			$where = "merged_to_leads_id = ".$leads_id;	
			$db->update('leads_merged_info' , $data , $where);

			$data = array(
				'leads_id' => $leads_id, 
				'merged_to_leads_id' => $merged_to_leads_id, 
				'merged_by_id' => $created_by_id, 
				'merged_by_type' => $created_by_type, 
				'date_merged' => $ATZ
			);
			$db->insert('leads_merged_info' , $data);
			
			$data = array('marked' => 'no' , 'status' => 'REMOVED');
			addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
			$where = "id = ".$leads_id;	
			$db->update('leads' ,  $data , $where);
			
			//delete record in the leads_indentical
			$where = "leads_id = ".$leads_id;	
			$db->delete('leads_indentical' ,  $where);
			
			$changes = array(
						 'leads_id' => $merged_to_leads_id ,
						 'date_change' => $ATZ, 
						 'changes' => "#".$leads_info['id']." ".$leads_info['fname']." ".$leads_info['lname']." ".$leads_info['email']." orders was merged to this lead", 
						 'change_by_id' => $change_by_id, 
						 'change_by_type' => $change_by_type
			);
			$db->insert('leads_info_history', $changes);
			
			$sql = $db->select()
				->from('leads' , Array('fname' , 'lname'))
				->where('id =?' , $merged_to_leads_id);
			$merge_lead_info = $db->fetchRow($sql);	
			
			$changes = array(
						 'leads_id' => $leads_id ,
						 'date_change' => $ATZ, 
						 'changes' => "All orders was merged to #".$merged_to_leads_id." ".$merge_lead_info['fname']." ".$merge_lead_info['lname'], 
						 'change_by_id' => $change_by_id, 
						 'change_by_type' => $change_by_type
			);
			$db->insert('leads_info_history', $changes);
			
			
			
			
			
			
			$smarty->assign('msg' , 'Successfully merged all orders and this lead was removed from the list');
	}else{
			$smarty->assign('msg' , 'Please choose a lead to merge on');
	}
}




	



//checked if the lead is existing in leads_indentical table
//id, leads_id, existing_leads_id
$queryIdentical = $db->select()
		->from(array('i' => 'leads_indentical') , array('existing_leads_id'))
		->join(array('l' => 'leads') , 'l.id = i.existing_leads_id' , array('fname' , 'lname' , 'email' , 'status'))
		->where('i.leads_id =?' , $leads_id);
//echo $queryIdentical;		
$identical_leads = $db->fetchAll($queryIdentical);

		
$smarty->assign('transfer_status',$transfer_status);
$smarty->assign('identical_leads' , $identical_leads);
$smarty->assign('lead_status' , $lead_status);
$smarty->assign('leads_info' , $leads_info);
$smarty->assign('leads_id' , $leads_id);

$smarty->display('leads_merge_order.tpl');
?>