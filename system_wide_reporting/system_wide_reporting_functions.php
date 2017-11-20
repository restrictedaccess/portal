<?php

function GetTimesheetId($start_date_search, $subcon_id){
	global $db;
	$year_str = date("Y", strtotime($start_date_search));
	$month_str = date("m", strtotime($start_date_search));
	$sql = "SELECT id FROM timesheet t WHERE t.subcontractors_id=".$subcon_id." AND YEAR(month_year)='".$year_str."' AND MONTH(month_year)='".$month_str."' AND t.status IN('open', 'loceked') ;";
	//echo $sql;
	$timesheet_id = $db->fetchOne($sql);	
	return $timesheet_id;
}

function GetTimsheetDetailsAdjustedHours($timesheet_id, $start_date_search){
	global $db;
	$timesheet_day = date("d", strtotime($start_date_search));
	if($timesheet_id){
		$sql = "SELECT adj_hrs FROM timesheet_details t where timesheet_id=".$timesheet_id." and day=".$timesheet_day.";";
		$adj_hrs = $db->fetchOne($sql);
	}else{
		$adj_hrs=0;
	}
	return $adj_hrs;
}
function setConvertTimezones($original_timezone, $converted_timezone , $time){
	//return $time;
	
	if(!$original_timezone){
		return "No timezone detected.";
	}else if(!$time){
		return "No time detected.";
	}else{
		$converted_timezone = new DateTimeZone("$converted_timezone");
		$original_timezone = new DateTimeZone($original_timezone);
		$time_str = $time;
		if ($time_str == null) {
			$time_hour = "";
		}
		else {
			$time = new DateTime($time_str, $original_timezone);
			$time->setTimeZone($converted_timezone);
			$time_hour = $time->format('h:i a');
			//$time_hour = $time->format('H:i');
		}
		return $time_hour;
	}
    
}

function convert($tz_ref, $tz_dest, $ref_date) {
	
		date_default_timezone_set($tz_ref);
		$date = new Zend_Date($ref_date." 00:00:00", 'YYYY-MM-dd HH:mm:ss');
		if($tz_dest){
			$dest_date = clone $date;
			$dest_date->setTimezone($tz_dest);
			return $dest_date->toString('yyyy-MM-dd hh:mm a');
		}
		/*
		$data = array(
			'ref_date_time' => $date->toString('yyyy-MM-dd hh:mm a'),
			'ref_time_zone' => $date->toString('zzzz'),
			'ref_dst' => $date->toString('I'),
			'dest_date_time' => $dest_date->toString('yyyy-MM-dd hh:mm a'),
			'dest_time_zone' => $dest_date->toString('zzzz'),
			'dest_dst' => $dest_date->toString('I'),
		);
		return $data;
		*/
		
}

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

function get_two_hours_after_time($date_str){
	
	$new_date =  date('Y-m-d H:i:s', strtotime("+2 hours",strtotime($date_str)));
	$unix = date('U',strtotime($new_date));
	//$unix = date('h:i a',strtotime($new_date));
	return $unix;
}

function get_ten_minutes_before_time($date_str){
	
	$new_date =  date('Y-m-d H:i:s', strtotime("-10 minutes",strtotime($date_str)));
	$unix = date('U',strtotime($new_date));
	//$unix = date('h:i a',strtotime($new_date));
	return $unix;
}

function get_five_minutes_after_time($date_str){
	$new_date =  date('Y-m-d H:i:s', strtotime("+6 minutes",strtotime($date_str)));
	$unix = date('U',strtotime($new_date));
	//$unix = date('h:i a',strtotime($new_date));
	return $unix;
}
function get_five_minutes_before_time($date_str){
	
	$new_date =  date('Y-m-d H:i:s', strtotime("-5 minutes",strtotime($date_str)));
	$unix = date('U',strtotime($new_date));
	//$unix = date('h:i a',strtotime($new_date));
	return $unix;
}


function GetComplianceStr($time_in, $work_days, $staff){
	    global $db;
		//default timezone is Asia/Manila
        date_default_timezone_set("Asia/Manila");
	
		$current_time_unix = date('U', strtotime(date("Y-m-d H:i:s")));
		$date_end_str = date("Y-m-d", strtotime("+1 day", strtotime($time_in)));
		$timerecord_time_in = false;
		$sql="SELECT time_in FROM timerecord WHERE userid = ".$staff['userid']." AND leads_id = ".$staff['leads_id']." AND subcontractors_id = ".$staff['id']." AND mode='regular' AND time_in BETWEEN '".$time_in."' AND '".$date_end_str."' GROUP BY DATE(time_in) ORDER BY time_in ASC, mode DESC LIMIT 1;";
		$timerecord_time_in = $db->fetchOne($sql);
	
	    if($timerecord_time_in){
		    // Staff logged in in this date.
			$dayname = date('D',strtotime($timerecord_time_in));
			$time_in = date('h:i a',strtotime($timerecord_time_in));
			$regular_time_in_unix =date('U',strtotime($timerecord_time_in));
			$start_date_search_str = date('Y-m-d',strtotime($timerecord_time_in));;
			
			$weekday_str = strtolower($dayname)."_start";
			$staff_start_work_hour = $staff[$weekday_str];
					
			$date = new DateTime($start_date_search_str.' '.$staff_start_work_hour);
			$staff_working_hour = $date->format('h:i a');
			
			$compliance="";
			
			//5mins before staff working hours 
			$five_min_start_work_hour_unix = get_five_minutes_before_time($date->format('Y-m-d H:i:s'));
			
			//5mins after staff working hours
			$after_five_min_start_work_hour_unix = get_five_minutes_after_time($date->format('Y-m-d H:i:s'));
			
			//compliance
			
			if (in_array(strtolower($dayname), $work_days) == false) { //staff worked extra days
				//check if flexi
				if($staff['flexi'] != "yes"){ 
					$compliance = "extra day";
				}else{
					$compliance = "flexi";
				}
			}
			
			if (in_array(strtolower($dayname), $work_days) == true) { //worked in staff contract days
				if($staff['flexi'] != "yes"){
					if($regular_time_in_unix < $five_min_start_work_hour_unix){
						$compliance = "early Login";
					}
					
					if($regular_time_in_unix > $after_five_min_start_work_hour_unix){
						$compliance = "late";
					}
					
					if($regular_time_in_unix >= $five_min_start_work_hour_unix and $regular_time_in_unix <= $after_five_min_start_work_hour_unix){
						$compliance = "present";
					}
					
				}else{
					$compliance = "flexi";
				}
			}
		}else{
			//No log in time yet
			//Check the date
			$dayname = date('D',strtotime($time_in));
			$start_date_search_str = date('Y-m-d',strtotime($time_in));
			
			
			
			//staff contract working days
			if (in_array(strtolower($dayname), $work_days) == true) {
				
				$weekday_str = strtolower($dayname)."_start";
			    $staff_start_work_hour = $staff[$weekday_str];
				$expected_login_time = $time_in." ".$staff_start_work_hour;
				
				//echo $expected_login_time;
			    //2hours after staff time
	            $two_hours_after_start_time = get_two_hours_after_time($expected_login_time);
			
			
			    //check the staff if it is on leave or absent
				$num_of_leave = 0;
	            $sql="SELECT COUNT(l.id)AS num_of_leave FROM leave_request_dates l JOIN leave_request r ON r.id = l.leave_request_id WHERE l.date_of_leave='".$start_date_search_str."' AND l.status='approved' AND r.userid=".$staff['userid']." and r.leads_id=".$staff['leads_id'].";";
	            $num_of_leave = $db->fetchOne($sql);
	            if($num_of_leave > 0){
				    $compliance = 'on leave';
				}else{
					//Check the work start time of the staff
					//echo "Unix time ".$current_time_unix." ".$two_hours_after_start_time;	
					if($current_time_unix < $two_hours_after_start_time){
						$compliance = "not yet working";
						//echo "current_time_unix [ ".$current_time_unix."] is less than two_hours_after_start_time [ ".$two_hours_after_start_time." ]";
					}else{
						$compliance = "absent";
					}
				}
			}else{
				if($staff['flexi'] == 'yes'){
					 //check the staff if it is on leave or absent
				     $num_of_leave = 0;
	                 $sql="SELECT COUNT(l.id)AS num_of_leave FROM leave_request_dates l JOIN leave_request r ON r.id = l.leave_request_id WHERE l.date_of_leave='".$start_date_search_str."' AND l.status='approved' AND r.userid=".$staff['userid']." and r.leads_id=".$staff['leads_id'].";";
	                $num_of_leave = $db->fetchOne($sql);
	                if($num_of_leave == 0){
				        $compliance = 'flexi';
				    }else{
					    $compliance = 'on leave';
				    }
				}else{
					$compliance = "no schedule";
				}
			}
		}
		return $compliance;
}
?>