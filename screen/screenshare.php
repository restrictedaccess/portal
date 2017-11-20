<?php
/* $Id: screenshare.php 1 2012-10-04 mike $
  2013-08-09 - added admin access
*/
	session_start();
	if(empty($_SESSION['client_id']) && empty($_SESSION['admin_id']) && empty($_SESSION['userid'])) {
		die("Oops! No valid session found, please login to <a href='/portal/index.php'>www.emotestaff.com.au</a>.");
	}
	$tokenString = substr(md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $referral_id),2,15);
	$hostname = $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Screen Sharing</title>
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
	var ss_btn = document.getElementById('screenshareopen');
	ss_btn.onclick = function(){
		location.href='http://screen.remotestaff.net:5080/screenshare/screenshare.jsp?app=oflaDemo&stream=<?php echo $tokenString;?>';
	}
});
//-->
</script>


<style type='text/css'>
body {
	margin: 0px;
}

div.box {
	float:left;
	border: 1px dashed #AAAAAA;
	padding: 12px;
	background: #FFFFFF;
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
    width: 490px;
}
td.label {
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
}
td.data {
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
	color:#ff0000;
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
<table cellspacing='0' cellpadding='0' style='width:100%;float:left;bor'>
<tr>
<td align='center' style='padding:30px 0 0 50px;'>
	<div style='float:left;font-size:12px;padding:1px 0 7px 0;text-align:left;width:100%;top:20px;'>
	<p>Copy the <span style='color:#ff0000'>RED</span> text below and give it to the person you are intending to share your screen.<br/>
	You can give this to multiple number of viewers.</p>
	</div>
	<form action='bhelp.php?/create_page/&curl=<?php echo $tokenString;?>' method='POST'>
	<div class='box'>
		<table cellpadding='3' cellspacing='3'>
		<tr>
		<td class='label' id='ssid_lbl'>
			<span onmouseover="tooltip('This is the link where user can view your screen.');" onmouseout="exit();">Access Link:</span> &nbsp;</td>
		<td class='data'>
			<span  id='token' style='font-weight:bold;'>http://<?php echo $hostname;?>/portal/screen/screenviewer.php</span> &nbsp;
		</td>
		</tr>
		
		<tr>
		<td class='label' id='ssid_lbl'>
			<span onmouseover="tooltip('This unique ID will be needed by your Viewers to access your screen.');" onmouseout="exit();">Screen Share ID:</span> &nbsp;</td>
		<td class='data'>
			<span id='token' style='font-weight:bold;'><?php echo $tokenString;?></span>
		</td>
		</tr><tr><td>&nbsp;</td></tr>
		<tr>
		<td colspan='2' class='login' style='text-align:center;height:30px;'><input id='screenshareopen' type='button' class='button' value='Open ScreenShare Tool'></td>
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
