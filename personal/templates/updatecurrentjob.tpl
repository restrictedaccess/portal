<html>
	<head>
		<title>MyProfile &copy;ThinkInnovations.com</title>
		<link rel=stylesheet type=text/css href="/portal/css/font.css">
		<link rel=stylesheet type=text/css href="../css/resume.css">
		<link rel=stylesheet type=text/css href="../menu.css">
		<link rel=stylesheet type=text/css href="css/application_form.css">
		<link rel=stylesheet type=text/css href="css/style.css">
		<link rel=stylesheet type=text/css href="css/updatecurrentjob.css">
		

		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script language=javascript src="../js/validation.js"></script>
		<script language=javascript src="../js/jquery.js"></script>
		<script language=javascript src="/portal/personal/js/updatecurrentjob.js"></script>

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
											<form name="form" method="post" id="currentjob_form">
											<h2>Current Status</h2>
												<div id="fieldcontents">
												<table border="0" cellspacing="0" cellpadding="0" id="applyform">
												<tr>
												<td width="50" align="right"><input type="radio" name="current_status" value="still studying" {$still_studying_selected}/></td>
												<td width="450">I am still pursuing my studies and seeking internship or part-time jobs</td>
												</tr>
												<tr>
												<td width="50" align="right"><input type="radio" name="current_status" value="fresh graduate" {$fresh_graduate_selected}/></td>
												<td width="450">I am a fresh graduate seeking my first job</td>
												</tr>
												<tr>
												  <td width="50" align="right"><input type="radio" name="current_status" value="experienced" {$experienced_selected}/></td>
												  <td width="450">I have been working for
												 <select name="years_worked" id="years_worked" style="width:40px;" class="text">
													{$years_worked_options}
												 </select>
												&nbsp;year(s)
												 <select name="months_worked" id="months_worked" style="width:40px;" class="text">
													{$months_worked_options}
												 </select>
												 &nbsp;month(s)</td>
												</tr>
												</table>
												</div>
												
												<h2>Availability Status</h2>
												<div id="fieldcontents">
												<table border="0" cellspacing="0" cellpadding="0" id="applyform">
												<tr>
												<td width="50" align="right"> <input type="radio" name="available_status" value="a" id="available_status_a" {$available_a}/></td>
												<td width="450">
													<label for="available_status_a">I can start work after </label>
												    { strip }
												    <select name="available_notice">
												    	<option value=""></option>
												        { section name=available_notice loop=12 }
												        	
													        <option value="{ $smarty.section.available_notice.index }"  
													        {if $available_notice==$smarty.section.available_notice.index}
													    				selected
													    			{/if}>
													        { $smarty.section.available_notice.index }
													        </option>
												        { /section }
												    </select>
												    { /strip } week(s) of notice period</td>
												</tr>
												<tr>
												<td width="50" align="right"><input type="radio" name="available_status" value="b" id="available_status_b" {$available_b}/></td>
												<td width="450">
													<label for="available_status_b">
												                I can start work after 
												    </label>
												    <select name="aday">
												    	<option value=""></option>
												    		{ section name=aday loop=31 }
													    		<option value="{ $smarty.section.aday.iteration }"
													    			{if $aday==$smarty.section.aday.iteration}
													    				selected
													    			{/if}
													    		>
													                        { $smarty.section.aday.iteration }
													            </option>
												            { /section }
												    </select>&nbsp;-&nbsp; 
												    <select name="amonth">
												                <option value=""></option>
												                {$month_full_options}
												    </select>&nbsp;-&nbsp;<input type=text name="ayear" size=4 maxlength=4 style='width=50px' value='{ $ayear }'/>(YYYY)
												</td>
												</tr>
												<tr>
												  <td width="50" align="right"><input type="radio" name="available_status" value="p" id="available_status_p" {$available_p}/></td>
												  <td width="450"><label for="available_status_p">I am not actively looking for a job now</label></td>
												</tr>
												<tr>
													<td width="50" align="right"><input type="radio" name="available_status" value="Work Immediately" id="available_status_work_immediate"  {$available_w}/></td>
													<td width="450"><label for="available_status_work_immediate">Work Immediately</label></td>
												</tr>
												</table>
												</div>
												<h2>Expected Salary</h2>
												<div id="fieldcontents">
												<table style="width:600px;" border="0" cellspacing="0" cellpadding="0" id="applyform">
												<tr>
												<td width="150" align="right">Expected Monthly Salary:</td>
												<td width="450">&nbsp;&nbsp;
												  <input type="checkbox" value="Yes" name="expected_salary_neg" {$is_negotiable} />
												  Negotiable 
												  <input type="text" class="text" name="expected_salary"  id="expected_salary" maxlength="15" size="16" value="{$expected_salary}" />
												  <select name="salary_currency" id="salary_currency" style="font:8pt, Verdana" >  
													{$salary_currency_options}
												</select>&nbsp;&nbsp;</td>
												</tr>
												</table>
												</div>
												
												
												<h2>Current/latest Job Title</h2>
												<div id="fieldcontents">
												<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
												<tr>
												<td width="200" align="right">Position:</td>
												<td width="300"><input name="latest_job_title" type="text" id="latest_job_title" size="35" value="{$latest_job_title}"/></td>
												</tr>
												</table>
												</div>
												
												<h2><strong>Work History</strong></h2>
												<div id="fieldcontents">
													<div id="resultarea" >
														Note: Please start with your current or most recent company<br><br>
														{$history_HTML}	
														<br />
													</div>
													<p align="center">
														<strong>
															<span class="add-new-work">Click Here to add more work history</span>
														</strong>
													</p> 
												</div>
												
												<h2>Position Desired</h2>
												<div id="fieldcontents">
																<table width="500" border="0" cellspacing="0"
																	cellpadding="0" id="applyform">
																	<tr>
																		<td width="200" align="right" valign="top">First
																			Choice:</td>
																		<td width="300"><select name="position_first_choice"
																			id="position_first_choice">
																				{$position_first_choice_options}
																		</select> <br /> <span class="smalltext">any
																				experience doing this role?
																				{$position_first_choice_exp_options} </span> <br />
																		</td>
																	</tr>
																	<tr>
																		<td align="right" valign="top">Second Choice:</td>
																		<td><select name="position_second_choice"
																			id="position_second_choice">
																				{$position_second_choice_options}
																		</select> <br /> <span class="smalltext">any
																				experience doing this role?
																				{$position_second_choice_exp_options} </span> <br />

																		</td>
																	</tr>
																	<tr>
																		<td align="right" valign="top">Third Choice:</td>
																		<td><select name="position_third_choice"
																			id="position_third_choice">
																				{$position_third_choice_options}
																		</select> <br /> <span class="smalltext">any
																				experience doing this role?
																				{$position_third_choice_exp_options} </span> <br />
																		</td>
																	</tr>
																	<tr>
																		<td align="right">Others:</td>
																		<td><input name="others" type="text" id="others"
																			size="35" value="{$other_choice}" /></td>
																	</tr>
																</table>
															</div>
												<h2>Character References</h2>
												
												<div id="container">
													{foreach from=$character_references item=character_reference}
														{include file=character-reference.tpl}
														
													{/foreach}
													{include file=empty-character-reference.tpl}
														
												</div>
												
												
												<div id="fieldcontents">
													<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
														<tr>
															<td width="200">&nbsp;</td>
															<td width="300">
																<button id="add-character-button">
																	Add
																</button>
															</td>
														</tr>
													</table>
												</div>
													
													
												
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

	<script type="text/javascript" src="../media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
	{ literal }
	<script type="text/javascript">
	tinyMCE.init({
	    mode : "textareas",
	
	    theme : "simple",
	});
	
	</script>
	{ /literal }
	</body>
</html>
