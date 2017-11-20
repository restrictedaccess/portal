{*
2011-08-11  Roy Pepito <roy.pepito@remotestaff.com.au>
*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Endorse to Client</title>
<link rel=stylesheet type=text/css href="/portal/css/font.css">
<link rel=stylesheet type=text/css href="/portal/menu.css">
<link rel=stylesheet type=text/css href="/portal/adminmenu.css">
<link rel=stylesheet type=text/css href="/portal/leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="/portal/category/category.css">
<link rel=stylesheet type=text/css href="/portal/leads_information/media/css/leads_information.css">

<script type="text/javascript" src="/portal/js/ajax.js"></script>
<script type="text/javascript" src="/js/admin-endorse-to-client.js"></script>
<script type="text/javascript" src="/portal/js/jquery.js"></script>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
	<tr>
		<td width=100% valign=top >
			<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
				<tr>
					<td width="86%" valign="top" align="left">
							
							<form name="form" method="post" action="?userid={ $userid }" onSubmit="return validate(this)">
                            <input type="hidden" id="position" name="position" value="" />
                            <input type="hidden" id="job_category" name="job_category" value="" />
                            <table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
                              <tr>
                                <td height="32" colspan="2" valign="middle">
                                  <table width="100%">
                                    <tr>
                                      <td colspan="3" height="24">
                                      
                                      			<!--START: search lead-->
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
                                                <!--ENDED: search lead-->                                    

                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="11%" height="28">Lead ID</td>
                                      <td width="1%">:</td>
                                      <td width="88%">
										<input type="text" id="search_lead_id" name="search_lead_id" value="{ $search_lead_id }" >
										<input type="button" name="browse_lead_id" value="Browse Lead" onClick="javascript: show_popup_report(); " >
                                        <font color="#FF0000" size="1">Click on the Browse Lead button to search a lead</font>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="11%" height="28" valign="top">CC</td>
                                      <td width="1%" valign="top">:</td>
                                      <td width="88%" valign="top"><input type="text" id="cc" name="cc" value="{ $cc }" style="width:50%" /></td>
                                    </tr>        
                                    <tr>
                                      <td width="11%" height="28">Subject</td>
                                      <td width="1%">:</td>
                                      <td width="88%"><input type="text" id="subject_id" name="subject" value="{ $subject }" style="width:50%"></td>
                                    </tr>  
                                    <tr>    
                                      <td width="11%" height="28" valign="top">Job&nbsp;Advertisement&nbsp;[<a href="javascript: show_job_position_report(); ">Refresh</a>]</td>
                                      <td width="1%" valign="top">:</td>
                                      <td width="88%" valign="top"><div id="job_position_report" align="center" style='overflow-y:scroll; height:120px; width: 100%; overflow-x:hidden '></div></td>
                                    </tr>  
                                    <tr>    
                                      <td width="11%" height="28" valign="top">Job&nbsp;Category&nbsp;[<a href="javascript: show_job_category_report(); ">Browse</a>]</td>
                                      <td width="1%" valign="top">:</td>
                                      <td width="88%" valign="top"><div id="job_category_report" align="center" style='overflow-y:scroll; height:120px; width: 100%; overflow-x:hidden '><font color="#FF0000" size="1">(This will be use when the lead has no Active or Current Job Advertisement)</font></div></td>
                                    </tr>                                     
                                    <tr>
                                      <td colspan="3">
                                        <div id="client_details" >&nbsp;</div>
                                      </td>
                                    </tr>
                                    
                                    <tr>
                                    	<div id="endorse-listings">
                                    		<table width="100%" cellpadding="3" cellspacing="3"></table>
                                    	</div>
                                    </tr>
                                    <tr>
                                      <td colspan="3">
                                      	<table width="100%"><tr><td valign="bottom">Insert Notes to Lead Message(optional)</td>
                                        	<td align="right">
                                            	<font color="#FF0000" size="1">
                                                What you see on the Preview Resume page is the identical to the view of the lead. <br />
                                                Ensure that all information are correct and sensitive data are not added. 
                                              </font><br />
                                                <a href="javascript: resume_checker('AdminResumeChecker/ResumeChecker.html?userid={ $userid }'); ">Admin Resume Checker</a>&nbsp;&nbsp;&nbsp;<a href="javascript: open_popup_resume({ $userid }); ">Preview Resume</a>
										  </td>
										</tr></table>
                                      </td>
                                    </tr>          
                                    <tr>
                                      <td colspan="3">
                                      <textarea name="body_message" cols="48" rows="7" wrap="physical" style="width:100%">{ $body_message }</textarea>
                                      </td>
                                    </tr>        
                                    <tr>
                                      <td colspan="3"><INPUT type="submit" value="Send" name="send" style="width:120px"></td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" valign="top"></td>
                              </tr>
                            </table>
                            </form>


					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
 
</body>
</html>

