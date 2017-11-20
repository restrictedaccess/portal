<?php
// 2013-03-05 - screenshare.php

include '../conf/zend_smarty_conf.php';
if(empty($_SESSION['client_id'])) {
	header("location:index.php");
	exit;
}
$page_type = $_REQUEST["page_type"];
?>

<html>
<head>
<title>Screen Recording</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script language=javascript src="js/functions.js"></script>
<style type="text/css">
ul.howto {list-style-type:none;margin:0;}
</style>
</head>
<?php if ($page_type=="iframe"){
	?>
	<style type="text/css">
		body{
			width:600px;
		}
	</style>
	<?php
}?>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<?php if ($page_type!="iframe"){
	include 'header.php';
	include 'client_top_menu.php';
}?>
<table width="<?php if ($page_type=="iframe"){ echo "600"; }else{ echo "100%"; }?>" cellpadding=0 cellspacing=0 border=0 >
<tr><td width="24%"style="border-right: #006699 2px solid; width: 170px; vertical-align:top;"><?php if ($page_type!="iframe"){ include 'clientleftnav.php'; }?></td>
<td style="width:100%;padding:15px;">
<p><strong>RemoteStaff Screen Recorder</strong></p>
<div>This is a tool that will allow you to record your computer screen and to give instruction and share it to you staff members.<br/>
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
			<li>5. Choosing "Share To Your Remote Staff" or "Create Workflow Task" will save the screen video inside your Client Portal<br/>
			and will be accessible to you and your staff in the next 3 months.
			The videos are auto-deleted after 3 months.</li><br/>
			<span>The list of your screen videos is accessible on the Screen Recording Links tab.</span>
			<p>&nbsp;</p>
        </ul>
</td>

</tr>
<tr>
<td colspan="3" style="border-top:#666666 solid 1px;">&nbsp;</td>
</tr>
<tr bgcolor="#FFFFFF">
<td colspan="3" valign="middle"  height="30" style="border-bottom:#666666 solid 1px;" align="center">
<br />
</p>


</td></tr>
</table></td>
</tr>
</table>
<?php if ($page_type!="iframe"){
include 'footer.php';
}
?>
</body>
</html>
