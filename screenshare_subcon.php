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
<title>Sub-contractor Home</title>
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
<h2 style="margin:2px;">Remotestaff Screen Share</h2>
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" style="margin-top:0px;">

<tr bgcolor="#FFFFFF">
<td>
	<p><strong>What is RemoteStaff Screen Sharing?</strong></p>
		<ul>
			<li>This tool will allow you to share your computer screen to your client or to other staff. </li></br>
			<li>The Remote Staff Screen sharing tool is built for you and your client to enrich communication with your team.          
This can be used while on a phone call or any other instant messaging voice calls (Skype, Yahoo, Gtalk, Etc.) 
</li></br>
        </ul>
		<br/>
		<p><strong>How to Use Remote Staff Screen Sharing?</strong></p>
		<!--<p><a href='http://screen.remotestaff.net:5080/screen/viewer.jsp?file=KArY3yCCaUO0' target='_blank'>View Quick 1.42 Minutes Video Here</a> Or Follow Steps Below</p>-->
		<ul class="howto">
			<li>1.  Please ensure that you have JAVA in your computer , if you're not sure, <a href="http://www.java.com/en/download/testjava.jsp" target="_blank">click here</a> to download and install. </li></br>
			<li>2.  <a href="screen/screenshare.exe" target="_blank">Click Here</a> to download the Screen Sharing application.</li></br>
			<li>3.  Run the application.  </li></br>
			<li>4.  Log in using your email identity when dialog box pops up. (First time users). </li></br>
			<li>5.  Give the Screen Access Link to your viewer (located at the bottom of application window) </li></br>
			<li>6.  Click on "<strong style="color:#ff0000">Start Sharing</strong>" Button.</li></br>
			<li>7.  Your viewer can now see your screen! To finish session , click "<strong style="color:#ff0000">Stop Sharing</strong>" button.</li></br>
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
