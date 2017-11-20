{*
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
2010-04-07  Roy Pepito <roy.pepito@remotestaff.com.au>
*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Recruiter View</title>
 
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">

<script type="text/javascript" src="category/category.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="../js/functions.js"></script>

<!--calendar picker - setup-->
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="js/staff.js"></script>
</head>
 
<body style="margin-top:0; margin-left:0">

{php} include("header.php") {/php}
{php} include("recruiter_top_menu.php") {/php}

<!--START: left nav.-->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  >
	<tr>
        <td valign="top" style="border-right: #006699 2px solid;">
            <div id='applicationsleftnav'>
                <table>
                    <tr>
                        <td background="images/open_left_menu_bg.gif">
                            <a href="javascript: applicationsleftnav_show(); "><img src="images/open_left_menu.gif" border="0" /></a>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td valign="top" width="100%">
<!--ENDED: left nav.-->

            
<!--START: sub title-->
<h1 align="left">&nbsp;&nbsp;Recruiter View {if $staff_status neq ''} <span class="leads_id">{ $staff_status }</span> {/if}</h1>
<!--ENDED: sub title-->            
            

<!--START: search function-->
            <div style="background:#FFFFFF; padding:5px; text-align:center; "><center>
            
                <table width="80%">
                    <tr>
                        <td>
                            <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                <table width="100%">
                                    <tr>
                                        <td><span><strong>Sub Categories / Advance Search</strong></span></td>
                                        <td align="right"><span style='width:150px;color:#ff0000;text-align:right;cursor:pointer;' id='label_str' onClick="show_hide_search('search_box','label_str');">[Show]</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                            	<table width="100%">
                                	<tr>
                                    	<!--<td><button onClick="window.open('../tools/AvailableStaffChecker/AvailableStaffChecker.html', '_blank');">Available Staff Checker</button></td>-->
                                        <td align="right">
                                            <table>
                                            	<tr>
                                                	<td><font color="#FF0000"><strong>LEGEND:&nbsp;&nbsp;&nbsp;&nbsp;</strong></font></td>
                                                    <td><font color="#FFFFFF" size="1"><strong><img src='../images/edit.gif' border="0" width="14" /></strong></font></td><td>deleted</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td><font color="#FFFFFF" size="1"><strong><img src='../images/delete.png' border="0" width="14" /></strong></font></td><td>remove from the list</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td><font color="#FFFFFF" size="1"><strong><img src='../images/icon-person.jpg' border="0" width="14" /></strong></font></td><td>replace or assign new recruiter</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td><font color="#FFFFFF" size="1"><strong><img src='../images/external.gif' border="0" width="14" /></strong></font></td><td>open profile on new window</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
												</tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                            </div>
                    </tr>
                </table>
                
                <!--<table width="80%" style='display:none;' id='search_box' border="0" bgcolor="#FFFFFF">-->
                <table width="80%" id='search_box'>
                    <tr>
                    <td valign="top">
                        <table width="100%" style="border:#FFFFFF solid 1px"; cellpadding="1" cellspacing="1">
                            <tr>
                            	{ if $staff_status neq 'ENDORSED' }
                                <td width="30%">
                                    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'><strong>Postings Advertised Quick Menu</strong></div>				
                                </td>
                                { /if }
                                <td width="70%">
                                    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                        <b>
                                            <strong>Search Options</strong>
                                        </b>
                                    </div>				
                                </td>
                            </tr>
                            <tr>
                            	{ if $staff_status neq 'ENDORSED' }
                                <td width="40%" valign="top" align="left">

                                    { $position_advertised }
                                    
                                </td>
                                { /if }
                                <td width="60%" valign="top">
                                
                                    <table width="100%" style="border:#CCCCCC solid 1px; " cellpadding="3" cellspacing="3">
                                        <tr>
                                            <td colspan="2">
                                                <div class="subtab">
                                                    <ul>
                                                        <li id="p" {if $country_option eq 'philippines'} class='selected' {/if}><a href="?country_option=philippines"><span>Philippines</span></a></li>
                                                        <li id="c" {if $country_option eq 'china'} class='selected' {/if}><a href="?country_option=china"><span>China</span></a></li>
                                                        <li id="i" {if $country_option eq 'india'} class='selected' {/if}><a href="?country_option=india"><span>India</span></a></li>
                                                        <li id="a" {if $country_option eq 'all'} class='selected' {/if}><a href="?country_option=all"><span>All</span></a></li>
                                                    </ul>
                                                </div>
                                                <div ID='popup_report' align="center" style='POSITION: Absolute; border: dashed ; overflow:hidden; background: #FFF; height:330px; width: 740px; VISIBILITY: HIDDEN '>
                                                    <table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#FFFFCC>
                                                        <tr>
                                                            <td valign=top>
                                                                <table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
                                                                    <tr bgcolor="#FFFFFF">
                                                                        <td width="100%" align="left" valign="top">
                                                                            <div class="hiresteps">
                                                                            <table width="100%">
                                                                                <tr>
                                                                                    <td><font color="#003366"><strong>Search</strong></font>&nbsp;<input type="text" id="keyword"><input type="button" value="Search" onClick="javascript: show_search_popup_report(); "></td>
                                                                                    <td align="right"><a href='javascript: hide_popup_report(); '><img src="../../portal/images/closelabel.gif" border="0" /></a></td>
                                                                                </tr>
                                                                            </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>                                                
                                                </DIV>
                                            </td>
                                        </tr>		
                                        <tr>
                                            <td colspan="2"></td>
                                        </tr>
                                    </table>
                                    
                                    <table width="100%" style="border:#CCCCCC solid 1px; " cellpadding="3" cellspacing="3">
                                        <tr>
                                            <td colspan="2"><strong>Search for All Registered Applicant <font size=1><i>(entire database)</i></font></strong></td>
                                        </tr>		
                                        <tr>
                                            <td colspan="2">
                                                <form action="?staff_status={ $staff_status }" method="post" name="formtable" onSubmit="return registered_validate(this); ">
                                                <input type="hidden" name="country_option" id="country_option4" value="{ $country_option }">
                                                <input type="hidden" name="result_total" value="" />
                                                    <table width="0" border="0" cellpadding="0">
                                                        <tr>
                                                            <td colspan=4>Position Advertised</td>
                                                        </tr>
                                                        
                                                        <tr>	
                                                            <td colspan=4>
	                                                            { $position }
                                                            </td>
                                                        </tr> 
                                                        <tr>
                                                            <td colspan=3>Date&nbsp;Registered&nbsp;Between&nbsp;</td>
                                                        </tr>
                                                        <tr>	
                                                            <td colspan="5">
                                                                            
                                                                                <table width="0"  border="0" cellspacing="0" cellpadding="0">
                                                                                  <tr>
                                                                                    <td>
                                                                                        <table>
                                                                                            <tr>
                                                                                                <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                <td>
                                                                                                <input type="text" name="date_requested1" id="id_date_requested1" class="text" {if $registered_date_check eq 'on'} disabled {/if} value="{ $date_requested1 }">
                                                                                                { $search_date_requested1 }
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table> 
                                                                                     </td>
                                                                                     <td>
                                                                                        <table>
                                                                                            <tr>
                                                                                                <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                <td>
                                                                                                <input type="text" name="date_requested2" id="id_date_requested2" class="text" {if $registered_date_check eq 'on'} disabled {/if} value="{ $date_requested2 }">
                                                                                                { $search_date_requested2 }
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table> 
                                                                                    </td>                                                                                                                                             
                                                                                    <td>&nbsp;Any</td>																	
                                                                                    <td><input type="checkbox" id="registered_date_check_id" name="registered_date_check" onClick="javascript: registered_any_date(this); " {if $registered_date_check eq 'on'} checked {/if} style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                                                                  </tr>
                                                                                </table>
                                                                            
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan=3>Date&nbsp;Updated</td>
                                                        </tr>
                                                        <tr>	
                                                            <td colspan="5">
                                                                            
                                                                                <table width="0"  border="0" cellspacing="0" cellpadding="0">
                                                                                  <tr>
                                                                                    <td>
                                                                                        <table>
                                                                                            <tr>
                                                                                                <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_updated1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                <td>
                                                                                                <input type="text" name="date_updated1" id="id_date_updated1" class="text" {if $updated_date_check eq 'on'} disabled {/if} value="{ $date_updated1 }">
                                                                                                { $search_date_updated1 }
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table> 
                                                                                     </td>
                                                                                     <td>
                                                                                        <table>
                                                                                            <tr>
                                                                                                <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_updated2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                <td>
                                                                                                <input type="text" name="date_updated2" id="id_date_updated2" class="text" {if $updated_date_check eq 'on'} disabled {/if} value="{ $date_updated2 }">
                                                                                                { $search_date_updated2 }
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table> 
                                                                                    </td>                                                                                                                                             
                                                                                    <td>&nbsp;Any</td>																	
                                                                                    <td><input type="checkbox" id="updated_date_check_id" name="updated_date_check" onClick="javascript: updated_any_date(this); " {if $updated_date_check eq 'on'} checked {/if} style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                                                                  </tr>
                                                                                </table>
                                                                            
                                                            </td>
                                                        </tr>  
                                                        <tr>
                                                            <td colspan=4>Keyword / Keyword Type (<i>multiple keywords separated by comma</i>)</td>
                                                        </tr>
                                                        <tr>	
                                                            <td colspan=4>
                                                            
                                                                                    <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                                                                      <tr>
                                                                                        <td><input type="text" id="registered_key_id" name="registered_key" value="{ $registered_key }" {if $registered_key_check eq 'on'} disabled {/if} ></td>
                                                                                        <td>&nbsp;
                                                                                                <select name="registered_key_type" id="registered_key_type_id" {if $registered_key_check eq 'on'} disabled {/if} >
																									{if $registered_key_type eq 'id'} <option value="id" selected>ID</option> {/if}
																									{if $registered_key_type eq 'fname'} <option value="fname" selected>FIRST NAME</option> {/if}
																									{if $registered_key_type eq 'lname'} <option value="lname" selected>LAST NAME</option> {/if}
																									{if $registered_key_type eq 'email'} <option value="email" selected>EMAIL</option> {/if}
																									{if $registered_key_type eq 'skills'} <option value="skills" selected>SKILLS</option> {/if}
																									{if $registered_key_type eq 'mobile'} <option value="mobile" selected>MOBILE NO.</option> {/if}
																									{if $registered_key_type eq 'resume_body'} <option value="resume_body" selected>RESUME</option> {/if}
																									{if $registered_key_type eq 'notes'} <option value="notes" selected>NOTES</option> {/if}
                                                                                                    <option value="id">ID</option>
                                                                                                    <option value="fname">FIRST NAME</option>
                                                                                                    <option value="lname">LAST NAME</option>
                                                                                                    <option value="email">EMAIL</option>
                                                                                                    <option value="mobile">MOBILE NO.</option>
                                                                                                    <option value="skills">SKILLS</option>
                                                                                                    <option value="resume_body">RESUME BODY</option>
                                                                                                    <option value="notes">NOTES</option>
                                                                                                </select>																		
                                                                                        </td>
                                                                                        <td>&nbsp;Any</td>
                                                                                        <td><input id="registered_key_check_id" name="registered_key_check" type="checkbox" onClick="javascript: registered_any_key(this); " {if $registered_key_check eq 'on'} checked { /if } /></td>
                                                                                        <td></td>
                                                                                      </tr>
                                                                                    </table>
                                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>	
                                                            <td colspan=4>{ if $staff_status eq 'INACTIVE' }Inactive / { /if }Recruiter{ if $staff_status eq 'ENDORSED' } / Endorsed&nbsp;Lead&nbsp;ID{ /if }</td>
                                                        </tr>                                                         
                                                        <tr>	
                                                            <td colspan=4>
																<table width="0%"  border="0" cellspacing="0" cellpadding="0">
																	<tr>
                                                                    	{ if $staff_status eq 'INACTIVE' }
                                                                    	<td>
                                                                            <select name="search_inactive_options" id="search_inactive_options" >
                                                                                { $search_inactive_options }
                                                                            </select> 
                                                                    	</td>
                                                                        <td>&nbsp;</td>
                                                                        { /if }                                                                    
                                                                    	<td>
                                                                            <select name="search_recruiter_options" id="search_recruiter_options" >
                                                                                { $search_recruiter_options }
                                                                            </select> 
                                                                    	</td>
                                                                    	{ if $staff_status eq 'ENDORSED' }
                                                                        <td>&nbsp;</td>
                                                                    	<td>
                                                                        	<input type="text" id="search_lead_id" name="search_lead_id" value="{ $search_lead_id }" >
                                                                            <input type="button" name="browse_lead_id" value="Browse Lead" onclick="javascript: show_popup_report(); " >
                                                                    	</td>
                                                                        { /if }                                                                        
																	</tr>
																</table>                                                            
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        	<td>
                                                            	<table>
                                                                	<tr>
                                                                    	<td><input type="submit" name="registered_advance_search" value="VIEW RESULT" style='color:#000000; font:arial; font-weight:normal; font-size:13px; padding:0px 1px 2px 2px; border:2px #666666 solid;'></td>
                                                                        <td><div id="mass_email_option"><input type="checkbox" name="mass_email" onClick="javascript: check_emailing_status(this); ">Apply Result to Mass Emailing list</div></td>
																	</tr>
																</table>
															</td>
                                                        </tr>
                                                        <tr>
                                                            <td>

                                                            </td>														  
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                            
                                                                                    <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                                                                      <tr>
                                                                                        <td></td>
                                                                                      </tr>
                                                                                    </table>
            
                                                            </td>
                                                        </tr>														  													  
                                                    </table>
                                                </form>				
                                                
                                            </td>
                                        </tr>
                                    </table>
                
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"></td>
                            </tr>
                        </table>
                    
                    </td>
                </tr>
                <tr>
                	<td>
                    	<div class="hiresteps"><table width="100%"><tr><td><strong>Custom Booking</strong></td><td align="right"><a href="javascript: booking(); ">Click to Book Interview Now</a></td></tr></table></div>
                        <div id="listings"><table width="100%" cellpadding="3" cellspacing="3">{ $return_output }</table></div>
					</td>
                </tr>
            </table>	    
            </center>
            </div>
<!--ENDED: search function-->            
            

<!--START: listings-->
            <div align="center">
				<table width=98% cellpadding=3 cellspacing="3" border=0>
                	<tr>
                    	<td align="center">
                            <table width=100% cellpadding=3 cellspacing="0" border=0 bgcolor="#006699">
                            
                                <tr bgcolor="#FFFFFF">
                                	<td></td>
                                    <td align="right" colspan="7"> { $result_pages } </td>
                                </tr>
                                                            
                                <tr>
                                	<td width="0" bgcolor="#FFFFFF"></td>
                                    <td bgcolor="#FFFFFF" style="border-right: #006699 2px solid;"></td>
                                    { if $staff_status eq 'ENDORSED' }
                                    	<td align="left"><font color="#FFFFFF" size="1"><strong>LEAD&nbsp;/&nbsp;POSITION&nbsp;/DATE&nbsp;ENDORSED</strong></font></td>
									{ else }
                                    	<td align="left"><font color="#FFFFFF" size="1"><strong>SKILLS</strong></font></td>
									{/if}
                                    <td align="center"><font color="#FFFFFF" size="1"><strong>DATE&nbsp;REGISTERED</strong></font></td>
                                    <td align="center"><font color="#FFFFFF" size="1"><strong>HOT&nbsp;/&nbsp;EXPERIENCED&nbsp;/&nbsp;CUSTOM BOOKING&nbsp;&nbsp;&nbsp;</strong></font></td>
                                    <td align="center"><font color="#FFFFFF" size="1"><strong><img src='../images/delete.png' border="0" width="14" /></strong></font></td>
                                    <td align="center"><font color="#FFFFFF" size="1"><strong><img src='../images/icon-person.jpg' border="0" width="14" /></strong></font></td>
                                    <td align="center"><font color="#FFFFFF" size="1"><strong><img src='../images/external.gif' border="0" width="14" /></strong></font></td>
                                </tr>

								{ $searched_result_listings }
                                	
                                <tr bgcolor="#FFFFFF">
                                	<td></td>
                                    <td align="right" colspan="7"> { $result_pages } </td>
                                </tr>   
                            </table>
                        </td>
                    </tr>
				</table>
            </div>
            
        </td>
	</tr>
</table>
<!--ENDED: listings-->


</td>
</tr>
</table>

{php} include("footer.php") {/php}

<!--START: assign recruiter -->
<DIV ID='staff_recruiter_stamp_div' STYLE='POSITION: Absolute; LEFT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table bgcolor="#FFFFCC" cellpadding="4" cellspacing="4" width="100%">
<tr>
	<td><b>Replace&nbsp;or&nbsp;assign&nbsp;new&nbsp;recruiter</b></td>
	<td>
		<select id="staff_recruiter_stamp_assign" style="font:11px tahoma;">
			{ $search_recruiter_assign_options }
		</select>
	</td>
	<td><input type="submit" name="registered_advance_search" onclick="javascript: staff_recruiter_stamp_update(); " style="font:11px tahoma;" value="Assign Recruiter"></td>
	<td width="100%" align="right"><a href="javascript: close_popup(); "><img src="../images/closelabel.gif" border="0" /></a></td>
</tr>
</table>
</DIV>
<!--ENDED: assign recruiter -->

<!--START: asl alarm-->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!--ENDED: asl alarm-->

<!--START: delete staff -->
<DIV ID='delete_staff_div' STYLE='POSITION: Absolute; LEFT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table bgcolor="#FFFFCC" cellpadding="4" cellspacing="4" width="100%">
<tr>
	<td><img src="../images/delete.png" /></td>
	<td><font color="#FF0000"><b>You&nbsp;are&nbsp;about&nbsp;to&nbsp;<strong>REMOVE</strong>&nbsp;this&nbsp;staff&nbsp;from&nbsp;the&nbsp;list. Click <strong>REMOVE</strong> to continue.</b></font></td>
	<td><input type="submit" name="registered_advance_search" onclick="javascript: execute_delete_staff(); " style="font:11px tahoma;" value="Remove"></td>
	<td width="100%" align="right"><a href="javascript: close_popup(); "><img src="../images/closelabel.gif" border="0" /></a></td>
</tr>
</table>
</DIV>
<!--ENDED: delete staff -->


<!--START: left nav. container -->
<DIV ID='applicationsleftnav_container' STYLE='POSITION: Absolute; RIGHT: 50px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table width="100%">
	<tr>
		<td align="right" background="images/close_left_menu_bg.gif">
        	<a href="javascript: applicationsleftnav_hide(); "><img src="images/close_left_menu.gif" border="0" /></a>
		</td>
	</tr>
</table>

{php} include("applicationsleftnav.php") {/php}

</DIV>
<!--ENDED: left nav. container -->

</body>
</html>
