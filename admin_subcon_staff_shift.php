<?php
//  2010-04-01  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   added clients address
//  2010-03-12  Normaneil Macutay <normanm@remotestaff.com.au>
//  -   added staff contact details , address and email 
//  2010-03-03  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   initial hack


require_once("conf/zend_smarty_conf.php");
include 'function.php';

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $admin_id);
$admin = $db->fetchRow($sql);

if($admin['manage_staff_invoice'] == 'N'){
    
	$body = sprintf('Admin #%s %s %s is trying to export subcontractors list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	if(!TEST){
	    $mail->addTo('admin@remotestaff.com.au', 'Admin');
		$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
	    $mail->setSubject("Subcontractor List Export Permission Alert.");
	}else{
	    $mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("TEST Subcontractor List Export Permission Alert.");
	}	
	//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
	//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	
	$mail->send($transport);
	die("Subcontractors List Export Permission Alert. Exporting cannot be access.");
	
}

$sql = $db->select()
            ->distinct()
            ->from(array('s' => 'subcontractors'), array('userid', 'starting_hours', 'ending_hours','starting_date', 'client_timezone', 'client_start_work_hour', 'client_finish_work_hour', 'currency', 'staff_currency_id', 'client_price', 'php_monthly'))
            ->joinLeft(array('p' => 'personal'), 
                's.userid = p.userid', 
                array(
                    'staff_lname' => 'lname',
                    'staff_fname' => 'fname',
                    'staff_address' => 'address1',
                    'staff_city' => 'city',
                    'staff_postcode' => 'postcode',
                    'staff_state' => 'state',
                    'staff_country_id' => 'country_id',
                    'staff_tel_code' => 'tel_area_code',
                    'staff_tel_no' => 'tel_no',
                    'staff_handphone_country_code' => 'handphone_country_code',
                    'staff_handphone_no' => 'handphone_no',
                    'staff_email' => 'email'
                ))
            ->joinLeft(array('l' => 'leads'), 's.leads_id = l.id',
                array(
                    'client_lname' => 'lname',
                    'client_fname' => 'fname',
                    'company_name' => 'company_name',
                    'company_address' => 'company_address'
                ))
            ->where('s.status = "ACTIVE"')
            //->order(array('p.fname', 'p.lname'));
			->order('starting_date DESC');

$staff_shifts = $db->fetchAll($sql);

$tmpfname = tempnam(null, null);

$handle = fopen($tmpfname, "w");

//put csv header
fputcsv($handle, array(
    'Userid', 
    'Staff First Name', 
    'Staff Last Name',
	'Staff Email', 
	'Staff Address', 
	'Staff Contact Details', 
    'Client First Name',
    'Client Last Name',
    'Client Company Name',
    'Client Company Address',
	'Starting Date',
    'Start Time',
    'Finish Time',
	'Staff Monthly Rate',
	'Client Monthly Rate'
    ));

foreach ($staff_shifts as $line) {
	if($line['starting_date']){
		$date = new DateTime($line['starting_date']);
		$starting_date = $date->format("F j, Y");
	}
	
	$sql = $db->select()
	    ->from('currency_lookup', 'code')
		->where('id=?', $line['staff_currency_id']);
	$code = $db->fetchOne($sql);	
	
    $record = array($line['userid'], 
        $line['staff_fname'],
        $line['staff_lname'],
		$line['staff_email'],
		$line['staff_address'].' '.$line['staff_city'].' '.$line['staff_postcode'].' '.$line['staff_state'].' '.$line['staff_country_id'],
		$line['staff_tel_code'].'-'.$line['staff_tel_no'].' / '.$line['staff_handphone_country_code'].'-'.$line['staff_handphone_no'] ,
        $line['client_fname'],
        $line['client_lname'],
        $line['company_name'],
        $line['company_address'],
		$starting_date,
        sprintf("%s %s", $line['client_timezone'], ConvertTime($line['client_timezone'], $line['client_timezone'] , $line['client_start_work_hour'])),
        sprintf("%s %s", $line['client_timezone'], ConvertTime($line['client_timezone'], $line['client_timezone'] , $line['client_finish_work_hour'])),
		sprintf('%s %s', $code, $line['php_monthly']),
		sprintf('%s %s', $line['currency'], $line['client_price']),
    );
    fputcsv($handle, $record);
}

$filename = "STAFF_SHIFT_DETAILS_".basename($tmpfname . ".csv");
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
//header('Content-Disposition: attachment; filename=STAFF_SHIFT_DETAILS'.$tmpfname . ".csv");
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));

//send email notify devs
$mail = new Zend_Mail('utf-8');
$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');


if(! TEST){
	$output = "Admin ".sprintf('#%s %s %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'])." is exporting Subcon list Filename : ".$filename;
	$mail->addTo('admin@remotestaff.com.au', 'Admin');
	//$mail->addBcc('devs@remotestaff.com.au', 'Devs');
}else{
	$output = "TEST Admin ".sprintf('#%s %s %s', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'])." is exporting Subcon list Filename : ".$filename;
	$mail->addTo('devs@remotestaff.com.au', 'Devs');
}

$mail->setSubject($output);
$mail->setBodyHtml($output);
$myImage = file_get_contents($tmpfname);
			$at = new Zend_Mime_Part($myImage);
			$at->type        = 'application/octet-stream';
			$at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
			$at->encoding = Zend_Mime::ENCODING_BASE64;
			$at->filename    = $filename;
			$mail->addAttachment($at);
$mail->send($transport);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);


//send notification to devs
$mail = new Zend_Mail('utf-8');
$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
$mail->setSubject("NOTIFICATION : ".$output);
$mail->setBodyHtml($output);
$mail->addTo('devs@remotestaff.com.au', 'Devs');
$mail->send($transport);
?>