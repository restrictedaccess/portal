<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;




$from = $_REQUEST['from'];
if(!$from){
	$from = date("Y-m-d");
}

if(!$to){
	$to = $from;
}

$date = new DateTime($from." ".date('H:i:s'));
$from = $date->format("Y-m-d");
$start_date_str = $date->format("Y-m-d");
$current_time_unix = $date->format('U');
$weekday_str = strtolower($date->format('D'))."_start";
$dayname = strtolower($date->format('D'));
//echo $dayname." ".$date->format('h:i a');
$date->modify("+1 day");
$date_end_str = $date->format("Y-m-d");

if($_REQUEST['csro']){
    $conditions .= " AND l.csro_id = '".$_REQUEST['csro']. "' ";
	$smarty->assign('csro', $_REQUEST['csro']);
}

if($_REQUEST['userid']){
    $conditions .= " AND p.userid = '".$_REQUEST['userid']. "' ";
	$smarty->assign('userid', $_REQUEST['userid']);
}

if($_REQUEST['leads_id']){
    $conditions .= " AND s.leads_id = '".$_REQUEST['leads_id']. "' ";
	$smarty->assign('leads_id', $_REQUEST['leads_id']);
}

if($_REQUEST['start_time']){
	$date = new DateTime($from." ".$_REQUEST['start_time']);
	$conditions .= " AND ".$weekday_str." BETWEEN '".$date->format('H:i:s'). "' AND  '".$date->format('H:59:59')."' ";
	$smarty->assign('start_time',$_REQUEST['start_time']);
}



//echo $start_date_str." ".$date_end_str;exit;


$sql="SELECT s.id, s.userid, s.leads_id, s.client_timezone, s.staff_working_timezone, s.client_start_work_hour, s.client_finish_work_hour, s.overtime, s.overtime_monthly_limit, p.fname, p.lname, p.email, l.fname AS client_fname, l.lname AS client_lname, l.email AS client_email, s.work_days, flexi, mon_start, tue_start, wed_start, thu_start, fri_start, sat_start, sun_start FROM subcontractors AS s INNER JOIN personal AS p ON p.userid = s.userid INNER JOIN leads AS l ON l.id = s.leads_id WHERE (s.status ='ACTIVE' $conditions ) ORDER BY fname ASC ";
//echo $sql;	
$staffs = $db->fetchAll($sql);
//echo "<pre>";
//print_r($staffs);
//echo "</pre>";
//exit;

$staff_list= array();

foreach($staffs as $staff){
	$start_regular_working_hours="";
	$finish_regular_working_hours="";
	$work_days = explode(',',$staff['work_days']);
	
    $date = new DateTime($from.' '.$staff[$weekday_str]);
	
	$expected_login_time = $date->format('Y-m-d H:i:s');
	$expected_login_time_str = $date->format('h:i a');
	$expected_login_time_unix = $date->format('U');
	
	$sql = $db->select()
		->from('activity_tracker', 'status')
		->where('userid =?' ,$staff['userid']);
	$working_status = $db->fetchOne($sql);
	
	//5mins before staff working hours 
	$five_min_start_work_hour_unix = get_five_minutes_before_time($expected_login_time);
	
	//10mins before staff working hours
	$ten_mins_start_work_hour_unix = get_ten_minutes_before_time($expected_login_time);
	
	//5mins after staff working hours
	$after_five_min_start_work_hour_unix = get_five_minutes_after_time($expected_login_time);
	
	//2hours after staff time
	$two_hours_after_start_time = get_two_hours_after_time($expected_login_time);
	
	//timerecord
	$sql = "SELECT time_in FROM timerecord WHERE mode='regular' AND userid = ".$staff['userid']." AND leads_id = ".$staff['leads_id']." AND subcontractors_id = ".$staff['id']."  AND time_in BETWEEN '".$start_date_str." 00:00:00' AND '".$date_end_str." 23:59:59' ORDER BY time_in ASC LIMIT 1;";
	$time_in = $db->fetchOne($sql);
	if($time_in){
		$time_in_str = date('h:i a',strtotime($time_in));
		$time_in = date('Y-m-d h:i a',strtotime($time_in));
		$regular_time_in_unix = date('U',strtotime($time_in));
	}
	if($staff['flexi'] == "no"){
		if (in_array(strtolower($dayname), $work_days) == true) {
			//staff should be working in this day
			if($time_in){ //staff already login
			    
				//check if late
				if($regular_time_in_unix > $after_five_min_start_work_hour_unix){
					$compliance = "late";
				}else{
					$compliance = "on time";
				}
				
			}else{
				//staff not yet login
				if($current_time_unix < $two_hours_after_start_time){
					if($expected_login_time_unix < $current_time_unix ){
						$compliance = 'running late';
					}else{
						if($current_time_unix >= $ten_mins_start_work_hour_unix and $current_time_unix <= $expected_login_time_unix){
							$compliance = '10 minutes';
						}else{
							$compliance = 'not yet working';
						}	
					}
				}else{
					$compliance = 'absent';
				}
				
			}
		}else{
			//extra day
			if($time_in){
			    $compliance = 'extra day';
		    }
		}
	}else{
		if($time_in){
		    $compliance = 'flexi';
		}else{
			//$compliance = 'not yet working';
		}
	}
	
	$data = array(
		'id' => $staff['id'],		  
		'staff_name' => $staff['fname']." ".$staff['lname'],
		'client_name' => $staff['client_fname']." ".$staff['client_lname'],
		'expected_login_time' => 'ETA : '.$expected_login_time_str,
		'time_in' => $time_in_str,
		'working_status' => $working_status,
		'flexi' => $staff['flexi'],
		'five_min_start_work_hour_unix' => $five_min_start_work_hour_unix,
		'after_five_min_start_work_hour_unix' => $after_five_min_start_work_hour_unix,
		'two_hours_after_start_time' => $two_hours_after_start_time,
		'ten_mins_start_work_hour_unix' => $ten_mins_start_work_hour_unix,
		'compliance' => $compliance
	);
	
	if (in_array(strtolower($dayname), $work_days) == false) {
	    unset($data['expected_login_time']);
		$data['expected_login_time'] = "No Schedule";
	}
	if($staff['flexi'] == "yes"){
		unset($data['expected_login_time']);
		$data['expected_login_time'] = "Flexi Schedule";
	}
    
	
	array_push($staff_list, $data); 
    $compliance="";
	$time_in = "";
    $time_in_str="";
	$working_status = "";
				
}	
function get_five_minutes_after_time($date_str){
	$new_date =  date('Y-m-d H:i:s', strtotime("+5 minutes",strtotime($date_str)));
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
function get_ten_minutes_before_time($date_str){
	
	$new_date =  date('Y-m-d H:i:s', strtotime("-10 minutes",strtotime($date_str)));
	$unix = date('U',strtotime($new_date));
	//$unix = date('h:i a',strtotime($new_date));
	return $unix;
}

function get_two_hours_after_time($date_str){
	
	$new_date =  date('Y-m-d H:i:s', strtotime("+2 hours",strtotime($date_str)));
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
		if($_REQUEST['csro'] == $member['admin_id']){
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

$TIME = array("06:00:00","07:00:00","08:00:00","09:00:00","10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00","18:00:00","19:00:00","20:00:00","21:00:00","22:00:00","23:00:00","00:00:00","01:00:00","02:00:00","03:00:00","04:00:00","05:00:00");

$TIMESTR = array("6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am");


$smarty->assign('active_clients', $active_clients);
$smarty->assign('active_staffs', $active_staffs);
$smarty->assign('team_Options', $team_Options );
$smarty->assign('from',$from);
$smarty->assign('to',$to);
$smarty->assign('TIME',$TIME);
$smarty->assign('TIMESTR',$TIMESTR);
$smarty->assign('staff_list',$staff_list);
$smarty->display('RunningLate2.tpl');
?>