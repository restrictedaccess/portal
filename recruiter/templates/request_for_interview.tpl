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
<link rel="stylesheet" type="text/css" href="css/request_for_interview.css"/>
<link rel=stylesheet type=text/css href="/portal/recruiter/css/themes/south-street/jquery-ui-1.8.19.custom.css"/>

<script language=javascript src="../js/jquery.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
<script language="javascript" src="js/jquery.BetterGrow.js"></script>
<!--calendar picker - setup-->
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>


<script type="text/javascript" src="js/request_for_interview.js"></script>

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
<h1 align="left">&nbsp;{ $service_type_title }</h1>
<!--ENDED: sub title-->            
            

<!--START: search function-->
            <div style="background:#FFFFFF; padding:5px; text-align:center; "><center>
            
                <table width="80%">
                    <tr>
                        <td>
                            <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                <table width="100%">
                                    <tr>
                                        <td><span><strong>Advanced Search</strong></span></td>
                                        <td align="right"><span style='width:150px;color:#ff0000;text-align:right;cursor:pointer;' id='label_str' onClick="show_hide_search('search_box','label_str');">[Show]</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div style='padding:3px; font:12px Arial;background:#FFFFFF; border:#CCCCCC outset 1px;'>
                                <!--<table width="100%" style='display:none;' id='search_box' border="0" bgcolor="#FFFFFF">-->
                                <table width="100%" id='search_box'>
												<tr>
													<td align="left" valign="top" bgcolor="#ffffff" colspan="5">
                                                            <table width="100%" border="0" bgcolor="#ffffff" cellpadding="4" cellspacing="1">
                                                              <tr>
                                                                    <td align="left" valign="top" bgcolor="#ffffff"> <font color="#000000"><strong>
                                                                        <form id="filter-form" action="?service_type={$service_type}" method="GET" name="formtable">
                                                                        <table width="0%"  border="0" cellspacing="3" cellpadding="3">
                                                                            <tr>
                                                                                <td></td>
                                                                                <td><font size="1"><strong>Staff/Client</strong>(First&nbsp;Name&nbsp;/Last&nbsp;Name&nbsp;/ID/&nbsp;Voucher)</font></td>							  
                                                                            </tr>								
                                                                            <tr>
                                                                                <td>	  
                                                                                    <strong>Keyword</strong><em>(optional)</em>
                                                                                </td>
                                                                                <td><input type="text" id="key_id" name="key" value="{ $key }" class="select" /></td>							  
                                                                            </tr>
                                                                            <tr>
																				<td scope="row"><font color="#000000"><strong>Date Requested Between</strong></font></td>
                                                                                <td>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_requested1" id="id_date_requested1" class="text" value="{if $date_requested1 eq ''}Any{/if}{if $date_requested1 neq ''}{ $date_requested1 }{/if}">
																									{ $search_date_requested1 }                                        
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_requested2" id="id_date_requested2" class="text" value="{if $date_requested2 eq ''}Any{/if}{if $date_requested2 neq ''}{$date_requested2}{/if}">
																									{ $search_date_requested2 }                                       
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
																				<td scope="row"><font color="#000000"><strong>Date Updated Between</strong></font></td>
                                                                                <td>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_updated1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_updated1" id="id_date_updated1" class="text" value="{if $date_updated1 eq ''}Any{/if}{if $date_updated1 neq ''}{ $date_updated1 }{/if}">
																									{ $search_date_updated1 }                                        
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_updated2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_updated2" id="id_date_updated2" class="text" value="{if $date_updated2 eq ''}Any{/if}{if $date_updated2 neq ''}{$date_updated2}{/if}">
																									{ $search_date_updated2 }                                       
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
																				<td scope="row"><font color="#000000"><strong>Interview Schedule Between</strong></font></td>
                                                                                <td>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_interview_sched1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_interview_sched1" id="id_date_interview_sched1" class="text" value="{if $date_interview_sched1 eq ''}Any{/if}{if $date_interview_sched1 neq ''}{ $date_interview_sched1 }{/if}">
																									{ $search_date_sched1 }   
																									<select name="time_interview_sched_1">
                                                                                                    	<option value="">Any</option>
                                                                                                    	{foreach from=$option_hours item=option_hour}
                                                                                                    		{if $option_hour.val eq $time_interview_sched1}
    																											<option value="{$option_hour.val}" selected>{$option_hour.label}</option>                                                                                                		
                                                                                                    		{else}
	                                                                                                    		<option value="{$option_hour.val}">{$option_hour.label}</option>
                                                                                                    		{/if}
                                                                                 
                                                                                                    		
                                                                                                    	{/foreach}
                                                                                                    </select>                                     
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_interview_sched2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_interview_sched2" id="id_date_interview_sched2" class="text" value="{if $date_interview_sched2 eq ''}Any{/if}{if $date_interview_sched2 neq ''}{$date_interview_sched2}{/if}">
																									{ $search_date_sched2 }      
                                                                                                    <select name="time_interview_sched_2">
                                                                                                    	<option value="">Any</option>
                                                                                                    	{foreach from=$option_hours item=option_hour}
	                                                                                                    	{if $option_hour.val eq $time_interview_sched2}
   		                                                                                                 		<option value="{$option_hour.val}" selected>{$option_hour.label}</option>
   		                                                                                                 	{else}
   		                                                                                                 		<option value="{$option_hour.val}">{$option_hour.label}</option>
   		                                                                                             
   		                                                                                                 	{/if}
                                                                                                    	{/foreach}
                                                                                                    </select>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>                                                    
                                                                                </td>
                                                                            </tr>
                                                                            
                                                                            <!--
                                                                            <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Booking Type</strong></font></td>
                                                                                <td>
                                                                                      <select size="1" class="text" name="booking_type">
                                                                                      	<option value='ANY'>Any</option>
                                                                                        { if $booking_type eq 'INTERVIEW NOW' }
                                                                                        	<option value=''>ANY</option>
																							<option value='INTERVIEW NOW' selected>INTERVIEW NOW</option>
																							<option value='BOOK INTERVIEW'>BOOK INTERVIEW</option>
																						{ elseif $booking_type eq 'BOOK INTERVIEW' }
                                                                                        	<option value=''>ANY</option>
																							<option value='INTERVIEW NOW'>INTERVIEW NOW</option>
																							<option value='BOOK INTERVIEW' selected>BOOK INTERVIEW</option>
																						{ else }
																							<option value='INTERVIEW NOW'>INTERVIEW NOW</option>
																							<option value='BOOK INTERVIEW'>BOOK INTERVIEW</option>
                                                                                            <option value='' selected>ANY</option>
																						{ /if }  
                                                                                      </select>
                                                                                </td>							
                                                                            </tr>  
                                                                            -->         
                                                                            <!--                                                                  
                                                                            <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Payment Status</strong></font></td>
                                                                                <td>
                                                                                      <select size="1" class="text" name="payment_status">
                                                                                      	<option value='ANY'>Any</option>
                                                                                        { if $payment_status eq 'PAID' }
																							<option value='PAID' selected>Paid</option>
																							<option value='PENDING'>Pending</option>
																							<option value='VOUCHER'>Voucher</option>
																						{ elseif $payment_status eq 'PENDING' }
																							<option value='PAID'>Paid</option>
																							<option value='PENDING' selected>Pending</option>
																							<option value='VOUCHER'>Voucher</option>
																						{ elseif $payment_status eq 'VOUCHER' }
																							<option value='PAID'>Paid</option>
																							<option value='PENDING'>Pending</option>
																							<option value='VOUCHER' selected>Voucher</option>
																						{ elseif $payment_status eq 'ANY' }
																							<option value='PAID'>Paid</option>
																							<option value='PENDING'>Pending</option>
																							<option value='VOUCHER'>Voucher</option>
																						{ else }
                                                                                        	<option value='ANY'>Any</option>
																							<option value='PAID'>Paid</option>
																							<option value='PENDING'>Pending</option>
																							<option value='VOUCHER'>Voucher</option>
																						{ /if }  
                                                                                      </select>
                                                                                </td>							
                                                                            </tr>    
                                                                            -->                                
                                                                            <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Interview Status</strong></font></td>
                                                                                <td>
                                                                                      <select size="1" class="text" name="status">
                                                                                         { if $status eq 'ANY' }
																							<option value='ANY' selected>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>
                                                                                            <option value='NEW'>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option>
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ elseif $status eq 'ARCHIVED' }
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED' selected>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>
                                                                                            <option value='NEW'>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ elseif $status eq 'HIRED' }                                                                                            
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED' selected>Hired</option>
																							<option value='REJECTED'>Rejected</option>	
                                                                                            <option value='NEW'>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option>
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>  
																						{ elseif $status eq 'REJECTED' }                                                                                              													
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED' selected>Rejected</option>	
                                                                                            <option value='NEW'>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option> 
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option> 	
																						{ elseif $status eq 'CONFIRMED' }                                                                                                       
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED' selected>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>	
                                                                                            <option value='NEW'>New</option>	
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ elseif $status eq 'YET TO CONFIRM' }                                                                                                        
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM' selected>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>	
                                                                                            <option value='NEW'>New</option>	
                                                                                            <option value='ON TRIAL'>On Trial</option> 
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option> 
																						{ elseif $status eq 'DONE' }                                                                                                     
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE' selected>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>	
                                                                                            <option value='NEW'>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option> 
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option> 
																						{ elseif $status eq 'RE-SCHEDULED' }                                                                                                      
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED' selected>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>	
                                                                                            <option value='NEW'>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ elseif $status eq 'CANCELLED' }                                                                                                    
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED' selected>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>
                                                                                            <option value='NEW'>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ elseif $status eq 'ANY' }                                                                                                     
																							<option value='ANY' selected>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>	
                                                                                            <option value='NEW'>New</option>			
                                                                                            <option value='ON TRIAL'>On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>												
																						{ elseif $status eq 'NEW' }  
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>
                                                                                            <option value='NEW' selected>New</option>
                                                                                            <option value='ON TRIAL'>On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ elseif $status eq 'ON TRIAL' }  
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>
                                                                                            <option value='NEW'>New</option>                                                                                            
                                                                                            <option value='ON TRIAL' selected="selected">On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ elseif $status eq 'CHATNOW INTERVIEWED' }  
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>
                                                                                            <option value='NEW'>New</option>                                                                                            
                                                                                            <option value='ON TRIAL'>On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED' selected="selected">Contract Page Set</option>                                                                                            
																						{ else }  
																							<option value='ANY'>ANY</option>
																							<option value='CANCELLED'>Cancelled</option>
																							<option value='YET TO CONFIRM'>Hold Pending</option>
																							<option value='CONFIRMED'>Confirmed/In Process </option>
																							<option value='DONE'>Interviewed; waiting for feedback</option>
																							<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>
																							<option value='ARCHIVED'>Archived</option>
																							<option value='HIRED'>Hired</option>
																							<option value='REJECTED'>Rejected</option>
                                                                                            <option value='NEW'>New</option>  
																							<option value='ON TRIAL'>On Trial</option>  
                                                                                            <option value='CHATNOW INTERVIEWED'>Contract Page Set</option>
																						{ /if }
                                                                                      </select>
                                                                                </td>							
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Service Type</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="service_type" id="service_type">
                                                                                     	{$service_type_options}
                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                            <tr>
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Facilitator</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="admin" id="admin_filter">
                                                                                     	{$optionAdmin}
                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                            
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Recruiter</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="recruiter" id="admin_filter">
                                                                                     	<option value="">All</option>
                                                                                     	{foreach from=$recruiters item=recruiter}
                                                                                     		{if $selectedRecruiter eq $recruiter.admin_id}
                                                                                     			<option value="{$recruiter.admin_id}" selected>{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
                                                                                     		{else}
                                                                                     			<option value="{$recruiter.admin_id}">{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
                                                                                     		{/if}
                                                                                     	{/foreach}
                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Staffing Consultant</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="hm" id="admin_filter">
                                                                                     	<option value="">All</option>
                                                                                     	{foreach from=$hms item=hm}
                                                                                     		{if $selectedHM eq $hm.admin_id}
                                                                                     			<option value="{$hm.admin_id}" selected>{$hm.admin_fname} {$hm.admin_lname}</option>
                                                                                     		{else}
                                                                                     			<option value="{$hm.admin_id}">{$hm.admin_fname} {$hm.admin_lname}</option>
                                                                                     		{/if}
                                                                                     	{/foreach}
                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                            
                                                                            
                                                                            <tr>
                                                                                <td></td><td valign="top"><font color="#000000"><input type="submit" id="search" value="Search" name="submit" class="button">									
                                                                            </tr>
                                                                        </table>
                                                                        </form>
                                                                    </td>
                                                                <tr />
                                                            </table>
                                                        
                                                        
													</td>
													<td align="center" valign="middle" colspan="5" bgcolor="#FFFFFF">
                                                        
  
                                                                <table border="0">
                                                                    <tr>
                                                                        <td colspan="5"><strong><FONT color="#FF0000">LEGEND:</FONT></strong></td>
                                                                    </tr>
                                                                    
                                                                    <!--
                                                                    <tr>
                                                                        <td colspan="5"><strong>Payment Status</strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top"><img src='../images/paid.gif' border=0 alt='Paid'></td>
                                                                        <td valign="top">Paid</td>
                                                                        <td>&nbsp;</td>
                                                                        <td valign="top" width="0"><img src='../images/not-paid.gif' border=0 alt='Not Paid'></td>
                                                                        <td valign="top">Not Paid Payment Pending</td>
                                                                    </tr>
                                                                    -->	
                                                                    <tr><td colspan="5">&nbsp;</td></tr>                                    
                                                                    <tr>
                                                                        <td colspan="5"><strong>Interview Status</strong></td>
                                                                    </tr>                                    
                                                                    <tr>
                                                                        <td valign="top" width="0"><img src='../images/confirmed.gif' border=0 alt='Not Paid'></td>
                                                                        <td valign="top">Confirmed/In Process </td>
                                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td valign="top" width="0"><img src="../images/edit.gif" border=0 alt='Move to Cancelled'></td>
                                                                        <td valign="top" align="left">Move&nbsp;to&nbsp;Cancelled</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top" width="0"><img src='../images/re-scheduled.gif' border=0 alt='Not Paid'></td>
                                                                        <td valign="top" align="left">Confirmed/Re-Booked</td>
                                                                        <td>&nbsp;</td>
                                                                        <td valign="top" width="0"><img src='../images/scheduled.gif' border=0 alt='Not Paid'></td>
                                                                        <td valign="top" align="left">Interviewed; waiting for feedback </td>
                                                                    </tr>	
                                                                    <tr>
                                                                        <td valign="top" width="0"><img src='../images/yet-to-confirm.gif' border=0 alt='Not Paid'></td>
                                                                        <td valign="top" align="left">Hold Pending</td>
                                                                        <td>&nbsp;</td>
                                                                        <td valign="top" width="0"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></td>
                                                                        <td valign="top" align="left">Move&nbsp;to&nbsp;Rejected</td>
                                                                    </tr>                                    
                                                                    <tr>
                                                                        <td valign="top" width="0"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></td>
                                                                        <td valign="top" align="left">Move&nbsp;to&nbsp;Hired</td>
                                                                        <td>&nbsp;</td>
                                                                        <td valign="top" width="0"><img src='../images/forward.png' border=0 alt='Move to Archived List'></td>
                                                                        <td valign="top" align="left">Move to Archive</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top" width="0"><img src='../images/user_go.png' border=0 alt='Move to Hired'></td>
                                                                        <td valign="top" align="left">On Trial</td>
                                                                        <td>&nbsp;</td>
                                                                        <td valign="top" width="0"><img src='../images/documentsorcopy16.png' border=0 alt='Move to Archived List'></td>
                                                                        <td valign="top" align="left">Contract Page Set</td>
                                                                    </tr>                                                                    
                                                                    <tr><td colspan="5">&nbsp;</td></tr>                                                                        
                                                                    <tr>
                                                                        <td colspan="3"><strong>Calendar</strong></td>
                                                                        <td colspan="2"><strong>Job Order</strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top"><img src='../images/calendar_ico.png' border=0 alt='Calendar'></td>
                                                                        <td valign="top">Setup Schedule</td>
                                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td valign="top" width="0"><img src='../images/flag_red.gif' border='0'></td>
                                                                        <td valign="top">With Job Order Details</td>
                                                                    </tr>
                                                                </table>
                                                                
                                                        
													</td>
												</tr> 
                                
                                </table>
                            </div>
                    </tr>
                </table>

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
                                    <td align="right" colspan="11"> { $pages } </td>
                                </tr>
								<tr>
                                    <td bgcolor="#FFFFFF" style="border-right: #006699 2px solid;" colspan="2"></td>
                                    <td width="10%" align="left" valign="top"><font color="#FFFFFF"><strong>Applicant&nbsp;&nbsp;</strong></font></td>
                                    <td width="6%" align="left" valign="top"><font color="#FFFFFF"><strong>Facilitator&nbsp;&nbsp;</strong></font></td>
                                    <td width="8%" align="left" valign="top"><font color="#FFFFFF"><strong>Interview&nbsp;Schedule&nbsp;&nbsp;</strong></font></td>
                                    <td width="8%" align="left" valign="top"><font color="#FFFFFF"><strong>Alternative<br/>Interview&nbsp;Schedule&nbsp;&nbsp;</strong></font></td>
                                    <td width="9%" align="left" valign="top"><font color="#FFFFFF"><strong>Time&nbsp;Zone<br/>of&nbsp;Interview&nbsp;&nbsp;</strong></font></td>
                                    <td width="8%" align="left" valign="top"><font color="#FFFFFF"><strong>Status/Payment</strong></font></td>
                                    <td width="6%" align="left" valign="top"><font color="#FFFFFF"><strong>Service Type</strong></font></td>
									<td width="8%" align="left" valign="top"><font color="#FFFFFF"><strong>Date Requested / Date Updated</strong></font></td>    
									<td width="15%" align="left" valign="top"><font color="#FFFFFF"><strong>Feedback</strong></font></td>    
									
									<td width="10%" align="left" valign="top"><font color="#FFFFFF"><strong>Notes</strong></font></td>    
									             		              
								</tr>
                                
								{ $report_listings }
                                	
                                <tr bgcolor="#FFFFFF">
                                	<td></td>
                                    <td align="right" colspan="11"> { $pages } </td>
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

<!--START: asl alarm-->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!--ENDED: asl alarm-->


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
<div id="add-feedback-dialog" style="display: none">
	<p>Please add a feedback about the interview between <span id='feedback_client_name'></span> and <span id='feedback_staff_name'></span></p>
	<form class="add_feedback_form">
		<input type="hidden" name="request_for_interview_id" id="feedback_request_for_interview_id"/>
		<table border="0" width="100%">
			<tr>
				<td width="10%"><label>Feedback</label></td>
				<td width="90%"><textarea rows="10" name="feedback" style="width:95%"></textarea></td>
			</tr>
		</table>
	</form>
</div>
<div id="view-feedback-dialog" style="display:none"></div>
</body>
</html>
