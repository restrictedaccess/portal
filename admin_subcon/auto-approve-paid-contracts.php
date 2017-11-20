<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = 5;

$subcontractors_invoice_setup_id = $_GET['subcontractors_invoice_setup_id'];
if($subcontractors_invoice_setup_id == ""){
     die('subcontractors invoice setup id is missing');
}

function formatTime($time ){
	if($time!=""){
		if(strlen($time) > 2){
			$time_str = $time;
		}else{
			$time_str = $time.":00";
		}
		$time = new DateTime($time_str);
		return $time->format('h:i a');
	}
}


$sql = $db->select()
    ->from('subcontractors_invoice_setup')
	//->where('status=?', 'paid')
	->where('id=?', $subcontractors_invoice_setup_id);
$subcontractors_invoice_setup = $db->fetchRow($sql);

$subcontractors_invoice_setup_status = $subcontractors_invoice_setup['status'];
$subcontractors_invoice_setup_details_id = $subcontractors_invoice_setup_id;
	
if(!$subcontractors_invoice_setup['id']){
     die('unknown invoice setup id');
}

//lead info
$leads_id = $subcontractors_invoice_setup['leads_id'];
$sql = $db->select()
    ->from('leads')
	->where('id=?', $leads_id);
$lead = $db->fetchRow($sql);

//get all subcontractors_temp id
$sql = $db->select()
    ->from('subcontractors_invoice_setup_details')
	->where('subcontractors_invoice_setup_id =?', $subcontractors_invoice_setup_id);
$subcontractors_invoice_setup_details = $db->fetchAll($sql);	

foreach($subcontractors_invoice_setup_details as $detail ){
    
	$id = $detail['subcontractors_id'];
	
	//get the subcontractors_temp details
	$sql = $db->select()
        ->from('subcontractors_temp')
		->where('temp_status !=?', 'deleted')
	    ->where('id = ?', $id);
    $subcontractors_temp = $db->fetchRow($sql);
	if($subcontractors_temp['id'] != ''){

		unset($subcontractors_temp['id']);
		unset($subcontractors_temp['subcontractors_id']);
		unset($subcontractors_temp['temp_status']);
		unset($subcontractors_temp['staff_email']);
		
		$subcontractors_temp['status'] = 'ACTIVE';
		$subcontractors_temp['contract_updated'] = 'y';
		
		
		//insert new record in the subcontractors table
		$db->insert('subcontractors', $subcontractors_temp);
		$subcontractors_id = $db->lastInsertId();
		
		//HISTORY
		//INSERT NEW RECORD TO THE subcontractors_history
		$changes = "SYSTEM AUTOMATICALLY APPROVED CONTRACT";
		$admin_notes = sprintf('System confirmed that %s %s %s already paid for this staff contract', $lead['id'], $lead['fname'], $lead['lname'] );
		$data = array (
			'subcontractors_id' => $subcontractors_id, 
			'date_change' => $ATZ, 
			'changes' => $changes, 
			'change_by_id' => $admin_id ,
			'changes_status' => 'approved',
			'note' => $admin_notes
			);
		$db->insert('subcontractors_history', $data);
		
		//update the temp table
		$data = array('temp_status' => 'deleted');
		$where = "id = ".$id;	
		$db->update('subcontractors_temp', $data , $where);
		
		$data = array('subcontractors_id' => $subcontractors_id);
		$where = "subcontractors_id = ".$id;	
		$db->update('subcontractors_history', $data , $where);
	
		$sql = $db->select()
			 ->from(array('s' => 'subcontractors'))
			 ->join(array('p' => 'personal'), 'p.userid = s.userid', Array('fname', 'lname', 'email' , 'registered_email', 'skype_id', 'initial_email_password', 'initial_skype_password'))
			 ->join(array('l' => 'leads'), 'l.id = s.leads_id', Array('client_fname' => 'fname', 'client_lname' => 'lname', 'client_email' => 'email'))
			 ->where('s.status =?', 'ACTIVE')
			 ->where('s.id =?', $subcontractors_id);
		$subcon = $db->fetchRow($sql);	
		
		$staff_name = $subcon['fname']." ".$subcon['lname'];
		$staff_email = $subcon['email'];
		$job_designation = $subcon['job_designation'];
		$work_status = $subcon['work_status'];
		$client_name = $subcon['client_fname']." ".$subcon['client_lname'];
		$client_email = $subcon['client_email'];
		$admin_name = 'Remote Staff';
		$admin_email = 'noreply@remotestaff.com.au';
		$registered_email = $subcon['registered_email'];
		$skype = $subcon['skype_id'];
		$staff_email_password = $subcon['initial_email_password'];
		$skype_password  = $subcon['initial_skype_password'];
		$date=date('l jS \of F Y h:i:s A');
		$main_pass="<i>(Your specified password on your jobseeker account)</i>";
		$site = $_SERVER['HTTP_HOST'];
		
		//send email to admin
		$details =  "<h3>SYSTEM AUTOMATIC APPROVED STAFF CONTRACT </h3>
				<p>Staff : ".$staff_name."</p>
				<p>Job Designation : ".$job_designation."</p>
				<p>Working : ".$work_status."</p>
				<p>Client : ".$client_name."</p>
				<p>Approved by : Remote Staff System</p>";
	
	
	
	
		$mail = new Zend_Mail();
		$mail->setBodyHtml($details);
		$mail->setFrom($admin_email, $admin_name);
		
		//SEND MAIL
		if(! TEST){
			//admin email
			$to = 'ricag@remotestaff.com.au'; // replace ricag@remotestaff.com.au
			$fullname = "Rhiza L.";
			$mail->setSubject(" STAFF ".$staff_name." CONTRACT HAS BEEN APPROVED");
		}else{
			$to = 'devs@remotestaff.com.au'; //replace devs@remotestaff.com.au
			$fullname = "Remotestaff Developers";
			$mail->setSubject("TEST STAFF ".$staff_name." CONTRACT HAS BEEN APPROVED");
		}
		$mail->addTo($to, $fullname);
		$mail->send($transport);
		
		
		//autoresponder to staff
		$smarty->assign('date',$date);
		$smarty->assign('staff_name', $staff_name);
		$smarty->assign('staff_email', $staff_email);
		$smarty->assign('main_pass', $main_pass);
		$smarty->assign('site', $site);
		$smarty->assign('skype', $skype);
		$smarty->assign('skype_password', $skype_password);
		$smarty->assign('staff_email_password', $staff_email_password);
		$smarty->assign('client_name', $client_name);
		$smarty->assign('company_name', $company_name);
		$smarty->assign('admin_name', $admin_name);
		$smarty->assign('admin_email', $admin_email);
		$body = $smarty->fetch('staff_autoresponder.tpl');
		
		$mail = new Zend_Mail('utf-8');
		$mail->setBodyHtml($body);
		$mail->setFrom($admin_email, $admin_name);
		
		//SEND MAIL to the STAFF
		if(! TEST){
			
			$mail->addTo($staff_email, $staff_name);
			if($registered_email!=""){
				$mail->addTo($registered_email, $staff_name);
			}
			$mail->addCc('staffsupport@remotestaff.com.ph', 'staffsupport@remotestaff.com.ph');// Adds a recipient to the mail with a "Cc" header
			$mail->setSubject(strtoupper($site)." Welcome to REMOTESTAFF ".$staff_name);
		
		}else{
		
			$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
			if($registered_email!=""){
				$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
			}
			$mail->addCc('staffsupport@remotestaff.com.ph', 'staffsupport@remotestaff.com.ph');// Adds a recipient to the mail with a "Cc" header
			//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
			$mail->setSubject("TEST ".strtoupper($site)." Welcome to REMOTESTAFF ".$staff_name);
		
		}
		$mail->addTo($to, $fullname);
		$mail->send($transport);
		
		//SEND MAIL to the CLIENT
		if($posting_id > 0){
			$query = "SELECT * FROM posting p WHERE id = $posting_id;";
			$resul=$db->fetchRow($query);
			$ads = $result['jobposition'];
		}
		
		
			
		$client_start_work_hour = formatTime($subcon['client_start_work_hour']);
		$client_finish_work_hour  = formatTime($subcon['client_finish_work_hour']);
		
		$start_date_of_leave = explode('-',$subcon['starting_date']);
		$date = new DateTime();
		$date->setDate($start_date_of_leave[0], $start_date_of_leave[1], $start_date_of_leave[2]);
		
		
		$date->modify("+1 month");
		$first_month = $date->format("Y-m-d");
		$end_of_first_month = $date->format('Y-m-t');
		$date->modify("+1 month");
		$third_month = $date->format("Y-m-01");
		$end_of_third_month = $date->format('Y-m-t');
		
		if($registered_domain == 2){
			$department_email = 'clientsupport@remotestaff.co.uk';
		}else if ($registered_domain == 3){
			$department_email = 'clientsupport@remotestaff.biz';
		}else{
			$department_email = 'clientsupport@remotestaff.com.au';
		}
		
		$smarty->assign('department_email', $department_email);
		$smarty->assign('first_month',$first_month);
		$smarty->assign('end_of_first_month',$end_of_first_month);
		$smarty->assign('third_month',$third_month);
		$smarty->assign('end_of_third_month',$end_of_third_month);
		
		$smarty->assign('job_designation',$job_designation);
		$smarty->assign('staff_name',$staff_name);
		$smarty->assign('staff_email',$staff_email);
		$smarty->assign('starting_date',$starting_date);
		$smarty->assign('client_start_work_hour',$client_start_work_hour);
		$smarty->assign('client_finish_work_hour',$client_finish_work_hour);
		$smarty->assign('skype',$skype);
		$smarty->assign('client_name', $client_name);
		$smarty->assign('client_email',$client_email);
		$body = $smarty->fetch('client_autoresponder.tpl');		
		
		
		$mail = new Zend_Mail('utf-8');
		$mail->setBodyHtml($body);
		
		if($registered_domain == 2){
			$mail->setFrom('clientsupport@remotestaff.co.uk', 'clientsupport@remotestaff.co.uk');
		}else if ($registered_domain == 3){
			$mail->setFrom('clientsupport@remotestaff.biz', 'clientsupport@remotestaff.biz');
		}else{
			$mail->setFrom('clientsupport@remotestaff.com.au', 'clientsupport@remotestaff.com.au');
		}
		
		
		if(! TEST){
		
			$mail->setSubject("Confirming ".$staff_name." first day, Work contact details, Tools and others");
			$mail->addTo( $client_email, $client_name);
			if($registered_domain == 2){
				$mail->addTo('clientsupport@remotestaff.co.uk', 'clientsupport@remotestaff.co.uk');
			}else if ($registered_domain == 3){
				$mail->addTo('clientsupport@remotestaff.biz', 'clientsupport@remotestaff.biz');
			}else{
				$mail->addTo('clientsupport@remotestaff.com.au', 'clientsupport@remotestaff.com.au');
			}
		
			
		}else{
			
			$mail->setSubject("TEST Confirming ".$staff_name." first day, Work contact details, Tools and others");
			$mail->addTo( 'devs@remotestaff.com.au', "Remotestaff Developers");
			if($registered_domain == 2){
				$mail->addTo('clientsupport@remotestaff.co.uk', 'clientsupport@remotestaff.co.uk');
			}else if ($registered_domain == 3){
				$mail->addTo('clientsupport@remotestaff.biz', 'clientsupport@remotestaff.biz');
			}else{
				$mail->addTo('clientsupport@remotestaff.com.au', 'clientsupport@remotestaff.com.au');
			}
		}
		
		$mail->send($transport);
	
		//Accounts Autoreponder content
		$body =  "<h3>NEW STAFF CONTRACT </h3>
				  <p>Dear Accounts,</p>
				  <p>There is a new contract set between ".$staff_name." and ".$client_name." .  Start day will be on ".$subcon['starting_date']." Work Schedule is ".$subcon['client_timezone']." ".$client_start_work_hour." to ".$client_finish_work_hour." time. </p>";
		
		
		
		$body .="<p>First month invoice already been issued and paid.</p>";
			
		$mail = new Zend_Mail('utf-8');
		$mail->setBodyHtml($body);
		$mail->setFrom($admin_email, $admin_name);
		
		if(! TEST){
			$to = 'accounts@remotestaff.com.au'; 
			$fullname = "Remotestaff Accounts";
			$mail->setSubject("NEW STAFF CONTRACT");
		}else{
			$to = 'devs@remotestaff.com.au'; 
			$fullname = "Remotestaff Developers";
			$mail->setSubject("TEST NEW STAFF CONTRACT ");
		}
		$mail->addTo($to, $fullname);
		$mail->send($transport);
		
	}	
}
exit;
?>