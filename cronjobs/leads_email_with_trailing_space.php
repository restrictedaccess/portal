<?php
//  2011-02-04 Normaneil Macutay <normanm@remotestaff.com.au>
//  -   executed with cronjob
//	- 	check all leads email with trailing space

//  2013-05-22 Normaneil Macutay <normanm@remotestaff.com.au>
//  -   automatic updated the lead
//	- 	added couchdb mailbox
//  -   added leads history for changes 

require_once('../conf/zend_smarty_conf.php');
require('../tools/CouchDBMailbox.php');



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
	
$sql = "select id, fname ,lname, email from leads where email like '% ' or email like ' %' ORDER BY fname ASC;";
$leads_email_with_space = $db->fetchAll($sql);

if (count($leads_email_with_space) > 0) {
	
	$leads=array();
	foreach($leads_email_with_space as $lead){
		$resolve = 'needs manual updating';
		
	
		$data['fname'] = ltrim(rtrim(trim($lead['fname'])));
		$data['lname'] = ltrim(rtrim(trim($lead['lname'])));
		$data['email'] = ltrim(rtrim(trim($lead['email'])));
		if($lead['fname']=="" or $lead['fname']==" "){
			$data['fname'] =NULL;
		}
		if($lead['lname']=="" or $lead['lname']==" "){
			$data['lname'] =NULL;
		}
		if($lead['email']=="" or $lead['email']==" "){
			$data['email']=NULL;
		}
		
		$history_changes="";
		$history_changes .= sprintf("fname => %s to %s <br>", $lead['fname'] , $data['fname']);
		$history_changes .= sprintf("lname => %s to %s <br>", $lead['lname'] , $data['lname']);
		$history_changes .= sprintf("email => %s to %s <br>", $lead['email'] , $data['email']);
		
		if($history_changes){
			$changes = array('leads_id' => $lead['id'] ,
						 'date_change' => $ATZ, 
						 'changes' => sprintf('Automatically updated by Cron. Removed trailing white spaces.<br>%s', $history_changes), 
						 'change_by_id' => 5, 
						 'change_by_type' => 'admin');
			$db->insert('leads_info_history', $changes);
		}			 
		
		
		
		$db->update('leads', $data, 'id='.$lead['id']);
		$resolve = 'resolved';

		
		$leads[]=array(
			'id' => $lead['id'],		   
		    'fname' => $data['fname'],
			'lname' => $data['lname'],
			'email' => $data['email'],
			'resolve' => 'resolved'
		);
		
	}
	
	
	
    $smarty = New Smarty();
	$smarty->assign('ctr', count($leads));
	$smarty->assign('leads', $leads);
	$output = $smarty->fetch('leads_email_with_space.tpl');


    //echo $output;exit;
	$attachments_array =NULL;
	$bcc_array=NULL;
    $cc_array = array('devs@remotestaff.com.au');
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = $output;
    $subject = "LEADS WITH EMAIL LEADING and TRAILING SPACES";
    $text = NULL;
    $to_array = array('contract_monitoring@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
}
?>