<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="../timezones/cheatclock.php"></script>
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF;">
<tr>
	<td colspan="2">
	<table width="100%">
	<tr>
	<td width="4%" valign="middle"><img src="../images/flags/Philippines.png" align="middle" title="Philippines/Manila" /></td>
	<td width="18%" valign="middle"><b>Manila</b> <span id="manila"></span></td>
	<td width="4%"valign="middle"><img src="../images/flags/Australia.png" align="absmiddle" title="Australia/Sydney" /></td>
	<td width="20%" valign="middle"> <b>Sydney</b> <span id="sydney"></span></td>
	<td width="4%" valign="middle"><img src="../images/flags/usa.png" align="absmiddle" title="USA/San Francisco" /></td>
	<td width="26%" valign="middle"><b>San Francisco</b> <span id="sanfran"></span><br /> 
	  <b>New York</b> <span id="newyork"></span></td>
	<td width="4%" valign="middle"><img src="../images/flags/uk.png" align="absmiddle" title="UK/London" /> </td>
	<td width="20%"><b>London</b> <span id="london"></span> </td>
	</tr>
	</table>	</td>
</tr>

<tr><td valign="top" >
<img src="../images/remote-staff-logo2.jpg" alt="think" >
</td>

<td align="right" >

<div align="right"><?php include 'home_pages_link.php'; ?></div>
<!--
<iframe id="frame" name="frame" width="100%" height="100%" src="notes.php" frameborder="0" scrolling="no">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
-->
<div style="padding:5px; color:#666666;">
<?php 
if(@$_SESSION['admin_id']!="" or @$_SESSION['agent_no']!="" or @$_SESSION['client_id']!="" or @$_SESSION['userid']!="" )
{
	// display the chat link if rschat window is not yet opened //2011-02-02 - mike
	// always display the link - 2011-08-16
	//if (!$_SESSION['firstrun']) {
	$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
	echo "<a href=\"javascript:popup_win8('/livechat/rschat.php?portal=1&email=".$_SESSION['emailaddr']."&hash=".$hash_code."',800,600);\"  style='text-decoration:none;color:#666666;' title='Open remostaff chat'>Chat</a> | "; 
	//}
		
?>
	<a href="logout.php"  style="text-decoration:none;color:#666666;">Logout</a> | <a href="logout.php" style="text-decoration:none;color:#666666;" title="Login in Different Account">Login</a>
<?php
	if( !empty($_SESSION['logintype']) && $_SESSION['logintype'] == 'admin' ):
		$path =  explode('portal/', $_SERVER['SCRIPT_FILENAME']);
?>
	| <a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=<?php echo $path[count($path)-1];?>" style="text-decoration:none;color:#666666;" title="Open Help Page" target="_blank">Help Page</a>
	
<?php
	endif;
}
?>
</div>
</td>

</tr>
</table>
<!-- /HEADER -->