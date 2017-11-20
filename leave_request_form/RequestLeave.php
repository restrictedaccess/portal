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

if(!$_SESSION['userid']){
	die("Staff ID is missing");
}

$comment_by_id = $_SESSION['userid'];
$comment_by_type = 'personal';	

$query="SELECT userid, fname, lname FROM personal WHERE userid=".$_SESSION['userid'];
$staff = $db->fetchRow($query);


$leads_id = $_REQUEST['leads_id'];

if($_REQUEST['year'] && $_REQUEST['month'] && $_REQUEST['day']){
	
	$date = $_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day']; 
	$det = new DateTime($date);
	$date_of_leave = $det->format("Y-m-d");
	$smarty->assign('date_of_leave' , $date_of_leave);
}

//leads details

//if($leads_id != 'all'){
	//single client selection
//	$sql = $db->select()
//		->from('leads')
//		->where('id =?' ,$leads_id);
//	$leads = $db->fetchRow($sql);
//	$leads_options = "<div><input type='checkbox' checked='checked' onClick='check_val()'  name='lead' value='".$leads['id']."' /> <b>".$leads['fname']." ".$leads['lname']."</b>//</div>";
	 	
//}else{
	//multiple client
	$sql = "SELECT s.leads_id, l.fname, l.lname, l.email FROM subcontractors s LEFT JOIN leads  l ON l.id = s.leads_id WHERE userid=".$_SESSION['userid']."  AND s.status IN('ACTIVE', 'suspended');";
	//echo $sql;	
	$leads = $db->fetchAll($sql);
	$ctr = 0;
	foreach($leads as $leads){
		$leads_options .= "<div><input type='checkbox' checked='checked' onClick='check_val()'  name='lead' value='".$leads['leads_id']."' />  <b>".$leads['fname']." ".$leads['lname']."</b></div>";
		$ctr++;
	}
	

//}	

$leave_type_array = array('Sick Leave' , 'Vacation Leave' , 'Personal Leave', 'Client Public Holiday', 'Staff Public Holiday');
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
$smarty->assign('leave_request' , $leave_request);
$smarty->display('RequestLeave.tpl');
?>