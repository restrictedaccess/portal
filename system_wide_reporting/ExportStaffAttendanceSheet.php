<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}

$sql=$db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

if($admin['export_subconlist_reporting'] == 'N'){
    
	$body = sprintf('Admin #%s %s %s is trying to export Staff Attendance Sheet Reporting.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
	$body .= sprintf('<p><em>%s</em></p>', $_SERVER['SCRIPT_FILENAME']);
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	if(!TEST){
	    $mail->addTo('devs@remotestaff.com.au', 'Admin');
		//$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
	    $mail->setSubject("ALERT Staff Running Late Sheet Reports Exporting Permission Denied.");
	}else{
	    $mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("TEST ALERT Staff Running Late Sheet Reports Exporting Permission Denied.");
	}	
	
	$mail->send($transport);
	die("Staff Running Late Sheet Reports Exporting Permission Denied");
	//echo $_SERVER['SCRIPT_FILENAME'];
	//exit;
}

function setConvertTimezones($original_timezone, $converted_timezone , $time){
	if(!$original_timezone){
		return "No client timezone detected";
	}
	else if(!$time){
		return "0:00";
	}
	else{
		$converted_timezone = new DateTimeZone("$converted_timezone");
		$original_timezone = new DateTimeZone($original_timezone);
		$time_str = $time;
		if ($time_str == null) {
			$time_hour = "";
		}
		else {
			$time = new DateTime($time_str.":00", $original_timezone);
			$time->setTimeZone($converted_timezone);
			$time_hour = $time->format('h:i a');
			//$time_hour = $time->format('H:i');
		}
		return $time_hour;
	}

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

if($_REQUEST['csro']){
    $conditions .= " AND l.csro_id = '".$_REQUEST['csro']. "'";
	$sql = "SELECT admin_fname, admin_lname FROM admin WHERE admin_id =".$_REQUEST['csro'];
	$csro = $db->fetchRow($sql);
	$search_str .= sprintf('_%s_%s', $csro['admin_fname'], $csro['admin_lname']);
}

if($_REQUEST['userid']){
    $conditions .= " AND p.userid = '".$_REQUEST['userid']. "' ";
	$smarty->assign('userid', $_REQUEST['userid']);
	$sql = "SELECT fname, lname FROM personal WHERE userid =".$_REQUEST['userid'];
	$personal = $db->fetchRow($sql);
	$search_str .= sprintf('_%s_%s', $personal['fname'], $personal['lname']);
}

if($_REQUEST['leads_id']){
    $conditions .= " AND s.leads_id = '".$_REQUEST['leads_id']. "' ";
	$smarty->assign('leads_id', $_REQUEST['leads_id']);
	$sql = "SELECT fname, lname FROM leads WHERE id =".$_REQUEST['leads_id'];
	$lead = $db->fetchRow($sql);
	$search_str .= sprintf('_%s_%s', $lead['fname'], $lead['lname']);
}

if($_REQUEST['flexi']){
	$conditions .= " AND s.flexi = '".$_REQUEST['flexi']. "' ";
	$search_str .= sprintf('_flexi_%s', $_REQUEST['flexi']);
}

$start_date_of_leave = explode('-',$to);
$year = $start_date_of_leave[0];
$month = $start_date_of_leave[1];
$day = $start_date_of_leave[2];

$date = new DateTime();
$date->setDate($year, $month, $day);
$date->modify("+1 day");

$date_end_str = $date->format("Y-m-d");

$sql="SELECT s.id, s.userid, s.leads_id, s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour, p.fname, p.lname, p.email, l.fname AS client_fname, l.lname AS client_lname, l.email AS client_email, s.flexi FROM subcontractors AS s INNER JOIN personal AS p ON p.userid = s.userid INNER JOIN leads AS l ON l.id = s.leads_id WHERE (s.status IN ('ACTIVE', 'suspended') $conditions ) ORDER BY fname ASC";
$staffs = $db->fetchAll($sql);

$filename="STAFF_ATTENDANCE_DATE_".$from."_to_".$date_end_str.$search_str.".xls";


// Functions for export to excel.
function xlsBOF() { 
echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
return; 
} 
function xlsEOF() { 
echo pack("ss", 0x0A, 0x00); 
return; 
} 
function xlsWriteNumber($Row, $Col, $Value) { 
echo pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
echo pack("d", $Value); 
return; 
} 
function xlsWriteLabel($Row, $Col, $Value ) { 
$L = strlen($Value); 
echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
echo $Value; 
return; 
} 

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=$filename"); 
header("Content-Transfer-Encoding: binary ");


xlsBOF();

/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/

xlsWriteLabel(0,0,"Remotestaff Clients with Subcon");

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"USERID");
xlsWriteLabel(2,1,"STAFF NAME");
xlsWriteLabel(2,2,"CLIENTID");
xlsWriteLabel(2,3,"CLIENT NAME");
xlsWriteLabel(2,4,"SUBCONTRACT ID");
xlsWriteLabel(2,5,"WORKING HOURS");
xlsWriteLabel(2,6,"FLEXI");
xlsWriteLabel(2,7,"TIME IN");
xlsWriteLabel(2,8,"TIME OUT");
xlsWriteLabel(2,9,"MODE");
xlsWriteLabel(2,10,"HOURS");
// Put data records from mysql by while loop.
// Get data records from table. 
$counter=0;
$xlsRow = 3;


foreach($staffs as $staff){
	
	$start_regular_working_hours =  setConvertTimezones($staff['client_timezone'], 'Asia/Manila' , $staff['client_start_work_hour']);
	$finish_regular_working_hours =  setConvertTimezones($staff['client_timezone'], 'Asia/Manila' , $staff['client_finish_work_hour']);
	$staff_regular_working_hours =$start_regular_working_hours." - " .$finish_regular_working_hours." Asia/Manila";



	xlsWriteNumber($xlsRow,0,$staff['userid']);
	xlsWriteLabel($xlsRow,1,$staff['fname']." ".$staff['lname']);
	xlsWriteLabel($xlsRow,2,$staff['leads_id']);
	xlsWriteLabel($xlsRow,3,$staff['client_fname']." ".$staff['client_lname']);
	xlsWriteLabel($xlsRow,4,$staff['id']);
	xlsWriteLabel($xlsRow,5,$staff_regular_working_hours);
	xlsWriteLabel($xlsRow,6,$staff['flexi']);	
	
	
	$hours_worked ="";
	$total_hrs = "";
	$work_hrs="";
	$lunch_hrs="";
	$total_hours_worked ="";

	$sql = "SELECT time_in , time_out , mode FROM timerecord WHERE userid = ".$staff['userid']." AND leads_id = ".$staff['leads_id']." AND subcontractors_id = ".$staff['id']."  AND time_in BETWEEN '".$from."' AND '".$date_end_str."' ORDER BY time_in ASC,  mode DESC";
		//echo $sql;
	$timerecords = $db->fetchAll($sql);
	
	foreach($timerecords as $timerecord){
			
			if($timerecord['mode'] == 'regular'){
				//time_in
				$det = new DateTime($timerecord['time_in']);
				$time_in = $det->format('Y-m-d h:i a');
				$time_in_unix = $det->format('U');
				
				//time_out
				$det = new DateTime($timerecord['time_out']);
				$time_out = $det->format('Y-m-d h:i a');
				$time_out_unix = $det->format('U');
				
				$work_hrs = $time_out_unix - $time_in_unix;
				$work_hrs = $work_hrs / 3600.0;
				//$work_hrs = number_format($work_hrs ,2 ,'.','');
				
				$total_hrs = $work_hrs;
				
			}else{
				//time_in
				$det = new DateTime($timerecord['time_in']);
				$time_in = $det->format('Y-m-d h:i a');
				$time_in_unix = $det->format('U');
				
				//time_out
				$det = new DateTime($timerecord['time_out']);
				$time_out = $det->format('Y-m-d h:i a');
				$time_out_unix = $det->format('U');
				
				$lunch_hrs = $time_out_unix - $time_in_unix;
				$lunch_hrs = $lunch_hrs / 3600.0;
				//$lunch_hrs = number_format($lunch_hrs ,2 ,'.','');
				
				$total_hrs = $lunch_hrs;
			}
			
			$hours_worked = ($work_hrs-$lunch_hrs);
			
			//$time_str = sprintf('%s - %s %s = %s' , $time_in , $time_out , $timerecord['mode'] , number_format($total_hrs ,2 ,'.',''));
			
			xlsWriteLabel($xlsRow,7,$time_in);
			xlsWriteLabel($xlsRow,8,$time_out);
			xlsWriteLabel($xlsRow,9,$timerecord['mode']);
			xlsWriteLabel($xlsRow,10,number_format($total_hrs ,2 ,'.',''));
			
			$total_hours_worked = $total_hours_worked + $hours_worked;
			
			$xlsRow++;
		}
		//if($hours_worked){
		//	xlsWriteLabel($xlsRow,10,sprintf('Total Hours : %s' , number_format($total_hours_worked ,2 ,'.','') ));
		//}
	$total_hours_worked=0;	
	$xlsRow = $xlsRow + 2;	
	//$xlsRow++;
}

xlsEOF();


exit();
?>