<style type="text/css">
/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */


#markermenu{

 width:auto;
}
#markermenu ul{
list-style-type: none;
padding: 0;
width:200px;
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

	padding-left:10px;
	padding-right:10px;
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

</style>
<div id="markermenu" >
<ul>
<li><a href="/portal/subconHome.php">My Home</a></li>
<li><a href="/portal/admin_contact_details.php" >Need Help ? Contact CSRO</a></li>
<li><a href="/portal/django/workflow/" target="_blank" >Workflow</a></li>
<li><a href="/portal/django/staff_productivity_reports/screenshots" target="_blank">Productivity Reports</a></li>
<li><a href="/portal/aclog/">Activity Logger</a></li>
<li><a href="/portal/screenshare_subcon.php">Screen Share</a></li>
<li><a href="/portal/screenrecorder_subcon.php">Screen Recorder</a></li>
<!--<li><a href="/portal/subcon/SubconActivityTrackerNotes/SubconActivityTrackerNotes.html" target="_blank">Activity Tracker Notes</a></li>-->
<li><a href="/portal/jobseeker/" target="_blank">Account Settings</a></li>
<li><a href="/portal/subcon_contract.php">Contract</a></li>
<li><a href="/portal/bank_account_details.php">Bank Account Details</a></li>
<li><a href="/portal/invoice/StaffViewInvoice/StaffViewInvoice.html" target="_blank">Invoice</a></li>
<li><a href="/portal/django/commission_request" target="_blank" >Commission Claims </a></li>
<?php if($leads_id == 11) echo '<li><a href="/portal/bugreport/" target="_blank">Bug Report</a></li>';?>
<li><a href="/portal/contractor_manuals_and_starter_kit/" >Contractor Manual &amp; Starter Kit</a></li>  
<li><a href="/portal/django/bulletin_board/message_board/" target="_blank" >Bulletin Board</a></li>
<li><a href="/portal/mytestimonials.php" >Testimonials</a></li>
<li><a href="/portal/legal_holidays.php" >Legal Holidays</a></li>
<li><a href="/portal/django/staff/leave_request" target="_blank" >Leave Request</a></li>
<li><a href="/portal/logoutSubcon.php">Logout</a></li>  
</ul>
</div>
