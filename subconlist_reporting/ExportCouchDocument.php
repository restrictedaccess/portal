<?php
//  2012-10-22  Normaneil E. Macutay <normanm@remotestaff.com.au>
//  -   initial hack
include '../conf/zend_smarty_conf.php';
include '../admin_subcon/subcon_function.php';

//echo $_GET['doc_id'];exit;

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
//echo $sql;	
$admin = $db->fetchRow($sql);

if($admin['export_subconlist_reporting'] == 'N'){
    
	$body = sprintf('Admin #%s %s %s is trying to export %s subcontractors list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'], $page_status);
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	if(!TEST){
	    $mail->addTo('admin@remotestaff.com.au', 'Admin');
		$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
	    $mail->setSubject("ALERT ".$page_status." Subcontractors List Exporting Permission Denied.");
	}else{
	    $mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("TEST ALERT ".$page_status." Subcontractors List Exporting Permission Denied");
	}	
	//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
	//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	
	$mail->send($transport);
	die($page_status." Subcontractors List Export Permission Alert. Exporting cannot be access.");
	
}

$couch_client = new couchClient($couch_dsn, 'subconlist_reporting');
$doc = new stdClass();
$doc->_id = $_REQUEST['doc_id'];
try {
	$response = $couch_client->getDoc($_REQUEST['doc_id']);
} catch (Exception $e) {
	echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	exit(1);
}
if(!$response->result){
	echo "No Subcontractors Adjusted Hours Detected.";
	exit;
}


$subcontractor_ids_str ="";
foreach($response->subcontractor_ids as $subcon){
	//echo sprintf('%s<br>', $subcon);
	$subcontractor_ids_str.=sprintf('%s,', $subcon);
}
//exit;
//remove the last comma;
$subcontractor_ids_str=substr($subcontractor_ids_str,0,(strlen($subcontractor_ids_str)-1));

$sql = "SELECT s.id,s.starting_date, s.userid , p.fname, p.lname , p.email ,s.leads_id, CONCAT(l.fname,' ',l.lname)AS client_name, (l.email)AS leads_email, s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour, s.work_status, s.job_designation, flexi, s.prepaid, s.staff_working_timezone, currency, staff_currency_id, client_price, php_monthly, (s.status)AS contract_status, s.date_terminated, s.resignation_date, l.csro_id
FROM subcontractors s
LEFT JOIN personal p ON p.userid = s.userid
LEFT JOIN leads l ON l.id = s.leads_id
WHERE s.id IN ($subcontractor_ids_str) ORDER BY p.fname ;";
//echo $sql;
$filter_staffs = $db->fetchAll($sql);

$staffs = array();
include 'filter-subconlist.php';

//echo "<pre>";
//print_r($staffs);
//echo "</pre>";
//exit;

$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");

//put csv header
$data =array(
	'Userid', 
	'Staff Name', 
	'Job Designation',
	'Staff Working Status',
	'Prepaid', 
	'Staff Email', 
	'Client  Name',
	'Start Time',
	'Finish Time',
	'Staff Monthly Rate',
	'Client Monthly Rate',
	'Contract Length',
	'Status',
	'Starting Date',
	'Contract End Date',
	'Total Log Hours',
	'Total Adjusted Hours',
	'CSRO'
);
fputcsv($handle, $data);

foreach ($staffs as $line) {
	$record = array(
		$line['userid'], 
		sprintf('%s %s', $line['fname'],$line['lname']) ,
		$line['job_designation'],
		$line['work_status'],
		$line['prepaid'],
		$line['email'],
		$line['client_name'],
		sprintf("%s %s / %s %s", $line['client_timezone'], ConvertTime($line['client_timezone'], $line['client_timezone'] , $line['client_start_work_hour']), $line['staff_working_timezone'], ConvertTime($line['client_timezone'], $line['staff_working_timezone'] , $line['client_start_work_hour'])),
		sprintf("%s %s / %s %s", $line['client_timezone'], ConvertTime($line['client_timezone'], $line['client_timezone'] , $line['client_finish_work_hour']), $line['staff_working_timezone'], ConvertTime($line['client_timezone'], $line['staff_working_timezone'] , $line['client_finish_work_hour'])),
		$line['staff_salary'],
		$line['client_rate'],
		$line['duration'],
		$line['contract_status'],
		$line['starting_date'],
		$line['staff_contract_finish_date'],
		$line['total_log_hour'],
		$line['adj_hours'],
		$line['csro_name']
	);	
	fputcsv($handle, $record);
	
}	



$filename = sprintf("SUBCONLIST_REPORTING_AS_OF_%s_%s_%s.csv",$from, $to, basename($tmpfname));
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
//header('Content-Disposition: attachment; filename=STAFF_SHIFT_DETAILS'.$tmpfname . ".csv");
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);
exit;
?>