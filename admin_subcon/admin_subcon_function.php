<?php
include '../conf/zend_smarty_conf.php';

function check_if_two_months_inactive($latest_end_date){
	date_default_timezone_set('Asia/Manila');  // you are required to set a timezone

	$date1 = new DateTime(sprintf('%s-%s-%s', date('Y'), date('m'), date('d')));
	$date2 = new DateTime($latest_end_date);
	
	$diff = $date1->diff($date2);
	//print_r($diff);
	return (($diff->format('%y') * 12) + $diff->format('%m')); // returns number of months
}

function filterInhouseConfidentialInfo($history_changes , $leads_id, $view_inhouse_confidential){
	//return string
	$changes = explode('<br>', $history_changes);
	$str = "";
	foreach($changes as $change){
		if($change != ""){
			if(stristr($change, 'salary')) {
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
							$word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str .= $display_string."<br>";
			}else if(stristr($change, 'php_monthly')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str .= $display_string."<br>";
			}else if(stristr($change, 'php_hourly')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str .= $display_string."<br>";
			}else{
				$str .= $change."<br>";
			}
		}
	}
	return $str;
	
}
function save_client_price($mode, $subcontractors_id, $current_rate){

    $AusTime = date("H:i:s"); 
    $AusDate = date("Y")."-".date("m")."-".date("d");
    $ATZ = $AusDate." ".$AusTime;
	
    global $db;
	
	$sql = $db->select()
	    ->from('subcontractors')
		->where('id =?', $subcontractors_id);
	$subcon = $db->fetchRow($sql);	
	
	if($mode == 'new'){
	    //subcontractors_client_rate
	    $data = array(
	        'subcontractors_id' => $subcontractors_id, 
		    'start_date' => $subcon['starting_date'], 
		    'rate' => $subcon['client_price'],
			'work_status' => $subcon['work_status']
	    );
		$db->insert('subcontractors_client_rate', $data);
		/*
		$data = array(
	            'subcontractors_id' => $subcontractors_id, 
		        'start_date' => $subcon['client_price_effective_date'], 
		        'rate' => $subcon['client_price']
	        );
		$db->insert('subcontractors_client_rate', $data);
		*/
	}else{
	    //check if existing already in subcontractors_client_rate
		$sql = "SELECT COUNT(id)AS num_count FROM subcontractors_client_rate WHERE subcontractors_id = ".$subcontractors_id;
		$num_count = $db->fetchOne($sql);
		
		
		if($num_count == 0){
			$data = array(
	            'subcontractors_id' => $subcontractors_id, 
		        'start_date' => $current_rate['starting_date'], 
		        'rate' => $current_rate['client_price'],
				'work_status' => $current_rate['work_status']
	        );
		    $db->insert('subcontractors_client_rate', $data);
		
		}
		//echo "<pre>";
        //print_r($data);
        //echo "</pre>";
		
		$data=array('end_date' => $subcon['client_price_effective_date'], 'work_status' => $current_rate['work_status']);
		$where = "subcontractors_id = ".$subcontractors_id." AND end_date IS NULL";	
        $db->update('subcontractors_client_rate', $data , $where);
		
			
		$data = array(
	            'subcontractors_id' => $subcontractors_id, 
		        'start_date' => $subcon['client_price_effective_date'], 
		        'rate' => $subcon['client_price'],
				'work_status' => $subcon['work_status']
	        );
		$db->insert('subcontractors_client_rate', $data);
		
	}	
}

function compareData($data , $table , $id){
	global $db;
	//PARSE DATA IN THE subcontractors  
$query = "SELECT  leads_id , agent_id ,userid , posting_id , client_price , payment_type, working_hours , working_days , php_monthly , php_hourly , work_status , work_days , starting_date, lunch_hour, current_rate, total_charge_out_rate , client_timezone, client_start_work_hour, client_finish_work_hour , currency , with_tax, with_bp_comm, with_aff_comm , mon_start , mon_finish, mon_number_hrs, mon_start_lunch  ,mon_finish_lunch , mon_lunch_number_hrs , tue_start , tue_finish, tue_number_hrs, tue_start_lunch  ,tue_finish_lunch , tue_lunch_number_hrs , wed_start , wed_finish, wed_number_hrs, wed_start_lunch  ,wed_finish_lunch , wed_lunch_number_hrs , thu_start , thu_finish, thu_number_hrs, thu_start_lunch  ,thu_finish_lunch , thu_lunch_number_hrs , fri_start , fri_finish, fri_number_hrs, fri_start_lunch  ,fri_finish_lunch , fri_lunch_number_hrs , sat_start , sat_finish, sat_number_hrs, sat_start_lunch  ,sat_finish_lunch , sat_lunch_number_hrs , sun_start , sun_finish, sun_number_hrs, sun_start_lunch  ,sun_finish_lunch , sun_lunch_number_hrs , job_designation , staff_currency_id , staff_working_timezone , flexi, overtime, overtime_monthly_limit, client_price_effective_date, prepaid_start_date, staff_other_client_email , staff_other_client_email_password, reason, reason_type, replacement_request, status, service_type, prepaid FROM  $table s WHERE id = $id;";
$result = $db->fetchRow($query);

	$difference = array_diff_assoc($data,$result);
	if($difference > 0){
		foreach(array_keys($difference) as $array_key){
			$history_changes .= sprintf("%s from %s to %s <br>", getFullColumnName($array_key), $result[$array_key] , $difference[$array_key]);
		}
	}
	//return $table;
	return $history_changes;
	//echo $history_changes;exit;
	
}

function FieldValueDesc($field_name , $value){
	global $db;
	// column to be consider: lead_id, category_id
	
	if($field_name == 'lead_id'){
		$sql = $db->select()
			 ->from('leads')
			 ->where('id = ?', $value);
		$result = $db->fetchRow($sql);	 
		return "#".$result['id']." ".$result['fname']." ".$result['lname'];
	}else if($field_name == 'category_id'){
		$sql = $db->select()
			->from('job_category' , 'category_name')
			->where('category_id =?' , $value);
		$category_name = $db->fetchOne($sql);
		return 	$category_name;
	}else{
		return $value;
	}

}

function getFullColumnName($field){
	$field_name = array("leads_id" , "agent_id" ,"userid" , "posting_id" , "client_price" , "payment_type", "working_hours" , "working_days" , "php_monthly" ,"php_hourly" , "work_status" , "work_days" , "starting_date", "lunch_hour", "current_rate", "total_charge_out_rate" , "client_timezone", "client_start_work_hour", "client_finish_work_hour" , "currency" , "with_tax", "with_bp_comm", "with_aff_comm", "mon_start" , "mon_finish", "mon_number_hrs","mon_start_lunch","mon_finish_lunch" , "mon_lunch_number_hrs" , "tue_start" , "tue_finish", "tue_number_hrs", "tue_start_lunch" ,"tue_finish_lunch", "tue_lunch_number_hrs", "wed_start" , "wed_finish","wed_number_hrs" , "wed_start_lunch" ,"wed_finish_lunch" , "wed_lunch_number_hrs" , "thu_start" , "thu_finish", "thu_number_hrs", "thu_start_lunch" ,"thu_finish_lunch" ,"thu_lunch_number_hrs","fri_start","fri_finish","fri_number_hrs","fri_start_lunch" ,"fri_finish_lunch" , "fri_lunch_number_hrs" , "sat_start" , "sat_finish", "sat_number_hrs", "sat_start_lunch" ,"sat_finish_lunch" , "sat_lunch_number_hrs", "sun_start" , "sun_finish", "sun_number_hrs", "sun_start_lunch" ,"sun_finish_lunch" , "sun_lunch_number_hrs", "job_designation" , "staff_currency_id" , "staff_working_timezone", "flexi" , "overtime" , "overtime_monthly_limit", "client_price_effective_date", "prepaid_start_date", "staff_other_client_email", "staff_other_client_email_password", "reason", "reason_type", "replacement_request", "status", "service_type", "prepaid");
	
	$field_description = array("LEADS ID" , "AGENTS ID" ,"STAFF ID" , "ADS ID" , "CLIENT QUOTED PRICE" , "PAYMENT TYPE OPTION", "TOTAL WORKING HOURS PER WEEK" , "TOTAL WORKING DAYS PER WEEK" , "STAFF MONTHLY SALARY" ,"STAFF HOURLY SALARY" , "STAFF WORKING STATUS" , "WORKING DAYS" , "STAFF STARTING DATE", "TOTAL LUNCH HOURS", "CURRENT RATE", "CLIENT TOTAL CHARGE OUT RATE" , "CLIENT PREFFERED TIMEZONE", "CLIENT PREFFERED WORK START TIME", "CLIENT PREFFERED WORK FINISH TIME" , "CURRENCY" , "TAX INCLUDED", "BUSINESS PARTNER COMMISSION", "AFFILIATE COMMISSION", "STAFF MONDAY START WORKING TIME" , "STAFF MONDAY FINISH WORKING TIME", "STAFF MONDAY TOTAL WORKING HOURS","STAFF MONDAY START LUNCH TIME","STAFF MONDAY FINISH LUNCH TIME" , "STAFF MONDAY TOTAL LUNCH HOURS" , "STAFF TUESDAY START WORKING TIME" , "STAFF TUESDAY FINISH WORKING TIME", "STAFF TUESDAY TOTAL WORKING HOURS","STAFF TUESDAY START LUNCH TIME","STAFF TUESDAY FINISH LUNCH TIME" , "STAFF TUESDAY TOTAL LUNCH HOURS", "STAFF WEDNESDAY START WORKING TIME" , "STAFF WEDNESDAY FINISH WORKING TIME", "STAFF WEDNESDAY TOTAL WORKING HOURS","STAFF WEDNESDAY START LUNCH TIME","STAFF WEDNESDAY FINISH LUNCH TIME" , "STAFF THURSDAY TOTAL LUNCH HOURS", "STAFF THURSDAY START WORKING TIME" , "STAFF THURSDAY FINISH WORKING TIME", "STAFF THURSDAY TOTAL WORKING HOURS","STAFF THURSDAY START LUNCH TIME","STAFF THURSDAY FINISH LUNCH TIME" , "STAFF FRIDAY TOTAL LUNCH HOURS", "STAFF FRIDAY START WORKING TIME" , "STAFF FRIDAY FINISH WORKING TIME", "STAFF FRIDAY TOTAL WORKING HOURS","STAFF FRIDAY START LUNCH TIME","STAFF FRIDAY FINISH LUNCH TIME" , "STAFF FRIDAY TOTAL LUNCH HOURS", "STAFF SATURDAY START WORKING TIME" , "STAFF SATURDAY FINISH WORKING TIME", "STAFF SATURDAY TOTAL WORKING HOURS","STAFF SATURDAY START LUNCH TIME","STAFF SATURDAY FINISH LUNCH TIME" , "STAFF SATURDAY TOTAL LUNCH HOURS", "STAFF SUNDAY START WORKING TIME" , "STAFF SUNDAY FINISH WORKING TIME", "STAFF SUNDAY TOTAL WORKING HOURS","STAFF SUNDAY START LUNCH TIME","STAFF SUNDAY FINISH LUNCH TIME" , "STAFF SUNDAY TOTAL LUNCH HOURS" , "JOB DESIGNATION" , "STAFF SALARY CURRENCY" , "STAFF WORKING TIMEZONE" , "FLEXI SCHEDULE",  "APPROVE ALL OVER TIMES" , "OVER TIME MONTHLY LIMIT", "EFFECTIVE DATE OF THE NEW CLIENT PRICE", "PREPAID STAFF START DATE", "STAFF OTHER CLIENT EMAIL", "STAFF OTHER CLIENT EMAIL PASSWORD", "REASON", "REASON TYPE", "REPLACEMENT REQUEST", "CONTRACT STATUS", "SERVICE TYPE", "PREPAID");
	
	for($i=0;$i<count($field_name);$i++){
		if($field == $field_name[$i]){
			return $field_description[$i];
			break;
		}
	}
	
}

function compareStaffEmail($staff_email , $email , $userid){
	global $db;
	if($staff_email != $email){
		$data = array( 'email' => $email);
		$where = "userid = ".$userid;	
		$db->update('personal', $data , $where);
		$email_history_changes .= "<br>STAFF EMAIL from ".$staff_email. " to ".$email;
	} 
	return $email_history_changes;
}

function compareStaffRegisteredEmail($staff_email , $email , $userid){
	global $db;
	if($staff_email != $email){
		$data = array( 'registered_email' => $email);
		$where = "userid = ".$userid;	
		$db->update('personal', $data , $where);
		$email_history_changes .= "<br>PERSONAL EMAIL from ".$staff_email. " to ".$email;
	} 
	return $email_history_changes;
}

function compareStaffSkype($staff_skype , $skype , $userid){
	global $db;
	if($staff_skype != $skype){
		$data = array( 'skype_id' => $skype);
		$where = "userid = ".$userid;	
		$db->update('personal', $data , $where);
		$skype_history_changes .= "<br>STAFF SKYPE from ".$staff_skype. " to ".$skype;
	}
	return $skype_history_changes;
}


function compareStaffEmailPass($staff_email_password , $initial_email_password , $userid){
	global $db;
	if($staff_email_password != $initial_email_password){
		$data = array( 'initial_email_password' => $initial_email_password);
		$where = "userid = ".$userid;	
		$db->update('personal', $data , $where);
		$history_changes .= "<br>INITIAL EMAIL PASSWORD from ".$staff_email_password. " to ".$initial_email_password;
	}
	return $history_changes;
}

function compareStaffSkypePass($staff_skype_password , $initial_skype_password , $userid){
	global $db;
	if($staff_skype_password != $initial_skype_password){
		$data = array( 'initial_skype_password' => $initial_skype_password);
		$where = "userid = ".$userid;	
		$db->update('personal', $data , $where);
		$history_changes .= "<br>INITIAL SKYPE PASSWORD from ".$staff_skype_password. " to ".$initial_skype_password;
	}
	return $history_changes;
}

function configureTime($time){
	
	if($time != ""){
		$length = strlen($time);
		if($length == 2){
			$time = $time.":00";
		}
		return $time.":00";
	}else{
		return "00:00:00";
	}
}

function formatNum($num){
	//$sPattern = '/.00/';
	//$sReplace = '';
	//$num = preg_replace( $sPattern, $sReplace, $num );
	if($num!=""){
		$num = number_format($num ,2 ,'.' ,'');
	}else{
		$num = 0;
	}
	return $num;
}

?>