<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
require('../tools/CouchDBMailbox.php');

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$subject = $_REQUEST["subject"];
$message = $_REQUEST["message"];
$template = $_REQUEST["template"];
$admin_id = $_SESSION['admin_id'];


//START: send email
	
	//start: select an staff
	$checker = 0;
	$admin_id = $_SESSION['admin_id'];
	$max = $db->fetchOne($db->select()->from(array("sm"=>"staff_mass_mail_logs"), array(new Zend_Db_Expr("MAX(batch) AS batch")))->where("admin_id = ?", $admin_id));
	$sql = $db->select()->from(array("sm"=>"staff_mass_mail_logs"), array("sm.id AS staff_mass_mail_log_id", "sm.userid", "sm.date_created", "sm.waiting AS waiting", "sm.finish AS finish", "sm.date_updated AS mass_emailing_date_executed"))
			->joinInner(array("pers"=>"personal"), "pers.userid = sm.userid", array("pers.fname", "pers.lname", "pers.email", "pers.mass_responder_code", "pers.datecreated"))
			->where("sm.waiting = 1")->where("sm.finish = 0")
			->where("sm.batch = ?", $max)
			->order("sm.date_updated DESC")
			->where("sm.admin_id = ?", $_SESSION["admin_id"])
			->limit(1);
	$personal = $db->fetchRow($sql);
	
	/*
	$personal = $db->fetchRow("SELECT userid, lname, fname, email FROM personal WHERE mass_emailing_status='WAITING' LIMIT 1");
	foreach($personal as $p)
	{
		$userid = $p['userid'];
		$lname = $p['userid'];
		$fname = $p['fname'];
		$email = $p['email'];
		$email = str_replace(" ", "", $email);
		$checker = 1;
	}
	*/
	if ($personal){
		$userid = $personal["userid"];
		$lname = $personal["lname"];
		$fname = $personal["fname"];
		$email = $personal["email"];
		$date_created = date("F d, Y", strtotime($personal["datecreated"]));
		$email = str_replace(" ", "", $email);
		$staff_mass_mail_log_id = $personal["staff_mass_mail_log_id"];
		
		
		while(true){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
			$rand_pw = '';    
			for ($p = 0; $p < 10; $p++) {
				$rand_pw .= $characters[mt_rand(0, strlen($characters))];
			}
			$mass_responder_code = sha1($rand_pw);
			$hasPersonal = $db->fetchRow($db->select()->from("personal")->where("mass_responder_code = ?", $mass_responder_code));
			if (!$hasPersonal){
				$db->update("personal", array("mass_responder_code"=>$mass_responder_code), $db->quoteInto("userid = ?", $userid));						
				$exchange = 'expire_mass_responder_code';
			    $queue = 'expire_mass_responder_code';
			    $consumer_tag = 'consumer';
				$conn = new AMQPConnection(MQ_HOST, MQ_PORT,MQ_USER, MQ_PASS, MQ_VHOST);
				$ch = $conn->channel();
				$ch->queue_declare($queue, false, true, false, false);
				$ch->exchange_declare($exchange, 'direct', false, true, false);
				$ch->queue_bind($queue, $exchange);
				
				$msg_body =json_encode(array("script"=>"/portal/recruiter/staff_mass_emailing_sending_new.php", "userid"=>$userid, "scheduled_date"=>date("Y-m-d H:i:s",strtotime("+3 day", strtotime(date("Y-m-d H:i:s")))), "mass_responder_code"=>$mass_responder_code));
				$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
				$ch->basic_publish($msg, $exchange);
				$ch->close();
				$conn->close();
				
				break;
			}

		}
	
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
		if ($template=="blank"){
			$body = $message."<br /><br />".$signature_template; 
		}else if ($template=="your_job_application"){
		
			
			$message = str_replace("{{firstname}}", $fname, $message);
			$message = str_replace("{{lastname}}", $lname, $message);
			$message = str_replace("{{date_registered}}", $date_created, $message);
			$message = str_replace("{{current_job_openings_link}}", "<a href='http://www.remotestaff.com.ph/jobopenings.php?jr_cat_id=1&category_id=4' target='_blank' style='color:#fff'>Current Job Openings</a>", $message);
			if (TEST){
				$message = str_replace("{{base}}", "http://test.remotestaff.com.au", $message);
				$autolog = "<a href='http://test.remotestaff.com.au/portal/jobseeker/autologin.php?c=$mass_responder_code' target='_blank' style='color:#fff'>CLICK HERE</a>";
				$inactive_link = "<a href='http://test.remotestaff.com.au/portal/jobseeker/in.php?c=$mass_responder_code' target='_blank' style='color:#fff'>CLICK HERE</a>";
			
			}else{
				$message = str_replace("{{base}}", "http://remotestaff.com.au", $message);
				$autolog = "<a href='http://remotestaff.com.au/portal/jobseeker/autologin.php?c=$mass_responder_code' target='_blank' style='color:#fff'>CLICK HERE</a>";
				$inactive_link = "<a href='http://remotestaff.com.au/portal/jobseeker/in.php?c=$mass_responder_code' target='_blank' style='color:#fff'>CLICK HERE</a>";
			}
			$message = str_replace("{{click_here_link_auto_log}}", $autolog, $message);
			$message = str_replace("{{click_here_link_mark_inactive}}", $inactive_link, $message);
			
			$body = $message; 
		
		}
		$attachments_array = NULL;
		$bcc_array = array();
		$cc_array = array();
		$sender =  "Remote Staff Recruitment<recruitment@remotestaff.com.au>";
		$reply = $name."<".$admin_email.">";
		$from = "Remote Staff Recruitment<recruitment@remotestaff.com.au>";
		$html = $body;
		$text = NULL;
		if (TEST){
			$to_array = array("devs@remotestaff.com.au");
		}else{
			$to_array = array($email);			
		}

		
		
		SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array, $sender,$reply );

		$date_executed = date("Y-m-d")." ".date("H:i:s");
		$data = array('waiting' => 1 , 'finish' => 1, 'date_updated'=>$date_executed);
		$where = "id = ".$staff_mass_mail_log_id;	
		$db->update('staff_mass_mail_logs' , $data , $where);	
		
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