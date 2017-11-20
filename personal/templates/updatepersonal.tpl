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
												<input type="hidden" name="userid" value="{$userid}" id="userid" />
												<h2>Personal Details</h2>
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyForm">
														<tr>
															<td width="200" align="right"> First Name: </td>
															<td width="300">
															<input name="fname" id="fname" size="35" type="text" value="{$fname}"/>
															</td>
														</tr>
														<tr>
															<td width="200" align="right"> Middle Name: </td>
															<td width="300">
															<input name="middle_name" id="mname" size="35" type="text" value="{$middle_name}"/>
															</td>
														</tr>

														<tr>
															<td width="200" align="right"> Last Name: </td>
															<td width="300">
															<input name="lname" id="lname" size="35" type="text" value="{$lname}"/>
															</td>
														</tr>

														<tr>
															<td width="200" align="right"> Nickname: </td>
															<td width="300">
															<input name="nick_name" id="nname" size="35" type="text" value="{$nick_name}"/>
															</td>
														</tr>

														<tr>
															<td width="200" align="right"> Date of Birth: </td>
															<td width="300">
															<select name="bmonth" class="text" id="bmonth">
																{$monthOptions}
															</select>&nbsp;-&nbsp;
															<select name="bday" class="text" id="bday">
																{$dayOptions}
															</select>&nbsp;-&nbsp;
															<input type="text" name="byear" size="4" maxlength=4 style='width=50px' value="{$byear}" id="byear"/>
															</td>
														</tr>

														<tr>
															<td width="200" align="right"> Identification: </td>
															<td width="300">
															<select name="auth_no_type_id" id="auth_no_type_id">
																<option value="">-</option>{$identificationOptions}
															</select>
															<input id="msia_new_ic_no" name="msia_new_ic_no" value="{$identification_number}" type="text" size="20" style="width:80px;" />
															</td>
														</tr>

														<tr>

															<td width="200" align="right"> Gender: </td>
															<td width="300"> {$genderOptions} </td>
														</tr>

														<tr>

															<td width="200" align="right"> Marital Status: </td>
															<td width="300">
															<select name="marital_status">
																{$marital_status_Options}
															</select></td>
														</tr>

														<tr>
															<td align="right">Number of kids ( if any)</td>
															<td>
															<input id="no_of_kids" name="no_of_kids" value="{$no_of_kids}" type="text" size="10" style="width:30px;"/>
															</td>
														</tr>

														<tr>
															<td align="right">Are you pregnant?</td>
															<td>
															<select name="pregnant" id="pregnant">
																{$pregnant_Options}
															</select></td>
														</tr>

														<tr>
															<td align="right">if yes, Expected Date of Delivery</td>
															<td>
															<select name="dmonth" id="dmonth">
																{$dmonthOptions}
															</select>
															<select name="dday" id="dday">
																<option value="">Day</option>
																{$ddayOptions}
															</select>
															<input type="text" class="ihalf" name="dyear" id="dyear" value="{$dyear}" size="5" maxlength="4" />
															<small style="color:#666666;"> (YYYY)</small></td>
														</tr>

														<tr>
															<td align="right">Nationality:</td>
															<td>
															<select name="nationality" id="nationality" style="width:200px;">
																{$nationalityOptions}
															</select></td>
														</tr>

														<tr>
															<td align="right">Permanent Residence In: </td>
															<td>
															<select name="permanent_residence" id="permanent_residence" style="width:200px;">
																{$countryOptions}
															</select></td>
														</tr>

														<tr>
															<td align="right">Do  you have pending Visa application ? </td>
															<td><div style="clear: both">{$pending_visa_application_Options}</div></td>
														</tr>

														<tr>
															<td align="right">Do  you have active Visa&rsquo;s for US, Australia, UK, Dubai ? </td>
															<td><div style="clear:both;">{$active_visa_Options}</div></td>
														</tr>

													</table>
												</div>

												<h2>Login Details</h2>
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyForm">
														<tr>
															<td width="200" align="right"> Primary Email: </td>
															<td width="300"> {$email} </td>
														</tr>
														<tr>
															<td width="200" align="right"> Password: </td>
															<td width="300"> {$password} <a href="/portal/forgotpass.php?user=applicant">Change Password</a></td>
														</tr>

													</table>
												</div>
												
												

												<h2>Contact Info</h2>
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
														<tr>
															<td width="200" align="right" valign="top">E-mail:</td>
															<td width="300">
															<input name="email" type="text" id="email" value="{$email}" size="35" onblur="" {$disableEmail}/>
															</td>
														</tr>
														<tr>
															<td width="200" align="right" valign="top">Alternative E-mail:</td>
															<td width="300">
															<input name="alt_email" type="text" id="alt_email" value="{$alt_email}" size="35" onblur="CheckAltEmail()"/>
															<br />
															<span class="smalltext" >will be used if primary email is not reachable</span></td>
														</tr>
														<tr>
															<td align="right" valign="top">Mobile Number:</td>
															<td>
															<input name="handphone_country_code" type="text" id="handphone_country_code" size="7" value="{$handphone_country_code}" />
															-
															<input name="handphone_no" type="text" id="handphone_no" value="{$handphone_no}" size="25" />
															<br />
															<span class="smalltext">area code - number</span></td>
														</tr>
														<tr>
															<td align="right" valign="top">Landline Number:</td>
															<td>
															<input name="tel_area_code" type="text" id="tel_area_code" value="{$tel_area_code}" size="7" />
															-
															<input name="tel_no" type="text" id="tel_no" value="{$tel_no}" size="25" />
															<br />
															<span class="smalltext">area code - number</span></td>
														</tr>
														<tr>
															<td align="right" valign="top">Address: </td>
															<td>															<textarea name="address1" cols="25" rows="5" id="address1">{$address1}</textarea></td>
														</tr>
														<tr>
															<td colspan="2" align="center" style="border:0;">
															<table width="480" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td width="100">Postal Code:</td>
																	<td width="120">
																	<input name="postcode" type="text" id="postcode" value="{$postcode}" size="15" />
																	</td>
																	<td width="10">&nbsp;</td>
																	<td width="50">Country:</td>
																	<td width="170">
																	<select name="country_id" id="country_id" style="width:150px;">
																		{$countryOptions2}
																	</select></td>
																</tr>
																<tr>
																	<td>State/ Region:</td>
																	<td>
																	<div id="state_field">
																		<input name="state" type="text" id="state" value="{$state}" size="45" />
																	</div></td>
																	<td>&nbsp;</td>
																	<td>City</td>
																	<td>
																	<input name="city" type="text" id="city" value="{$city}" size="15" />
																	</td>
																</tr>
															</table></td>
														</tr>
													</table>
												</div>
												
												
												

												<h2>Online Contact Info (optional)</h2>
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
														<tr>
															<td width="200" align="right">MSN Messenger ID:</td>
															<td width="300">
															<input name="msn_id" type="text" id="msn_id" value="{$msn_id}" size="35" />
															</td>
														</tr>
														<tr>
															<td align="right">YAHOO MessengerID:</td>
															<td>
															<input name="yahoo_id" type="text" id="yahoo_id" value="{$yahoo_id}" size="35" />
															</td>
														</tr>
														<tr>
															<td align="right">Facebook / Twitter Account:</td>
															<td>
															<input name="icq_id" type="text" id="icq_id" value="{$icq_id}" size="35" />
															</td>
														</tr>
														<tr>
															<td align="right">Linked In Account:</td>
															<td>
															<input name="linked_in" type="text" id="linked_in" value="{$linked_in}" size="35" />
															</td>
														</tr>
														
														<tr>
															<td align="right">SKYPE ID</td>
															<td>
															<input name="skype_id" type="text" id="skype_id" value="{$skype_id}" size="35" />
															</td>
														</tr>

													</table>
												</div>

												<h2>Others</h2>
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
														<tr>
															<td width="200" align="right">How did you hear about us?</td>
															<td width="300">
															<input type="radio" name="others" id="others" value="external" {if $referred_by == ''}checked{/if} >
															External Source
															<select name="external_source" id="external_source" onchange="displayOthers()" >
																{$referredByOptions}
															</select>
															<br/>
															<span id="others_container" style="display:{$display_others};">
																<br/>
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																Please specify
																<input name="external_source_others" type="text" id="external_source_others" value="{$external_source_others}" size="24" />
															</span>
															<br/>
															<input type="radio" name="others" id="others" value="referral" {if $external_source == ''}checked{/if}>
															Referred by
															<input name="referred_by" type="text" id="referred_by" value="{$referred_by}" size="27" />
															</td>
														</tr>
														<tr>
															<td width="200" align="right">Have you spoken to any of our recruiters before ?</td>
															<td width="300">
															<select name="have_you_spoken">
																{$recruiterYesNo}
															</select></td>

														</tr>
														<tr>
															<td width="200" align="right">If yes,</td>
															<td width="300">
															<select name="recruiter">
																<option value="">Please select</option>
																{$recruiterOption}
															</select></td>
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
										</div></td>
									</tr>
								</table></td>
							</tr>
						</table></td>
					</tr>
				</table></td>
		</table>

	</body>
</html>
