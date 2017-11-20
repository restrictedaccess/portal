<?php
$admin_status=$_SESSION['status'];
?>

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
* AnyLink Vertical Menu- � Dynamic Drive (www.dynamicdrive.com)
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
		<!--<li><a href="#" onmouseover="dropdownmenu(this, event, SELECT_CATEGORY, '270px')" onmouseout="delayhidemenu();"><img src="../images/folder_clip.gif" border="0" /> Position Categories</a></li>-->
		<!--<li><a href="#" onmouseover="dropdownmenu(this, event, OPEN_POSSITION_APPLICATION, '270px')" onmouseout="delayhidemenu();"><img src="../images/textfile16.png" border="0" /> Open Position Application</a></li>-->
		<!--<li><a href="../staff.php"><img src="../images/attach.gif" border="0" /> Position Summary Report</a></li>-->
		<!--<li><a href="recruiter_staff_manager.php"><img src="../images/attach.gif" border="0" />&nbsp;ASL Candidate</a></li>-->
		<!--<li><a href="../application_endorsement_summary_report.php"><img src="../images/foldermove16.png" border="0" /> Endorsement Summary Report</a></li>-->
		<!--<li><a href="../application_shortlisted_report.php"><img src="../images/stats16.png" border="0" /> Shortlisted Applicants</a></li>-->
		<!--<li><a href="../top_10_applicants.php"><img src="../images/groupofusers16.png" border="0" /> Top 10 Applicants</a></li>-->
		<!--<li><a href="../admin_problems_and_issues.php"><img src="../images/undo16.png" border="0"/> Problems / Issues</a></li>-->
		<!--<li><a href="/portal/recruiter/request_for_interview_voucher.php"><img src="../images/adduser16.png" border="0" /> Voucher Manager</a></li>-->
		<!--<li><a href="/portal/recruiter/send_email_resume.php"><img src="../images/email.gif" border="0" /> Send Email Resume</a></li>-->
		<!--<li><a href="../recruiter/staff_category_manager.php?stat=No Potential" onmouseover="dropdownmenu(this, event, NO_POTENTIAL, '270px')" onmouseout="delayhidemenu();"><img src="../images/icon-person.jpg" border="0" />&nbsp;ASL Categories</a></li>-->
		<?php 
			/*?><li><a href="request_for_interview.php?service_type=CUSTOM"><img src="../images/adduser16.png" border="0" /> CUSTOM Booking</a></li>*/
		?>
		<li><a href="/portal/recruiter/advertised_list.php">Advertisement</a></li>
		<li><a href="/portal/recruiter/request_for_interview.php">Interview Bookings</a></li>
		<li><a href="/portal/recruiter/request_for_prescreen.php">Request for Pre-Screen</a></li>
		<li><a href="/portal/recruiter/recruiter_job_orders_view_summary.php">Job Order Summary</a></li>
		<li><a href="/portal/recruiter/recruitment_sheet.php">Recruitment Sheet</a></li>
		<li><a href="/portal/recruiter/new_recruitment_sheet.php">Recruitment Sheet - Recruiter View</a></li>
		<li><a href="/portal/recruiter/recruitment_sheet_dashboard.php">Recruitment Dashboard</a></li>
		<li><a href="/portal/recruiter/recruitment_team_shortlists.php">Recruitment Team Shortlists</a></li>
		<li><a href="/portal/recruiter/recruitment_contract_dashboard.php">Recruiter's New Hires</a></li>
		<li><a href="/portal/recruiter/recruiter_test_reports.php">Test Takers</a></li>
		<li><a href="/portal/recruiter/referrals.php">Refer a Friend</a></li>
		<li><a href="/portal/sms/">SMS Logs</a></li>
		<li><a href="/portal/candidates/index.php">Create Job Seeker Account</a></li>
		<li><a href="/portal/test_admin/">Generate Test Session</a></li>
		<li><a href="/portal/recruiter/staff_mass_emailing.php">Staff Mass Emailing</a></li>
		<li><a href="javascript: open_calendar(); ">Meeting Calendar</a></li>
		<li><a href="/portal/recruiter/category-management.php">Category Management</a></li>
		<li><a href="/portal/pricing_list/">Job Order Pricing</a></li>
		<li><a href="/portal/skill_task_manager/">Skill and Task Management</a></li>
	</ul>

</div>


