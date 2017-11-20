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
<link href="css/rsscroll-staff.css" type="text/css" rel="stylesheet" />
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

<form name="form" id="register-step-5" method="post" action="register/register-step5.php">
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />

<!--
<h2>Add a Skill </h2>

<div id="fieldcontents">
<p style="border-bottom:1px solid #ccc; margin:5px 70px 10px 70px; padding-bottom:20px;">Any learned capacity you are able to carry out and be able to deliver a quality results is what we would mean by skills. Please do not overlook basic skills as well, you might be tech savvy and a fast internet user, list this capacity. You might be great at word and excel with microsoft, list those as skills along with other capacities you might have. Add as many skills you feel you have experience and capacity with.</p>

<div id="resultarea">
	{$skill_HTML}
</div>

<br />
<br />
</div>

<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <td width="500" align="right" style="border:0;"><img src="/portal/images/btn-clicksaveadd.png" alt="" width="208" height="40" onclick="expandSkills()" />&nbsp;&nbsp;
  <input type="image" src="/portal/images/btn-clicksavenext.png" width="200" height="40" border="0" onclick="return CheckStep5Form()"  />
  </td>
</tr>
</table>
</div>
-->
<p >Any learned capacity you are able to carry out and be able to deliver a quality results is what we would mean by skills. Please do not overlook basic skills as well, you might be tech savvy and a fast internet user, list this capacity. You might be great at word and excel with microsoft, list those as skills along with other capacities you might have. Add as many skills you feel you have experience and capacity with.</p>

<h2> Technical Skills </h2>

<div id="fieldcontents">

<table border="0" cellspacing="0" cellpadding="0" id="applyform" style="width:600px">
<tr>
<td width="350" align="left" valign="top" bgcolor="#EEEEEE">Skills</td>
<td width="100" align="left" bgcolor="#EEEEEE">Proficiency</td> 
<td width="200" align="left" bgcolor="#EEEEEE">Years of Experience</td>
</tr>
{$skill_HTML}
</table>
<br />
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" id="applyform2">
  <tr>
    <td width="500" align="right" style="border:0;"><img src="/portal/images/btn-clicksaveadd.png" alt="" width="208" height="40" onclick="form.action='register/register-step5-expand-tskills.php';document.form.submit();" /></td>  
  </tr>
</table>
<br />
<br />

</div>

<h2> Admin Skills </h2>

<div id="fieldcontents">

<table border="0" cellspacing="0" cellpadding="0" id="applyform" style="width:600px">
<tr>
<td width="350" align="left" valign="top" bgcolor="#EEEEEE" >Skills</td>
<td width="100" align="left" bgcolor="#EEEEEE" >Proficiency</td>
<td width="200" align="left" bgcolor="#EEEEEE" >Years of Experience</td>
</tr>
{$admin_skill_HTML}
</table>
<br />
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" id="applyform2">
  <tr>
    <td width="500" align="right" style="border:0;"><img src="/portal/images/btn-clicksaveadd.png" onclick="form.action='register/register-step5-expand-askills.php';document.form.submit();" alt="" width="208" height="40" /></td>
  </tr>
</table>
<br/>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" id="applyform2">
  <tr>
    <td width="500" align="right" style="border:0;"><img src="/portal/images/btn-clicksavenext.png" class="register-step-5-button" width="200" height="40" border="0" /></td>
  </tr>
</table>
<br />
<br />

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
