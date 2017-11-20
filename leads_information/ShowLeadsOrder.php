<?php
function ShowLeadsCustomOrder($leads_id){
	global $db;
	$order_counter =0;
	$total_order_counter = 0;
	$order_details_counter = 0;
	$str = '';
	$sql = "SELECT * FROM gs_job_role_selection WHERE leads_id = ".$leads_id;
	$orders = $db->fetchAll($sql);
	if(count($orders) > 0){
		foreach($orders as $o){
			 $sql = "SELECT * FROM gs_job_titles_details g WHERE form_filled_up = 'yes' AND gs_job_role_selection_id =".$o['gs_job_role_selection_id'];
			 $order_details = $db->fetchAll($sql);
			 $order_details_counter = count($order_details);
			 if($order_details_counter > 0){
			     foreach($order_details as $d){
			         //CHECK IF ADS STATUS IS ARCHIVE
			         $sql = "SELECT * FROM posting WHERE status = 'ARCHIVE' AND job_order_source = 'rs' AND job_order_id = ".$d['gs_job_titles_details_id'];
			 	     $posting = $db->fetchRow($sql);
					 if($posting['id']){
					      $order_details_counter = $order_details_counter - 1;
					 } 
			     }
			 }
			 //$total_order_counter = $total_order_counter + $order_counter;
		}
		if($order_details_counter > 0){
			$str = "<p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p>";
		}
	
	}
	
	//return $str;
}	
function CheckLeadsOrderInASL($leads_id){
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
	    $orders_str = $orders_str + 0;
	}
	return $orders_str;
	}
}
function ShowLeadsOrder($leads_id){
	global $db;
	
	$new_asl=0;
	$new_custom=0;
	$hired_asl = 0;
	$hired_custom = 0;
	
	
		
	$sql = $db->select()
		->from('tb_request_for_interview' , Array('id','status','service_type'))
		//->where('status !=?' , 'REJECTED')
		//->where('status !=?' , 'ARCHIVED')
		//->where('status !=?' , 'HIRED')
		->where('leads_id =?' , $leads_id);
	$orders = $db->fetchAll($sql);
	
	if (count($orders) > 0){
		
		
		
		/*
		ACTIVE : New
ON-HOLD : On Hold
HIRED : Hired
REJECTED : Rejected
CONFIRMED: Confirmed/In Process
YET TO CONFIRM: Client contacted, no confirmed date
DONE : Interviewed; waiting for feedback
RE-SCHEDULED : Confirmed/Re-Booked
CANCELLED : Cancelled
		*/
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
		
		
		
		//ASL
		if($new_asl > 0){
			$orders_str .="ASL ORDER : NEW!!!<br>";
		}
		
		if($hired_asl == 0){
		
			if($confirmed_asl == 0 and ($archived_asl > 0 or $cancelled_asl > 0 or $rejected_asl > 0)){
				$orders_str .="";
			}else if($on_hold_asl > 0 or $rejected_asl > 0 or  $confirmed_asl > 0 or $yet_to_confirm_asl > 0 or  $rescheduled_asl > 0 or $cancelled_asl > 0 or $done_asl > 0){
				$orders_str .="ASL ORDER : IN PROGRESS<br>";
			}
			
		}else{
			if($archived_asl > 0 or $cancelled_asl > 0 or $rejected_asl > 0){
				$orders_str .="";
			}else if($confirmed_asl > 0 or $done_asl > 0 or $yet_to_confirm_asl > 0 or  $rescheduled_asl > 0){
				$orders_str .="ASL ORDER : IN PROGRESS<br>";
			}
			
		}
		
		
		//CUSTOM
		if($new_custom > 0){
			$orders_str .="CUSTOM ORDER : NEW!!!<br>";
		}
		
		if($hired_custom == 0){
			if($confirmed_custom == 0 and ($archived_custom > 0 or $cancelled_custom > 0 or $rejected_custom > 0)){
				$orders_str .="";
			}else if($on_hold_custom > 0 or $rejected_custom > 0 or  $confirmed_custom > 0 or $yet_to_confirm_custom > 0 or  $rescheduled_custom > 0 or $cancelled_custom > 0 or $done_custom > 0){
				$orders_str .="CUSTOM ORDER : IN PROGRESS<br>";
			}	
		}else{
			if($archived_custom > 0 or $cancelled_custom > 0 or $rejected_custom > 0){
				$orders_str .="";
			}else if($confirmed_custom > 0 or  $done_custom > 0 or $yet_to_confirm_custom > 0 or  $rescheduled_custom > 0){
				$orders_str .="CUSTOM ORDER : IN PROGRESS<br>";
			}
		}
		
		
		if($orders_str!=""){
			$str .="<img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  />";
			$str .="<div style='display:block;float:left;margin-left:7px;font-weight:bold;'>";
			$str .=$orders_str;
			$str .="</div>";
		}
		return $str;
	}	
			
}


?>