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
    
	$body = sprintf('Admin #%s %s %s is trying to export Running Late Reporting.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
	$body .= sprintf('<p><em>%s</em></p>', $_SERVER['SCRIPT_FILENAME']);
	
	$attachments_array =NULL;
	$bcc_array=NULL;
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = $body;
    $subject = "System Wide Reporting Running Late Sheet Reports Exporting Permission Denied";
    //$text = $body;
    $to_array = array('devs@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	die($subject);
}


//echo "<pre>";
//print_r($_SESSION['staff_list']);
//echo "</pre>";
//exit;


$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");
	
	
//put csv header
$data =array(
    'Subcon Id', 
    'Staff', 
	'Client',
	'Csro',
	'Compliance',
);

fputcsv($handle, $data);

foreach ($_SESSION['staff_list'] as $line) {
	$record = array(
	    $line['id'],
		$line['staff_name'],
		$line['client_name'],
		$line['csro']['admin_fname']." ".$line['csro']['admin_lname'],
		$line['compliance']
    );
	
	if($line['compliance'] == 'running late' or $line['compliance'] == '10 minutes' or $line['compliance'] == 'not yet working' or $line['compliance'] == 'on leave' or $line['compliance'] == 'absent'){
		array_push($record, $line['expected_login_time']);
	}else{
		array_push($record, $line['time_in']);
	}
	fputcsv($handle, $record);
}

$filename = "RUNNING_LATE_REPORT_".$_REQUEST['from']."_".basename($tmpfname . ".csv");
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));

//CouchDB Mailbox
$attachments_array=array();
$data=array(
    'tmpfname' => $tmpfname,
	'filename' => $filename
);
array_push($attachments_array, $data);

$bcc_array=NULL;
$cc_array = NULL;
$from = 'No Reply<noreply@remotestaff.com.au>';
$html = NULL;
$subject = "System Wide Reporting Running Late Exported to CSV";
$text = "Admin ".sprintf('#%s %s %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'])." exported Running Late Report : ".$filename;
$to_array = array('devs@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);
?>