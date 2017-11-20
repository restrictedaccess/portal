<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
</style><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Portal Administrator Home (Help Page)</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./system_wide_reporting/media/css/system_wide_reporting.css">
<link rel=stylesheet type=text/css href="./system_wide_reporting/media/css/tabber.css">
<script language=javascript src="./js/MochiKit.js"></script>
<script language=javascript src="./js/functions.js"></script>

<script type="text/javascript" src="./system_wide_reporting/media/js/system_wide_reporting.js"></script>
<script type="text/javascript" src="./system_wide_reporting/media/js/tabber.js"></script>


<script type="text/javascript" src="./js/calendar.js"></script> 
<script type="text/javascript" src="./lang/calendar-en.js"></script> 
<script type="text/javascript" src="./js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="./css/calendar-blue.css" title="win2k-1" />
<link rel=stylesheet type=text/css href="css/overlay.css">
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
	<div id="overlay"> <div> <p>You will be logged in to RemoteStaff Chat.</p>
	<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='submit' value='&nbsp; OK &nbsp;' onclick='void(1);' /></div> </div>
	
<FORM NAME="parentForm" method="post">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="timezones/cheatclock.php"></script>
<script type="text/javascript" src="/portal/bugreport/pullmenu.js"></script>
<link rel=stylesheet type=text/css href="/portal/seatbooking/css/pullmenu.css">
<style type="text/css">
a.hlink {text-decoration:none;color:#666666;}
</style>
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF;">
<tr>
	<td colspan="2">
	<table width="100%">
	<tr>
	<td width="4%" valign="middle"><img src="images/flags/Philippines.png" align="middle" title="Philippines/Manila" /></td>
	<td width="18%" valign="middle"><b>Manila</b> <span id="manila"></span></td>
	<td width="4%"valign="middle"><img src="images/flags/Australia.png" align="absmiddle" title="Australia/Sydney" /></td>
	<td width="20%" valign="middle"> <b>Sydney</b> <span id="sydney"></span></td>
	<td width="4%" valign="middle"><img src="images/flags/usa.png" align="absmiddle" title="USA/San Francisco" /></td>
	<td width="26%" valign="middle"><b>San Francisco</b> <span id="sanfran"></span><br /> 
	  <b>New York</b> <span id="newyork"></span></td>
	<td width="4%" valign="middle"><img src="images/flags/uk.png" align="absmiddle" title="UK/London" /> </td>
	<td width="20%"><b>London</b> <span id="london"></span> </td>
	</tr>
	</table>	</td>
</tr>

<tr><td valign="top" >
<img src="images/remote-staff-logo2.jpg" alt="think" >
</td>

<td align="right" >

<div align="right"><img src='images/remote-staff-country-active-AUS.jpg' border='0'><a href="http://www.remotestaff.co.uk/portal/adminHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img border="0" onmouseout=this.src="images/remote-staff-country-inactive-UK.jpg" onmouseover=this.src="images/remote-staff-country-active-UK.jpg" src="images/remote-staff-country-inactive-UK.jpg"></a><a href="http://www.remotestaff.net/portal/adminHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img border="0" onmouseout=this.src="images/remote-staff-country-inactive-US.jpg" onmouseover=this.src="images/remote-staff-country-active-US.jpg" src="images/remote-staff-country-inactive-US.jpg"></a>
</div>
<!--
<iframe id="frame" name="frame" width="100%" height="100%" src="notes.php" frameborder="0" scrolling="no">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
-->
<div style="padding:5px; color:#666666;">
<a href="javascript:popup_win8('.\/rschat.php?portal=1&email=lorelie@remotestaff.com.ph&hash=vb5807ecd8a42430c5',800,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  class='hlink' title='Open remostaff chat'>Chat</a> | 	<a href="logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="hlink">Logout</a> | <a href="logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="hlink" title="Login in Different Account">Login</a>
	| <a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=adminHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="hlink" title="Open Help Page" >Help Page</a>
| <a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="showReportMenu(this)" onmouseout="mclosetime()" class="hlink">Bug Report</a> | <a href="https://dokuwiki.remotestaff.com.au/dokuwiki/doku.php?sectok=14dcf38ef2a8ae387a13d1ca4e620a59&u=user&p=RemotE&do=login&id=start" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" title="Open the Wiki page"  class="hlink">Wiki</a></div>

</td>

</tr>
</table>

<!-- /HEADER -->


<div style="float:right; padding-right:10px;"><a href="admin_profile.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link10"  >Administrator Profile</a></div>
<div style="clear:both;"></div>
<div style="background:url(images/remote-staff-nav-bg2.jpg); height:40px;">
<div id="glossymenu">
<ul>

  <li><a href="adminHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id='homenav' >Home</a></li>
  <li><a href="recruiter/RecruiterHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Recruitment</a></li>
  <li><a href="leads.php?lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >New Leads <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Follow Up </a></li>
  <li><a href="leads.php?lead_status=asl" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >ASL <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Custom Recruitment <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Keep in Touch <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=pending" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Pending </a></li>
  <li><a href="leads-active.php?lead_status=Client&filter=ACTIVE" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Clients <img src='images/star.png' border='0'  ></a></li>
  <li><a href="adminscm.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Sub Contractor Management</a></li>
  <li><a href="subconlist.php' " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">List of Sub Contractors</a></li>
  <li><a href="/portal/ticketmgmt/' " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Cases</a></li>









</ul>
</div>
</div>
<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<tr><td width="18%" valign="top" style="border-right: #006699 2px solid;">

<style type="text/css">
/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */


#markermenu{

 width:auto;
}
#markermenu ul{
list-style-type: none;
padding: 0;
width:230px;
margin:5px;

}
#markermenu li {
   margin-bottom:5px;
   
   
}
#markermenu li a{
/*
font: bold 11px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: #00014e;
display: block;
padding: 3px 0;
padding-left: 20px;
text-decoration: none;
border: 3px solid #E7F0F5;
margin-top:2px;
height:30px;
line-height:30px;
*/
    border:#d0e8ff solid 1px;
    background: #e3f3ff;
    /* Mozilla: */
    background: -moz-linear-gradient(top, #FFFFFF, #d0e8ff);
	
    /* Chrome, Safari:*/
    background: -webkit-gradient(linear,
                left top, left bottom, from(#FFFFFF), to(#d0e8ff));
    /* MSIE */
    filter: progid:DXImageTransform.Microsoft.Gradient(
                StartColorStr='#FFFFFF', EndColorStr='#d0e8ff', GradientType=0);
				
	height:30px;
	line-height:30px;
	display:block;
	text-decoration:none;
   	border-left:#a6c8e1 solid 1px;
	border-right:#a6c8e1 solid 1px;

	padding-left:25px;
	padding-right:25px;
	text-align:center;
	color:#333333;			
}

#markermenu li img{
    float:left;
	
}



#markermenu li a:hover{
/*
color: black;
background:#ffffcb url(images/arrow-list-red.gif) no-repeat left ;
*/
background: #a6c8e1;
	/*background: #e3f3ff;*
    /* Mozilla: */
    background: -moz-linear-gradient(top, #FFFFFF, #a6c8e1);
	
    /* Chrome, Safari:*/
    background: -webkit-gradient(linear,
                left top, left bottom, from(#FFFFFF), to(#a6c8e1));
    /* MSIE */
    filter: progid:DXImageTransform.Microsoft.Gradient(
                StartColorStr='#FFFFFF', EndColorStr='#a6c8e1', GradientType=0);
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
border:1px solid #a6c8e1;
border-bottom-width: 0;
line-height:18px;
z-index:100;
-moz-box-shadow: 3px 3px 5px #666666;
    -webkit-box-shadow: 3px 3px 5px #666666;
    box-shadow: 3px 3px 5px #666666;
	font-family:tahoma;
	font-size:11px;
}

#dropmenudiv a{
width: 100%;
display: block;
text-indent: 3px;
border-bottom: 1px solid #a6c8e1;
padding: 1px 0;
text-decoration: none;
color:#333333;
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

//Contents for menu 1 USERS
var USERS=new Array()
USERS[0]='<a href="/portal/django/rsadmin/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Admin Account Users</a>'
USERS[1]='<a href="adminnaddagent.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Business Developer Management</a>'
USERS[2]='<a href="adminaffiliates.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Affiliates</a>'
USERS[3]='<a href="adminBPTransferLeads.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Business Developer Transfer Leads</a>'
USERS[4]='<a href="./recruitment_team/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Recruitment Team</a>'

//Contents for INVOICING
var INVOICING=new Array()
INVOICING[0]='<a href="/portal/invoice/StaffInvoiceMaintenance/StaffInvoiceMaintenance.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Sub-Contractors</a>'
INVOICING[1]='<a href="adminInvoicesForClient.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Clients</a>'
//INVOICING[2]='<a href="adminBPCommission.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Business Developer Commission</a>'
//INVOICING[3]='<a href="adminInvoicingForAff.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Affiliates</a>'
INVOICING[4]='<a href="payment_history.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Payments History</a>'
INVOICING[5]='<a href="admin_set_up_fee_invoice.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Set-Up Fee Invoice</a>'
INVOICING[6]='<a href="admin_create_quote.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Create a Quote</a>'
INVOICING[7]='<a href="admin_subcon_payment_details.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Sub-Contractors Bank Accounts</a>'
INVOICING[8]='<a href="invoice/IremitSenderMaintenance/IremitSenderMaintenance.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Sub-Contractors Iremit Sender</a>'
INVOICING[9]='<a href="admin_leads_invoice_payment.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Secure Pay/PayPal Payments</a>'
INVOICING[10]='<a href="admin_get_started.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recruitment Service Ordering</a>'
INVOICING[11]='<a href="/portal/django/commission/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" target="blank">Commissions</a>'
// TOOLS
var TOOLS=new Array() 
TOOLS[0]='<a href="admin_job_order.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Job Request/Order Form</a>'
TOOLS[1]='<a href="admin_testimonials.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Testimonials</a>'
TOOLS[2]='<a href="admin_comments_suggestion.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Comments &amp; Suggestions</a>'
TOOLS[3]='<a href="admin_subcon_updates.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Bulletin Board</a>'
TOOLS[4]='<a href="admin_promo_codes_monitoring.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Promo Codes Monitoring</a>'
TOOLS[5]='<a href="job_titles.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Job Titles Price Management</a>'
TOOLS[6]='<a href="seatbooking/seatb.php?/index/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >RS Office Seat Booking</a>'
TOOLS[7]='<a href="/portal/skillstest/apptest.php?/index/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Manage Skills Tests</a>'
TOOLS[8]='<a href="/portal/django/inhouse/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Inhouse Payment Settings</a>'
//TOOLS[9]='<a href="/skills_test/?/reports/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Skills Test Reports</a>'
//TOOLS[6]='<a href="inhouse.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Inhouse Team Management</a>'


var LEADS=new Array() 
LEADS[0]='<a href="AddUpdateLeads.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Add New Leads</a>'
//LEADS[1]='<a href="admin_prepaid_clients.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Prepaid Clients</a>'
//LEADS[2]='<a href="admininactiveList.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">No Longer a Prospect</a>'

var TRIAL = new Array()
TRIAL[0]='<a href="/adhoc/django/requested_time_slots_management/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Manage Trial Staff Candidates</a>'
TRIAL[1]='<a href="/adhoc/django/purchased_time_blocks_management/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Manage Time Blocks</a>'
TRIAL[2]='<a href="/adhoc/django/requested_time_slots_management/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Running Balance Management</a>'
TRIAL[3]='<a href="/adhoc/site_media/admin/category_subcategory_management/CategorySubCategoryManagement.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Manage Trial Staff Categories</a>'
TRIAL[4]='<a href="/adhoc/site_media/admin/alias_price_management/AliasPriceManagement.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Manage Trial Staff Advertised Rates</a>'
TRIAL[5]='<a href="/adhoc/django/assigning_staff/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Member Assign Staff</a>'

var PREPAID = new Array()
PREPAID[0]='<a href="admin_prepaid_clients.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Prepaid Clients</a>'
PREPAID[1]='<a href="/portal/AdminRunningBalanceClientSearch/ClientSearch.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Client Available Balance Search</a>'    
PREPAID[2]='<a href="/portal/AdminMassGeneratePrepaidAdjustments/AdminMassGeneratePrepaidAdjustments.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Prepaid Invoice Mass Generation & Adjustments</a>'    
PREPAID[3]='<a href="/portal/AdminPrepaidInvoiceManagement/AdminPrepaidInvoiceManagement.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Prepaid Invoice Management</a>'    

var MEETINGCALENDAR = new Array()
MEETINGCALENDAR[0]='<a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onclick="open_calendar();return false;">View My Calendar</a>'
MEETINGCALENDAR[1]='<a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onclick="open_admin_calendar();return false;">View Other Admins\' Calendar</a>';


var disappeardelay=250  //menu disappear speed onMouseout (in miliseconds)
var horizontaloffset=2 //horizontal offset of menu from default location. (0-5 is a good value)

/////No further editting needed

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
document.write('<div id="dropmenudiv" style="visibility:hidden;" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

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
  window.open('meeting_calendar/?view_type=view','_blank','width=1024,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
function open_admin_calendar()
{
  window.open('meeting_calendar/?view_type=other_admin','_blank','width=1024,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
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
<li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, USERS, '270px')" onmouseout="delayhidemenu();">Add Users</a></li>
<li><a href="recruiter/recruitment_sheet.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Job Orders</a></li>
<li><a href="recruiter/recruitment_sheet_dashboard.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Job Orders Dashboard</a></li>

<!--
<li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, LEADS, '270px')" onmouseout="delayhidemenu();">Leads</a></li>
-->
<li><a href="admin_personnel_info.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Personnel</a></li>
<li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, INVOICING, '270px')" onmouseout="delayhidemenu();">Tax Invoices</a></li>
<li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, PREPAID, '270px')" onmouseout="delayhidemenu();">Prepaid Client</a></li>
<li><a href="/portal/django/client_sub_accounts/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Client's Sub Accounts</a></li>
	<li><a href="javascript: open_calendar(); " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Meeting Calendar</a></li>

<li><a href="admin_activity_tracker_notes.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Activity Tracker Notes</a></li>
<li><a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="dropdownmenu(this, event, TOOLS, '270px')" onmouseout="delayhidemenu();">Tools</a></li>
<li><a href="send-staff-resume-to-leads-adminside.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recommendation&nbsp;Summary</a></li>
<li><a href="send-resume-to-leads.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Send Resume to Leads</a></li>
<!--<li><a href="admin_problems_and_issues.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Problems / Issues</a></li>-->
<li><a href="leave_request_management.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Leave Request Management</a></li>
<li><a href="/portal/django/workflow/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Workflow</a></li>
<li><a href="tools/TimeZoneConverter/TimeZoneConverter.html" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Time Zone Converter</a></li>
<li><a href="/adhoc/django/requested_time_slots_management/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Trial Based</a></li>
<li><a href="/portal/bugreport/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Bug Report</a></li>
</ul></div>






</td>
<td valign="top">
<div align="right">Welcome #188 Lorelie Lynn Ramos</div>

<div id="admin_tab" style="display:block; padding:20px; ">
<div class="tabber">

	<div class="tabbertab">
		  <h2>Admin</h2>
	</div>
	
	<div class="tabbertab">
		  <h2>Accounts</h2>
	</div>
	
	<div class="tabbertab">
		  <h2>Recruitment</h2>
	</div>
	
	<div class="tabbertab">
		  <h2>Sales</h2>
	</div>
	<!--
	<div class="tabbertab">
		  <h2>ASL</h2>
	</div>
    -->

</div>
</div>















</td>
</tr>
</table>
<!--ASL ALARM--> <DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV> <!--ENDED-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " colspan="2" >&nbsp;</td></tr>
<tr><td valign="top" >
Copyright © 2008 Think Innovations Pty Ltd<br />
<a href="http://remotestaff.com.au/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  class="link10" title="Outsourcing Online Staff from the Philippines">REMOTESTAFF.COM.AU</a>
</td><td valign="top" align="right"><font size="1"><a href="logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link10">Agent/Client/Sub-Contractor login</a></font></td></tr>
<tr><td colspan="2" valign="top" align="right"><img src="images/Small-Logo2.jpg" alt="Think Innovations" align="middle" /></td></tr>
</table>


<script language="javascript">

		var chck = 0;
		var temp = '';
		var curSubMenu = '';	
		//var curSubMenu='';
		function showSubMenu(menuId){
				if (curSubMenu!='') hideSubMenu();
				eval('document.all.'+menuId).style.visibility='visible';
				curSubMenu=menuId;
		}
		function hideSubMenu(){
				eval('document.all.'+curSubMenu).style.visibility='hidden';
				curSubMenu='';
		}
		function void(clicked) {
			el = document.getElementById("overlay");
			//el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
			el.style.display = (!el.style.display || el.style.display == "none") ? "block" : "none";
			if (clicked == 1) {
				popup_win8('./rschat.php?portal=1&email=lorelie@remotestaff.com.ph&hash=sbfd1fae770b9be486',800,600);
			}
			return false;
		}
		
				connect(window, 'onload', function() { void(0); });
		
		
		
</script>

</form>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/script.js"></script>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/pullmenu.js"></script>
</body>
</html>