<?php
include('../conf/zend_smarty_conf.php');
if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

if($admin['export_subconlist_reporting'] == 'N'){
    
	$body = sprintf('Admin #%s %s %s is trying to export %s Leads Monthly Reporting list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'], $page_status);
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	if(!TEST){
	    $mail->addTo('devs@remotestaff.com.au', 'Admin');
		//$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
	    $mail->setSubject("ALERT Leads Monthly Reporting List Exporting Permission Denied.");
	}else{
	    $mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("TEST ALERT Leads Monthly Reporting List Exporting Permission Denied");
	}	
	//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
	//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	
	$mail->send($transport);
	die("Leads Monthly Reporting List Exporting Permission Denied.");
	
}



//$MONTH_NUM=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$MONTH_STR=array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');

$year = $_GET['year'];
if($year == ""){
	$year = date('Y');
}

$MONTLY_RESULTS=array();
$total_count=0;
foreach(array_keys($MONTH_STR) as $array_key){
	$sql = "SELECT COUNT(id)AS month_num_count FROM leads l WHERE MONTH(timestamp)='".$MONTH_STR[$array_key]."' AND YEAR(timestamp)='".$year."';";
	$month_num_count = $db->fetchOne($sql);
	$data=array(
	    'month_name' => $array_key,
		'month_num' => $MONTH_STR[$array_key],
		'month_num_count' => $month_num_count,
	);
	$MONTLY_RESULTS[] = $data;
	$total_count = $total_count + $month_num_count;
}


$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");


	
//put csv header
$data =array(
    'Month',
	'Year',
    'Count', 
);
	
fputcsv($handle, $data);
foreach ($MONTLY_RESULTS as $line) {		
    $record = array(
		$line['month_name'],
		$year,
		$line['month_num_count']
    );	
    fputcsv($handle, $record);		
}	
		
		
		
$filename = "leads_monthly_reporting_".basename($tmpfname . ".csv");
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