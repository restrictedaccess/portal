{*
2010-07-17  Normaneil Macutay <normanm@remotestaff.com.au>

*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
{include file = "head.tpl"}
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


<h2>Upload Photo </h2>
<div id="fieldcontents"> 
<p style="background:url(images/tip.png) top left no-repeat; padding-left:65px; font-size:12px; font-weight:bold;">Please upload a head shot photo in JPEG or GIF format, with the file extension as .jpg, .jpeg or .gif. Maximum file size is 15K. The ideal dimension to save your photograph is 110 x 150 pixels.</p>
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
  <img src="images/removephoto.png" width="159" height="40" onclick="document.upload.submit();"/> 
  <img src="images/uploadphoto.png" width="159" height="40" onclick="showpopup('popup')"  />
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
  <td align="center" style="border:0;"><strong>If you are done with the 7 steps click the Finish Button </strong></td>
</tr>
<tr>
  <td align="center" style="border:0;"><a href="registernow-finish.php"><img src="images/donephoto.png" width="159" height="40" /></a></td>
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
