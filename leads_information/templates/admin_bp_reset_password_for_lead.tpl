<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$leads_info.fname} {$leads_info.lname} Reset password</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="./media/css/leads_information.css">
<link rel=stylesheet type=text/css href="../menu.css">
</head>

<body>

<form name="form" method="post" action="admin_bp_reset_password_for_lead.php" onsubmit="return checkEmail()">
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />
<table width="100%"  >

<tr>
<td colspan="2"><img src='http://{$site}/portal/images/remote_staff_logo.png' width='171' height='49' border='0'>
</td>
</tr>

{if $sent eq True}
<tr>
<td colspan="2" height="30" style="background:#FFFF00; font-weight:bold; text-align:center;">Message sent</td>
</tr>
{/if}

{if $email_error eq True}
<tr>
<td colspan="2" height="30" style="background:#FFFF00; font-weight:bold; text-align:center;">Please enter lead's email address</td>
</tr>
{/if}



<tr>
<td colspan="2">Reset password for {$leads_info.fname} {$leads_info.lname}</td>
</tr>

<tr>
<td>Email</td>
<td><input type="text" name="email" id="email" value="{$leads_info.email}" size="40" /></td>
</tr>

<tr>
<td colspan="2"><input type="submit" value="Submit" /></td>
</tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>
</form>

</body>
</html>