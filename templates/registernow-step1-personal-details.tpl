{*
2010-07-17  Normaneil Macutay <normanm@remotestaff.com.au>

*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
{include file = "head.tpl"}
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
<div class="shodow_out" style="height:1300px;">&nbsp;</div>
{/if}
{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}
<form name="form" method="post" action="register/register-step1.php" >
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
    {$monthOptions}
  </select>
    <select name="dday" id="dday">
      <option value="">Day</option>
      {$dayOptions}
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
<input type="hidden" name="email" value="{$email}">
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
<td width="300"><input name="alt_email" type="text" id="alt_email" value="{$alt_email}" size="35" />  <br />
  <span class="smalltext" >will be used if primary email is not reachable</span></td>
</tr>
<tr>
  <td align="right" valign="top">Mobile Number:</td>
  <td><input name="handphone_country_code" type="text" id="handphone_country_code" size="7" value="{$handphone_country_code}" />
-
  <input name="handphone_no" type="text" id="handphone_no" value="{$handphone_no}" size="25" />
  <br />
  <span class="smalltext">area code - number</span></td>
</tr>
<tr>
<td align="right" valign="top">Landline Number:</td>
<td><input name="tel_area_code" type="text" id="tel_area_code" value="{$tel_area_code}" size="7" />   
  -   
  <input name="tel_no" type="text" id="tel_no" value="{$tel_no}" size="25" />  <br />
  <span class="smalltext">area code - number</span></td>
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
      <td width="170"><select name="country_id" id="country_id" style="width:150px;" onchange='changeStateSelectOptions(this.form.country_id.value);' >
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
  <td align="right">Facebook / Friendster Account:</td>
  <td><input name="icq_id" type="text" id="icq_id" value="{$icq_id}" size="35" /></td>
</tr>
<tr>
  <td align="right">SKYPE ID</td>
  <td><input name="skype_id" type="text" id="skype_id" value="{$skype_id}" size="35" /></td>
</tr>
</table>
</div>
<!--
<h2>Verification</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right"><img src="images/dummyver.jpg" width="94" height="24" /></td>
<td width="300"><input name="textfield15" type="text" id="textfield15" size="35" /></td>
</tr>

<tr>
<td colspan="2" align="center"><span class="smalltext"><strong>For validation, please type the numbers that you see</strong></span></td>
</tr>
-->
<tr>
  <td colspan="2" align="right" style="border:0;">&nbsp;</td>
  </tr>
<tr>
	<td>&nbsp;</td>
  <td>
  <!--
  <a href="registernow-step2-working-at-home-capabilities.php"><img src="images/btn-clicknext.png" width="200" height="40" border="0" /></a>
	-->  
  <input type="image" src="images/btn-clicknext.png" width="200" height="40" border="0" onclick="return CheckStep1Form()"  />


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
