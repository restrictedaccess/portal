<?php
require('../conf/zend_smarty_conf.php');
require('../tools/CouchDBMailbox.php');
include('export_function.php');
require('../admin_subcon/subcon_function.php');


if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

    
$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

$script_name = $_SERVER['SCRIPT_FILENAME'];
if($_SERVER['QUERY_STRING']){
	$script_name =sprintf('%s?%s', $script_name,$_SERVER['QUERY_STRING'] );
}

if (in_array($_SESSION['admin_id'], $admin_with_permission) == False) {
    	
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Permission Denied.";
    $text = sprintf('Admin #%s %s %s is trying to export export_clients_with_company_industry_and_staff_contract_duration_and_client_hourly_rate.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Exporting of export_clients_with_company_industry_and_staff_contract_duration_and_client_hourly_rate denied.");
	
}

function formatNum($num){
	if($num!=""){
		$num = number_format($num ,2 ,'.' ,'');
	}else{
		$num = 0;
	}
	return $num;
}
//$comparing_date = date("Y-m-d");
//$time2 = '2012-10-24';
//echo dateDiff('2012-05-28', '2012-06-09');
//exit;
$sql="SELECT (l.id)AS leads_id, l.leads_country, l.city, l.fname, l.lname, (l.status)AS client_status, l.company_industry, l.email, l.officenumber, l.mobile, (s.id)AS subcon_id, (p.fname)AS staff_fname, (p.lname)AS staff_lname, (s.status)AS contract_status, s.client_price,  s.job_designation,  s.starting_date, DATE(s.end_date)AS end_date, s.work_status, s.replacement_request FROM leads AS l LEFT JOIN subcontractors AS s ON s.leads_id = l.id LEFT JOIN personal AS p ON p.userid = s.userid WHERE s.status IN ('ACTIVE', 'suspended', 'terminated', 'resigned') and (l.company_industry is not null and l.company_industry != '' and l.company_industry !='0' ) ORDER BY l.fname, l.lname";
$results = $db->fetchAll($sql);


$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");

//echo "<pre>";
$comparing_date = "".date("Y-m-d");
foreach($results as $result){
	
	//Contract Duration
	$contract_duration = "";
	if($result['contract_status'] == "ACTIVE" or $result['contract_status'] == "suspended"){
		$contract_duration = dateDiff($comparing_date,$result['starting_date']);
	}else{
		if($result['end_date']){
			$end_date = "".$result['end_date'];
			$contract_duration = dateDiff($result['starting_date'],$end_date);			
		}
	}
	
	//Check work_status
	$work_status = "Full-Time"; //Default value
	if($result['work_status']){
		$work_status = $result['work_status'];
	}
	
	//Check working hours
	$working_hours = 8; // Default value
	if($work_status == "Part-Time"){
		$working_hours = 4;
	}
	
	//Check client_price
	$client_hourly_rate="0.00";
	if($result['client_price']){
		if($result['client_price'] > 0){
			$client_hourly_rate = (((($result['client_price'] * 12) / 52) / 5 ) / $working_hours);
		}
	}
	
	
	
	//echo sprintf('<li>Client ID : %s <br>Subcon Id: %s <br>Starting Date : %s <br>End Date : %s <br>Duration : %s <br>Contract Status : %s <br>Work Status : %s %s/hrs <br>Client Rate : %s %s/hr</li>', $result['leads_id'], $result['subcon_id'], $result['starting_date'], $result['end_date'], $contract_duration, $result['contract_status'], $work_status, $working_hours, $result['client_price'], formatNum($client_hourly_rate)   );
	
	
	$record = array(
		$result['leads_id'],
		$result['leads_country'],
		$result['city'],
		$result['fname']." ".$result['lname'],
		$result['client_status'],
		$result['email'],
		$result['company_industry'],
		$result['officenumber'],
		$result['mobile'],
		$result['subcon_id'],
		$result['staff_fname']." ".$client['staff_lname'],
		$result['contract_status'],
		$result['client_price']."/Monthly",
		formatNum($client_hourly_rate)."/Hr",
		$result['job_designation'],
		$work_status,
		$result['replacement_request'],
		$result['starting_date'],
		$result['end_date'],
		$contract_duration,
	);
	//print_r($record);
	fputcsv($handle, $record);
	
}
//echo "</pre>";





$filename ="export_clients_with_company_industry_and_staff_contract_duration_and_client_hourly_rate_".basename($tmpfname . ".csv");


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));



//$attachments_array=array();
//$data=array(
//    'tmpfname' => $tmpfname,
//	'filename' => $filename
//);
//array_push($attachments_array, $data);

//$bcc_array=array('devs@remotestaff.com.au');
//$cc_array = NULL;
//$from = 'No Reply<noreply@remotestaff.com.au>';
//$html = NULL;
//$subject = "Active Clients Currency Setting";
//$text = sprintf('Admin #%s %s %s exported Active Clients Currency Setting. %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'], $script_name);
//$to_array = array('admin@remotestaff.com.au');
//SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);
exit;
?>