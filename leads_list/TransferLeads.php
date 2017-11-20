<?php
include('../conf/zend_smarty_conf.php');
include '../leads_information/ShowLeadsOrder.php';


if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	$change_by_id = $_SESSION['agent_no'];
	$change_by_type = 'bp';
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){
	$change_by_id = $_SESSION['admin_id'];
	$change_by_type='admin';
}else{
	die("Session expire. Please relogin.");
}	



$leads = explode(',',$_REQUEST['leads']);
$sql = $db->select()
    ->from('agent')
	->where('agent_no =?', $_REQUEST['agent_id']);
$new_business_partner = $db->fetchRow($sql);	


//echo sprintf("Transfer these following leads to %s %s %s :\n", $bp['agent_no'], $bp['fname'], $bp['lname']);
$str="";

foreach($leads as $l){
	$history_changes = "";
    $sql = $db->select()
        ->from('leads', Array('id', 'fname', 'lname', 'email', 'agent_id', 'business_partner_id'))
        ->where('id=?', $l);
    $lead = $db->fetchRow($sql);

    //Check BP and Aff
	$sql = $db->select()
	    ->from('agent', 'work_status')
		->where('agent_no=?', $lead['agent_id']);
	$work_status = $db->fetchOne($sql);
	
	//Get the Info details of lead BP
	$sql = $db->select()
	    ->from('agent', Array('fname', 'lname'))
		->where('agent_no=?', $lead['business_partner_id']);
	$current_business_partner = $db->fetchRow($sql);
	
		

    //Check if the lead has an active orders
    $active_orders_str = "";
    $active_orders_str = ShowLeadsOrder($lead['id']);
    if($active_orders_str != ""){
		$str .= sprintf("%s %s %s cannot be transferred. It has an existing active order.\n" , $lead['id'], $lead['fname'], $lead['lname']);		
    }else{
		if($work_status == 'AFF'){
			$data = array(
			    'business_partner_id' => $_REQUEST['agent_id'],
				'date_move' => date('Y-m-d H:i:s'),
				'agent_from' => $lead['business_partner_id'],
				'last_updated_date' => date('Y-m-d H:i:s')
			);
			$where = "id = ".$l;	
			$db->update('leads' ,  $data , $where);
		}
		
		if($work_status == 'BP'){
			if($lead['agent_id'] == $lead['business_partner_id']){
			    $data = array(
				    'agent_id' => $_REQUEST['agent_id'],		  
			        'business_partner_id' => $_REQUEST['agent_id'],
				    'date_move' => date('Y-m-d H:i:s'),
				    'agent_from' => $lead['business_partner_id'],
				    'last_updated_date' => date('Y-m-d H:i:s')
			    );
				$where = "id = ".$l;	
			    $db->update('leads' ,  $data , $where);
			}
			if($lead['agent_id'] != $lead['business_partner_id']){
			    $data = array(
			        'business_partner_id' => $_REQUEST['agent_id'],
				    'date_move' => date('Y-m-d H:i:s'),
				    'agent_from' => $lead['business_partner_id'],
				    'last_updated_date' => date('Y-m-d H:i:s')
			    );
				$where = "id = ".$l;	
			    $db->update('leads' ,  $data , $where);
			}
			
		}
		
		$history_changes = sprintf('Lead has been transferred from BP %s %s to BP %s %s.<br>', $current_business_partner['fname'], $current_business_partner['lname'], $new_business_partner['fname'], $new_business_partner['lname']);
		$data= array(
		    'leads_id' => $l, 
			'date_change' => date('Y-m-d H:i:s'), 
			'changes' => $history_changes, 
			'change_by_id' => $change_by_id, 
			'change_by_type' =>	$change_by_type		 
		);
		$db->insert('leads_info_history', $data);
	    $str .= sprintf("%s %s %s transferred.\n" , $lead['id'], $lead['fname'], $lead['lname']);
	}
}
echo sprintf("Transferring Results:\n%s", $str);
exit;
//echo "<pre>";
//print_r($leads);
//echo "</pre>";
?>