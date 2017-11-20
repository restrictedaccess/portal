<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

$userid = @$_GET["userid"];

$s = "SELECT DISTINCT lname, fname, gender, pass FROM personal WHERE userid='$userid' LIMIT 1;";
$r=mysql_query($s);
while(list($lname, $fname, $gender, $pass) = mysql_fetch_array($r))
{
	 $FullName=$fname." ".$lname;
	 $FullName=filterfield($FullName);
	 //$main_pass=sha1($pass);
	 $main_pass="<i>(Your specified password on your jobseeker account)</i>";
	 $gender = $gender;
}

$sql3 = "SELECT DISTINCT l.id, l.lname, l.fname FROM leads l WHERE status='Client' ORDER BY l.fname ASC;";
$result3=mysql_query($sql3);
while(list($lead_id, $client_lname, $client_fname) = mysql_fetch_array($result3))
{
	 $client_fullname =$client_fname." ".$client_lname;
	 if ($kliyente==$lead_id)
	 {
	 	$usernameOptions2 .="<option selected value= ".$lead_id.">".$client_fullname."</option>";
	 }
	 else
	 {
	 	$usernameOptions2 .="<option  value= ".$lead_id.">".$client_fullname."</option>";
	 }
}

if(@isset($_POST["save"]))
{
	// used to create automatic creation of ads
	$kliyente=$_REQUEST['kliyente'];
	$new_email=$_REQUEST['email'];
	$new_email = str_replace(" ", "", $new_email);
	//$initial_email_password=sha1($_REQUEST['password']);
	$initial_email_password=$_REQUEST['password'];
	$skype=$_REQUEST['skype'];
	$skype_password=$_REQUEST['skype_password'];



	$starting_hours=$_REQUEST['starting_hours_hour'].":".$_REQUEST['starting_hours_minute'].":".$_REQUEST['starting_hours_type'];
	if($_REQUEST['starting_hours_type'] == "PM")
	{	
		switch($_REQUEST['starting_hours_hour'])
		{
			case "1":
				$starting_hours_to_save = "13:".$_REQUEST['starting_hours_minute'];
			case "2":
				$starting_hours_to_save = "14:".$_REQUEST['starting_hours_minute'];
			case "3":
				$starting_hours_to_save = "15:".$_REQUEST['starting_hours_minute'];
			case "4":
				$starting_hours_to_save = "16:".$_REQUEST['starting_hours_minute'];
			case "5":
				$starting_hours_to_save = "17:".$_REQUEST['starting_hours_minute'];
			case "6":
				$starting_hours_to_save = "18:".$_REQUEST['starting_hours_minute'];
			case "7":
				$starting_hours_to_save = "19:".$_REQUEST['starting_hours_minute'];
			case "8":
				$starting_hours_to_save = "20:".$_REQUEST['starting_hours_minute'];
			case "9":
				$starting_hours_to_save = "21:".$_REQUEST['starting_hours_minute'];
			case "10":
				$starting_hours_to_save = "22:".$_REQUEST['starting_hours_minute'];
			case "11":
				$starting_hours_to_save = "23:".$_REQUEST['starting_hours_minute'];
			case "12":
				$starting_hours_to_save = "24:".$_REQUEST['starting_hours_minute'];
		}
	}
	else
	{
		$starting_hours_to_save = $_REQUEST['starting_hours_hour'].":".$_REQUEST['starting_hours_minute'];
	}
	
	
	
	
	$ending_hours=$_REQUEST['ending_hours_hour'].":".$_REQUEST['ending_hours_minute'].":".$_REQUEST['ending_hours_type'];
	if($_REQUEST['ending_hours_type'] == "PM")
	{	
		switch($_REQUEST['ending_hours_hour'])
		{
			case "1":
				$ending_hours_to_save = "13:".$_REQUEST['ending_hours_minute'];
			case "2":
				$ending_hours_to_save = "14:".$_REQUEST['ending_hours_minute'];
			case "3":
				$ending_hours_to_save = "15:".$_REQUEST['ending_hours_minute'];
			case "4":
				$ending_hours_to_save = "16:".$_REQUEST['ending_hours_minute'];
			case "5":
				$ending_hours_to_save = "17:".$_REQUEST['ending_hours_minute'];
			case "6":
				$ending_hours_to_save = "18:".$_REQUEST['ending_hours_minute'];
			case "7":
				$ending_hours_to_save = "19:".$_REQUEST['ending_hours_minute'];
			case "8":
				$ending_hours_to_save = "20:".$_REQUEST['ending_hours_minute'];
			case "9":
				$ending_hours_to_save = "21:".$_REQUEST['ending_hours_minute'];
			case "10":
				$ending_hours_to_save = "22:".$_REQUEST['ending_hours_minute'];
			case "11":
				$ending_hours_to_save = "23:".$_REQUEST['ending_hours_minute'];
			case "12":
				$ending_hours_to_save = "24:".$_REQUEST['ending_hours_minute'];
		}
	}
	else
	{
		$ending_hours_to_save = $_REQUEST['ending_hours_hour'].":".$_REQUEST['ending_hours_minute'];
	}
		
		
	
	$starting_date = $_REQUEST['starting_date_year']."-".$_REQUEST['starting_date_month']."-".$_REQUEST['starting_date_day'];
	$starting_date_autoresponder = date("l, jS F Y", strtotime($starting_date));
	
	
	$end_date = $_REQUEST['end_date_year']."-".$_REQUEST['end_date_month']."-".$_REQUEST['end_date_day'];
	$end_date_autoresponder = date("l, jS F Y", strtotime($end_date));


	$query="SELECT * FROM personal WHERE (email='$new_email') && (userid != '$userid');";
	$result=mysql_query($query);
	$ctr=@mysql_num_rows($result);
	
	if ($ctr ==0 )
	{
			$AusTime = date("H:i:s"); 
			$AusDate = date("Y")."-".date("m")."-".date("d");
			$ATZ = $AusDate." ".$AusTime;
			$date=date('l jS \of F Y h:i:s A');
			
			$admin_id = $_SESSION['admin_id'];
			$admin_status=$_SESSION['status'];
			
			$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
			
			$resulta=mysql_query($sql);
			$ctr=@mysql_num_rows($resulta);
			if ($ctr >0 )
			{
				$row = mysql_fetch_array ($resulta); 
				$admin_email = $row['admin_email'];
			}
					
			// check the client Business Partner
			$sqlAgentcheck="SELECT * FROM leads WHERE id=$kliyente";
			$resultAgentCheck=mysql_query($sqlAgentcheck);
			$rowAgentCheck = mysql_fetch_array ($resultAgentCheck); 
			$agent_no = $rowAgentCheck['agent_id'];
			$client_name = $rowAgentCheck['fname']." ".$rowAgentCheck['lname'];
			$company_name = $rowAgentCheck['company_name'];		
			$client_password = $rowAgentCheck['password'];	
			$client_login = $rowAgentCheck['email'];	
			$company_name = $rowAgentCheck['company_name'];	
			
			if($agent_no=="")
			{
				$query="SELECT * FROM agent WHERE email ='$admin_email';";
				$result=mysql_query($query);
				$ctr2=@mysql_num_rows($result);
				if ($ctr2 >0 )
				{
					$row = mysql_fetch_array ($result); 
					$agent_no = $row['agent_no'];
				}
			}	
			
			$ads=$_REQUEST['ads'];
			$ads_id = $ads;
			if($ads == "")
			{
				$ads = $_REQUEST['job_position'];
			}
			
			$sql="SELECT jobposition FROM posting WHERE id = '$ads';";
			$r=mysql_query($sql);
			$ctr=@mysql_num_rows($r);
			if ($ctr >0 )
			{
				$rw = mysql_fetch_array ($r); 
				$ads = $rw['jobposition'];
			}
	
			mysql_query("INSERT INTO subcontractors SET leads_id = '$kliyente', agent_id = '$agent_no', userid = '$userid', posting_id = '$ads_id', date_contracted ='$ATZ', starting_hours ='$starting_hours_to_save', ending_hours ='$ending_hours_to_save', starting_date ='$starting_date', end_date ='$end_date', status = 'ACTIVE'");
			mysql_query("UPDATE applicants SET status='Sub Contracted' WHERE userid='$userid' LIMIT 1");							
	
			// SEND AN EMAIL TO SUB-CONTRACTOR
			$sqlEmail="SELECT * FROM personal p WHERE p.userid=$userid";
			$result=mysql_query($sqlEmail);
			$row = mysql_fetch_array ($result); 
			$email =$row['email'];
			$gender =$row['gender'];
			if($gender == "Female" || $gender == "female")
			{
				$gender_a = "Her";
				$gender_b = "her";
			}
			else
			{
				$gender_a = "His";
				$gender_b = "him";
			}
			$fullname =$row['fname']." ".$row['lname'];
	
			mysql_query("UPDATE personal SET registered_email='$email', email='$new_email', initial_email_password='$initial_email_password', skype_id='$skype', initial_skype_password='$skype_password' WHERE userid='$userid' LIMIT 1");	
					
			$from_email="staffclientrelations@remotestaff.com.au";
			$subject ="Welcome to RemoteStaff";
			
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from_email." \r\n"."Reply-To: ".$from_email."\r\n";	
			
			
			
			//SIGNATURE
			$admin_id = $_SESSION['admin_id'];
			$admin_status=$_SESSION['status'];
			$site = $_SERVER['HTTP_HOST'];
			
			$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
			$resultAgentCheck=mysql_query($sql);
			$result = mysql_fetch_array ($resultAgentCheck); 		
			
			$name = $result['admin_fname']." ".$result['admin_lname'];
			$admin_email=$result['admin_email'];
			$signature_company = $result['signature_company'];
			$signature_notes = $result['signature_notes'];
			$signature_contact_nos = $result['signature_contact_nos'];
			$signature_websites = $result['signature_websites'];
			
			if($signature_notes!=""){
				$signature_notes = "<p><i>$signature_notes</i></p>";
			}else{
				$signature_notes = "";
			}
			if($signature_company!=""){
				$signature_company="<br>$signature_company";
			}else{
				$signature_company="<br>RemoteStaff";
			}
			if($signature_contact_nos!=""){
				$signature_contact_nos = "<br>$signature_contact_nos";
			}else{
				$signature_contact_nos = "";
			}
			if($signature_websites!=""){
				$signature_websites = "<br>Websites : $signature_websites";
			}else{
				$signature_websites = "";
			}
			 
			$signature_template = $signature_notes;
			$signature_template .="<a href='http://$site/$agent_code'>
						<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
			$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
			//END SIGNATURE
			
			$date=date('l jS \of F Y h:i:s A');
			
			$body = "
			<style>
			body{font-family:Tahoma; font-size:14px;}
			#paragraph {margin-left:10px; margin-top:5px;}
			#paragraph p{margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;}
			#paragraph h4 {margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; }
			#paragraph h3 { color:#660000;margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; }
			#paragraph ol{font-family:Tahoma; font-size:13px;}
			#paragraph li { margin-bottom:10px; margin-top:10px;}
			#paragraph span { margin-top:20px; color:#003399; text-align:justify;font-family:Tahoma; font-size:13px; }
			</style>
			<table style=' border:#FFFFFF solid 1px;' width='100%'>
			<tr><td height='105' width='100%%' valign='top'>
			<div id='paragraph' style=''>
			<p>$date<p>
			<h4>Hi&nbsp; ".strtoupper($fullname)."</h4>
			<h3>This is to confirm the receipt of your contract. Welcome to RemoteStaff!!! </h3>
			
			<p>You need to attend a 30 minute online work orientation before your first day. The orientation can be scheduled between 2 PM to 4 PM Manila time , Monday to Friday. Please send your complete name and time/date you can attend the interview to <a href='mailto:staffclientrelations@remotestaff.com.au'>staffclientrelations@remotestaff.com.au </a> . </p>
			<p><em>Example : Juan Dela Cruz, 4.00 PM/June 15, 2010. </em></p>
			<p>A confirmation email will be sent to you right after. </p>
			<p>Log in to your assigned Skype ID on time for the orientation. Don't be late, make sure your headset is working. </p>			
			
			<p><b>Before your first day please: </b></p>
			<ol>
			<li>Go to <a href='http://www.remotestaff.com.au/portal/' target='_blank'>Sub-contractors System</a> , log in and check out the Starter Kit. Log in as a 'Sub-Contractor'</li>
			<ul> <b>Login Detail</b>
				<li><b>Email : ".$new_email."</b></li>
				<li><b>Password : ".$main_pass."</b></li>
			</ul>
			<li>Log in and test out your Skype account. (please note that this has already been created, and you just need to log-in to it.)</li>
			<ul><li><b>Skype ID : ".$skype."</b></li>
				<li><b>Password : ".$skype_password."</b></li>
			</ul>
			This Skype account should be used for business purpose only. You are required to be logged in to this account during working hours. 
			<li>Test your Headset</li>
			<li>Download the RemoteStaff Screen Capture Installer from the Sub-Contractor System Website and install it into your computer.</li>
			<ul> <b>Login Detail</b>
				<li><b>Email : ".$new_email."</b></li>
				<li><b>Password : ".$main_pass."</b></li>
			</ul>
			The log in details for your RemoteStaff Screen Capture is the same as your log-in details for the Sub-Contractor system.
			<li>Log in to your company email address (Yahoo or Gmail).</li>
			<ul> <b>Login Detail</b>
				<li><b>Email : ".$new_email."</b></li>
				<li><b>Password : ".$_REQUEST['password']."</b></li>
			</ul>
			All communication between you and your client must be made through this email address. 
			<li>Download Yuuguu at <a href='http://www.yuuguu.com' target='_blank'>www.yuuguu.com</a> and create an account. Using your company Gmail address</li>
			</ol>
			<p><b>Please follow the steps below on your first day. </b></p>
			<ol>
			   <li>On your first day log in to the System and click <strong>&quot;Start Work&quot;</strong>. Be on time. Log in to the RSSC.
			You have to be on the system and Skype on or before your starting working time.</li>
			  
			   <li>Wait for me or the client to contact you via Skype.  Your client will introduce himself to you. Your client's name is <b>".strtoupper($client_name." ( ".$company_name)." )</b> </li>
			   <li>While waiting, please read and study the resources on the Sub-Contractor System. After the introduction, you will be working <strong>DIRECTLY</strong> with your client. We will <strong>NOT</strong> project manage you when it comes to your tasks and activities with your client, but we check on your attendance and online visibility. Work and task related issues should be discussed directly with the client.</li>
			   
			  
			</ol>
			<span><i>**Please note that you cannot negotiate anything with the client when it comes to problems regarding the work set-up, systems, compensation and attendance. You have to discuss this directly with the RemoteStaff team.    </i></span>
			<p>&nbsp;</p>
			
			<p>Welcome to the team! Have a wonderful and productive  first working day! </p>
			<p>Cheers!</p>
			<p>".$signature_template."</p>
			</div>
			</td></tr>
			</tr>
			</table>
			";
			if($email == $new_email)
			{
				if (TEST) 
				{		
					$email = "devs@remotestaff.com.au";			
				}
				mail($email, $subject, $body, $header);
			}
			else
			{
				if (TEST) 
				{		
					$email = "devs@remotestaff.com.au";		
					$new_email = "devs@remotestaff.com.au";			
				}			
				mail($email, $subject, $body, $header);
				mail($new_email, $subject, $body, $header);
			}
						

			
			
			
			
			
						
			//generate client password
			//$c_code = rand(1000, 2000) ; 
			//$client_password="pass".$c_code;
			//$pass_to_save=sha1($client_password);
			//mysql_query("UPDATE leads SET password='$pass_to_save' WHERE id='$kliyente'");
			
			$sqlPass="SELECT password FROM leads WHERE id='$kliyente'";
			$r=mysql_query($sqlPass);
			$rw = mysql_fetch_array ($r); 
			$client_password = "(Your specified password on your client account)"; //$rw['password'];			
			//end client generate password
			
			
			$body = 
			'
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
			"http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<title>Untitled Document</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<style type="text/css">
			<!--
			.style1 {font-family: Arial, Helvetica, sans-serif}
			-->
			</style>
			</head>
			
			<body>
			<table width="100%"  border="0" cellpadding="3" cellspacing="3">
			  <tr>
				<td colspan="2" valign="top"><span class="style1">Your new '.$ads.', '.$FullName.', will start work for you on '.$starting_date_autoresponder.'. '.$gender_a.' work Schedule is '.$starting_hours.' to '.$ending_hours.' your time. </span></td>
			  </tr>
			  <tr>
				<td colspan="2" valign="top"><span class="style1">You will be able to contact '.$gender_b.' through the following: </span></td>
			  </tr>
			  <tr>
				<td colspan="2" valign="top"><table cellpadding="2" cellspacing="2" bgcolor="#666666">
				  <tr>
					<td width="144" valign="middle" bgcolor="#FFFFFF" class="style1"><p align="right"><strong><font color="#FF0000">Email&nbsp;Address: </font></strong></p></td>
					<td width="281" valign="middle" bgcolor="#FFFFFF" class="style1"><font color="#FF0000">'.$new_email.'</font></td>
				  </tr>
				  <tr>
					<td width="144" valign="middle" bgcolor="#FFFFFF" class="style1"><p align="right"><strong><font color="#FF0000">Skype ID: </font></strong></p></td>
					<td width="281" valign="middle" bgcolor="#FFFFFF" class="style1"><font color="#FF0000">'.$skype.'</font></td>
				  </tr>
				</table></td>
			  </tr>
			  <tr>
				<td colspan="2" valign="top"><span class="style1"><strong>A few notes: </strong></span></td>
			  </tr>
			  <tr>
				<td width="2%" valign="top"><span class="style1">1.</span></td>
				<td width="98%"><span class="style1">If you need for your staff to have a local Australian number - to allow her to call local Australian numbers and receive calls locally please click&nbsp; <a href="http://www.anrdoezrs.net/rt67ox52x4KORSNOPNKMLQSRRQO">HERE </a>. A separate email will be sent to you with detailed instruction. </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1">2.</span></td>
				<td><span class="style1">Once a number is purchased, please send it to us and we\'ll set the phone up on your staff member\'s computer. </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1">3.</span></td>
				<td><span class="style1">Your staff\' Skype account will only be used for business purposes, and shall be a means to easily communicate with you. If you need to download Skype, the installer will be found on:&nbsp; <a href="http://www.anrdoezrs.net/rt67ox52x4KORSNOPNKMLQSRRQO"><strong>Skype </strong></a></span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1">4.</span></td>
				<td><span class="style1">Your staff has registered to Yuuguu, a screen-sharing application which will allow you to view and take control of her screen (vice versa), which can be a valuable application to use during training. The yuuguu installer may be found at:&nbsp; <strong><a href="http://www.yuuguu.com/download/windows_download_preview">Yuuguu </a></strong></span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1">5.</span></td>
				<td><span class="style1">To help you work effectively with your remote staff member, we have developed a Sub Contractor Management system that will allow you to assign task to your staff, monitor their&nbsp;progress, check their work flow and &nbsp;check their computer screen any any given point of the&nbsp;day.&nbsp; </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1"></span></td>
				<td><span class="style1">To access, log in as a Client&nbsp; <a href="http://www.remotestaff.com.au/portal/index.php"><strong>HERE </strong></a>. (please bookmark this link for easier access)&nbsp; </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1"></span></td>
				<td><table cellpadding="2" cellspacing="2" bgcolor="#666666">
				  <tr>
					<td width="144" valign="middle" bgcolor="#FFFFFF" class="style1"><p align="right"><strong><font color="#FF0000">Username: </font></strong></p></td>
					<td width="252" valign="middle" bgcolor="#FFFFFF" class="style1"><p><font color="#FF0000">'.$client_login.'</font></p></td>
				  </tr>
				  <tr>
					<td width="144" valign="middle" bgcolor="#FFFFFF" class="style1"><p align="right"><strong><font color="#FF0000">Password: </font></strong></p></td>
					<td width="252" valign="middle" bgcolor="#FFFFFF" class="style1"><p><font color="#FF0000">'.$client_password.' </font></p></td>
				  </tr>
				</table></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1">6.</span></td>
				<td><span class="style1">As with any&nbsp;types&nbsp;of staff member, the&nbsp;first&nbsp;2 weeks will be&nbsp;crucial. Micromanagement or training might be required from you or from your department managers. Please&nbsp;liaise&nbsp;directly with your staff member to identify how much training and micromanagement is needed for the&nbsp;first&nbsp;2 weeks.&nbsp; </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1">7.</span></td>
				<td><span class="style1">I will be sending you your&nbsp;first&nbsp;month invoice. This Invoice should be paid&nbsp; <strong>by '.$starting_date_autoresponder.'</strong>. We accept electronic bank transfer, direct debit and credit card payments.&nbsp; </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1"></span></td>
				<td><p class="style1">Monthly invoices will be sent every&nbsp;first&nbsp;week of the month and should be settled within 5 business days of the invoice date. Failure to pay&nbsp;within&nbsp;this time frame will result to&nbsp;suspension&nbsp;or termination of our Agreement.&nbsp; </p>    </td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1"></span></td>
				<td><span class="style1">Any questions regarding payments and accounts should be&nbsp;directed&nbsp;to:&nbsp; <a href="mailto:accounts@remotestaff.com.au"><strong>accounts@remotestaff.com.au </strong></a><strong>&nbsp; </strong></span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1"></span></td>
				<td><span class="style1">Our goal is to partner long term with you, we want to help in any way we can BUT please note that your staff member is under your direct control. You work with&nbsp;them directly.&nbsp; <br>
			  On our end we :&nbsp; </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1"></span></td>
				<td><table width="100%"  border="0">
				  <tr>
					<td width="3%" class="style1">a.</td>
					<td width="97%" class="style1">Make sure that your staff member is online on time and following a structured schedule </td>
				  </tr>
				  <tr>
					<td class="style1">b.</td>
					<td class="style1">Check on their screen shots to make sure that they are active all throughout the working hours </td>
				  </tr>
				  <tr>
					<td class="style1">c.</td>
					<td class="style1"> Set up local Australian numbers and phone when needed; take care of technical issues </td>
				  </tr>
				  <tr>
					<td class="style1">d.</td>
					<td class="style1">Take care of Payroll </td>
				  </tr>
				  <tr>
					<td class="style1">e.</td>
					<td class="style1">Make sure you are informed about the whereabouts of your staff member </td>
				  </tr>
				  <tr>
					<td class="style1">f.</td>
					<td class="style1">Provide you with tools to collaborate and work effectively with your staff member </td>
				  </tr>
				</table></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1"></span></td>
				<td><span class="style1">Any work related issue should be addressed directly to your staff member. Any issues regarding pay, schedule,&nbsp;commissions&nbsp;etc. should be routed to us.&nbsp; </span></td>
			  </tr>
			  <tr>
				<td valign="top"><span class="style1">8.</span></td>
				<td><span class="style1"><strong>'.$fullname.'</strong>, will be online for work and will be waiting for your instructions.</span></td>
			  </tr>
			  
			  
			  <tr>
				<td colspan="2"><br />
					<span class="style1">
					
					
					<p>'.$signature_template.'</p>
					
					
					
					</span>
				</td>
			  </tr>			  
			</table>
			<p>&nbsp;</p>
			</body>
			</html>
			';			
			if (TEST) 
			{		
				$client_login = "devs@remotestaff.com.au";			
			}					
			mail($client_login, $subject, $body, $header);

			
			
			
			?>
				<script language="javascript">
					alert("<?php echo $fullname; ?> has been sucessfully sub contracted and will receive an email along with the login details.");
					window.close();
				</script>
			<?php
	}
	else
	{
			?>
				<script language="javascript">
					alert("Email already exist!");
				</script>
			<?php	
	}				
}

?>












<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>

<script src="selectClient.js"></script>

<script language="javascript">
	function validate(form) 
	{
		if (form.kliyente.value == '0' || form.kliyente.value == '') { alert("You forgot to select the client."); form.kliyente.focus(); return false; }
		
		if (form.skype_password.value == '') { alert("You forgot to enter the skype password."); form.skype_password.focus(); return false; }		
		if (form.skype.value == '') { alert("You forgot to enter the skype account."); form.skype.focus(); return false; }	
		
		if (form.password.value == '') { alert("You forgot to enter the email account password."); form.password.focus(); return false; }	
		if (form.email.value == '') { alert("You forgot to enter the email address."); form.email.focus(); return false; }	
		
		
		if (form.starting_hours_hour.value == '') { alert("You forgot to enter starting hour."); form.starting_hours_hour.focus(); return false; }
		if (form.starting_hours_minute.value == '') { alert("You forgot to enter starting hour."); form.starting_hours_minute.focus(); return false; }
		if (form.starting_hours_type.value == '') { alert("You forgot to enter starting hour."); form.starting_hours_type.focus(); return false; }
			
		if (form.ending_hours_hour.value == '') { alert("You forgot to enter the ending hour."); form.ending_hours_hour.focus(); return false; }	
		if (form.ending_hours_minute.value == '') { alert("You forgot to enter the ending hour."); form.ending_hours_minute.focus(); return false; }	
		if (form.ending_hours_type.value == '') { alert("You forgot to enter the ending hour."); form.ending_hours_type.focus(); return false; }	
		
		if (form.starting_date_month.value == '') { alert("You forgot to enter the starting date."); form.starting_date_month.focus(); return false; }	
		if (form.starting_date_day.value == '') { alert("You forgot to enter the starting date."); form.starting_date_day.focus(); return false; }	
		if (form.starting_date_year.value == '') { alert("You forgot to enter the starting date."); form.starting_date_year.focus(); return false; }	
		
		if (form.end_date_month.value == '') { alert("You forgot to enter ending date."); form.end_date_month.focus(); return false; }									
		if (form.end_date_day.value == '') { alert("You forgot to enter ending date."); form.end_date_day.focus(); return false; }									
		if (form.end_date_year.value == '') { alert("You forgot to enter ending date."); form.end_date_year.focus(); return false; }									
		
		
			emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
			var regex = new RegExp(emailReg);
			if(regex.test(form.email.value) == false)
			{
				alert('Please enter a valid email address and try again!');
				form.email.focus();
				return false;
			}	
	}		
</script>




<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<style type="text/css">
<!--
div.scroll {
	height: 400px;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript">

function fillAds(ads)
{
	document.form.ads2.value=ads;
}
function checkFields()
{
	if(document.form.flag.value=="")
	{
		alert("Please choose an Option in Adding a Sub-Contractor.");
		return false;
	}
	if(document.form.flag.value=="1")
	{
		if(document.form.fname.value=="")
		{
			alert("Firstname is a required Field!");
			return false;
		}
		if(document.form.lname.value=="")
		{
			alert("Lastname is a required Field!");
			return false;
		}
		if(document.form.email.value=="")
		{
			alert("Email is a required Field!");
			return false;
		}
			
	}
	if(document.form.flag.value=="2")
	{
		if(document.form.subcon.selectedIndex=="0")
		{
			alert("Please choose an Applicant in the List!");
			return false;
		}
	}
	// kliyente
	if(document.form.kliyente.selectedIndex=="0")
		{
			alert("Please choose a Client in the List!");
			return false;
		}
		
	//if(document.form.ads2.value=="")
	//{
	//	alert("Please choose a Client Job Advertisement!");
	//	return false;
	//}
	return true;
}
-->
</script>


<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="86%" valign="top" align="left">



<form name="form" method="post" action="?userid=<?php echo $userid; ?>" onSubmit="return validate(this)">
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
	<tr>
		<td height="40" colspan="2">
			<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
				<b>Add a Sub-Contractor</b>
			</div>				
		</td>
	</tr>	
	<tr>
		<td valign="top" colspan="2">
			<b><?php echo $FullName; ?></b>
		</td>
	</tr>  
	<tr>
		<td colspan="2" valign="top"><hr></td>
	</tr>
	<tr>
		<td height="32" colspan="2" valign="middle">
			<table width="100%">
				<tr>
					<td colspan="3" height="24"><strong>Sub-Contracted to</strong></td>
				</tr>
				<tr>
					<td width="11%" height="28">Client<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
						<select name="kliyente" class="select" onChange="showClientCompany(this.value);">
							<option value="0">-</option>
							<?=$usernameOptions2;?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="11%" height="28">Email<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
						<input type="text" name="email" class="select">
					</td>
				</tr>
				<tr>
					<td width="11%" height="28">Initial&nbsp;Email&nbsp;Password<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
						<input type="text" name="password" class="select">
					</td>
				</tr>
				<tr>
					<td width="11%" height="28">Skype-ID<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
						<input type="text" name="skype" class="select">
					</td>
				</tr>
				<tr>
					<td width="11%" height="28">Initial&nbsp;Skype&nbsp;Password<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
						<input type="text" name="skype_password" class="select">
					</td>
				</tr>	
				
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>					
				
				<tr>
					<td width="11%" height="28">Starting Hours<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
																					<SELECT NAME="starting_hours_hour" class="text">
																						<OPTION VALUE=''>Hour</OPTION>
																						<OPTION VALUE=01>01</OPTION>
																						<OPTION VALUE=02>02</OPTION>
																						<OPTION VALUE=03>03</OPTION>
																						<OPTION VALUE=04>04</OPTION>
																						<OPTION VALUE=05>05</OPTION>
																						<OPTION VALUE=06>06</OPTION>
																						<OPTION VALUE=07>07</OPTION>
																						<OPTION VALUE=08>08</OPTION>
																						<OPTION VALUE=09>09</OPTION>
																						<OPTION VALUE=10>10</OPTION>
																						<OPTION VALUE=11>11</OPTION>
																						<OPTION VALUE=12>12</OPTION>
																					</SELECT>											
																					<select name="starting_hours_minute" class="text">
																					  <option value="">Minute</option>
																					  <option value="00">00</option>
																					  <option value="01">01</option>
																					  <option value="02">02</option>
																					  <option value="03">03</option>
																					  <option value="04">04</option>
																					  <option value="05">05</option>
																					  <option value="06">06</option>
																					  <option value="07">07</option>
																					  <option value="08">08</option>
																					  <option value="09">09</option>
																					  <option value="10">10</option>
																					  <option value="11">11</option>
																					  <option value="12">12</option>
																					  <option value="13">13</option>
																					  <option value="14">14</option>
																					  <option value="15">15</option>
																					  <option value="16">16</option>
																					  <option value="17">17</option>
																					  <option value="18">18</option>
																					  <option value="19">19</option>
																					  <option value="20">20</option>
																					  <option value="21">21</option>
																					  <option value="22">22</option>
																					  <option value="23">23</option>
																					  <option value="24">24</option>
																					  <option value="25">25</option>
																					  <option value="26">26</option>
																					  <option value="27">27</option>
																					  <option value="28">28</option>
																					  <option value="29">29</option>
																					  <option value="30">30</option>
																					  <option value="31">31</option>
																					  <option value="32">32</option>
																					  <option value="33">33</option>
																					  <option value="34">34</option>
																					  <option value="35">35</option>
																					  <option value="36">36</option>
																					  <option value="37">37</option>
																					  <option value="38">38</option>
																					  <option value="39">39</option>
																					  <option value="40">40</option>
																					  <option value="41">41</option>
																					  <option value="42">42</option>
																					  <option value="43">43</option>
																					  <option value="44">44</option>
																					  <option value="45">45</option>
																					  <option value="46">46</option>
																					  <option value="47">47</option>
																					  <option value="48">48</option>
																					  <option value="49">49</option>
																					  <option value="50">50</option>
																					  <option value="51">51</option>
																					  <option value="52">52</option>
																					  <option value="53">53</option>
																					  <option value="54">54</option>
																					  <option value="55">55</option>
																					  <option value="56">56</option>
																					  <option value="57">57</option>
																					  <option value="58">58</option>
																					  <option value="59">59</option>
																					</select>	
																					<SELECT NAME="starting_hours_type" class="text">
																						<OPTION VALUE=''>Type</OPTION>
																						<OPTION VALUE="AM">AM</OPTION>
																						<OPTION VALUE="PM">PM</OPTION>
																					</SELECT>																										
					</td>
				</tr>	
				<tr>
					<td width="11%" height="28">Ending Hours<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
																					<SELECT NAME="ending_hours_hour" class="text">
																						<OPTION VALUE=''>Hour</OPTION>
																						<OPTION VALUE=01>01</OPTION>
																						<OPTION VALUE=02>02</OPTION>
																						<OPTION VALUE=03>03</OPTION>
																						<OPTION VALUE=04>04</OPTION>
																						<OPTION VALUE=05>05</OPTION>
																						<OPTION VALUE=06>06</OPTION>
																						<OPTION VALUE=07>07</OPTION>
																						<OPTION VALUE=08>08</OPTION>
																						<OPTION VALUE=09>09</OPTION>
																						<OPTION VALUE=10>10</OPTION>
																						<OPTION VALUE=11>11</OPTION>
																						<OPTION VALUE=12>12</OPTION>
																					</SELECT>											
																					<select name="ending_hours_minute" class="text">
																					  <option value="">Minute</option>
																					  <option value="00">00</option>
																					  <option value="01">01</option>
																					  <option value="02">02</option>
																					  <option value="03">03</option>
																					  <option value="04">04</option>
																					  <option value="05">05</option>
																					  <option value="06">06</option>
																					  <option value="07">07</option>
																					  <option value="08">08</option>
																					  <option value="09">09</option>
																					  <option value="10">10</option>
																					  <option value="11">11</option>
																					  <option value="12">12</option>
																					  <option value="13">13</option>
																					  <option value="14">14</option>
																					  <option value="15">15</option>
																					  <option value="16">16</option>
																					  <option value="17">17</option>
																					  <option value="18">18</option>
																					  <option value="19">19</option>
																					  <option value="20">20</option>
																					  <option value="21">21</option>
																					  <option value="22">22</option>
																					  <option value="23">23</option>
																					  <option value="24">24</option>
																					  <option value="25">25</option>
																					  <option value="26">26</option>
																					  <option value="27">27</option>
																					  <option value="28">28</option>
																					  <option value="29">29</option>
																					  <option value="30">30</option>
																					  <option value="31">31</option>
																					  <option value="32">32</option>
																					  <option value="33">33</option>
																					  <option value="34">34</option>
																					  <option value="35">35</option>
																					  <option value="36">36</option>
																					  <option value="37">37</option>
																					  <option value="38">38</option>
																					  <option value="39">39</option>
																					  <option value="40">40</option>
																					  <option value="41">41</option>
																					  <option value="42">42</option>
																					  <option value="43">43</option>
																					  <option value="44">44</option>
																					  <option value="45">45</option>
																					  <option value="46">46</option>
																					  <option value="47">47</option>
																					  <option value="48">48</option>
																					  <option value="49">49</option>
																					  <option value="50">50</option>
																					  <option value="51">51</option>
																					  <option value="52">52</option>
																					  <option value="53">53</option>
																					  <option value="54">54</option>
																					  <option value="55">55</option>
																					  <option value="56">56</option>
																					  <option value="57">57</option>
																					  <option value="58">58</option>
																					  <option value="59">59</option>
																					</select>	
																					<SELECT NAME="ending_hours_type" class="text">
																						<OPTION VALUE=''>Type</OPTION>
																						<OPTION VALUE="AM">AM</OPTION>
																						<OPTION VALUE="PM">PM</OPTION>
																					</SELECT>						
					</td>
				</tr>					
				<tr>
					<td width="11%" height="28">Starting Date<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
												<select name="starting_date_month" class="text">
												   <option value="01">Jan</option>
												   <option value="02">Feb</option>
												   <option value="03">Mar</option>
												   <option value="04">Apr</option>
												   <option value="05">May</option>
												   <option value="06">Jun</option>
												   <option value="07">Jul</option>
												   <option value="08">Aug</option>
												   <option value="09">Sep</option>
												   <option value="10">Oct</option>
												   <option value="11">Nov</option>
												   <option value="12">Dec</option>
												   <option value="" selected="selected">Month</option>		
										    	</select>
												
												 <select name="starting_date_day" class="text">
												   <option value="01">01</option>
												   <option value="02">02</option>
												   <option value="03">03</option>
												   <option value="04">04</option>
												   <option value="05">05</option>
												   <option value="06">06</option>
												   <option value="07">07</option>
												   <option value="08">08</option>
												   <option value="09">09</option>
												   <option value="10">10</option>
												   <option value="11">11</option>
												   <option value="12">12</option>
												   <option value="13">13</option>
												   <option value="14">14</option>
												   <option value="15">15</option>
												   <option value="16">16</option>
												   <option value="17">17</option>
												   <option value="18">18</option>
												   <option value="19">19</option>
												   <option value="20">20</option>
												   <option value="21">21</option>
												   <option value="22">22</option>
												   <option value="23">23</option>
												   <option value="24">24</option>
												   <option value="25">25</option>
												   <option value="26">26</option>
												   <option value="27">27</option>
												   <option value="28">28</option>
												   <option value="29">29</option>
												   <option value="30">30</option>
												   <option value="31">31</option>
													<option value="" selected="selected">day</option>	
												 </select>
												 
												 <select name="starting_date_year" class="text">
												   <option value="2010">2010</option>
												   <option value="2011">2011</option>
												   <option value="2012">2012</option>
												   <option value="" selected="selected">year</option>	
												 </select>						
					</td>
				</tr>		
				
				
				
				<tr>
					<td width="11%" height="28">Ending Date<font color="#FF0000"><strong>*</strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
												<select name="end_date_month" class="text">
												   <option value="01">Jan</option>
												   <option value="02">Feb</option>
												   <option value="03">Mar</option>
												   <option value="04">Apr</option>
												   <option value="05">May</option>
												   <option value="06">Jun</option>
												   <option value="07">Jul</option>
												   <option value="08">Aug</option>
												   <option value="09">Sep</option>
												   <option value="10">Oct</option>
												   <option value="11">Nov</option>
												   <option value="12">Dec</option>
												   <option value="" selected="selected">Month</option>		
										    	</select>
												
												 <select name="end_date_day" class="text">
												   <option value="01">01</option>
												   <option value="02">02</option>
												   <option value="03">03</option>
												   <option value="04">04</option>
												   <option value="05">05</option>
												   <option value="06">06</option>
												   <option value="07">07</option>
												   <option value="08">08</option>
												   <option value="09">09</option>
												   <option value="10">10</option>
												   <option value="11">11</option>
												   <option value="12">12</option>
												   <option value="13">13</option>
												   <option value="14">14</option>
												   <option value="15">15</option>
												   <option value="16">16</option>
												   <option value="17">17</option>
												   <option value="18">18</option>
												   <option value="19">19</option>
												   <option value="20">20</option>
												   <option value="21">21</option>
												   <option value="22">22</option>
												   <option value="23">23</option>
												   <option value="24">24</option>
												   <option value="25">25</option>
												   <option value="26">26</option>
												   <option value="27">27</option>
												   <option value="28">28</option>
												   <option value="29">29</option>
												   <option value="30">30</option>
												   <option value="31">31</option>
													<option value="" selected="selected">day</option>	
												 </select>
												 
												 <select name="end_date_year" class="text">
												   <option value="2010">2010</option>
												   <option value="2011">2011</option>
												   <option value="2012">2012</option>
												   <option value="2013">2013</option>
												   <option value="2014">2014</option>
												   <option value="2015">2015</option>
												   <option value="2016">2016</option>
												   <option value="2017">2017</option>
												   <option value="2018">2018</option>
												   <option value="2019">2019</option>
												   <option value="2020">2020</option>
												   <option value="" selected="selected">year</option>	
												 </select>							
					</td>
				</tr>										
				
				
				
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>					
				<tr>
					<td width="11%" height="28" valign="top">Job Position<em>(optional)</em></td>
					<td width="1%">:</td>
					<td width="88%">
						<input type="text" id="job_position" name="job_position" class="select">
						<br /><em>(This will be use when the client has no Active or Current Job Advertisement)</em>
						<br /><br />
						<font color="#FF0000" size="3"><strong>*</strong> Indicates required fields</font>
					</td>
				</tr>	
								
																						
				<tr>
					<td colspan="3">
						<div id="client_details" >&nbsp;</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="save" value="Save"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top"></td>
	</tr>
</table>
</form>




</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>

</body>
</html>



