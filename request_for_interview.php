<?php
include 'config.php';
include 'conf.php';

$applicant_id = @$_REQUEST["userid"];

if(@isset($_REQUEST["register"]))
{
	$time=$_REQUEST['start_hour'].": ".$_REQUEST['start_minute']." ".$_REQUEST['type'];
	if($_REQUEST['start_hour'] == "" || $_REQUEST['start_minute'] == "")
	{
		$time = "";
	}
	$date_interview=$_REQUEST['start_year']."-".$_REQUEST['start_month']."-".$_REQUEST['start_day'];
	$time_zone=$_REQUEST['time_zone'];	
	$fname=$_REQUEST['fname'];
	$lname=$_REQUEST['lname'];
	$email=$_REQUEST['email'];
	$companyname=$_REQUEST['companyname'];
	$officenumber=$_REQUEST['officenumber'];
	$comment=$_REQUEST['comment'];
	$mobile=$_REQUEST['mobile'];
	$date = date("Y-m-d");
	
	//ADD NEW LEAD	
	$AusTime = date("H:i:s"); 
	$AusDate = date("Y")."-".date("m")."-".date("d");
	$ATZ = $AusDate." ".$AusTime;
	
	$agent_no = "";
	$companydesc="";
	$name = "";
	$agent_code = "";
	$length=strlen($agent_code);
	
	$tracking_no =$agent_code."OUTBOUNDCALL";
	
	$jobresponsibilities="";
	$rsnumber="";
	$needrs="";
	$rsinhome="";
	$rsinoffice="";
	$questions="";
	
	$companyposition="";
	$companyaddress="";
	$website="";
	$companydesc="";
	$industry="";
	$noofemployee="";
	$used_rs="";

	if ($used_rs=="Yes")
	{
		$usedoutsourcingstaff="";
	}
	if ($used_rs=="No")
	{
		$usedoutsourcingstaff="";
	}
	
	$companyturnover="";
	$openreferral="";
	
	$y =date('Y');
	$m =date('m');
	$d= date('d');
	$date =$y."-".$m."-".$d; 
	$sql="SELECT * FROM leads  WHERE DATE_FORMAT(timestamp,'%Y-%m-%d') = '$date';";
	$res=mysql_query($sql);
	$ctr=@mysql_num_rows($res);
	if ($ctr >0 )
	{
		$row = mysql_fetch_array ($res); 
		$ctr=$ctr+1;
		$personal_id="L".$y.$d.$m."-".$ctr;	
	}
	else
	{	$ctr=1;
		$personal_id="L".$y.$d.$m."-".$ctr;	
	}
	$leads_id = 0;
	$query=mysql_query("SELECT id FROM leads WHERE email='$email'");
	while ($row = mysql_fetch_assoc($query)) 
	{
		$leads_id = $row['id'];
	}
	if($leads_id == 0)
	{
		$query="INSERT INTO leads SET 
				tracking_no = '$tracking_no',
				timestamp = '$ATZ' ,
				status = 'New Leads' ,
				remote_staff_competences = '$jobresponsibilities',
				remote_staff_needed = '$rsnumber', 
				remote_staff_needed_when = '$needrs', 
				remote_staff_one_home = '$rsinhome', 
				remote_staff_one_office = '$rsinoffice',
				your_questions = '$questions', 
				fname = '$fname',
				lname = '$lname', 
				company_position = '$companyposition', 
				company_name = '$companyname', 
				company_address = '$companyaddress', 
				email = '$email', 
				website= '$website', 
				officenumber = '$officenumber', 
				mobile = '$mobile', 
				company_description = '$companydesc', 
				company_size = '$noofemployee', 
				outsourcing_experience = '$used_rs', 
				outsourcing_experience_description = '$usedoutsourcingstaff', 
				company_turnover = '$companyturnover',
				personal_id = '$personal_id',
				show_to_affiliate = 'YES',
				agent_id = '$agent_no' ;";
				$result=mysql_query($query);
				$query=mysql_query("SELECT id FROM leads WHERE email='$email'");
				while ($row = mysql_fetch_assoc($query)) 
				{
					$leads_id = $row['id'];
				}
	}
	//END ADD NEW LEAD
	
	//ADD REQUEST
	$query="INSERT INTO tb_request_for_interview SET 
		leads_id = '$leads_id',
		applicant_id = '$applicant_id',
		fname = '$fname',
		lname = '$lname',
		email = '$email',
		office_number = '$officenumber',
		mobile_number = '$mobile',
		comment = '$comment',
		date_interview = '$date_interview',
		time = '$time',
		time_zone = '$time_zone',
		status = 'NEW',
		date_added = '$date'
		;";
		$result=mysql_query($query);
	//ADD REQUEST

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


			//SEND TO ADMIN
			$from_email=$email;
			$subject ="Request for Interview(".$fname." ".$lname.")";
			
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$email." \r\n"."Reply-To: ".$email."\r\n";	

			$date=date('l jS \of F Y h:i:s A');
			
			$body = '
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
			<div id="paragraph" style="">

					<table width="30%"  border="0" cellspading=3 cellspacing=3>
					  <tr>
						<td colspan=2><strong>'.$date.'</strong><br /><br /></td>
					  </tr>
					  <tr>
						<td><strong>Date: </strong></td>
						<td width=70%>'.$date_interview.'</td>
					  </tr>
					  <tr>
						<td><strong>Time: </strong></td>
						<td>'.$time.'</td>
					  </tr>
					  <tr>
						<td><strong>Time Zone: </strong></td>
						<td>'.$time_zone.'</td>
					  </tr>
					  <tr>
						<td><strong>Name: </strong></td>
						<td>'.$fname.' '.$lname.'</td>
					  </tr>
					  <tr>
						<td><strong>Company Name: </strong></td>
						<td>'.$companyname.'</td>
					  </tr>
					  <tr>
						<td><strong>Office No.</strong></td>
						<td>'.$officenumber.'</td>
					  </tr>
					  <tr>
						<td><strong>Mobile No.</strong></td>
						<td>'.$mobile.'</td>
					  </tr>
					  <tr>
						<td><strong>Comment: </strong></td>
						<td>'.$comment.'</td>
					  </tr>
					</table>
			</div>
			';
			if (TEST) 
			{		
				$admin_email = "devs@remotestaff.com.au";			
			}
			mail($admin_email, $subject, $body, $header);
			//END SEND TO ADMIN


			//SEND TO CANDIDATE
			$name = mysql_query("SELECT fname, lname, email FROM personal WHERE userid='$applicant_id' LIMIT 1");
			$candidate_fname = mysql_result($name,0,"fname");
			$candidate_lname = mysql_result($name,0,"lname");
			$candidate_email = mysql_result($name,0,"email");
			
			$from_email="ricag@remotestaff.com.au";
			$subject ="Request for Interview(".$fname." ".$lname.")";
			
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from_email." \r\n"."Reply-To: ".$from_email."\r\n";	

			$date=date('l jS \of F Y h:i:s A');
			
			$body = '
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
			<div id="paragraph" style="">

			<table width="100%"  border="0" cellspading=3 cellspacing=3>
			  <tr>
				<td><strong>'.$date.'</strong><br /><br /></td>
			  </tr>
			  <tr>
				<td>
					Hi '.$candidate_fname.' '.$candidate_lname.',<br /><br />
					You have been invited by '.$fname.' '.$lname.' for an interview.<br /><br />
					<table width="30%"  border="0" cellspading=3 cellspacing=3>
					  <tr>
						<td colspan=2><strong>'.$date.'</strong><br /><br /></td>
					  </tr>
					  <tr>
						<td><strong>Date: </strong></td>
						<td width=70%>'.$date_interview.'</td>
					  </tr>
					  <tr>
						<td><strong>Time: </strong></td>
						<td>'.$time.'</td>
					  </tr>
					  <tr>
						<td><strong>Time Zone: </strong></td>
						<td>'.$time_zone.'</td>
					  </tr>
					  <tr>
						<td><strong>Name: </strong></td>
						<td>'.$fname.' '.$lname.'</td>
					  </tr>
					  <tr>
						<td><strong>Company Name: </strong></td>
						<td>'.$companyname.'</td>
					  </tr>
					  <tr>
						<td><strong>Office No.</strong></td>
						<td>'.$officenumber.'</td>
					  </tr>
					  <tr>
						<td><strong>Mobile No.</strong></td>
						<td>'.$mobile.'</td>
					  </tr>
					  <tr>
						<td><strong>Comment: </strong></td>
						<td>'.$comment.'</td>
					  </tr>
					</table>
				</td>
			  </tr>
				<tr>	
					<td colspan=2>
					'.$signature_template.'
					</td>
				</tr>
			</table>
			</div>
			';
			if (TEST) 
			{		
				$candidate_email = "devs@remotestaff.com.au";			
			}			
			mail($candidate_email, $subject, $body, $header);
			//END SEND TO CANDIDATE


			//SEND TO CLIENT
			$from_email="ricag@remotestaff.com.au";
			$subject ="Request for Interview(".$fname." ".$lname.")";
			
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from_email." \r\n"."Reply-To: ".$from_email."\r\n";	

			$date=date('l jS \of F Y h:i:s A');
			
			$body = '
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
			<div id="paragraph" style="">

			<table width="100%"  border="0" cellspading=3 cellspacing=3>
			  <tr>
				<td><strong>'.$date.'</strong><br /><br /></td>
			  </tr>
			  <tr>
				<td>
					Hi '.$fname.',<br /><br />
					Your request has been sent to the candidate.
				</td>
			  </tr>
				<tr>	
					<td colspan=2>
					'.$signature_template.'
					</td>
				</tr>
			</table>
			</div>
			';
			if (TEST) 
			{		
				$email = "devs@remotestaff.com.au";			
			}						
			mail($email, $subject, $body, $header);
			//END SEND TO CLIENT

	echo '
	<script language="javascript">
		alert("Your request has been successfully submitted. Thank You!");
		window.close();
	</script>
	';
}

?>
<html>
<head>
<title>Online Inquiry Form</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript">
	function validate(form)
	{
		if (form.start_month.value == '') { alert("You forgot to select the month."); form.start_month.focus(); return false; }
		if (form.start_day.value == '') { alert("You forgot to select the day."); form.start_day.focus(); return false; }
		if (form.start_year.value == '') { alert("You forgot to select the year."); form.start_year.focus(); return false; }
		if (form.fname.value == '') { alert("You forgot to enter your first name."); form.fname.focus(); return false; }
		if (form.lname.value == '') { alert("You forgot to enter your last name."); form.lname.focus(); return false; }
		if (form.companyname.value == '') { alert("You forgot to enter the company name."); form.companyname.focus(); return false; }
		
		if (form.email.value == '') { alert("You forgot to enter your email address."); form.email.focus(); return false; }
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
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="?userid=<?php echo $applicant_id; ?>" method="post" onSubmit="return validate(this)">

<!-- HEADER -->
<center>
<table width=95% cellpadding=3 cellspacing=3 border=0 >
<tr>
<td width=100% valign=top >

<table width="100%" cellpadding=3 cellspacing="5">
<tr bgcolor="#CCCCCC">
<td colspan="2" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#000000"><B>REQUEST F0R INTERVIEW</B></font></tr>
<tr>
<td width="50%" valign="top">



<table width="100%"  cellspacing="3" cellpadding="3"> 
  <tr>
  	<td colspan="3"><font color="#FF0000"><strong>NOTE: Request should be made at least 2 business day before the meeting time</strong> (Weekday and weekend)</font> </td>
  </tr>
  <tr>
  	<td colspan="3">&nbsp;</td>
  </tr> 
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Date</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
	
	<!--date here --->
	<table>
		<tr>
<td>

																				<SELECT ID="start_month_id" NAME="start_month" class="text">

																					<OPTION VALUE="1">Jan</OPTION>

																					<OPTION VALUE="2">Feb</OPTION>

																					<OPTION VALUE="3">Mar</OPTION>

																					<OPTION VALUE="4">Apr</OPTION>

																					<OPTION VALUE="5">May</OPTION>

																					<OPTION VALUE="6">Jun</OPTION>

																					<OPTION VALUE="7">Jul</OPTION>

																					<OPTION VALUE="8">Aug</OPTION>

																					<OPTION VALUE="9">Sep</OPTION>

																					<OPTION VALUE="10">Oct</OPTION>

																					<OPTION VALUE="11">Nov</OPTION>

																					<OPTION VALUE="12">Dec</OPTION>

																				</SELECT>											

											</td>

											<td>

                                                                                <select id="start_day_id" name="start_day" class="text">

																				  <option value="1">01</option>

                                                                                  <option value="2">02</option>

                                                                                  <option value="3">03</option>

                                                                                  <option value="4">04</option>

                                                                                  <option value="5">05</option>

                                                                                  <option value="6">06</option>

                                                                                  <option value="7">07</option>

                                                                                  <option value="8">08</option>

                                                                                  <option value="9">09</option>

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

                                                                                </select>												

											</td>

											<td>

																			  <SELECT ID="start_year_id" NAME="start_year" class="text">

																				<OPTION VALUE="2009">2009</OPTION>

																				<OPTION VALUE="2009">2010</OPTION>
																				
																				<OPTION VALUE="2009">2011</OPTION>

																			  </SELECT>											

											</td>		
		</tr>
	</table>
	<!--end date here --->
	
	
	</td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Time</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
	
	<!--- time ---->
																<table>
																	<tr>
																		<td>

																				<SELECT ID="start_hour_id" NAME="start_hour" class="text">

																					<OPTION VALUE='' SELECTED>Hour</OPTION>

																					<OPTION VALUE=1>1</OPTION>

																					<OPTION VALUE=2>2</OPTION>

																					<OPTION VALUE=3>3</OPTION>

																					<OPTION VALUE=4>4</OPTION>

																					<OPTION VALUE=5>5</OPTION>

																					<OPTION VALUE=6>6</OPTION>

																					<OPTION VALUE=7>7</OPTION>

																					<OPTION VALUE=8>8</OPTION>

																					<OPTION VALUE=9>9</OPTION>

																					<OPTION VALUE=10>10</OPTION>

																					<OPTION VALUE=11>11</OPTION>

																					<OPTION VALUE=12>12</OPTION>

																				</SELECT>											

											</td>

											<td>

                                                                                <select id="start_minute_id" name="start_minute" class="text">

																				  <option value="" selected>Minute</option>

																				  <option value="0">00</option>

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

																				  <option value="60">60</option>

                                                                                </select>												

											</td>
											<td>
																		<select id="type_id" name="type" class="text">
																				  <option value="AM">AM</option>
                                                                                  <option value="PM">PM</option>

                                                                                </select>											
											</td>
										</tr>
									</table>		
	<!--- end time ---->

	</td>
  </tr>  
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Time&nbsp;Zone</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="time_zone_id" name="time_zone" class="select" /></td>
  </tr>    
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>     
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>First Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="fname_id" name="fname" class="select" /></td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Last Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="lname_id" name="lname" class="select" /></td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Email </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="email_id" name="email" class="select" /></td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Name</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyname_id" name="companyname" class="select"  /></td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Office Number</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="officenumber_id" name="officenumber"  class="select" /></td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Mobile No. </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="mobile_id" name="mobile"  class="select" /></td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'> Comment </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea cols="25" rows="5" name="comment" id="comment_id" class="select" ></textarea></td>
  </tr>
  <tr>
    <td width='20%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'></td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'></td>
    <td width='80%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="submit" name="register" value="Submit Form" class="button" /></td>
  </tr>
</table>



</td>
</table>
<!-- -->
</td>
</tr></table>
</center>
</form>

</body>
</html>
