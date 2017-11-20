<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{*
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
*}
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Staff Information</title>




<!--calendar picker - setup--> 
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->
<script type="text/javascript" src="../../js/MochiKit.js"></script>
<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/portal/jobseeker/js/summernote/summernote.min.js"></script>
<script type="text/javascript" src="/portal/media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="js/staff_information.js"></script>
<script type="text/javascript" src="../leads_information/media/js/tabber.js"></script>


<link rel="stylesheet" href="/portal/jobseeker/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/portal/jobseeker/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/portal/jobseeker/js/summernote/summernote.css"/>
<link rel="stylesheet" href="/portal/jobseeker/js/summernote/summernote-bs2.css"/>
<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="css/staff_information.css">


</head>

<body style="margin-top:0; margin-left:0">
{if $TEST}
    <form method="POST" id="submit-form" name="form" action="/portal/recruiter/staff_information.php?userid={ $userid }" data-host="{$server_host}" data-admin_id="{$logged_admin_id}" data-userid="{$userid}" enctype="multipart/form-data"  onsubmit="return checkFields(); ">
{else}
    <form method="POST" id="submit-form" name="form" action="/portal/recruiter/staff_information.php?userid={ $userid }" data-host="{$server_host}" data-admin_id="{$logged_admin_id}" data-userid="{$userid}" enctype="multipart/form-data"  onsubmit="return checkFields(); ">
{/if}
<input type="hidden" name="userid" value="{ $userid }">
<input type="hidden" name="id" id="leads_id" value="{ $userid }">
<input type="hidden" name="agent_no" value="{ $agent_no }">
<input type="hidden" name="fill" value="">
<input type="hidden" name="mode" value="{ $mode }">
<input type="hidden" name="hid" value="{ $hid }">
<input type="hidden" name="fullname" value="{ $fname } { $lname }">
<input type="hidden" name="email" value="{if $email eq ''}{$registered_email}{else}{$email}{/if}">
<input type="hidden" name="alt_email" value="{$alt_email}"/>
<!--
<input type="hidden" name="staff_email" value="{$email}"/>
-->
{foreach from=$staff_email item=staff_email_item}
	<input type="hidden" name="staff_email[]" value="{$staff_email_item}" class="staff_email_item"/>
{/foreach}

<input type="hidden" name="job_order" id="job_order" >
<input type="hidden" name="csros" value="{$csros}"/>

{if $page_type neq "popup"}
{php} include("header.php") {/php}
{php} include("recruiter_top_menu.php") {/php}
{/if}

<table width="100%" cellpadding="0" cellspacing="0" border="0"  >
	<tr>
		<td valign="top" style="border-right: #006699 2px solid;">
			<div id='applicationsleftnav'>
                <table>
                    <tr>
                        <td background="images/open_left_menu_bg.gif"><a href="javascript: applicationsleftnav_show(); "><img src="images/open_left_menu.gif" border="0" /></a></td>
                    </tr>
                </table>
			</div>
		</td>
		<td valign="top" align="center" width="100%">


		<!--START: sub title-->
		<h1 align="left">&nbsp;{ $staff_name } <span class="leads_id">#{ $userid }</span>
			{if $hasActive eq 'ACTIVE'}, <span style="color:#ff0000">ACTIVE, {$work_status}, {$staff_admin_fullname}</span>
			{elseif $hasActive eq 'INACTIVE'}, <span style="color:#ff0000">INACTIVE</span>
			{/if}</h1>
		<input id="staff-name" type="hidden" value="{$staff_name}"/>
		<!--ENDED: sub title-->

		
			<table width=98% cellpadding=3 cellspacing="3" border=0>
            
                <!--START: tabber-->
                <tr>
                    <td width=100% colspan=2>
                        <div class="subtab">
                            <ul>
                                <li id="cp" class="selected"><a href="staff_information.php?userid={ $userid }"><span>Candidate's Profile Manager</span></a></li>
                                <li id="csro"><a href="staff_csro_report.php?userid={ $userid }"><span>CSRO Report</span></a></li>
								<li id="cm"><a href="staff_case_report.php?userid={ $userid }"><span>Case Management</span></a></li>
                            </ul>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td width=100% colspan=2>
                        <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                            <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                <!--<input type="button" class="button" value="ASL Staff Checker" onClick="javascript: asl_checker('tools/AvailableStaffChecker/AvailableStaffChecker.html'); "/>-->
                                <input type="button" class="button" value="Admin Resume Checker" onClick="window.open('../AdminResumeChecker/ResumeChecker.html?userid={ $userid }','_blank','width=800,height=500,scrollbars=yes') "/>
                                <input type="button" class="button" value="Bank Accounts" onClick="javascript: bank_accounts({ $userid }); "/>
                                <input type="button" class="button" value="Lead's view of this Resume" onClick="window.open('/available-staff-resume/{ $userid }','Resume','width=800,height=500,scrollbars=yes')"/>
                                
                            </div>
                        </div>		
                    </td>
                </tr>
                <!--ENDED: tabber-->


                <!--START: transaction result or return error result-->
                <tr>
                    <td colspan="2">
                        <div id="trans_result">{ $transaction_result }</div>
                    </td>
                </tr>
                <!--ENDED: transaction result or return error result-->


                <!--START: calendar appointments report-->
                <tr>
                    <td width=100% colspan=2>
                    <h2>Meeting Candidate</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan=2 >
                        <table width=100% cellspacing=1 cellpadding=3 align=left border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
                            <tr>
                                <td valign="middle" onClick="javascript: window.location='../meeting_calendar/?userid={$userid}'; " colspan=3 onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; ">
                                    <a href="javascript: window.location='../meeting_calendar/?userid={$userid}'; "><img src="../images/001_44.png" alt="Calendar" align="texttop" border="0"></a><strong>&nbsp;&nbsp;Manage Meetings</strong>
                                </td>
                            </tr>
                        </table>			
                    </td>
                </tr>
                <tr>
                    <td colspan=3 >
                        <table width="100%">
                            <tr>
                                <td width="50%" valign="top" colspan="2">
                                    <table width="100%">							
                                        <tr>
                                            <td colspan=3 valign="top" >
                                                <iframe id="frame" name="frame" width="100%" height="130" src="../application_calendar/today_and_otherdays_schedule.php" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
                                            </td>	
                                        </tr>
                                    </table>		
                                </td>
                            </tr>	
                        </table>
                    </td>
                </tr>
                <!--ENDED: calendar appointments report-->


                <!--START: staff audio file / other files-->
                <tr>
                    <td width=100% colspan=3>
                        <h2>Voice / Files</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan=2>
                        <table width=100% cellpadding="5" cellspacing="5" align=center border=0 bgcolor=#ffffff>
							<tr>
								<td colspan="2" align="center"><div id="staff_file_permission_update_loader_div"></div><div id="staff_files_reporting_div"></div></td>
							</tr>                        
                            <tr>
                                <td width="50%" valign="top">
                                    <table cellspacing=1 cellpadding=3 width=100%>
                                        <tr>
                                            <td class="td_info td_la">Voice</td>
                                        </tr>		
                                        <tr>
                                            <td>
                                                <FONT size="1">
                                                Voice recording should be: <BR />
                                                <em>
                                                Size: Equal or less than 5000kb in size<BR />
                                                Format: WAV, Mpeg, WMA, MP3 <BR />
                                                Length: Should be equal or less than 3 minutes<BR />
                                                Content: Quick voice resume. Introduction and summary of experience<BR />
                                                </em></FONT>
                                                <input type="file" name="sound_file" id="sound_file">
                                                <input type="submit" name="sound_btn" id="sound_btn" value="upload">			
                                            </td>
                                        </tr>
                                    </table>    
                                    <br />
                                    {if $staff_voice_file neq ''}
                                    <table cellspacing=1 cellpadding=3 width=100% >
                                        <tr>
                                            <td valign="middle"><a href="javascript: delete_file_confirmation('userid={ $userid}&action=DEL-VOICE-FILE','VOICE FILE'); "><img src="../images/delete.png" border="0" /></a></td><td width="100%" valign="top">{ $staff_voice_file }</td>
                                        </tr>
                                    </table>
                                    {/if}
                                </td>
                                <td style="border-left: #333333 1px solid;" valign="top" width="50%">
                                    <table cellspacing=1 cellpadding=3 width=100%>
                                        <tr>
                                            <td class="td_info td_la"><b>File Type/Size</b><font size="1"> (doc, pdf or image format) Upload limit per file is 5 MB</font></td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<table cellpadding="3" cellspacing="3">
                                                	<tr>
                                                    	<td>
                                                            <select name="file_description">
                                                                <option value="RESUME" selected>Resume</option>
                                                                <option value="SAMPLE WORK">Sample Work</option>
                                                                <option value="MOCK CALLS">Mock Calls</option>
                                                                <option value="HOME OFFICE PHOTO">Home Office Photo</option>
                                                                <option value="OTHER">Other</option>
                                                                <OPTGROUP LABEL="Staff Files">
                                                                    <option value="SIGNED CONTRACT">Signed contract</option>
                                                                    <option value="SOFT CONTRACT COPY">Soft Contract Copy</option>
                                                                    <option value="ID">I.D.</option>
                                                                    <option value="BANK FORM">BANK FORM</option>
                                                                    <option value="CEDULA">Cedula</option>
                                                                    <option value="INTERNET BILL">Internet Bill</option>
                                                                    <option value="OTHER STAFF FILES">Other</option>
                                                                </OPTGROUP>
                                                            </select>
														</td>
                                                        <td>
                                                            Resume,Sample Work, Mock Calls & Other: <a href="javascript: staff_files_counter({ $userid },'other'); "><font color="#FF0000"><strong>{ $staff_files_counter }</strong></font></a>	<br />
                                                            Staff Files: <a href="javascript: staff_files_counter({ $userid },'staff files'); "><font color="#FF0000"><strong>{ $csro_staff_files_counter }</strong></font></a>
                                                        </td>
													</tr>
												</table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td_info td_la">File</td>
                                        </tr>			
                                        <tr>
                                            <td><input type="file" name="fileimg" value="" size="35" />	</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<input type="submit" value="Upload File" name="upload_file">
                                                <input type="button" value="Send Sample(s) to Email" onClick="javascript: send_sample({ $userid }); "/>
                                                Samples Sent to Lead: <a href="javascript: staff_samples_counter({ $userid }); "><font color="#FF0000"><strong>{ $staff_samples_counter }</strong></font></a>
											</td>
                                        </tr>			
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>        
                <!--ENDED: staff audio file / other files-->


                <!--START: profile-->
                <tr>
                    <td width=100% colspan=2><h2>Profile</h2></td>
                </tr>
                <tr>
                    <td colspan=2 >
                        <table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#ffffff solid 1px;">
                            <tr>
                                <td valign="top" colspan="3">
                                    <table width="100%" cellpadding="5" cellspacing="5">
                                        <tr>
                                            <td colspan="2"><div id="reporting_div"></div></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <table width="100%">
                                                    <tr>
                                                        <td width="20%" valign="top" align="center">{ $staff_photo }</td>
                                                        <td width="80%" class="subtitle" valign="top">
                                                            <table width="100%" style="position:relative">
                                                                    <tr>
                                                                        <td class="td_info td_la">Candidate ID</td>
                                                                        <td class="td_info" style="position:relative">
                                                                        	{if $hasMatch}
                                                                        	<div><font color="#FF0000">{ $userid } </font></div>
                                                                        	<div style="overflow:hidden;min-width:200px;max-width:250px;padding:5px;position:absolute;top:0;right:0;border:1px dashed #333;background-color:#FFFFCC">
                                                                        		<div style="float:left;margin-right:5px;"><strong>Identical To:</strong></div>
                                                                        		<div class="drawer" style="clear:both">
	                                                                        		<ul style="float:left;padding-left:0;margin:0;list-style-type:none">
	                                                                        		{foreach from=$matches item=match}
	                                                                        			<li><a href="/portal/recruiter/staff_information.php?userid={$match.userid}&page_type=popup" target='_blank'>{$match.candidate_fullname}</a></li>
	                                                                        		{/foreach}                                                                      
	                                                                        		</ul>  			
                                                                        		</div>
                                                                        		<p align="center" style="border-top:1px dashed #333;padding-bottom:0;margin:0;margin-top:5px;clear:both"> 
																					<a href="#" class="minimize">[Minimize]</a>
                                                                        			
                                                                        		</p>
                                                                        	{else}
                                                                        	<font color="#FF0000">{ $userid }</font>
                                                                        	{/if}
                                                                        </td></tr>
                                                                    <tr>
                                                                        <td width="27%" valign="top" class="td_info td_la">Date Registered</td>
                                                                        <td width="71%" valign="top" class="td_info">{ $dateapplied }</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="27%" valign="top" class="td_info td_la">Last Update</td>
                                                                        <td width="71%" valign="top" class="td_info">{ $dateupdated }</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="27%" valign="top" class="td_info td_la">Last Login</td>
                                                                        <td width="71%" valign="top" class="td_info">{ $last_login }</td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td valign="top" class="td_info td_la">Fullname</td>
                                                                        <td valign="top" class="td_info">{ $staff_name }</td>
																	</tr>
																	<tr>
                                                                        <td valign="top" class="td_info td_la">Nickname</td>
                                                                        <td valign="top" class="td_info">{ $nick_name }</td>
																	</tr>
                                                                    <tr>
                                                                        <td valign="top" class="td_info td_la">Latest Job Title</td>
                                                                        <td valign="top" class="td_info">{ $latest_job_title }</td></tr>		
                                                                    <tr>
                                                                        <td valign="top" class="td_info td_la">Availability</td>
                                                                        <td valign="top" class="td_info">{ $availability }</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top" class="td_info td_la">Preferred Interview Schedule</td>
                                                                        <td valign="top" class="td_info">{ $interview_schedule }</td>
                                                                    </tr>
                                                                    
                                                                    <!-- 
                                                                    <tr>
                                                                        <td valign="top" class="td_info td_la">Promotional Code</td>
                                                                        <td valign="top" class="td_info"><span style="color:#FF0000">{ $promotional_code }</span></td>
                                                                    </tr> 
                                                                   	-->
                                                                    <tr>
                                                                        <td valign="top" class="td_info td_la">Change Picture</td>
                                                                        <td valign="top" class="td_info"><input type="file" name="img" id="img"><input type="submit" name="picture" id="upload" value="Upload"></td>
                                                                    </tr>
                                                            </table>		
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" bgcolor="#FFFFFF"></td>
                                                    </tr>
                                                </table> 
                                            </td>
                                            <td style="border-left: #333333 1px solid;" valign="top">
                                                <table width="100%">
                                                    <tr>
                                                        <td></td>
                                                        <td>{ $experienced } { $hot }</td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">Recruiter</td>
                                                        <td valign="top" class="td_info">
                                                            <select name="staff_recruiter_stamp" id="staff_recruiter_stamp" onChange="javascript: staff_recruiter_stamp_update({ $userid }, this.value);" >
                                                                { $staff_recruiter_stamp }
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">Status</td>
                                                        <td valign="top" class="td_info">
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td><div id="app_status_loader"><a href="javascript: staff_information_status_report({ $userid }); "><font color="#FF0000"><strong>{ $applicant_status_report_counter }</strong></font></a></div></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr> 
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">No Show</td>
                                                        <td valign="top" class="td_info">
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td>
                                                                        <select name="staff_no_show_service_type" id="staff_no_show_service_type">
                                                                            <option value="" selected>Select Service Type</option>
                                                                            <option value="INITIAL">INITIAL</option>
                                                                            <option value="ASL">ASL</option>
                                                                            <option value="CUSTOM">CUSTOM</option>
                                                                            <option value="FIRST DAY">FIRST DAY</option>
                                                                            <option value="TRIAL">TRIAL</option>
                                                                        </select>
                                                                        <input type="button" value="+" onclick="javascript: staff_no_show_update({ $userid },{ $admin_id });" />
                                                                    </td>
                                                                    <td>
                                                                        <div id="no_show_status_loader"><a href="javascript: staff_no_show_report({ $userid }); "><font color="#FF0000"><strong>{ $applicant_no_show_counter }</strong></font></a></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr> 
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">Staff Resume Up To Date</td>
                                                        <td valign="top" class="td_info">
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td>
                                                                        <input type="button" value="+" onclick="javascript: staff_resume_up_to_date_update({ $userid },{ $admin_id });" />
                                                                    </td>
                                                                    <td>
                                                                        <div id="staff_resume_up_to_date_status_loader"><a href="javascript: staff_resume_up_to_date_report({ $userid }); "><font color="#FF0000"><strong>{ $staff_resume_up_to_date_counter }</strong></font></a></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>                                                                            
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">Interview Counter</td>
                                                        <td valign="top" class="td_info"><a href="javascript: asl_interview_counter({ $userid }); "><font color="#FF0000"><strong>{ $asl_interview_counter }</strong></font></a></td>
                                                    </tr>  
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">Full Time Rate</td>
                                                        <td valign="top" class="td_info">
                                                            <SELECT name="pull_time_rate" id="pull_time_rate_id">
                                                                { $pull_time_rate_dropdown }
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">Part Time Rate</td>
                                                        <td valign="top" class="td_info">
                                                            <SELECT name="part_time_rate" id="part_time_rate_id">
                                                                { $part_time_rate_dropdown }
                                                            </select>
                                                            <input type="button" onClick="javascript: update_staff_rate({ $userid });" value="Save Staff Rate Changes">
                                                        </td>
                                                    </tr>   
                                                    <tr>
                                                        <td valign="top" class="td_info td_la">Working Model</td> 
                                                        <td valign="top" class="td_info">
                                                            <select name="working_model" id="working_model">
																<option value="home_based" {if $working_model_value == 'home_based'} selected="selected" {/if}>Home Based</option>
																<option value="office_based" {if $working_model_value == 'office_based'} selected="selected" {/if}>Office Based</option>
																<option value="home_based_and_office_based" {if $working_model_value == 'home_based_and_office_based'} selected="selected" {/if}>Home Based and Office Based</option>
                                                            </select>
                                                            <input id="working_model_btn" name="working_model_btn" type="button" value="Save Working Model">
                                                        </td>
                                                    </tr>      
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" cellpadding="5" cellspacing="5">
                                    	<tr>
                                        	<td width="50%" valign="top">
												<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Personal Information</strong></font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','candidates/updatepersonal.php'); ">Edit</a></td></tr></table></div>
												<table width="100%">
												<tr>
														<td width="35%" valign="top" class="td_info td_la">Identification</td>
														<td width="60%" valign="top" class="td_info">{ $auth_no_type_id }  -  { $msia_new_ic_no }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Age</td>
														<td width="60%" valign="top" class="td_info"><font color="#FF0000">{ $yr_byear }</font></td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Date of Birth</td>
														<td width="60%" valign="top" class="td_info">{ $bmonth } { $bday } {$byear }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Gender</td>
														<td width="60%" valign="top" class="td_info">{ $gender }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Marital Status</td>
														<td width="60%" valign="top" class="td_info"><font color="#FF0000">{ $marital_status }</font></td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Number of Kids</td>
														<td width="60%" valign="top" class="td_info">{ $no_of_kids }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Pregnant</td>
														<td width="60%" valign="top" class="td_info">{ $pregnant }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Expected Delivery Date</td>
														<td width="60%" valign="top" class="td_info">{ $dmonth } { $dday } { $dyear }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Nationality</td>
														<td width="60%" valign="top" class="td_info">{ $nationality }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Permanent Residence</td>
														<td width="60%" valign="top" class="td_info">{ $residence }</td>
													</tr>  
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Pending Visa application</td>
														<td width="60%" valign="top" class="td_info">{ $pending_visa_application }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Has active visa for US, UK, Austrialia, Dubai </td>
														<td width="60%" valign="top" class="td_info">{ $active_visa }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">How do you hear Remote Staff?</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">External Source</td>
														<td width="60%" valign="top" class="td_info">{ $external_source }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Referred By</td>
														<td width="60%" valign="top" class="td_info">{ $referred_by }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">English Comm. Skill<br/><strong>(0-Poor 10-Excellent)</strong></td>
														<td width="60%" valign="top" class="td_info">{ $english_communication_skill }</td>
													</tr>
													
												</table>	
                                            </td>
											<td style="border-left: #333333 1px solid;" valign="top">
                                                <div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Contact Information</strong></font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','candidates/updatepersonal.php'); ">Edit</a></td></tr></table></div>
												<table width="100%">
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Address</td>
														<td width="60%" valign="top" class="td_info">{ $address }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Address 2</td>
														<td width="60%" valign="top" class="td_info">{ $address2 }</td>
													</tr>
													
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Telephone No.</td>
														<td width="60%" valign="top" class="td_info">{ $tel }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Mobile No.</td>
														<td width="60%" valign="top" class="td_info">{ $cell }
															{if $cell}
																[ <a href="/portal/recruiter/sms_sender.php?userid={$userid}" class="sms_launcher">Send Message</a> ] [ <a href="/portal/recruiter/sms_log.php?userid={$userid}" class="view_logs">View Logs</a> ] 
															{/if}	
														</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Personal Email</td>
														<td width="60%" valign="top" class="td_info">{ $email }</td>
													</tr> 
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Alternative Email</td>
														<td width="60%" valign="top" class="td_info">{ $alt_email }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Personal Skype</td>
														<td width="60%" valign="top" class="td_info">{ $skype_id }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Staff Email</td>
														<td width="60%" valign="top" class="td_info">
															<ol style="padding-left:10px">
															{foreach from=$staff_email item=staff_email_item}
																<li>{$staff_email_item}</li>
															{/foreach}
															</ol>
														</td>
													</tr>
													
													
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Staff Skype ID</td>
														<td width="60%" valign="top" class="td_info">
															<ol style="padding-left:10px">
															
															{foreach from=$staff_skype_ids item=work_skype}
																<li>{$work_skype}</li>
															{/foreach}
															</ol>
															
															
														</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">MSN Messenger ID</td>
														<td width="60%" valign="top" class="td_info">{ $msn_id }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">YAHOO MessengerID</td>
														<td width="60%" valign="top" class="td_info">{ $yahoo_id }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Facebook / Twitter Account</td>
														<td width="60%" valign="top" class="td_info">{ $icq_id }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">LinkedIn Account</td>
														<td width="60%" valign="top" class="td_info">{ $linked_in }</td>
													</tr>
													
												</table>                                            
                                            </td>
										</tr>
									</table>
                                    <table width="100%" cellpadding="5" cellspacing="5">
                                    	<tr>
                                        	<td width="50%" valign="top">
												<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Working at Home Capabilities</strong></font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','candidates/updateworkingathomecapabilities.php'); ">Edit</a></td></tr></table></div>
												<table width="100%">
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Working Environment</td>
														<td width="60%" valign="top" class="td_info">{$home_working_environment}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Worked from home before</td>
														<td width="60%" valign="top" class="td_info">{$work_from_home_before} for {$start_worked_from_home}</td>
													</tr>
													<!--<tr>
														<td width="27%" valign="top" class="td_info td_la">Started working from home</td>
														<td width="71%" valign="top" class="td_info">{$start_worked_from_home}</td>
													</tr>-->
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Has baby in the house </td>
														<td width="60%" valign="top" class="td_info">{$has_baby}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Main Caregiver</td>
														<td width="60%" valign="top" class="td_info">{$main_caregiver}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Reason to work from home</td>
														<td width="60%" valign="top" class="td_info">{$reason_to_wfh}</td>
													</tr>
													<tr>
														<td width="35" valign="top" class="td_info td_la">Timespan to work with Remotestaff</td>
														<td width="60%" valign="top" class="td_info">{$timespan}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Internet Connection</td>
														<td width="60%" valign="top" class="td_info">{$isp}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Internet Plan and Package</td>
														<td width="60%" valign="top" class="td_info">{$internet_connection}</td>
													</tr>
														<td width="35%" valign="top" class="td_info td_la">Speed Test Link</td>
														<td width="60%" valign="top" class="td_info">{$speed_test}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Internet Consequences</td>
														<td width="60%" valign="top" class="td_info">{$internet_consequences}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Computer Hardware/s</td>
														<td width="60%" valign="top" class="td_info">{$computer_hardware2}</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Noise level at home</td>
														<td width="60%" valign="top" class="td_info">{$noise_level}</td>
													</tr>
												</table>	
                                            </td>
											<td style="border-left: #333333 1px solid;" valign="top">
												<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Highest Qualification</strong></font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','../portal/candidates/updateeducation.php'); ">Edit</a></td></tr></table></div>
												<table width="100%">
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Level</td>
														<td width="60%" valign="top" class="td_info">{ $level }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Field of Study</td>
														<td width="60%" valign="top" class="td_info">{ $field }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Major</td>
														<td width="60%" valign="top" class="td_info">{ $major }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Institute / University</td>
														<td width="60%" valign="top" class="td_info">{ $school }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Located In</td>
														<td width="60%" valign="top" class="td_info">{ $loc }</td>
													</tr>
													<tr>
														<td width="35%" valign="top" class="td_info td_la">Graduation Date</td>
														<td width="60%" valign="top" class="td_info">{ $month} { $year }</td>
													</tr>
													<tr>
														<td class="td_info td_la">Trainings & Seminars Attended</td>
														<td class="td_info">{ $trainings }</td>
													</tr>
                                                    <tr>
                                                        <td class="td_info td_la">Licence & Certifications</td>
                                                        <td class="td_info">{ $licence_cert }</td>
                                                    </tr>
                                                </table>
												<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Tasks</strong></font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','../portal/candidates/tasks.php'); ">Edit</a></td></tr></table></div>
												
												{foreach from=$sub_categories item=subcategory_task}
												<table width="100%" cellpadding="5" cellspacing="5">
													<tr><td style='color:#003366;font-weight:bold;text-align:left;' colspan='4'>Tasks for : {$subcategory_task.sub_category_name}</td></tr>
													<tr>
														<td class="td_info td_la" width="70%">Task</td>
														<td class="td_info td_la" width="30%">Rate</td>
													</tr>
													{foreach from=$subcategory_task.tasks item=task}
														<tr>
															<td class="td_info" width="70%">{$task.task_desc}</td>
															<td class="td_info" width="30%">{$task.ratings} / 10</td>
															
														</tr>
													{/foreach}
												</table>
												{/foreach}
												
												<br/>
												<table width="100%" cellpadding="5" cellspacing="5">
													<tr><td style='color:#003366;font-weight:bold;text-align:left;' colspan='4'>Test Taken:</td></tr>
													<tr>
														<td class="td_info td_la"></td>
														<td class="td_info td_la">Test Name</td>
														<td class="td_info td_la">Date Taken</td>
														<td class="td_info td_la">Score</td>
														<td class="td_info td_la">Result</td>
														<td class="td_info td_la">Test Details</td>
													</tr>
													
													{if $test_taken|@count > 0}	
													{section name=idx loop=$test_taken}
													<tr>
													<td class="td_info"><input type="checkbox" name="test_taken[{$test_taken[idx].result_id}]" value="{$test_taken[idx].result_id}" class="test_taken_check" {if $test_taken[idx].result_selected}checked{/if} ></td>
													<td class="td_info">{$test_taken[idx].assessment_title}</td>
													<td class="td_info">{$test_taken[idx].test_date}</td>
													<td class="td_info">{$test_taken[idx].result_score}</td>
													<td class="td_info">{$test_taken[idx].result_pct}{if $test_taken[idx].assessment_typing == 1 } wpm{else}%{/if}</td>
													<td class="td_info"><a href='{$test_taken[idx].result_url}' target='_blank'>click here</a></td>
													</tr>
													{/section}
												   {/if}
													
												</table>
												
												<!--
												<br/>
												<table width="100%" cellpadding="1" cellspacing="2">
													<tr><td style='color:#003366;font-weight:bold;text-align:left;' colspan='4'>Typing Test:</td></tr>
													<tr>
														<td class="td_info td_la">Try</td>
														<td class="td_info td_la">Title</td>
														<td class="td_info td_la">Date/Time</td>
														<td class="td_info td_la">Gross Speed</td>
														<td class="td_info td_la">Errors</td>
														<td class="td_info td_la">Net Speed</td>
														<td class="td_info td_la">Accuracy</td>
													</tr>
													
													{if $typingtest|@count > 0}	
													{section name=idx loop=$typingtest}
													<tr>
													<td class="td_info">{$smarty.section.idx.index+1}</td>
													<td class="td_info">{$typingtest[idx].test_name}</td>
													<td class="td_info">{$typingtest[idx].date_taken}</td>
													<td class="td_info">{$typingtest[idx].gwpm} wpm</td>
													<td class="td_info">{$typingtest[idx].error} words</td>
													<td class="td_info">{$typingtest[idx].nwpm} wpm</td>
													<td class="td_info">{$typingtest[idx].accuracy}%</td>
													</tr>
													{/section}
												   {/if}
													
												</table>
												-->
                                            </td>
										</tr>
									</table>     
                                    <table width="100%" cellpadding="5" cellspacing="5">
                                    	<tr>
                                        	<td width="50%" valign="top">
												<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Languages </strong>Proficiency(0=Poor - 10=Excellent</font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','admin_updatelanguages.php'); ">Edit</a></td></tr></table></div>
                                                { $languages_listings }
                                            </td>
											<td style="border-left: #333333 1px solid;" valign="top">
												<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Skills</strong> Proficiency (1=Beginner - 2=Intermediate - 3=Advanced)</font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','candidates/updateskills.php'); ">Edit</a></td></tr></table></div>
                                                { $skill_listings }
                                            </td>
										</tr>
									</table> 
                                    <table width="100%" cellpadding="5" cellspacing="5">
                                    	<tr>
                                        	<td width="50%" valign="top" colspan="2">
												<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Employment History</strong></font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','candidates/updatecurrentjob.php'); ">Edit</a></td></tr></table></div>
												<p><strong style="color:#ff0000">Note:</strong> You can sort the entries by dragging in to desired placement.</p>
                                    	
												<div class="employment_history_list">
													{ if $company neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#1</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties }</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_1}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_1}</td>
														</tr>                   
														
														{if $industry_id_1 eq 10 and $campaign_1}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_1}</td>
															</tr> 
														{/if}
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_1} - {$ending_grade_1}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_1}</td>
														</tr>
														                   
														                                                                                                                                         
													</table>
	                                                { /if }
													{ if $company2 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#2</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company2 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position2 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period2 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties2 }</td>
														</tr>    
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_2}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_2}</td>
														</tr>                   
														           
														{if $industry_id_2 eq 10 and $campaign_2}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_2}</td>
															</tr> 
														{/if}  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_2} - {$ending_grade_2}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_2}</td>
														</tr>                   
														                                                                                                                                           
													</table>
	                                                { /if }	 
													{ if $company3 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#3</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company3 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position3 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period3 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties3 }</td>
														</tr> 
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_3}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_3}</td>
														</tr>                   
														{if $industry_id_3 eq 10 and $campaign_3}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_3}</td>
															</tr> 
														{/if}  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_3} - {$ending_grade_3}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_3}</td>
														</tr>                   
														                                                                                                                                                        
													</table>
	                                                { /if }       
													{ if $company4 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#4</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company4 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position4 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period4 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties4 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_4}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_4}</td>
														</tr>                   
														{if $industry_id_4 eq 10 and $campaign_4}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_4}</td>
															</tr> 
														{/if}  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_4} - {$ending_grade_4}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_4}</td>
														</tr>                   
														                                                                                                                                                       
													</table>
	                                                { /if }    
													{ if $company5 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#5</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company5 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position5 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period5 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties5 }</td>
														</tr>      
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_5}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_5}</td>
														</tr>                   
														{if $industry_id_5 eq 10 and $campaign_5}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_5}</td>
															</tr> 
														{/if}  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_5} - {$ending_grade_5}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_5}</td>
														</tr>                   
														                                                                                                                                                      
													</table>
	                                                { /if }  
													{ if $company6 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#6</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company6 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position6 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period6 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties6 }</td>
														</tr>  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_6}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_6}</td>
														</tr>                   
														{if $industry_id_6 eq 10 and $campaign_6}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_6}</td>
															</tr> 
														{/if}  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_6} - {$ending_grade_6}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_6}</td>
														</tr>                   
														                                                                                                                                                      
													</table>
	                                                { /if }      
													{ if $company7 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#7</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company7 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position7 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period7 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties7 }</td>
														</tr>           
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_7}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_7}</td>
														</tr>                   
														{if $industry_id_7 eq 10 and $campaign_7}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_7}</td>
															</tr> 
														{/if}                                                                                                                                              
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_7} - {$ending_grade_7}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_7}</td>
														</tr>                   
														
													</table>
	                                                { /if } 
													{ if $company8 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#8</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company8 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position8 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period8 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties8 }</td>
														</tr>  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_8}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_8}</td>
														</tr>                   
														{if $industry_id_8 eq 10 and $campaign_8}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_8}</td>
															</tr> 
														{/if}       
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_8} - {$ending_grade_8}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_8}</td>
														</tr>                   
														                                                                                                                                                    
													</table>
	                                                { /if }   
													{ if $company9 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#9</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company9 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position9 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period9 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties9 }</td>
														</tr>    
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_9}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_9}</td>
														</tr>                   
														{if $industry_id_9 eq 10 and $campaign_9}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_9}</td>
															</tr> 
														{/if}                     
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_9} - {$ending_grade_9}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_9}</td>
														</tr>                   
														                                                                                                                                   
													</table>
	                                                { /if } 
													{ if $company10 neq "" }
	                                                <table width="100%" class="employment_history">
														<tr>
	                                                    	<td class="td_info td_la">#10</td>
															<td class="td_info td_la" width="25%">Company Name</td>
															<td class="td_info" width="75%">{ $company10 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Position Title</td>
															<td class="td_info" width="75%">{ $position10 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Employment Period</td>
															<td class="td_info" width="75%">{ $period10 }</td>
														</tr>
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Responsibilies /Achievements</td>
															<td class="td_info" width="75%">{ $duties10 }</td>
														</tr>  
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Work Setup</td>
															<td class="td_info" width="75%">{$work_setup_type_10}</td>
														</tr>               
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Industry</td>
															<td class="td_info" width="75%">{$industry_10}</td>
														</tr>                   
														{if $industry_id_10 eq 10 and $campaign_10}
															<tr>
		                                                    	<td class="td_info td_la"></td>
																<td class="td_info td_la" width="25%">Campaign</td>
																<td class="td_info" width="75%">{$campaign_10}</td>
															</tr> 
														{/if} 
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Salary Grade</td>
															<td class="td_info" width="75%">{$starting_grade_10} - {$ending_grade_10}</td>
														</tr>                   
														<tr>
	                                                    	<td class="td_info td_la"></td>
															<td class="td_info td_la" width="25%">Benefits</td>
															<td class="td_info" width="75%">{$benefits_10}</td>
														</tr>                   
														                                                                                                                                                          
													</table>
	                                                { /if }   
												</div>
												
                                                <br /><br />
                                                <table width="100%">
													<tr>
														<td class="td_info td_la" width="25%">Current status</td>
														<td class="td_info" width="75%">{ $current_status }</td>
													</tr>
													<tr>
														<td class="td_info td_la" width="25%">Has been working for</td>
														<td class="td_info" width="75%">{ $years_worked }years { $months_worked }months</td>
													</tr><tr>
														<td class="td_info td_la" width="25%">Expected Salary</td>
														<td class="td_info" width="75%">{ $currency } { $salary } {$neg }</td>
													</tr>
                                                    { if $company neq "" }
                                                    { if $mess neq "" }
													<tr>
														<td class="td_info td_la" width="25%">Intership Status</td>
														<td class="td_info" width="75%">{ $mess }</td>
													</tr>
                                                    { /if }
                                                    { if $str neq "" }
													<tr>
														<td class="td_info td_la" width="25%">Availability Status</td>
														<td class="td_info" width="75%">{ $str }</td>
													</tr>  
                                                    { /if }
																										
                                                    { /if }  
                                                    { if $position_first_choice }
													<tr>
														<td class="td_info td_la" width="25%">Position first choice</td>
														<td class="td_info" width="75%">{ $position_first_choice } { $position_first_choice_exp }</td>
													</tr>  
                                                    { /if } 

													{ if $position_second_choice }
													<tr>
														<td class="td_info td_la" width="25%">Position second choice</td>
														<td class="td_info" width="75%">{ $position_second_choice } { $position_second_choice_exp }</td>
													</tr>  
                                                    { /if } 

													{ if $position_third_choice }
													<tr>
														<td class="td_info td_la" width="25%">Position third choice</td>
														<td class="td_info" width="75%">{ $position_third_choice } { $position_third_choice_exp }</td>
													</tr>  
                                                    { /if } 
                                                    
                                                    <tr>
														<td class="td_info td_la" width="25%">Character Reference</td>
														<td class="td_info" width="75%">
															<ol class="contact_references">
																{foreach from=$character_references item=character_reference}
																	<li style="margin-bottom:10px;">
																		<strong>Name: </strong>{$character_reference.name}<br/>
																		<strong>Contact Details: </strong><br/>{$character_reference.contact_details}<br/>
																		<strong>Contact Number: </strong>{$character_reference.contact_number}<br/>
																		<strong>Email Address: </strong>{$character_reference.email_address}
																	</li>
																{/foreach}
															</ol>
															
															
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
				<!--ENDED: profile-->
                

                <!--START: status actions-->
                <tr>
                    <td colspan="3">
                        <table width=100% border=0 cellspacing=1 cellpadding=2>
                            <tr>
                                <td align=center>
                                    <div id="inactive_staff_loader"></div>		
                                    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                        <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                               <!-- <input {$inactive_disabled} name="button" type="button" onClick="javascript: move({ $userid }, 'Become a Staff'); " value="Become a Staff"/> -->
                                                { if $agent_no neq "" }
                                                        <input {$inactive_disabled} type="button" value="ASL Categories" onClick="javascript: move({ $userid }, 'Category');window.opener.document.getElementById('reload').value=1;  "/>&nbsp;
                                                        <input {$inactive_disabled} type="button" value="Shortlist" onClick="javascript: move({ $userid }, 'Shortlist');window.opener.document.getElementById('reload').value=1; "/>&nbsp;
                                                        <!--<input type="button" value="Unprocessed" onClick="javascript: update_status({ $userid }, 'UNPROCESSED',''); "/>&nbsp;-->
                                                        {if $is_prescreened_disabled == "disabled"}
                                                        	<input {$is_prescreened_disabled} type="button" value="Pre-Screen" onClick="javascript: update_status({ $userid }, 'PRESCREENED','');window.opener.document.getElementById('reload').value=1; "/>&nbsp;
                                                        {else}
                                                        	<input {$inactive_disabled} type="button" value="Pre-Screen" onClick="javascript: update_status({ $userid }, 'PRESCREENED','');window.opener.document.getElementById('reload').value=1; "/>&nbsp;
                                                        {/if}
                                                        <input {$endorsement_disabled} type="button" value="Endorse to Client" onClick="javascript: move({ $userid }, 'Endorse to Client');window.opener.document.getElementById('reload').value=1; "/>&nbsp;
                                                        <input {$inactive_disabled} type="button" value="Inactive" onClick="javascript: inactive_staff_option_open();window.opener.document.getElementById('reload').value=1; "/>&nbsp;
                                                		
						                                {if $ninety_day_code}
						                                	<input type="button" value="Mark as Still Available" onClick="window.open('/portal/jobseeker/still_available.php?u={ $userid }&c={$ninety_day_code}','Resume','width=800,height=500,scrollbars=yes')"/>
						                            	{/if}
                                                
                                                { /if }
                                        </div>
                                    </div>        
                                </td> 
                            </tr>
                        </table>
                    </td>
                </tr>
                <!--ENDED: status actions-->


                <!--START: evaluation report-->
                <tr>
                    <td width=100% colspan=3>
                        <h2>Evaluation Report</h2>
                    </td>
                </tr>
                
				<!--start: RS employment history-->
				<tr>
                     <td  colspan="3" width=30% >
                         <table width=100% border=0 cellspacing=1 cellpadding=2>
                             <tr>
                                 <td valign="top" width="50%">
									<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>RS Employment History </strong></font></td><td align="right">&nbsp;</td></tr></table></div>
                                   	
   	                                	{ $rs_employment_history }	
                                   	
                                 </td>
                             </tr>
                         </table>
                     </td>
				</tr>
				<!--ended: RS employment history-->                  
                
				<!--start: relevant industry experience-->
				<tr>
                     <td  colspan="3" width=30% >
                         <table width=100% border=0 cellspacing=1 cellpadding=2>
                             <tr>
                                 <td valign="top" width="50%">
                                     <div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Relevant Industry Experience</strong></font></td><td align="right"><a href="javascript: admin_edit('{ $userid }','admin_relevant_industry_experience.php'); ">Edit</a></td></tr></table></div>                                
                                     <div id="relevant_industry_experience">{ $relevant_industry_experience }</div>
                                 </td>
                             </tr>
                         </table>
                     </td>
				</tr>
				<!--ended: relevant industry experience-->                
                    
                <tr>
                    <td colspan="3" bgcolor="#FFFFFF">
						<table width="100%">
							<tr>
								<td width="50%" valign="top" colspan="2">
                                	<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Other</strong></font></td><td align="right"></td></tr></table></div>
									<table width="100%">							
										<tr>
											<td colspan=3 valign="top" >
												<iframe id="frame" name="frame" width="100%" height="400" marginheight="0" marginwidth="0" src="staff_evaluate.php?userid={ $userid }" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
											</td>	
										</tr>
									</table>		
								</td>
							</tr>	
						</table>
                    </td>
                </tr>
                <!--NEDED: evaluation report-->

                
                <!--START: additional information-->
                <tr>
                    <td width=100% colspan=2>
                        <h2>Additional Information</h2>
                    </td>
                </tr>
                    
                    <!--start: ASL categories-->
                    <tr>
                        <td  colspan="3" width=30% >
                            <table width=100% border=0 cellspacing=1 cellpadding=2>
                                <tr>
                                    <td valign="top" width="50%">
                                        <div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>ASL Categories</strong></font></td><td align="right"></td></tr></table></div>                                
                                        <div id="asl_div">{ $asl_categories }</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--ended: ASL categories-->
                                
                    <!--start: endorsement history-->
                    <tr>
                        <td  colspan="3" width=30% >
                            <table width=100% border=0 cellspacing=1 cellpadding=2>
                                <tr>
                                    <td valign="top" width="50%">
                                        <div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Endorsement History</strong></font></td><td align="right"></td></tr></table></div>                                
                                        { $endorsement_history }
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--ended: endorsement history-->                                
					
					  <!--start: shortlist history-->
                    <tr>
                        <td  colspan="3" width=30% >
                            <table width=100% border=0 cellspacing=1 cellpadding=2>
                                <tr>
                                    <td valign="top" width="100%">
                                    	<div id="shortlist_preview"></div>
                                        <div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Shortlisted History</strong></font></td><td align="right"></td></tr></table></div>                                
                                        { $shortlist_history }
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--ended: shortlist history-->   
                    <!--start: job applications-->
                    <tr>
                        <td  colspan="3" width=30% >
                            <table width=100% border=0 cellspacing=1 cellpadding=2>
                                <tr>
                                    <td valign="top" width="100%">
                                        <div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Job Applications</strong></font></td><td align="right"></td></tr></table></div>                                
                                        { $jobapplications }
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--ended: job applications-->
                      
                <!--ENDED: additional information-->


                <!--START: communications history-->
                <tr>
                    <td width=100% colspan=3><h2>Communication Records</h2></td>
                </tr>
                <tr>
                    <td  colspan="3" width=30% >
                        <p>{ $fname } { $lname }</p>
                        <p style="color:#333333;">Please send all Service Agreements Contracts to contracts@remotestaff.com.au</p>	
                        <table width=100% border=0 cellspacing=1 cellpadding=2>
                            <tr>
                                <td width="20%">
                                    <input type="radio" name="action" value="EMAIL" onclick ="showHide('EMAIL');"> Email
                                    <a href="sendemail.php?id={ $leads_id }">
                                    <img border="0" src="../images/email.gif" alt="Email" width="16" height="10"></a>
                                </td>
                                <td width="20%">
                                    <input type="radio" name="action" value="CALL" onclick ="showHide('CALL');"> Call 
                                    <img src="../images/icon-telephone.jpg" alt="Call">
                                </td>
                                <td width="20%">
                                    <input type="radio" name="action" value="NOTES" onclick ="showHide('NOTES');"> Notes
                                    <img src="../images/textfile16.png" alt="Notes" >
                                </td>
                                <td width="20%">
                                    <input type="radio" name="action" value="MEETING FACE TO FACE" onclick ="showHide('MEETING FACE TO FACE');"> Meeting face to face
                                    <img src="../images/icon-person.jpg" alt="Meet personally">
                                </td>
                                <td width="20%">
                                    <input type="radio" name="action" value="NHO" onclick ="showHide('CSR');"> New Hire Orientation
                                    <img src="../images/icon-person.jpg" alt="Meet personally">
                                </td>                                
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
        
                        <!--start: communications history form-->
                        <div id="message"></div>
                        <!--ended: communications history form-->
                    
                        <!--start: communication history tab report-->
                            <!--start: edit notes--><br />
                            <div id="edit_notes_div"></div>
                            <!--ended: edit notes-->
                            
                            <div class="tabber">
                                
                                <!--start: view all notes-->
                                <div class="tabbertab">
                                    <h2><a href="javascript: load_all(); ">View All</a></h2>
                                    <div id="all_report">
                                    	{if $admin_report}
                                    	{ $admin_report } <br />
                                    	{/if}
                                    	{if $recruiter_report}
                                    	 { $recruiter_report } <br /> 
                                    	{/if}
                                    	{if $feedbacks}
                       		             
                                    		<table  width="100%" cellpadding="3" cellspacing="0" border="0" >
                                    			<summary style="border-bottom:1px dotted #ccc;color:#999999">Interview Feedbacks</summary>
                                    			<tbody> 
                            					<tr>
                            						<td class="td_info td_la" width="2%">
                            							#	
                            						</td>
                            						<td class="td_info td_la" width="10%">
                            							Admin	
                            						</td>
                            						<td class="td_info td_la" width="15%">
                            							Client	
                            						</td>
                            						<td class="td_info td_la" width="58%">
                            							Feedback	
                            						</td>
                            						<td class="td_info td_la">
                            							Date Created	
                            						</td>
                            						
                            					</tr>
                                				
                                					{foreach from=$feedbacks item=feedback name=feedback_list}
		                                    			<tr>
		                                    				<td class="td_info td_la">{$smarty.foreach.feedback_list.iteration}</td>
		                                    				<td class="td_info">{$feedback.admin}</td>
		                                    				<td class="td_info"><a href="javascript:lead({$feedback.client_id})">{$feedback.client}</td>
		                                    				<td class="td_info">{$feedback.feedback}</td>
		                                    				<td class="td_info">{$feedback.date_created}</td>
		                                    				
		                                    				
		                                    			</tr>	
		                                    		{/foreach}
                                				</tbody>
                                    		</table>
                                    		
                                    	{/if}
                                    	
                                    	{if $feedback_endorsement}
                                    		<table  width="100%" cellpadding="3" cellspacing="0" border="0" >
                                    			<summary style="border-bottom:1px dotted #ccc;color:#999999">Endorsement Rejection Feedbacks</summary>
                                    			
                                    			<tbody>
                            					<tr>
                            						<td class="td_info td_la" width="2%">
                            							#	
                            						</td>
                            						<td class="td_info td_la" width="10%">
                            							Admin	
                            						</td>
                            						<td class="td_info td_la" width="15%">
                            							Client	
                            						</td>
                            						<td class="td_info td_la" width="58%">
                            							Feedback	
                            						</td>
                            						<td class="td_info td_la">
                            							Date Created	
                            						</td>
                            						
                            					</tr>
                                				
                                					{foreach from=$feedback_endorsement item=feedback name=feedback_endorsement_list}
		                                    			<tr>
		                                    				<td class="td_info td_la">{$smarty.foreach.feedback_endorsement_list.iteration}</td>
		                                    				<td class="td_info">{$feedback.rejected_admin}</td>
		                                    				<td class="td_info"><a href="javascript:lead({$feedback.client_name})">{$feedback.client}</td>
		                                    				<td class="td_info">{$feedback.rejection_feedback}</td>
		                                    				<td class="td_info">{$feedback.rejected_date}</td>
		                                    				
		                                    				
		                                    			</tr>	
		                                    		{/foreach}
                                				</tbody>
                                    		</table>
                                    	{/if}
                                    	{if $evaulation_report }
                                    	<p><strong style="color:#ff0000">Note:</strong> You can sort the entries by dragging in to desired placement.</p>
                                    	{ $evaulation_report } 
                                    	{/if}
                                    	</div>
                                </div>
                                <!--ended: view all notes-->
                                
                                <!--start: admin notes-->
                                <div class="tabbertab">
                                    <h2>Admin</h2>
                                    <div id="admin_report_div">{ $admin_report }</div>
                                </div>
                                <!--ended: admin notes-->            
                                
                                <!--start: recruiters notes-->
                                <div class="tabbertab">
                                    <h2>Recruiter</h2>
                                    <div id="recruiter_report_div">{ $recruiter_report }</div>
                                </div>
                                <!--ended: recruiters notes-->            
                                
                                <!--start: interview feedback -->
                                 <div class="tabbertab">
                                    <h2>Interview Feedback</h2>
                                    <div id="interview_feedbacks_div">
                                    	{if $feedbacks}
                                    		<table  width="100%" cellpadding="3" cellspacing="0" border="0" >
                            					<tr>
                            						<td class="td_info td_la" width="2%">
                            							#	
                            						</td>
                            						<td class="td_info td_la" width="10%">
                            							Admin	
                            						</td>
                            						<td class="td_info td_la" width="15%">
                            							Client	
                            						</td>
                            						<td class="td_info td_la" width="58%">
                            							Feedback	
                            						</td>
                            						<td class="td_info td_la">
                            							Date Created	
                            						</td>
                            						
                            					</tr>
                                				
                                					{foreach from=$feedbacks item=feedback name=feedback_list}
		                                    			<tr>
		                                    				<td class="td_info td_la">{$smarty.foreach.feedback_list.iteration}</td>
		                                    				<td class="td_info">{$feedback.admin}</td>
		                                    				<td class="td_info"><a href="javascript:lead({$feedback.client_id})">{$feedback.client}</td>
		                                    				<td class="td_info">{$feedback.feedback}</td>
		                                    				<td class="td_info">{$feedback.date_created}</td>
		                                    				
		                                    				
		                                    			</tr>	
		                                    		{/foreach}
                                				</tbody>
                                    		</table>
                                    		
                                    	{/if}
                                    </div>
                                 </div>
                                
                                <!--ended: interview feedback -->
                                 <div class="tabbertab">
                                    <h2>Endorsement Feedback</h2>
                                
                                	{if $feedback_endorsement}
                                    		<table  width="100%" cellpadding="3" cellspacing="0" border="0" >
                                    			<tbody>
                            					<tr>
                            						<td class="td_info td_la" width="2%">
                            							#	
                            						</td>
                            						<td class="td_info td_la" width="10%">
                            							Admin	
                            						</td>
                            						<td class="td_info td_la" width="15%">
                            							Client	
                            						</td>
                            						<td class="td_info td_la" width="58%">
                            							Feedback	
                            						</td>
                            						<td class="td_info td_la">
                            							Date Created	
                            						</td>
                            						
                            					</tr>
                                				
                                					{foreach from=$feedback_endorsement item=feedback name=feedback_endorsement_list}
		                                    			<tr>
		                                    				<td class="td_info td_la">{$smarty.foreach.feedback_endorsement_list.iteration}</td>
		                                    				<td class="td_info">{$feedback.rejected_admin}</td>
		                                    				<td class="td_info"><a href="javascript:lead({$feedback.client_name})">{$feedback.client}</td>
		                                    				<td class="td_info">{$feedback.rejection_feedback}</td>
		                                    				<td class="td_info">{$feedback.rejected_date}</td>
		                                    				
		                                    				
		                                    			</tr>	
		                                    		{/foreach}
                                				</tbody>
                                    		</table>
                                    	{/if}
                                 </div>
                                
                                 <div class="tabbertab">
                                    <h2>Shortlist Feedback</h2>
                                
                                	{if $feedback_shortlist}
                                    		<table  width="100%" cellpadding="3" cellspacing="0" border="0" >
                                    			<tbody>
                            					<tr>
                            						<td class="td_info td_la" width="2%">
                            							#	
                            						</td>
                            						<td class="td_info td_la" width="10%">
                            							Admin	
                            						</td>
                            						<td class="td_info td_la" width="15%">
                            							Client	
                            						</td>
                            						<td class="td_info td_la" width="58%">
                            							Feedback	
                            						</td>
                            						<td class="td_info td_la">
                            							Date Created	
                            						</td>
                            						
                            					</tr>
                                				
                                					{foreach from=$feedback_shortlist item=feedback name=feedback_shortlist_list}
		                                    			<tr>
		                                    				<td class="td_info td_la">{$smarty.foreach.feedback_shortlist_list.iteration}</td>
		                                    				<td class="td_info">{$feedback.rejected_admin}</td>
		                                    				<td class="td_info"><a href="javascript:lead({$feedback.client_name})">{$feedback.client}</td>
		                                    				<td class="td_info">{$feedback.feedback}</td>
		                                    				<td class="td_info">{$feedback.date_rejected}</td>
		                                    				
		                                    				
		                                    			</tr>	
		                                    		{/foreach}
                                				</tbody>
                                    		</table>
                                    	{/if}
                                 </div>
                                
                                
                                
                                
                                <!--start: evaluation notes-->
                                <div class="tabbertab">
                                    <h2>Evaluation Notes</h2>
                                    <div id="evaluation_report_div">
                                    	<p><strong style="color:#ff0000">Note:</strong> You can sort the entries by dragging in to desired placement.</p>
                                    	{ $evaulation_report_tab }</div>
                                </div>
                                <!--ended: evaluation notes-->
                                
                            </div>
                        <!--ended: communication history tab report-->
                    
                    </td>
                </tr>
                <!--ENDED: communications history-->


                <!--START: history-->
                <tr>
                    <td width=100% colspan=2><h2>History</h2></td>
                </tr>
                <tr>
                    <td colspan="3" width=30%>
						<div id="history">
                            <table width="100%" cellpadding="0" cellspacing="1">
                                <tr>
                                    <td height="66" valign="top">
                                        <div style='margin-bottom:10px; border:#fff solid 1px; background:#FFFFFF;'>
                                        <div style='overflow-y:scroll;overflow-x:hidden; height:200px; '>{ $history_logs_report }</div>
                                    </td>
                                </tr>
                            </table>
						</div>
                    </td>
                </tr>
            </table>
            <!--ENDED: history-->


		</td>
	</tr>
</table>

{php} include("footer.php") {/php}

<!--START: asl alarm-->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!--ENDED: asl alarm-->

<!--START: left nav. container -->
<DIV ID='applicationsleftnav_container' STYLE='POSITION: Absolute; RIGHT: 50px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table width="100%">
	<tr>
		<td align="right" background="images/close_left_menu_bg.gif"><a href="javascript: applicationsleftnav_hide(); "><img src="images/close_left_menu.gif" border="0" /></a></td>
	</tr>
</table>

{php} include("applicationsleftnav.php") {/php}

</DIV>
<!--ENDED: left nav. container -->


<!--START: in-active staff status update-->
<DIV ID='inactive_staff_div' STYLE='POSITION: Absolute; LEFT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table bgcolor="#FFFFCC" cellpadding="4" cellspacing="4" width="100%">
	<tr>
    	<td width="100%" align="right">NO&nbsp;POTENTIAL</td><td><input type="radio" name="inactive_options" value="NO POTENTIAL" onclick ="update_status({ $userid }, 'INACTIVE','NO POTENTIAL');" { if $inactive_current_status eq 'NO POTENTIAL' } checked { /if } ></td><td>&nbsp;&nbsp;&nbsp;</td>
        <td>NOT&nbsp;INTERESTED</td><td><input type="radio" name="inactive_options" value="NOT INTERESTED" onclick ="update_status({ $userid }, 'INACTIVE','NOT INTERESTED');" { if $inactive_current_status eq 'NOT INTERESTED' } checked { /if } ></td><td>&nbsp;&nbsp;&nbsp;</td>
        <td>NOT&nbsp;READY</td><td><input type="radio" name="inactive_options" value="NOT READY" onclick ="update_status({ $userid }, 'INACTIVE','NOT READY');" { if $inactive_current_status eq 'NOT READY' } checked { /if } ></td><td>&nbsp;&nbsp;&nbsp;</td>
        <td>BLACKLISTED</td><td><input type="radio" name="inactive_options" value="BLACKLISTED" onclick ="update_status({ $userid }, 'INACTIVE','BLACKLISTED');" { if $inactive_current_status eq 'BLACKLISTED' } checked { /if } ></td><td>&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td align="right"><a href="javascript: inactive_staff_option_exit(); "><img src="../images/closelabel.gif" border="0" /></a></td>
	</tr>
</table> 
</DIV>
<!--ENDED: in-active staff status update-->


</form>


<!-- add feedback -->
<div id="add-feedback-dialog" style="display: none">
	<p>Please add a feedback about the <strong>Shortlist Rejection</strong> between <strong><span id='feedback_client_name'></span></strong> and <strong><span id='feedback_staff_name'></span></strong>.</p>
	<form class="add_feedback_form">
		<input type="hidden" name="id" id="shortlist_id"/>
		<table border="0" width="100%">
			<tr>
				<td width="10%"><label>Feedback</label></td>
				<td width="90%"><textarea rows="10" name="feedback" style="width:95%"></textarea></td>
			</tr>
		</table>
	</form>
</div>
{literal}
<style type="text/css">
	.ui-dialog .ui-dialog-titlebar-close span{
		margin:-8px!important;
	}
</style>
<script type="text/javascript">
	$(function(){
		$(document).on('click','#working_model_btn',function(e){
			var userid = $('input[name=userid]').val();
			var working_model = $('#working_model').val();
			$.post('/portal/recruiter/update_working_model.php',{userid:userid,working_model:working_model},function(response){
				if(response.success){
					alert('Working model has been updated!');
				}
			},'json');
		});
	});
</script>
{/literal}
</body>
</html>
