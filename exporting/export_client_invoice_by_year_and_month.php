<?php
require('../conf/zend_smarty_conf.php');

$month = 4; //((int)$_GET['month']);
$year = 2014; //$_GET['year'];

$doc_client = new couchClient($couch_dsn, 'client_docs'); 
$doc_client->startkey(Array($year));
$doc_client->endkey(Array($year));    
$response = $doc_client->getView('reports', 'all_orders_except_cancelled_via_added_on');
echo "<pre>";
//print_r($response);




foreach($response->rows as $r){
        
        //$order_date = sprintf("%s-%s-%s %s:%s:%s", $r->value->order_date[0], $r->value->order_date[1], $r->value->order_date[2], $r->value->order_date[3], $r->value->order_date[4], $r->value->order_date[5]);
        
		$include_it=FALSE;
		
		//check and filter the items		
		$invoice_items=array();
		foreach($r->value->items as $item){
			$start_date_array = $item->start_date;
			
			
			if($start_date_array[1] == $month){ 
				$include_it=TRUE;		
				$invoice_items[] = $item;
			} 
			
		}
		
		if($include_it){
			
	        $results[] = array(
	            'id' => $r->id,
	            'order_id' => $r->value->order_id,
	            'status' => $r->value->status,
	            'apply_gst' => $r->value->apply_gst,
	            'date' => date("Y-m-d h:i:s" , strtotime($order_date)),
	            'currency' => $r->value->currency,
	            'total_amount' => $r->value->total_amount,
	            'client_id' => $r->value->client_id,
	            'client_name' => $r->value->client_name,
	            'invoice_items' => $invoice_items
	        );
        
		}
		
        
        
           
}



//print_r($results);
//exit;
//echo "<hr>";


$records=array();
foreach($results as $result){
	//print_r($result);
	
	
	//breaking down the items
	$items=array();
	foreach($result['invoice_items'] as $item){
		
		//print_r($item->start_date);
		//print_r($item->end_date);
		
		
		$start_date = $item->start_date;
		$start_date = sprintf("%s-%s-%s", $start_date[0], $start_date[1], $start_date[2]);
		$start_date = date('Y-m-d', strtotime($start_date));
		
		$end_date = $item->end_date;
		$end_date = sprintf("%s-%s-%s", $end_date[0], $end_date[1], $end_date[2]);
		$end_date = date('Y-m-d', strtotime($end_date));
		
		$insert_another_item = FALSE;
		$start_date_last_date = "";
		$end_date_first_date = "";
		
		if($item->end_date[1] > $month){
			
			$insert_another_item = TRUE;
			$start_date_last_date = date('Y-m-t', strtotime($start_date)); //last day of the month of start_date
						
			$end_date = $item->end_date;
			$end_date = sprintf("%s-%s-%s", $end_date[0], $end_date[1], $end_date[2]);
			$end_date_last_date = date('Y-m-d', strtotime($end_date));
			$end_date_first_date = date('Y-m-01', strtotime($end_date)); // get the first day of the end_date
						
		}
		
		if($insert_another_item){
			$end_date = $start_date_last_date;
		}
		
		$description = explode('[', $item->description);
		//echo trim($description[0])."<br>";
		
		//$db->select()->from;
		
		$items[]=array(
			'start_date' => $start_date,
			'end_date' => $end_date,
			'description' => $item->description,
			'unit_price' => $item->unit_price
		);
		
		
		if($insert_another_item){
			$items[]=array(
				'start_date' => $end_date_first_date,
				'end_date' => $end_date_last_date,
				'description' => $item->description,
				'unit_price' => $item->unit_price,
				'cloned' => 'yes'
			);
		}
		
	}
	
	
	$records[] = array(
		'doc_id' => $result['id'],
		'order_id' => $result['order_id'],
		'client_name' => $result['client_name'],
		'client_id' => $result['client_id'],
		'items' => $items
	);
	//print_r($records);
	//exit;
}

print_r($records);
echo "</pre>";
exit;
?>