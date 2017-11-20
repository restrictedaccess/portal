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
	
	if($staff['staff_currency_id']){
	    $sql = $db->select()
	        ->from('currency_lookup', 'code')
	        ->where('id=?', $staff['staff_currency_id']);
	    $code = $db->fetchOne($sql);
		$staff['code'] = $code;
	}
	
	$team_name = "";
    $csro_name = "";	
	if($staff['csro_id']){
	    $sql = "SELECT admin_fname, admin_lname FROM admin WHERE admin_id =".$staff['csro_id'];
		$csro = $db->fetchRow($sql);
		$csro_name = sprintf('%s %s', $csro['admin_fname'], $csro['admin_lname']);		
		$staff['csro_name'] = $csro_name;
		
		
	}
	
	if($staff['leads_id'] == '11' and $admin['view_inhouse_confidential'] == 'N'){
		$staff['staff_salary']='****';
		$staff['client_rate']='****';
	}else{
		$staff['staff_salary']=sprintf('%s %s', $code, $staff['php_monthly']);
		$staff['client_rate']=sprintf('%s %s', $staff['currency'], $staff['client_price']);
	}
	
	$compare_date = create_dateDiff($comparing_date ,$starting_date_str);
	$staff['duration'] = dateDiff($comparing_date,$starting_date_str);
	$staff['staff_contract_finish_date'] = $staff_contract_finish_date;
    $staff['total_log_hour'] = $response->total_log_hours->$staff['id'];
	
	$staff['adj_hours'] = $response->result->$staff['id'];
	
	
	$staff['starting_date_str'] = $starting_date_str;
	
	array_push($staffs,$staff);	

}

function GetTotalLogHours($userid, $sid, $lead_id, $from, $to){
	global $couch_dsn;
	
	$userid = ((int)$userid);  //must be an integer
	$staff = new couchClient($couch_dsn, 'rssc_time_records');
	$staff->startkey(Array($userid, Array(((int)date("Y", strtotime($from))),((int)date("m", strtotime($from))),((int)date("d", strtotime($from))),0,0,0,0)));
	$staff->endkey(Array($userid, Array(((int)date("Y", strtotime($to))),((int)date("m", strtotime($to))),((int)date("d", strtotime($to))),23,59,59,0)));
	
	$r = $staff->getView('rssc_reports', 'userid_timein');
	$regular_hours_work =0;
	$work_hrs=0;
	foreach($r->rows as $row){
		//print_r($row->value);
		list($mode, $time_out, $leads_id, $subcon_id) = $row->value;
		list($userid, $time_in) = $row->key;
		
		if($subcon_id == $sid && $lead_id == $leads_id){
			if($mode == 'time record'){
				//print_r($time_out);
				$time_in_str = sprintf('%s-%s-%s %s:%s:%s', $time_in[0], $time_in[1], $time_in[2], $time_in[3], $time_in[4], $time_in[5]);
				$time_in = date("Y-m-d H:i:s", strtotime($time_in_str));
				$time_in_unix = date('U',strtotime($time_in_str));
				
				
				$time_out_str = sprintf('%s-%s-%s %s:%s:%s', $time_out[0], $time_out[1], $time_out[2], $time_out[3], $time_out[4], $time_out[5]);
				$time_out = date("Y-m-d H:i:s", strtotime($time_out_str));
				$time_out_unix = date('U', strtotime($time_out_str));
				
				$work_hrs = $time_out_unix - $time_in_unix;
				$work_hrs = $work_hrs / 3600.0;
				$regular_hours_work = $regular_hours_work + $work_hrs;
				//echo sprintf('%s %s %s %s<br>' , $userid, $mode, $work_hrs, $regular_hours_work);
			}
		}
		
	}
	return ceil($regular_hours_work * 100)/100;

}
?>
