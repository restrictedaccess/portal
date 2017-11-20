<?
include 'config.php';
include 'conf.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
$leads_id=$_REQUEST['id'];
$hid =$_REQUEST['hid'];
$mode =$_REQUEST['mode'];
$hmode =$_REQUEST['hmode'];

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





/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program
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
	$referal_program =$row['referal_program'];
	
	$your_questions=str_replace("\n","<br>",$your_questions);
	$contacted_since=$row['contacted_since'];
	$client_since=$row['client_since'];
	$rate =$row['rating'];
	$personal_id =$row['personal_id'];
	
	if($rate=="1")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
	
}



?>

<html>
<head>
<title>Business Partner Client's  Work Flow</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
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

-->
</script>	
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
	
	#l {
	float: left;
	width: 350px;
	text-align:left;
	padding:5px 0 5px 10px;
	
	
	}	

#r{
	float: right;
	width: 120px;
	text-align: right;
	padding:5px 0 5px 10px;
	
	
	}
	
	#l2 {
	float: left;
	width: 200px;
	text-align:left;
	padding:5px 0 5px 10px;
	
	
	}	

#r2{
	float: right;
	width: 150px;
	text-align: right;
	padding:5px 0 5px 10px;
	
	
	}
#contentwrapper{
}

.billcontent{
width: 100%;
display:block;

}
.reminders{
font-weight:bold
}
-->
</style>		
<script type="text/javascript">
<!--
var billboardeffects=["GradientWipe(wipestyle=1 motion='forward')"] //Uncomment this line and input one of the effects above (ie: "Iris") for single effect.

var tickspeed=4500 //ticker speed in miliseconds (2000=2 seconds)
var effectduration=500 //Transitional effect duration in miliseconds
var hidecontent_from_legacy=1 //Should content be hidden in legacy browsers- IE4/NS4 (0=no, 1=yes).

var filterid=Math.floor(Math.random()*billboardeffects.length)

document.write('<style type="text/css">\n')
if (document.getElementById)
document.write('.billcontent{display:none;\n'+'filter:progid:DXImageTransform.Microsoft.'+billboardeffects[filterid]+'}\n')
else if (hidecontent_from_legacy)
document.write('#contentwrapper{display:none;}')
document.write('</style>\n')

var selectedDiv=0
var totalDivs=0

function contractboard(){
var inc=0
while (document.getElementById("billboard"+inc)){
document.getElementById("billboard"+inc).style.display="none"
inc++
}
}

function expandboard(){
var selectedDivObj=document.getElementById("billboard"+selectedDiv)
contractboard()
if (selectedDivObj.filters){
if (billboardeffects.length>1){
filterid=Math.floor(Math.random()*billboardeffects.length)
selectedDivObj.style.filter="progid:DXImageTransform.Microsoft."+billboardeffects[filterid]
}
selectedDivObj.filters[0].duration=2
selectedDivObj.filters[0].Apply()
}
selectedDivObj.style.display="block"
if (selectedDivObj.filters)
selectedDivObj.filters[0].Play()
selectedDiv=(selectedDiv<totalDivs-1)? selectedDiv+1 : 0
setTimeout("expandboard()",tickspeed)
}

function startbill(){
while (document.getElementById("billboard"+totalDivs)!=null)
totalDivs++
if (document.getElementById("billboard0").filters)
tickspeed+=effectduration
expandboard()
}




//-----
-->
</script>
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="client_workflowphp.php" enctype="multipart/form-data"  onsubmit="return checkFields();">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <!--<li><a href="advertise_positions.php"><b>Applications</b></a></li>-->
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li ><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li class="current"><a href="client_listings.php"><b>Clients</b></a></li>
<!--  <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li> -->
</ul>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=100% valign=top>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td>
<input type="hidden" name="id" value="<? echo $leads_id;?>">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="fill" value="">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<input type="hidden" name="hid" value="<? echo $hid;?>">
<input type="hidden" name="fullname" value="<? echo $fname." ".$lname;?>">
<input type="hidden" name="email" value="<? echo $email;?>">
<!--
<div id="l2">
<p>
<img src="images/arrow_next.gif" align="top" >Recruitment Fee</p>
</div> <div id="r2"><b>Paid :</b> Yes <img src="images/action_check.gif" align="top"> / No <img src="images/action_delete.gif" align="top">&nbsp;&nbsp;</div>
-->
<table width=80% cellspacing=8 cellpadding=2 border=0 align=left >
<tr>
<td valign="bottom" width="100%">
<div class="animatedtabs">
<ul>
<li class="selected"><a href="client_workflow.php?id=<? echo $leads_id;?>" title="Client <? echo $fname." ".$lname;?>"><span>Client</span></a></li>
<li ><a href="client_account.php?id=<? echo $leads_id;?>" title="Client Account"><span>Client Account</span></a></li>
<li ><a href="jobpostings.php?id=<? echo $leads_id;?>" title="Recruiting Preparation"><span>Recruitment Preparation</span></a></li>
<li ><a href="recruitment_1.php?id=<? echo $leads_id;?>" title="Recruiting Process"><span>Recruitment Process Done by HR</span></a></li>
</ul>
</div>
</td>
</tr>










<!-- appointments calendar -->



<tr>



	<td colspan=2 >



		<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">



			<tr>



				<td valign="middle" onClick="javascript: window.location='calendar/popup_calendar.php?back_link=2&id=<?php echo @$_GET["id"]; ?>'; " colspan=3 onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; ">



					<a href="calendar/popup_calendar.php?back_link=3&id=<?php echo @$_GET["id"]; ?>" target="_self"><img src='images/001_44.png' alt='Calendar' align='texttop' border='0'></a><strong>&nbsp;&nbsp;Add New Appointment				</strong>



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














<tr>
<td height="100%" colspan=2 valign="top" >
<!-- Clients Details starts here -->
<table width="100%">
  <tr><td width="74%">
<table width="102%" style="margin-left:10px;" >
<tr>
<td valign="top" colspan="3" >
<div style="background:#FFFFFF; padding:5px; "><b>Steps Taken</b></div>
<div style="padding:5px;">
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
<tr><td valign="top" colspan="3" align="right"><a href="updateinquiry.php?leads_id=<? echo $leads_id;?>&page=CLIENT">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>

<tr>
<td colspan="3">
<? if ($rate!="") {echo "<h4>Client Rate :&nbsp;" .$rate."</h4>"; }?></p>
</td>
</tr>
<tr>
<td ><b>Client ID </b></td><td>:</td>
<td><? echo $personal_id;?></td>
</tr>
<tr>
<td width="14%" ><b>Client </b></td><td>:</td>

<td width="86%"><? echo $fname." ".$lname;?></td>
</tr>
<tr>
<td ><b>Date Registered	</b></td><td>:</td>
<td><? echo format_date($timestamp);?></td>
</tr>
<tr>
<td ><b>Email </b></td><td>:</td>
<td><? echo $email;?></td>
</tr>
<tr>
</table>
</td>
<td width="26%" valign="top" height="100%"><br>
<div style="border:#CCCCCC solid 1px;" >
<h5 style="margin-left:10px; margin-top:5px; margin-bottom:5px;">Rate this Client</h5>
<p style="margin-left:10px; margin-top:20px; margin-bottom:5px;"><b>Ratings : </b></p>
<p style="margin-left:10px; margin-top:10px; margin-bottom:5px;">1 <img src="images/star.png" align="texttop">=Low potential</p>
<p style="margin-left:10px; margin-top:10px; margin-bottom:5px;">5 <img src="images/star.png" align="top">=Highest potential</p>
<p style="margin-left:10px; margin-top:10px; margin-bottom:5px;">&nbsp;
  <select name="star" >
    <option value="0">-</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
  </select>
  <input type="submit" name="rate" value="Rate">
</p>




</div>
</td>
</tr>
</table>
<!-- Clients Details ends here -->
</td>
</tr>
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Action Records </b></td></tr>
<tr>
<td colspan="2">
<table width="100%" style="border:#CCCCCC solid 1px;" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" width="50%" colspan="2" >
<b>Became Client  : <font color="#0000FF" size="2"><i><? echo format_date($client_since);?></i></font></b>
</td>
</tr>
<tr><td colspan="2">&nb</td></tr>


<tr>
<td colspan="2" valign="middle" align="center" width="50%" style="border-left:#CCCCCC solid 1px; " >
<input type="button" name="Back" class="button" value="Move to Follow-Up" onClick="self.location='moveLead.php?id=<? echo $leads_id;?>&status=Follow-Up'"/>&nbsp;&nbsp;
<input type="button" name="Back" class="button" value="Move to Keep In-Touch" onClick="self.location='moveLead.php?id=<? echo $leads_id;?>&status=Keep In-Touch'"/>&nbsp;&nbsp;
<input type="button" name="Back" class="button" value="Delete" onClick="self.location='deleteProspect.php?id=<? echo $leads_id;?>'"/>&nbsp;&nbsp;
<input type="button" name="Back" class="button" value="No Longer a Prospect" onClick="self.location='notProspect.php?id=<? echo $leads_id;?>'"/>&nbsp;&nbsp;
<input type="button"  class="button" value="Create Set-Up Fee" onClick="self.location='agent_set_up_fee_invoice.php?leads_id=<? echo $leads_id;?>'"/>
</td>
</tr>
</table>
</td>
</tr>



<tr>
  <td  colspan="2" width=100% >
  <p><? echo $fname." ".$lname;?></p>
  <table width=100% border=0 cellspacing=1 cellpadding=2>
  <tr>
  <td width="22%">
 <input type="radio" name="action" value="EMAIL" onclick ="showHide('EMAIL');"> Email
  <a href="sendemail.php?id=<? echo $leads_id;?>">
  <img border="0" src="images/email.gif" alt="Email" width="16" height="10">
  </a>
  </td>
  <td width="21%">
  <input type="radio" name="action" value="CALL" onclick ="showHide('CALL');"> Call 
  <img src="images/icon-telephone.jpg" alt="Call">
  </td>
  <td width="21%">
  <input type="radio" name="action" value="MAIL" onclick ="showHide('MAIL');"> Notes
  <img src="images/textfile16.png" alt="Notes" >
  </td>
  <td width="36%">
  <input type="radio" name="action" value="MEETING FACE TO FACE" onclick ="showHide('MEETING FACE TO FACE');"> Meeting face to face
  <img src="images/icon-person.jpg" alt="Meet personally">
  
    </td>
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
 <tr><td colspan="2">
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
<!-- -->
</td>
</tr>

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Communication History :</b></td></tr>
<tr>
<td  colspan="2" width=100%  >
<?
$sql="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y') FROM history WHERE agent_no = $agent_no AND leads_id=$leads_id AND actions ='EMAIL' ORDER BY date_created DESC;";
//echo $sql;
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$counter=0;
	while(list($id,$history,$date) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		$hist=$history;
		$history=substr($history,0,30);
		$txt.="<p><div id='l'><b>".$counter.")  ".$date."</b>"
		."&nbsp;&nbsp;&nbsp;&nbsp;".
		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a></div>
		<div id='r'><a href='client_workflow.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='client_workflow.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		</p>";
		
	}
	echo "<p>Email <img src='images/email.gif' alt='Email' width='16' height='10'>";
	echo "<div class='scroll'>".$txt."</div></p>";
}

$sql2="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y') FROM history WHERE agent_no = $agent_no AND leads_id=$leads_id AND actions ='CALL' ORDER BY date_created DESC;";
//echo $sql2."<br>";
$result2=mysql_query($sql2);
$ctr2=@mysql_num_rows($result2);
if ($ctr2 >0 )
{
	$counter=0;
	while(list($id,$history,$date) = mysql_fetch_array($result2))
	{
		$counter=$counter+1;
		$hist=$history;
		$history=substr($history,0,30);
		$txt2.="<p><div id='l'><b>".$counter.")  ".$date."</b>"
		."&nbsp;&nbsp;&nbsp;&nbsp;".
		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a></div>
		<div id='r'><a href='client_workflow.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='client_workflow.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		</p>";
		
	}
	echo "<p>Call <img src='images/icon-telephone.jpg' alt='Call'>";
	echo "<div class='scroll'>".$txt2."</div></p>";
}

$sql3="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y') FROM history WHERE agent_no = $agent_no AND leads_id=$leads_id AND actions ='MAIL' ORDER BY date_created DESC;";
//echo $sql3."<br>";
$result3=mysql_query($sql3);
$ctr3=@mysql_num_rows($result3);
if ($ctr3 >0 )
{
	$counter=0;
	while(list($id,$history,$date) = mysql_fetch_array($result3))
	{
		$counter=$counter+1;
		$hist=$history;
		$history=substr($history,0,30);
		$txt3.="<p><div id='l'><b>".$counter.")  ".$date."</b>"
		."&nbsp;&nbsp;&nbsp;&nbsp;".
		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a></div>
		<div id='r'><a href='client_workflow.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='client_workflow.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		</p>";
		
	}
	echo "<p>Notes  <img src='images/textfile16.png' alt='Mail' >";
	echo "<div class='scroll'>".$txt3."</div></p>";
}

$sql4="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y') FROM history WHERE agent_no = $agent_no AND leads_id=$leads_id AND actions ='MEETING FACE TO FACE' ORDER BY date_created DESC;";
//echo $sql3."<br>";
$result4=mysql_query($sql4);
$ctr4=@mysql_num_rows($result4);
if ($ctr4 >0 )
{
	$counter=0;
	while(list($id,$history,$date) = mysql_fetch_array($result4))
	{
		$counter=$counter+1;
		$hist=$history;
		$history=substr($history,0,30);
		$txt4.="<br><br><p><div id='l'><b>".$counter.")  ".$date."</b>"
		."&nbsp;&nbsp;&nbsp;&nbsp;".
		"<a href='#'"."onClick="."javascript:popup_win('./viewHistory.php?id=$id'".",500,400); title='$hist'>".$history."</a></div>
		<div id='r'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		</p>";
		
	}
	echo "<p>Meeting face to face <img src='images/icon-person.jpg' alt='Meet personally'>";
	echo "<div class='scroll'>".$txt4."</div></p>";
}

?></td>
</tr>
</table>
<!-- skills list -->
<br clear=all><br>



<!-- --->
<br>

</td></tr></table></td></tr></table>
</form>	
<? include 'footer.php';?>
</body>
</html>
r></table></td></tr></table>
</form>	
<? include 'footer.php';?>
</body>
</html>
