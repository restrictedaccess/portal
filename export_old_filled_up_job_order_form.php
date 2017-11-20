<?php
require('./conf/zend_smarty_conf.php');
require('./tools/CouchDBMailbox.php');


if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$admin_with_permission = array(5, 6);
    
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
    $subject = "Permission Denied. OLD Job Order Form List Exporting";
    $text = sprintf('Admin #%s %s %s is trying to export OLD Job Order Form list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Exporting of OLD Job Order Form List Permission Denied.");
	
}

//parse all filled up JO

$sql="SELECT j.job_order_id, j.ran, j.date_created, j.form_filled_up, j.date_filled_up, j.leads_id,  l.fname, l.lname, l.email  FROM job_order j JOIN leads l ON l.id = j.leads_id where DATE(date_created) > 2010 and form_filled_up = 'yes';";
$orders = $db->fetchAll($sql);

//echo "<pre>";
//echo "<ol>";
//print_r($leads);



$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");
	
	
//put csv header
$data =array(
    'JOB ORDER ID',
	'DATE CREATED',
	'FORM FILLED UP',
	'DATE FILLED UP',
	'CLIENT NAME',
	'LEADS ID',
	'EMAIL',
	'JOB ORDER LINK'
);

fputcsv($handle, $data);


foreach($orders as $order){
	//echo sprintf('<li>%s %s %s</li>', $lead['id'], $lead['fname'], $lead['lname'], $lead['email']);
	$record = array(
		$order['job_order_id'],
		$order['date_created'],
		$order['form_filled_up'],
		$order['date_filled_up'],
		sprintf('%s %s', $order['fname'], $order['lname']),
		$order['leads_id'],
		$order['email'],
		sprintf('https://remotestaff.com.au/portal/pdf_report/job_order_form/?ran=%s', $order['ran']),
	);
	
	fputcsv($handle, $record);
}
//echo "</ol>";
//echo "</pre>";

$filename ="Filled_Up_OLD_JO_2011_onwards".basename($tmpfname . ".csv");


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
$subject = sprintf('Admin #%s %s %s exported OLD Job Order Form List 2011 onwards', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname']);
$text = sprintf('Admin #%s %s %s exported OLD Job Order Form List 2011 onwards', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname']);
$to_array = array('admin@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);



exit;
?>