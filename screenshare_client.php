<?php
// 2013-03-05 - screenshare.php

include '../conf/zend_smarty_conf.php';
if(empty($_SESSION['client_id'])) {
	header("location:index.php");
	exit;
}
?>

<html>
<head>
<title>Screen Sharing</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script language=javascript src="js/functions.js"></script>
<style type="text/css">
ul.howto {list-style-type:none;margin:0;}
</style>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<?php if ($_REQUEST["page_type"]!="iframe"){
	?>
		<?php include 'header.php';?>
		<?php include 'client_top_menu.php';?>	
	<?php
}?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr>
	<?php if ($_REQUEST["page_type"]!="iframe"){
	?>
	<td width="24%"style="border-right: #006699 2px solid; width: 170px; vertical-align:top;"><?php include 'clientleftnav.php';?></td>
	<?php }?>
<td style="width:100%;padding:15px;">
<p><strong>What is RemoteStaff Screen Sharing?</strong></p>
		<ul>
			<li>This tool will allow you to share your computer screen to your staff or team. </li></br>
			<li>The Remote Staff Screen sharing tool is built for you  and your staff members to enrich communication with your team.          
This can be used while on a phone call or any other instant messaging voice calls (Skype, Yahoo, Gtalk, Etc.) 
</li></br>
        </ul>
		<br/>
		<p><strong>How to Use Remote Staff Screen Sharing?</strong></p>
		<!--<p><a href='http://screen.remotestaff.net:5080/screen/viewer.jsp?file=KArY3yCCaUO0' target='_blank'>View Quick 1.42 Minutes Video Here</a> Or Follow Steps Below</p>-->
		<ul class="howto">
			<li>1.  Please ensure that you have JAVA in your computer , if you're not sure, <a href="http://www.java.com/en/download/testjava.jsp" target="_blank">click here</a> to download and install. </li></br>
			<!--<li>2.  <a href="screen/screenshare.php" target="_blank">Click Here</a> to Share your Screen.</li></br>-->
			<li>2.  <a href="screen/screenshare.exe" target="_blank">Click Here</a> to download the Screen Sharing application.</li></br>
			<li>3.  Run the application.  </li></br>
			<li>4.  Log in using your email identity when dialog box pops up. (First time users). </li></br>
			<!--<li>3.  Give the unique screen sharing ID to your viewer. </li></br>-->
			<li>5.  Give the Screen Access Link to your viewer (located at the bottom of application window) </li></br>
			<!--<li>4.  <strong style="color:#ff0000">Click Open Screen Share Tool</strong> Button </li></br>
			<li>5.  A new box will pop, click on "<strong style="color:#ff0000">Start Sharing</strong>" Button.</li></br>-->
			<li>6.  Click on "<strong style="color:#ff0000">Start Sharing</strong>" Button.</li></br>
			<li>7.  Your viewer can now see your screen! To finish session , click "<strong style="color:#ff0000">Stop Sharing</strong>" button.</li></br>
        </ul>
</td>

</tr>
<tr>
<td colspan="3" style="border-top:#666666 solid 1px;">&nbsp;</td>
</tr>
<?php if ($_REQUEST["page_type"]!="iframe"){
	?>
<tr bgcolor="#FFFFFF">
<td colspan="3" valign="middle"  height="30" style="border-bottom:#666666 solid 1px;" align="center">
<br />
<?php }?>
</p>


</td></tr>
</table></td>
</tr>
</table>
<?php if ($_REQUEST["page_type"]!="iframe"){
	?>
<?php include 'footer.php';?>
<?php }?>
</body>
</html>
