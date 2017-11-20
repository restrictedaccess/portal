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


if($_GET['date']){
    $date = new DateTime($_GET['date']);
    $start_date_search_str = $date->format("Y-m-01");
    $finish_date_search_str = $date->format("Y-m-t");
}else{
	$from=sprintf('%s-01', $_GET['from']);
	$to=sprintf('%s-01', $_GET['to']);
	$start_date_search_str = date('Y-m-01',strtotime($from));
	$finish_date_search_str = date('Y-m-t',strtotime($to));
}
$file_search = sprintf('from_%s_to_%s', $start_date_search_str, $finish_date_search_str );

if($_GET['hm']){
	$conditions .= " AND l.hiring_coordinator_id = '".$_GET['hm']. "'";
}


if($_GET['work_status']){
	$conditions .= " AND s.work_status = '".$_GET['work_status']. "'";
}

if($_GET['recruiter']){
	$conditions .= " AND rs.admin_id = '".$_GET['recruiter']. "'";
}
	
if($_GET['business_partner_id']){
    $conditions .= " AND l.business_partner_id = '".$_GET['business_partner_id']. "'";
}	
	
if($_GET['service_type']){
	$conditions .= " AND s.service_type = '".$_GET['service_type']. "'";
}else{
	$conditions .= " AND ( s.service_type IN ('ASL', 'Back Order', 'Replacement', 'Customs','Inhouse', 'Project Based', 'Trial') ) ";
}

if($_GET['status']){
	if($_GET['status'] == 'ACTIVE'){
        $conditions .= " AND s.status IN ('ACTIVE', 'suspended') ";
	}
		
	if($_GET['status'] == 'INACTIVE'){
        $conditions .= " AND  s.status IN ('terminated', 'resigned') ";
	}
}else{
	$conditions .= " AND s.status IN ('ACTIVE', 'terminated', 'resigned', 'suspended')";
}

if($_GET['include_inhouse_staff'] == 'no'){
    $conditions .= " AND s.leads_id !=11";
}	

$where = "WHERE s.starting_date BETWEEN '".$start_date_search_str."' AND  '".$finish_date_search_str."' ".$conditions;




$sql = "SELECT s.id, s.leads_id, s.userid, s.reason_type, s.reason, s.replacement_request, (l.fname)AS client_fname, (l.lname)AS client_lname, l.email, (p.fname)AS staff_fname, (p.lname)AS staff_lname, l.csro_id, s.status, s.resignation_date, s.date_terminated, s.starting_date, s.service_type, l.business_partner_id, rs.admin_id, l.hiring_coordinator_id,  s.job_designation  FROM subcontractors s JOIN leads l ON l.id = s.leads_id JOIN personal p ON p.userid= s.userid LEFT JOIN recruiter_staff rs ON rs.userid = s.userid $where ORDER BY  p.fname ASC ";
//echo $sql."<br>";
$RESULTS = $db->fetchAll($sql);
$search_results = array();
foreach($RESULTS as $result){
	$comparing_date = "";
	$det = new DateTime($result['starting_date']);
	$starting_date_str = $det->format("Y-m-d");
	if($result['status'] == 'ACTIVE'){
		$comparing_date = date('Y-m-d');
	}
	
	if($result['status'] == 'suspended'){
		$comparing_date = date('Y-m-d');
	}
	
	if($result['status'] == 'resigned'){
		$date = new DateTime($result['resignation_date']);
		$comparing_date = $date->format('Y-m-d');
	}
	if($result['status'] == 'terminated'){
		$date = new DateTime($result['date_terminated']);
		$comparing_date = $date->format('Y-m-d');
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
		'job_designation' => $result['job_designation'],
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
		'reason' => $result['reason'],
		'status' => $result['status'],
		'end_date' => $comparing_date,
		'business_partner' => sprintf('%s %s', $bp['fname'], $bp['lname']),
		'hiring_manager' => sprintf('%s %s', $hiring_manager['admin_fname'], $hiring_manager['admin_lname']),
		'recruiter' => sprintf('%s %s', $recruiter['admin_fname'], $recruiter['admin_lname']),
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
		
		$body = sprintf('Admin #%s %s %s is trying to exporting New Hire Reporting.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
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

    $tmpfname = tempnam(null, null);
    $handle = fopen($tmpfname, "w");
	
	//put csv header
	$data =array(
        'Staff Name', 
        'Job Designation',
        'Client Name',
		'Business Partner',
		'Staffing Consultant',
		'Recruiter',
		'Service Type',
		'Starting Date',
		'Length Of Contract',
		'Contract Status',
		'End Date'
    );
	fputcsv($handle, $data);
	
	foreach ($search_results as $line) {
		$comparing_date = "";
		if($line['status'] == 'resigned'){
		    $comparing_date = $line['staff_contract_finish_date'];
	    }
	    if($line['status'] == 'terminated'){
		    $comparing_date = $line['staff_contract_finish_date'];
	    }
		
		$record = array(
		    sprintf('%s %s', $line['staff_fname'], $line['staff_lname']),
		    $line['job_designation'],
			sprintf('%s %s', $line['client_fname'], $line['client_lname']),
			$line['business_partner'],
			$line['hiring_manager'],
			$line['recruiter'],
			$line['service_type'],
			$line['starting_date'],
			$line['duration'],
			$line['status'],
			$comparing_date,
        );
		
		fputcsv($handle, $record);
	}
	
	$filename = "Remotestaff_New_Hires_Reporting_Details_".basename($tmpfname . ".csv");
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
$smarty->display('new_hires_reporting_details.tpl');
?>