<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$subject = $_REQUEST["subject"];
$message = $_REQUEST["message"];
$message = str_replace("\n","<br>",$message);
$admin_id = $_SESSION['admin_id'];


//START: send email
	
	//start: select an staff
	$checker = 0;
	$personal = $db->fetchAll("SELECT userid, lname, fname, email FROM personal WHERE mass_emailing_status='WAITING' LIMIT 1");
	foreach($personal as $p)
	{
		$userid = $p['userid'];
		$lname = $p['userid'];
		$fname = $p['fname'];
		$email = $p['email'];
		$email = str_replace(" ", "", $email);
		$checker = 1;
	}
	//ended: select an staff
	
	//start: email signature
	if($checker == 1)
	{
		$site = $_SERVER['HTTP_HOST'];
		$sql=$db->select()
			->from('admin')
			->where('admin_id = ?' ,$admin_id);
		$a = $db->fetchRow($sql);
		$admin_email = $a['admin_email'];
		$name = $a['admin_fname']." ".$a['admin_lname'];
		$admin_email = $a['admin_email'];
		$signature_company = $a['signature_company'];
		$signature_notes = $a['signature_notes'];
		$signature_contact_nos = $a['signature_contact_nos'];
		$signature_websites = $a['signature_websites'];
		if($signature_notes <> "")
		{
			$signature_notes = "<p><i>$signature_notes</i></p>";
		}
		else
		{
			$signature_notes = "";
		}
		
		if($signature_company!="")
		{
			$signature_company="<br>$signature_company";
		}
		else
		{
			$signature_company="<br>RemoteStaff";
		}
		if($signature_contact_nos!="")
		{
			$signature_contact_nos = "<br>$signature_contact_nos";
		}
		else
		{
			$signature_contact_nos = "";
		}
		if($signature_websites!="")
		{
			$signature_websites = "<br>Websites : $signature_websites";
		}
		else
		{
			$signature_websites = "";
		}
		$signature_template = $signature_notes;
		$signature_template .="<a href='http://$site/$agent_code'>
		<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
		$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
		//ended: email signature
		
		//start: sending
		$body = $message."<br /><br />".$signature_template;  
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom($admin_email, $admin_email);
		if(! TEST)
		{
			$mail->addTo($email, $email);
		}
		else
		{
			$mail->addTo('devs@remotestaff.com.au', 'devs@remotestaff.com.au');
		}
		$mail->setSubject($subject);
		$mail->send($transport);									
		
		$date_executed = date("Y-m-d")." ".date("H:i:s");
		$data = array('mass_emailing_status' => 'SENT' , 'mass_emailing_date_executed' => $date_executed);
		$where = "userid = ".$userid;	
		$db->update('personal' , $data , $where);	
		
		//start: return active data report
		echo $fname." ".$lname." > ".$email." > ".$date_executed;
		//ended: return active data report
	}
	else
	{
		//start: return active data report
		echo "COMPLETED";
		//ended: return active data report
	}
	//ended: sending
	
//ENDED: send email	
?>