<?php
//  2012-05-14  Normaneil E. Macutay <normanm@remotestaff.com.au>
//  -   initial hack
//echo $page_status;exit;

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
//echo $sql;	
$admin = $db->fetchRow($sql);

if($admin['export_staff_list'] == 'N'){
    
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
	    'Staff Address', 
	    'Staff Contact Details', 
        'Client  Name',
        'Client Company Name',
        'Client Company Address',
        'Start Time',
        'Finish Time',
	    'Staff Monthly Rate',
	    'Client Monthly Rate',
		'CSRO / Team',
		'Contract Length',
		'Status',
		'Starting Date',
		'Contract End Date',
		'Reason',
		'Reason Type',
		'Replacement Request',
		'Work Hours'
    );
	

	
    fputcsv($handle, $data);
	$code = "-";
	foreach ($staffs as $line) {
	    if($line['starting_date']){
		    $date = new DateTime($line['starting_date']);
		    $starting_date = $date->format("F j, Y");
	    }
		if($line['staff_currency_id']){
		    $sql = $db->select()
	            ->from('currency_lookup', 'code')
		        ->where('id=?', $line['staff_currency_id']);
	        $code = $db->fetchOne($sql);
		}
		$team_name = "";
		if($line['csro_id']){
		    $sql = "SELECT r.team_id, r.member_position, t.team FROM recruitment_team_member r JOIN recruitment_team t ON t.id = r.team_id WHERE admin_id =".$line['csro_id'];
			$team = $db->fetchRow($sql);
			$team_name = "/ ".$team['team'];
		}
		
		if($line['leads_id'] == '11' and $admin['view_inhouse_confidential'] == 'N'){
			$staff_salary='confidential';
		}else{
			$staff_salary=sprintf('%s %s', $code, $line['php_monthly']);
		}
		$record = array(
		    $line['userid'], 
            sprintf('%s %s', $line['fname'],$line['lname']) ,
			$line['job_designation'],
			$line['work_status'],
			$line['prepaid'],
		    $line['email'],
		    sprintf('%s %s %s %s %s', $line['address1'],$line['city'],$line['postcode'],$line['state'],$line['country_id']),
		    sprintf('%s-%s / %s-%s',$line['tel_area_code'],$line['tel_no'],$line['handphone_country_code'],$line['handphone_no']) ,
            $line['client_name'],
            $line['company_name'],
            $line['company_address'],
            sprintf("%s %s / %s %s", $line['client_timezone'], ConvertTime($line['client_timezone'], $line['client_timezone'] , $line['client_start_work_hour']), $line['staff_working_timezone'], ConvertTime($line['client_timezone'], $line['staff_working_timezone'] , $line['client_start_work_hour'])),
            sprintf("%s %s / %s %s", $line['client_timezone'], ConvertTime($line['client_timezone'], $line['client_timezone'] , $line['client_finish_work_hour']), $line['staff_working_timezone'], ConvertTime($line['client_timezone'], $line['staff_working_timezone'] , $line['client_finish_work_hour'])),
		    $staff_salary,
		    sprintf('%s %s', $line['currency'], $line['client_price']),
			sprintf('%s %s %s' , $line['admin_fname'], $line['admin_lname'], $team_name),
			$line['duration'],
			$line['contract_status'],
			$starting_date,
        );
		//if($page_status == 'INACTIVE'){
		    array_push($record, $line['staff_contract_finish_date']);
		    array_push($record, $line['reason']);
			array_push($record, $line['reason_type']);
			array_push($record, $line['replacement_request']);
			array_push($record, $line['total_log_hour']);
			
		//}
		
        fputcsv($handle, $record);
		
	}	
		
		
		
$filename = "SUBCONTRACTORS_STAFF_SHIFT_DETAILS_".basename($tmpfname . ".csv");
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
	$output = "Admin ".sprintf('#%s %s %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'])." exported ".$page_status." Subcon list Filename : ".$filename;
	$mail->addTo('admin@remotestaff.com.au', 'Admin');
	$mail->addBcc('normanm@remotestaff.com.au', 'Normaneil');
	
	$myImage = file_get_contents($tmpfname);
	$at = new Zend_Mime_Part($myImage);
	$at->type        = 'application/octet-stream';
	$at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
	$at->encoding = Zend_Mime::ENCODING_BASE64;
	$at->filename    = $filename;
	$mail->addAttachment($at);
}else{
	$output = "TEST Admin ".sprintf('#%s %s %s', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'])." exported ".$page_status." Subcon list Filename : ".$filename;
	$mail->addTo('devs@remotestaff.com.au', 'Devs');
}

$mail->setSubject($output);
$mail->setBodyHtml($output);
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