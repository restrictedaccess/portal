<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if(!$_SESSION['admin_id']){
	die("Session Expires. Please re-login");
}

//months
$monthFullName=array(
	1 => 'January',
	2 => 'February',
	3 => 'March',
	4 => 'April',
	5 => 'May',
	6 => 'June',
	7 => 'July',
	8 => 'August',
	9 => 'September',
	10 => 'October',
	11 => 'November',
	12 => 'December' 
);
for ($i =1; $i <= count($monthFullName); $i++) {
	//$det = new DateTime($i);
	//$month = $det->format("m");
			
	if($i == date("m")){
		$monthOptions .= "<option selected value='".$i."'>".$monthFullName[$i]."</option>\n";
	}else{
		$monthOptions .= "<option value='".$i."'>".$monthFullName[$i]."</option>\n";
	}
}

//year
for ($i = date("Y"); $i >=2008; $i--){
	if(date("Y") == $i){
		$yearoptions .= "<option value=\"$i\" selected>$i</option>\n";
	}else{
		$yearoptions .= "<option value=\"$i\" >$i</option>\n";
	}
}


//CSRO
$sql = $db->select()
	->from('admin' , Array('admin_id', 'admin_fname', 'admin_lname'))
	->where('status =?' , 'FULL-CONTROL')
	->where('csro =?', 'Y')
	->order('admin_fname ASC');
//echo $sql;exit;	
$csro =  $db->fetchAll($sql);

//CSRO
$sql = $db->select()
	->from('admin' , Array('admin_id', 'admin_fname', 'admin_lname'))
	->where('status =?' , 'HR')
	->order('admin_fname ASC');
//echo $sql;exit;	
$hr =  $db->fetchAll($sql);	






//COMLIANCE QUICK VIEW
//Get the no.of staff working today
//include 'StaffWorking.php';
/*
//total no. of leave request
$sql = $db->select()
	->from('leave_request')
	->where('leave_type !=?' , 'Absent');
$leave_requests = $db->fetchAll($sql);	
foreach($leave_requests as $leave_request){
	$det = new DateTime($leave_request['date_requested']);
	$timestamp = $det->format("Y-m-d");
	if($timestamp == date('Y-m-d')){
		$received_today++;
	}
}

$smarty->assign('received_today',$received_today);
$smarty->assign('leave_requests_count',count($leave_requests));


$sql = $db->select()
	->from(Array('r' => 'leave_request') , Array('id'))
	->join(Array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id', Array('leave_request_date_id' => 'id'))
	//->where('r.userid =?' ,$subcontractor['userid'])
	->where('d.date_of_leave =?' , date('Y-m-d'))
	->where('d.status =?', 'approved');
//echo $sql;	
$leave_result = $db->fetchAll($sql);
$smarty->assign('on_leave_today' , count($leave_result));
*/



$date = new DateTime();
$start_date_ref = $date->format('Y-m-01');
$end_date_ref = $date->format('Y-m-t');

$smarty->assign('csro',$csro);
$smarty->assign('yearoptions',$yearoptions);
$smarty->assign('monthOptions',$monthOptions);
$smarty->assign('start_date_ref',$start_date_ref);
$smarty->assign('end_date_ref',$end_date_ref);
$smarty->assign('today_date' , date("F j, Y"));
$smarty->display('Admin.tpl');
?>