<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}

if(!$_REQUEST['userid']){
	die("Staff ID is missing");
}

$query="SELECT * FROM personal WHERE userid=".$_REQUEST['userid'];
$staff = $db->fetchRow($query);


$leads_id = $_REQUEST['leads_id'];

if($_REQUEST['year'] && $_REQUEST['month'] && $_REQUEST['day']){
	
	$date = $_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day']; 
	$det = new DateTime($date);
	$date_of_leave = $det->format("Y-m-d");
	$smarty->assign('date_of_leave' , $date_of_leave);
}

//leads details

$sql = $db->select()
->from(array('s' => 'subcontractors') , Array('leads_id'))
->joinleft(array('l' => 'leads') , 'l.id = s.leads_id' , Array('fname' , 'lname' ,'email'))
->where('userid = ?' ,$_REQUEST['userid'])
->where('s.status =?' , 'ACTIVE');
//echo $sql;	
$leads = $db->fetchAll($sql);
foreach($leads as $leads){
	$leads_options .= "<div><input type='checkbox' checked='checked' onClick='check_val()'  name='lead' value='".$leads['leads_id']."' />  <b>".$leads['fname']." ".$leads['lname']."</b></div>";
	
}	


$leave_type_array = array('Absent', 'Sick Leave' , 'Vacation Leave' , 'Personal Leave', 'Client Public Holiday', 'Staff Public Holiday');
for($i=0 ; $i<count($leave_type_array); $i++){
	if($leave_type == $leave_type_array[$i]){
		$leave_type_Options .="<option value='".$leave_type_array[$i]."' selected='selected'>".$leave_type_array[$i]."</option>";
	}else{
		$leave_type_Options .="<option value='".$leave_type_array[$i]."' >".$leave_type_array[$i]."</option>";
	}
} 

$duration_array = array('Whole Day' , 'Half Day');
for($i=0 ; $i<count($duration_array); $i++){
	if($leave_duration == $duration_array[$i]){
		$leave_duration_Options .="<option value='".$duration_array[$i]."' selected='selected'>".$duration_array[$i]."</option>";
	}else{
		$leave_duration_Options .="<option value='".$duration_array[$i]."' >".$duration_array[$i]."</option>";
	}
} 


$smarty->assign('comment_by_type',$comment_by_type);
$smarty->assign('leave_type_Options',$leave_type_Options);
$smarty->assign('leave_duration_Options',$leave_duration_Options);
$smarty->assign('leads_options' ,$leads_options);
$smarty->display('ShowAddLeaveForm.tpl');
?>