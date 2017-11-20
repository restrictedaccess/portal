<?php /* screenviewer.php */
	/*session_start();
	if(empty($_SESSION['client_id']) && empty($_SESSION['admin_id']) && empty($_SESSION['userid'])
	   && empty($_SESSION['agent_no']) ) {
		header("location: /portal/index.php");
		exit;
	}*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>RS ScreenShare - Viewer</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/portal/js/MochiKit.js"></script>

<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>
<link rel="stylesheet" href="/portal/typingtest/css/stylesheet.css" type="text/css" />
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden" name="userid" value="<? echo $userid?>">

<script type="text/javascript">
<!--
connect(window, 'onload', function(){
	var ss_btn = document.getElementById('screenshareview');
	ss_btn.onclick = function(){
		var ssID = document.getElementById('ssID').value;
		location.href='http://screen.remotestaff.net:5080/screenshare/screenviewer.html?stream='+ssID;
	}
});
//-->
</script>


<style type='text/css'>
body {
	margin: 0px;
}

div.box {
	border: 1px dashed #AAAAAA;
	padding: 25px;
	background: #FFFFFF;
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
        width: 370px;
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
.rslogo {
	width: 700px;
	height: 89px;
	float: left;
	padding: 0px;
	margin: 0px;
	background-image:url(/portal/images/remote-staff-logo2.jpg);
	background-position: center left;
	background-repeat:no-repeat;
}
</style>
<div style='float:left;width:100%'><div class="rslogo" id="rslogo"></div></div>
<br/><br/>
<table cellspacing='0' cellpadding='0' style='width:100%;float:left;'>
<tr>
<td align='center'><div style='font-size:13px;font-weight:bold;padding:25px;'>Enter Screenshare ID here</div>
	<form action='http://screen.remotestaff.net:5080/screenshare/screenviewer.html?=<?php echo $tokenString;?>' method='POST'>
	<div class='box'>
		<table cellpadding='3' cellspacing='3'>
		<tr>
		<td class='login' id='ssid_lbl'>ScreenShare ID: &nbsp;</td>
		<td class='login'>
			<input type='text' class='text' name='ssID' id='ssID' maxlength='50'> &nbsp;
		</td>
		</tr>
		<!--<tr>
		<td class='login'>Type: &nbsp;</td>
		<td class='login'><select class='text' name='login_type'>
		<option value='admin'>Admin</option>
		<option value='client'>Client</option>
		<option value='staff'>Staff</option>
		</select>
		&nbsp;</td>
		</tr>-->
		<tr>
		<td colspan='2' class='login' style='text-align:center'>
			<input id='screenshareview' type='button' class='button' value='View the screen'></td>
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
