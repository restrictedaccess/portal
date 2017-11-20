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

<script language="Javascript" src="js/functions.js"></script>
<link href="register/register.css" type="text/css" rel="stylesheet"  />
<link href="css/style.css" type="text/css" rel="stylesheet"  /> 
<link href="css/rsscroll-staff.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
{literal}
	jQuery(document).ready(function(){
		if (jQuery.browser.mozilla){
			jQuery(".shodow_out").height(1600);
		}else{
			jQuery(".shodow_out").height(1650);
		}
		
	});
{/literal}
</script>

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
<div class="shodow_out" style="height:1400px;">&nbsp;</div>
{else}
	{include file="fb.tpl"}
{/if}
{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}
<form id="register-step-1" name="form" method="post" action="register/register-step1.php" >
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />
<h2>Personal Details</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">First Name:</td>
<td width="300"><input name="fname" type="text" id="fname" value="{$fname}" size="35" /></td>
</tr>
<tr>
<td width="200" align="right">Middle Name:</td>
<td width="300"><input name="middle_name" type="text" id="middle_name" value="{$middle_name}" size="35" /></td>
</tr>

<tr>
<td width="200" align="right">Last Name:</td>
<td width="300"><input name="lname" type="text" id="lname" value="{$lname}" size="35" /></td>
</tr>

<tr>
<td width="200" align="right">Nick Name:</td>
<td width="300"><input name="nick_name" type="text" id="nick_name" value="{$nick_name}" size="35" /></td>
</tr>


<tr>
  <td align="right">Date of Birth:</td>
  <td><select name="bmonth" id="bmonth">
    {$monthOptions}
  </select>
    <select name="bday" id="bday">
	<option value="">-</option>
     {$dayOptions}
    </select>
    <input type="text" name="byear" id="byear" class="ihalf" size="5" maxlength="4" value="{$byear}" /><small style="color:#666666;"> (YYYY)</small></td>
</tr>



<tr>
  <td align="right">Identification:</td>
  <td><select name="auth_no_type_id" id="auth_no_type_id">
  <option value="">-</option>
{$identificationOptions}
</select>
<input id="msia_new_ic_no" name="msia_new_ic_no" value="{$identification_number}" type="text" size="20" style="width:80px;" />
</td>
</tr>
<tr>
  <td align="right">Gender:</td>
  <td>{$genderOptions}</td>
</tr>
<tr>
  <td align="right">Marital Status:</td>
  <td><select name="marital_status" id="marital_status">
    <option value="">-</option>
   {$marital_status_Options}
  </select></td>
</tr>
<tr>
  <td align="right">Number of kids ( if any)</td>
  <td><input id="no_of_kids" name="no_of_kids" value="{$no_of_kids}" type="text" size="10" style="width:30px;" /></td>
</tr>
<tr>
  <td align="right">Are you pregnant?</td>
  <td><select name="pregnant" id="pregnant">
    <option value="">-</option>
 {$pregnant_Options}
  </select></td>
</tr>
<tr>
  <td align="right">if yes, Expected Date of Delivery</td>
  <td><select name="dmonth" id="dmonth">
    {$dmonthOptions}
  </select>
    <select name="dday" id="dday">
      <option value="">Day</option>
      {$ddayOptions}
    </select>
    <input type="text" class="ihalf" name="dyear" id="dyear" value="{$dyear}" size="5" maxlength="4" /> <small style="color:#666666;"> (YYYY)</small></td>
</tr>
<tr>
  <td align="right">Nationality:</td>
  <td><select name="nationality" id="nationality" style="width:200px;">
    {$nationalityOptions}
  </select></td>
</tr>
<tr>
  <td align="right">Permanent Residence In: </td>
  <td><select name="permanent_residence" id="permanent_residence" style="width:200px;">
    {$countryOptions}
  </select></td>
</tr>
<tr>
  <td align="right">Do  you have pending Visa application ? </td>
  <td>{$pending_visa_application_Options}</td>
</tr>
<tr>
  <td align="right">Do  you have active Visa&rsquo;s for US, Australia, UK, Dubai ? </td>
  <td>{$active_visa_Options}</td>
</tr>
</table>
</div>

<h2>Login Details</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">Username:</td>
<td width="300"><b>{$email}</b>
<input type="hidden" name="email" id="email" value="{$email}">
</td>
</tr>
{if $form_id eq ""}
<tr>
<td align="right">Password:</td>
<td><input name="password" type="password" id="password" size="35" /></td>
</tr>
{else}
<tr>
<td align="right">Reset Password:</td>
<td>Click <a href="javascript:popup_win('http://remotestaff.com.au/portal/forgotpass.php?user=applicant',500,330);"> <b>HERE</b></a></td>
</tr>
{/if}
</table>
</div>

<h2>Contact Info</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right" valign="top">Alternative E-mail:</td>
<td width="300"><input name="alt_email" type="text" id="alt_email" value="{$alt_email}" size="35" onblur="CheckAltEmail()"/>  <br />
  <span class="smalltext" >will be used if primary email is not reachable</span></td>
</tr>
<tr>
  <td align="right" valign="top">Mobile Number:</td>
  <td><input name="handphone_country_code" type="text" id="handphone_country_code" size="7" value="{$handphone_country_code}" />
-
  <input name="handphone_no" type="text" id="handphone_no" value="{$handphone_no}" size="25" />
  <br />
  <span class="smalltext">Country Code(ex. 63) - Mobile Number(ex. 9479959825)<br />Do NOT add any space or special character</span></td>
</tr>
<tr>
<td align="right" valign="top">Landline Number:</td>
<td><input name="tel_area_code" type="text" id="tel_area_code" value="{$tel_area_code}" size="7" />   
  -   
  <input name="tel_no" type="text" id="tel_no" value="{$tel_no}" size="25" />  <br />
  <span class="smalltext">Area Code(ex. 632) - Number(ex. 8464249)<br />Do NOT add any space or special character</span></td>
</tr>
<tr>
  <td align="right" valign="top">Address: </td>
  <td><textarea name="address1" cols="25" rows="5" id="address1">{$address1}</textarea></td>
</tr>
<tr>
  <td colspan="2" align="center" style="border:0;"><table width="480" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100">Postal Code:</td>
      <td width="120"><input name="postcode" type="text" id="postcode" value="{$postcode}" size="15" /></td>
      <td width="10">&nbsp;</td>
      <td width="50">Country:</td>
      <td width="170"><select name="country_id" id="country_id" style="width:150px;" onchange='changeStateSelectOptions(this.form.country_id.value);'>
        {$countryOptions2}
      </select></td>
    </tr>
    <tr>
      <td>State/ Region:</td>
      <td><div id="state_field"><input name="state" type="text" id="state" value="{$state}" size="15" /></div></td>
      <td>&nbsp;</td>
      <td>City</td>
      <td><input name="city" type="text" id="city" value="{$city}" size="15" /></td>
    </tr>
  </table></td>
</tr>
</table>
</div>


<h2>Online Contact Info (optional)</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">MSN Messenger ID:</td>
<td width="300"><input name="msn_id" type="text" id="msn_id" value="{$msn_id}" size="35" /></td>
</tr>
<tr>
<td align="right">YAHOO MessengerID:</td>
<td><input name="yahoo_id" type="text" id="yahoo_id" value="{$yahoo_id}" size="35" /></td>
</tr>
<tr>
  <td align="right">Facebook / Twitter Account:</td>
  <td><input name="icq_id" type="text" id="icq_id" value="{$icq_id}" size="35" /></td>
</tr>
<tr>
  <td align="right">Linked In Account:</td>
  <td><input name="linked_in" type="text" id="linked_in" value="{$linked_in}" size="35" /></td>
</tr>

<tr>
  <td align="right">SKYPE ID</td>
  <td><input name="skype_id" type="text" id="skype_id" value="{$skype_id}" size="35" /></td>
</tr>


</table>
</div>

<h2>Others</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">How did you hear about us?</td>
<td width="300">
	<input type="radio" name="others" id="others" value="external" {if $referred_by == ''}checked{/if} >External Source  
		<select name="external_source" id="external_source" onchange="displayOthers()" > 
			{$referredByOptions}  
		</select><br/>
		<span id="others_container" style="display:{$display_others};">
			<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Please specify <input name="external_source_others" type="text" id="external_source_others" value="{$external_source}" size="24" />
		</span><br/>
	<input type="radio" name="others" id="others" value="referral" {if $external_source == ''}checked{/if}>Referred by
		<input name="referred_by" type="text" id="referred_by" value="{$referred_by}" size="27" />
</td> 
</tr>
<tr>
	<td width="200" align="right">Have you spoken to any of our recruiters before ?</td>
	<td width="300">
	<select name="have_you_spoken">
		{$recruiterYesNo}
	</select></td>

</tr>
<tr>
	<td width="200" align="right">If yes,</td>
	<td width="300">
	<select name="recruiter">
		<option value="">Please select</option>
		{$recruiterOption}
	</select></td>
</tr>


</table>
</div>

<h2>Verification</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td align="right"><input type="hidden" value="{$rv}" name="rv" id="rv">{$rv_image}</td>
<td >&nbsp;<input type="text" value="" name="pass2" id="pass2"  style="width:200px;" maxlength="5"> 

</td>
</tr>
<tr> 
<td colspan="2" style="padding-left:80px;" >For verification, please type the numbers that you see</td>
</tr>


<tr>
  <td colspan="2" align="right" style="border:0;">&nbsp;</td>
  </tr>
<tr>
	<td>&nbsp;</td>
  <td>
  <!--
  <a href="registernow-step2-working-at-home-capabilities.php"><img src="/portal/images//btn-clicknext.png" width="200" height="40" border="0" /></a>
	-->  
  <input type="image" src="/portal/images//btn-clicknext.png" width="200" height="40" border="0" onclick="return CheckStep1Form()"  />


  </td>
  </tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>
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
