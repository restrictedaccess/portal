<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="/portal/css/font.css">
<link rel=stylesheet type=text/css href="../css/resume.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css
	href="../application_form/css/style.css">
<link rel=stylesheet type=text/css href="css/style.css">

<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script language=javascript src="../js/validation.js"></script>
<script language=javascript src="../js/jquery.js"></script>
<script language=javascript src="/portal/personal/js/updatepersonal.js"></script>

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

	{include file="header.tpl"}


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
													<table width=98% cellspacing=0 cellpadding=0 align=center>
														<tr>
															<td class=msg><b>Fill in this section to give employers a
																	snapshot of your profile.</b> <br />
															</td>
														</tr>
													</table> <br />
													<div id="applynow">
														<form name="form" method="post">

															<h2 style="padding-left:8px">Trainings &amp; Seminars Attended</h2>
															<div id="fieldcontents">
																<table width="500" border="0" cellspacing="0"
																	cellpadding="0" id="applyform">

																	<tr>
																		<td width="500" colspan="2" align="left"><textarea
																				cols="80" rows="20"
																				name="trainings_seminars"
																				id="trainings_and_seminars_attended">{$trainings_seminars}</textarea>
																		</td>
																	</tr>
																</table>
															</div>

															<h2 style="padding-left:8px">Highest Academic Qualification</h2>
															<div id="fieldcontents">
																<table style="width: 600px" border="0" cellspacing="0"
																	cellpadding="0" id="applyform">
																	<tr>
																		<td width="200" align="right">Highest Level:</td>
																		<td width="300"><select name="educationallevel"
																			id="highest_level"> {$highest_level_options}

																		</select></td>
																	</tr>
																	<tr>
																		<td width="200" align="right">Field of Study:</td>
																		<td width="300"><select name="field_of_study"
																			id="field_of_study"> {$field_of_study_options}
																		</select></td>
																	</tr>
																	<tr>
																		<td align="right">Others( please specify )</td>
																		<td><input name="others" id="others" type="text"
																			size="35" value="{$others}" /></td>
																	</tr>
																	<tr>
																		<td align="right">Major:</td>
																		<td><input name="major" type="text" id="major"
																			size="35" value="{$major}" /></td>
																	</tr>
																	<tr>
																		<td align="right" valign="top">Grade:</td>
																		<td><select name="grade" id="grade"> {$grade_options}
																		</select> <br /> <br /> If GPA, please enter score: <input
																			name="gpascore" type="text" id="gpascore" size="5"
																			value="{$gpascore}" /> out of 100</td>
																	</tr>
																	<tr>
																		<td align="right">Institute / University:</td>
																		<td><input name="college_name" type="text"
																			id="university" size="35" value="{$college_name}" />
																		</td>
																	</tr>
																	<tr>
																		<td align="right">Located in:</td>
																		<td><select name="college_country"
																			id="university_location">
																				{$university_location_options}
																		</select>
																		</td>
																	</tr>
																	<tr>
																		<td align="right" valign="top">Graduation date:</td>
																		<td><select name="graduate_month" id="graduate_month"
																			class=text> {$month_options}
																		</select> - <input type="text" name="graduate_year"
																			id="graduate_year" size=4 maxlength=4 style=''
																			value="{$graduate_year}" class="text"> (YYYY)<br /> <br>
																			&nbsp;&nbsp;<font class=tip>&gt; Enter expected
																				graduation date if still pursuing</font></td>
																	</tr>
																</table>
																<br />
																<!--<p align="center"><strong><a href="#"  style="color:red !important">Click Here to add another Academic Qualification</a></strong></p>-->
															</div>


															<input type="hidden" value="{$process}" name="process" />
															<div id="fieldcontents">
																<table width="500" border="0" cellspacing="0"
																	cellpadding="0" id="applyform">
																	<tr>
																		<td>&nbsp;</td>
																		<td style="text-align: center">
																			<button id="update-button" type="submit">UPDATE</button>
																		</td>
																	</tr>
																</table>
															</div>
														</form>
													</div>
												</td>
											</tr>
										</table>
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
