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
<script language=javascript src="/portal/personal/js/updateskills.js"></script>

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
															<td class=msg>Any learned capacity you are able to carry out and be able to deliver a quality results is what we would mean by skills. Please do not overlook basic skills as well, you might be tech savvy and a fast internet user, list this capacity. You might be great at word and excel with microsoft, list those as skills along with other capacities you might have. Add as many skills you feel you have experience and capacity with.
															</td>
														</tr>
													</table> <br />
													<div id="applynow">
														
														
														
														<form name="form" method="post" id="addtechnicalskill">
															<input type="hidden" name="userid" value="{$userid}"/>
															<input type="hidden" name="skill_type" value="technical"/>
															
															<h2>Add a Technical Skill</h2>
															<div id="fieldcontents">
																<div id="resultarea">
																	<table border="0" cellspacing="0" cellpadding="0" id="applyform">
																		<tr>
																			<td width="200" align="right">Skills:</td>
																			<td width="300">
																				<select name="skill" id="skill_technical">
																					{$skill_options}
																				</select>
																			</td>
																		</tr>
																		<tr>
																			<td width="200" align="right">Experience:</td>
																			<td width="300">
																				<select name="experience" id="experience_technical">
																					{$experience_options}
																				</select>
																			</td>
																		</tr>
																		<tr>
																			<td width="200" align="right">Proficiency:</td>
																			<td width="300">
																				<select name="proficiency" id="proficiency_technical">
																					{$proficiency_options}
																				</select>
																			</td>
																		</tr>
																		
																		
																	</table>	
																</div>
															</div>
															<div id="fieldcontents">
																<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
																	<tr>
																		<td>&nbsp;</td>
																		<td style="text-align: center">
																		<button id="update-button" type="submit">
																			ADD
																		</button></td>
																	</tr>
																</table>
															</div>
															
															
															<table width=98% cellspacing=0 cellpadding=0 align=center>
																<tr>
																	<td><strong>My Technical Skills</strong></td>
																</tr>
																<tr>
																	<td bgcolor=#333366 height=1><img src='../images/space.gif' height=1 width=1>
																	</td>
																</tr>
																<tr>
																	<td>
																	<table id="technical-table" width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
																		<tr>
																			<td width='6%' align=center>#</td>
																			<td width='33%' align=left><b><font size='1'>Skill</font></b></td>
																			<td width='26%' align=center><b><font size='1'>Experience</font></b></td>
																			<td width='35%' align=center><b><font size='1'>Level</font></b></td>
																			<td width='26%' align=center><b><font size='1'>Action</font></b></td>
																		</tr>
																		{$technical_skills}
																	</table>
																	</td>
																</tr>
															</table>
														</form>
														
														

														<form name="form" method="post" id="addadminskill" style="margin-top:10px;">
															<input type="hidden" name="userid" value="{$userid}"/>
															<input type="hidden" name="skill_type" value="admin"/>
															
															<h2>Add an Admin Skill</h2>
															<div id="fieldcontents">
																<div id="resultarea">
																	<table border="0" cellspacing="0" cellpadding="0" id="applyform">
																		<tr>
																			<td width="200" align="right">Skills:</td>
																			<td width="300">
																				<select name="skill" id="skill_admin">
																					{$admin_skill_options}
																				</select>
																			</td>
																		</tr>
																		<tr>
																			<td width="200" align="right">Experience:</td>
																			<td width="300">
																				<select name="experience" id="experience_admin">
																					{$experience_options}
																				</select>
																			</td>
																		</tr>
																		<tr>
																			<td width="200" align="right">Proficiency:</td>
																			<td width="300">
																				<select name="proficiency" id="proficiency_admin">
																					{$proficiency_options}
																				</select>
																			</td>
																		</tr>
																		
																		
																	</table>	
																</div>
															</div>
															<div id="fieldcontents">
																<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
																	<tr>
																		<td>&nbsp;</td>
																		<td style="text-align: center">
																		<button id="update-button" type="submit">
																			ADD
																		</button></td>
																	</tr>
																</table>
															</div>
															
															
														<table width=98% cellspacing=0 cellpadding=0 align=center>
															<tr>
																<td><strong>My Admin Skills</strong></td>
															</tr>
															<tr>
																<td bgcolor=#333366 height=1><img src='../images/space.gif' height=1 width=1>
																</td>
															</tr>
															<tr>
																<td>
																	<table id="admin-table" width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
																		<tr>
																			<td width='6%' align=center>#</td>
																			<td width='33%' align=left><b><font size='1'>Skill</font></b></td>
																			<td width='26%' align=center><b><font size='1'>Experience</font></b></td>
																			<td width='35%' align=center><b><font size='1'>Level</font></b></td>
																			<td width='26%' align=center><b><font size='1'>Action</font></b></td>
																		</tr>
																		{$admin_skills}
																	</table>
																</td>
															</tr>
														</table>
														</form>
														
														<form name="form" method="post" id="addotherskill" style="margin-top:10px;">
															<input type="hidden" name="userid" value="{$userid}"/>
															<input type="hidden" name="skill_type" value=""/>
															
															<h2>Add Other Skill</h2>
															<div id="fieldcontents">
																<div id="resultarea">
																	<table border="0" cellspacing="0" cellpadding="0" id="applyform">
																		<tr>
																			<td width="200" align="right">Skills:</td>
																			<td width="300">
																				<input type="text" name="skill" id="skill_other"/>
																			</td>
																		</tr>
																		<tr>
																			<td width="200" align="right">Experience:</td>
																			<td width="300">
																				<select name="experience" id="experience_other">
																					{$experience_options}
																				</select>
																			</td>
																		</tr>
																		<tr>
																			<td width="200" align="right">Proficiency:</td>
																			<td width="300">
																				<select name="proficiency" id="proficiency_other">
																					{$proficiency_options}
																				</select>
																			</td>
																		</tr>
																		
																		
																	</table>	
																</div>
															</div>
															<div id="fieldcontents">
																<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
																	<tr>
																		<td>&nbsp;</td>
																		<td style="text-align: center">
																		<button id="update-button" type="submit">
																			ADD
																		</button></td>
																	</tr>
																</table>
															</div>
															
															
														<table width=98% cellspacing=0 cellpadding=0 align=center>
															<tr>
																<td><strong>My Other Skills</strong></td>
															</tr>
															<tr>
																<td bgcolor=#333366 height=1><img src='../images/space.gif' height=1 width=1>
																</td>
															</tr>
															<tr>
																<td>
																	<table id="other-table" width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
																		<tr>
																			<td width='6%' align=center>#</td>
																			<td width='33%' align=left><b><font size='1'>Skill</font></b></td>
																			<td width='26%' align=center><b><font size='1'>Experience</font></b></td>
																			<td width='35%' align=center><b><font size='1'>Level</font></b></td>
																			<td width='26%' align=center><b><font size='1'>Action</font></b></td>
																		</tr>
																		{$other_skills}
																	</table>
																</td>
															</tr>
														</table>
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
