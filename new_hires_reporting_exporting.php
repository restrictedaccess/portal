<?php
include './conf/zend_smarty_conf.php';

$sql=$db->select()
	->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);
//print_r($admin);
//exit;
if($admin['export_subconlist_reporting'] == 'N'){
	
	$body = sprintf('Admin #%s %s %s is trying to export New Hire Reporting.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
	$body .= sprintf('<p><em>%s</em></p>', $_SERVER['SCRIPT_FILENAME']);
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	if(!TEST){
		$mail->addTo('admin@remotestaff.com.au', 'Admin');
		$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("ALERT New Hire Reports Exporting Permission Denied.");
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("TEST ALERT New Hire Reports Exporting Permission Denied.");
	}	
	
	$mail->send($transport);
	die("New Hires Reports Exporting Permission Denied");
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



$conditions .= " AND s.status IN ('ACTIVE', 'terminated', 'resigned', 'suspended')";
	
	if($_GET['hm']){
	    $conditions .= " AND l.hiring_coordinator_id = '".$_GET['hm']. "'";
	}
	
	if($_GET['csro']){
	    $conditions .= " AND l.csro_id = '".$_GET['csro']. "'";
	}
	
	if($_GET['work_status']){
	    $conditions .= " AND s.work_status = '".$_GET['work_status']. "'";
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
	
	if($_GET['status']){
		if($_GET['status'] == 'ACTIVE'){
	        $conditions .= " AND s.status IN ('ACTIVE', 'suspended') ";
		}
		
		if($_GET['status'] == 'INACTIVE'){
	        $conditions .= " AND  s.status IN ('terminated', 'resigned') ";
		}
	}

$SEARCH_RESULTS =array();
$total_num_count_asl=0;
$total_num_count_back_order=0;
$total_num_count_replacement=0;
$total_num_count_customs =0;
$total_num_count_inhouse=0;
$total_num_count_trial=0;

foreach($DATE_SEARCH as $date_search_str){
	$date = new DateTime($date_search_str);
	$start_date_search_str = $date->format("Y-m-01 00:00:00");
	$finish_date_search_str = $date->format("Y-m-t 23:59:59");
	//echo sprintf('%s => %s<br>' , $start_date_search_str, $finish_date_search_str ) ;
	
	$data['date_search_str'] = $date_search_str;
	
	//service_type=ASL
    $sql = "SELECT COUNT(s.id)AS num_count_asl  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='ASL'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	//echo $sql."<br>";
	$num_count_asl = $db->fetchOne($sql);
	$data['num_count_asl'] = $num_count_asl;
	$total_num_count_asl = $total_num_count_asl + $num_count_asl;
	
	//service_type=Back Order
    $sql = "SELECT COUNT(s.id)AS num_count_back_order  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Back Order'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_back_order = $db->fetchOne($sql);
	$data['num_count_back_order'] = $num_count_back_order;
	$total_num_count_back_order = $total_num_count_back_order + $num_count_back_order;
	
	
	//service_type=Replacement
    $sql = "SELECT COUNT(s.id)AS num_count_replacement  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Replacement'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_replacement = $db->fetchOne($sql);
	$data['num_count_replacement'] = $num_count_replacement;
    $total_num_count_replacement = $total_num_count_replacement + $num_count_replacement;	
	
	//service_type=Customs
    $sql = "SELECT COUNT(s.id)AS num_count_customs  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Customs'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_customs = $db->fetchOne($sql);
	$data['num_count_customs'] = $num_count_customs;
	$total_num_count_customs = $total_num_count_customs + $num_count_customs;
	
	//service_type=Inhouse
    $sql = "SELECT COUNT(s.id)AS num_count_inhouse  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Inhouse'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_inhouse = $db->fetchOne($sql);
	$data['num_count_inhouse'] = $num_count_inhouse;
    $total_num_count_inhouse = $total_num_count_inhouse + $num_count_inhouse;
	
	//service_type=Trial
    $sql = "SELECT COUNT(s.id)AS num_count_inhouse  FROM subcontractors s JOIN leads l ON l.id = s.leads_id LEFT JOIN recruiter_staff rs ON rs.userid = s.userid WHERE s.service_type='Trial'  AND s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions.";"; 
	$num_count_trial = $db->fetchOne($sql);
	$data['num_count_trial'] = $num_count_trial;
    $total_num_count_trial = $total_num_count_trial + $num_count_trial;
	
	$data['num_count'] = $num_count_asl + $num_count_back_order + $num_count_replacement + $num_count_customs + $num_count_inhouse + $num_count_trial;
	$total_num_count = $total_num_count + $data['num_count']; 
	array_push($SEARCH_RESULTS, $data);

}


$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");


//put csv header
$data =array(
	'Month / Year', 
	'Custom', 
	'Replacement',
	'Inhouse',
	'Backorder', 
	'ASL',  
);
fputcsv($handle, $data);

foreach ($SEARCH_RESULTS as $line) {
	$date = new DateTime($line['date_search_str']);
	$date_search_str = $date->format("Y-m");
	$record = array(
		$date_search_str,
		$line['num_count_customs'],
		$line['num_count_replacement'],
		$line['num_count_inhouse'],
		$line['num_count_back_order'],
		$line['num_count_asl'],
		$line['num_count_trial'],
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