<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Case Management Report</title>

<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script language=javascript src="js/staff_csro_report.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>

</head>
<body style="margin-top:0; margin-left:0">

{php}include("header.php"){/php}
{php}include("recruiter_top_menu.php"){/php}

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
        
           
        <!--START: sub title-->
        <h1 align="left">&nbsp;{ $name } <span class="leads_id">#{ $userid }</span></h1>
        <!--ENDED: sub title-->
        
        
        <!--START: result-->
        <center>
        <table width=98% cellpadding=3 cellspacing="3" border=0>
        <tr>
            <td width=100% colspan=2>
                <div class="subtab">
                    <ul>
                        <li id="cp"><a href="staff_information.php?userid={ $userid }"><span>Candidate's Profile Manager</span></a></li>
                        <li id="csro"><a href="staff_csro_report.php?userid={ $userid }"><span>CSRO Report</span></a></li>
						<li id="cm" class="selected"><a href="staff_case_report.php?userid={ $userid }"><span>Case Management</span></a></li>
                    </ul>
                </div> 
            </td>
        </tr>
        {*<tr>
            <td width=100% colspan=2>
                <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                        <input type="button" class="button" value="ASL Staff Checker" onClick="javascript: asl_checker('tools/AvailableStaffChecker/AvailableStaffChecker.html'); "/>
                        <input type="button" class="button" value="Bank Accounts" onClick="javascript: bank_accounts({ $userid }); "/>
                    </div>
                </div>		
            </td>
        </tr>*}
        </table>
        </center>
		<!--ENDED: result-->
                        
                 
		<!--START: file report-->
		<br /><div align="center">
		
		<iframe id='casesframe' name='casesframe' frameborder='0' src='/portal/ticketmgmt/ticket.php?/index/open/&userid={$userid}'
	scrolling="auto" style='width:100%;height:500px;float:left;'></iframe>

		</div>
        <!--ENDED: file report-->
            
            
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
