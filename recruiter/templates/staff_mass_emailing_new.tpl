{*
2011-08-15  Roy Pepito <roy.pepito@remotestaff.com.au>
*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Recruiter View</title>
 
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">

<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<script type="text/javascript" src="../leads_information/media/js/tabber.js"></script>

<script type="text/javascript" src="category/category.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="../js/functions.js"></script>

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="js/staff_mass_emailing_new.js"></script>

</head>
 
<body style="margin-top:0; margin-left:0">

{literal}
	<script type="text/x-handlebars-template" id="application_interested">
		<div style="text-align: center">
			<div style="margin:auto;text-align:left;width:800px;background:url({{base}}/portal/recruiter/images/color_side.png) repeat-y transparent;overflow: hidden;display:block!important">
				<div style="float:left;width:74px;display:block!important">&nbsp;</div>
				<div style="float:left;width:726px;">
					<div style="float:left;background:url({{base}}/portal/recruiter/images/cloud_top.png) no-repeat transparent;width:726px;height:228px;display:block!important"></div>
					<div style="float:left;clear:both;padding-left:41px;">
						<p style="margin-bottom:22px;font-family:Arial, Helvetica, sans-serif;font-size:28px;line-height:120%;color:rgb(123,123,123);text-align:left;">Dear {{firstname}} {{lastname}},</p>
						<p style="margin-bottom:22px;font-family:Arial, Helvetica, sans-serif;font-size:16px;text-align:left;">Your resume is currently profiled on our available staff list at <a href="http://www.remotestaff.com.au" target="_blank">www.remotestaff.com.au</a>. It's important that we only market your resume and profile you on our website if you are still actively seeking work at the moment.</p>
						<p style="margin-bottom:22px;font-family:Arial, Helvetica, sans-serif;font-size:16px;text-align:left;">We would like to check if you are still interested and actively looking for a home based career opportunity.</p>
						<p style="margin-bottom:22px;font-family:Arial, Helvetica, sans-serif;font-size:16px;text-align:left;">If yes, you are re-confirming that you are truly committed to building a home based career with Remote Staff Clients,</p>
						
						<div style="height:70px;position:relative;background:url({{base}}/portal/recruiter/images/refresh.png) no-repeat transparent;width:616px;z-index:1;padding-left:69px;color:#ffffff;font-family:Arial, Helvetica, sans-serif;font-size:15px;text-align:left;padding-top:8px;">
							Please {{click_here_link_auto_log}} to update your resume. <br/>This will  allow us to asses and match you accordingly to our {{current_job_openings_link}}. 
						</div>
						<div style="height:70px;position:relative;background:url({{base}}/portal/recruiter/images/refresh.png) no-repeat transparent;width:616px;z-index:1;padding-left:69px;color:#ffffff;font-family:Arial, Helvetica, sans-serif;font-size:15px;text-align:left;padding-top:8px;">
							If NO, please {{click_here_link_mark_inactive}}.<br/>We will remove your resume from our website.
						</div>
						<p style="margin-bottom:22px;font-family:Arial, Helvetica, sans-serif;font-size:16px;text-align:left;">If you want to receive a phone call from us to update your resume on your behalf, please reply to this email asking us to do so along with your most recent and active contact number or call anytime between 9 am to 4pm.</p>
						<p style="margin-bottom:22px;font-family:Arial, Helvetica, sans-serif;font-size:16px;text-align:left;">This email has been sent to you because you have applied on our website <a href="http://www.remotestaff.com.ph" target="_blank">www.remotestaff.com.ph</a> last {{date_registered}}.</p>
						<p style="margin-bottom:44px;font-family:Arial, Helvetica, sans-serif;font-size:16px;text-align:left;">Best regards,</p>
						<p style="margin-bottom:22px;font-family:Arial, Helvetica, sans-serif;font-size:16px;text-align:left;">Remote Staff Recruitment<br/>Recruitment Hotline: 09479959825<br/>Email: recruitment@remotestaff.com.au</p>
						
						
					</div>
				</div>
			</div>
			
		</div>
		
	</script>
{/literal}


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
        <td valign="top" width="100%" align="center">
<!--ENDED: left nav.-->

            
<!--START: sub title-->
<h1 align="left">&nbsp;&nbsp;Mass Emailing</span></h1>
<!--ENDED: sub title-->            
            

<!--START: search function-->
				<table width=98% cellpadding=3 cellspacing="3" border=0>
                	<tr>
                    	<td width=100% colspan=2>
                            
                            
                            <div class="tabber">
                                
                                <!--start: view all notes-->
                                <div class="tabbertab">
                                    <h2>Waiting</a></h2>
                                    <div id="waiting_items_div">{ $waiting_items }</div>
                                </div>
                                <!--ended: view all notes-->
                                
                                <!--start: recruiters notes-->
                                <div class="tabbertab">
                                    <h2>Sent Items</h2>
                                    <div id="sent_items_div">{ $sent_items }</div>
                                </div>
                                <!--ended: recruiters notes-->            

                            </div>
                            
                            
                        </td>
					</tr>
                    <tr>
                        <td width=100% colspan=2>
                        	<form method="POST" name="form" enctype="multipart/form-data">
                        	<B>Subject :</B>
                        	<input type="text" style="width:100%" name="subject" id="subject" />
                        	<b>Template: </b>
                        	<select name="template" id="template_selector">
                        		<option value="blank">Blank Template</option>
                        		<option value="your_job_application">Do we still profile your resume on our Remote Staff website</option>
                        		
                        	</select><br/>
							<B>Message :</B>
							<div id="message_wrapper" style="width:100%;border:1px solid gray;height:118px;overflow-y:scroll"><div></div></div>
							<input type="hidden" name="message" id="message"/>
                            <div id="action_div"><INPUT type="button" value="send" name="send" style="width:120px" onclick="javascript: send_now(this.form); "></div>
                        	</form>
                        </td>
                    </tr>  
                    <tr>
                    	<td width="100%" colspan="2">
                            <table id="active_sent_items_report">
                              <tr>
                                <td colspan="2"><div id="sending_icon"></div></td>
                              </tr>
                              <tr><td width="0"></td><td width="100%"></td></tr>
                            </table>                        
                        </td>
                    </tr>
				</table>
<!--ENDED: search function-->            
            

<!--START: listings-->
        </td>
	</tr>
</table>
<!--ENDED: listings-->


</td>
</tr>
</table>

{php} include("footer.php") {/php}

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
