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
	$date_added = date("Y-m-d")." ".date("H:i:s");     
    $admin_id = $_SESSION['admin_id'];
	$search_lead_id = $_REQUEST["search_lead_id"];
	$cc = $_REQUEST["cc"];
	$subject = $_REQUEST["subject"];
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

		//start: insert staff history
		include('../lib/staff_history.php');
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'EMAIL SAMPLES', 'INSERT', $lead_name);
		//ended: insert staff history    
		
		//start: setup samples & comments
		$body = "
		<p align=left>
		<table width='650' border='0' align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td valign=\"top\" colspan=\"6\">
					<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
						<tr>
							<td valign='top' bgcolor='#ffffff'>
								<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
								".$body_message.	"
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor=\"#CCCCCC\">
				<td valign=\"top\" colspan=\"6\" ><b>Samples</b></td>
			</tr>
			<tr>
				<td valign=\"top\" colspan=\"6\">
					<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
						<tr>
							<td valign='top' bgcolor='#ffffff'>
								<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
									<table>";
										$f_counter = @$_REQUEST["f_counter"];
										$num = 1;
										$temp = "";
										if(! TEST)
										{
											$domain_path = "http://www.remotestaff.com.au/portal/applicants_files/";
										}
										else
										{
											$domain_path = "http://test.remotestaff.com.au/portal/applicants_files/";
										}									
										for($i = 1; $i <= $f_counter; $i++)
										{
											if(@isset($_REQUEST["file".$i]))
											{
												$temp = $temp."<tr><td valign=top><font face='arial' size=2>".$num.")</font></td>";
												$temp = $temp."<td valign=top>"."<font color='#000000' face='arial' size=2>".$row["file_description"]."</font><font color='#CCCCCC' face='arial' size=1><b>(Download</b><i>&nbsp;&nbsp;<a href='".$domain_path.$_REQUEST["file".$i]."' target='_blank'>".$_REQUEST["file".$i]."</a></i><strong>)</strong></font></td></tr>";
												$num++;
											}	
										}
										$body=$body.$temp;
										$body = $body."
									</table>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor=\"#CCCCCC\">
				<td valign=\"top\" colspan=\"6\" ><b>Comments</b></td>
			</tr>
			<tr>
				<td valign=\"top\" colspan=\"6\">
					<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
						<tr>
							<td valign='top' bgcolor='#ffffff'>
								<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
									<table>";
										$c_counter = @$_REQUEST["c_counter"];
										$num = 1;
										$temp = "";
										for($i = 1; $i <= $c_counter; $i++)
										{
											if(@isset($_REQUEST["comment".$i]))
											{
												$temp = $temp."<tr><td valign=top>".$num.")</td>";
												$temp = $temp."<td>".$_REQUEST["comment".$i]."</td></tr>";
												$num++;
											}	
										}
										$body=$body.$temp;
										$body = $body."
									</table>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor=\"#CCCCCC\" align=left>
				<td valign=\"top\" colspan=\"6\" >".$signature_template."</td>
			</tr>
		</table>
		</p>
		";
		//ended: setup samples & comments
		
		//start: save sent samples
		$data= array(
		'userid' => $userid,
		'leads_id' => $search_lead_id,
		'message' => $body,
		'date' => $date_added 
		);
		$db->insert('staff_samples_email_sent', $data);
		//ended: save sent samples
	
		//start: send email samples to client
		$from_email=$admin_email;
		if (TEST) 
		{
			$client_email = 'devs@remotestaff.com.au';
		}
		$cc = $_REQUEST["cc"]; 
		
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
			
		//ended: send email samples to client
	
		echo '
		<script language="javascript">
		  alert("'.$fullname.' samples has been successfully sent. The samples will be sent to the client along with an email");
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


//START: get comments
$comments .= '<tr>
	<td>Include Comments</td>
	<td valign=top>:</td>
	<td valign=top>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">';
			$c_counter = 0;
			$q ="SELECT comments FROM evaluation_comments WHERE userid='$userid'";
			$result = $db->fetchAll($q);
			foreach($result as $r)
			{
				$c_counter++;
				$comments .= '<tr>';
				$comments .= '<td valign="top"><input type="checkbox" name="comment'.$c_counter.'" value="'.$r['comments'].'" checked></td>';
				$comments .= '<td width="100%">'.$r['comments'].'</td>';
				$comments .= '</tr>';
			}
			$comments .= '<input type="hidden" value="'.$c_counter.'" name="c_counter">';
		$comments .= '</table>';
	$comments .= '</td>';
$comments .= '</tr>';
//ENDED: get comments                


//START: get samples
$samples .= '<tr>';
	$samples .= '<td valign="top">Include Samples</td>';
	$samples .= '<td valign="top">:</td>';
	$samples .= '<td valign=top>';
		$samples .= '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
			$c_counter = 0;
			$q ="SELECT * FROM tb_applicant_files WHERE userid='$userid'";
			$result = $db->fetchAll($q);
			foreach($result as $r)
			{
				$c_counter++;
				$samples .= '<tr>';
					$samples .= '<td valign="top"><input type="checkbox" name="file'.$c_counter.'" value="'.$r["name"].'" checked></td>';
					$samples .= '<td width="100%">';
					if($row["file_description"] != "" || $row["file_description"] != NULL)
					{
						$samples .= $row["file_description"].":&nbsp;<i><a href='applicants_files/".$r["name"]."' target='_blank'>".$r["name"]."</a></i>"; 
					}
					else
					{
						$samples .= "<i><a href='applicants_files/".$row["name"]."' target='_blank'>".$r["name"]."</a></i>"; 
					}
					$samples .= '</td>';
				$samples .= '</tr>';
			}
			$samples .= '<input type="hidden" value="'.$c_counter.'" name="f_counter">';
		$samples .= '</table>';
	$samples .= '</td>';
$samples .= '</tr>';
//ENDED: get samples


$smarty->assign('samples', $samples);
$smarty->assign('comments', $comments);
$smarty->assign('userid', $userid);
$smarty->assign('search_lead_id', $search_lead_id);
$smarty->assign('cc', $cc);
$smarty->assign('subject', $subject);
$smarty->assign('body_message', $body_message);
$smarty->display('send_sample_work_to_client.tpl');
?>