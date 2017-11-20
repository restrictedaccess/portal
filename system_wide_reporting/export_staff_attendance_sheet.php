<?php
include('../conf/zend_smarty_conf.php');
require('../tools/CouchDBMailbox.php');


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
	
	$attachments_array =NULL;
	$bcc_array=NULL;
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = $body;
    $subject = "System Wide Reporting Staff Attendance Report Exporting Permission Denied";
    //$text = $body;
    $to_array = array('devs@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	die($subject);
}


$tmpfname = tempnam(null, null);
$filename = sprintf("STAFF_ATTENDANCE_SHEET_%s_%s_%s.xls" , $_REQUEST['from'], $_REQUEST['to'], basename($tmpfname));


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
header("Content-Type: application/download");
header('Content-Disposition: attachment; filename='.$filename);
header("Content-Transfer-Encoding: binary ");



xlsBOF();


// Make column labels. (at line 3)
xlsWriteLabel(0,0,"USERID");
xlsWriteLabel(0,1,"STAFF NAME");
xlsWriteLabel(0,2,"CLIENTID");
xlsWriteLabel(0,3,"CLIENT NAME");
xlsWriteLabel(0,4,"SUBCONTRACT ID");
xlsWriteLabel(0,5,"WORKING HOURS");
xlsWriteLabel(0,6,"COMPLIANCE");
xlsWriteLabel(0,7,"TIME IN");
xlsWriteLabel(0,8,"TIME OUT");
xlsWriteLabel(0,9,"MODE");
xlsWriteLabel(0,10,"HOURS");
xlsWriteLabel(0,11,"ADJ HOURS");
xlsWriteLabel(0,12,"CSRO");
xlsWriteLabel(0,13,"WORK STATUS");
xlsWriteLabel(0,14,"FLEXI");
// Put data records from mysql by while loop.
// Get data records from table. 
$counter=0;
$xlsRow = 1;


foreach($_SESSION['staff_attendance'] as $line){
	
	xlsWriteNumber($xlsRow,0,$line['userid']);
	xlsWriteLabel($xlsRow,1,$line['staff_name']);
	xlsWriteNumber($xlsRow,2,$line['leads_id']);
	xlsWriteLabel($xlsRow,3,$line['client_name']);
	xlsWriteNumber($xlsRow,4,$line['id']);
	xlsWriteLabel($xlsRow,5,$line['working_hours']);
	xlsWriteLabel($xlsRow,12,sprintf('%s %s', $line['csro']['admin_fname'], $line['csro']['admin_lname']));
	xlsWriteLabel($xlsRow,13,$line['work_status']);
	xlsWriteLabel($xlsRow,14,$line['flexi']);
	
	foreach($line['logins'] as $login){
		xlsWriteLabel($xlsRow,6,$login['compliance']);
		xlsWriteLabel($xlsRow,11,$login['adj_hrs']);
		foreach($login['timerecords'] as $timerecord){
			xlsWriteLabel($xlsRow,7,$timerecord['time_in']);
			xlsWriteLabel($xlsRow,8,$timerecord['time_out']);
			xlsWriteLabel($xlsRow,9,$timerecord['mode']);
			xlsWriteNumber($xlsRow,10,number_format($timerecord['total_hrs'] ,2 ,'.',''));
			$xlsRow++;
		}
	}
	
}
xlsEOF();


//CouchDB Mailbox
$attachments_array=array();
/*
$data=array(
    'tmpfname' => $tmpfname,
	'filename' => $filename
);
array_push($attachments_array, $data);
*/
$bcc_array=NULL;
$cc_array = NULL;
$from = 'No Reply<noreply@remotestaff.com.au>';
$html = NULL;
$subject = "System Wide Reporting Staff Attendance Sheet Exported";
$text = "Admin ".sprintf('#%s %s %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'])." exported Staff Atttendance Sheet Report : ".$filename;
$to_array = array('devs@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


exit();
?>