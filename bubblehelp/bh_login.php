<?php /* $Id: login.tpl 1 2011-04-05 mike $ */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>RS Help Page Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/portal/js/MochiKit.js"></script>

<script language="javascript">

</script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden" name="userid" value="<? echo $userid?>">

<script type="text/javascript">
<!--
connect(window, 'onload', function() { document.getElementById('emailaddr').focus(); });
//-->
</script>


<style type='text/css'>
body {
	margin: 0px;
	/*background-image: url(images/admin_bg.gif);
	background-repeat: repeat-x;*/
}
html, body {
	height: 100% !important;
}
body {
	text-align: center;
	background-image:url(./images/remote-staff-logo.jpg);
	background-position:top;
	background-repeat:repeat-x;
}
body, td, div {
	color: #666666;
}
div.box {
	border: 1px dashed #AAAAAA;
	padding: 15px;
	background: #FFFFFF;
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
        width: 270px;
}
td.login {
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
}
input.text {
	font-family: arial, tahoma, verdana, serif;
	font-size: 9pt; 
}
div.error {
	text-align: center;
	padding-top: 3px;
	font-weight: bold;
}
input.button {
	font-family: arial, tahoma, verdana, serif;
	font-size: 9pt;
	background: #DDDDDD;
	padding: 2px;
	font-weight: bold;
}
</style>


<table cellspacing='0' cellpadding='0' style='width: 100%; height: 90%;'>
<tr>
<td align='center'><div style='font-size:13px;font-weight:bold;padding:12px;'>Please login to generate static page</div>
	<form action='bhelp.php?/create_page/&curl=<?php echo $_GET['curl'];?>' method='POST'>
	<div class='box'>
		<table cellpadding='3' cellspacing='3'>
		<tr>
		<td class='login'>Email Address: &nbsp;</td>
		<td class='login'><input type='text' class='text' name='emailaddr' id='emailaddr' maxlength='50' value='<?php echo $_GET['email'];?>'> &nbsp;</td>
		</tr><tr>
		<td class='login'>Password: &nbsp;</td>
		<td class='login'><input type='password' class='text' name='password' id='password' maxlength='50'> &nbsp;</td>
		</tr>
		<tr>
		<td class='login'>Type: &nbsp;</td>
		<td class='login'><select class='text' name='login_type'>
		<option value='admin'>Admin</option>
		<option value='client'>Client</option>
		<option value='staff'>Staff</option>
		</select>
		&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' class='login' style='text-align:right'><input type='submit' class='button' value='Submit'></td>
		</tr>
		</table>
	</div>
	<input type='hidden' name='task' value='dologin'>
	<NOSCRIPT><input type='hidden' name='javascript' value='no'></NOSCRIPT>
	</form>
</td>
</tr>
</table>

</body>
</html>
