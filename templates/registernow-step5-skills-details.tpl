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
<div class="shodow_out" style="height:1780px;">&nbsp;</div>
{/if}

{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}

<form name="form" method="post" action="register/register-step5.php">
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />


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
  <td width="500" align="right" style="border:0;"><img src="images/btn-clicksaveadd.png" alt="" width="208" height="40" onclick="expandSkills()" />&nbsp;&nbsp;
  <input type="image" src="images/btn-clicksavenext.png" width="200" height="40" border="0" onclick="return CheckStep5Form()"  />
  </td>
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
