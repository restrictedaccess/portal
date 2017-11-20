<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = $_REQUEST['rowsPerPage'];
//echo $rowsPerPage;

if($rowsPerPage == ""){
	$rowsPerPage = 20;
}
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_REQUEST['page']))
{
	$pageNum = $_REQUEST['page'];
}
// counting the offset
//echo $pageNum ;

$offset = 0;
if($pageNum!=NULL){
	$offset = ($pageNum - 1) * $rowsPerPage;
	//$offset2 = ($pageNum - 1) * $rowsPerPage;
}

$limit = " LIMIT $offset, $rowsPerPage ";

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




$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$staff_list ="";
if(!$from){
	$from = date("Y-m-d");
}

if(!$to){
	$to = $from;
}

if($_POST['csro']){
    $conditions .= " AND l.csro_id = '".$_POST['csro']. "' ";
	$smarty->assign('csro', $_POST['csro']);
}

if($_POST['userid']){
    $conditions .= " AND p.userid = '".$_POST['userid']. "' ";
	$smarty->assign('userid', $_POST['userid']);
}

if($_POST['leads_id']){
    $conditions .= " AND s.leads_id = '".$_POST['leads_id']. "' ";
	$smarty->assign('leads_id', $_POST['leads_id']);
}


$date = new DateTime($from);
$from = $date->format("Y-m-d");
$start_date_str = $date->format("Y-m-d");
$dayname = strtolower($date->format("D"));
$weekday_str = $dayname."_start";


$date2 = new DateTime($to);
$date2->modify("+1 day");
$date_end_str = $date2->format("Y-m-d");

//echo $from." ".$to;//exit;

/*
$DATE_SEARCH=array();
$random_string_exists = True;
while ($random_string_exists) {
    if($start_date_str != $date_end_str){
	    $DATE_SEARCH[] = $date->format("Y-m-d");
		$date->modify("+1 day");
		$start_date_str = $date->format("Y-m-d");
		$random_string_exists = True;
	}else{
		$random_string_exists = False;
	}
}
*/
//echo "<pre>";
//print_r($DATE_SEARCH);
//echo "</pre>";
//exit;

$sql="SELECT s.id, s.userid, s.leads_id, s.client_timezone, s.staff_working_timezone, s.client_start_work_hour, s.client_finish_work_hour, s.overtime, s.overtime_monthly_limit, p.fname, p.lname, p.email, l.fname AS client_fname, l.lname AS client_lname, l.email AS client_email, s.work_days, flexi, mon_start, tue_start, wed_start, thu_start, fri_start, sat_start, sun_start,  mon_finish, tue_finish, wed_finish, thu_finish, fri_finish, sat_finish, sun_finish FROM subcontractors AS s INNER JOIN personal AS p ON p.userid = s.userid INNER JOIN leads AS l ON l.id = s.leads_id WHERE s.status IN ('ACTIVE', 'deleted') $conditions  ORDER BY p.fname ASC ";
echo $sql;	
$staffs = $db->fetchAll($sql);
echo "<pre>";
print_r($staffs);
echo "</pre>";
//exit;

$staff_list= array();

foreach($staffs as $staff){
	$start_regular_working_hours="";
	$finish_regular_working_hours="";
	$work_days = explode(',',$staff['work_days']);
	
	$day_start = strtolower($dayname)."_start";
	$day_finish = strtolower($dayname)."_finish";
	
	if($staff['staff_working_timezone'] != ""){
	    $start_regular_working_hours =  setConvertTimezones($staff['staff_working_timezone'], $staff['staff_working_timezone'] , $staff[$day_start]);
	    $finish_regular_working_hours =  setConvertTimezones($staff['staff_working_timezone'], $staff['staff_working_timezone'] , $staff[$day_finish]);
	}
	
	if (in_array(strtolower($dayname), $work_days) == true) {
	    $working_hours = sprintf('%s - %s %s', $start_regular_working_hours, $finish_regular_working_hours, $staff['staff_working_timezone']);
	}else{
		$working_hours = 'No Schedule';
	}
	$data = array(
		'id' => $staff['id'],		  
		'staff_name' => $staff['fname']." ".$staff['lname'],
		'client_name' => $staff['client_fname']." ".$staff['client_lname'],
		'working_hours' => $working_hours
	);
	
	
	if($staff['flexi'] == "yes"){
		unset($data['working_hours']);
		$data['working_hours'] = "Flexi Schedule";
		//$working_hours="Flexi Schedule";
	}
   
	
	//echo sprintf('subcon id =>%s<br>staff name=>%s<br>client name=>%s<br>working schedule=>%s<br>', $staff['id'], $staff['fname'], $staff['client_fname'], $working_hours);
    $hours_worked =0;
	$total_hrs = 0;
	$work_hrs=0;
	$lunch_hrs=0;
	$total_hours_worked =0;
	$regular_hours_work =0;
	$total_lunch_hours = 0;

	$sql = "SELECT time_in , time_out , mode FROM timerecord WHERE userid = ".$staff['userid']." AND leads_id = ".$staff['leads_id']." AND subcontractors_id = ".$staff['id']."  AND time_in BETWEEN '".$start_date_str."' AND '".$date_end_str."' ORDER BY time_in ASC,  mode DESC";
	echo $sql."<br>";
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
    $data['timerecords'] = $time_record;
	
	
	//$data['days_work'] = $dates;
	$logins = array();
	
	foreach(array_keys($dates) as $array_key){
		$timerecord_time_in = $dates[$array_key];
		
		$dayname = date('D',strtotime($timerecord_time_in));
		$time_in = date('h:i a',strtotime($timerecord_time_in));
		$regular_time_in_unix =date('U',strtotime($timerecord_time_in));
		$start_date_search_str = $array_key;
		
		$weekday_str = strtolower($dayname)."_start";
		$staff_start_work_hour = $staff[$weekday_str];
				
		$date = new DateTime($start_date_search_str.' '.$staff_start_work_hour);
		$staff_working_hour = $date->format('h:i a');
		
		
		//5mins before staff working hours 
		$five_min_start_work_hour_unix = get_five_minutes_before_time($date->format('Y-m-d H:i:s'));
		
		//5mins after staff working hours
		$after_five_min_start_work_hour_unix = get_five_minutes_after_time($date->format('Y-m-d H:i:s'));
		
		//compliance
		
		if (in_array(strtolower($dayname), $work_days) == false) { //staff worked extra days
		    //check if flexi
		    if($staff['flexi'] != "yes"){ 
		        $compliance = "Extra Day";
				$extra_day++;
		    }else{
		        $compliance = "Flexi";
				$flexi++;
		    }
		}
		
		if (in_array(strtolower($dayname), $work_days) == true) { //worked in staff contract days
		    if($staff['flexi'] != "yes"){
				if($regular_time_in_unix < $five_min_start_work_hour_unix){
					$compliance = "Early Login";
					$early_login++;
				}
				
				if($regular_time_in_unix > $after_five_min_start_work_hour_unix){
					$compliance = "Late";
					$late++;
				}
				
				if($regular_time_in_unix >= $five_min_start_work_hour_unix and $regular_time_in_unix <= $after_five_min_start_work_hour_unix){
					$compliance = "Present";
					$present++;
				}
				
			}else{
				$compliance = "Flexi";
				$flexi++;
			}
		}
				
		array_push($logins, array(
		    'time_in' => $timerecord_time_in,
			'expected_login_time' => $staff_working_hour,
			'compliance' => $compliance,
			'regular_time_in_unix' => $regular_time_in_unix,
			'five_min_start_work_hour_unix' => $five_min_start_work_hour_unix,
			'after_five_min_start_work_hour_unix' => $after_five_min_start_work_hour_unix,
			)
		);
		$compliance="";
	}
	
	$data['logins'] = $logins;
	
	$data['extra_day'] =$extra_day;
	$data['early_login'] = $early_login;
	$data['flexi_count'] = $flexi;
	$data['late'] = $late;
	$data['present'] = $present;
	$extra_day=0;
	$early_login =0;
	$flexi=0;
	$late=0;
	$present=0;
	if($hours_worked){
		$total_hours_worked = ($regular_hours_work-$total_lunch_hours);
		$data['total_hours_worked'] = ceil($total_hours_worked * 100)/100;
	}
	array_push($staff_list, $data); 
    $working_hours ="";
				
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
//echo "<pre>";
//print_r($staff_list);
//echo "</pre>";
//exit;
$sql = "SELECT * FROM recruitment_team r WHERE team_status='active';";
$teams = $db->fetchAll($sql);
foreach($teams as $team){
    $sql = "SELECT r.admin_id, a.admin_fname, a.admin_lname FROM recruitment_team_member r JOIN admin a ON a.admin_id = r.admin_id WHERE member_position='csro' AND team_id =".$team['id'];
	//echo $sql;
	$team_members = $db->fetchAll($sql);
	foreach($team_members as $member){
		if($_POST['csro'] == $member['admin_id']){
			$team_Options .="<option value='".$member['admin_id']."' selected='selected'>".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}else{
			$team_Options .="<option value='".$member['admin_id']."' >".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}
	}
	
}


//active staffs
$sql = "SELECT s.userid, p.fname, p.lname FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status = 'ACTIVE' GROUP BY s.userid ORDER BY p.fname;";
$active_staffs = $db->fetchAll($sql);

//active clients
$sql = "SELECT s.leads_id, l.fname, l.lname FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status = 'ACTIVE' GROUP BY s.leads_id ORDER BY l.fname;";
$active_clients = $db->fetchAll($sql);



$smarty->assign('active_clients', $active_clients);
$smarty->assign('active_staffs', $active_staffs);
$smarty->assign('team_Options', $team_Options );
$smarty->assign('from',$from);
$smarty->assign('to',$to);
$smarty->assign('staff_list',$staff_list);
$smarty->display('StaffAttendanceSheet2.tpl');
?>