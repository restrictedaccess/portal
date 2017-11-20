<form name="form" method="post" action="email-validate.php">
<input type="hidden" name="page" id="page" value="{$page}" />
<input type="hidden" name="staff_fname" value="{$fname}">
<input type="hidden" name="staff_lname" value="{$lname}">

<h2>Email Validation</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
{if $error eq True}
<tr>
<td align="center" colspan="2" style="color:#FF0000; font-weight:bold;">{$error_msg}</td>
</tr>

{/if}
<tr>
<td width="200" align="right">Primary Email:</td>
<td width="300"><input name="email" type="text" id="email" size="35" value="{$email}" /><br />
<small>Your Yahoo ID is not thesame as your email address</small>
</td>
</tr>

<tr>
<td align="right">Code Number:</td>
<td><input name="code" type="text" id="code" value="{$code}" size="35" /></td>
</tr>

<tr>
<td align="right">&nbsp;</td>
<td><input type="submit" name="validate" value="Validate Email" onclick="return ValidateEmail()" /></td>
</tr>

<tr>
<td colspan="2">

<div>Do not have yet the registration code ? Click <a href="javascript:toggle('code-form')">HERE</a></div>

<div id="code-form">
<div class="code-form-note">Code verification is to ensure that your email address is valid.<br />
 Valid email address is required to process your application as this will be your initial means of contact. <b>Please click the button below.</b> </div>
 <div id="responder_message" class="responder_message"></div>

<div class="code-form-img"><img src="images/clksendemail.jpg" width="202" height="24" style="cursor:pointer;" onclick="SendCode()" align="texttop" /></div>

</div>
<div id="send-btn"></div>
 
</td>
</tr>

</table>
</div>
</form>
