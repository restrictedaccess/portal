<?php
foreach($filter_staffs as $staff){
    //echo "<pre>";
    //echo $staff['userid']."<br>";
    $det = new DateTime($staff['starting_date']);
	$starting_date = $det->format("F j, Y");
	$starting_date_str = $det->format("Y-m-d");
	$staff_starting_date_last_date = $det->format("t");
	//echo $starting_date_str."<br>";
	if($staff['contract_status'] == 'resigned'){
		$date = new DateTime($staff['resignation_date']);
		$comparing_date = $date->format('Y-m-d');
		$staff_contract_finish_date = $date->format('F j, Y');
	}else if($staff['contract_status'] == 'terminated'){
		$date = new DateTime($staff['date_terminated']);
		$comparing_date = $date->format('Y-m-d');
		$staff_contract_finish_date = $date->format('F j, Y');
	}else{
	    $comparing_date = date('Y-m-d');
		$staff_contract_finish_date = "";
	}
	
	
	$compare_date = create_dateDiff($comparing_date ,$starting_date_str);
	//print_r($compare_date);
	//echo "<pre>";
	$staff['duration'] = dateDiff($comparing_date,$starting_date_str);
	$staff['staff_contract_finish_date'] = $staff_contract_finish_date;
    $staff['total_log_hour'] = GetTotalLogHours($staff['userid'], $staff['id'], $staff['leads_id'], $from, $to);
	array_push($staffs,$staff);	

}

function GetTotalLogHours($userid, $subcon_id, $leads_id, $from, $to){
	global $db;
	$start_date_str = sprintf('%s 00:00:00', $from);
	$date_end_str = sprintf('%s 23:59:59', $to);
	//return $start_date_str." ".$date_end_str;
	
	$hours_worked =0;
	$total_hrs = 0;
	$work_hrs=0;
	$lunch_hrs=0;
	$total_hours_worked =0;
	$regular_hours_work =0;
	$total_lunch_hours = 0;
	
	$sql = "SELECT time_in , time_out , mode FROM timerecord WHERE userid = ".$userid." AND leads_id = ".$leads_id." AND subcontractors_id = ".$subcon_id."  AND time_in BETWEEN '".$start_date_str."' AND '".$date_end_str."' ORDER BY time_in ASC,  mode DESC";
	$timerecords = $db->fetchAll($sql);
	$time_record = array();
	$dates =array();
	foreach($timerecords as $timerecord){
		
	    //timein
		//$date = new DateTime($timerecord['time_in']);
		//$time_in_str = $date->format('Y-m-d');
		//$time_in = $date->format('Y-m-d h:i a');
		//$time_in_unix = $date->format('U');
		$time_in_str = date('Y-m-d',strtotime($timerecord['time_in']));
		$time_in = date('Y-m-d h:i a',strtotime($timerecord['time_in']));
		$time_in_unix = date('U',strtotime($timerecord['time_in']));
		
		//time_out
		//$date = new DateTime($timerecord['time_out']);
		//$time_out = $date->format('Y-m-d h:i a');
		//$time_out_unix = $date->format('U');
		if($timerecord['time_out']){
		    $time_out = date('Y-m-d h:i a',strtotime($timerecord['time_out']));
		    $time_out_unix = date('U',strtotime($timerecord['time_out']));
		}else{
			$time_out = date('Y-m-d H:i:a');
		    $time_out_unix = date('U');
		}
		if($timerecord['mode'] == 'regular'){
			$work_hrs = $time_out_unix - $time_in_unix;
			$work_hrs = $work_hrs / 3600.0;
			$total_hrs = $work_hrs;
			$regular_hours_work = $regular_hours_work + $work_hrs;
			 
			//get the date per time_in
			if (array_key_exists($time_in_str, $dates) == false) {
				$dates[$time_in_str] = $timerecord['time_in'];
            }
			
		}else{
			$lunch_hrs = $time_out_unix - $time_in_unix;
			$lunch_hrs = $lunch_hrs / 3600.0;
			$total_hrs = $lunch_hrs;
			$total_lunch_hours = $total_lunch_hours + $lunch_hrs;
		}
		
		array_push($time_record, array(
				'time_in' => $time_in,
				'time_out' => $time_out,
				'mode' => $timerecord['mode'],
				'total_hrs' => $total_hrs,
			)
	    );
				
	}
	$hours_worked = ($work_hrs-$lunch_hrs);
	if($hours_worked){
		$total_hours_worked = ($regular_hours_work-$total_lunch_hours);
		//$data['total_hours_worked'] =$total_hours_worked;
	}
	return $total_hours_worked;
	
}

?>
