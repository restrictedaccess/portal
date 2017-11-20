<?php
require('../conf/zend_smarty_conf.php');
require('../tools/CouchDBMailbox.php');
include('export_function.php');

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

    
$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);


if (in_array($_SESSION['admin_id'], $admin_with_permission) == False) {
    	
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Permission Denied. All Leads Exporting";
    $text = sprintf('Admin #%s %s %s is trying to export All Leads list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Exporting of All Leads List Permission Denied.");
	
}

//parse all leads

//$sql="select id, fname, lname, email , status, timestamp from leads l where status is not null and fname is not null and lname is not null and email is not null order by l.fname ";
$sql="select id, fname, lname, email , status, timestamp, leads_ip, leads_country from leads l order by l.fname;";
$leads = $db->fetchAll($sql);

//echo "<pre>";
//echo "<ol>";
//print_r($leads);



$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");
	
	
//put csv header
$data =array(
    'ID',
	'Client Name',
	'Email',
	'Status',
	'Date Registered',
	'Ip',
	'Ip Country',
);

fputcsv($handle, $data);


foreach($leads as $lead){
	//echo sprintf('<li>%s %s %s</li>', $lead['id'], $lead['fname'], $lead['lname'], $lead['email']);
	$record = array(
		$lead['id'],
		$lead['fname']." ".$lead['lname'],
		$lead['email'],
		$lead['status'],
		$lead['timestamp'],
		$lead['leads_ip'],
		$lead['leads_country'],
	);
	
	fputcsv($handle, $record);
}
//echo "</ol>";
//echo "</pre>";

$filename ="All_Leads".basename($tmpfname . ".csv");


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));



$attachments_array=array();
$data=array(
    'tmpfname' => $tmpfname,
	'filename' => $filename
);
array_push($attachments_array, $data);

$bcc_array=array('devs@remotestaff.com.au');
$cc_array = NULL;
$from = 'No Reply<noreply@remotestaff.com.au>';
$html = NULL;
$subject = sprintf('Admin #%s %s %s exported All Leads', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname']);
$text = sprintf('Admin #%s %s %s exported All Leads', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname']);
$to_array = array('admin@remotestaff.com.au');
SaveToCouchDBMailbox(NULL, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);



exit;
?>