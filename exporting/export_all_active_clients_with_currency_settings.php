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
    $subject = "Permission Denied. Active Clients Currency Setting Exporting";
    $text = sprintf('Admin #%s %s %s is trying to export Active Clients Currency Setting.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Exporting of Active Clients Currency Setting Permission Denied.");
	
}



$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");
	
	
//put csv header
$data =array(
    'Client ID',
	'Client Name',
	'Email',
	'Currency',
	'Apply GST'
);

fputcsv($handle, $data);


$currency=NULL;
$gst_applied=NULL;
if(isset($_GET['currency'])){
	if($_GET['currency']){
		$currency = $_GET['currency'];
	}
}
if(isset($_GET['gst_applied'])){
	if($_GET['gst_applied']){
		$gst_applied = $_GET['gst_applied'];
	}
}

$status_search = "s.status IN ('ACTIVE', 'suspended')";
if(isset($_GET['status'])){
	if($_GET['status'] == 'active'){
		$status_search = "s.status IN ('ACTIVE', 'suspended')";
	}else if($_GET['status'] == 'inactive'){
		$status_search = "s.status IN ('resigned', 'terminated')";
	}else{
		$status_search = "s.status IN ('ACTIVE', 'suspended', 'resigned', 'terminated')";
	}
}



//echo $gst_applied;			   

$sql = "SELECT DISTINCT(leads_id), fname, lname, email, company_address FROM subcontractors s LEFT JOIN leads l ON l.id = s.leads_id WHERE ".$status_search." ORDER BY l.fname;";
//echo $sql;exit;
$clients = $db->fetchAll($sql);
//echo "<pre>";
//echo count($clients)."<br>";
//print_r($clients);
//echo "</pre>";
//exit;
$data=array();
foreach($clients as $client){
	$setting = get_client_currency_setting($client['leads_id']);	
    if($currency){
		if(strtoupper($currency) == $setting['currency_code']){
			if($gst_applied){
				if(strtoupper($gst_applied) == $setting['apply_gst']){
					$record = array(
						$client['leads_id'],
						$client['fname']." ".$client['lname'],
						$client['email'],
						$setting['currency_code'],
						$setting['apply_gst']
					);
					//array_push($data, $record);
					fputcsv($handle, $record);
				}
			}else{
				$record = array(
					$client['leads_id'],
					$client['fname']." ".$client['lname'],
					$client['email'],
					$setting['currency_code'],
					$setting['apply_gst']
				);
				//array_push($data, $record);
				fputcsv($handle, $record);
			}
		}
	}else{
		$record = array(
			$client['leads_id'],
			$client['fname']." ".$client['lname'],
			$client['email'],
			$setting['currency_code'],
			$setting['apply_gst']
		);
		//array_push($data, $record);
		fputcsv($handle, $record);
	}
	
}

$filename ="Remotestaff_Active_Clients_Currency_Setting_".basename($tmpfname . ".csv");


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
$subject = "Active Clients Currency Setting";
$text = sprintf('Admin #%s %s %s exported Active Clients Currency Setting. %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'], $script_name);
$to_array = array('admin@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);




//echo "<pre>";
//echo count($data)."<br>";
//print_r($data);
//echo "</pre>";

exit;
?>