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
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="../js/functions.js"></script>

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="js/staff_mass_emailing.js"></script>

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
							<B>Message :</B>
							<textarea name="message" id="message" cols="48" rows="7" wrap="physical" style="width:100%"></textarea>
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
