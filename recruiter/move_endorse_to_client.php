<?php
//2011-08-11  Roy Pepito <roy.pepito@remotestaff.com.au>

include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

if(!$_SESSION['admin_id']){
	header("location:index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
	echo "This page is for HR usage only.";
	exit;
}


//START: get subcontractor info
$userid = $_REQUEST["userid"]; 
$sql=$db->select()
	->from('personal')
	->where('userid = ?' ,$userid);
$sc = $db->fetchRow($sql);
$fullname = $sc['fname']." ".$sc['lname'];
$subcontructor_email = $sc['email'];	
$subject_value = "Remotestaff: (".$fullname.")";
//ENDED: get subcontractor info


//START: process endorsement
if(@isset($_POST["send"]))
{
	$date=date('l jS \of F Y h:i:s A');
	$date_endorsed = date("Y-m-d")." ".date("H:i:s");     
    $admin_id = $_SESSION['admin_id'];
	$search_lead_id = $_REQUEST["search_lead_id"];
	$cc = $_REQUEST["cc"];
	$subject = $_REQUEST["subject"];
	$position = $_REQUEST["position"];
	$job_category = $_REQUEST["job_category"];
	$body_message = $_REQUEST["body_message"];
	$body_message = str_replace("\n","<br>",$body_message);

	//start: get lead info
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$search_lead_id);
	$l = $db->fetchRow($sql);
	$lead_name = $l['fname']." ".$l['lname'];
	$lead_email = $l['email'];
	//ended: get lead info	
	
	//start: get admin info
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	$admin_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$admin_email = $admin['admin_email'];
	//ended: get admin info	
    
	//start: email signature
	$subject =@$_REQUEST["subject"];    
	$admin_id = $_SESSION['admin_id'];
	$admin_status=$_SESSION['status'];
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
	
	//ended: check lead if exist	
	if($lead_email <> "")
	{
		//start: get job position
		$ads = "";
		if($position <> "")
		{
			$sql=$db->select()
				->from('posting')
				->where('id = ?' ,$position);
			$jp = $db->fetchRow($sql);
			$ads = $jp['jobposition'];
		}
		if ($ads=="")
		{
			//$position = 0;
			$pos = "to one of our clients.";
		}
		else
		{
			$pos = "for the ".$ads." position to one of our clients.";
		}
		//ended: get job position

		//start: get job category
		if($position == "")
		{
			$sql=$db->select()
				->from('job_sub_category')
				->where('sub_category_id = ?' ,$job_category);
			$jp = $db->fetchRow($sql);
			$ads = $jp['sub_category_name'];
		}
		if ($ads=="")
		{
			//$job_category = 0;
			$pos = "to one of our clients.";
		}
		else
		{
			$pos = "for the ".$ads." position to one of our clients.";
		}
		//ended: get job category

		//start: save endorsement 
		$data= array(
		'userid' => $userid,
		'client_name' => $search_lead_id,
		'admin_id' => $admin_id,
		'position' => $position,
		'job_category' => $job_category,
		'date_endoesed' => $date_endorsed 
		);
		$db->insert('tb_endorsement_history', $data);
		//ended: save endorsement
	
		//start: add status lookup or history
		$status_to_use = "ENDORSED";
		$data2 = array(
		'personal_id' => $userid,
		'admin_id' => $admin_id,
		'status' => $status_to_use,
		'date' => date("Y-m-d")." ".date("H:i:s")
		);
		$db->insert('applicant_status', $data2);
		//ended: add status lookup or history
		
		//start: insert staff history
		include('../lib/staff_history.php');
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'STAFF STATUS', 'INSERT', 'ENDORSED');
		//ended: insert staff history    
		
		//start: staff status
		include_once('../lib/staff_status.php') ;
		staff_status($db, $_SESSION['admin_id'], $userid, 'ENDORSED');
		//ended: staff status
		
		//start: email body
		$body = "
		Hi ".$lead_name.",<br /><br />
		".$body_message."<br /><br />
		Please Click the link below to view the cadidate's full profile.<br/><br/>
		<a href='http://www.remotestaff.com.au/available-staff-resume.php?userid=".$userid."'>".$fullname."</a><br /><br />
		";
		//ended: email body

		//start: send email resume to client
		$from_email=$admin_email;
		if (TEST) 
		{
			$client_email = 'devs@remotestaff.com.au';
		}
		$cc = $_REQUEST["cc"]; 
		$body .= $signature_template; 

			//start: send email
			$mail = new Zend_Mail();
			$mail->setBodyHtml($body);
			$mail->setFrom($from_email, $from_email);
			if(! TEST)
			{
				$mail->addTo($lead_email, $lead_email);
				if($cc <> "" || $cc <> NULL)
				{
					$mail->addCc($cc, $cc);// Adds a recipient to the mail with a "Cc" header
				}
			}
			else
			{
				$mail->addTo('devs@remotestaff.com.au', 'devs@remotestaff.com.au');
				if($cc <> "" || $cc <> NULL)
				{
					$mail->addCc('devs@remotestaff.com.au', 'devs@remotestaff.com.au');// Adds a recipient to the mail with a "Cc" header
				}			
			}
			$mail->setSubject($subject);
			$mail->send($transport);									
			//ended: send email
			
		//ended: send email resume to client
	
	
		//start: send email to subcontractor
		$body="
		Dear ".$fullname.",
		<p> <br>
		
		</p>
		<p>We are happy to inform you that we have just recommended you ".$pos." </p>
		<p>The client will either hire you on the spot based on your resume, voice recording an initial interview summary or request a final interview.<br>
		</p>
		<p>We will get back to you with a feedback within 5 business days with regards to the client&rsquo;s decision.</p>
		<p>&nbsp;</p>
		<p>Should you happen to find/accept a lucrative offer/job from another company within these 2 days, please inform us so we could pull your application out.<br>
		</p>
		";    
		$subject = "Remotestaff: Application Update";
		$body .= $signature_template;               
	
			//start: send email
			$mail = new Zend_Mail();
			$mail->setBodyHtml($body);
			$mail->setFrom($from_email, $from_email);
			if(! TEST)
			{
				$mail->addTo($subcontructor_email, $subcontructor_email);
			}
			else
			{
				$mail->addTo('devs@remotestaff.com.au', 'devs@remotestaff.com.au');
			}
			$mail->setSubject($subject);
			$mail->send($transport);									
			//ended: send email	
			
		//ended: send email to subcontractor
	
		echo '
		<script language="javascript">
		  alert("'.$fullname.' has been successfully endorsed. The resume will be sent to the client along with an email");
		  window.close();
		</script>
		';
	}
	else
	{
		echo '
		<script language="javascript">
		  alert("Error!!! Lead not found.");
		</script>
		';		
	}
	//ended: check lead if exist
}
//ENDED: process endorsement

$smarty->assign('userid', $userid);
$smarty->assign('search_lead_id', $search_lead_id);
$smarty->assign('cc', $cc);
$smarty->assign('subject', $subject);
$smarty->assign('body_message', $body_message);
$smarty->display('move_endorse_to_client.tpl');
?>