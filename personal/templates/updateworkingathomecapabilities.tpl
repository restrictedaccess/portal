<html>
	<head>
		<title>MyProfile &copy;ThinkInnovations.com</title>
		<link rel=stylesheet type=text/css href="/portal/css/font.css">
		<link rel=stylesheet type=text/css href="../css/resume.css">
		<link rel=stylesheet type=text/css href="../menu.css">
		<link rel=stylesheet type=text/css href="../application_form/css/style.css">
		<link rel=stylesheet type=text/css href="css/style.css">

		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script language=javascript src="../js/validation.js"></script>
		<script language=javascript src="../js/jquery.js"></script>
		<script language=javascript src="/portal/personal/js/updatepersonal.js"></script>

	</head>
	<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
			<tr>
				<td width="546" style="width: 220px; height: 60px;"><img src="../images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
				<td width="474">&nbsp;</td>
				<td width="211" align="right" valign="bottom"></td>
			</tr>
		</table>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('/portal/images/bg1.gif'); background-repeat: repeat-x">
			<tr>
				<td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
			</tr>
		</table>

		{include file="header.tpl"}


		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="32">
			<tr>
				<td width="736"  bgcolor="#abccdd" >
				<table width="736">
					<tr>
						<td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome</b>, {$fname}</td>
					</tr>
				</table></td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0" border="0" width="744">
			<tr>
				<td width="736" bgcolor="#ffffff" align="center">
				<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr>
						<td>
						<table width=736 cellpadding=0 cellspacing=0 border=0 align=center>
							<tr>
								<td colspan=2 style='height: 1px;'> {if $mess neq ""}
								<center>
									<b><font color='#FF0000' size='3'>There's an {$mess} Please try again</font></b>
								</center> {/if} </td>
							</tr>
							<tr>
								<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '> {php} include 'applicantleftnav.php'{/php} </td>
								<td width=566 valign=top align=right><img src='/portal/images/space.gif' width='1' height='10'>
								<br clear=all>
								<table width=566 cellpadding=10 cellspacing=0 border=0>
									<tr>
										<td>
										<table width=98% cellspacing=0 cellpadding=0 align=center>
											<tr>
												<td class=msg><b>Fill in this section to give employers a snapshot of your profile.</b>
												<br/>
												</td>
											</tr>
										</table>
										<br/>
										<div id="applynow">
											<form method="POST" name="frmPersonal" id="frmPersonal" onsubmit="return checkFields();">

												<input type="hidden" name="userid" value="{$userid}" />

												<h2>Working at Home Capabilities</h2>
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
														<tr>
															<td height="47" align="right"> Have you worked from home before? </td>
															<td>
															<input name="work_from_home_before"  type="radio" value="Yes" style="width:15px;" {$work_from_home_before_yes} />
															Yes, how long
															<select name="start_worked_from_home_year" id="start_worked_from_home_year">
																{$yearOptions}
															</select>
															<select name="start_worked_from_home_month" id="start_worked_from_home_month">
																{$monthOptions}
															</select>
															<br />
															<input name="work_from_home_before" type="radio" value="No" style="width:15px;" {$work_from_home_before_no} />
															No </td>
														</tr>
														<tr>
															<td align="right">Do  you have a baby in the house ? </td>
															<td>{$have_a_baby_in_the_house_Options}</td>
														</tr>
														<tr>
															<td align="right">If yes, Who is the main caregiver?</td>
															<td>
															<input name="who_is_the_main_caregiver" id="who_is_the_main_caregiver" value="{$who_is_the_main_caregiver}" type="text" size="25" />
															</td>
														</tr>
														<tr>
															<td align="right" valign="top">Why  do you want to work from home? </td>
															<td>															<textarea name="why_do_you_want_to_work_from_home" cols="35" rows="6" id="why_do_you_want_to_work_from_home">{$why_do_you_want_to_work_from_home}</textarea></td>
														</tr>
														<tr>
															<td align="right">How  long do you see yourself working for RemoteStaff ? </td>
															<td>
															<select name="how_long_do_you_see_yourself_working_for_rs" id="how_long_do_you_see_yourself_working_for_rs">
																<option value="">-</option>
																{$timespan_Options}

															</select></td>
														</tr>
														<tr>
															<td width="180" align="right">Home Working Environment:</td>
															<td width="320">{$home_working_environment_Options}</td>
														</tr>
														<tr>
															<td width="180" align="right">Internet Connection:</td>
															<td width="320">
															<select name="internet_connection" id="internet_connection">
																<option value="">-</option>
																{$internet_connections_Options}
															</select></td>
														</tr>
														<tr>
															<td width="180" align="right">Others
															<br />
															<span class="smalltext">(state whether wireless or wired):</span></td>
															<td width="320">
															<input name="internet_connection_others" type="text" id="internet_connection_others" value="{$internet_connection_others}" size="35" />
															</td>
														</tr>
														<tr>
															<td align="right">Internet Plan &amp; Package: </td>
															<td>
															<input name="internet_plan" type="text" id="internet_plan" value="{$internet_plan}" size="25" />
															<span class="smalltext"> e.g. PLDT excite plan</span></td>
														</tr>
														<tr>
															<td colspan="2" align="left" valign="top" style="background:#f7f7f7;"> Go to <a href="http://www.speedtest.net" target="_blank">www.speedtest.net</a> website and place what your upload & download Mbps speed . </td>
														</tr>
														<tr align="right">
															<td colspan="2" align="center" valign="top" style="border:0;"><img src="/portal/images/speedtest.jpg" width="400" height="264" border="1" /></td>
														</tr>
														<tr align="right">
															<td valign="top" style="border:0;">Speed Test Result Link :</td>
															<td align="left" valign="top" style="border:0;">
															<input name="speed_test_result_link" type="text" id="speed_test_result_link" value="{$speed_test_result_link}" size="25" />
															</td>
														</tr>

														<tr>
															<td colspan="2" align="justified" valign="top" style="border:0;"><strong>Please note: </strong>To make working from home a sustainable career your internet becomes your lifeline. As a possible remote staff contractor you will need 1.0mbps download with 0.35mbps upload on a DSL broadband connection, WIFI connection is not acceptable because its not stable enough.</td>
														</tr>
														<tr>
															<td align="right" valign="top"> What is possible and what is not possible about your internet connection from home?</td>
															<td align="left" valign="top">															<textarea name="internet_consequences" cols="35" rows="7" id="internet_consequences">{$internet_consequences}</textarea></td>
														</tr>

														<tr>
															<td colspan="2" align="left" valign="top" style="background:#f7f7f7;">Resource Checklist</td>
														</tr>
														<tr>
															<td align="right" valign="top">
															<input type="checkbox"  name="desktop_computer" id="desktop_computer" value="yes" {$desktop_checked} />
															Desktop
															<select name="desktop_os" id="desktop_os" style="font-size:11px; width:80px">
																<option value="">Select OS</option>
																{$desktop_os_Options}
															</select></td>
															<td align="left" valign="top">
															<input name="desktop_processor" type="text" id="desktop_processor" value="{$desktop_processor}" size="13" />
															Processor
															<input name="desktop_ram" type="text" id="desktop_ram" value="{$desktop_ram}" size="13" style="width:75px;" />
															RAM</td>
														</tr>
														<tr>
															<td align="right" valign="top">
															<input type="checkbox" name="loptop_computer" id="loptop_computer" value="yes" {$laptop_checked} />
															Laptop
															<select name="loptop_os" id="loptop_os" style="font-size:11px; width:80px;">
																<option value="">Select OS</option>
																{$laptop_os_Options}
															</select></td>
															<td align="left" valign="top">
															<input name="loptop_processor" type="text" id="loptop_processor" value="{$laptop_processor}" size="13" />
															Processor
															<input name="loptop_ram" type="text" id="loptop_ram" value="{$laptop_ram}" size="13" style="width:75px;" />
															RAM</td>
														</tr>
														<tr>
															<td align="right" valign="top">Headset </td>
															<td align="left" valign="top">
															<input name="headset" type="text" id="headset" value="{$headset}" size="25" />
															Brand &amp; Model </td>
														</tr>
														<tr>
															<td align="right" valign="top">High Performance Headphones ***</td>
															<td align="left" valign="top">
															<input name="headphone" type="text" id="headphone" value="{$headphone}" size="25" />
															Brand &amp; Model </td>
														</tr>
														<tr>
															<td align="right" valign="top">Printer</td>
															<td align="left" valign="top">
															<input name="printer" type="text" id="printer" value="{$printer}" size="25" />
															Brand &amp; Model </td>
														</tr>
														<tr>
															<td align="right" valign="top">Scanner</td>
															<td align="left" valign="top">
															<input name="scanner" type="text" id="scanner" value="{$scanner}" size="25" />
															Brand &amp; Model </td>
														</tr>
														<tr>
															<td width="180" align="right" valign="top">Tablet
															<br />
															</td>
															<td width="320" align="left" valign="top">
															<input name="tablet" type="text" id="tablet" value="{$tablet}" size="25" />
															Brand &amp; Model </td>
														</tr>
														<tr>
															<td width="180" align="right">Pen tablet</td>
															<td width="320">
															<input name="pen_tablet" type="text" id="pen_tablet" value="{$pen_tablet}" size="25" />
															Brand &amp; Model </td>
														</tr>
														<tr>
															<td colspan="2" align="right" valign="top" style="background:#f7f7f7;">&nbsp;</td>
														</tr>
														<tr>
															<td align="right" valign="top">How  do you rate the noise level at your home location ?</td>
															<td>{$noise_level_Options} </td>
														</tr>
													</table>
												</div>
											
												<input type="hidden" value="{$process}" name="process"/>
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
														<tr>
															<td>&nbsp;</td>
															<td style="text-align: center">
															<button id="update-button" type="submit">
																UPDATE
															</button></td>
														</tr>
													</table>
												</div>
											</form>
										</div>
									</tr>
								</td>
							</tr>
						</table></td>
					</tr>
				</table></td>
			</tr>
		</table>
		</td>
		</table>

	</body>
</html>
