<?php
include './conf/zend_smarty_conf.php';
include './admin_subcon/subcon_function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	header("location:index.php");
	exit;
}

header("location:/portal/django/subcontractors/cancellation_dashboard/");
exit;

$date = new DateTime($_GET['date']);
$start_date_search_str = $date->format("Y-m-01 00:00:00");
$finish_date_search_str = $date->format("Y-m-t 23:59:59");

$file_search = sprintf('from_%s_to_%s', $start_date_search_str, $finish_date_search_str );

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

if($_GET['result']=='resigned'){
	//total no. of resigned contracts
	$where = "WHERE s.status = 'resigned' AND s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions;
}

if($_GET['result']=='terminated'){
	//total no. of terminated contracts
	$where = "WHERE s.status = 'terminated' AND s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions;
}

if($_GET['result']=='yes'){
	$where = "WHERE s.replacement_request='yes' AND (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions;
}

if($_GET['result']=='no'){
	$where = "WHERE s.replacement_request='no' AND (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions;
}

if($_GET['result']=='cancelled'){
	$where = "WHERE (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions;
}

if($_GET['result']=='ended'){
	$where = "WHERE s.replacement_request='no' AND (s.status ='terminated' OR s.status ='resigned') AND ( (s.resignation_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) OR (s.date_terminated BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ) ) ".$conditions;

}


$sql = "SELECT s.id, s.leads_id, s.userid, s.reason_type, s.reason, s.replacement_request, (l.fname)AS client_fname, (l.lname)AS client_lname, l.email, (p.fname)AS staff_fname, (p.lname)AS staff_lname, l.csro_id, s.status, s.resignation_date, s.date_terminated, s.starting_date, s.service_type, l.business_partner_id, rs.admin_id, l.hiring_coordinator_id  FROM subcontractors s JOIN leads l ON l.id = s.leads_id JOIN personal p ON p.userid= s.userid LEFT JOIN recruiter_staff rs ON rs.userid = s.userid $where ORDER BY  p.fname ASC ";
//echo $sql."<br>";
$RESULTS = $db->fetchAll($sql);
$search_results = array();
foreach($RESULTS as $result){
	$comparing_date = "";
	$det = new DateTime($result['starting_date']);
	$starting_date_str = $det->format("Y-m-d");
	if($result['status'] == 'resigned'){
		$date = new DateTime($result['resignation_date']);
		$comparing_date = $date->format('Y-m-d');
	}
	if($result['status'] == 'terminated'){
		$date = new DateTime($result['date_terminated']);
		$comparing_date = $date->format('Y-m-d');
	}
	$csro_name="";
	if($result['csro_id'] != ""){
	    $sql = $db->select()
		    ->from('admin', Array('admin_fname', 'admin_lname'))
			->where('admin_id =?', $result['csro_id']);
		$csro = $db->fetchRow($sql);
		$csro_name = $csro['admin_fname']." ".$csro['admin_lname'];
	}
	
	//bp
	if($result['business_partner_id']!=""){
		$sql=$db->select()
		    ->from('agent', Array('fname', 'lname'))
			->where('agent_no =?', $result['business_partner_id']);
		$bp=$db->fetchRow($sql);	
	}
	
	//recruiter
	if($result['admin_id']){
		$sql=$db->select()
		    ->from('admin', Array('admin_fname', 'admin_lname'))
			->where('admin_id =?', $result['admin_id']);
		$recruiter=$db->fetchRow($sql);
	}
	
	//hiring manager
	if($result['hiring_coordinator_id']){
		$sql=$db->select()
		    ->from('admin', Array('admin_fname', 'admin_lname'))
			->where('admin_id =?', $result['hiring_coordinator_id']);
		$hiring_manager=$db->fetchRow($sql);
	}
	
	$data = array(
        'id' => $result['id'],
		'leads_id' => $result['leads_id'],
		'userid' => $result['userid'],
		'reason_type' => $result['reason_type'],
		'service_type' => $result['service_type'],
		'replacement_request' => $result['replacement_request'],
		'client_fname' => $result['client_fname'],
		'client_lname' => $result['client_lname'],
		'email' => $result['email'],
		'staff_fname' => $result['staff_fname'],
		'staff_lname' => $result['staff_lname'],
		'staff_contract_finish_date' => $comparing_date,
		'starting_date' => $result['starting_date'],
		'duration' => dateDiff($comparing_date,$starting_date_str),
		'duration_in_days' => NumOfDays($comparing_date,$starting_date_str),
		'csro_name' => $csro_name,
		'reason' => $result['reason'],
		'status' => $result['status'],
		'end_date' => $comparing_date,
		'business_partner' => sprintf('%s %s', $bp['fname'], $bp['lname']),
		'recruiter' => sprintf('%s %s', $recruiter['admin_fname'], $recruiter['admin_lname']),
		'hiring_manager' => sprintf('%s %s', $hiring_manager['admin_fname'], $hiring_manager['admin_lname']),
	);
	
	array_push($search_results, $data);
}


//echo "<pre>";
//echo count($search_results)."<BR>";
//print_r($search_results);
//echo "</pre>";
//exit;
if(isset($_POST['export'])){
	
	
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
		die("Cancellation Dashboard Exporting Permission Denied");
	}
	
    $tmpfname = tempnam(null, null);
    $handle = fopen($tmpfname, "w");
	
	//put csv header
	$data =array(
        'Staff Name', 
        'Client Name',
		'Hiring Manager',
		'CSRO',
		'Business Partner',
		'Recruiter',
		'Reason Type',
		'Service Type',
		'Starting Date',
		'Finish Date',
		'Length Of Contract',
		'Number of Days',
	    'Replacement Request', 
	    'Reason',
		
    );
	fputcsv($handle, $data);
	
	foreach ($search_results as $line) {
		$record = array(
		    sprintf('%s %s', $line['staff_fname'], $line['staff_lname']),
			sprintf('%s %s', $line['client_fname'], $line['client_lname']),
			$line['hiring_manager'],
			$line['csro_name'],
			$line['business_partner'],
			$line['recruiter'],
			$line['reason_type'],
			$line['service_type'],
			$line['starting_date'],
			$line['staff_contract_finish_date'],
			$line['duration'],
			$line['duration_in_days'],
			$line['replacement_request'],
			$line['reason'],
			
        );
		
		fputcsv($handle, $record);
	}
	
	$filename = "Remotestaff_Cancellation_Dashboard_Details_".basename($tmpfname . ".csv");
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

}





$smarty->assign('search_results', $search_results);
$smarty->assign('query_string', $_SERVER['QUERY_STRING']);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING']);
$smarty->display('cancellation_dashboard_details.tpl');
?>