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
<script type="text/javascript" src="js/register-step-4.js"></script>
<script type="text/javascript" src="js/email_validate.js"></script>
<link href="register/register.css" type="text/css" rel="stylesheet"  />
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<link href="css/rsscroll-staff.css" type="text/css" rel="stylesheet" />
<link rel=stylesheet type=text/css href="css/updatecurrentjob.css">
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
<div class="shodow_out" style="height:1000px;">&nbsp;</div>
{else}
	{include file="fb.tpl"}
{/if}

{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}


<form name="form" method="post" action="register/register-step4.php" id="currentjob_form">
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />


<p><strong>Fill in this section to give employers a snapshot of your profile. </strong></p> 
<h2>Current Status</h2>
<div id="fieldcontents">
<table border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="50" align="right"><input type="radio" name="current_status" value="still studying" {$still_studying_selected}/></td>
<td width="450">I am still pursuing my studies and seeking internship or part-time jobs</td>
</tr>
<tr>
<td width="50" align="right"><input type="radio" name="current_status" value="fresh graduate" {$fresh_graduate_selected}/></td>
<td width="450">I am a fresh graduate seeking my first job</td>
</tr>
<tr>
  <td width="50" align="right"><input type="radio" name="current_status" value="experienced" {$experienced_selected}/></td>
  <td width="450">I have been working for
 <select name="years_worked" id="years_worked" style="width:40px;" class="text">
	{$years_worked_options}
 </select>
&nbsp;year(s)
 <select name="months_worked" id="months_worked" style="width:40px;" class="text">
	{$months_worked_options}
 </select>
 &nbsp;month(s)</td>
</tr>
</table>
</div>

<h2>Availability Status</h2>
<div id="fieldcontents">
<table border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="50" align="right"> <input type="radio" name="available_status" value="a" id="available_status_a" {$available_a}/></td>
<td width="450">
	<label for="available_status_a">I can start work after </label>
    { strip }
    <select name="available_notice">
    	<option value=""></option>
        { section name=available_notice loop=12 }
        	
	        <option value="{ $smarty.section.available_notice.index }"  
	        {if $available_notice==$smarty.section.available_notice.index}
	    				selected
	    			{/if}>
	        { $smarty.section.available_notice.index }
	        </option>
        { /section }
    </select>
    { /strip } week(s) of notice period</td>
</tr>
<tr>
<td width="50" align="right"><input type="radio" name="available_status" value="b" id="available_status_b" {$available_b}/></td>
<td width="450">
	<label for="available_status_b">
                I can start work after 
    </label>
    <select name="aday">
    	<option value=""></option>
    		{ section name=aday loop=31 }
	    		<option value="{ $smarty.section.aday.iteration }"
	    			{if $aday==$smarty.section.aday.iteration}
	    				selected
	    			{/if}
	    		>
	                        { $smarty.section.aday.iteration }
	            </option>
            { /section }
    </select>&nbsp;-&nbsp; 
    <select name="amonth">
                <option value=""></option>
                {$month_full_options}
    </select>&nbsp;-&nbsp;<input type=text name="ayear" size=4 maxlength=4 style='width=50px' value='{ $currentjob.ayear }'/>(YYYY)
</td>
</tr>
<tr>
  <td width="50" align="right"><input type="radio" name="available_status" value="p" id="available_status_p" {$available_p}/></td>
  <td width="450"><label for="available_status_p">I am not actively looking for a job now</label></td>
</tr>
<tr>
	<td width="50" align="right"><input type="radio" name="available_status" value="Work Immediately" id="available_status_work_immediate"  {$available_w}/></td>
	<td width="450"><label for="available_status_work_immediate">Work Immediately</label></td>
</tr>
</table>
</div>
<h2>Expected Salary</h2>
<div id="fieldcontents">
<table style="width:600px;" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="150" align="right">Expected Monthly Salary:</td>
<td width="450">&nbsp;&nbsp;
  <input type="checkbox" value="Yes" name="expected_salary_neg" {$is_negotiable} />
  Negotiable 
  <select name="expected_salary" id="expected_salary">
  	{$expected_salary_options}
  </select>
  <select name="salary_currency" id="salary_currency" style="font:8pt, Verdana" >  
	{$salary_currency_options}
</select>&nbsp;&nbsp;</td>
</tr>
</table>
</div>


<h2>Current/latest Job Title</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">Position:</td>
<td width="300"><input name="latest_job_title" type="text" id="latest_job_title" size="35" value="{$latest_job_title}"/></td>
</tr>
</table>
</div>

<h2><strong>Work History</strong></h2>
<div id="fieldcontents">
<div id="resultarea" >
	Note: Please start with your current or most recent company<br><br>
	{$history_HTML}	
	<br />
</div>
<p align="center"><strong><span style="color:red;cursor:pointer;text-decoration:underline;" onclick="form.action='register/register-step4-expand.php';document.form.submit();" <!--onclick="expandWorkHistory()"--> >Click Here to add more work history</span></strong></p> 
</div>

<h2>Position Desired</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right" valign="top">First Choice:</td>
<td width="300"><select name="position_first_choice" id="position_first_choice">
<option value="" selected="selected">Select Position </option>
	{$position_first_choice_options}
</select>
  <br />
  <span class="smalltext">any experience doing this role?  {$position_first_choice_exp_options} </span> <br /></td>
</tr>
<tr>
  <td align="right" valign="top">Second Choice: </td>
  <td><select name="position_second_choice" id="position_second_choice">
	{$position_second_choice_options}
  </select>
  <br />
  <span class="smalltext">any experience doing this role?  {$position_second_choice_exp_options} </span> <br />
  
  </td>
</tr>
<tr>
  <td align="right" valign="top">Third Choice:</td>
  <td><select name="position_third_choice" id="position_third_choice">
	{$position_third_choice_options}
  </select>
  <br />
  <span class="smalltext">any experience doing this role?   {$position_third_choice_exp_options} </span> <br />
  </td>
</tr>
<tr>
  <td align="right">Others:</td>
  <td><input name="others" type="text" id="others" size="35" /></td>
</tr>
</table>
</div>
<h2>Character References</h2>
												
<div id="container_references">
	{foreach from=$character_references item=character_reference}
		{include file=character-reference.tpl}
		
	{/foreach}
	{include file=empty-character-reference.tpl}
		
</div>
<div id="fieldcontents">
	<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
		<tr>
			<td width="200">&nbsp;</td>
			<td width="300">
				<strong>
					<span id="add-character-button" style="color:red;cursor:pointer;text-decoration:underline;">&gt;Click here to add more character reference</span>	
				</strong>
				
			</td>
		</tr>
	</table>
</div>







<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <!--<td width="500" align="right" style="border:0;">&nbsp;&nbsp;<a href="registernow-step5-skills-details.php"><img src="/portal/images/btn-clicksavenext.png" width="200" height="40" border="0" /></a></td>-->
	<input type="image" src="/portal/images/btn-clicksavenext.png" width="200" height="40" border="0" onclick="expandForm=false;"   />
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
