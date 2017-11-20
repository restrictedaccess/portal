<?php
//  2013-03-04 Normaneil Macutay <normanm@remotestaff.com.au>
//  -   executed with cronjob
//	- 	execute scheduled staff contract salary updates
require_once('../conf/zend_smarty_conf.php');
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
$sql = "SELECT * FROM subcontractors_scheduled_subcon_rate s WHERE s.status = 'waiting' AND s.scheduled_date BETWEEN '".$date_str." 00:00:00' AND '".$date_str." 23:59:59';";
//echo $sql;exit;

$schedules = $db->fetchAll($sql);
if(count($schedules) > 0){
    foreach($schedules as $sched){
		
		$history_changes="";
		$sql = $db->select()
		    ->from('subcontractors', Array('leads_id', 'userid', 'php_monthly', 'php_hourly', 'work_status', 'job_designation'))
			->where('id=?', $sched['subcontractors_id']);
		$subcon = $db->fetchRow($sql);
		
		//Client details
		$sql =$db->select()
		    ->from('leads', Array('fname', 'lname', 'email', 'csro_id'))
			->where('id=?', $subcon['leads_id']);
		$client = $db->fetchRow($sql);
		
		//Staff
		$sql =$db->select()
		    ->from('personal', Array('fname', 'lname', 'email'))
			->where('userid=?', $subcon['userid']);
		$staff = $db->fetchRow($sql);
		
		//Client CSRO
		if($client['csro_id']){
			$sql = $db->select()
			    ->from('admin', Array('admin_fname', 'admin_lname', 'admin_email') )
				->where('admin_id =?', $client['csro_id']);
			$csro = $db->fetchRow($sql);	
		}
		
		//Scheduled by
		$sql = $db->select()
		    ->from('admin', Array('admin_fname', 'admin_lname', 'admin_email') )
			->where('admin_id =?', $sched['added_by_id']);
		$created_by = $db->fetchRow($sql);
		
		
        $data=array(
            'php_monthly' => $sched['rate'],
			'work_status' => $sched['work_status'],
        );
		
		if($sched['work_status'] == 'Full-Time'){
			$php_hourly = (((($sched['rate'] * 12)/52)/5)/8);
		}else{
			$php_hourly = (((($sched['rate'] * 12)/52)/5)/4);
		}
		
		$php_hourly = number_format($php_hourly ,2 ,'.' ,',');
		
		
		
		//Set the history
		if($sched['work_status'] != $subcon['work_status']){
			$history_changes .=sprintf("STAFF WORKING STATUS from %s to %s<br>" , $subcon['work_status'], $sched['work_status']);
		}
		
		if($sched['rate'] != $subcon['php_monthly']){
			$history_changes .=sprintf("STAFF MONTHLY SALARY from %s to %s<br>" , $subcon['php_monthly'], $sched['rate']);
		}
		
		if($php_hourly != $subcon['php_hourly']){
			$history_changes .=sprintf("STAFF HOURLY SALARY from %s to %s<br>" , $subcon['php_hourly'], $php_hourly);
		}
		
		
		
		
		
		//update subcontractors
		$where = "id = ".$sched['subcontractors_id'];
		$db->update('subcontractors', $data, 'id='.$sched['subcontractors_id']);
		
		//update schedule
		$data = array('status' => 'executed');
        $where = "id = ".$sched['id'];	
        $db->update('subcontractors_scheduled_subcon_rate', $data , $where);
		
		
		//HISTORY
        //INSERT NEW RECORD TO THE subcontractors_history
        $changes = "SYSTEM EXECUTED SCHEDULED STAFF CONTRACT SALARY UPDATES.<br>";
        $changes .= "<b>Changes made : </b>.".$history_changes;
        $data = array (
		    'subcontractors_id' => $sched['subcontractors_id'], 
		    'date_change' => $ATZ, 
		    'changes' => $changes, 
		    'change_by_id' => '5' ,
		    'changes_status' => 'updated',
		    'note' => 'Cron System Executed.'
	    );
        $db->insert('subcontractors_history', $data);
		//echo $history_changes;
		
		//Send email
		//Email recipient
		$recipients=array('admin@remotestaff.com.au', $csro['admin_email'], $created_by['admin_email']);
		
		$smarty->assign('sched', $sched);
		$smarty->assign('client', $client);
		$smarty->assign('staff', $staff);
		$smarty->assign('subcon', $subcon);
		$smarty->assign('created_by', $created_by);
		
		
	    
		
		$mail = new Zend_Mail('utf-8');    		
        $mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
		
		
		
	    if( TEST){
		    $mail->addTo('devs@remotestaff.com.au', 'DEVS');
			$smarty->assign('recipients', $recipients);
		    $subject = sprintf("TEST Executed Scheduled Staff Contract Updates of #[%s] %s %s.", $sched['subcontractors_id'], $staff['fname'], $staff['lname']);
	    }else{
           
			foreach($recipients as $recipient){
				$mail->addTo($recipient, $recipient);
			}
			$mail->addBcc('devs@remotestaff.com.au');
	        $subject = sprintf("TEST Executed Scheduled Staff Contract Updates of #[%s] %s %s.", $sched['subcontractors_id'], $staff['fname'], $staff['lname']);		    
	    }
		
		
		
		$body = $smarty->fetch('scheduled_staff_contract_salary_updates.tpl');
		$mail->setBodyHtml($body);
		$mail->setSubject($subject);	
	    $mail->send($transport);
		//echo $body;
    }
}
?>