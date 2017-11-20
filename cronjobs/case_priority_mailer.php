<?php
error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', TRUE);
include '../conf/zend_smarty_conf.php';

include '../ticketmgmt/lib/Utils.php';

$utils = Utils::getInstance();
$utils->db = $db;

$tmpfile = '.case_mailer_is_running';

if (file_exists($tmpfile)) exit;

$fh = fopen($tmpfile, 'w');
fclose($fh);

$query = "SELECT i.id, t.type_name, i.ticket_details, i.date_created, i.day_priority, a.admin_fname
	FROM tickets_info i LEFT JOIN ticket_types t ON t.id=i.ticket_type
	LEFT JOIN admin a ON a.admin_id=i.csro LEFT JOIN user_common_request r ON i.id=r.resetpassword_code
	WHERE ticket_status='Open' and r.id is NULL";
	
// EMAIL BODY
$emailtpl =	"This is to remind you about our pending case with ID <strong>#__CID__</strong>
	that needs to be resolved.<br/><br/>\n
	<table border='0' cellspacing='2' cellpadding='2'>
	<tr><td  style='font-weight:bold'>Case ID</td><td>__CID__</td></tr>\n
	<tr><td  style='font-weight:bold'>Case Type</td><td>__CTYPE__</td></tr>\n
	<tr><td>&nbsp;</td></tr>\n
	<tr><td valign='top' style='font-weight:bold'>Case Details</td><td>__CDET__</td></tr>\n
	<tr><td>&nbsp;</td></tr>\n
	<tr><td  style='font-weight:bold'>Date Created</td><td>__CDATE__</td></tr>\n
	</table><br/><strong>CSRO:</strong> __CSRO__<br/><p>
	Click <a href='http://".$_SERVER['HTTP_HOST']."/portal/ticketmgmt/ticket.php?/ticketinfo/__CID__'>here</a> for more information,
	or you may login to admin <a href='www.remotestaff.com.au/portal/'>portal</a> and select Cases menu link.<br/>
	</p><br/>".
	"This is auto-generated email.";

class ClassNotFoundException extends Exception{}

// handle request and dispatch it to the appropriate controller
try{
	$date_from = strtotime(date("Y-m-d H:i:s"));
	$rows = $db->fetchAll($query);
	$new_result = array();

	for( $i=0, $cnt = count($rows); $i < $cnt; $i++) {
		
		$age_date = $utils->get_age($date_from, (int)$rows[$i]['date_created']);
		
		$age = explode(' ', $age_date);
				
		$ctr = (float)$age[0];
		$warning = $ctr > (int)$rows[$i]['day_priority'] && in_array($age[1], array('days', 'day'));
		
		if( $warning ) {
			$msgbody = $emailtpl;
			//$case_det = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', strlen($rows[$i]['ticket_details']) > 200 ?
			//						 substr($rows[$i]['ticket_details'],0, 200)."..." : $rows[$i]['ticket_details']);
			$case_det = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $rows[$i]['ticket_details']);
			$case_det = preg_replace('/\\\/', '', $case_det);
            $case_det = str_replace("/\s+/", '&nbsp;', $case_det);
			// send email to managers
			$subject = 'Case #'.$rows[$i]['id']. ' has reached its priority days';
			$msgbody = str_replace("__CID__", $rows[$i]['id'], $msgbody);
			$msgbody = str_replace("__CTYPE__", $rows[$i]['type_name'], $msgbody);
			$msgbody = str_replace("__CDET__", $case_det, $msgbody);
			$msgbody = str_replace("__CDATE__", date("m/d/Y H:i:s", $rows[$i]['date_created']), $msgbody);
			$msgbody = str_replace("__CSRO__", $rows[$i]['admin_fname'], $msgbody);
			
			$to_emails = "sharlene@remotestaff.com.au";
			if( $utils->send_email($subject, $msgbody, $to_emails, 'RS Case Priority Mailer', false) ) {
				$values = array('email' => 'Cases', 'resetpassword_code' => $rows[$i]['id'], 'resetpassword_time' => time(),
								'ref_table' => 'tickets_info', 'ip_address' => $_SERVER['REMOTE_ADDR']);
				$db->insert('user_common_request', $values);
			}
			
			
		}
		
		//echo $warning.': '.$rows[$i]['day_priority'].' '.$rows[$i]['age'].' '.$rows[$i]['id'].' - '.$age_date."\n";
	}
	
}
// catch exceptions
catch (ClassNotFoundException $e){
	echo $e->getMessage();
	exit();
}

unlink($tmpfile);
