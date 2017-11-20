<?php
$asl_orders = array();
$leads_with_orders = array();
//if($_SESSION['admin_id']){
    $sql = "SELECT t.leads_id, l.status FROM tb_request_for_interview t JOIN leads l ON l.id = t.leads_id  GROUP BY t.leads_id;";
//}else{
//    $sql = "SELECT t.leads_id, l.status FROM tb_request_for_interview t JOIN leads l ON l.id = t.leads_id  WHERE l.business_partner_id = ".$_SESSION['agent_no']." GROUP BY t.leads_id;";
//}
//echo $sql;
$leads_with_asl_orders = $db->fetchAll($sql);
foreach($leads_with_asl_orders as $lead){
     $leads_id = $lead['leads_id'];
	 
	 $orders_str = asl_order_checker($leads_id);
	 //echo $sql."<br>".$orders_str."<hr>"; 
	 if($orders_str > 0){
	     array_push($asl_orders,$lead['status']);
		 //$sql = $db->select()
		 //   ->from('leads')
		 //	->where('id =?', $leads_id);
		 //$lead_with_order = $db->fetchRow($sql);	
		 //$data = array('id' => $leads_id, 'fname'=> $lead['fname'], 'status' => $lead['status'], 'order' => $order_str);
		 array_push($leads_with_orders, $leads_id);
	 }
	 
}

function asl_order_checker($leads_id){
    global $db;
	
	$new_asl=0;
	$new_custom=0;
	$hired_asl = 0;
	$hired_custom = 0;
	
	if($leads_id !=""){
		
	$sql = $db->select()
		->from('tb_request_for_interview' , Array('id','status','service_type'))
		->where('leads_id =?' , $leads_id);
	$orders = $db->fetchAll($sql);
	
	if (count($orders) > 0){
		
		
		
		foreach($orders as $order){
			if($order['status']=='NEW'){
				if($order['service_type'] == 'ASL'){
					$new_asl++;
				}else{
					$new_custom++;
				}
			}else if($order['status']=='ON-HOLD'){
				if($order['service_type'] == 'ASL'){
					$on_hold_asl++;
				}else{
					$on_hold_custom++;
				}
			}else if($order['status']=='HIRED'){
				if($order['service_type'] == 'ASL'){
					$hired_asl++;
				}else{
					$hired_custom++;
				}
			}else if($order['status']=='REJECTED'){
				if($order['service_type'] == 'ASL'){
					$rejected_asl++;
				}else{
					$rejected_custom++;
				}
			}else if($order['status']=='CONFIRMED'){
				if($order['service_type'] == 'ASL'){
					$confirmed_asl++;
				}else{
					$confirmed_custom++;
				}
			}else if($order['status']=='YET TO CONFIRM'){
				if($order['service_type'] == 'ASL'){
					$yet_to_confirm_asl++;
				}else{
					$yet_to_confirm_custom++;
				}
			}else if($order['status']=='DONE'){
				if($order['service_type'] == 'ASL'){
					$done_asl++;
				}else{
					$done_custom++;
				}
			}else if($order['status']=='RE-SCHEDULED'){
				if($order['service_type'] == 'ASL'){
					$rescheduled_asl++;
				}else{
					$rescheduled_custom++;
				}
			}else if($order['status']=='CANCELLED'){
				if($order['service_type'] == 'ASL'){
					$cancelled_asl++;
				}else{
					$cancelled_custom++;
				}
			}else if($order['status']=='ARCHIVED'){
				if($order['service_type'] == 'ASL'){
					$archived_asl++;
				}else{
					$archived_custom++;
				}
			}
			
		}
		
		//$orders_str .=$hired_asl;
		
		$orders_str = 0;
		
		//ASL
		if($new_asl > 0){
			$orders_str = $orders_str + 1;
		}
		
		if($hired_asl == 0){
			if($confirmed_asl == 0 and ($archived_asl > 0 or $cancelled_asl > 0 or $rejected_asl > 0)){
				$orders_str = $orders_str +0;
			}else if($on_hold_asl > 0 or $rejected_asl > 0 or  $confirmed_asl > 0 or $yet_to_confirm_asl > 0 or  $rescheduled_asl > 0 or $cancelled_asl > 0 or $done_asl > 0){
				$orders_str = $orders_str + 1;
			}
			
		}else{
			if($archived_asl > 0 or $cancelled_asl > 0 or $rejected_asl > 0){
				$orders_str = $orders_str + 0;
			}else if($confirmed_asl > 0 or $done_asl > 0 or $yet_to_confirm_asl > 0 or  $rescheduled_asl > 0){
				$orders_str = $orders_str + 1;
			}
			
		}
		
		
		//CUSTOM
		if($new_custom > 0){
			$orders_str = $orders_str + 1;
		}
		
		if($hired_custom == 0){
			if($confirmed_custom == 0 and ($archived_custom > 0 or $cancelled_custom > 0 or $rejected_custom > 0)){
				$orders_str = $orders_str + 0;
			}else if($on_hold_custom > 0 or $rejected_custom > 0 or  $confirmed_custom > 0 or $yet_to_confirm_custom > 0 or  $rescheduled_custom > 0 or $cancelled_custom > 0 or $done_custom > 0){
				$orders_str = $orders_str + 1;
			}	
		}else{
			if($archived_custom > 0 or $cancelled_custom > 0 or $rejected_custom > 0){
				$orders_str = $orders_str + 0;
			}else if($confirmed_custom > 0 or  $done_custom > 0 or $yet_to_confirm_custom > 0 or  $rescheduled_custom > 0){
				$orders_str = $orders_str + 1;
			}
		}
	
	}else{
	    $orders_str = 0;
	}
	return $orders_str;
	}
}

$asl_orders = array_unique($asl_orders);
//print_r($asl_orders);
foreach($asl_orders as $asl_order){
   // echo $asl_order."<br>";  
   
        if($asl_order == 'New Leads' ){
			$new_lead_marked_flag = "<img src='images/star.png' border='0'  >";
		}
		
		if($asl_order == 'Follow-Up' ){
			$follow_up_marked_flag = "<img src='images/star.png'  border='0'  >";
		}
		
		if($asl_order == 'Keep In-Touch' ){
			$keep_in_touch_marked_flag = "<img src='images/star.png' border='0'  >";
		}
		
		if($asl_order == 'pending' ){
			$pending_marked_flag = "<img src='images/star.png'  border='0'  >";
		}
		
		if($asl_order == 'Client' ){
			$client_marked_flag = "<img src='images/star.png' border='0'  >";
		}
		
		if($asl_order == 'asl' ){
			$asl_up_marked_flag = "<img src='images/star.png' border='0'  >";
		}
		
		if($asl_order == 'custom recruitment' ){
			$custom_recruitment_marked_flag = "<img src='images/star.png' border='0'  >";
		}
		
}
?>