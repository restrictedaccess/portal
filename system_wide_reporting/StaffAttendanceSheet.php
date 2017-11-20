<?php
include('../conf/zend_smarty_conf.php');
include 'system_wide_reporting_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Session expires. Please re-login.";
	exit;
}

$sql=$db_query_only->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db_query_only->fetchRow($sql);

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$staff_list ="";
if(!$from){
	$from = date("Y-m-d");
}

if(!$to){
	$to = $from;
}

$SEARCH_ALL = true;
$limit = "";





if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$SEARCH_ALL = true;
	
	$csro_conditions="";
	$smarty->assign('csro', NULL);
	$csro_id = "";
		
	if($_POST['csro']){
		$csro_conditions="";
		$conditions .= " AND l.csro_id = '".$_POST['csro']. "' ";
		$smarty->assign('csro', $_POST['csro']);
		$csro_id = $_POST['csro'];
		$SEARCH_ALL = false;
	}
	
	if($_POST['userid']){
		$conditions .= " AND p.userid = '".$_POST['userid']. "' ";
		$smarty->assign('userid', $_POST['userid']);
		$SEARCH_ALL = false;
	}
	
	if($_POST['leads_id']){
		$conditions .= " AND s.leads_id = '".$_POST['leads_id']. "' ";
		$smarty->assign('leads_id', $_POST['leads_id']);
		$SEARCH_ALL = false;
	}
	
	
	if($_POST['work_status']){
		//echo $_POST['work_status'];
		$conditions .= " AND s.work_status = '".$_POST['work_status']. "' ";
		$SEARCH_ALL = false;
	}
	
	if($_POST['flexi']){
		$conditions .= " AND s.flexi = '".$_POST['flexi']. "' ";
		$SEARCH_ALL = false;
	}
	
	if($_POST['login_type']){
		$SEARCH_ALL = false;
	}
	
	if($_POST['from']){
		$date_str=sprintf('&from=%s',$_POST['from']);
	}
	
	if($_POST['to']){
		$date_str.=sprintf('&to=%s',$_POST['to']);
	}
	
}else{
	if($admin['csro'] == 'Y'){
		$csro_conditions = " AND l.csro_id = '".$_SESSION['admin_id']. "' ";
		$smarty->assign('csro', $_SESSION['admin_id']);
		$csro_id = $_SESSION['admin_id'];
		$SEARCH_ALL = false;
	}
	if($_GET['page']){
		$csro_conditions = "";
		$csro_id ="";
		$SEARCH_ALL = true;
	}
}

$conditions .=sprintf(" AND DATE(s.starting_date)<='%s'", date('Y-m-d'));

//echo $SEARCH_ALL;
if($SEARCH_ALL){
	//// USE FOR PAGING ///
	// how many rows to show per page
	$rowsPerPage = $_REQUEST['rowsPerPage'];
	//echo $rowsPerPage;
	
	if($rowsPerPage == ""){
		$rowsPerPage = 100;
	}
	// by default we show first page
	$pageNum = 1;
	// if $_GET['page'] defined, use it as page number
	if(isset($_GET['page']))
	{
		$pageNum = $_GET['page'];
	}
	// counting the offset
	//echo $pageNum ;
	
	$offset = 0;
	if($pageNum!=NULL){
		$offset = ($pageNum - 1) * $rowsPerPage;
	}
	
	
	$limit = " LIMIT $offset, $rowsPerPage ";
	
	$sql="SELECT COUNT(s.id) FROM subcontractors s WHERE (s.status IN ('ACTIVE', 'suspended') AND DATE(s.starting_date)<='".date('Y-m-d')."' )";
	$numrows = $db_query_only->fetchOne($sql);
	$maxPage = ceil($numrows/$rowsPerPage);
	// print the link to access each page
	$self = "./".basename($_SERVER['SCRIPT_FILENAME']);
	$nav = '';
	for($page = 1; $page <= $maxPage; $page++)
	{
		if ($page == $pageNum)
		{
			$nav .= " <li><a class='currentpage' href=\"$self?page=$page$date_str\">$page</a></li> ";
		}
		else
		{
			$nav .= " <li><a href=\"$self?page=$page$date_str\">$page</a></li> ";
		}
	}
	
	if ($pageNum > 1){
	
		$page = $pageNum - 1;
		$prev = " <li><a href=\"$self?page=$page$date_str\">Prev</a></li> ";
		$first = "<li><a href=\"$self?page=1$date_str\">First Page</a></li>";
		
	}
	else{
	
		$prev  = '&nbsp;'; // we're on page one, don't print previous link
		$first = '&nbsp;'; // nor the first page link
	}
	
	if ($pageNum < $maxPage){
	
		$page = $pageNum + 1;
		$next = " <li><a href=\"$self?page=$page$date_str\">Next</a></li>";
		$last = " <li><a href=\"$self?page=$maxPage$date_str\">Last Page</a></li> ";
	}else{
	
		$next = '&nbsp;'; // we're on the last page, don't print next link
		$last = '&nbsp;'; // nor the last page link
	}
	//echo $first . $prev . $nav. $next . $last;
	$paging =  $first . $prev . $nav . $next . $last;
	$smarty->assign('paging', $paging);
	
	$csro_conditions = "";
	$csro_id = "";
	$result_str = sprintf('%s records found<br>page %s of %s', $numrows, $pageNum, $maxPage);

}


//echo "<hr>";
$DATE_SEARCH=array();
$random_string_exists = True;
$start_date_str = date('Y-m-d', strtotime($from));
$dayname = strtolower(date('D', strtotime($from)));
$weekday_str = $dayname."_start";
//echo $dayname;

$date_end_str = date('Y-m-d', strtotime($to));
while ($random_string_exists) {
    if($start_date_str <= $date_end_str){
	    $DATE_SEARCH[] = $start_date_str;
		$start_date_str = date("Y-m-d", strtotime("+1 day", strtotime($start_date_str)));
		$random_string_exists = True;
	}else{
		$random_string_exists = False;
	}
}

//echo "<pre>";
//print_r($DATE_SEARCH);
//echo "</pre>";
//exit;


$sql="SELECT s.id, s.userid, s.leads_id, s.client_timezone, s.staff_working_timezone, s.client_start_work_hour, s.client_finish_work_hour, s.overtime, s.overtime_monthly_limit, p.fname, p.lname, p.email, l.fname AS client_fname, l.lname AS client_lname, l.email AS client_email, s.work_days, flexi, mon_start, tue_start, wed_start, thu_start, fri_start, sat_start, sun_start,  mon_finish, tue_finish, wed_finish, thu_finish, fri_finish, sat_finish, sun_finish, s.job_designation, l.csro_id, s.work_status FROM subcontractors AS s INNER JOIN personal AS p ON p.userid = s.userid INNER JOIN leads AS l ON l.id = s.leads_id WHERE (s.status IN ('ACTIVE', 'suspended') $csro_conditions $conditions ) ORDER BY fname ASC $limit ";
//echo $sql;	
$staffs = $db_query_only->fetchAll($sql);
//echo "<pre>";
//print_r($staffs);
//echo "</pre>";
//exit;

$staff_list= array();
$staff_login_type_counter=0;
$counter = $offset;
foreach($staffs as $staff){
	$counter = $counter + 1;
	$total_hours_worked =0;
	$start_regular_working_hours="";
	$finish_regular_working_hours="";
	$work_days = explode(',',$staff['work_days']);
	
	
	$day_start = strtolower($dayname)."_start";
	$day_finish = strtolower($dayname)."_finish";
	
	if($staff['staff_working_timezone'] != ""){
	    $start_regular_working_hours =  setConvertTimezones($staff['staff_working_timezone'], $staff['staff_working_timezone'] , $staff[$day_start]);
	    $finish_regular_working_hours =  setConvertTimezones($staff['staff_working_timezone'], $staff['staff_working_timezone'] , $staff[$day_finish]);
	}
	//echo $start_regular_working_hours;
	if (in_array(strtolower($dayname), $work_days) == true) {
	    $working_hours = sprintf('%s - %s %s', $start_regular_working_hours, $finish_regular_working_hours, $staff['staff_working_timezone']);
	}else{
		$working_hours = 'No Schedule';
	}
	
	/*
	$working_hours="";
	if (in_array(strtolower($dayname), $work_days) == true) {
		foreach($work_days as $w){
			$day_start = strtolower($w)."_start";
	        $day_finish = strtolower($w)."_finish";
			if($staff['staff_working_timezone'] != ""){
	            $start_regular_working_hours =  setConvertTimezones($staff['staff_working_timezone'], $staff['staff_working_timezone'] , $staff[$day_start]);
	            $finish_regular_working_hours =  setConvertTimezones($staff['staff_working_timezone'], $staff['staff_working_timezone'] , $staff[$day_finish]);
	        }
			$working_hours .= sprintf('<div>%s %s - %s %s</div>', ucwords($w), $start_regular_working_hours, $finish_regular_working_hours, $staff['staff_working_timezone']);
		}
	    
	}else{
		$working_hours = 'No Schedule';
	}
	*/
	
	$csro = array();
	if($staff['csro_id']){
		$sql = $db_query_only->select()
		    ->from('admin', Array('admin_fname', 'admin_lname'))
			->where('admin_id =?', $staff['csro_id']);
		$csro = $db_query_only->fetchRow($sql);	
	}
	
	$data = array(
		'id' => $staff['id'],		  
		'staff_name' => $staff['fname']." ".$staff['lname'],
		'client_name' => $staff['client_fname']." ".$staff['client_lname'],
		'working_hours' => $working_hours,
		'userid' => $staff['userid'],
		'leads_id' => $staff['leads_id'],
		'job_designation' => $staff['job_designation'],
		'csro' => $csro,
		'work_status' => $staff['work_status'],
		'flexi' => $staff['flexi'],
		'counter' => $counter
	);
	
	
	if($staff['flexi'] == "yes"){
		unset($data['working_hours']);
		$data['working_hours'] = "Flexi Schedule";
	}
    
	
	//check the dates
	$regular_hours_work =0;
	$total_lunch_hours=0;
	$logins=array();
	$TS_YEAR_MONTH=array();
	$total_adj_hrs=0;
	foreach($DATE_SEARCH as $start_date_search){
		
		$compliance="";
		$time_in_str = "";
		$time_out_str = "";
		//echo $start_date_search."<br>";	
		$compliance = GetComplianceStr($start_date_search, $work_days, $staff);
		
		$timesheet_month_year = date("Y-m-01", strtotime($start_date_search));
		if(!in_array($timesheet_month_year, $TS_YEAR_MONTH)){
			$timesheet_id = GetTimesheetId($start_date_search, $staff['id']);
			$TS_YEAR_MONTH[] = $timesheet_month_year;
		}
		
		$adj_hrs = GetTimsheetDetailsAdjustedHours($timesheet_id, $start_date_search);
		$total_adj_hrs = $total_adj_hrs + $adj_hrs;
		$recorded_logins = array(
			'compliance' => $compliance,
			'adj_hrs' => $adj_hrs
		);
		
		$end_date_search_str = date("Y-m-d", strtotime("+1 day", strtotime($start_date_search)));
		
		$sql="SELECT time_in , time_out, mode FROM timerecord WHERE userid = ".$staff['userid']." AND leads_id = ".$staff['leads_id']." AND subcontractors_id = ".$staff['id']." AND time_in BETWEEN '".$start_date_search."' AND '".$end_date_search_str."' ORDER BY time_in ASC, mode DESC";
		$timerecords = $db_query_only->fetchAll($sql);
		
		$time_record = array();
		
		if(!$timerecords){
			$time_in = $start_date_search;
			if($compliance == 'absent' or $compliance == 'on leave' or $compliance == 'no schedule'){
				$time_in = date("Y-m-d D", strtotime($start_date_search));
			}
			array_push($time_record, array(
			    'time_in' => $time_in,
			    'time_out' => '',
			    'mode' => '-',
			    'total_hrs' => 0,
			    )
	        );
		}
		
		foreach($timerecords as $timerecord){
		    $work_hrs=0;			
			$lunch_hrs =0;
			$time_in_unix = date('U',strtotime($timerecord['time_in']));
		
		    if($timerecord['time_out']){
		        $time_out_unix = date('U',strtotime($timerecord['time_out']));
		    }else{
		        $time_out_unix = date('U');
		    }
			
		    if($timerecord['mode'] == 'regular'){
			    $work_hrs = $time_out_unix - $time_in_unix;
			    $work_hrs = $work_hrs / 3600.0;
				$total_hrs = $work_hrs;
				if($_POST['login_type']){
		            if($_POST['login_type'] == $compliance){
			            $regular_hours_work = $regular_hours_work + $work_hrs;
					}
				}else{
					$regular_hours_work = $regular_hours_work + $work_hrs;
				}
		    }else{
			    $lunch_hrs = $time_out_unix - $time_in_unix;
			    $lunch_hrs = $lunch_hrs / 3600.0;
				$total_hrs = $lunch_hrs;
			    
				if($_POST['login_type']){
		            if($_POST['login_type'] == $compliance){
			            $total_lunch_hours = $total_lunch_hours + $lunch_hrs;
					}
				}else{
					$total_lunch_hours = $total_lunch_hours + $lunch_hrs;
				}
		    }
		    
			if($_POST['login_type']){
		        if($_POST['login_type'] == $compliance){
					
		            array_push($time_record, array(
				        'time_in' => $timerecord['time_in'],
				        'time_out' => $timerecord['time_out'],
				        'mode' => $timerecord['mode'],
				        'total_hrs' => $total_hrs,
			            )
	                );
				}
			}else{
				array_push($time_record, array(
				    'time_in' => $timerecord['time_in'],
				    'time_out' => $timerecord['time_out'],
				    'mode' => $timerecord['mode'],
				    'total_hrs' => $total_hrs,
			        )
	            );
			}
				
	    }
		
		if($compliance == 'flexi'){
			$flexi++;
		}
		
		if($compliance == 'extra day'){
			$extra_day++;
		}
		
		if($compliance == 'early login'){
			$early_login++;
		}
		
		if($compliance == 'late'){
			$late++;
		}
		
		if($compliance == 'present'){
			$present++;
		}
		
		if($compliance == 'absent'){
			$absent++;
		}
		
		if($compliance == 'on leave'){
			$on_leave++;
		}
		
		if($compliance == 'no schedule'){
			$no_schedule++;
		}
		
		if($compliance == 'not yet working'){
			$not_yet_working++;
		}
		
		$recorded_logins['timerecords'] = $time_record;
		if($_POST['login_type']){
		    if($_POST['login_type'] == $compliance){
				$staff_login_type_counter++;
		        $logins[]= $recorded_logins;
			}
		}else{
			$logins[]= $recorded_logins;
		}
	}	
	//end check date
	
	$data['logins'] = $logins;
	
	$total_hours_worked = ($regular_hours_work-$total_lunch_hours);
	$data['total_hours_worked'] = $total_hours_worked;//ceil($total_hours_worked * 100)/100;
	$data['total_adj_hrs'] = $total_adj_hrs;
	$data['extra_day'] =$extra_day;
	$data['early_login'] = $early_login;
	$data['flexi_count'] = $flexi;
	$data['late'] = $late;
	$data['present'] = $present;
	
	$data['absent'] = $absent;
	$data['on_leave'] = $on_leave;
	$data['no_schedule'] = $no_schedule;
	$data['not_yet_working'] = $not_yet_working;
	$extra_day=0;
	$early_login =0;
	$flexi=0;
	$late=0;
	$present=0;
	$absent=0;
	$on_leave=0;
	$no_schedule=0;
	$not_yet_working=0;
	
	$data['staff_login_type_counter'] = $staff_login_type_counter;
	if($_POST['login_type']){
	    if($staff_login_type_counter>0){
		    array_push($staff_list, $data);
	    }
	}else{
		array_push($staff_list, $data);
	}
	$staff_login_type_counter=0;
}


//echo "<pre>";
//print_r($staff_list);
//echo "</pre>";
//exit;
$_SESSION['staff_attendance'] = "";
$_SESSION['staff_attendance'] = $staff_list;


$sql = "SELECT * FROM admin a WHERE csro='Y' AND status NOT IN('PENDING','REMOVED') ORDER BY admin_fname ASC;";
$csros = $db_query_only->fetchAll($sql); 
foreach($csros as $csro){
    if($csro_id == $csro['admin_id']){
	    $team_Options .="<option value='".$csro['admin_id']."' selected='selected'>".sprintf('%s %s', $csro['admin_fname'], $csro['admin_lname'])."</option>";
	}else{
		$team_Options .="<option value='".$csro['admin_id']."'>".sprintf('%s %s', $csro['admin_fname'], $csro['admin_lname'])."</option>";
	}
}


$conditions =sprintf(" AND DATE(s.starting_date)<='%s'", date('Y-m-d'));

//active staffs
$sql = "SELECT s.userid, p.fname, p.lname FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status IN ('ACTIVE', 'suspended') $conditions GROUP BY s.userid ORDER BY p.fname;";
$active_staffs = $db_query_only->fetchAll($sql);

//active clients
$sql = "SELECT s.leads_id, l.fname, l.lname FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status IN ('ACTIVE', 'suspended') GROUP BY s.leads_id ORDER BY l.fname;";
$active_clients = $db_query_only->fetchAll($sql);


$work_status_array = array('Full-Time','Part-Time');
for($i=0; $i<count($work_status_array); $i++){
    if($_POST['work_status'] == $work_status_array[$i]){
        $work_status_Options .="<option selected value='".$work_status_array[$i]."'>".$work_status_array[$i]."</option>";
	}else{
	    $work_status_Options .="<option value='".$work_status_array[$i]."'>".$work_status_array[$i]."</option>";
	}
}

//echo '=>'.$SEARCH_ALL;
if(!$SEARCH_ALL){
	$result_str = sprintf('%s records found<br>', count($staff_list));
}

$smarty->assign('SEARCH_ALL', $SEARCH_ALL);
$smarty->assign('prepaid_Options',Array('no', 'yes'));
$smarty->assign('flexi', $_POST['flexi']);
$smarty->assign('work_status_Options', $work_status_Options);
$smarty->assign('login_types', Array('present', 'early Login', 'extra day', 'late', 'flexi', 'absent', 'on leave', 'no schedule', 'not yet working'));
$smarty->assign('login_type', $_POST['login_type']);
$smarty->assign('active_clients', $active_clients);
$smarty->assign('active_staffs', $active_staffs);
$smarty->assign('team_Options', $team_Options );
$smarty->assign('from',$from);
$smarty->assign('to',$to);
$smarty->assign('staff_list',$staff_list);
$smarty->assign('result_str', $result_str);
$smarty->display('StaffAttendanceSheet.tpl');
?>