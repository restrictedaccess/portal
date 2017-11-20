<!DOCTYPE HTML>
<html>
	<head>
		<title>Refer a Friend &copy;ThinkInnovations.com</title>
		<link rel=stylesheet type=text/css href="/portal/css/font.css">
		<link rel=stylesheet type=text/css href="../css/resume.css">	
		<link rel=stylesheet type=text/css href="../menu.css">
		<link rel=stylesheet type=text/css href="../application_form/css/style.css">
		<link rel=stylesheet type=text/css href="../application_form/css/register-8.css">
		<link rel=stylesheet type=text/css href="css/style.css">
		<link rel=stylesheet type=text/css href="css/referrals.css">
		
		
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script language=javascript src="../js/validation.js"></script>
		<script language=javascript src="../js/jquery.js"></script>
		<script language=javascript src="/portal/personal/js/updatepersonal.js"></script>
		<script type="text/javascript" src="/portal/personal/js/referral.js"></script>
		
		{if $success == "true"}
		<script type="text/javascript">
			alert("You have successfully referred a friend/friends to Remotestaff. Thank you.");
			//location.href = "/portal/myresume.php"
		</script>
		{/if}
	</head>
	<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
			<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
				<tr>
					<td width="546" style="width: 220px; height: 60px;">
						<img src="../images/remotestafflogo.jpg" alt="think" width="416" height="108">
					</td>
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
						</table>
					</td>
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
										<td colspan=2 style='height: 1px;'>
											
										</td>
									</tr>
									<tr>
										<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
										{php} include 'applicantleftnav.php'{/php}
										</td>
										<td width=566 valign=top align=right>
										<img src='/portal/images/space.gif' width='1' height='10'><br clear=all>
										<table width=566 cellpadding=10 cellspacing=0 border=0>
											<tr>
												<td>
													<div id="applynow" class="refer-a-friend">
														<form method="POST" id="refer-a-friend">
														<h2>Refer a Friend</h2>
														<input name="userid" id="refer-a-friend-userid" value="{$userid}" type="hidden"/>
														<p>Do you know any one who might be interested to apply? We offer 500 Pesos incentive for back office admin referrals and 1000 Pesos incentive to IT Professional Referrals. (Optional)</p>
														<p style="font-size:0.95em"><strong><small>Referral fee will be paid out once your referred candidate works with us for a month minimum.</small></strong></p>
															<table id="refer-a-friend-table">
																<tr>
																	<th>
																		First Name
																	</th>
																	<th>
																		Last Name
																	</th>
																	<th>
																		Current Position
																	</th>
																	<th>
																		Email Address
																	</th>
																	<th>
																		Contact Number
																	</th>
																</tr>
																
																<tr>
																	<td><input type="text" name="firstname[]" class="first-name" value="{$firstname0}"/></td>
																	<td><input type="text" name="lastname[]" class="lastname"  value="{$lastname0}"/></td>
																	<td><input type="text" name="currentposition[]" class="currentposition"  value="{$currentposition0}"/></td>
																	<td><input type="text" name="emailaddress[]" class="emailaddress" value="{$emailaddress0}"/></td>
																	<td><input type="text" name="contactnumber[]" class="contactnumber" value="{$contactnumber0}"/></td>
																</tr>
																
																<tr>
																	<td><input type="text" name="firstname[]" class="first-name" value="{$firstname1}"/></td>
																	<td><input type="text" name="lastname[]" class="lastname"  value="{$lastname1}"/></td>
																	<td><input type="text" name="currentposition[]" class="currentposition"  value="{$currentposition1}"/></td>
																	<td><input type="text" name="emailaddress[]" class="emailaddress" value="{$emailaddress1}"/></td>
																	<td><input type="text" name="contactnumber[]" class="contactnumber" value="{$contactnumber1}"/></td>
																</tr>
																<tr>
																	<td><input type="text" name="firstname[]" class="first-name" value="{$firstname2}"/></td>
																	<td><input type="text" name="lastname[]" class="lastname"  value="{$lastname2}"/></td>
																	<td><input type="text" name="currentposition[]" class="currentposition"  value="{$currentposition2}"/></td>
																	<td><input type="text" name="emailaddress[]" class="emailaddress" value="{$emailaddress2}"/></td>
																	<td><input type="text" name="contactnumber[]" class="contactnumber" value="{$contactnumber2}"/></td>
																</tr>
																
															</table>
															<div style="text-align: center">
																<button class="finish-button add-referral"><img src="/portal/application_form/images/check.png"/>Refer Now</button>
															</div>

														</form>
													</div>
													
													
											</td>
										 </tr>
										 
										 <tr>
										 	<td>
										 		
										 		<div id="applynow" class="referral-list">
										 			<h2>
											 			My Referrals
											 		</h2>
										 			<table width="100%" cellpadding="2" cellspacing="0">
										 				<tr>
										 					<th>First Name</th>
										 					<th>Last Name</th>
										 					<th>Current Position</th>
										 					<th>Email</th>
										 					<th>Contact Number</th>
										 					<th>Application Status</th>										 					
										 					<th>Action</th>
										 				</tr>
										 				{$referralOutput}
										 			</table>
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
	</tr>
	</table>
			
			
	</body>
</html>
