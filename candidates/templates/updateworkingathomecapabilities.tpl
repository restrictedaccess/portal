<html>
	<head>
		<title>Remotestaff - Update Working at Home Capabilities</title>
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
		
		<link rel="stylesheet" href="css/updateworkingathomecapabilities.css"/>
	</head>
	<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
		<div id="applynow">
			<form method="POST" name="frmPersonal" id="frmPersonal" onSubmit="return checkFields();">

				<input type="hidden" name="userid" value="{$userid}" />

				<h3>Working at Home Capabilities</h3>
				<div id="fieldcontents">
					<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
					<tr>
							<td width="180" align="right">Working Environment:</td>
							<td width="320">{$home_working_environment_Options}</td>
						</tr>
						<tr>
							<td height="47" align="right">Worked from home before:</td>
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
							<td align="right">Has baby in the house:</td>
							<td>{$have_a_baby_in_the_house_Options}</td>
						</tr>
						<tr>
							<td align="right">If yes, Who is the main caregiver?</td>
							<td>
							<input name="who_is_the_main_caregiver" id="who_is_the_main_caregiver" value="{$who_is_the_main_caregiver}" type="text" size="25" />
							</td>
						</tr>
						<tr>
							<td align="right" valign="top">Reason to work from home:</td>
							<td>															<textarea name="why_do_you_want_to_work_from_home" cols="35" rows="6" id="why_do_you_want_to_work_from_home">{$why_do_you_want_to_work_from_home}</textarea></td>
						</tr>
						<tr>
							<td align="right">Timespan to work with Remote Staff:</td>
							<td>
							<select name="how_long_do_you_see_yourself_working_for_rs" id="how_long_do_you_see_yourself_working_for_rs">
								<option value="">-</option>
								{$timespan_Options}

							</select></td>
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
							<td valign="top" style="border:0;">Speed Test Result Link :</td>
							<td align="left" valign="top" style="border:0;">
							<input name="speed_test_result_link" type="text" id="speed_test_result_link" value="{$speed_test_result_link}" size="25" />
							</td>
						</tr>
						<tr>
							<td align="right" valign="top"> Internet Consequences:</td>
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
							<td align="right" valign="top">Noise level at home:</td>
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
	
			

	</body>
</html>
