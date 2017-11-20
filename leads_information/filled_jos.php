<?php
include('../conf/zend_smarty_conf.php');
$smarty = new Smarty();
$retries = 0;
while (true) {
	try{
		if (TEST){
			$mongo = new MongoClient(MONGODB_TEST);
			$database = $mongo->selectDB('prod');
		}else{
			$mongo = new MongoClient(MONGODB_SERVER);
			$database = $mongo->selectDB('prod');
		}
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}
	
$job_orders_collection = $database->selectCollection('job_orders');
//var_dump(((int)$_GET['leads_id']));
$cursor = $job_orders_collection->find(array("leads_id"=>((int)$_GET['leads_id'])));
$job_orders = array();
while($cursor->hasNext()){
	$job_orders[] = $cursor->getNext();
}

$filled_forms=array();
$gs_job_role_selection_ids=array();
foreach($job_orders as $job_order){
	/*
	foreach($job_order["endorsed"] as $endorsement_request){
		if ($endorsement_request["type"]=="request"){
		
		}else{
		
		}
	}
	*/
	
	
	if($job_order['gs_job_titles_details_id'] != "" and $job_order['gs_job_role_selection_id'] != ""){
		if(in_array($job_order['gs_job_role_selection_id'], $gs_job_role_selection_ids) == false){
			$gs_job_role_selection_ids[] = $job_order['gs_job_role_selection_id'];
		
			/*
		    $data=array(
			    'gs_job_role_selection_id' => $job_order['gs_job_role_selection_id'],
			    'gs_job_titles_details_id' => $job_order['gs_job_titles_details_id'],
                'order_date' => date("Y-m-d", $job_order["date_filled_up"]->sec),
				'job_position' => $job_order['job_title'],
				'level' => $job_order['level'],
				'order_status' => $job_order['order_status']
			);
			$filled_forms[] = $data;
			*/
		}
		
	}
}


$orders=array();	
foreach($gs_job_role_selection_ids as $gs_job_role_selection_id){
	//$orders[] = array('gs_job_role_selection_id' => $gs_job_role_selection_id);
	$order_date = "";
	$order_status= "unknown";
	foreach($job_orders as $job_order){
		
		if(((int)$gs_job_role_selection_id) == ((int)$job_order['gs_job_role_selection_id'])){
			$order_date = date("Y-m-d", $job_order["date_filled_up"]->sec);
			
			if (($job_order['order_status']=="new")||($job_order['order_status']=="active")||$job_order['order_status']=="Open"){
				$order_status = "Open";
			}else if ($job_order['order_status']=="cancel"||$job_order['order_status']=="Cancel"){
				$order_status = "Did not push through";
			}else if ($job_order['order_status']=="finish"||$job_order['order_status']=="Closed"){
				$order_status = "Closed";
			}else if ($job_order['order_status']=="onhold"||$job_order['order_status']=="OnHold"){
				$order_status = "On Hold";
			}else if ($job_order['order_status']=="ontrial"||$job_order['order_status']=="OnTrial"){
				$order_status = "On Trial";
			}else{
				$order_status = $job_order["order_status"];
			}
			
			$data=array(
				'gs_job_role_selection_id' => $job_order['gs_job_role_selection_id'],
				'gs_job_titles_details_id' => $job_order['gs_job_titles_details_id'],
				'jr_cat_id' => $job_order['jr_cat_id'],
            	'jr_list_id' => $job_order['jr_list_id'],
				'order_date' => date("Y-m-d", $job_order["date_filled_up"]->sec),
				'job_position' => $job_order['job_title'],
				'level' => $job_order['level'],
				'order_status' => $order_status
			);
			//$filled_forms[] = $data;
			array_push($filled_forms, $data);
		}

	}
	//$orders['filled_forms'] = $filled_forms;
	//$filled_forms=array();
	$order=array(
		'gs_job_role_selection_id' => $gs_job_role_selection_id,
		'order_date' =>$order_date,
		'filled_forms' => $filled_forms
	);
	
	$orders[]=$order;
	$filled_forms=array();
}

//echo "<pre>";
//print_r($job_orders);
//echo "<hr>";
//print_r($orders);
//echo "</pre>";
$smarty->assign('orders',$orders);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('filled_jos.tpl');
exit;
//echo json_encode(array("success"=>true, "orders" => $orders));
//exit;
?>