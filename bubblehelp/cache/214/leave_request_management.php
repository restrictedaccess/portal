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
</style><meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Remotestaff Leave Request Form (Help Page)</title>
<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="./leave_request_form/media/css/leave_request.css">

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<link rel="stylesheet" type="text/css" href="./leave_request_form/media/css/antique.css" />

<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./js/functions.js"></script>
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>


<script type="text/javascript" src="./leave_request_form/media/js/leave_request_form.js"></script>

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
<form name="parentForm" method="post" enctype="multipart/form-data" action="#" accept-charset = "utf-8">
<input type="hidden" name="leads" id="leads" />
<input type="hidden" name="userid" id="userid"  />
<input type="hidden" name="user_type" id="user_type" value="admin" />

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

<div align="right"><img src='images/remote-staff-country-active-AUS.jpg' border='0'><a href="http://www.remotestaff.co.uk/portal/leave_request_management.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img border="0" onmouseout=this.src="images/remote-staff-country-inactive-UK.jpg" onmouseover=this.src="images/remote-staff-country-active-UK.jpg" src="images/remote-staff-country-inactive-UK.jpg"></a><a href="http://www.remotestaff.net/portal/leave_request_management.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"><img border="0" onmouseout=this.src="images/remote-staff-country-inactive-US.jpg" onmouseover=this.src="images/remote-staff-country-active-US.jpg" src="images/remote-staff-country-inactive-US.jpg"></a>
</div>
<!--
<iframe id="frame" name="frame" width="100%" height="100%" src="notes.php" frameborder="0" scrolling="no">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
-->
<div style="padding:5px; color:#666666;">
<a href="javascript:popup_win8('.\/rschat.php?portal=1&email=mike.lacanilao@remotestaff.com.au&hash=o4cf494fccb075dda3',800,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  class='hlink' title='Open remostaff chat'>Chat</a> | 	<a href="logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="hlink">Logout</a> | <a href="logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="hlink" title="Login in Different Account">Login</a>
	| <a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=leave_request_management.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="hlink" title="Open Help Page" >Help Page</a>
| <a href="#" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" onmouseover="showReportMenu(this)" onmouseout="mclosetime()" class="hlink">Bug Report</a> | <a href="gotowiki.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" title="Open the Wiki page"  class="hlink">Wiki</a></div>

</td>

</tr>
</table>

<!-- /HEADER -->


	
		
			<div style="float:right; padding-right:10px;"><a href="admin_profile.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link10"  >Administrator Profile</a></div>
<div style="clear:both;"></div>
<div style="background:url(images/remote-staff-nav-bg2.jpg); height:40px;">
<div id="glossymenu">
<ul>

  <li><a href="adminHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Home</a></li>
  <li><a href="/portal/recruiter/recruiter_home.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Recruitment</a></li>
  <li><a href="leads.php?lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >New Leads <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Follow Up </a></li>
  <li><a href="leads.php?lead_status=asl" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >ASL <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Custom Recruitment <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Keep in Touch <img src='images/star.png' border='0'  ></a></li>
  <li><a href="leads.php?lead_status=pending" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Pending </a></li>
  <li><a href="leads-active.php?lead_status=Client&filter=ACTIVE" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Clients <img src='images/star.png' border='0'  ></a></li>
  <li><a href="adminscm.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  >Sub Contractor Management</a></li>
  <li><a href="subconlist.php' " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">List of Sub Contractors</a></li>
  <li><a href="/portal/ticketmgmt/' " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Tickets</a></li>









</ul>
</div>
</div>	
<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<td width="173" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; ' >

		
			
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
TOOLS[3]='<a href="/portal/django/bulletin_board/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Bulletin Board</a>'
TOOLS[4]='<a href="./promo_codes_monitoring/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Promo Codes Monitoring</a>'
TOOLS[5]='<a href="job_titles.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Job Titles Price Management</a>'
TOOLS[6]='<a href="seatbooking/seatb.php?/index/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >RS Office Seat Booking</a>'
TOOLS[7]='<a href="/portal/skillstest/apptest.php?/index/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Manage Skills Tests</a>'
TOOLS[8]='<a href="/portal/django/inhouse/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Inhouse Payment Settings</a>'
TOOLS[9]='<a href="/portal/test_admin/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Generate Test Session</a>'
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
<li><a href="recruiter/recruiter_job_orders_view_summary.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recruitment Summary</a></li>
<li><a href="recruiter/recruitment_sheet.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recruitment Sheet</a></li>
<li><a href="recruiter/recruitment_sheet_dashboard.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recruitment Dashboard</a></li>
<li><a href="recruiter/recruitment_team_shortlists.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recruitment Team Shortlists</a></li>

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
<li><a href="screenshare_admin.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link12b" >Screen Share</a></li>
<li><a href="screenrecorder_admin.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link12b" >Screen Recorder</a></li>
<li><a href="/portal/aclog/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link12b" >Activity Logger</a></li>
</ul></div>






	</td>

<td valign="top">
<!-- content -->
<div id="lrm">
<h2 align="center" >STAFF LEAVE REQUEST MANAGEMENT</h2>
<table align="right" border="0" >
		<tr>
		<td bgcolor="#00FF00">&nbsp;</td>
		<td>Approved</td>
		<td bgcolor="#FFFF00">&nbsp;</td>
		<td>Pending</td>
		<td bgcolor="#FF0000">&nbsp;</td>
		<td>Denied</td>
		<td bgcolor="#CCCCCC">&nbsp;</td>
		<td>Cancelled</td>
		<td bgcolor="#0000FF">&nbsp;</td>
		<td>Marked Absent</td>
		</tr>
</table>

 
<div id="suggest">Select Staff : <input type="text"  id="inquiring_about" class="inquiring_about" name="inquiring_about" onblur="suggest();" onkeyup="suggest();"  onclick="suggest();"  />
 <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="go" value="Search" onclick="ShowStaffAllRequestedLeave()"/>
      <div class="suggestionsBox" id="suggestions" style="display: none;"> 
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
      </div>
</div>



<table width="100%" cellpadding="0" cellspacing="1" >

<tr bgcolor="#FFFFFF">
<td valign="top" width="25%" >
<div id="staff_list"></div>
</td>
<td valign="top" width="75%">
<div id="right_panel">
<div style="margin-left:10px;">
<select name="year" id="year" style="width:100px;" onchange="javascript:document.parentForm.submit();">
<option value='2014' selected>2014</option><option value='2013' >2013</option><option value='2012' >2012</option><option value='2011' >2011</option><option value='2010' >2010</option>
</select> Selected Year
<div id="showleave"><table width='90%' class="year">
<tr><td colspan="4" class="yearname">2014</td></tr>
<tr>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">January 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,1,31)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">31</a></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">February 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,2,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">March 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,3,31)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">31</a></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">April 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,4,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,4,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,4,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
</tr><tr><td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">May 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#0000FF' class='with_event'><a href="javascript:UpdateStaffList(2014,5,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td></tr>
<tr><td bgcolor='#FFFF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#00FF00' class='with_event'><a href="javascript:UpdateStaffList(2014,5,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,5,31)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">31</a></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">June 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,6,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">July 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,7,31)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">31</a></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">August 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,8,31)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">31</a></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
</tr><tr><td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">September 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,9,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">October 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,10,31)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">31</a></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">November 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,11,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
<td valign="top">
<table width='100%' class="month">
<tr><td class="monthname" colspan="7">December 2014</td></tr>
<tr><td class="dayname">Sun</td><td class="dayname">Mon</td><td class="dayname">Tue</td><td class="dayname">Wed</td><td class="dayname">Thu</td><td class="dayname">Fri</td><td class="dayname">Sat</td></tr>
<tr><td class="nomonthday"></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,1)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">1</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,2)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">2</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,3)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">3</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,4)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">4</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,5)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">5</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,6)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">6</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,7)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">7</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,8)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">8</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,9)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">9</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,10)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,11)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,12)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,13)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">13</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,14)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">14</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,15)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">15</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,16)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">16</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,17)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">17</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,18)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">18</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,19)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">19</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,20)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">20</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,21)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">21</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,22)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">22</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,23)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">23</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,24)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">24</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,25)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">25</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,26)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">26</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,27)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">27</a></td></tr>
<tr><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,28)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">28</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,29)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">29</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,30)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">30</a></td><td bgcolor='#CCCCCC' class='with_event'><a href="javascript:UpdateStaffList(2014,12,31)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">31</a></td><td class="nomonthday"></td><td class="nomonthday"></td><td class="nomonthday"></td></tr>
</table>
</td>
</tr>
</table>
</div>
</div>
</div>
</td>
</tr>
</table>
<!-- end content -->
</div>
</td>

</tr>
</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " colspan="2" >&nbsp;</td></tr>
<tr><td valign="top" >
Copyright © 2008 Think Innovations Pty Ltd<br />
<a href="http://remotestaff.com.au/" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"  class="link10" title="Outsourcing Online Staff from the Philippines">REMOTESTAFF.COM.AU</a>
</td><td valign="top" align="right"><font size="1"><a href="logout.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" class="link10">Agent/Client/Sub-Contractor login</a></font></td></tr>
<tr><td colspan="2" valign="top" align="right"><img src="images/Small-Logo2.jpg" alt="Think Innovations" align="middle" /></td></tr>
</table>


<script> ShowStaffList() </script>

</form>

<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/script.js"></script>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/pullmenu.js"></script>
</body>
</html>