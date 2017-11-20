<?php
//  2012-05-14  Normaneil E. Macutay <normanm@remotestaff.com.au>
//  -   initial hack
//echo $page_status;exit;
require('./tools/CouchDBMailbox.php');

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $admin_id);
$admin = $db->fetchRow($sql);

if($admin['export_subconlist_reporting'] == 'N'){
    	
	$attachments_array =NULL;
	$bcc_array=NULL;
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "ALERT ".$page_status." Subcontractors List Exporting Permission Denied.";
    $text = sprintf('Admin #%s %s %s is trying to export %s subcontractors list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'], $page_status);
    $to_array = array('devs@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	die($page_status." Subcontractors List Exporting Permission Denied.");
	
}

    $tmpfname = tempnam(null, null);
    $handle = fopen($tmpfname, "w");
	
	
	//put csv header
	$data =array(
        'Userid', 
        'Staff Name', 
		'Job Designation',
		'Staff Working Status',
		'Client Timezone',
		'Flexi',
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
		'Number Of Days',
		'Status',
		'Starting Date',
        'Business Partner',
		'Recruiter',
		'Hiring Manager',
		'Reffered By',
    );
	
	if($page_status == 'INACTIVE'){
	    array_push($data, 'Contract End Date');
	    array_push($data, 'Reason');
		array_push($data, 'Reason Type');
		array_push($data, 'Replacement Request');
	}
	
	
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
		if($line['business_partner_id']!=""){
			$sql=$db->select()
			    ->from('agent', Array('fname', 'lname'))
				->where('agent_no =?', $line['business_partner_id']);
			$bp=$db->fetchRow($sql);	
		}
		if($line['admin_id']){
			$sql=$db->select()
			    ->from('admin', Array('admin_fname', 'admin_lname'))
				->where('admin_id =?', $line['admin_id']);
			$recruiter=$db->fetchRow($sql);
		}
		
		if($line['hiring_coordinator_id']){
			$sql=$db->select()
			    ->from('admin', Array('admin_fname', 'admin_lname'))
				->where('admin_id =?', $line['hiring_coordinator_id']);
			$hiring_manager=$db->fetchRow($sql);
		}
		
		$record = array(
		    $line['userid'], 
            sprintf('%s %s', $line['fname'],$line['lname']) ,
			$line['job_designation'],
			$line['work_status'],
			$line['client_timezone'],
			$line['flexi'],
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
			$line['number_of_days'],
			$line['contract_status'],
			$starting_date,
			sprintf('%s %s', $bp['fname'], $bp['lname']),
			sprintf('%s %s', $recruiter['admin_fname'], $recruiter['admin_lname']),
			sprintf('%s %s', $hiring_manager['admin_fname'], $hiring_manager['admin_lname']),
			$line['reffered_by']
        );
		if($page_status == 'INACTIVE'){
		    array_push($record, $line['staff_contract_finish_date']);
		    array_push($record, $line['reason']);
			array_push($record, $line['reason_type']);
			array_push($record, $line['replacement_request']);
		}
		
        fputcsv($handle, $record);
		
	}	
		
		
		
$filename = $page_status."_STAFF_SHIFT_DETAILS_".basename($tmpfname . ".csv");
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
//header('Content-Disposition: attachment; filename=STAFF_SHIFT_DETAILS'.$tmpfname . ".csv");
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));
		


//CouchDB Mailbox
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
$subject = "Notification Subconlist Exporting.";
$text = "Admin ".sprintf('#%s %s %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'])." exported ".$page_status." Subcon list Filename : ".$filename;
$to_array = array('devs@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);



ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);
?>