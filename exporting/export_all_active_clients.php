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

/*
$attachments_array =NULL;
$bcc_array=array('devs@remotestaff.com.au');
$cc_array = NULL;
$from = 'No Reply<noreply@remotestaff.com.au>';
$html = NULL;
$subject = "Exporting of Active Clients List is disabled.";
$text = sprintf('Admin #%s %s %s is trying to export All Active Clients list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
$to_array = array('admin@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
die("Exporting of Active Clients List is disabled.");
*/

if (in_array($_SESSION['admin_id'], $admin_with_permission) == False) {
    	
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Permission Denied. Active Clients List Exporting";
    $text = sprintf('Admin #%s %s %s is trying to export All Active Clients list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Exporting of Active Clients List Permission Denied.");
	
}



$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");
	
	
//put csv header
$data =array(
    'Client ID',
	'Client Name',
	'Email',
	'CSRO',
	'Hiring Coordinator',
	'Staffing Consultant',
	'Address',
	'No. of Staff',
	'Active Staffs'
);

fputcsv($handle, $data);

$sql = "SELECT DISTINCT(leads_id), fname, lname, email, csro_id, hiring_coordinator_id, a.admin_fname, a.admin_lname, company_address FROM subcontractors s LEFT JOIN leads l ON l.id = s.leads_id LEFT JOIN admin a ON a.admin_id = l.hiring_coordinator_id WHERE s.status IN ('ACTIVE', 'suspended') ORDER BY l.fname;";
$clients = $db->fetchAll($sql);

foreach($clients as $client){
	$sql = "SELECT CONCAT(p.fname,' ',p.lname)AS subcon FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid WHERE s.status IN ('ACTIVE', 'suspended') AND s.leads_id = ".$client['leads_id']." ORDER BY p.fname;";
	$staffs = $db->fetchAll($sql);
	
	$staffs_str="";
	if(count($staffs) > 0){
		foreach($staffs as $staff){
			$staffs_str .=sprintf('%s, ', $staff['subcon']);			
		}
		$staffs_str=substr($staffs_str,0,(strlen($staffs_str)-2));
	}
	
	$record = array(
		$client['leads_id'],
		$client['fname']." ".$client['lname'],
		$client['email'],
		$client['csro_id'],
		$client['hiring_coordinator_id'],
		$client['admin_fname']." ".$client['admin_lname'],
		$client['company_address'],
		count($staffs),
		$staffs_str
	);
	
	fputcsv($handle, $record);
}

$filename ="Remotestaff_Active_Clients_with_Active_Subcon_".basename($tmpfname . ".csv");


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
$subject = "Active Clients Exporting";
$text = sprintf('Admin #%s %s %s exported All Active Clients list', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname']);
$to_array = array('admin@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);

exit;
?>