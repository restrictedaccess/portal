<?php
// Set timezone
  date_default_timezone_set("UTC");
 
// Time format is UNIX timestamp or
// PHP strtotime compatible strings
$AGE_CONTRACTS = array('Within 1 Week' , '2 Weeks Up', '1 Month Exact', '1 Month Plus', '2 Months Exact', '2 Months Plus', '3 Months Exact', '3 Months Plus', '4 Months Exact', '4 Months Up', '6 Months Exact', '6 Months Up', '1 Year Exact', '1 Year UP');

function RefferedBy($userid){
	global $db;
	
	$referral = $db->fetchRow($db->select()->from(array("r"=>"referrals"), array())->joinInner(array("p"=>"personal"), "p.userid = r.user_id", array("p.fname AS referee_fname", "p.lname AS referee_lname", "p.userid AS referee_userid"))->where("r.jobseeker_id = ?", $userid));
	
	$referred_by= ""; 
    if ($referral){
        $referred_by = $referral["referee_fname"]." ".$referral["referee_lname"];
    }
	return $referred_by;
}

function NumOfDays($time1, $time2, $precision = 6) {
	// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2 = strtotime($time2);
	}
	
	// If time1 is bigger than time2
	// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}
	
	// Set up intervals and diffs arrays
	$intervals = array('day');
	$diffs = array();
	
	// Loop thru all intervals
	foreach ($intervals as $interval) {
		// Set default diff to 0
		$diffs[$interval] = 0;
		// Create temp time from time1 and interval
		$ttime = strtotime("+1 " . $interval, $time1);
		// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
			$time1 = $ttime;
			$diffs[$interval]++;
			// Create new temp time from time1 and interval
			$ttime = strtotime("+1 " . $interval, $time1);
		}
	}
	
	$count = 0;
	$times = array();
	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
		// Break if we have needed precission
		if ($count >= $precision) {
			break;
		}
		// Add value and interval 
		// if value is bigger than 0
		if ($value > 0) {
			// Add s if value is not 1
			if ($value != 1) {
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}
	
	// Return string with times
	//return $times;
	return implode(", ", $times);
}


function create_date_difference($id, $date_compare){
    $condition="";
	if($id == 0){
	    $condition = " AND DATEDIFF('$date_compare', starting_date)<=7 ";
	}
	
	if($id == 1){
	    //2 weeks (2 weeks from start date of contract =>8 days to 14 days 
	    $condition = " AND DATEDIFF('$date_compare', starting_date) >=8 AND DATEDIFF('$date_compare', starting_date) < DAY(LAST_DAY(starting_date)) ";
	}
	
	if($id == 2){
	    //1 Month (1 month from start date of contract) 
	    $condition = " AND (PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '$date_compare'), EXTRACT(YEAR_MONTH FROM starting_date))) =1 AND DATEDIFF('$date_compare', starting_date)= DAY(LAST_DAY(starting_date)) ";
	}
	
	if($id == 3){
	    //1.5 Month (1 months and 2 weeks from start date of contract) 1 month onwards.
	    $condition = " AND (PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '$date_compare'), EXTRACT(YEAR_MONTH FROM starting_date))) =1 ";
	}
	return $condition;
}

function create_dateDiff($time1, $time2, $precision = 3) {
	// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2 = strtotime($time2);
	}
	
	// If time1 is bigger than time2
	// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}
	
	// Set up intervals and diffs arrays
	$intervals = array('year','month','day');
	$diffs = array();
	
	// Loop thru all intervals
	foreach ($intervals as $interval) {
		// Set default diff to 0
		$diffs[$interval] = 0;
		// Create temp time from time1 and interval
		$ttime = strtotime("+1 " . $interval, $time1);
		// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
			$time1 = $ttime;
			$diffs[$interval]++;
			// Create new temp time from time1 and interval
			$ttime = strtotime("+1 " . $interval, $time1);
		}
	}
	return $diffs;
	/*
	$count = 0;
	$times = array();
	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
		// Break if we have needed precission
		if ($count >= $precision) {
			break;
		}
		// Add value and interval 
		// if value is bigger than 0
		if ($value > 0) {
			// Add s if value is not 1
			if ($value != 1) {
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}
	
	// Return string with times
	return $times;
	//return implode(", ", $times);
	*/
}


function dateDiff($time1, $time2, $precision = 6) {
	// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2 = strtotime($time2);
	}
	
	// If time1 is bigger than time2
	// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}
	
	// Set up intervals and diffs arrays
	$intervals = array('year','month','day','hour','minute','second');
	$diffs = array();
	
	// Loop thru all intervals
	foreach ($intervals as $interval) {
		// Set default diff to 0
		$diffs[$interval] = 0;
		// Create temp time from time1 and interval
		$ttime = strtotime("+1 " . $interval, $time1);
		// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
			$time1 = $ttime;
			$diffs[$interval]++;
			// Create new temp time from time1 and interval
			$ttime = strtotime("+1 " . $interval, $time1);
		}
	}
	
	$count = 0;
	$times = array();
	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
		// Break if we have needed precission
		if ($count >= $precision) {
			break;
		}
		// Add value and interval 
		// if value is bigger than 0
		if ($value > 0) {
			// Add s if value is not 1
			if ($value != 1) {
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}
	
	// Return string with times
	//return $times;
	return implode(", ", $times);
}
	
function setConvertTimezones($original_timezone, $converted_timezone , $start_time, $finish_time){
	if($original_timezone!=""){
	$converted_timezone = new DateTimeZone("$converted_timezone");
	$original_timezone = new DateTimeZone($original_timezone);
	
	$start_time_str = $start_time;
	if ($start_time_str == null) {
	$start_time_hour = "";
	}
	else {
	//INFO: Due to the client_start_work_hour field type, I had to append a :00
	$time = new DateTime($start_time_str, $original_timezone);
	$time->setTimeZone($converted_timezone);
	$start_hour = $time->format('h:i a');
	}
	
	$finish_time_str = $finish_time;
	if ($finish_time_str == null) {
	$finish_time_hour = "";
	}
	else {
	//INFO: Due to the client_start_work_hour field type, I had to append a :00
	$time = new DateTime($finish_time_str, $original_timezone);
	$time->setTimeZone($converted_timezone);
	$finish_hour = $time->format('h:i a');
	}
	return $start_hour."-".$finish_hour;
	}else{
	return "00:00 - 00:00";
	}
}

function ConvertTime($original_timezone, $converted_timezone , $start_time){
    if($original_timezone!="" and $converted_timezone!=""){
        $converted_timezone = new DateTimeZone("$converted_timezone");
        $original_timezone = new DateTimeZone($original_timezone);
         
        $start_time_str = $start_time;
        if ($start_time_str == null) {
            $start_time_hour = "";
        }
        else {
            //INFO: Due to the client_start_work_hour field type, I had to append a :00
            $time = new DateTime($start_time_str, $original_timezone);
            $time->setTimeZone($converted_timezone);
            $start_hour = $time->format('h:i a');
        }
    
        
        return $start_hour;
    }else{
        return "00:00 - 00:00";
    }
}

?>