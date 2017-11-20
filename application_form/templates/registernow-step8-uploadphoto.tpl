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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="register/register.js"></script>
<script type="text/javascript" src="register/register-step8.js"></script>
<script type="text/javascript" src="js/email_validate.js"></script>
<link href="register/register.css" type="text/css" rel="stylesheet"  />
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<link href="css/rsscroll-staff.css" type="text/css" rel="stylesheet" />
<link href="css/register-8.css" type="text/css" rel="stylesheet" />
</head>
<body class="sub-bg" id="registernow">

<div id="main" class="fadePage">&nbsp;</div>

<div id="popup" class="login_container">
<div  class="login" >
	<div class="sprite-closebutton" onclick="hidepopup('popup')" ></div>
	<div id="login_popup" class="login_popup">
		<div id="uploadPicture" >
			<form enctype="multipart/form-data" name="upload" method="post" action="register/register-step8.php">
				<input type="hidden" name="page" value="{$page}" />
				<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />
				<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
				<input type="hidden" id="action" name="action" value="upload"/>
				<table cellpadding="0" border="0">
					<tr >
						<td style="text-align:center;height:70px;font-weight:bold;">Upload Photo</td>
					</tr>
					<tr >
						<td style="text-align:center;">
							<input type="file" id="uploaded_file" value="" name="uploaded_file"  size="30" /><br/>
						</td>											
					</tr>
					<tr >
						<td style="text-align:center;height:80px;">
						<div onclick='document.upload.submit();' > 
							 <img src="/portal/images/uploadphoto.png" width="159" height="40">
						</div>
						</td>
					</tr>
					<tr >
						<td style="text-align:center;">
							<span class="formNotes">Note: Upload files only in JPEG or GIF format, with the file extension as .jpg, .jpeg or .gif. Maximum file size is 10MB. The ideal dimension to save your photograph is 110 x 150 pixels.</span>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
</div>

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
<div class="shodow_out" style="height:600px;">&nbsp;</div>
{else}
	{include file="fb.tpl"}
{/if}

{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}

<!--<form name="upload" method="post" action="register/register-step7.php">-->
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />


<h2>Upload Photo </h2>
<div id="fieldcontents"> 
<p style="background:url(/portal/images/tip.png) top left no-repeat; padding-left:65px; font-size:12px; font-weight:bold;">Please upload a head shot photo in JPEG or GIF format, with the file extension as .jpg, .jpeg or .gif. Maximum file size is 
10MB. The ideal dimension to save your photograph is 110 x 150 pixels.</p>
<table border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <td align="center"><img src="{$image}" width="130" height="163" /></td> 
  </tr>
</table>
<p>If the photo looks distorted, please resize and upload it again. You may remove the photo if you no longer wish to attach it with your resume.</p>
</div>

<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <td width="500" align="center" style="border:0;">
  <img src="/portal/images/removephoto.png" width="159" height="40" id="remove-photo"/> 
  <img src="/portal/images/uploadphoto.png" width="159" height="40" id="upload-photo"/>
  </td>
  </tr>
<tr>
  <td align="center" style="border:0;">&nbsp;</td>  
</tr>
<tr>
  <td align="center" style="border:0;" ><span style="color:red">Make sure that you have completed each step before proceeding. You may go back  and review each steps by clicking the links on the left side panel.</span></td>
</tr>
<tr>
  <td align="center" style="border:0;">&nbsp;</td>  
</tr>

<tr>
	<td align="center" style="border:0;">
		<!--
		<a href="registernow-finish.php"><img src="/portal/images/donephoto.png" width="159" height="40" /></a>
		-->
		
		<div class="refer-a-friend">
			<form method="POST" id="refer-a-friend">
			<input name="userid" id="refer-a-friend-userid" value="{$userid}" type="hidden"/>
			<input name="email" id="refer-a-friend-email" value="{$email}" type="hidden"/>
			
			<p>Do you know any one who might be interested to apply? We offer 500 Pesos incentive for back office admin referrals and 1000 Pesos incentive to IT Professional Referrals. (Optional)</p>
			<p style="font-size:0.95em"><strong><small>Referral fee will be paid out once your referred candidate works with us for a month minimum.</small></strong></p>
				<table id="refer-a-friend-table">
					<tr>
						<th>
							First Name
						</th>
						<th>
							Last Name
						</th>
						<th>
							Current Position
						</th>
						<th>
							Email Address
						</th>
						<th>
							Contact Number
						</th>
					</tr>
					
					<tr>
						<td><input type="text" name="firstname[]" class="first-name"/></td>
						<td><input type="text" name="lastname[]" class="lastname"/></td>
						<td><input type="text" name="currentposition[]" class="currentposition"/></td>
						<td><input type="text" name="emailaddress[]" class="emailaddress"/></td>
						<td><input type="text" name="contactnumber[]" class="contactnumber"/></td>
					</tr>
					
					<tr>
						<td><input type="text" name="firstname[]" class="first-name"/></td>
						<td><input type="text" name="lastname[]" class="lastname"/></td>
						<td><input type="text" name="currentposition[]" class="currentposition"/></td>
						<td><input type="text" name="emailaddress[]" class="emailaddress"/></td>
						<td><input type="text" name="contactnumber[]" class="contactnumber"/></td>
					</tr>
					
					<tr>
						<td><input type="text" name="firstname[]" class="first-name"/></td>
						<td><input type="text" name="lastname[]" class="lastname"/></td>
						<td><input type="text" name="currentposition[]" class="currentposition"/></td>
						<td><input type="text" name="emailaddress[]" class="emailaddress"/></td>
						<td><input type="text" name="contactnumber[]" class="contactnumber"/></td>
					</tr>
				</table>
			</form>
		</div>
		</td>
</tr>

<tr>
  <td align="center" style="border:0;">
  		<button class="finish-button finish-4-days"><img src="/portal/application_form/images/check.png"/>Finish. Call Me Within 4 Days.</button>
  		<button class="finish-button finish-and-chat"><img src="/portal/application_form/images/check.png"/>Finish. Chat to our Recruiters Now.</button>
  </td>
</tr>

</table>      
</div>




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
