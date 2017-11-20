{* screenshare_admin.tpl //2013-08-09
	- screen share access for admin, based from adminHome.tpl $ *}
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Portal Administrator Home</title>

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
			<li>2.  <a href="screen/screenshare.exe" target="_blank">Click Here</a> to download the Screen Sharing application.</li></br>
			<li>3.  Run the application.  </li></br>
			<li>4.  Log in using your email identity when dialog box pops up. (First time users). </li></br>
			<li>5.  Give the Screen Access Link to your viewer (located at the bottom of application window) </li></br>
			<li>6.  Click on "<strong style="color:#ff0000">Start Sharing</strong>" Button.</li></br>
			<li>7.  Your viewer can now see your screen! To finish session , click "<strong style="color:#ff0000">Stop Sharing</strong>" button.</li></br>
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
