<?php
include './conf/zend_smarty_conf_root.php';
$userid = $_SESSION['userid'];
//echo $userid;
if($_SESSION['userid']=="")
{
	header("location:index.php");
}
$query="SELECT * FROM personal WHERE userid=$userid";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sub-contractor - Screen Recording</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script type="text/javascript" src="js/MochiKit.js"></script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <?php echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
 <?php include 'subconleftnav.php';?></td>
<td width="1081" valign="top" style="padding:10px;">
<h2 style="margin:2px;">RemoteStaff Screen Recorder</h2>
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" style="margin-top:0px;">

<tr bgcolor="#FFFFFF">
<td>
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
	
</td>

</tr>


</table>
</td>
</tr>
</table>
<?php include 'footer.php';?>
</body>
</html>
