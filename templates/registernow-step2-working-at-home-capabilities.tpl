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
<!--<div class="shodow_out" style="height:1780px;">&nbsp;</div>-->
{/if}

{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}

<form name="form" method="post" action="register/register-step2.php">
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />

<h2>Working at Home Capabilities</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <td height="47" align="right">	Have you worked from home before? </td>
  <td><input name="work_from_home_before"  type="radio" value="Yes" style="width:15px;" {$work_from_home_before_yes} />
Yes, how long 
  <select name="start_worked_from_home_month" id="start_worked_from_home_month">
   {$monthOptions}
  </select>
  <select name="start_worked_from_home_day" id="start_worked_from_home_day">
    <option value="" selected="selected">Day</option>
   {$dayOptions}
  </select>
  <input type="text" name="start_worked_from_home_year" id="start_worked_from_home_year"  value="{$start_worked_from_home_year}" class="ihalf" size="5" />
  <br />
  <input name="work_from_home_before" type="radio" value="No" style="width:15px;" {$work_from_home_before_no} />
No </td>
</tr>
<tr>
  <td align="right">Do  you have a baby in the house ? </td>
  <td>{$have_a_baby_in_the_house_Options}</td>
</tr>
<tr>
  <td align="right">If yes, Who is the main caregiver?</td>
  <td><input name="who_is_the_main_caregiver" id="who_is_the_main_caregiver" value="{$who_is_the_main_caregiver}" type="text" size="25" /> </td>
</tr>
<tr>
  <td align="right" valign="top">Why  do you want to work from home? </td>
  <td><textarea name="why_do_you_want_to_work_from_home" cols="35" rows="6" id="why_do_you_want_to_work_from_home">{$why_do_you_want_to_work_from_home}</textarea></td>
</tr>
<tr>
  <td align="right">How  long do you see yourself working for RemoteStaff ? </td>
  <td><select name="how_long_do_you_see_yourself_working_for_rs" id="how_long_do_you_see_yourself_working_for_rs">
    <option value="">-</option>
    {$timespan_Options}

  </select></td>
</tr>
<tr>
<td width="180" align="right">Home Working Environment:</td>
<td width="320">{$home_working_environment_Options}</td>
</tr>
<tr>
<td width="180" align="right">Internet Connection:</td>
<td width="320"><select name="internet_connection" id="internet_connection">
	<option value="">-</option>
	{$internet_connections_Options}
</select></td>
</tr>
<tr>
  <td width="180" align="right">Others <br />
    <span class="smalltext">(state whether wireless or wired):</span></td>
  <td width="320"><input name="internet_connection_others" type="text" id="internet_connection_others" value="{$internet_connection_others}" size="35" /></td>
</tr>
<tr>
  <td align="right">Internet Plan &amp; Package: </td>
  <td><input name="internet_plan" type="text" id="internet_plan" value="{$internet_plan}" size="25" /> 
   <span class="smalltext"> e.g. PLDT excite plan</span></td>
</tr>
<tr>
  <td colspan="2" align="left" valign="top" style="background:#f7f7f7;"> Go to <a href="http://www.speedtest.net" target="_blank">www.speedtest.net</a> website and place what your upload & download Mbps speed . </td>
  </tr>
<tr align="right">
  <td colspan="2" align="center" valign="top" style="border:0;"><img src="images/speedtest.jpg" width="400" height="264" border="1" /></td>
</tr>
<tr align="right">
  <td valign="top" style="border:0;">Speed Test Result Link :</td>
  <td align="left" valign="top" style="border:0;"><input name="speed_test_result_link" type="text" id="speed_test_result_link" value="{$speed_test_result_link}" size="25" /></td>
</tr>


<tr>
  <td colspan="2" align="left" valign="top" style="border:0;"><strong>Please note: </strong>To make working from home a sustainable career your internet becomes your lifeline. As a possible remote staff contractor you will need 1.0mbps download with 0.35mbps upload on a DSL broadband connection, WIFI connection is not acceptable because its not stable enough. It's ok not to have this type of internet connection speed when you apply as a jobseeker, but once hired you need to be ready to be able to upgrade. You need to make sure your internet provider and your internet plan you are on is flexible to be able to increase your internet speed or you will need to be prepared to sign up to a new internet supplier with a faster connection.</td>
  </tr>
<tr>
  <td align="right" valign="top"> What is possible and what is not possible about your internet connection from home?</td>
  <td align="left" valign="top"><textarea name="internet_consequences" cols="35" rows="7" id="internet_consequences">{$internet_consequences}</textarea></td>
</tr>

<tr>
  <td colspan="2" align="left" valign="top" style="background:#f7f7f7;">Resource Checklist</td>
  </tr>
<tr>
  <td align="right" valign="top"><input type="checkbox"  name="desktop_computer" id="desktop_computer" value="yes" {$desktop_checked} />
Desktop  
  <select name="desktop_os" id="desktop_os" style="font-size:11px; width:80px">
  	<option value="">Select OS</option>
    {$desktop_os_Options}
      </select></td>
  <td align="left" valign="top"><input name="desktop_processor" type="text" id="desktop_processor" value="{$desktop_processor}" size="13" /> 
    Processor 
      <input name="desktop_ram" type="text" id="desktop_ram" value="{$desktop_ram}" size="13" style="width:75px;" /> 
      RAM</td>
</tr>
<tr>
  <td align="right" valign="top"><input type="checkbox" name="loptop_computer" id="loptop_computer" value="yes" {$laptop_checked} />
Laptop
  <select name="loptop_os" id="loptop_os" style="font-size:11px; width:80px;">
    <option value="">Select OS</option>
  {$laptop_os_Options}
  </select></td>
  <td align="left" valign="top"><input name="loptop_processor" type="text" id="loptop_processor" value="{$laptop_processor}" size="13" />
Processor
  <input name="loptop_ram" type="text" id="loptop_ram" value="{$laptop_ram}" size="13" style="width:75px;" />
RAM</td>
</tr>
<tr>
  <td align="right" valign="top">Headset </td>
  <td align="left" valign="top"><input name="headset" type="text" id="headset" value="{$headset}" size="25" />     Brand &amp; Model </td>
</tr>
<tr>
  <td align="right" valign="top">High Performance Headphones ***</td>
  <td align="left" valign="top"><input name="headphone" type="text" id="headphone" value="{$headphone}" size="25" /> 
    Brand &amp; Model </td>
</tr>
<tr>
  <td align="right" valign="top">Printer</td>
  <td align="left" valign="top"><input name="printer" type="text" id="printer" value="{$printer}" size="25" />     Brand &amp; Model </td>
</tr>
<tr>
  <td align="right" valign="top">Scanner</td>
  <td align="left" valign="top"><input name="scanner" type="text" id="scanner" value="{$scanner}" size="25" />     Brand &amp; Model </td>
</tr>
<tr>
  <td width="180" align="right" valign="top">Tablet<br /></td>
  <td width="320" align="left" valign="top"><input name="tablet" type="text" id="tablet" value="{$tablet}" size="25" />     Brand &amp; Model </td>
</tr>
<tr>
  <td width="180" align="right">Pen tablet</td>
  <td width="320"><input name="pen_tablet" type="text" id="pen_tablet" value="{$pen_tablet}" size="25" /> 
    Brand &amp; Model </td>
</tr>
<tr>
  <td colspan="2" align="right" valign="top" style="background:#f7f7f7;">&nbsp;</td>
  </tr>
<tr>
  <td align="right" valign="top">How  do you rate the noise level at your home location ?</td>
  <td>{$noise_level_Options} </td>
</tr>
</table>
</div>

<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <!--<td width="500" align="right" style="border:0;"><a href="registernow-step3-educational-details.php"><img src="images/btn-clicksavenext.png" width="200" height="40" border="0" /></a></td>-->
   <input type="image" src="images/btn-clicksavenext.png" width="200" height="40" border="0" onclick="return CheckStep2Form()"  />
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
