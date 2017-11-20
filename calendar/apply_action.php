<?

putenv("TZ=Australia/Sydney");

include 'config.php';

include 'function.php';

include 'conf.php';

$agent_no = $_SESSION['agent_no'];

$hid =$_REQUEST['hid'];

$mode =$_REQUEST['mode'];

$hmode =$_REQUEST['hmode'];

$leads_id=$_REQUEST['id'];



$code=$_REQUEST['code'];

if($code==1){

	$code="<tr><td colspan='2' bgcolor='#FFFFCC' align='center'><b>Email Sent</b></td></tr>";

}

//Failed to send email

if($code==2){

	$code="<tr><td colspan='2' bgcolor='#FFFFCC' align='center'><b style='color:#FF0000'>Failed to Send Email</b></td></tr>";

}





if($hmode!="" && $hmode=='delete')

{

	$query="DELETE FROM history WHERE id=$hid;";

	mysql_query($query);

	

}



$sql ="SELECT * FROM history WHERE id = $hid;";

$res=mysql_query($sql);

$ctr=@mysql_num_rows($res);

if ($ctr >0)

{

	$row = mysql_fetch_array($res);

	$desc=$row['history'];;

	

	

}

//echo $agent_no;



/*

id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip



*/

$query ="SELECT * FROM leads WHERE id = $leads_id;";

$result=mysql_query($query);

$ctr=@mysql_num_rows($result);

if ($ctr >0 )

{

	//$row = mysql_fetch_array ($result, MYSQL_NUM); 

	$row = mysql_fetch_array($result);



	$tracking_no =$row['tracking_no'];

	$timestamp =$row['timestamp'];

	$status =$row['status'];

	$call_time_preference =$row['call_time_preference'];

	$remote_staff_competences =$row['remote_staff_competences'];

	$remote_staff_needed =$row['remote_staff_needed'];

	$remote_staff_needed_when =$row['remote_staff_needed_when'];

	$$remote_staff_one_home =$row['$remote_staff_one_home'];

	$remote_staff_one_office =$row['remote_staff_one_office'];

	$your_questions =$row['your_questions'];

		

	$lname =$row['lname'];

	$fname =$row['fname'];

	$company_position =$row['company_position'];

	$company_name =$row['company_name'];

	$company_address =$row['company_address'];

	$email =$row['email'];

	$website =$row['website'];

	$officenumber =$row['officenumber'];

	$mobile =$row['mobile'];

	$company_description =$row['company_description'];

	$company_industry =$row['company_industry'];

	$company_size =$row['company_size'];

	$outsourcing_experience =$row['outsourcing_experience'];

	$outsourcing_experience_description =$row['outsourcing_experience_description'];

	$company_turnover =$row['company_turnover'];

	

	$your_questions=str_replace("\n","<br>",$your_questions);

	$outsourcing_experience_description=str_replace("\n","<br>",$outsourcing_experience_description);

	$company_description=str_replace("\n","<br>",$company_description);

	

	$rate =$row['rating'];

	$personal_id =$row['personal_id'];

	

	

	// Newly added

	$leads_country = $row['leads_country'];

	$leads_ip = $row['leads_ip'];

	

	if($rate=="1")

		{

			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";

		}

		if($rate=="2")

		{

			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";

		}

		if($rate=="3")

		{

			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";

		}

		if($rate=="4")

		{

			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";

		}

		if($rate=="5")

		{

			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";

		}

	

	

}

?>



<html>

<head>

<title>Business Partner Manage New Lead</title>

<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="css/style.css">



<link rel=stylesheet type=text/css href="menu.css">

<script language=javascript src="js/functions.js"></script>

<link rel=stylesheet type=text/css href="product_need/product_needs.css">

<script language=javascript src="product_need/product_need.js"></script>

<script type="text/javascript">

<!--

function checkFields()

{

	if(document.form.star.selectedIndex==0)

	{

	

		missinginfo = "";

		if(document.form.txt.value=="")

		{

			missinginfo += "\n     -  There is no message or details to be save or send \t \n Please enter details.";

		}

		if (document.form.mode.value =="")

		{

			if (document.form.fill.value=="" )

			{

				missinginfo += "\n     -  Please choose actions.";

			}

			if (document.form.fill.value=="EMAIL" )

			{

				if (document.form.subject.value=="" )

				{

					missinginfo += "\n     -  Please enter a subject in your Email.";

				}

				if (document.form.templates[0].checked==false && document.form.templates[1].checked==false && document.form.templates[2].checked==false)

				{

					missinginfo += "\n     -  Please choose email templates.";

				}

			}

		}	

		if (missinginfo != "")

		{

			missinginfo =" " + "You failed to correctly fill in the required information:\n" +

			missinginfo + "\n\n";

			alert(missinginfo);

			return false;

		}

		else return true;

	}



	

}



	function popup_calendar(id) 



	{



		previewPath = "calendar/popup_calendar.php?id="+id;



		window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');



	}

-->

</script>	









<!-- ROY'S CODE ------------------->

		<script language="javascript">

		var chck = 0;

		var temp = '';

		var int=self.setInterval('check_schedule(temp)',9000)	

		var curSubMenu = '';	

		function check_schedule(id)

		{

			chck = 0;

			http.open("GET", "return_schedule.php?id="+id, true);

			http.onreadystatechange = handleHttpResponse;

			http.send(null);

		}

		function hideAlarm(id)

		{

			chck = 0;

			document.getElementById('support_sound_alert').innerHTML='';

			document.getElementById('alarm').style.visibility='hidden';

			check_schedule(id);

		}

		//ajax



		function handleHttpResponse() 

		{

			if (http.readyState == 4) 

			{

				var temp = http.responseText;

				if(temp == "" || temp == '')

				{

					//do nothing

					//document.getElementById('support_sound_alert').innerHTML = "";

				}

				else

				{

					document.getElementById('alarm').innerHTML = http.responseText;			

					document.getElementById('alarm').style.visibility='visible';							

					//if(chck == 0)

					//{

						//document.getElementById('support_sound_alert').innerHTML = "<EMBED SRC='calendar/media/crawling.mid' hidden=true autostart=true loop=1>";

						//chck = 1;

					//}

				}	

			}

		}

		function getHTTPObject() 

		{

					var x 

					var browser = navigator.appName 

					if(browser == 'Microsoft Internet Explorer'){

						x = new ActiveXObject('Microsoft.XMLHTTP')

					}

					else

					{

						x = new XMLHttpRequest()

					}

					return x		

		}

		var http = getHTTPObject();		

		//ajax		

		

		//menu

		//var curSubMenu='';

		function showSubMenu(menuId){

				if (curSubMenu!='') hideSubMenu();

				eval('document.all.'+menuId).style.visibility='visible';

				curSubMenu=menuId;

		}

		

		function hideSubMenu(){

				eval('document.all.'+curSubMenu).style.visibility='hidden';

				curSubMenu='';

		}

		//menu		

		

		

		</script>		

<!-- ROY'S CODE ------------------->			









<style type="text/css">

<!--

	div.scroll {

		height: 100px;

		width: 100%;

		overflow: auto;

		border: 1px solid #CCCCCC;

		padding: 8px;

		

	}

	.scroll p{

		margin-bottom: 10px;

		margin-top: 4px;

	}

	.spanner

	{

		float: right;

		text-align: right;

		padding:5px 0 5px 10px;

	

	

	}

	.spannel

	{

		float: left;

		text-align:left;

		padding:5px 0 5px 10px;

		border:#f2cb40 solid 1px;

		

	}	

.l {

	float: left;

	}	



.r{

	float: right;

	}

	

.btn{

	font:11px Tahoma;

}	

-->

</style>	

	

	

</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<form method="POST" name="form" action="apply_actionphp.php" enctype="multipart/form-data"  onsubmit="return checkFields();">

<input type="hidden" name="id" id="leads_id" value="<? echo $leads_id;?>">

<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">

<input type="hidden" name="fill" value="">

<input type="hidden" name="mode" value="<? echo $mode;?>">

<input type="hidden" name="hid" value="<? echo $hid;?>">

<input type="hidden" name="fullname" value="<? echo $fname." ".$lname;?>">

<input type="hidden" name="email" value="<? echo $email;?>">



<!-- HEADER -->



<? include 'header.php';?>

<ul class="glossymenu">

 <li ><a href="agentHome.php"><b>Home</b></a></li>

 

  <li class="current"><a href="newleads.php"><b>New Leads</b></a></li>

  <li ><a href="follow_up_leads.php"><b>Follow Up</b></a></li>

  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>

  <li ><a href="client_listings.php"><b>Clients</b></a></li>



</ul>

<table width=100% cellpadding=0 cellspacing=0 border=0 >

<tr><td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>

<? include 'agentleftnav.php';?>

<br></td>

<td valign=top align=left>



<table width=98% cellspacing=8 cellpadding=2 border=0 align=left >

<?=$code;?>

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Manage New Lead Lead</b></td></tr>









<!-- appointments calendar -->

<tr>

	<td colspan=2 >

		<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">

			<tr>

				<td valign="middle" onClick="javascript: window.location='calendar/popup_calendar.php?back_link=1&id=<?php echo @$_GET["id"]; ?>'; " colspan=3 onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; ">

					<a href="calendar/popup_calendar.php?back_link=1&id=<?php echo @$_GET["id"]; ?>" target="_self"><img src='images/001_44.png' alt='Calendar' align='texttop' border='0'></a><strong>&nbsp;&nbsp;Add New Appointment				</strong>

				</td>

			</tr>

		</table>			

	</td>

</tr>

<!-- appointments calendar -->





<!-- appointments -->

<tr>

	<td colspan=2 >


<table width="100%">
	<tr>
		<td width="33%" valign="top">







							<?php

								require_once("conf/connect.php");

								$time_offset ="0"; // Change this to your time zone

								$time_a = ($time_offset * 120);

								$h = date("h",time() + $time_a);

								$m = date("i",time() + $time_a);

								$d = date("Y-m-d" ,time());

								$type = date("a",time() + $time_a);								

							

								$db=connsql();

								$c = mysql_query("SELECT id FROM tb_appointment WHERE user_id='$agent_no' AND date_start='$d'");	

							

								$num_result = mysql_num_rows($c);

							?>

										<table width="100%">							
			
											<tr><td bgcolor="#F1F1F3" height="25" colspan=3><font color='#000000'><b>Today's Appointments(<?php echo $num_result; ?>)</b></font><br /></td></tr>
			
											<?php if($num_result > 0) { ?>
			
											<tr >
			
												<td colspan=3 valign="top" >
			
														<iframe id="frame" name="frame" width="100%" height="100" src="todays_appointments.php?agent_no=<?php echo $agent_no; ?>" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
			
												</td>	
			
											</tr>
											<?php } ?>
										</table>		





		</td>
		
		
		<td width="33%" valign="top">

										<?php
			
											$c = mysql_query("SELECT id FROM tb_appointment WHERE user_id='$agent_no' AND date_start > '$d'");	
			
											$num_result = mysql_num_rows($c);
			
										?>
			
										<table width="100%">							
			
											<tr><td bgcolor="#F1F1F3" height="25" colspan=3><font color='#000000'><b>Other Days Appointments(<?php echo $num_result; ?>)</b></font><br /></td></tr>
			
											<?php if($num_result > 0) { ?>
			
											<tr >
			
												<td colspan=3 valign="top" >
			
														<iframe id="frame" name="frame" width="100%" height="100" src="other_appointments.php?agent_no=<?php echo $agent_no; ?>" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
			
												</td>	
			
											</tr>
											<?php } ?>
										</table>			


		</td>		


		<td width="33%" valign="top">

										<?php
			
											$c = mysql_query("SELECT id FROM tb_calendar_notes");	
			
											$num_result = mysql_num_rows($c);
			
										?>
			
										<table width="100%">							
			
											<tr><td bgcolor="#F1F1F3" height="25" colspan=3><font color='#000000'><b>Issues/Problems(<?php echo $num_result; ?>)</b></font><br /></td></tr>
			
											<?php if($num_result > 0) { ?>
			
											<tr >
			
												<td colspan=3 valign="top" >
			
														<iframe id="frame" name="frame" width="100%" height="100" src="notes_list.php" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
			
												</td>	
			
											</tr>
											<?php } ?>
										</table>			


		</td>		
	</tr>	
</table>




	</td>

</tr>

<!-- appointments -->












<tr><td colspan=2 >

<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
<tr>
<td valign="top" colspan="3">
<div style="background:#DBDBDB; padding:5px; border:#DBDBDB outset 1px;"><b>Steps Taken</b></div>
<div style="padding:5px; border:#DBDBDB solid 1px;">
<?
	//Check if the leads is given by quote and set-up fee invoice
	//echo $id;
	//Quote 
	$sqlQuote="SELECT * FROM quote q WHERE leads_id = $leads_id;";
	$data = mysql_query($sqlQuote);
	$ctr = mysql_num_rows($data);
	if($ctr>0){
		echo "<div>".$ctr." Quote(s) Given</div>";
	}
	// Set-Up Fee
	$sqlSetUpFeeInvoice ="SELECT * FROM set_up_fee_invoice s WHERE leads_id = $leads_id;";
	$data = mysql_query($sqlSetUpFeeInvoice);
	$ctr = mysql_num_rows($data);
	if($ctr>0){
		echo "<div>".$ctr." Set-Up Fee Tax Invoice</div>";
	}
	?>
</div>	
</td>
</tr>

<tr><td valign="top" colspan="3" align="right"><a href="updateinquiry.php?leads_id=<? echo $leads_id;?>&page=NEW">Edit</a></td></tr>



<tr><td><b>Lead ID</b></td><td>:</td><td><? echo $personal_id;?></td></tr>

<tr><td valign="top"><b>Lead Ratings</b></td><td>:</td><td valign="top">

<div>

<div style=" float:left;width:100px; display:block;"><? echo $rate;?></div><div style=" float:left; display:block; margin-left:10px; color:#999999;font:10px tahoma; "> 

<select name="star" style="font:10px tahoma;" >

<option value="0">-</option>

<option value="1">1</option>

<option value="2">2</option>

<option value="3">3</option>

<option value="4">4</option>

<option value="5">5</option>

</select>&nbsp;

<input type="submit" name="rate" style="font:10px tahoma;"  value="Rate">&nbsp;<i>(Ratings : 1 <img src="images/star.png" align="texttop"> = Low potential  ----  5 <img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top">=Highest potential)</i></div>

</div>

</td></tr>



<tr><td width="27%" valign="top" ><b>Date Registered</b></td>

<td width="2%" valign="top">:</td>

<td width="71%" valign="top"><? echo format_date($timestamp);?></td>

</tr>

<tr><td valign="top"><strong>Fullname</strong></td>

<td valign="top">:</td><td valign="top"><? echo $fname." ".$lname; $_SESSION['l_id'] = @$_GET["id"];  $_SESSION['s_name'] = $fname." ".$lname; ?></td></tr>

<tr><td valign="top"><strong>Email</strong></td>

<td valign="top">:</td><td valign="top"><? echo $email;?></td></tr>

<tr><td valign="top"><strong>Country</strong></td>

<td valign="top">:</td><td valign="top"><? echo $leads_country;?></td></tr>

<tr><td valign="top"><strong>IP Address</strong></td>

<td valign="top">:</td><td valign="top"><? echo $leads_ip;?></td></tr>











<tr><td valign="top"><strong>Company name</strong></td>

<td valign="top">:</td><td valign="top"><? echo $company_name;?></td></tr>

<tr><td valign="top"><strong>Job Position</strong></td>

<td valign="top">:</td><td valign="top"><? echo $company_position;?></td></tr>

<tr><td valign="top"><strong>Company Address</strong></td>

<td valign="top">:</td><td valign="top"><? echo $company_address;?></td></tr>

<tr><td valign="top"><strong>Website</strong></td>

<td valign="top">:</td><td valign="top"><? echo $website;?></td></tr>

<tr><td valign="top"><strong>Company No.</strong></td>

<td valign="top">:</td><td valign="top"><? echo $officenumber;?></td></tr>

<tr><td valign="top"><strong>Moblie No</strong></td>

<td valign="top">:</td><td valign="top"><? echo $mobile;?></td></tr>

<tr><td valign="top"><strong>Company Industry</strong></td>

<td valign="top">:</td><td valign="top"><? echo $company_industry;?></td></tr>

<tr><td valign="top"><strong>No. of Employees</strong></td>

<td valign="top">:</td><td valign="top"><? echo $company_size;?></td></tr>

<tr><td valign="top"><strong>Company Turnover in a Year</strong></td>

<td valign="top">:</td><td valign="top"><? echo $company_turnover;?></td></tr>

<tr><td valign="top"><strong>Company Profile</strong></td>

<td valign="top">:</td><td valign="top"><ul style="margin-top:0px; margin-left:2px;"><? echo $company_description;?></ul></td></tr>



<tr><td colspan="3"><hr></td></tr>

<tr><td valign="top"><strong>Call time availability</strong></td>

<td valign="top">:</td><td valign="top"><? echo $call_time_preference;?></td></tr>



<tr><td valign="top"><strong>No. of Remote Staff neeeded</strong></td>

<td valign="top">:</td><td valign="top"><? echo $remote_staff_needed;?></td></tr>

<tr><td valign="top"><strong>Remote Staff needed</strong></td>

<td valign="top">:</td><td valign="top"><? echo $remote_staff_needed_when;?></td></tr>



<tr><td valign="top"><strong>Remote Staff needed in Home Office</strong></td>

<td valign="top">:</td><td valign="top"><? echo $remote_staff_one_home;?></td></tr>

<tr><td valign="top"><strong>Remote Staff needed in Office</strong></td>

<td valign="top">:</td><td valign="top"><? echo $remote_staff_one_office;?></td></tr>

<tr><td valign="top"><strong>Remote Staff responsibilities</strong></td>

<td valign="top">:</td><td valign="top"><? echo $remote_staff_competences;?></td></tr>

<tr><td colspan="3"><hr></td></tr>

<tr><td valign="top"><strong>Questions / Concern</strong></td>

<td valign="top">:</td><td valign="top"><ul style="margin-top:0px; margin-left:2px;"><? echo $your_questions;?></ul></td></tr>

<? if($outsourcing_experience =="Yes")

echo "<tr><td valign=top><b>Outsourcing Experience / Details</b></td><td valign=top>:</td><td valign=top><ul style='margin-top:0px; margin-left:2px;'>".$outsourcing_experience_description."</ul></td></tr>";

?>

		</table>



</td></tr>







































<tr><td colspan="2">

<table width=100% border=0 cellspacing=1 cellpadding=2>

<tr><td align=center>





<input type="button" class="btn" value="Move to Follow-Up" onClick="self.location='moveLead.php?id=<? echo $leads_id;?>&status=Follow-Up'"/>

<input type="button" class="btn" value="Move to Keep In-Touch" onClick="self.location='moveLead.php?id=<? echo $leads_id;?>&status=Keep In-Touch'"/>

<input name="button" type="button" class="btn" onClick="self.location='makeClient.php?id=<? echo $leads_id;?>'" value="Become a Client"/>

<input type="button" class="btn" value="Delete" onClick="self.location='deleteProspect.php?id=<? echo $leads_id;?>'"/>

<input type="button" class="btn"  value="No Longer a Prospect" onClick="self.location='notProspect.php?id=<? echo $leads_id;?>'"/>

<input type="button" class="btn" value="Create Set-Up Fee" onClick="self.location='agent_set_up_fee_invoice.php?leads_id=<? echo $leads_id;?>'"/>

<input type="button" class="btn" value="Quote" onClick="self.location='agent_create_quote.php?leads_id=<? echo $leads_id;?>'"/>



</td>

</tr></table>



</td></tr>







































<tr><td width=100% colspan=2>

<div id="product_needs">

	<div class="product_box_title"><b>Product Request</b></div>

	<div style="background:#FFFFFF; padding:5px; border:#DEE5EB solid 1px;">

		<div id="product_form">

		<img src="images/ajax-loader.gif">

		</div>

	</div>

</div>

</td></tr>

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Action Records </b></td></tr>

<tr>

  <td  colspan="2" width=30% >

  <p><? echo $fname." ".$lname;?></p>

  <table width=100% border=0 cellspacing=1 cellpadding=2>

  <tr>

  <td width="22%">

  <input type="radio" name="action" value="EMAIL" onclick ="showHide('EMAIL');"> Email

  <a href="sendemail.php?id=<? echo $leads_id;?>">

  <img border="0" src="images/email.gif" alt="Email" width="16" height="10">  </a>  </td>

  <td width="21%">

  <input type="radio" name="action" value="CALL" onclick ="showHide('CALL');"> Call 

  <img src="images/icon-telephone.jpg" alt="Call">  </td>

  <td width="21%">

  <input type="radio" name="action" value="MAIL" onclick ="showHide('MAIL');"> Notes

  <img src="images/textfile16.png" alt="Notes" >  </td>

  <td width="36%">

  <input type="radio" name="action" value="MEETING FACE TO FACE" onclick ="showHide('MEETING FACE TO FACE');"> Meeting face to face

  <img src="images/icon-person.jpg" alt="Meet personally">  </td>

  </tr>

  </table>

  <script language=javascript>

<!--

	function go(id) 

	{

		document.form.fill.value=id;			

	}

	function showHide(actions)

	{

		if(actions=="EMAIL")

		{

		

		newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";

		newitem+="<tr><td>";

		newitem+="<p><b>Subject :</b>&nbsp;&nbsp;<input type=\"text\"  name=\"subject\"></p>";

		newitem+="<B>Message :</B>";

		newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"7\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";

		newitem+="</td></tr>";

		newitem+="<tr><td><b>Send Message as :</b><br>";

		newitem+="<input type=\"radio\" name=\"templates\" value=\"signature\"> Signature Template";

		newitem+="&nbsp;&nbsp;&nbsp;";

		newitem+="<input type=\"radio\" name=\"templates\" value=\"plain\"> Plain Text";

		newitem+="&nbsp;&nbsp;&nbsp;";

		newitem+="<input type=\"radio\" name=\"templates\" value=\"promotional\"> Promotional Template";

		newitem+="<br>";

		newitem+="<b>1) Attach File :</b> <input name=\"image\" type=\"file\" id=\"image\" class=text >";

		newitem+="<br>";

		newitem+="<b>2) Attach File :</b> <input name=\"image2\" type=\"file\" id=\"image2\" class=text >";

		newitem+="<br>";

		newitem+="<b>3) Attach File :</b> <input name=\"image3\" type=\"file\" id=\"image3\" class=text >";

		newitem+="<br>";

		newitem+="<b>4) Attach File :</b> <input name=\"image4\" type=\"file\" id=\"image4\" class=text >";

		newitem+="<br>";

		newitem+="<b>5) Attach File :</b> <input name=\"image5\" type=\"file\" id=\"image5\" class=text >";

		newitem+="</td></tr>";

		newitem+="<tr><td align=center>";

		newitem+="<INPUT type=\"submit\" value=\"Send / Save\" name=\"Add\" class=\"button\" style=\"width:120px\">";

		newitem+="&nbsp;&nbsp;";

		newitem+="<INPUT type=\"reset\" value=\"Cancel\" name=\"Cancel\" class=\"button\" style=\"width:120px\">";

		newitem+="</td></tr></table>";

		document.getElementById("message").innerHTML=newitem;

		document.form.fill.value=actions;



		}

		else

		{

		newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";

		newitem+="<tr><td>";

		newitem+="<B>Add Record :</B>";

		newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"7\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";

		newitem+="</td></tr>";

		newitem+="<tr><td align=center>";

		newitem+="<INPUT type=\"submit\" value=\"Save\" name=\"Add\" class=\"button\" style=\"width:120px\">";

		newitem+="&nbsp;&nbsp;";

		newitem+="<INPUT type=\"reset\" value=\"Cancel\" name=\"Cancel\" class=\"button\" style=\"width:120px\">";

		newitem+="</td></tr></table>";

		document.getElementById("message").innerHTML=newitem;

		document.form.fill.value=actions;

		}

		

	}

-->

</script>  </td>

 </tr>

 <tr>

   <td colspan="2">

<!-- -->

<div id="message">

<table width=100% border=0 cellspacing=1 cellpadding=2 style="border:#CCCCCC solid 1px;">

<tr><td>

<B>Add Record :</B>

<textarea name="txt" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"><? echo $desc;?></textarea>

</td></tr>



<tr><td align=center>

<INPUT type="submit" value="save" name="Add" class="button" style="width:120px">

&nbsp;&nbsp;

<INPUT type="reset" value="Cancel" name="Cancel" class="button" style="width:120px">

</td></tr></table>

</div> 

<!-- --></td>

</tr>



<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Communication History :</b></td></tr>

<tr>

<td  colspan="2" width=30%  >

<?

function getCreator($created_by , $created_by_type)

{

	if($created_by_type == 'agent')

	{

		$query = "SELECT fname FROM agent a WHERE agent_no = $created_by;";

		$data = mysql_query($query);

		$row = mysql_fetch_array($data);

		$name = "Agent ".$row[0];

	}

	else if($created_by_type == 'admin')

	{

		//return "Admin Norman";

		$query = "SELECT admin_fname FROM admin a WHERE admin_id = $created_by;";

		$data = mysql_query($query);

		$row = mysql_fetch_array($data);

		$name = "Admin ".$row[0];

	}

	else{

		$name="";

	}

	return $name;

	

}



// id, agent_no, leads_id, actions, history, date_created, subject, created_by_type

$sql="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y'),agent_no,created_by_type FROM history WHERE leads_id=$leads_id AND actions ='EMAIL' ORDER BY date_created DESC;";

$result=mysql_query($sql);

$ctr=@mysql_num_rows($result);

if ($ctr >0 )

{

	$counter=0;

	while(list($id,$history,$date ,$created_by , $created_by_type) = mysql_fetch_array($result))

	{

		

		$creator = getCreator($created_by , $created_by_type);

		

		$counter=$counter+1;

		$hist=$history;

		$history=substr($history,0,30);

		$txt.="<div><div class='l'><b>".$counter.")  ".$date."</b>"

		."&nbsp;&nbsp;&nbsp;&nbsp;".

		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a>

		</div>

		<div class='r'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>

		</div>

		<div style='clear:both;'></div>

		<div style='color:#CCCCCC'>-- ".$creator."</div>

		

		";

		

	}

	echo "<p>Email <img src='images/email.gif' alt='Email' width='16' height='10'>";

	echo "<div class='scroll'>".$txt."</div></p>";

}



$sql2="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y'),agent_no,created_by_type FROM history WHERE leads_id=$leads_id AND actions ='CALL' ORDER BY date_created DESC;";

//echo $sql2."<br>";

$result2=mysql_query($sql2);

$ctr2=@mysql_num_rows($result2);

if ($ctr2 >0 )

{

	$counter=0;

	while(list($id,$history, $date,$created_by , $created_by_type) = mysql_fetch_array($result2))

	{

		$creator = getCreator($created_by , $created_by_type);

		$counter=$counter+1;

		$hist=$history;

		$history=substr($history,0,30);

		$txt2.="<div><div class='l'><b>".$counter.")  ".$date."</b>"

		."&nbsp;&nbsp;&nbsp;&nbsp;".

		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a>

		</div>

		<div class='r'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>

		<div style='clear:both;'></div>

		<div style='color:#CCCCCC'>-- ".$creator."</div>

		</div>";

		

	}

	echo "<p>Call <img src='images/icon-telephone.jpg' alt='Call'>";

	echo "<div class='scroll'>".$txt2."</div></p>";

}



$sql3="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y'),agent_no,created_by_type FROM history WHERE leads_id=$leads_id AND actions ='MAIL' ORDER BY date_created DESC;";

//echo $sql3."<br>";

$result3=mysql_query($sql3);

$ctr3=@mysql_num_rows($result3);

if ($ctr3 >0 )

{

	$counter=0;

	while(list($id,$history,$date,$created_by , $created_by_type) = mysql_fetch_array($result3))

	{

		$creator = getCreator($created_by , $created_by_type);

		$counter=$counter+1;

		$hist=$history;

		$history=substr($history,0,30);

		$txt3.="<div><div class='l'><b>".$counter.")  ".$date."</b>"

		."&nbsp;&nbsp;&nbsp;&nbsp;".

		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a>

		</div>

		<div class='r'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>

		<div style='clear:both;'></div>

		<div style='color:#CCCCCC'>-- ".$creator."</div>

		</div>";

		

	}

	echo "<p>Notes  <img src='images/textfile16.png' alt='Mail' >";

	echo "<div class='scroll'>".$txt3."</div></p>";

}



$sql4="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y') ,agent_no,created_by_type FROM history WHERE  leads_id=$leads_id AND actions ='MEETING FACE TO FACE' ORDER BY date_created DESC;";

//echo $sql3."<br>";

$result4=mysql_query($sql4);

$ctr4=@mysql_num_rows($result4);

if ($ctr4 >0 )

{

	$counter=0;

	while(list($id,$history,$date,$created_by , $created_by_type) = mysql_fetch_array($result4))

	{

		$creator = getCreator($created_by , $created_by_type);

		$counter=$counter+1;

		$hist=$history;

		$history=substr($history,0,30);

		$txt4.="<div><div class='l'><b>".$counter.")  ".$date."</b>"

		."&nbsp;&nbsp;&nbsp;&nbsp;".

		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a>

		</div>

		<div class='r'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>

		<div style='clear:both;'></div>

		<div style='color:#CCCCCC'>-- ".$creator."</div>

		</div>";

		

	}

	echo "<p>Meeting face to face <img src='images/icon-person.jpg' alt='Meet personally'>";

	echo "<div class='scroll'>".$txt4."</div></p>";

}



?></td>

</tr>







</table>

</td>

</tr></table>

<script type="text/javascript">

<!--

showProductForm();

--> 

</script>

<? include 'footer.php';?>

</form>









<!-- ROY'S CODE -------------------><!-- ALARM BOX -->

<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>

<div id="support_sound_alert"></div>

<!-- ROY'S CODE -------------------><!-- ALARM BOX -->







</body>

</html>

