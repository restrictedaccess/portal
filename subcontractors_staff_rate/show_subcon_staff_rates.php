<?php
function GetWorkStatus($id){
	global $db;
	$findme = "staff working status";
    $work_status = array();

    $sql ="SELECT * FROM subcontractors_history s where changes_status IN ('approved') AND ( changes LIKE '%".$findme."%' ) and subcontractors_id =".$id." order by id asc limit 1;";
    $history = $db->fetchRow($sql);
	$str_array = explode("<br>", $history['changes']);
	foreach($str_array as $str){		
		$pos = stripos($str, $findme);
	    if ($pos !== false) {
			//echo $str."<br>";
		    $strs = explode("from", $str);
            $str = trim($strs[1]);
            $strs = explode("to", $str);
            $from = trim($strs[0]);
            $to = trim($strs[1]);
			//$data=array('from' => $from, 'to' => $to);
			$work_status[] = $from;
	    }
	    
    }
	//
	$sql ="SELECT * FROM subcontractors_history s where changes_status IN ('approved') AND ( changes LIKE '%".$findme."%' ) and subcontractors_id =".$id." order by id asc;";
    $histories = $db->fetchAll($sql);
	foreach($histories as $history){
		$str_array = explode("<br>", $history['changes']);
		foreach($str_array as $str){
			$pos = stripos($str, $findme);
			if ($pos !== false) {
				$strs = explode("from", $str);
            	$str = trim($strs[1]);
            	$strs = explode("to", $str);
            	$from = trim($strs[0]);
            	$to = trim($strs[1]);
				$work_status[] = $to;
			}
		}
	}
	return $work_status;
}
function GetPreviousWorkStatus($subcon_id, $history_id, $first = false){
	global $db;
	$findme = "staff working status";
    $work_status = false;
	$sql ="SELECT * FROM subcontractors_history s where changes like '%".$findme."%' and id=$history_id;";
	$history = $db->fetchRow($sql);
    if($history){
		$history = $db->fetchRow($sql);
		$str_array = explode("<br>", $history['changes']);
		foreach($str_array as $str){		
			$pos = stripos($str, $findme);
			if ($pos !== false) {
				//echo $str."<br>";
				$strs = explode("from", $str);
				$str = trim($strs[1]);
				$strs = explode("to", $str);
				$from = trim($strs[0]);
				$to = trim($strs[1]);
				$data=array('from' => $from, 'to' => $to);
			    //	
			}
		}
		if($first){
			$work_status[] = $data;
		}else{
			$work_status[] = $data['to'];
		}
		
		return $work_status;
	}else{
		$sql ="SELECT * FROM subcontractors_history s where changes_status IN ('approved') AND ( changes LIKE '%".$findme."%' ) and subcontractors_id =".$subcon_id." order by id asc limit 1;";
		$history = $db->fetchRow($sql);
		if($history){
			$str_array = explode("<br>", $history['changes']);
			foreach($str_array as $str){		
				$pos = stripos($str, $findme);
				if ($pos !== false) {
					//echo $str."<br>";
					$strs = explode("from", $str);
					$str = trim($strs[1]);
					$strs = explode("to", $str);
					$from = trim($strs[0]);
					$to = trim($strs[1]);
					$data=array('from' => $from, 'to' => $to);
					//	
				}
			}
			if($first){
				//$work_status =  $from;
				$work_status[] = $data;
			}else{
				//$work_status =  $to;
				unset($data['from']);
				$work_status[] = $data;
			}
			
			
		}else{
			$sql = $db->select()
				->from('subcontractors', 'work_status')
				->where('id=?', $subcon_id);
			$working_status = $db->fetchOne($sql);
			//$work_status[] = $working_status;
			$data=array('from' => $working_status, 'to' => $working_status);
			$work_status[] = $data;
			
		}
		return $work_status;
	}
	

}


function show_subcon_client_rates($subcon_id){
	global $db;
	$findme = "client quoted price";
	$rates=array();
	$sql=$db->select()
		->from('subcontractors')
		->where('id=?', $subcon_id);
	$subcon =$db->fetchRow($sql);
	$starting_date = $subcon['starting_date'];
	//echo $starting_date;
	
	$sql ="SELECT * FROM subcontractors_history s where changes_status IN ('approved') AND ( changes LIKE '%".$findme."%' ) and subcontractors_id =".$subcon_id." order by id asc;";
	//echo $sql;
	$histories = $db->fetchAll($sql);
	//echo "<pre>";
	//print_r($histories);
	//echo "</pre>";
	$first_record = true;
	for($i=0; $i<count($histories); $i++){
        
		//Client price
		$pos = stripos($histories[$i]['changes'], $findme);
		if ($pos !== false) {
			preg_match_all('!\d+\.*\d*!', $histories[$i]['changes'] ,$m);	
			$m = $m[0];
			$from = $m[0];
			$to = $m[1];
		}
		
		//$pos2 = stripos($histories[$i]['changes'], 'staff working status');
		//if ($pos2 !== false) {
			$history_id = $histories[$i]['id'];
		//}
        $start_date = GetClientPriceEffectiveDate($histories[$i]['id'], $first_record, $subcon_id);
		//if($start_date == ""){
		//    $start_date = $histories[$i]['date_change'];
		//}
		
		$data=array(
			'id' => $histories[$i]['id'],	
			'start_date' => $start_date,
			'from' => $from,
			'to' => $to,
			'history_id' => $history_id,
			'first_record' => $first_record,
			'work_status' => GetPreviousWorkStatus($subcon_id, $history_id, $first_record)
		);
		$rates[] = $data;
		$first_record = false;
    }
	//$rates['work_status'] = GetWorkStatus($subcon_id);
	
	
	//echo "<hr><pre>";
	//print_r($rates);
	//echo "</pre>";
	//echo count($rates);
	//echo "<hr>";
	//exit;
	
	
	$client_rates = array();
	if($rates){
		$data = array(
			'start_date' => $rates[0]['start_date']['from'],
			'rate' => $rates[0]['from'],
			'work_status' => $rates[0]['work_status'][0]['from'],
		);
		$client_rates[] = $data;
		
		$data = array(
			'start_date' => $rates[0]['start_date']['to'],
			'rate' => $rates[0]['to'],
			'work_status' => $rates[0]['work_status'][0]['to'],
		);
		$client_rates[] = $data;
		
		for($i=1; $i<count($rates); $i++){
			$data = array(
				'start_date' => $rates[$i]['start_date']['to'],
				'rate' => $rates[$i]['to'],
				'work_status' => $rates[$i]['work_status'][0]['to'],
			);
			$client_rates[] = $data;
		}
	}
	//echo "<pre>";
	//print_r($client_rates);
	//echo "</pre>";
	
	//exit;
	if(!$client_rates){
		//echo "No changes yet in staff monthly salary";
		$data=array(
			'start_date' => $starting_date,
			'rate' => $subcon['client_price'],
			'work_status' => $subcon['work_status']
		);   
		$client_rates[] = $data;
		
	}
	//echo "<pre>";
	//print_r($client_rates);
	//echo "</pre>";
    return $client_rates;
	//exit;
}

function show_subcon_staff_rates($subcon_id){
	global $db;
	$findme = "staff monthly salary";
	$rates=array();
	$sql=$db->select()
		->from('subcontractors')
		->where('id=?', $subcon_id);
	$subcon =$db->fetchRow($sql);
	$starting_date = $subcon['starting_date'];
	//echo $starting_date;
	

	
	$sql ="SELECT * FROM subcontractors_history s where changes_status IN ('approved') AND ( changes LIKE '%".$findme."%' ) and subcontractors_id =".$subcon_id." order by id asc;";
	
	$histories = $db->fetchAll($sql);
	//echo "<pre>";
	//print_r($histories);
	//echo "</pre>";
	$first_record = true;
	for($i=0; $i<count($histories); $i++){
        
		//Client price
		$pos = stripos($histories[$i]['changes'], $findme);
		if ($pos !== false) {
			preg_match_all('!\d+\.*\d*!', $histories[$i]['changes'] ,$m);	
			$m = $m[0];
			$from = $m[0];
			$to = $m[1];
		}
		
		//$pos2 = stripos($histories[$i]['changes'], 'staff working status');
		//if ($pos2 !== false) {
			$history_id = $histories[$i]['id'];
		//}
        $start_date = GetClientPriceEffectiveDate($histories[$i]['id'], $first_record, $subcon_id);
		//if($start_date == ""){
		//    $start_date = $histories[$i]['date_change'];
		//}
		
		$data=array(
			'id' => $histories[$i]['id'],	
			'start_date' => $start_date,
			'from' => $from,
			'to' => $to,
			'history_id' => $history_id,
			'first_record' => $first_record,
			'work_status' => GetPreviousWorkStatus($subcon_id, $history_id, $first_record)
		);
		$rates[] = $data;
		$first_record = false;
    }
	//$rates['work_status'] = GetWorkStatus($subcon_id);
	
	
	//echo "<hr><pre>";
	//print_r($rates);
	//echo "</pre>";
	//echo count($rates);
	//echo "<hr>";
	//exit;
	
	
	$client_rates = array();
	if($rates){
		$data = array(
			'start_date' => $rates[0]['start_date']['from'],
			'rate' => $rates[0]['from'],
			'work_status' => $rates[0]['work_status'][0]['from'],
		);
		$client_rates[] = $data;
		
		$data = array(
			'start_date' => $rates[0]['start_date']['to'],
			'rate' => $rates[0]['to'],
			'work_status' => $rates[0]['work_status'][0]['to'],
		);
		$client_rates[] = $data;
		
		for($i=1; $i<count($rates); $i++){
			$data = array(
				'start_date' => $rates[$i]['start_date']['to'],
				'rate' => $rates[$i]['to'],
				'work_status' => $rates[$i]['work_status'][0]['to'],
			);
			$client_rates[] = $data;
		}
	}
	//echo "<pre>";
	//print_r($client_rates);
	//echo "</pre>";
	
	//exit;
	if(!$client_rates){
		//echo "No changes yet in staff monthly salary";
		$data=array(
			'start_date' => $starting_date,
			'rate' => $subcon['client_price'],
			'work_status' => $subcon['work_status']
		);   
		$client_rates[] = $data;
		
	}
	//echo "<pre>";
	//print_r($client_rates);
	//echo "</pre>";
    return $client_rates;
}




function GetClientPriceEffectiveDate($id, $first, $subcon_id){
	global $db;
	
		
	$findme = "effective date of the new client price";
    //$sql ="SELECT * FROM subcontractors_history s where changes like '%".$findme."%' and id=$id;";
	
    $sql ="SELECT * FROM subcontractors_history s where id=".$id;	
	//$sql ="SELECT * FROM subcontractors_history s where changes_status IN ('approved') AND ( changes LIKE '%".$findme."%' ) and subcontractors_id =".$id." order by id asc limit 1;";
	$history = $db->fetchRow($sql);
	
	$sql = $db->select()
		->from('subcontractors', 'starting_date')
		->where('id=?', $history['subcontractors_id']);
	$starting_date = $db->fetchOne($sql);
		
	if($history){
		$str_array = explode("<br>", $history['changes']);
		foreach($str_array as $str){		
			$pos = stripos($str, $findme);
			if ($pos !== false) {
				//echo $str."<br>";
				$strs = explode("from", $str);
				$str = trim($strs[1]);
				$strs = explode("to", $str);
				$from = trim($strs[0]);
				$to = trim($strs[1]);
				if(!$from){
					$from = $starting_date;
				}
				if(!to){
					$to = $history['date_change'];
				}
				
				$data=array('from' => $from, 'to' => $to);
			}else{
				if($first){
					$data=array('from' => $starting_date, 'to' => $history['date_change']);
				}else{
					$data=array('from' => $history['date_change'], 'to' => $history['date_change']);
				}
			}
			
		}
		return $data;
	}
	
	
	
}
?>