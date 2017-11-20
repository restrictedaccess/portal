<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
.btspot {color:#900; padding-bottom:1px; border-bottom:1px dotted #900; cursor:pointer}
#bt {position:absolute; display:block; background:url(/portal/bubblehelp/images/bt_left.gif) top left no-repeat}
#bttop {display:block; height:5px; margin-left:5px; background:url(/portal/bubblehelp/images/bt_top.gif) top right no-repeat; overflow:hidden}
#btcont {display:block; padding:2px 12px 3px 11px; background:#FF8301; color:#FFF;}
#btbot {display:block; height:5px; ; background:url(/portal/bubblehelp/images/bt_bottom.gif) top right no-repeat; overflow:hidden}
#task-status {  position:fixed;  width:300px;  height: auto;  top:0;  margin-left:-150px; z-index: 999;  font-size:12px; font-weight:bold;
  background:#ffff00;  padding-left:5px;  text-align:center;  display:none;  left:50%;}
</style><style type="text/css">
.btspot {color:#900; padding-bottom:1px; border-bottom:1px dotted #900; cursor:pointer}
#bt {position:absolute; display:block; background:url(/portal/bubblehelp/images/bt_left.gif) top left no-repeat}
#bttop {display:block; height:5px; margin-left:5px; background:url(/portal/bubblehelp/images/bt_top.gif) top right no-repeat; overflow:hidden}
#btcont {display:block; padding:2px 12px 3px 11px; background:#FF8301; color:#FFF;}
#btbot {display:block; height:5px; ; background:url(/portal/bubblehelp/images/bt_bottom.gif) top right no-repeat; overflow:hidden}
#task-status {  position:fixed;  width:300px;  height: auto;  top:0;  margin-left:-150px; z-index: 999;  font-size:12px; font-weight:bold;
  background:#ffff00;  padding-left:5px;  text-align:center;  display:none;  left:50%;}
</style><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Recruiter View (Help Page) (Help Page)</title>

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
<link rel=stylesheet type="text/css" href="/portal/bubblehelp/pullmenu.css" />
<link rel=stylesheet type="text/css" href="/portal/ticketmgmt/css/overlay.css" />
<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>
<div id='boxdiv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:390px;padding:3px;border:1px solid #011a39;'>
	<div class='title'>Edit Help Content - <span id='blink'></span></div>
		
		<form name='regform' method='POST' target='ajaxframe' action='/portal/bubblehelp/bhelp.php?/set_data/' style='padding:0;margin:0;'>
			<input type='hidden' name='link_id' id='link_id' />
            <input type='hidden' name='item' id='item' value='new'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<!--<tr><td class='form1'>Subject:</td>
				<td class='form2'><input type="text" id="email_subject" name="email_subject" value="Remotestaff: Client-Staff Support" class="inputbox2"/></td>
			</tr>-->
			  
			  <tr><td class='form2'>Enter text here:</td></tr>
			<tr><td class='form2'><textarea id="help_content" name='help_content' class='text' rows='5' style='width:95%;float:left;'></textarea></td></tr>
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type='submit' class='button' id='createbutton' value='Edit'> <input type='button' class='button' value='Cancel' onClick="document.getElementById('boxdiv').style.display='none';">
			</tr>
		  </table>
		</form>
	</div>
	
</div>
<link rel=stylesheet type="text/css" href="/portal/bubblehelp/pullmenu.css" />
<link rel=stylesheet type="text/css" href="/portal/ticketmgmt/css/overlay.css" />
<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>
<div id='boxdiv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:390px;padding:3px;border:1px solid #011a39;'>
	<div class='title'>Edit Help Content - <span id='blink'></span></div>
		
		<form name='regform' method='POST' target='ajaxframe' action='/portal/bubblehelp/bhelp.php?/set_data/' style='padding:0;margin:0;'>
			<input type='hidden' name='link_id' id='link_id' />
            <input type='hidden' name='item' id='item' value='new'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<!--<tr><td class='form1'>Subject:</td>
				<td class='form2'><input type="text" id="email_subject" name="email_subject" value="Remotestaff: Client-Staff Support" class="inputbox2"/></td>
			</tr>-->
			  
			  <tr><td class='form2'>Enter text here:</td></tr>
			<tr><td class='form2'><textarea id="help_content" name='help_content' class='text' rows='5' style='width:95%;float:left;'></textarea></td></tr>
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='button' id='createbutton' value='Edit'> <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='button' value='Cancel' onClick="document.getElementById('boxdiv').style.display='none';">
			</tr>
		  </table>
		</form>
	</div>
	
</div>

<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<link rel=stylesheet type=text/css href="/portal/css/overlay.css">
<script type="text/javascript" src="../timezones/cheatclock.php"></script>
<script type="text/javascript" src="/portal/bugreport/pullmenu.js"></script>
<link rel=stylesheet type=text/css href="/portal/seatbooking/css/pullmenu.css">
<script type="text/javascript" src="../js/functions.js"></script>
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF;">
<tr>
	<td colspan="2">
	<table width="100%">
	<tr>
	<td width="4%" valign="middle"><img src="../images/flags/Philippines.png" align="middle" title="Philippines/Manila" /></td>
	<td width="18%" valign="middle"><b>Manila</b> <span id="manila"></span></td>
	<td width="4%"valign="middle"><img src="../images/flags/Australia.png" align="absmiddle" title="Australia/Sydney" /></td>
	<td width="20%" valign="middle"> <b>Sydney</b> <span id="sydney"></span></td>
	<td width="4%" valign="middle"><img src="../images/flags/usa.png" align="absmiddle" title="USA/San Francisco" /></td>
	<td width="26%" valign="middle"><b>San Francisco</b> <span id="sanfran"></span><br /> 
	  <b>New York</b> <span id="newyork"></span></td>
	<td width="4%" valign="middle"><img src="../images/flags/uk.png" align="absmiddle" title="UK/London" /> </td>
	<td width="20%"><b>London</b> <span id="london"></span> </td>
	</tr>
	</table>	</td>
</tr>

<tr><td valign="top" >
<img src="../images/remote-staff-logo2.jpg" alt="think" >
</td>

<td align="right" valign="bottom">
<div align="right"><img src='../images/remote-staff-country-active-AUS.jpg' border='0'><a href="http://www.remotestaff.co.uk/portal/request_for_interview.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img border="0" onmouseout=this.src="../images/remote-staff-country-inactive-UK.jpg" onmouseover=this.src="../images/remote-staff-country-active-UK.jpg" src="../images/remote-staff-country-inactive-UK.jpg"></a><a href="http://www.remotestaff.biz/portal/request_for_interview.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img border="0" onmouseout=this.src="../images/remote-staff-country-inactive-US.jpg" onmouseover=this.src="../images/remote-staff-country-active-US.jpg" src="../images/remote-staff-country-inactive-US.jpg"></a>
</div>
<!--
<iframe id="frame" name="frame" width="100%" height="100%" src="notes.php" frameborder="0" scrolling="no">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
-->
<div style="padding:5px; color:#666666;">
<a href="javascript:popup_win8('..\/rschat.php?portal=1&email=ricag@remotestaff.com.au&hash=x4ea5c3f15a95ec022',700,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  style='text-decoration:none;color:#666666;' title='Open remostaff chat'>Chat</a> | 	| <a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=recruiter/request_for_interview.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="text-decoration:none;color:#666666;" title="Open Help Page" >Help Page</a>
	| <a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="showReportMenu(this)" onmouseout="mclosetime()" style='text-decoration:none;color:#666666;'>Bug Report</a>
	| <a href="https://dokuwiki.remotestaff.com.au/dokuwiki/doku.php?sectok=14dcf38ef2a8ae387a13d1ca4e620a59&u=user&p=RemotE&do=login&id=start" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style='text-decoration:none;color:#666666;' title="Open the Wiki page"  class="hlink">Wiki</a>
	<a href="../logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  style="text-decoration:none;color:#666666;">Logout</a>
</div>

</td>

</tr>
</table>
<div id="overlay"> <div> <p>You will be logged in to RemoteStaff Chat.</p>
	<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='submit' value='&nbsp; OK &nbsp;' onclick='void(1);' /></div> </div>

<script type='text/javascript'>
function void(clicked) {
	el = document.getElementById("overlay");
	el.style.display = (!el.style.display || el.style.display == "none") ? "block" : "none";
	if (clicked == 1) {
		popup_win8('/portal/rschat.php?email=ricag@remotestaff.com.au',800,600);
	}
	return false;
}
connect(window, 'onload', function() { void(0); });
</script>
<!-- /HEADER -->



<div style="float:right; padding-right:10px;"><a href="admin_profile.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link10">Administrator Profile</a></div>
<div style="clear:both;"></div>
<div style="background:url(../images/remote-staff-nav-bg2.jpg); height:40px;">
<div id="glossymenu">
<ul>

  <li><a href="/portal/recruiter/recruiter_home.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Home</a></li>
  <li><a href="../adminHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Admin</a></li>  <li><a href="/portal/recruiter/recruiter_search.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id='homenav'>View All</a></li>  
  <li><a href="/portal/recruiter/recruiter_search.php?staff_status=UNPROCESSED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Unprocessed</a></li>
  <li><a href="/portal/recruiter/recruiter_search.php?staff_status=REMOTEREADY" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Remote Ready</a></li>
  <li><a href="/portal/recruiter/recruiter_search.php?staff_status=PRESCREENED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Pre-Screened</a></li>
  <li><a href="/portal/recruiter/recruiter_search.php?staff_status=INACTIVE" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Inactive</a></li>  
  <li><a href="/portal/recruiter/recruiter_search.php?staff_status=SHORTLISTED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Shortlisted</a></li>
  <li><a href="/portal/recruiter/recruiter_search.php?staff_status=ENDORSED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Endorsed</a></li>
  <li><a href="/portal/recruiter/recruiter_staff_manager.php?on_asl=0" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Categorized</a></li>
  <li><a href="/portal/recruiter/recruiter_test_reports.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Test Takers</a></li>
  <li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Trial</a></li>
  <li><a href="/portal/django/subcontractors/subcons/active" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >List of Subcon</a></li>

</ul>
</div>
</div>
<div style="text-align: right;width:100%;margin-bottom:-30px">
	<a href="/portal/recruiter/guides_for_pay_rates.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="color:red;text-decoration:none;font-weight:bold;display:inline-block;margin-top:10px;">Guide to Pay Rates</a>
</div>



<!--START: left nav.-->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  >
	<tr>
        <td valign="top" style="border-right: #006699 2px solid;">
            <div id='applicationsleftnav'>
                <table>
                    <tr>
                        <td background="images/open_left_menu_bg.gif">
                            <a href="javascript: applicationsleftnav_show(); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="images/open_left_menu.gif" border="0" /></a>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td valign="top" width="100%">
<!--ENDED: left nav.-->

            
<!--START: sub title-->
<h1 align="left">&nbsp;Interview Bookings Report</h1>
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
                                                                        <form id="filter-form" action="?service_type=" method="GET" name="formtable">
                                                                        <table width="0%"  border="0" cellspacing="3" cellpadding="3">
                                                                            <tr>
                                                                                <td></td>
                                                                                <td><font size="1"><strong>Staff/Client</strong>(First&nbsp;Name&nbsp;/Last&nbsp;Name&nbsp;/ID/&nbsp;Voucher)</font></td>							  
                                                                            </tr>								
                                                                            <tr>
                                                                                <td>	  
                                                                                    <strong>Keyword</strong><em>(optional)</em>
                                                                                </td>
                                                                                <td><input type="text" id="key_id" name="key" value="" class="select" /></td>							  
                                                                            </tr>
                                                                            <tr>
																				<td scope="row"><font color="#000000"><strong>Date Requested Between</strong></font></td>
                                                                                <td>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_requested1" id="id_date_requested1" class="text" value="Any">
																									
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_requested1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
                                        
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_requested2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_requested2" id="id_date_requested2" class="text" value="Any">
																									
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_requested2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
                                       
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
                                                                                                    <input type="text" name="date_updated1" id="id_date_updated1" class="text" value="2014-10-24">
																									
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_updated1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_updated1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
                                        
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_updated2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_updated2" id="id_date_updated2" class="text" value="2014-11-24">
																									
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_updated2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_updated2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
                                       
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
                                                                                                    <input type="text" name="date_interview_sched1" id="id_date_interview_sched1" class="text" value="Any">
																									
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_interview_sched1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_interview_sched1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
   
																									<select name="time_interview_sched_1">
                                                                                                    	<option value="">Any</option>
                                                                                                    	                                                                                                    			                                                                                                    		<option value="00:00">12:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="00:30">12:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="01:00">01:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="01:30">01:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="02:00">02:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="02:30">02:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="03:00">03:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="03:30">03:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="04:00">04:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="04:30">04:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="05:00">05:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="05:30">05:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="06:00">06:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="06:30">06:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="07:00">07:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="07:30">07:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="08:00">08:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="08:30">08:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="09:00">09:00 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="09:30">09:30 AM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="10:00">10:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="10:30">10:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="11:00">11:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="11:30">11:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="12:00">12:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="12:30">12:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="13:00">01:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="13:30">01:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="14:00">02:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="14:30">02:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="15:00">03:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="15:30">03:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="16:00">04:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="16:30">04:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="17:00">05:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="17:30">05:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="18:00">06:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="18:30">06:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="19:00">07:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="19:30">07:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="20:00">08:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="20:30">08:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="21:00">09:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="21:30">09:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="22:00">10:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="22:30">10:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="23:00">11:00 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    			                                                                                                    		<option value="23:30">11:30 PM</option>
                                                                                                    		                                                                                 
                                                                                                    		
                                                                                                    	                                                                                                    </select>                                     
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><img align="absmiddle" src="../../images/date-picker.gif" id="date_interview_sched2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                                    <td>
                                                                                                    <input type="text" name="date_interview_sched2" id="id_date_interview_sched2" class="text" value="Any">
																									
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_interview_sched2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_interview_sched2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
      
                                                                                                    <select name="time_interview_sched_2">
                                                                                                    	<option value="">Any</option>
                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="00:00">12:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="00:30">12:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="01:00">01:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="01:30">01:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="02:00">02:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="02:30">02:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="03:00">03:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="03:30">03:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="04:00">04:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="04:30">04:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="05:00">05:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="05:30">05:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="06:00">06:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="06:30">06:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="07:00">07:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="07:30">07:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="08:00">08:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="08:30">08:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="09:00">09:00 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="09:30">09:30 AM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="10:00">10:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="10:30">10:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="11:00">11:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="11:30">11:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="12:00">12:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="12:30">12:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="13:00">01:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="13:30">01:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="14:00">02:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="14:30">02:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="15:00">03:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="15:30">03:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="16:00">04:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="16:30">04:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="17:00">05:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="17:30">05:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="18:00">06:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="18:30">06:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="19:00">07:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="19:30">07:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="20:00">08:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="20:30">08:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="21:00">09:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="21:30">09:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="22:00">10:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="22:30">10:30 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="23:00">11:00 PM</option>
   		                                                                                             
   		                                                                                                 	                                                                                                    		                                                                                                    	   		                                                                                                 		<option value="23:30">11:30 PM</option>
   		                                                                                             
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
                                                                                        																							<option value='INTERVIEW NOW'>INTERVIEW NOW</option>
																							<option value='BOOK INTERVIEW'>BOOK INTERVIEW</option>
                                                                                            <option value='' selected>ANY</option>
																						  
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
                                                                                                                                                                                	<option value='ANY'>Any</option>
																							<option value='PAID'>Paid</option>
																							<option value='PENDING'>Pending</option>
																							<option value='VOUCHER'>Voucher</option>
																						  
                                                                                      </select>
                                                                                </td>							
                                                                            </tr>    
                                                                            -->                                
                                                                            <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Interview Status</strong></font></td>
                                                                                <td>
                                                                                      <select size="1" class="text" name="status">
                                                                                           
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
																						                                                                                      </select>
                                                                                </td>							
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Service Type</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="service_type" id="service_type">
                                                                                     	<option value='ANY'>ANY</option><option value='ASL'>ASL</option><option value='CUSTOM'>CUSTOM</option>
                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                            <tr>
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Facilitator</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="admin" id="admin_filter">
                                                                                     	<option value='ALL'>All</option><option value='242'>Charrie Japis</option><option value='167'>Honey Lapidario</option><option value='236'>Rona Hermida</option>
                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                            
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Recruiter</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="recruiter" id="admin_filter">
                                                                                     	<option value="">All</option>
                                                                                     	                                                                                     		                                                                                     			<option value="125">Aaron James Marie Cruz</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="213">Andrew  	 Hiponia</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="140">Angela Clemente</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="242">Charrie Japis</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="153">Gail Guina</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="167">Honey Lapidario</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="231">Ian Grazon Espiritu</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="264">Ivan Bryan Aureus</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="212">Jen Millarez</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="100">Liz dela Cuesta</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="274">Ma. Claudine  Delgado</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="262">Notch Pery</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="201">Paulo Jose Sangalang</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="238">Raquel Mendiola</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="236">Rona Hermida</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="209">Rosemarie Lozada</option>
                                                                                     		                                                                                     	                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                              <tr>
                                                                                <td scope="row"><font color="#000000"><strong>Staffing Consultant</strong></font></td>
                                                                                <td>
                                                                                     <select size="1" class="text" name="hm" id="admin_filter">
                                                                                     	<option value="">All</option>
                                                                                     	                                                                                     		                                                                                     			<option value="232">Czarina  Espiritu</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="235">Edward  Coloma Jr.</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="247">Erwin Mercado</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="134">Former  Hiring Managers </option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="269">Jan Michael Saturnino</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="258">Jashen Montiadora</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="246">Je Ann Villanueva</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="252">Jen Nikka Dapitin</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="245">Jescel Cortez</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="267">John Steven   Azogue</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="251">Louie Martin  Benares</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="180">Marie Shanelle Paldeng</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="265">Petra Jay</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="16">PJ Boromeo</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="6">Rica Gil</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="266">Robert Brian  Patag</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="95">Rowena Nalda</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="94">Thurice Marie Payawal</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="91">Vernie Lissa Martinez</option>
                                                                                     		                                                                                     	                                                                                     		                                                                                     			<option value="233">Veronica    Chen</option>
                                                                                     		                                                                                     	                                                                                     </select>
                                                                                 </td>
                                                                            </tr>
                                                                            
                                                                            
                                                                            <tr>
                                                                                <td></td><td valign="top"><font color="#000000"><input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" id="search" value="Search" name="submit" class="button">									
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
                                    <td align="right" colspan="11"> 1-20 of 1713&nbsp;&nbsp;&nbsp;|&nbsp;<a href="?service_type=&booking_type=&payment_status=&date_requested2=Any&date_requested1=Any&date_updated1=Any&date_updated2=Any&status=NEW&key=&max=1713&p=2&date_interview_sched1=&date_interview_sched2=&time_interview_sched_1=&time_interview_sched_2=" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><font color="#000000">Next</font></a>&nbsp&nbsp&nbsp&nbsp </td>
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
                                
									
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>1</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(3580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">David Cheang</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10628" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10628" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(73674,3580,10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10628"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(73674,3580,10628); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(73674); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Raiza Fatima Sangalang</a> <br/><br/><a href="/portal/Ad.php?id=3031' target='_blank' style='color:#000;font-weight:bold'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-24<br />
								11:00 am<br/><br/>
								<strong>2014-11-24<br/>09:00 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Brisbane<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10628">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Louie Martin  Benares</td></tr></table>
                            </td>
                            <td align="left" valign="top">CUSTOM</td>
							<td align="left" valign="top">2014-11-21 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10628'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10628' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10628'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='3580' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10628'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>2</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(10992); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jarrod Greenwood</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10627" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10627" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(78902,10992,10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10627"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(78902,10992,10627); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(78902); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Melanie Lariosa</a> <br/><br/><a href="/portal/Ad.php?id=3015' target='_blank' style='color:#000;font-weight:bold'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Bookeeper</a>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-20<br />
								2:00 pm<br/><br/>
								<strong>2014-11-20<br/>11:00 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10627">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Je Ann Villanueva</td></tr></table>
                            </td>
                            <td align="left" valign="top">CUSTOM</td>
							<td align="left" valign="top">2014-11-19 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10627'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10627' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10627'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='10992' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10627'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>3</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(7320); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Michael O'Sullivan</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10615" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10615" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(38312,7320,10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10615"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(38312,7320,10615); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(38312); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Porfirio Cinco</a> <br/><br/>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-19<br />
								1:00 pm<br/><br/>
								<strong>2014-11-19<br/>10:00 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10615">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Rowena Nalda</td></tr></table>
                            </td>
                            <td align="left" valign="top">CUSTOM</td>
							<td align="left" valign="top">2014-11-19 /2014-11-19</td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10615'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10615' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value='1422'/><input type='hidden' name='request_for_interview_id' value='10615'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'>CUSTOM</span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'>13,000.00</span></li><li><strong>Charge Out</strong> <span class='chargeout-label'> $533.33</span></li><li><strong>Currency</strong> <span class='currency-label'>AUD</span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'>2014-11-21</span></li><li><strong>Status</strong> <span class='status-label'>Part Time</span></li><li><strong>Client Schedule</strong> <span class='schedule-label'>10:00am - 02:00pm Australia/Sy</span></li><li><strong>Designation</strong> <span class='designation-label'>Graphic Designer</span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>Yes,  2014-11-19</span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>Yes,  2014-11-19</span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'>2014-11-19</span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='7320' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10615'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>4</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(11058); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Simone Penrose</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10616" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10616" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(103442,11058,10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10616"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(103442,11058,10616); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(103442); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lee Dapatnapo</a> *<br/><br/><a href="/portal/Ad.php?id=3030' target='_blank' style='color:#000;font-weight:bold'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a>
							</td>
							<td align="left" valign="top">&nbsp;-&nbsp;Vernie Lissa Martinez<br /></td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-20<br />
								11:30 am<br/><br/>
								<strong>2014-11-20<br/>09:30 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Brisbane<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10616">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Vernie Lissa Martinez</td></tr></table>
                            </td>
                            <td align="left" valign="top">CUSTOM</td>
							<td align="left" valign="top">2014-11-19 /2014-11-21</td>
							<td align="left" valign="top"><ul style='padding-left:10px;'><li id='feedback_3074' style='overflow:hidden;max-height:6em;line-height:1.5em;margin-bottom:10px;max-width:200px;word-wrap:break-word'><a href="/portal/recruiter/view_interview_feedback.php?id=3074' class='view_feedback' style='color:#333;text-decoration:none'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">what we need is barely simple. All that we need to know is that they speak well to be able to do our...&nbsp;&nbsp;<a href="/portal/recruiter/delete_interview_request_feedback.php?id=3074' class='delete_interview_feedback' data-id='3074'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Delete</a></a></li></ul><button class='button add-feedback' data-interview-id='10616'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10616' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value='1423'/><input type='hidden' name='request_for_interview_id' value='10616'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'>CUSTOM</span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'>13000.00</span></li><li><strong>Charge Out</strong> <span class='chargeout-label'>553.33</span></li><li><strong>Currency</strong> <span class='currency-label'>AUD</span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'>2014-11-26</span></li><li><strong>Status</strong> <span class='status-label'>Part Time</span></li><li><strong>Client Schedule</strong> <span class='schedule-label'>9am Bris</span></li><li><strong>Designation</strong> <span class='designation-label'>Marketing Assistant</span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>Yes,  2014-11-21</span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'>yes</span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='11058' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10616'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>5</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(11071); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Christine Edwards</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10609" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10609" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(97502,11071,10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10609"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(97502,11071,10609); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(97502); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marilou   Pitlo</a> <br/><br/><span style='font-weight:bold;color:#333'>Article Writing</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-19<br />
								10:00 am<br/><br/>
								<strong>2014-11-19<br/>10:00 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								10:30 am
							</td>							
							<td align="left" valign="top">Asia/Singapore<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10609">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-17 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10609'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10609' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10609'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='11071' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10609'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>6</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(11071); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Christine Edwards</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10610" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10610" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(87486,11071,10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10610"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(87486,11071,10610); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(87486); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Angeline Lyn Rodriguez</a> <br/><br/><span style='font-weight:bold;color:#333'>Article Writing</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-19<br />
								11:00 am<br/><br/>
								<strong>2014-11-19<br/>11:00 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								12:00 pm
							</td>							
							<td align="left" valign="top">Asia/Singapore<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10610">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-17 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10610'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10610' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10610'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='11071' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10610'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>7</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(11071); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Christine Edwards</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10611" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10611" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(50250,11071,10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10611"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(50250,11071,10611); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(50250); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lanessa Cago</a> <br/><br/><span style='font-weight:bold;color:#333'>Article Writing</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-19<br />
								3:30 pm<br/><br/>
								<strong>2014-11-19<br/>03:30 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								4:00 pm
							</td>							
							<td align="left" valign="top">Asia/Singapore<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10611">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-17 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10611'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10611' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10611'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='11071' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10611'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>8</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(5182); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew Jackson</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10594" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10594" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(47913,5182,10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10594"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(47913,5182,10594); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(47913); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">arnel marco</a> <br/><br/><span style='font-weight:bold;color:#333'>.NET Framework</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								9:00 am<br/><br/>
								<strong>2014-11-18<br/>05:00 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								9:00 am
							</td>							
							<td align="left" valign="top">Europe/London<br />www.remotestaff.co.uk
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10594">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-16 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10594'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10594' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10594'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='5182' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10594'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>9</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(5182); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew Jackson</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10595" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10595" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(99268,5182,10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10595"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(99268,5182,10595); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(99268); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Arvee Jay Gamay</a> <br/><br/><span style='font-weight:bold;color:#333'>Software Application Development</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								10:00 am<br/><br/>
								<strong>2014-11-18<br/>06:00 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								10:00 am
							</td>							
							<td align="left" valign="top">Europe/London<br />www.remotestaff.co.uk
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10595">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-16 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10595'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10595' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10595'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='5182' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10595'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>10</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(5182); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew Jackson</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10596" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10596" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(101796,5182,10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10596"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(101796,5182,10596); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(101796); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Joey Aldrin Cruz</a> <br/><br/><span style='font-weight:bold;color:#333'>Software Application Development</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								10:30 am<br/><br/>
								<strong>2014-11-18<br/>06:30 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								10:30 am
							</td>							
							<td align="left" valign="top">Europe/London<br />www.remotestaff.co.uk
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10596">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-16 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10596'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10596' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10596'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='5182' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10596'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>11</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(5182); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew Jackson</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10597" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10597" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(98854,5182,10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10597"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(98854,5182,10597); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(98854); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Analiza Villaranda</a> <br/><br/><span style='font-weight:bold;color:#333'>Software Application Development</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								11:00 am<br/><br/>
								<strong>2014-11-18<br/>07:00 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								11:00 am
							</td>							
							<td align="left" valign="top">Europe/London<br />www.remotestaff.co.uk
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10597">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-16 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10597'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10597' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10597'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='5182' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10597'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>12</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(5182); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew Jackson</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10598" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10598" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(95742,5182,10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10598"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(95742,5182,10598); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(95742); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Rudy Marie Ilo</a> <br/><br/><span style='font-weight:bold;color:#333'>Software Application Development</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								11:30 am<br/><br/>
								<strong>2014-11-18<br/>07:30 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								11:30 am
							</td>							
							<td align="left" valign="top">Europe/London<br />www.remotestaff.co.uk
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10598">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-16 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10598'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10598' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10598'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='5182' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10598'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>13</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(5182); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew Jackson</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10601" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10601" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(96973,5182,10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10601"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(96973,5182,10601); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(96973); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ray Gerard Pelobello</a> <br/><br/><span style='font-weight:bold;color:#333'>.NET Framework</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								1:30 pm<br/><br/>
								<strong>2014-11-18<br/>09:30 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								1:30 pm
							</td>							
							<td align="left" valign="top">Europe/London<br />www.remotestaff.co.uk
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10601">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-16 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10601'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10601' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10601'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='5182' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10601'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>14</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(5182); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew Jackson</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10602" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10602" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(69678,5182,10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10602"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(69678,5182,10602); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(69678); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Francis   Tolentino</a> <br/><br/><span style='font-weight:bold;color:#333'>.NET Framework</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								2:00 pm<br/><br/>
								<strong>2014-11-18<br/>10:00 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-19<br />
								2:00 pm
							</td>							
							<td align="left" valign="top">Europe/London<br />www.remotestaff.co.uk
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10602">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-16 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10602'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10602' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10602'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='5182' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10602'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>15</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(11062); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kate Vagg</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10593" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10593" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(90768,11062,10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10593"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(90768,11062,10593); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(90768); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Magnolia May Afable</a> <br/><br/><span style='font-weight:bold;color:#333'>Marketing Assistance</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-18<br />
								1:00 pm<br/><br/>
								<strong>2014-11-18<br/>10:00 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-18<br />
								2:30 pm
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10593">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-15 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10593'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10593' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10593'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='11062' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10593'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>16</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(10719); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Peter Taylor</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10580" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10580" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(33004,10719,10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10580"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(33004,10719,10580); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(33004); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kristine Raralio</a> <br/><br/><a href="/portal/Ad.php?id=2969' target='_blank' style='color:#000;font-weight:bold'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-13<br />
								3:00 pm<br/><br/>
								<strong>2014-11-13<br/>12:00 pm <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10580">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Veronica    Chen</td></tr></table>
                            </td>
                            <td align="left" valign="top">CUSTOM</td>
							<td align="left" valign="top">2014-11-12 /2014-11-13</td>
							<td align="left" valign="top"><ul style='padding-left:10px;'><li id='feedback_3047' style='overflow:hidden;max-height:6em;line-height:1.5em;margin-bottom:10px;max-width:200px;word-wrap:break-word'><a href="/portal/recruiter/view_interview_feedback.php?id=3047' class='view_feedback' style='color:#333;text-decoration:none'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kristine seems to have a high level experience. Im afraid the task is too process driven for her....&nbsp;&nbsp;<a href="/portal/recruiter/delete_interview_request_feedback.php?id=3047' class='delete_interview_feedback' data-id='3047'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Delete</a></a></li><li id='feedback_3048' style='overflow:hidden;max-height:6em;line-height:1.5em;margin-bottom:10px;max-width:200px;word-wrap:break-word'><a href="/portal/recruiter/view_interview_feedback.php?id=3048' class='view_feedback' style='color:#333;text-decoration:none'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kristine seems to have a high level experience. Im afraid the task is too process driven for her....&nbsp;&nbsp;<a href="/portal/recruiter/delete_interview_request_feedback.php?id=3048' class='delete_interview_feedback' data-id='3048'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Delete</a></a></li></ul><button class='button add-feedback' data-interview-id='10580'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10580' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10580'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='10719' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10580'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>17</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(10779); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">shanelle smiths(dummy)</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10569" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10569" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(96396,10779,10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10569"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(96396,10779,10569); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(96396); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Erwin Marquis Mercado</a> <br/><br/>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-12<br />
								4:45 am<br/><br/>
								<strong>2014-11-12<br/>01:45 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10569">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Marie Shanelle Paldeng</td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-12 /2014-11-12</td>
							<td align="left" valign="top"><ul style='padding-left:10px;'><li id='feedback_3025' style='overflow:hidden;max-height:6em;line-height:1.5em;margin-bottom:10px;max-width:200px;word-wrap:break-word'><a href="/portal/recruiter/view_interview_feedback.php?id=3025' class='view_feedback' style='color:#333;text-decoration:none'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Please disregard this booking. For Training purposes only. ...&nbsp;&nbsp;<a href="/portal/recruiter/delete_interview_request_feedback.php?id=3025' class='delete_interview_feedback' data-id='3025'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Delete</a></a></li></ul><button class='button add-feedback' data-interview-id='10569'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10569' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10569'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='10779' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10569'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>18</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(10779); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">shanelle smiths(dummy)</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10571" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10571" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(96396,10779,10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10571"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(96396,10779,10571); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(96396); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Erwin Marquis Mercado</a> <br/><br/><a href="/portal/Ad.php?id=2694' target='_blank' style='color:#000;font-weight:bold'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-13<br />
								11:15 am<br/><br/>
								<strong>2014-11-13<br/>08:15 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10571">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Marie Shanelle Paldeng</td></tr></table>
                            </td>
                            <td align="left" valign="top">CUSTOM</td>
							<td align="left" valign="top">2014-11-12 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10571'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10571' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10571'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='10779' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10571'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#E4E4E4">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>19</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(10779); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">shanelle smiths(dummy)</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10570" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10570" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(8651,10779,10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10570"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(8651,10779,10570); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(8651); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Maricar Barbosa</a> <br/><br/><a href="/portal/Ad.php?id=3021' target='_blank' style='color:#000;font-weight:bold'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-14<br />
								8:45 am<br/><br/>
								<strong>2014-11-14<br/>05:45 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								0000-00-00<br />
								
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10570">NEW</div></td></tr><tr><td valign=top><strong>-</strong></td><td>Marie Shanelle Paldeng</td></tr></table>
                            </td>
                            <td align="left" valign="top">CUSTOM</td>
							<td align="left" valign="top">2014-11-12 /2014-11-12</td>
							<td align="left" valign="top"><ul style='padding-left:10px;'><li id='feedback_3026' style='overflow:hidden;max-height:6em;line-height:1.5em;margin-bottom:10px;max-width:200px;word-wrap:break-word'><a href="/portal/recruiter/view_interview_feedback.php?id=3026' class='view_feedback' style='color:#333;text-decoration:none'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Please disregard this booking. Created for training purposes only....&nbsp;&nbsp;<a href="/portal/recruiter/delete_interview_request_feedback.php?id=3026' class='delete_interview_feedback' data-id='3026'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Delete</a></a></li></ul><button class='button add-feedback' data-interview-id='10570'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10570' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10570'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='10779' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10570'>Edit Notes</button></td>
							
						  </tr>	
						  <tr bgcolor="#F5F5F5">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>20</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead(11044); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kim Foster</a> <br>
										</td>
									</tr>
									<tr>
										<td>
												<table>
													<tr>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=NEW&id=10531" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/back.png' border=0 alt='Move to Active List'></a></td>-->
														<td><a href="javascript: update_status('ARCHIVED',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/forward.png' border=0 alt='Move to Archived List'></a></td>
														<!--<td><a href="?key=&date_requested1=&date_requested2=&status=NEW&stat=ON-HOLD&id=10531" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/userlock16.png' border=0 alt='Move to On Hold'></a></td>-->
														<td><a href="javascript: update_status('HIRED',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/adduser16.png' border=0 alt='Move to Hired'></a></td>
														<td><a href="javascript: update_status('REJECTED',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/deleteuser16.png' border=0 alt='Move to Rejected'></a></td>
														
														<td><a href="javascript: update_status('YET TO CONFIRM',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/yet-to-confirm.gif' border=0 alt='Move Yet to confirm'></a></td>
														<td><a href="javascript: update_status('CONFIRMED',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/confirmed.gif' border=0 alt='Move to Confirmed'></a></td>
														<td><a href="javascript: update_status('DONE',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/scheduled.gif' border=0 alt='Move to Done, waiting for approval'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status('ON TRIAL',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/user_go.png' border=0 alt='On Trial'></a></td>
														<td><a href="javascript: update_status('CHATNOW INTERVIEWED',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/documentsorcopy16.png' border=0 alt='Contract Page Set'></a></td>
														<td><a href="javascript: rescheduled(96819,11044,10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src='../images/re-scheduled.gif' border=0 alt='Re-Scheduled'></a></td>
														<td><a href="javascript: update_status('CANCELLED',10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="cancelled" data-id="10531"><img src='../images/edit.gif' border=0 alt='Cancel'></a></td>
														
														
														<td><a href="javascript: meeting_calendar(96819,11044,10531); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top"><a href="javascript: resume(96819); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kathleen Ruth Dumajel</a> <br/><br/><span style='font-weight:bold;color:#333'>Internet Marketing</span>
							</td>
							<td align="left" valign="top">None</td>                            
							<td align="left" valign="top">
								BOOK INTERVIEW<br />
								2014-11-08<br />
								10:00 am<br/><br/>
								<strong>2014-11-08<br/>07:00 am <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								2014-11-09<br />
								10:00 am
							</td>							
							<td align="left" valign="top">Australia/Sydney<br />www.remotestaff.com.au
                            </td>
                            <td align="left" valign="top"><table><tr><td valign=top><strong>-</strong></td><td><div id="status_details_10531">NEW</div></td></tr></table>
                            </td>
                            <td align="left" valign="top">ASL</td>
							<td align="left" valign="top">2014-11-06 </td>
							<td align="left" valign="top"><ul style='padding-left:10px;'></ul><button class='button add-feedback' data-interview-id='10531'>Add Feedback</button></td>
							<td align="left" valign="top"><div class='notes_wrapper'><div id='notes_10531' class='notes-container'><form class='notebox-form'><input type='hidden' name='id' value=''/><input type='hidden' name='request_for_interview_id' value='10531'/><ul class='notebox'><li><strong>Service Type</strong> <span class='contract-label'></span></li><li><strong>Staff Rate</strong> <span class='staffrate-label'></span></li><li><strong>Charge Out</strong> <span class='chargeout-label'></span></li><li><strong>Currency</strong> <span class='currency-label'></span></li><li><strong>GST</strong> <span class='gst-label'>Yes</span></li><li><strong>Start Date</strong> <span class='startdate-label'></span></li><li><strong>Status</strong> <span class='status-label'></span></li><li><strong>Client Schedule</strong> <span class='schedule-label'></span></li><li><strong>Designation</strong> <span class='designation-label'></span></li><li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>No </span></li><li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>No </span></li><li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'></span></li><li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'></span></li><input type='hidden' value='11044' name='leads_id'/></ul></form></div></div><a href="#' class='view-more-minimize' data-state='more'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='10531'>Edit Notes</button></td>
							
						  </tr>
                                	
                                <tr bgcolor="#FFFFFF">
                                	<td></td>
                                    <td align="right" colspan="11"> 1-20 of 1713&nbsp;&nbsp;&nbsp;|&nbsp;<a href="?service_type=&booking_type=&payment_status=&date_requested2=Any&date_requested1=Any&date_updated1=Any&date_updated2=Any&status=NEW&key=&max=1713&p=2&date_interview_sched1=&date_interview_sched2=&time_interview_sched_1=&time_interview_sched_2=" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><font color="#000000">Next</font></a>&nbsp&nbsp&nbsp&nbsp </td>
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

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: url(../images/bg1.gif); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " colspan="2" >&nbsp;</td></tr>
<tr><td valign="top" >
Copyright © 2008 Think Innovations Pty Ltd<br />
<a href="http://remotestaff.com.au/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  class="link10" title="Outsourcing Online Staff from the Philippines">REMOTESTAFF.COM.AU</a>
</td><td valign="top" align="right"><font size="1"><a href="../logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link10">Agent/Client/Sub-Contractor login</a></font></td></tr>
<tr><td colspan="2" valign="top" align="right"><img src="../images/Small-Logo2.jpg" alt="Think Innovations" align="middle" /></td></tr>
</table>


<!--START: asl alarm-->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!--ENDED: asl alarm-->


<!--START: left nav. container -->
<DIV ID='applicationsleftnav_container' STYLE='POSITION: Absolute; RIGHT: 50px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table width="100%">
	<tr>
		<td align="right" background="images/close_left_menu_bg.gif">
        	<a href="javascript: applicationsleftnav_hide(); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="images/close_left_menu.gif" border="0" /></a>
		</td>
	</tr>
</table>


<style type="text/css">
/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */


#markermenu{
width: 230px; /*width of menu*/
}
#markermenu ul{
list-style-type: none;
margin: 5px 0;
padding: 0;
width:220px;
}
#markermenu li a{
font: bold 11px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: #00014e;
display: block;
padding: 3px 0;
padding-left: 20px;
text-decoration: none;
border: 3px solid #E7F0F5;
margin-top:2px;
height:40px;
}

#markermenu li a:visited, #markermenu ul li a:active{
color: #00014e;
}

#markermenu li a:hover{
color: black;
background:#ffffcb url(../images/arrow-list-red.gif) no-repeat left ;
}

#markermenu li a:active{
background:#ffffcb;
}
#markermenu li a:focus{
background:#ffffcb;
}

* html #markermenu li a{ /*IE only. Actual menu width minus left padding of LINK (20px) */
margin-bottom:0px;
margin-top:0px;
}
#dropmenudiv{
position:absolute;
background-color: #E3FFB0;
border:1px solid black;
border-bottom-width: 0;
font:normal 12px Verdana;
line-height:18px;
z-index:100;
}

#dropmenudiv a{
width: 100%;
display: block;
text-indent: 3px;
border-bottom: 1px solid black;
padding: 1px 0;
text-decoration: none;
font-weight: bold;
}

#dropmenudiv a:hover{ /*hover background color*/
background-color: #C7FF5E;
}

/* Sample CSS definition for the example list. Remove if desired */
.navlist li {
list-style-type:georgian;
width: 170px;
background-color: #0099FF;
}

</style>
<script type="text/javascript">
<!-- Begin
function setVariables() {
if (navigator.appName == "Netscape") {
v=".top=";
dS="document.";
sD="";
y="window.pageYOffset";
}
else {
v=".pixelTop=";
dS="";
sD=".style";

y="document.body.scrollTop";

   }
}
function checkLocation() {
object="object1";
yy=eval(y);
eval(dS+object+sD+v+yy);
setTimeout("checkLocation()",10);
//alert (v);
}
//  End -->

/***********************************************
* AnyLink Vertical Menu- ï¿½ Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var disappeardelay=250  //menu disappear speed onMouseout (in miliseconds)
var horizontaloffset=2 //horizontal offset of menu from default location. (0-5 is a good value)

/////No further editting needed

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
document.write('<div id="dropmenudiv" style="visibility:hidden;width: 160px" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function open_calendar()
{
  window.open('/portal/meeting_calendar/','_blank','width=1024,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
  //window.open('/portal/application_calendar/popup_calendar.php?is_rescheduled=no&interview_id=ANY','_blank','width=900,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}

function showhide(obj, e, visible, hidden, menuwidth){
if (ie4||ns6)
dropmenuobj.style.left=dropmenuobj.style.top=-500
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=menuwidth
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
obj.visibility=visible
else if (e.type=="click")
obj.visibility=hidden
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=0
if (whichedge=="rightedge"){
var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x-obj.offsetWidth < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure+obj.offsetWidth
}
else{
var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move menu up?
edgeoffset=dropmenuobj.contentmeasure-obj.offsetHeight
if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either? (position at top of viewable window then)
edgeoffset=dropmenuobj.y
}
}
return edgeoffset
}

function populatemenu(what){
if (ie4||ns6)
dropmenuobj.innerHTML=what.join("")
}


function dropdownmenu(obj, e, menucontents, menuwidth){
if (window.event) event.cancelBubble=true
else if (e.stopPropagation) e.stopPropagation()
clearhidemenu()
dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
populatemenu(menucontents)

if (ie4||ns6){
showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+obj.offsetWidth+horizontaloffset+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+"px"
}

return clickreturnvalue()
}

function clickreturnvalue(){
if (ie4||ns6) return false
else return true
}

function contains_ns6(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function dynamichide(e){
if (ie4&&!dropmenuobj.contains(e.toElement))
delayhidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
delayhidemenu()
}

function hidemenu(e){
if (typeof dropmenuobj!="undefined"){
if (ie4||ns6)
dropmenuobj.style.visibility="hidden"
}
}

function delayhidemenu(){
if (ie4||ns6)
delayhide=setTimeout("hidemenu()",disappeardelay)
}

function clearhidemenu(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}
/////////////////////////
var timer;
function scrolltop()
{
document.getElementById('scrollmenu').style.top=(document.body.scrollTop+230) ;
timer=setTimeout("scrolltop()",1);
}
function stoptimer()
{
clearTimeout(timer);
}
</script>
<div id="markermenu" >
<ul>
<!--<li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, SELECT_CATEGORY, '270px')" onmouseout="delayhidemenu();"><img src="../images/folder_clip.gif" border="0" /> Position Categories</a></li>-->
<li><a href="../recruiter/staff_category_manager.php?stat=No Potential" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, NO_POTENTIAL, '270px')" onmouseout="delayhidemenu();"><img src="../images/icon-person.jpg" border="0" />&nbsp;ASL Categories</a></li>

<!--<li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, OPEN_POSSITION_APPLICATION, '270px')" onmouseout="delayhidemenu();"><img src="../images/textfile16.png" border="0" /> Open Position Application</a></li>-->

<!--<li><a href="../staff.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/attach.gif" border="0" /> Position Summary Report</a></li>-->

<!--<li><a href="recruiter_staff_manager.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/attach.gif" border="0" />&nbsp;ASL Candidate</a></li>-->

<!--<li><a href="../application_endorsement_summary_report.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/foldermove16.png" border="0" /> Endorsement Summary Report</a></li>-->

<!--<li><a href="../application_shortlisted_report.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/stats16.png" border="0" /> Shortlisted Applicants</a></li>-->

<!--<li><a href="../top_10_applicants.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/groupofusers16.png" border="0" /> Top 10 Applicants</a></li>-->

<li><a href="/portal/recruiter/request_for_interview.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Interview Bookings</a></li>
<li><a href="/portal/recruiter/recruiter_job_orders_view_summary.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Recruiter Job Order Summary</a></li>
<li><a href="/portal/recruiter/recruitment_sheet.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Recruitment Sheet</a></li>
<li><a href="/portal/recruiter/new_recruitment_sheet.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Recruitment Sheet - Recruiter View</a></li>
<li><a href="/portal/recruiter/recruitment_sheet_dashboard.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Recruitment Dashboard</a></li>
<li><a href="/portal/recruiter/recruitment_team_shortlists.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Recruitment Team Shortlists</a></li>

<li><a href="/portal/recruiter/recruitment_contract_dashboard.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Recruiters' New Hires Reporting </a></li>
<li><a href="/portal/recruiter/request_for_prescreen.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Request for Prescreen </a></li>
<li><a href="/portal/recruiter/referrals.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Refer a Friend Reports</a></li>
<li><a href="/portal/candidates/index.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Create Jobseeker Account</a></li>

<li><a href="/portal/recruiter/request_for_interview_voucher.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/adduser16.png" border="0" /> Voucher Manager</a></li>

<li><a href="/portal/recruiter/send_email_resume.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/email.gif" border="0" /> Send Email Resume</a></li>

<li><a href="/portal/recruiter/staff_mass_emailing.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/email.gif" border="0" /> Staff Mass Emailing</a></li>
<li><a href="/portal/sms/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"/><img src="../images/email.gif" border="0" /> SMS Logs</a></li>
<li><a href="javascript: open_calendar(); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseout="delayhidemenu();"><img src="../images/calendar_ico.png" border="0" /> Meeting Calendar</a></li>

<li><a href="/portal/recruiter/category-management.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseout="delayhidemenu();"><img src="../images/icon-person.jpg" border="0" /> Category Management</a></li>

<li><a href="/portal/recruiter/advertised_list.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseout="delayhidemenu();"><img src="../images/icon-person.jpg" border="0" /> Advertisement</a></li>
<li><a href="/portal/test_admin/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseout="delayhidemenu();" ><img src="../images/icon-person.jpg" border="0" /> Generate Test Session</a></li>
<li><a href="/portal/aclog/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseout="delayhidemenu();" ><img src="../images/calendar_ico.png" border="0" /> Activity Logger</a></li>
<!--
<li><a href="../admin_problems_and_issues.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img src="../images/undo16.png" border="0"/> Problems / Issues</a></li>
-->
</ul>

</div>



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
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/script.js"></script>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/pullmenu.js"></script>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/script.js"></script>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/pullmenu.js"></script>
</body>
</html>