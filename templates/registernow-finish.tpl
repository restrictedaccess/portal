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
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="register/register.js"></script>
<link href="register/register.css" type="text/css" rel="stylesheet"  />
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<link href="css/rsscroll-staff.css" type="text/css" rel="stylesheet" />
</head>
<body class="sub-bg" id="registernow">

<div id="main" class="fadePage">&nbsp;</div>

<div id="popup" class="login_container">
<div  class="login" >
	<div class="sprite-closebutton" onclick="hidepopup('popup')" ></div>
	<div id="login_popup" class="login_popup">
		<div id="uploadPicture" >
			<form enctype="multipart/form-data" name="upload" method="post" action="register/register-step7.php">
				<input type="hidden" name="page" value="{$page}" />
				<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />
				<table cellpadding="0" border="0">
					<tr >
						<td style="text-align:center;height:70px;font-weight:bold;">Upload Photo</td>
					</tr>
					<tr >
						<td style="text-align:center;">
							<input type="file" value="" name="uploaded_file"  size="30" /><br/>
						</td>											
					</tr>
					<tr >
						<td style="text-align:center;height:80px;">
						<div onclick='document.upload.submit();' > 
							 <img src="images/uploadphoto.png" width="159" height="40">
						</div>
						</td>
					</tr>
					<tr >
						<td style="text-align:center;">
							<span class="formNotes">Note: Upload files only in JPEG or GIF format, with the file extension as .jpg, .jpeg or .gif. Maximum file size is 15K. The ideal dimension to save your photograph is 110 x 150 pixels.</span>
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
<div class="shodow_out" style="height:1780px;">&nbsp;</div>
{/if}

{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}

<!--<form name="upload" method="post" action="register/register-step7.php">-->
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />




{if $success}
<h2>Successfully Submitted Form! </h2>
<p><br>
Congratulations! 
<br> You are now a registered Remotestaff Jobseeker.
Please leave your communication lines open. 
<br> A remotestaff  administrator shall contact you soon.
</p>
{/if}





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
