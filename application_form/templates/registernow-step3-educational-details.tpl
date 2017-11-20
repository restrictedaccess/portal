{*
2010-07-17  Normaneil Macutay <normanm@remotestaff.com.au>

*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="verify-v1" content="LaxjipBphycGX3aaNPJVEJ4TawiiEs/3kDSe15OJ8D8=" />
<title>BPO Company Remote Staff Official Website | Hire Offshore Staff from Remote Staff | Outsource Staff, Inexpensive and Professional Online Staff, Virtual Assistant and IT Offshore Outsourcing BPO Services</title>
<meta name="description" content="Outsource staff, inexpensive offshore staff, online staff and Virtual assistant working for you at $4 to $8 per hr, and you don't pay for holidays and sick pay. Save up to 70% off your labour cost with our IT Offshore Outsourcing Services we offer">
<meta name="keywords" content="outsource staff, hire offshore staff, offshore staff, online staff, virtual assistant, IT offshore, offshore outsourcing, outsourcing services, offshore services, remote staff, BPO company, BPO Australia, outsourced staff, offshore labour, offshore hire, offshore labour hire, IT offshore outsourcing, IT offshore staff, labour cost, offshore outsourcing services, outsource offshore, outsource services, IT outsourcing services">
<meta name="ROBOTS" content="NOODP">
<meta name="GOOGLEBOT" content="NOODP"> 
<meta name="title" content="Hire Offshore Staff from Remote Staff | Outsource Staff, Online Staff, Virtual Assistant and IT Offshore Outsourcing Services BPO Company">
<meta name="classification" content="Outsource staff, inexpensive offshore staff, online staff and Virtual assistant working for you at $4 to $8 per hr, and you don't pay for holidays and sick pay. Save up to 70% off your labour cost with our IT Offshore Outsourcing Services we offer">
<meta name="author" content="Remote Staff | Chris J">
<meta name="robots" content="NOYDIR">
<meta name="slurp" content="NOYDIR">
<meta name="robots" content="index all,follow all">
<meta name="revisit-after" content="7 days">
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="register/register.js"></script>
<script type="text/javascript" src="js/email_validate.js"></script>
<link href="register/register.css" type="text/css" rel="stylesheet"  />
<link href="css/style.css" type="text/css" rel="stylesheet"  />

</head>
<body class="sub-bg" id="registernow">


<div id="container" >


{include file="header.tpl"}
<!--  End of Header -->
<!-- End of Navigation -->
{php}include("inc/nav.php"){/php}  

<div id="main-image" style="height:30px;"></div>
<!-- End of Main Image -->

<div id="contents" >

{include file="register-left-menu.tpl"}
<div id="applynow" >
<div align="right">{$welcome}</div>
{if $userid eq ""}
{include file="email-validation-form.tpl"}
<div class="shodow_out" style="height:900px;">&nbsp;</div>
{else}
	{include file="fb.tpl"}
{/if}

{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}

<form name="form" method="post" action="register/register-step3.php">
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />


<h2>Trainings &amp; Seminars Attended</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">

<tr>
<td width="500" colspan="2" align="left">
  <textarea cols="80" rows="20" name="trainings_and_seminars_attended" id="trainings_and_seminars_attended">{$trainings_seminars}</textarea>  </td>
</tr>
</table>
</div>

<h2>Highest Academic Qualification</h2>
<div id="fieldcontents">
<table style="width:600px" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">Highest Level:</td>
<td width="300"><select name="highest_level" id="highest_level">
{$highest_level_options}

</select></td>
</tr>
<tr>
<td width="200" align="right" >Field of Study:</td>
<td width="300"><select name="field_of_study" id="field_of_study">
{$field_of_study_options}
</select></td>
</tr>
<tr>
  <td align="right">Others( please specify )</td>
  <td><input name="others" id="others" type="text" size="35" value="{$others}"/></td>
</tr>
<tr>
  <td align="right">Major:</td>
  <td><input name="major" type="text" id="major" size="35" value="{$major}" /></td>
</tr>
<tr>
  <td align="right" valign="top">Grade:</td>
  <td><select name="grade" id="grade">
	{$grade_options}
  </select>
    <br />
    <br />
    	If GPA, please enter score:
    	<input name="gpa" type="text" id="gpa" size="5" value="{$gpascore}"/>  
    	out of 100  </td>
</tr>
<tr>
  <td align="right">Institute / University:</td>
  <td><input name="university" type="text" id="university" size="35" value="{$college_name}" /></td>
</tr>
<tr> 
  <td align="right">Located in:</td>
  <td><select name="university_location" id="university_location">
	{$university_location_options} 
  </select>  
  </td>
</tr>
<tr>
  <td align="right" valign="top">Graduation date: </td>
  <td><select name="graduate_month" id="graduate_month" class=text>
	{$month_options}
  </select> - <input type="text" name="graduate_year" id="graduate_year" size=4 maxlength=4 style='width=50px' value="{$graduate_year}"  class="text"> (YYYY)<br />
<br>
&nbsp;&nbsp;<font class=tip>&gt; Enter expected graduation date if still pursuing</font></td>
</tr>
</table>
<br />
<!--<p align="center"><strong><a href="#"  style="color:red !important">Click Here to add another Academic Qualification</a></strong></p>-->
</div>

<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <!--<td width="500" align="right" style="border:0;"><a href="registernow-step4-work-history-details.php"><img src="/portal/images/btn-clicksavenext.png" width="200" height="40" border="0" /></a></td>-->
  <input type="image" src="/portal/images/btn-clicksavenext.png" width="200" height="40" border="0" onclick="return CheckStep3Form()"  />
  </tr>
</table>
</div>




</form>
</div>




</div>
<!-- End of Content Box  -->

<div id="contents" style="clear:both">
</div>
<!-- End of Left Contents -->
<!-- End of Main Contents -->
<!-- End of Right Contents -->
</div>
<!-- End of Content Box  -->



</div><!-- End of Container -->
<p>&nbsp;</p>
<p>&nbsp;</p>
{php}include("inc/footer.php"){/php} 
</body>
</html>
