<?php
include './conf/zend_smarty_conf.php';

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}


$sql=$db->select()
	->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

if($admin['export_subconlist_reporting'] == 'N'){
	
	$body = sprintf('Admin #%s %s %s is trying to export Cancellation Dashboard Reporting.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
	$body .= sprintf('<p><em>%s</em></p>', $_SERVER['SCRIPT_FILENAME']);
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	if(!TEST){
		$mail->addTo('admin@remotestaff.com.au', 'Admin');
		$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("ALERT Cancellation Dashboard Exporting Permission Denied.");
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("TEST ALERT Cancellation Dashboard Exporting Permission Denied.");
	}	
	
	$mail->send($transport);
	die("Cancellation Dashboard Reporting Exporting Permission Denied");
}


$from_month = $_GET['from_month'];
$from_year = $_GET['from_year'];

$to_month = $_GET['to_month'];
$to_year = $_GET['to_year'];

if($from_month == ""){
	$from_month = date("m");
}

if($from_year == ""){
	$from_year = date("Y");
}

if($to_month == ""){
	$to_month = date("m");
}

if($to_year == ""){
	$to_year = date("Y");
}


if($_GET['hm']){
	$conditions .= " AND l.hiring_coordinator_id = '".$_GET['hm']. "'";
}

if($_GET['csro']){
	$conditions .= " AND l.csro_id = '".$_GET['csro']. "'";
}

if($_GET['work_status']){
	$conditions .= " AND s.work_status = '".$_GET['work_status']. "'";
}

if($_GET['reason_type']){
	$conditions .= " AND s.reason_type = '".$_GET['reason_type']. "'";
}

if($_GET['service_type']){
	$conditions .= " AND s.service_type = '".$_GET['service_type']. "'";
}

if($_GET['business_partner_id']){
	$conditions .= " AND l.business_partner_id = '".$_GET['business_partner_id']. "'";
}

if($_GET['recruiter']){
	$conditions .= " AND rs.admin_id = '".$_GET['recruiter']. "'";
}

$date = new DateTime();
$date->setDate($from_year, $from_month, date("d"));
$start_date_str = $date->format("Y-m");
//echo $start_date_str."<br>";


$date2 = new DateTime();
$date2->setDate($to_year, $to_month, date("d"));
$end_date = $date->format("Y-m");
$date2->modify("+1 month");
$end_date_str = $date2->format("Y-m");
//echo $end_date_str."<br>";

$file_search = sprintf('from_%s_to_%s', $start_date_str, $end_date );

$DATE_SEARCH=array();
$random_string_exists = True;
while ($random_string_exists) {
    if($start_date_str != $end_date_str){
	    $DATE_SEARCH[] = $date->format("Y-m-d");
		$date->modify("+1 month");
		$start_date_str = $date->format("Y-m");
		$random_string_exists = True;
	}else{
		$random_string_exists = False;
	}
}


$SEARCH_RESULTS =array();
foreach($DATE_SEARCH as $date_search_str){
	$date = new DateTime($date_search_str);
	$start_date_search_str = $date->format("Y-m-01 00:00:00");
	$finish_date_search_str = $date->format("Y-m-t 23:59:59");
	//echo sprintf('%s => %s<br>' , $start_date_search_str, $finish_date_search_str ) ;
	
	$data['date_search_str'] = $date_search_str;
	
	//total no. of terminated contracts
    $sql = "SELECT COUNT(s.id)AS num_count_terminated  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.status = 'terminated' AND s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	//echo $sql;
    $num_count_terminated = $db->fetchOne($sql);
	$data['num_count_terminated'] = $num_count_terminated;
	
	
	//total no. of resigned contracts
    $sql = "SELECT COUNT(s.id)AS num_count_terminated  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.status = 'resigned' AND s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";";
	//echo $sql;
    $num_count_resigned = $db->fetchOne($sql);
	$data['num_count_resigned'] = $num_count_resigned;
	
	
	//total no. of replacement request
    $sql = "SELECT COUNT(s.id)AS num_count_replacement_request FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.replacement_request='yes' AND (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions."; ";
    $num_count_replacement_request = $db->fetchOne($sql);
	$data['num_count_replacement_request'] = $num_count_replacement_request;
	
	//total no. of no replacement request
    $sql = "SELECT COUNT(s.id)AS num_count_replacement_request FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.replacement_request='no' AND (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions."; ";
    $num_count_no_replacement_request = $db->fetchOne($sql);
	$data['num_count_no_replacement_request'] = $num_count_no_replacement_request;
	
	
	//total contract cancelled
    $sql = "SELECT COUNT(s.id)AS num_count_replacement_request FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions."; ";
	//echo $sql;
    $total_contract_cancelled = $db->fetchOne($sql);
	$data['total_contract_cancelled'] = $total_contract_cancelled;		
	$data['total_contract_ended'] =  ($total_contract_cancelled - $num_count_replacement_request);
	
		
	array_push($SEARCH_RESULTS, $data);
}
//echo "<pre>";
//print_r($SEARCH_RESULTS);
//echo "</pre>";
//exit;
	
	
	
$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");


//put csv header
$data =array(
	'Month / Year', 
	'Resigned', 
	'Terminated',
	'Request to Replace',
	'No Request to Replace', 
	'Total Contract Cancelled', 
	'Total Contract Ended', 
);
fputcsv($handle, $data);

foreach ($SEARCH_RESULTS as $line) {
	$date = new DateTime($line['date_search_str']);
	$date_search_str = $date->format("Y-m");
	$record = array(
		$date_search_str,
		$line['num_count_resigned'],
		$line['num_count_terminated'],
		$line['num_count_replacement_request'],
		$line['num_count_no_replacement_request'],
		$line['total_contract_cancelled'],
		$line['total_contract_ended'],
	);
	
	fputcsv($handle, $record);
}

$filename = "Remotestaff_Cancellation_Dashboard_".$file_search."_".basename($tmpfname . ".csv");
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
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