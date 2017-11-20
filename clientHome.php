<?php
include('conf/zend_smarty_conf.php');
if($_SESSION['client_id'] == "" or $_SESSION['client_id'] == NULL){

	header("location:index.php");
	die;
}

header("Location:/portal/django/client_portal/");
die;

$client_id = $_SESSION['client_id'];

//2011-02-02 Mike Lacanilao <remote.michaell@remotestaff.com.au>
// replaced the alert message with overlay popup box for rschat auto-login
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Client Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="css/overlay.css">
<script language=javascript src="js/MochiKit.js"></script>
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="/portal/js/jquery.js"></script>
<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>
<link rel=stylesheet type=text/css href="css/jqMoverlay.css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>
<div id="announcement" style=" display:none;position:absolute; width:500px; height:200px; background:#FFFFFF; border:#CA0000 solid 1px; font-family:Arial, Helvetica, sans-serif; font-size:14px;  z-index:1;">
<div style="background-color:#CA0000;">

<table width="100%" ><tr><td style="color:white; padding:5px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:14px;">Announcement</td><td align="right"><a href="javascript:toggle('announcement');" style=" color:#FFFFFF; font-weight:bold; text-decoration:none; font-family:Arial, Helvetica, sans-serif; font-size:14px;">X</a></td></tr></table>
</div>
<div style=" padding:10px; line-height:20px;">
<p>Dear <?php echo $name;?> , </p>
<p>There is a change on <em><strong>Remote Staff Service Agreement&acute;s Clause 21</strong></em> regarding Amendments. Please click <a href="client_contract.php">HERE</a> to review.
 
Should you have any questions, please contact <a href="mailto:contracts@remotestaff.com.au">contracts@remotestaff.com.au</a>.</p>
</div>
</div>
<table width="100%" cellpadding="5" cellspacing="0" border="0" >
<tr>
<td width="170" style="border-right: #006699 2px solid; width: 170px; vertical-align:top;"><?php include 'clientleftnav.php';?>

<img src="images/icon-people.gif" alt="RemoteStaff" align="middle"><a class='t3' href='myremotestaff.php' title="my staff" > 
<?php
$sql ="SELECT COUNT(id)AS numrow FROM subcontractors WHERE leads_id =$client_id AND status = 'ACTIVE';";
$result = $db->fetchRow($sql);
echo $result['numrow'];
?>
</a>
</td>
<td width="1150" height="108" valign="top">
<div id="paragraph" style="text-align:justify; padding-right:50px; padding-left:50px; padding-top:10px; ">
<p><b>Dear <?php echo $name;?>, </b></p>
<p>Welcome to Remote Staff! </p>
<p>This page is your Remote Platform. This will serve as your tool and will help you in managing and utilizing your remote staff. </p>
<p>As a tool, it is very important to know how to use it. Please be quickly acquainted with the Remote Platform by reading on. </p><br>
<p style="color:#FF0000; font-weight:bold;">Upper Right Hand Side Buttons : </p>
<ul style="list-style:none;">
<li ><strong>Chat Button</strong> When clicked, will lead you to the Remote Staff Chat page where you can chat to your staff real time and to the Remote Staff Support Team. <br>
<br>
</li>
<li><strong>Log Out</strong> button This is where you can log out. </li>
</ul>

<p>Below Log Out and Chat Button, you will see a quick summary of your account with us. </p>
<ul style="list-style:none;">
<li ><strong>Credits</strong> = Your Current Balance in your local currency.  <br>
<br>
</li>
<li><strong>Staffs</strong> = Total Number of Staff <br>
<br>
</li>
<li><strong>Days</strong> = Number of days your Credit can cover for your Staff/s. </li>
</ul>
<br>
<p>Click on <strong>Buy Credits</strong> to buy more credits. </p>
<p>Click on <strong>Available Balance</strong> to get itemized details on the hours and services charged and deducted from your account. </p>
<br>
<p style="color:#FF0000; font-weight:bold;">Top Main Tabs  : </p>


<ul style="list-style:none;">
<li ><strong>Screenshots, Timesheets and Activity Tracker</strong> : This is where you can view your staff's activity notes, computer screen shots, list of daily tasks, total number of hours worked and detailed time sheet. <br><br>
	
</li>
<li><strong>Comments and Suggestions</strong> : Is where you can send us your comments and suggestions about our services, processes , support team and the Remote Platform.  <br>
<br>
</li>
<li><strong>Support Team Contact Details</strong>: Is where you can find relevant departments contact details. <br>
<br>
 </li>
 <li><strong>Service Agreement</strong> : Is where you can find our Service Agreement and addendums therein.<br>
<br>
 </li>
<li><strong>Commissions</strong> : This is a tool and page you can use when you have a commission structure with your staff. This report is communicated directly to your staff and Clients Staff relations department.<br>
<br>
 </li>
 
 <li><strong>Trial Staff List</strong> :  This is a separate platform where you can trial staff without hiring. Trialing can be between 1 hour to 80 hours (10 days). </li>
  
</ul>
<br>


<p style="color:#FF0000; font-weight:bold;">Left Hand Side Navigation Tabs :  </p>


<ul style="list-style:none;">
<li ><strong>My Account</strong> : This is a form where you can edit your details, email address (user name), password etc.  
<br><br>
</li>
<li><strong>My Remote Staff</strong> : This is a page with a view of all your remote staff members. You will be quickly updated on their status: Working, Not Working and On Break. .   <br>
<br>
</li>
<li><strong>My Invoice</strong> : This is a page where you will list of invoices we have issued to you all throughout the contract.  <br>
<br>
 </li>
 
<li><strong>Add Testimonials</strong> : This is where you can give us testimonials about your staff or/and our services. <br>
<br>
 </li>
 
 <li><strong>My Job Ads / Post a New Job Ad</strong> : This is a page where you can view previous job specification orders. <br>
<br></li>

<li><strong>My Remote Staff Leave Requests </strong> : This is where you can see a calendar list and view of your staff's leave requests and advised absent days. This is where you can approve or disapprove their requests.  <br>
<br></li>

<li><strong>FAQs</strong> : These are lists of Frequently Asked Questions we have collated all throughout 4 years of providing remote staffing solutions.  <br>
<br></li>
  
</ul>

<p>&nbsp;</p>


<div align="center">
For any questions about the Remote Platform, any tools you want to use in this remote set up like VoIP phones, Skype, Screen sharing, document sharing solutions, any issues<br>
 regarding your staff, payment options etc. contact us on our details below. <br>
AUS Number:      1300 733 430 or +61 (02) 8090 3458, Press OPTION 3<br>
US Number:       +1 415 376 1472, Press OPTION 3<br>
UK Number:       +44 208 816 7802, Press OPTION 3<br>
<br>
Email:      clientsupport@remotestaff.com.au  (AUS)<br>
clientsupport@remotestaff.co.uk  (UK)<br>
clientsupport@remotestaff.biz  (USA<br>

</div>
</div>

</td>

</tr>
</table>

<?php include 'footer.php';?>

<div class='popupmodal'>RSChat<span id='aid'></span><hr>
	<div style='float:left;padding:4px;width:100%;'>
	  You will also be logged in to RemoteStaff Chat. This will allow you to chat with Admin and your staff members real time.
	  <div style='text-align:center;'><button type="button" id="btn_yes">OK</button></div>
	</div>
</div>

<script language='javascript'>
$.noConflict();
<?php
	if( (@$_SESSION['admin_id']!="" or @$_SESSION['agent_no']!="" or
		 @$_SESSION['client_id']!="" or @$_SESSION['userid']!="" ) && $_SESSION['firstrun']=="") {
		
		$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
?>

<?php
if( !empty($_SESSION['client_id']) && empty($_SESSION['firstrun']) ):?>
	//window.onload=alertchat(0);
	
	jQuery(document).ready(function($) {
		$('.popupmodal').jqm({overlay: 50, modal: true}).jqmShow();
		//$('.popupmodal').show();
		$('button#btn_yes').click(function(){
			$('.popupmodal').jqmHide();
			popup_win8('./rschat.php?portal=1&email=<?php echo $_SESSION['emailaddr'].'&hash='.$hash_code ?>',800,600);
		});
	});
<?php
	endif;
}
?>

//toggle('announcement');
//var xpos = screen.availWidth/2 - 500/2; 
//var ypos = screen.availHeight/2 - 200/2; 
//$('announcement').style.top = xpos+"px";
//$('announcement').style.left = ypos+"px";
</script>

</body>
</html>
