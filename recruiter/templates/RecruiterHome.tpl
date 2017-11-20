{*
//  2012-05-21  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   added back the return schedule
//  -   removed agai the return schedule
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
2010-04-07  Roy Pepito <roy.pepito@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Recruiter Home { $recruiter_full_name }</title>

<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">

<!--calendar picker - setup-->
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script type="text/javascript" src="../js/ajax.js"></script>
<script language=javascript src="js/staff_public_functions.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="js/RecruiterHome.js"></script>
<script type="text/javascript" src="../leads_information/media/js/tabber.js"></script>
</head>

<body style="margin-top:0; margin-left:0">

{php}include("header.php"){/php}
{php}include("recruiter_top_menu.php"){/php}
<input type="hidden" id="reload" value="">
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
        
        	<!--<div align="right">Welcome Recruiter <?php echo $admin['admin_fname']." ".$admin['admin_lname'];?></div>-->
            
            <!--START: sub title-->
            <h1 align="left">&nbsp;Recruiter Home Page</h1>
            <!--ENDED: sub title-->            
            
            
            <form action="" method="get">
            <div align="center">
            <table width="80%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                        <table width="100%">
                        	<tr>
                            	<td><span><strong>Advance Search</strong></span></td>
                                <td align="right"><span style='width:150px;color:#ff0000;text-align:right;cursor:pointer;' id='label_str' onClick="show_hide_search('search_box','label_str');">[Show]</span></td>
                            </tr>
                        </table>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td>
                            <!--<table width="100%" style='display:none;' id='search_box' border="0" bgcolor="#F5F5F5" cellpadding="10" cellspacing="10">-->
                            <table width="100%" id='search_box' border="0" bgcolor="#F5F5F5" cellpadding="10" cellspacing="10">
                                <tr>
                                    <td>
                                    
                                    
															<table width="0" border="0" cellpadding="0">
                                                              <tr>	
                                                                <td colspan="5">
                                                                
                                                                
                                                                    <table width="0"  border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                      </tr>	
                                                                      <tr>
                                                                        <td>
																			
                                                                            <table>
                                                                            	<tr>
                                                                                	<td colspan="2"></td><td><font size="1">Date From</font></td>
                                                                                </tr>
                                                                                <tr>
                                                                                	<td>Date&nbsp;Between&nbsp;</td>
                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" /></td>
                                                                                    <td>
                                                                                    <input type="text" name="search_date1" id="search_date1" class="text" value="{ $search_date1 }" readonly="readonly" {if $search_date_check eq on} disabled="disabled" {/if} >
                                                                                    { $search_date_requested1 }
                                                                                    </td>
                                                                                </tr>
                                                                            </table>                                                                          </td>
                                                                         <td>
                                                                            <table>
                                                                            	<tr>
                                                                                	<td></td><td align="left"><font size="1">Date To</font></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" /></td>
                                                                                    <td>
                                                                                    <input type="text" name="search_date2" id="search_date2" class="text" value="{ $search_date2 }" readonly="readonly" {if $search_date_check eq on} disabled="disabled" {/if} >
                                                                                    { $search_date_requested2 }
                                                                                    </td>
                                                                                </tr>
                                                                            </table> 
                                                                        </td>  
                                                                        <td>
                                                                        	<table>
                                                                            	<tr>
                                                                                	<td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><!--&nbsp;Any--></td>																	
                                                                                    <td><!--<input type="checkbox" id="search_date_check" name="search_date_check" onClick="javascript: search_date_check_function(this); " {if $search_date_check eq on} checked="checked" {/if} style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>--></td>
                                                                                    <td>&nbsp;&nbsp;</td>
                                                                                    <td><input type="submit" name="registered_advance_search" value="SEARCH" /></td>                                                                      
                                                                                </tr>
                                                                            </table>
                                                                        </td>                                                                                                                                           
                                                                      </tr>
                                                                    </table>
                                                                
                                                                
                                                                
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
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_info td_la"><font color="#FF0000"><strong>NOTE: </strong></font>The report below is for the dates above. It is defaulted to show you reports between the first day of the current month and today. Update the dates above to view reports for other dates. </td>
                                </tr>                                
                            </table>                     
                    </td>
                </tr>
            </table>
            </div>
            </form>
            <br />            
            
            <div align="center">
				<table width=98% cellpadding=3 cellspacing="3" border=0>
                	<tr>
                    	<td align="left">
                            <div class="tabber">
                                <div ID='popup_report' align="center" style='POSITION: Absolute; border: dashed ; overflow:hidden; background: #FFF; height:330px; width: 740px; VISIBILITY: HIDDEN '></DIV>
                                <!--start: view all notes-->
                                <div class="tabbertab">
                                    <h2>Candidate Status</h2>
                                    <div id="candidate_status">
                                    	<table width=98% cellpadding=3 cellspacing="0" border=0>
                                            <tr>
                                                <td class="td_info td_la" width="2%">#</td>
                                                <td class="td_info td_la" width="15%">Recruiter</td>
                                                <td class="td_info td_la" width="50" align="center">TNC</td>
                                                <td class="td_info td_la" width="15%" align="center">Unprocessed</td>
                                                <td class="td_info td_la" width="15%" align="center">Pre-Screened</td>
                                                <td class="td_info td_la" width="15%" align="center">Inactive</td>
                                                <td class="td_info td_la" style="background:#DDDDDD;" width="10%" align="center">Shortlisted</td>
                                                <td class="td_info td_la" style="background:#DDDDDD;" width="10%" align="center">Endorsed</td>
                                                <td class="td_info td_la" style="background:#DDDDDD;" width="10%" align="center">Categorized</td>
                                               <td class="td_info td_la" width="15%" align="center">Candidate&nbsp;Status&nbsp;Total</td>
                                            </tr> 
                                           <!--- start new candidate status report --->
										   {foreach from=$recruiters item=recruiter key=number}
										   <tr>
                                                <td class="td_info td_la">{$number}</td> 
                                                <td class="td_info">{$recruiter.fname} {$recruiter.lname}</td>
                                                <td class="td_info" align="center" style="text-decoration:underline;cursor:pointer;" onclick="show_popup_report('{$search_date1}','{$search_date2}',{$recruiter.id},'TNC')">({$recruiter.tnc})</td>
                                                <td class="td_info" align="center" style="text-decoration:underline;cursor:pointer;" onclick="show_popup_report('{$search_date1}','{$search_date2}',{$recruiter.id},'unprocessed')">{$recruiter.unprocessed}</td>
                                                <td class="td_info" align="center" style="text-decoration:underline;cursor:pointer;" onclick="show_popup_report('{$search_date1}','{$search_date2}',{$recruiter.id},'pre_screened')">{$recruiter.prescreened}</td>
                                                <td class="td_info" align="center" style="text-decoration:underline;cursor:pointer;" onclick="show_popup_report('{$search_date1}','{$search_date2}',{$recruiter.id},'inactive_staff')">{$recruiter.inactive}</td>
                                                <td class="td_info" style="text-decoration:underline;cursor:pointer;background:#DDDDDD;" align="center" style="text-decoration:underline;cursor:pointer;" onclick="show_popup_report('{$search_date1}','{$search_date2}',{$recruiter.id},'shortlisted')">{$recruiter.shortlisted}</td>
                                                <td class="td_info" style="text-decoration:underline;cursor:pointer;background:#DDDDDD;" align="center"  style="text-decoration:underline;cursor:pointer;" onclick="show_popup_report('{$search_date1}','{$search_date2}',{$recruiter.id},'endorsed')">{$recruiter.endorsed}</td>
                                                <td class="td_info" style="text-decoration:underline;cursor:pointer;background:#DDDDDD;" align="center" style="text-decoration:underline;cursor:pointer;" onclick="show_popup_report('{$search_date1}','{$search_date2}',{$recruiter.id},'asl')">{$recruiter.onasl}</td>
                                               <td class="td_info" align="center">{$recruiter.total_status}</td>
                                            </tr>
										   {/foreach} 
										   
										   <tr>
                                                <td class="td_info td_la">&nbsp;</td> 
                                                <td class="td_info">{$totals.fname}</td>
                                                <td class="td_info" align="center">{$totals.tnc}</td>
                                                <td class="td_info" align="center">{$totals.unprocessed}</td>
                                                <td class="td_info" align="center">{$totals.prescreened}</td>
                                                <td class="td_info" align="center">{$totals.inactive}</td>
                                                <td class="td_info"  style="background:#DDDDDD;" align="center">{$totals.shortlisted}</td>
                                                <td class="td_info"  style="background:#DDDDDD;" align="center">{$totals.endorsed}</td>
                                                <td class="td_info"  style="background:#DDDDDD;" align="center">{$totals.onasl}</td>
                                                <td class="td_info" align="center">{$totals.total_status}</td>
                                            </tr>

										   
                                           <!--- end new candidate status report --->	   
										</table>
                                    </div>
                                </div>
                                <!--ended: view all notes-->
                                
                                <!--start: admin notes-->
                                <div class="tabbertab">
                                    <h2>Interview Requests</h2>
                                    <div id="interview_request">
                                    	<table width=100% cellpadding=3 cellspacing="0" border=0>
                                            <tr>
                                                <td class="td_info td_la" width="2%">#</td>
                                                <td class="td_info td_la" width="25%">Recruiter</td>
                                                <td class="td_info td_la" width="50" align="center">TNC</td>
                                                <td class="td_info td_la" width="25%" align="center">Custom</td>
                                                <td class="td_info td_la" width="25%" align="center">ASL</td>
                                                <td class="td_info td_la" width="20%" align="center">Interview&nbsp;Requests&nbsp;Total</td>
                                            </tr> 
                                            { $interview_request_report }
										</table>                                  
                                    </div>
                                </div>
                                <!--ended: admin notes-->            
                                
                                <!--start: recruiters notes-->
                                <div class="tabbertab">
                                    <h2>Hired Staff</h2>
                                    <div id="hired_staff">
                                    	<table width=100% cellpadding=3 cellspacing="0" border=0>
                                            <tr>
                                                <td class="td_info td_la" width="2%">#</td>
                                                <td class="td_info td_la" width="20%">Recruiter</td>
                                                <td class="td_info td_la" width="50" align="center">TNC</td>
                                                <td class="td_info td_la" width="15%" align="center">Trial Staff</td>
                                                <td class="td_info td_la" width="15%" align="center">ASL Staff</td>
                                                <td class="td_info td_la" width="15%" align="center">Custom Staff</td>
                                                <td class="td_info td_la" width="15%" align="center">%Hired</td>
                                                <td class="td_info td_la" width="15%" align="center">Hired&nbsp;Staff&nbsp;Total</td>
                                            </tr> 
                                            { $hired_staff_report }
										</table>                                  
                                    </div>
                                </div>
                                <!--ended: recruiters notes-->            
                                    
                                <!--start: evaluation notes-->
                                <div class="tabbertab">
                                    <h2>Drop Outs</h2>
                                    <div id="drop_outs">
                                    	<table width=100% cellpadding=3 cellspacing="0" border=0>
                                            <tr>
                                                <td class="td_info td_la" width="2%">#</td>
                                                <td class="td_info td_la" width="15%">Recruiter</td>
                                                <td class="td_info td_la" width="50" align="center">TNC</td>
                                                <td class="td_info td_la" width="10%" align="center">Initial </td>
                                                <td class="td_info td_la" width="10%" align="center">ASL </td>
                                                <td class="td_info td_la" width="10%" align="center">Custom </td>
                                                <td class="td_info td_la" width="10%" align="center">First Day </td>
                                                
                                                <td class="td_info td_la" width="10%" align="center">Resigned</td>
                                                <td class="td_info td_la" width="10%" align="center">Terminated</td>
                                                <td class="td_info td_la" width="10%" align="center">Replacement</td>
                                                
                                                <td class="td_info td_la" width="10%" align="center">Drop&nbsp;Outs&nbsp;Total</td>
                                            </tr> 
                                            { $drop_outs_report }
										</table>                                  
                                    </div>
                                </div>
                                <!--ended: evaluation notes-->
                                
                            </div>
                        </td>
					</tr>
				</table>
            </div>
            
        </td>
	</tr>
</table>

{php}include("footer.php"){/php}

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
        
        {php}include("applicationsleftnav.php"){/php}
        
</DIV>
<!--ENDED: left nav. container -->

</DIV>
</body>
</html>