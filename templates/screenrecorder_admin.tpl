{* screenshare_admin.tpl //2013-08-09
	- screen share access for admin, based from adminHome.tpl $ *}
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Portal Administrator</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">

<link rel=stylesheet type=text/css href="./system_wide_reporting/media/css/tabber.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script language=javascript src="./js/functions.js"></script>


<link rel="stylesheet" type="text/css" media="all" href="./css/calendar-blue.css" title="win2k-1" />

</head>
<body style="margin-top:0; margin-left:0">
	
<FORM NAME="parentForm" method="post">
{php}include("header.php"){/php}
{php}include("admin_header_menu.php"){/php}

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<tr><td width="18%" valign="top" style="border-right: #006699 2px solid;">
{php}include("adminleftnav.php"){/php}
</td>
<td valign="top">
<div align="right">Welcome #{$admin.admin_id} {$admin.admin_fname} {$admin.admin_lname}</div>

<div id="admin_tab" style="display:block; padding:20px; ">
<div class="tabber">
<p><strong>RemoteStaff Screen Recorder</strong></p>
	
	<div>This is a tool that will allow you to record your computer screen and to give instruction and share it to others.<br/>
This is a good tool for recording instructions or tutorials.
<p><strong style='color:#ff0000'>Note:</strong> This application requires that you have Java in your computer and the Flash plugin,<br/>
<a href="http://www.java.com/en/download/testjava.jsp" target="_blank">click here</a> to check if you have latest version of Java. 
	
</p>
</div>
		<br/>
		<p>To start using, please follow below.</p>
		<ul class="howto">
			<li>1. Get the application
			<p style='padding-left:8px'>- For Windows users: <a href='/portal/screen/screc_setup.exe'>click here</a> to download and install.<br/>
			- For Mac users: <a href='/portal/screen/screenrecorder_mac.zip'>click here</a> to download the binary copy. 
			</p>
			</li>
			<li>2. Open the application</li><br/>
			<li>3. Click Start Recording. Note that you can select the area of the screen you want to record.
			<p><img src='images/screc/start_recording.png'/></p>
			<br/>
			<span>Clicking start recording button will minimize the window. When you are done recording, just click and restore the Screen Recorder video,<br/>
			doing so will automatically stop and prepare your video.</span>
			<p><img src='images/screc/menu_bar2.png'/></p><br/>
			<span>You will have an option to cancel the video preparation.</span>
			<p><img src='images/screc/cancel.png'/></p><br/>
			</li><br/>
			<li>4. Decide how you would want to share or store your screen video.
			<p><img src='images/screc/preview2.png'/></p>
			</li>
			<p>&nbsp;</p>
        </ul>

</div>
</div>

</td>
</tr>
</table>
<!--ASL ALARM--> <DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV> <!--ENDED-->
{php}include("footer.php"){/php}
</form>
</body>
</html>
