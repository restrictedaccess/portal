<?php
$flagging_menus = array();
if($_SESSION['admin_id']){
    //for admin
    $sql = "SELECT COUNT(id) AS no_of_lead , status FROM leads l WHERE marked='yes' OR ask_question = 'yes' OR mark_lead_for !='unmark'  GROUP by status;";

}else{
   //for bp
   $sql=$db->select()
       ->from('agent', 'view_leads_setting')
	   ->where('agent_no =?',$_SESSION['agent_no']);
   $view_leads_setting = $db->fetchOne($sql);
   if($view_leads_setting==""){
	   $sql = "SELECT COUNT(id) AS no_of_lead , status FROM leads l WHERE (marked='yes' OR ask_question = 'yes' OR mark_lead_for !='unmark'  ) AND business_partner_id = ".$_SESSION['agent_no']." GROUP by status;";
   }else if($view_leads_setting == 'all'){
      $sql = "SELECT COUNT(id) AS no_of_lead , status FROM leads l WHERE (marked='yes' OR ask_question = 'yes' OR mark_lead_for !='unmark' ) GROUP by status;";
   }else{
      $sql = "SELECT COUNT(id) AS no_of_lead , status FROM leads l WHERE (marked='yes' OR ask_question = 'yes' OR mark_lead_for !='unmark' ) AND business_partner_id = ".$_SESSION['agent_no']." GROUP by status;"; 
   } 

}

$new_lead_marked_flag ="";
$follow_up_marked_flag ="";
$keep_in_touch_marked_flag = "";
$pending_marked_flag = "";
$client_marked_flag = "";
$asl_up_marked_flag ="";
$custom_recruitment_marked_flag ="";

//echo $sql;
$leads_marked = $db->fetchAll($sql);
foreach($leads_marked as $lead_marked){
		
		if($lead_marked['status'] == 'New Leads' ){
			$new_lead_marked_flag = "<img src='images/star.png' border='0'  >";
			$data = array(
			    'status' => $lead_marked['status'],
				'flag' => $new_lead_marked_flag
			);
			array_push($flagging_menus,$data);
		}
		
		if($lead_marked['status'] == 'Follow-Up' ){
			$follow_up_marked_flag = "<img src='images/star.png'  border='0'  >";
			$data = array(
			    'status' => $lead_marked['status'],
				'flag' => $follow_up_marked_flag
			);
			array_push($flagging_menus,$data);
		}
		
		if($lead_marked['status'] == 'Keep In-Touch' ){
			$keep_in_touch_marked_flag = "<img src='images/star.png' border='0'  >";
			$data = array(
			    'status' => $lead_marked['status'],
				'flag' => $keep_in_touch_marked_flag
			);
			array_push($flagging_menus,$data);
		}
		
		if($lead_marked['status'] == 'pending' ){
			$pending_marked_flag = "<img src='images/star.png'  border='0'  >";
			$data = array(
			    'status' => $lead_marked['status'],
				'flag' => $pending_marked_flag
			);
			array_push($flagging_menus,$data);
		}
		
		if($lead_marked['status'] == 'Client' ){
			$client_marked_flag = "<img src='images/star.png' border='0'  >";
			$data = array(
			    'status' => $lead_marked['status'],
				'flag' => $client_marked_flag
			);
			array_push($flagging_menus,$data);
		}
		
		if($lead_marked['status'] == 'asl' ){
			$asl_up_marked_flag = "<img src='images/star.png' border='0'  >";
			$data = array(
			    'status' => $lead_marked['status'],
				'flag' => $asl_up_marked_flag
			);
			array_push($flagging_menus,$data);
		}
		
		if($lead_marked['status'] == 'custom recruitment' ){
			$custom_recruitment_marked_flag = "<img src='images/star.png' border='0'  >";
			$data = array(
			    'status' => $lead_marked['status'],
				'flag' => $custom_recruitment_marked_flag
			);
			array_push($flagging_menus,$data);
		}
		
		
}
?>