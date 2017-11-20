<?php
//  2011-11-04 Normaneil Macutay <normanm@remotestaff.com.au>
//  -   executed with cronjob
//	- 	execute scheduled finish staff contract setup by Admin
die("Please check API for execution : /cron-jobs/execute-scheduled-staff-contract-termination/ ");
require_once('../conf/zend_smarty_conf.php');
require_once('../admin_subcon/subcon_function.php');
$smarty = new Smarty();

if($_GET['date_str']){
    $date_str = $_GET['date_str'];
}else{
    $date_str = date("Y-m-d");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

// parse all records who are scheduled today
$sql = "SELECT s.id, s.subcontractors_status, s.scheduled_date, s.subcontractors_id , s.reason, s.reason_type, s.replacement_request, s.added_by_id, (c.id)AS sid ,c.userid, c.leads_id, (p.fname)AS staff_fname, (p.lname)AS staff_lname, (p.email)AS staff_email, p.registered_email, l.fname, l.lname , l.email, s.service_type, c.starting_date, l.csro_id, l.business_partner_id 
FROM subcontractors_scheduled_close_cotract s
JOIN subcontractors c ON c.id = s.subcontractors_id
JOIN personal p ON p.userid = c.userid
JOIN leads l ON l.id = c.leads_id
WHERE s.status = 'waiting' AND s.scheduled_date BETWEEN '".$date_str." 00:00:00' AND '".$date_str." 23:59:59';";
//echo $sql;exit;

$schedules = $db->fetchAll($sql);
if(count($schedules) > 0){
    //id, subcontractors_status, scheduled_date, subcontractors_id, reason, userid, leads_id, staff_fname, staff_lname, staff_email, fname, lname, email
	$history_changes="";
	$changes="";
	foreach($schedules as $schedule){
	    //echo sprintf('%s %s %s<br>', $schedule['id'], $schedule['scheduled_date'], $schedule['staff_fname']);
		$history_changes="";
	    $changes="";
		$details ="";
		
		$status = $schedule['subcontractors_status'];
		$admin_notes = $schedule['reason'];
		$date = new DateTime($client['work_hour']);
	    $end_date_str = $date->format('Y-m-d');
	    $id = $schedule['sid'];
		$admin_id = $schedule['added_by_id'];
		$staff_name = $schedule['staff_fname']." ".$schedule['staff_lname'];
		$reason_type = $schedule['reason_type'];
		$replacement_request = $schedule['replacement_request'];
		$service_type = $schedule['service_type'];
		
		if($status == "resigned"){
	        //SUBMITTED DATA
	        $data = array (
			    'status' => $status,
			    'reason' => $admin_notes,
				'reason_type' => $reason_type,
				'service_type' => $service_type,
				'replacement_request' => $replacement_request,
			    'resignation_date' => $end_date_str." ".$AusTime,
				'end_date' => $end_date_str." ".$AusTime		
		    );
        }		


        if($status == "terminated"){
	        //SUBMITTED DATA
	        $data = array (
			    'status' => $status,
			    'reason' => $admin_notes,
				'reason_type' => $reason_type,
				'service_type' => $service_type,
				'replacement_request' => $replacement_request,
			    'date_terminated' => $end_date_str." ".$AusTime,
				'end_date' => $end_date_str." ".$AusTime		
		    );
        }
		//COMPARE AND GET THE CHANGES
        $history_changes .= sprintf("%s => %s to %s <br>", 'STATUS', 'ACTIVE' , $status);
        $where = "id = ".$id;	
        $db->update('subcontractors', $data , $where);
		
		
		//update the subcontractors_scheduled_close_cotract table
		$data = array('status' => 'executed');
        $where = "id = ".$schedule['id'];	
        $db->update('subcontractors_scheduled_close_cotract', $data , $where);
		
		//HISTORY
        //INSERT NEW RECORD TO THE subcontractors_history
        $changes = "SYSTEM EXECUTED SCHEDULED CONTRACT TERMINATION.<br>";
        $changes .= "<b>Changes made : </b>.".$history_changes;
        $data = array (
		    'subcontractors_id' => $id, 
		    'date_change' => $ATZ, 
		    'changes' => $changes, 
		    'change_by_id' => $admin_id ,
		    'changes_status' => $status,
		    'note' => $admin_notes
	    );
        $db->insert('subcontractors_history', $data);
		
		$date = new DateTime($schedule['starting_date']);	
        $starting_date_str = $date->format("Y-m-d");
		
		//Get the CSRO of client
        $csro_name="";
        $csro_email="";
        if($schedule['csro_id']!=""){
	        $sql=$db->select()
	            ->from('admin')
		        ->where('admin_id =?', $schedule['csro_id']);
	        $csro = $db->fetchRow($sql);
            $csro_name = $csro['admin_fname']." ".$csro['admin_lname'];
            $csro_email = $csro['admin_email'];	
        }
		//Get the Business Partner of client
		$bp_name="";
		$bp_email="";
		if($schedule['business_partner_id'] != ""){
			$sql=$db->select()
	            ->from('agent')
		        ->where('agent_no =?', $schedule['business_partner_id']);
	        $bp = $db->fetchRow($sql);
            $bp_name = $bp['fname']." ".$bp['lname'];
            $bp_email = $bp['email'];	
		}
		
        $client_name = $schedule['fname']." ".$schedule['lname'];
        $comparing_date = date("Y-m-d");
	    $smarty->assign('contract_length', dateDiff($comparing_date,$starting_date_str));
	    $smarty->assign('client_name', $client_name);
	    $smarty->assign('staff_name', $staff_name);
		$smarty->assign('admin_name','Remote Staff System CronJob');
	    $smarty->assign('admin_email','noreply@remotestasff.com.au');
	    $smarty->assign('admin_notes', $admin_notes);
	    $smarty->assign('status', $status);
	    $smarty->assign('reason_type', $reason_type);
	    $smarty->assign('replacement_request', $replacement_request);
	    $smarty->assign('service_type', $service_type);
        $smarty->assign('ATZ', $comparing_date);	
	    $smarty->assign('msg', sprintf("System Executed Scheduled Contract Termination between Client %s and subcon %s.", $client_name, $staff_name));
	    $body = $smarty->fetch('contract_termination_autoresponder.tpl');
	
		$details =  "<h3>SYSTEM EXECUTED SCHEDULED CONTRACT TERMINATION</h3>
			<p>Staff : ".$staff_name."</p>
			<p><hr></p>
			<p>".$changes."</p>
			<p><hr></p>
			<p>Executed by : SYSTEM (CRONJOB)</p>";
		
		$mail = new Zend_Mail('utf-8');
        $mail->setBodyHtml($body);
        $mail->setFrom('noreply@remotestaff.com.au', 'No Reply');

		//SEND MAIL
	    if( TEST){
		    $mail->addTo('devs@remotestaff.com..au', 'DEVS');
		    $subject = sprintf("TEST SYSTEM EXECUTED SCHEDULED CONTRACT TERMINATION BETWEEN CLIENT %s AND SUBCON %s. Recipients[attendance@remotestaff.com.au, %s %s]", $client_name, $staff_name, $csro_email, $bp_email);
			$mail->setSubject($subject);	
	        $mail->send($transport);
	    }else{
		    $mail->addTo('attendance@remotestaff.com.au');
			$mail->addTo('accounts@remotestaff.com.au');
			
		    if($csro_email!=""){
		        $mail->addTo($csro_email, $csro_name);				
		    }
			if($bp_email!=""){
		        $mail->addTo($bp_email, $bp_name);				
		    }
			
			$mail->addBcc('devs@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
			$subject = sprintf("SYSTEM EXECUTED SCHEDULED CONTRACT TERMINATION BETWEEN CLIENT %s AND SUBCON %s.", $client_name, $staff_name);
			$mail->setSubject($subject);	
			$mail->send($transport);
		    
	    }
	    
		
		/*
		//Check if staff still has any active contracts
		$schedule['userid'];
		$schedule['staff_email'];
		$schedule['registered_email'];
		$sql = "SELECT COUNT(id)AS no_of_active_contracts FROM subcontractors s WHERE status IN('suspended', 'ACTIVE') AND userid = ".$schedule['userid'].";";
		$no_of_active_contracts = $db->fetchOne($sql);
		if($no_of_active_contracts == 0){
			//No active contracts
			//Update personal.email
			if($schedule['registered_email']){
				$data = array('email' => $schedule['registered_email']);
				$db->update('personal', $data, 'userid='.$schedule['userid']);
				
				//INSERT history
				$data = array (
					'userid' => $id, 
					'date_change' => $ATZ, 
					'changes' => sprintf('Reverted back staff personal email from %s to %s', $schedule['staff_email'], $schedule['registered_email']), 
					'change_by_id' => 5,
					'change_by_type' => 'ADMIN'
				);
				$db->insert('staff_history', $data);
			}
			
			//send email to Rhine Ramos <rine.r@remotestaff.com.au> to disable rs email of staff
			
			$subject = sprintf("Please disable remotestaff email [ %s ] of staff #%s %s", $schedule['staff_email'], $schedule['userid'], $staff_name);
			$body = sprintf('<p>%s</p><p><strong>Note : </strong>Personal email of staff has already been reverted back from %s to %s</p>', $subject, $schedule['staff_email'], $schedule['registered_email']);
			
			$mail = new Zend_Mail('utf-8');
        	$mail->setBodyHtml($body);
        	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
			if( TEST){
				$subject = sprintf('TEST %s', $subject);
				$mail->addTo('devs@remotestaff.com.au');
			}else{
				$mail->addTo('rine.r@remotestaff.com.au');
				$mail->addBcc('devs@remotestaff.com.au');
			}
			
		    $mail->setSubject($subject);	
	        $mail->send($transport);	
		}
		*/
		
		
	    //echo $body;exit;
		
	} //end foreach
} //endif
?>