<?php
include('../conf/zend_smarty_conf.php');
include '../leads_information/ShowLeadsOrder.php';
include '../lib/addLeadsInfoHistoryChanges.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$sql = "SELECT t.leads_id, l.status, l.fname, l.lname  FROM tb_request_for_interview t JOIN leads l ON l.id = t.leads_id  GROUP BY t.leads_id;";
$leads_with_asl_orders = $db->fetchAll($sql);
echo "<ol>";
foreach($leads_with_asl_orders as $lead){
     $leads_id = $lead['leads_id'];
	 $orders_str = CheckLeadsOrderInASL($leads_id);
     if($orders_str > 0){
        $data = array('asl_orders' => 'yes');
     }else{
	    $data = array('asl_orders' => 'no');
     }
	 
	 addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
	 $db->update('leads', $data, 'id='.$leads_id);
	 echo sprintf('<li>%s %s %s</li>', $lead['leads_id'], $lead['fname'], $lead['lname']);
}
echo "</ol>";
/*
function HeaderCheckLeadsOrderInASL($leads_id){
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
*/
?>