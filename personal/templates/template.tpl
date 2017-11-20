<!DOCTYPE HTML>
<html>
<head>
<title>Applicant Home</title>
<link rel=stylesheet type=text/css href="/portal/css/font.css">
<link rel=stylesheet type=text/css href="../css/resume.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css
	href="../application_form/css/style.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="css/myresume.css">



<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script language=javascript src="../js/validation.js"></script>
<script language=javascript src="../js/jquery.js"></script>

</head>
<body style="background: #ffffff" text="#000000" topmargin="0"
	leftmargin="0" marginheight="0" marginwidth="0">
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		style="background-color: #FFFFFF; background-repeat: repeat-x;">
		<tr>
			<td width="546" style="width: 220px; height: 60px;"><img
				src="../images/remotestafflogo.jpg" alt="think" width="416"
				height="108">
			</td>
			<td width="474">&nbsp;</td>
			<td width="211" align="right" valign="bottom"></td>
		</tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0"
		style="width: 100%; background: URL('/portal/images/bg1.gif'); background-repeat: repeat-x">
		<tr>
			<td style="border-bottom: 2px #0d509e solid;">&nbsp;</td>
		</tr>
	</table>

	<ul class="glossymenu">
		<li><a href="/portal/applicantHome.php"><b>Home</b> </a></li>
		<li class="current"><a href="/portal/personal/myresume.php"><b>MyResume</b> </a></li>
		<li><a href="/portal/myapplications.php"><b>Applications</b> </a></li>
		<li><a href="/portal/jobs.php"><b>Search Jobs</b> </a></li>
	</ul>

	<table cellpadding="0" cellspacing="0" border="0" width="100%"
		height="32">
		<tr>
			<td width="736" bgcolor="#abccdd">
				<table width="736">
					<tr>
						<td style="font: 8pt verdana;">&#160;&#160;<b>Welcome</b>,
							{$fname}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" border="0" width="744">
		<tr>
			<td width="736" bgcolor="#ffffff" align="center">
				<table width="736" cellpadding="0" cellspacing="0" border="0"
					align="center">
					<tr>
						<td>
							<table width=736 cellpadding=0 cellspacing=0 border=0
								align=center>
								<tr>
									<td colspan=2 style='height: 1px;'>{if $mess neq ""}
										<center>
											<b><font color='#FF0000' size='3'>There's an {$mess} Please
													try again</font> </b>
										</center> {/if}</td>
								</tr>
								<tr>
									<td
										style='border-right: #006699 2px solid; width: 170px; vertical-align: top;'>
										{php} include 'applicantleftnav.php'{/php}</td>
									<td width=566 valign=top align=right><img
										src='/portal/images/space.gif' width='1' height='10'><br
										clear=all>
										<table width=566 cellpadding=10 cellspacing=0 border=0>
											<tr>
												<td>
													{include file="$tpl_name.tpl"}
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
				
				</table>

</body>
</html>
