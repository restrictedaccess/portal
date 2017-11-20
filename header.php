<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="timezones/cheatclock.php"></script>
<script type="text/javascript" src="/portal/bugreport/pullmenu.js"></script>
<link rel=stylesheet type=text/css href="/portal/seatbooking/css/pullmenu.css">
<style type="text/css">
a.hlink {text-decoration:none;color:#666666;}
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF;">
	<tr>
		<td colspan="2">
			<table width="100%">
				<tr>
					<td width="4%" valign="middle"><img src="images/flags/Philippines.png" align="middle" title="Philippines/Manila" /></td>
					<td width="18%" valign="middle"><b>Manila</b> <span id="manila"></span></td>
					<td width="4%"valign="middle"><img src="images/flags/Australia.png" align="absmiddle" title="Australia/Sydney" /></td>
					<td width="20%" valign="middle"> <b>Sydney</b> <span id="sydney"></span></td>
					<td width="4%" valign="middle"><img src="images/flags/usa.png" align="absmiddle" title="USA/San Francisco" /></td>
					<td width="26%" valign="middle"><b>San Francisco</b> <span id="sanfran"></span><br /> 
						<b>New York</b> <span id="newyork"></span></td>
					<td width="4%" valign="middle"><img src="images/flags/uk.png" align="absmiddle" title="UK/London" /> </td>
					<td width="20%"><b>London</b> <span id="london"></span> </td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td valign="top" ><img src="images/remote-staff-logo2.jpg" alt="think" ></td>
		<td align="right" >

		<div align="right"><?php include 'home_pages_link.php'; ?></div>
		<div style="padding:5px; color:#666666;">

<?php 
			echo '<a href="#" onmouseover="showReportMenu(this)" onmouseout="mclosetime()" class="hlink" style="text-decoration: none">Bug Report</a> | ';
			if( (!empty($_SESSION['admin_id']) && $_SESSION['logintype'] == 'admin') ||
				($_SESSION['logintype'] == 'business_partner' && !empty($_SESSION['agent_no'])) ) {
			echo '<a href="https://remotestaffdotcomau.atlassian.net/wiki/display/RS" title="Open the Wiki page" target="_blank" class="hlink" style="text-decoration: none">Wiki</a> | ';
			echo '<a href="logout.php" class="hlink" style="text-decoration: none">Logout</a>';
	}
?>
</div>
</td>

</tr>
</table>

<!-- /HEADER -->


