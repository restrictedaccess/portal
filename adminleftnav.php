<?php
//2013-02-25 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   updated running balance to available balance
//2012-08-06 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   added prepaid invoice management
//2011-07-18 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added new subcon invoicing app
//2010-03-26 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added activity tracker notes for HR
//2009-11-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added Timezone Converter Tool
//include 'config.php';
//include 'conf.php';
include_once('conf/zend_smarty_conf.php');
$settingsCalendar = $db->fetchOne($db->select()->from("admin", array("view_admin_calendar"))->where("admin_id = ?", $_SESSION["admin_id"]));
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
?>

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
* AnyLink Vertical Menu- � Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/


var USERS=new Array()
USERS[0]='<a href="/portal/django/rsadmin/" target="_blank">Admin Account Users</a>'
USERS[1]='<a href="/portal/whitelist/" target="_blank">Admin Whitelist</a>'
USERS[2]='<a href="/portal/adminnaddagent.php">Business Developer Management</a>'
USERS[3]='<a href="adminaffiliates.php">Affiliates</a>'
USERS[4]='<a href="/portal/adminBPTransferLeads.php">Business Developer Transfer Leads</a>'
USERS[5]='<a href="/portal/django/client_sub_accounts/" target="_blank">Create Client Sub-Account</a>'
USERS[6]='<a href="/portal/recruitment_team/" target="_blank">Recruitment Team</a>'


var INVOICING=new Array()
INVOICING[0]='<a href="/portal/invoice/StaffInvoiceMaintenance/StaffInvoiceMaintenance.html" target="_blank">Sub-Contractors</a>'
INVOICING[1]='<a href="/portal/admin_subcon_payment_details.php">Sub-Contractors Bank Accounts</a>'
INVOICING[2]='<a href="/portal/django/inhouse/" target="_blank">Inhouse Payment Settings</a>'
INVOICING[3]='<a href="/portal/django/commission/" target="_blank">Commission</a>'
//INVOICING[4]='<a href="/portal/django/commission/" target="blank">x</a>'
//INVOICING[1]='<a href="adminInvoicesForClient.php">Clients</a>'
//INVOICING[2]='<a href="adminBPCommission.php">Business Developer Commission</a>'
//INVOICING[3]='<a href="adminInvoicingForAff.php">Affiliates</a>'
//INVOICING[4]='<a href="payment_history.php">Payments History</a>'
//INVOICING[5]='<a href="admin_set_up_fee_invoice.php">Set-Up Fee Invoice</a>'
//INVOICING[6]='<a href="admin_create_quote.php">Create a Quote</a>'
//INVOICING[8]='<a href="invoice/IremitSenderMaintenance/IremitSenderMaintenance.html" target="_blank">Sub-Contractors Iremit Sender</a>'
//INVOICING[9]='<a href="admin_leads_invoice_payment.php">Secure Pay/PayPal Payments</a>'
//INVOICING[10]='<a href="admin_get_started.php">Recruitment Service Ordering</a>'

var TOOLS=new Array() 
//TOOLS[0]='<a href="admin_job_order.php">Job Request/Order Form</a>'
//TOOLS[0]='<a href="/portal/admin_testimonials.php">Testimonials</a>'
//TOOLS[1]='<a href="/portal/admin_comments_suggestion.php">Comments &amp; Suggestions</a>'
TOOLS[0]='<a href="/portal/django/bulletin_board/">Bulletin Board</a>'
TOOLS[1]='<a href="/portal/promo_codes_monitoring/" target="_blank">Promo Codes Monitoring</a>'
TOOLS[2]='<a href="/portal/job_titles.php">Job Titles Price Management</a>'
TOOLS[4]='<a href="/portal/pricing_list/">Custom Recruitment Price Management</a>'
//TOOLS[6]='<a href="/portal/seatbooking/seatb.php?/index/" target="_blank">RS Office Seat Booking</a>'
//TOOLS[7]='<a href="/portal/tools/TimeZoneConverter/TimeZoneConverter.html" target="_blank">Time Zone Converter</a>'
TOOLS[5]='<a href="/portal/rs_contact_nos/" target="_blank">RS Contact Number Management</a>'

var SKILLTEST=new Array()
SKILLTEST[0]='<a href="/portal/skillstest/apptest.php?/index/" target="_blank">Manage Skills Tests</a>'
SKILLTEST[1]='<a href="/portal/test_admin/" target="_blank">Generate Test Session</a>'
//SKILLTEST[3]='<a href="/skills_test/?/reports/" target="_blank">Skills Test Reports</a>'

var RECREPORTING=new Array()
RECREPORTING[0]='<a href="/portal/recruiter/recruiter_job_orders_view_summary.php" target="_blank">Recruitment Summary</a>'
RECREPORTING[1]='<a href="/portal/recruiter/recruitment_sheet.php" target="_blank">Recruitment Sheet</a>'
RECREPORTING[2]='<a href="/portal/recruiter/recruitment_sheet_dashboard.php">Recruitment Dashboard</a>'
RECREPORTING[3]='<a href="/portal/recruiter/recruitment_team_shortlists.php">Recruitment Team Shortlists</a>'

var LEADS=new Array() 
LEADS[0]='<a href="AddUpdateLeads.php">Add New Leads</a>'
//LEADS[1]='<a href="admin_prepaid_clients.php">Prepaid Clients</a>'
//LEADS[2]='<a href="admininactiveList.php">No Longer a Prospect</a>'

var TRIAL = new Array()
TRIAL[0]='<a href="/adhoc/django/requested_time_slots_management/" target="_blank">Manage Trial Staff Candidates</a>'
TRIAL[1]='<a href="/adhoc/django/purchased_time_blocks_management/" target="_blank">Manage Time Blocks</a>'
TRIAL[2]='<a href="/adhoc/django/requested_time_slots_management/" target="_blank">Running Balance Management</a>'
TRIAL[3]='<a href="/adhoc/site_media/admin/category_subcategory_management/CategorySubCategoryManagement.html" target="_blank">Manage Trial Staff Categories</a>'
TRIAL[4]='<a href="/adhoc/site_media/admin/alias_price_management/AliasPriceManagement.html" target="_blank">Manage Trial Staff Advertised Rates</a>'
TRIAL[5]='<a href="/adhoc/django/assigning_staff/" target="_blank">Member Assign Staff</a>'

var PREPAID = new Array()
PREPAID[0]='<a href="/portal/admin_prepaid_clients.php">Prepaid Clients</a>'
PREPAID[1]='<a href="/portal/AdminRunningBalanceClientSearch/ClientSearch.html" target="_blank">Client Available Balance Search</a>'        
PREPAID[2]='<a href="/portal/AdminPrepaidInvoiceManagement/AdminPrepaidInvoiceManagement.html" target="_blank">Prepaid Invoice Management</a>'  
PREPAID[3]='<a href="/portal/django/accounts/" target="_blank">Statement Of Account</a>'  
PREPAID[4]='<a href="/portal/accounts_v2/#/accounts/manage-payment-advise" target="_blank">Payment Advice Received </a>'  

var MEETINGCALENDAR = new Array()
MEETINGCALENDAR[0]='<a href="#" onclick="open_calendar();return false;">View My Calendar</a>'
MEETINGCALENDAR[1]='<a href="#" onclick="open_admin_calendar();return false;">View Other Admins\' Calendar</a>'

var SCREENRECORDING = new Array()
SCREENRECORDING[0]='<a href="/portal/screenshare_admin.php" target="blank">Screen Share</a>'
SCREENRECORDING[1]='<a href="/portal/screenrecorder_admin.php" target="blank">Screen Recorder</a>'
SCREENRECORDING[2]='<a href="/portal/screenrec_list.php" target="blank">Saved Screen Recording</a>'

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


<?php if ($admin_status =="FULL-CONTROL"){ ?>
<div id="markermenu" >
	<ul>
		<li><a href="#" onmouseover="dropdownmenu(this, event, USERS, '270px')" onmouseout="delayhidemenu();">Add Users</a></li>
		<li><a href="/portal/accounts_v2/#/invoice/clients">Client Invoice Management</a></li>
		<li><a href="/portal/accounts_v2/#/invoice/invoice-reporting">Client Invoice Reporting</a></li>
		<li><a href="/portal/accounts_v2/#/invoice/email-reporting">Client Invoice Email Report</span></a></li>
		<li><a href="#" onmouseover="dropdownmenu(this, event, INVOICING, '270px')" onmouseout="delayhidemenu();">Subcon Invoice Management</a></li>
		<!--<li><a href="#" onmouseover="dropdownmenu(this, event, PREPAID, '270px')" onmouseout="delayhidemenu();">Prepaid Client</a></li>-->
		<li><a href="/portal/sc_v2/#/quote/main/">Quote and SA Management</a></li>
		<li><a href="/portal/django/subcontractors/accepted_service_agreement/" target="_blank" >Accepted Service Agreements</a></li>
		<li><a href="/portal/accounts_v2/#/accounts/timesheet">Time Sheet Management</a></li>
		<li><a href="#" onmouseover="dropdownmenu(this, event, RECREPORTING, '270px')" onmouseout="delayhidemenu();">Recruiters Reporting</a></li>
		<li><a href="/portal/stats/page_view.php" target="_blank" >Client Portal Activities</a></li>
		<li><a href="#" onmouseover="dropdownmenu(this, event, SKILLTEST, '270px')" onmouseout="delayhidemenu();">Skill Test Management</a></li>
		<li><a href="admin_activity_tracker_notes.php">Activity Tracker Notes Settings</a></li>
		<li><a href="/portal/aclog/" target="_blank" >Activity Logger</a></li>
		<li><a href="/portal/compliance_v2/#/leave-request/dashboard" target="_blank">Leave Request Management</a></li>
		<li><a href="/portal/django/workflow/" target="_blank" >Workflow</a></li>
		<?php if ($settingsCalendar=="Y"){?>
			<li><a href="#" onmouseover="dropdownmenu(this, event, MEETINGCALENDAR, '270px')" onmouseout="delayhidemenu();">Meeting Calendar</a></li>
		<?php }else{?>
			<li><a href="javascript: open_calendar(); ">Meeting Calendar</a></li>
		<?php }?>
		<li><a href="/portal/scenmgt/?/admin/" target="_blank" >Scenario Management</a></li>
		<li><a href="#" onmouseover="dropdownmenu(this, event, TOOLS, '270px')" onmouseout="delayhidemenu();">Tools</a></li>
		<!--<li><a href="/adhoc/django/requested_time_slots_management/" target="_blank" >Trial Based</a></li>-->
		<li><a href="/portal/bugreport/" target="_blank" >Bug Report</a></li>
		<!--<li><a href="#" onmouseover="dropdownmenu(this, event, SCREENRECORDING, '270px')" onmouseout="delayhidemenu();">Screen Recording</a></li>-->
		<!--<li><a href="#" onmouseover="dropdownmenu(this, event, LEADS, '270px')" onmouseout="delayhidemenu();">Leads</a></li>-->
		<!--<li><a href="admin_personnel_info.php">Personnel</a></li>-->
		<!--<li><a href="send-staff-resume-to-leads-adminside.php">Recommendation&nbsp;Summary</a></li>-->
		<!--<li><a href="send-resume-to-leads.php">Send Resume to Leads</a></li>-->
		<!--<li><a href="admin_problems_and_issues.php">Problems / Issues</a></li>-->		
	</ul>
</div>
<?php } ?>

<?php if ($admin_status =="COMPLIANCE") {?>
<div id="markermenu" >
	<ul>
		<li><a href="/portal/django/client_sub_accounts/" target="_blank">Client's Sub Accounts</a></li>
		<li><a href="admin_job_order.php">Job Request/Order Form</a></li>
		<li><a href="admin_newsletter_tips.php">Newsletter &amp; Tips</a></li>
		<li><a href="admin_comments_suggestion.php">Comments &amp; Suggestions</a></li>  
		<li><a href="admin_subcon_updates.php">Bulletin Board</a></li>
		<li><a href="/portal/invoice/StaffInvoiceMaintenance/StaffInvoiceMaintenance.html" target="_blank">Invoicing for Sub-Con</a></li>	
		<li><a href="admin_subcon_payment_details.php">Sub-Con Payment Details</a></li>
		<li><a href="admin_activity_tracker_notes.php">Activity Tracker Notes</a></li>
		<!--<li><a href="send-staff-resume-to-leads-adminside.php">Recommendation&nbsp;Summary</a></li>-->
		<!--<li><a href="admin_problems_and_issues.php">Problems / Issues</a></li>-->
		<li><a href="/portal/leave_request/admin/" target="_blank">Leave Request Management</a></li>
		<li><a href="/portal/django/workflow/" target="_blank" >Workflow</a></li>
		<li><a href="tools/TimeZoneConverter/TimeZoneConverter.html" target="_blank">Time Zone Converter</a>'</li>
	</ul>
</div>
<?php } ?>

<?php if($admin_status=="FINANCE-ACCT"){ ?>
<div id="markermenu" >
	<ul>
		<li><a href="#" onmouseover="dropdownmenu(this, event, INVOICING, '270px')" onmouseout="delayhidemenu();">Tax Invoices</a></li>
		<li><a href="#" onmouseover="dropdownmenu(this, event, TOOLS, '270px')" onmouseout="delayhidemenu();">Tools</a></li>
		<!--<li><a href="admin_problems_and_issues.php"><img src="images/undo16.png" border="0"/> Problems / Issues</a></li>-->
		<li><a href="tools/TimeZoneConverter/TimeZoneConverter.html" target="_blank">Time Zone Converter</a>'</li>
	</ul>
</div>
<?php }?>
