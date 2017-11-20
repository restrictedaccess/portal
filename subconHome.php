<?php
//2011-12-06 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  retrieve facebook script from https
//2011-09-10 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  updated rssc link
//2011-09-09 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  updated rssc link
//  fixed clocks not showing
//2011-07-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  stop executing script if session is not found fix
//  removed timer.js

//2011-02-02 Mike Lacanilao <remote.michaell@remotestaff.com.au>
// added overlay popup box for rschat auto-login

//2011-01-13  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Resized iframe to accomodate timesheet timezone note
//2010-11-15 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Retained the toggle function for the link on the "Click HERE to find out more about RSSC"

//2010-11-09    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  removed start work/finish work on portal and the old timesheet

//2009-02-18    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  removed clock
//  modified height of new timesheet frame to prevent scrolling from IE

//2009-11-17    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  modified size for new timesheet notes frame

//2010-02-23 Normaneil Macutay <normanm@remotestaff.com.au>
// - changed the php short tags (<?) to <?php


//2010-02-24 Normaneil Macutay <normanm@remotestaff.com.au>
// - remove dropin div and script
// - replaced it with a splash page script

//2010-03-03 Normaneil Macutay <normanm@remotestaff.com.au>
// - remove the $flag code and hidden element
// - remove Don contact nos.

//2010-03-16 Normaneil Macutay <normanm@remotestaff.com.au>
// - remove the dropin div and js/dropin.js
// - bug fix of differenct timezone not showing time conflict in the js/dropin.js script

//2010-03-22 Normaneil Macutay <normanm@remotestaff.com.au>
// - remove the "Important Letter about Payroll from Admin"

//2010-05-12 Anne Charise Villarama <charise@remotestaff.com.au>
//  Adding Link to download RSSC installer for Mac user

//2010-10-12 Normaneil Macutay <normanm@remotestaff.com.au>
// Shows javascript alert box informing that the Independent Contract has been modified.

//echo $_SERVER['REMOTE_ADDR'];
include './conf/zend_smarty_conf.php';
$userid = $_SESSION['userid'];
//echo $userid;
if($userid=="")
{
	header("location:index.php");
    exit();
}
header("Location:/portal/django/staff/");
die;
$query="SELECT fname, lname, payment_details, image, s.leads_id FROM personal p
LEFT JOIN subcontractors s ON p.userid=s.userid WHERE p.userid=$userid GROUP BY p.userid";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];
$payment_details=$result['payment_details'];
$image = $result['image'];
$leads_id = $result['leads_id'];



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/reminders.css">
<script src="https://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<!-- added by lawrence sunglao on 2008-06-25 9:50 -->
<script type="text/javascript" src="js/MochiKit.js"></script>
<link rel=stylesheet type=text/css href="css/overlay.css">
<script type="text/javascript">
<!-- 
var USER_TYPE = 'subcon';
-->
</script>

<script type="text/javascript" src="time_recording/timeRecording.js"></script>
<script language=javascript src="js/subconHome.js"></script>
<script language=javascript src="js/functions.js"></script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden"  id="payment_details" name="payment_details" value="<?php echo $payment_details;?>">
<div id="overlay"> <div> <p>You will be logged in to RemoteStaff Chat.</p>
	<input type='button' name='submit' value='&nbsp; OK &nbsp;' onclick='alertchat(1);' /></div> </div>

<div id="dropin" style="font:12px Arial; line-height:20px; padding:20px;position:absolute; display:none; background:#FFFFCC; border:#333333 solid 5px; width:500px;">
  <p>Dearest RemoteStaff Sub Contractor,<br>
      <br>
    A great year is about to end and we're writing to wish you a happy holidays, thank you for your hard / efficient work all throughout the year and announce a new payroll scheme for 2011.<br>
  <br>
    We received feedback from you/your client on improving our current payroll scheme and this has been considered and studied.&nbsp;<br>
    As a result of the feedback received from you / clients, <strong>starting January 2011, our cut off schedule is fixed to every 20th of the month</strong>. Note that <em>payout will still happen at the end of each month with guaranteed clearing on the 1st or 2nd</em> business day of the following month.<br>
  <br>
    Having this schedule, your payroll is better managed. This will also give us a good allowance to follow up on some clients who, for one reason or another, unintentionally forget or delay to pay their monthly invoices.<br>
  <br>
    We are confident that this change will benefit you. If you have any questions, suggestions/feedback please do not hesitate to get in touch with your Client &ndash; Staff Relations officers.&nbsp;<br>
  <br>
    We appreciate you being part of our sub con team this 2010 and we are looking forward to 2011 with you as a part of our ever growing and expanding team.<br>
  <br>
    RemoteStaff wishes you and your family a Merry Christmas and a Wonderful New Year!!!&nbsp;<br>
  <br>
  </p>
  Cheers ,&nbsp;<br>
RemoteStaff&nbsp;<br>
<br>
<br>
<center><input type="button" onClick="toggle('dropin')" value="Close"></center>
</div>

<?php include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <?php echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <?php include 'subconleftnav.php';?>
   
   </td>
<td width="1081" valign="top">
<div style="margin-left:10px; font:14px Arial;">
<div id="divConfirmPresence"></div>
</div>

<div id="reminders" >
<div style="background:#E3E0AC; padding:5px; border:#E3E0AC outset 2px;"><b>Sub-Contractor Home</b></div>
<div>
<div id="subcon_notes">
<h2>IMPORTANT REMINDERS</h2>
<ol >
<li><strong>SKYPE RULES</strong>. It is VERY important that we are all online on Skype and are able to answer within 3 minutes. <span class="style2"><strong>NOTE</strong> that communication is vital in building and maintaining trust. When a messaged from your client is not answered, the client could easily question your whereabouts and be doubtful about this remote set up</span></li>
<li>Please observe your respective work hours and work schedules.<br>
 <br>
</li>


<p><strong>For any attendance-related issues such as the following:</strong></p>
<ul>
  <li>Lates</li>
  <li>Absences</li>
  <li>Emergency</li>
  <li>Leaves</li>
  <li>OTs</li>
  <li>Disconnections ( DSL issues, PC Issues, Power interruptions)</li>
  <li>Other attendance and compliance related issues</li>
</ul>
<br>

<p><strong style="color:#F00">TEXT US: </strong><strong>0917-533-7949</strong> (This is an <strong>Attendance TEXT Hotline</strong>, we can't receive a call on this number.)<br>
<strong style="color:#F00">CALL US: </strong><strong>0947-995-9822</strong> . (This is an <strong>Attendance Call Hotline</strong>, we can't receive text messages on this number.)<br>
<strong style="color:#F00">EMAIL US</strong>: attendance@remotestaff.com.au<br></p>

<p><br>
<strong>To request a work leave please notify us at least 2 days before the requested work leave date</strong> <img src="images/001_44.png" align="absmiddle"><a href="leave_request_form.php" style="color: #0000CC; font-weight: bold; text-decoration:none"> Request a Leave?</a> </p>

<br clear="all">

<div style="clear:both; margin-top:20px;"></div>
<p><span class="style3"><strong>NOTE</strong> that inability to notify us of your whereabouts during working  hours will put your job at risk. Our goal is to foster an office like  environment where your client could expect you to be working on a structured  schedule and not showing up to work without notice will disrupt our client&rsquo;s  business activities. </span></p>
<p class="style3">Absence without notice for 2 consecutive days will be considered as  ABANDONMENT OF POST, wherein, such case is subject to the following:</p>
<ul>
	<li class="style3" style=" list-style:lower-alpha;">Penalty in the amount of <strong>PHP 50,000</strong> for monetary damages without prejudice to the COMPANY in filing a case against the CONTRACTOR in a competent court of law. (as per your contract)</li>
	<li class="style3" style=" list-style:lower-alpha;">Banning or black-listing of the CONTRACTOR wherein, announcement and notices shall be forwarded to different recruiting agencies including but not limited to JOBSDb, JobStreet, Newspaper, and especially to other remote work environment companies. Always remember to keep your RSSC on at all times and update your online presence when prompted</li>
</ul>
<li>Please upload your updated photo and complete your information (add more relevant <em>skills, work experiences, etc</em>). Click "<strong>Account Settings</strong>" to update your profile.<br>
<br>
</li>
<li>Never disclose any information about the business and its trade secrets which includes its clients, suppliers, finances, salaries, research and development, business processes or any other technical or business information.<br>
<br>
</li>
<li>You are only <strong>SERVICING</strong> to RemoteStaff's clients, you are a member of the RemoteStaff team so all your transaction regarding your salaries, attendances, work schedules or shifts, and all other information not related to your clients <strong>MUST</strong> be coursed through RemoteStaff. </li>
</ol>
</div>
</div>
<div style="clear:both;"></div>
</div>
<div id="download_client" style="margin-bottom: 12px; border: 1px solid #abccdd; padding: 8px; margin:10px;">
	<p>Please download the <strong><u>RemoteStaff Screen Capture (RSSC)</u></strong> installer. Install this into your computer. </p>
	<div style='margin-top: 4px; margin-bottom:8px;'>For <strong>WINDOWS users</strong> click <a href="https://remotestaff.com.au/portal/screenshots/ThinkInnovationsInstaller-2011-09-10.exe" style="color: #0000CC; font-weight: bold; text-decoration: none;">here</a> to download.</div>
	<div style='margin-top: 4px; margin-bottom:8px;'>For <strong>MAC users</strong> click on the version below to download.<br/><a href="https://remotestaff.com.au/portal/screenshots/RSSC_2011-09-27-mac.zip" style="color: #0000CC; font-weight: bold; text-decoration:none">Leopard/Snow-Leopard version</a><br/><a href="https://remotestaff.com.au/portal/screenshots/RSSC_2011-09-27-mac-lion.zip" style="color: #0000CC; font-weight: bold; text-decoration:none">Lion version</a></div>
	<div style='margin-top: 4px; margin-bottom:8px;'>For <strong>LINUX users</strong> click <a href="https://remotestaff.com.au/portal/screenshots/rssc_linux_2013-06-14.tbz" style="color: #0000CC; font-weight: bold; text-decoration: none;">here</a> to download.</div>
     <div style="margin-top: 12px; margin-bottom: 8px;">Click <span id="what_is_this_software" style="font-weight: bold; cursor: pointer; color: #0000CC;">HERE</span> to find out more about the <b>RSSC</b></div>
	
	 
	
    <div id="what_is_this_software_desc" style="display:none;">
        <ul>
		<li>As a contractor for Remote Staff, you will need to download and save this software on your computer.</li> 
<li>This software will take screen capture of your computer screen, do background test of your internet connection and help you manage your to do list and activities all throughout your working day.</li>
<li>This tool is designed for you and your Client. It helps provide transparency to the Client which promotes trust. Your Client can help, manage and trust you more effectively with the help of RSSC. These are the 3 most important factors needed for a longer lasting work from home relationship between yourself and your Client.</li> 
<li>You are required to log in to this software all throughout the working day as this is the basis of your timesheet and pay at the end of each month. </li>
<li>Click <a href="rssc_faq.php"><strong>here</strong></a> to know how to install RSSC, it's features and some FAQs. </li>
        </ul>
    </div>
</div>
<div class="clear"></div>
<div>
<div style="float:left; margin-left:10px;">
<fb:like-box href="http://www.facebook.com/pages/Remote-Staff-wwwremotestaffcomau/186026291427516" width="500" height="110" show_faces="true" stream="false" header="false"></fb:like-box>
</div>
<div style="float:left; margin-left:10px; line-height:20px;">
"<strong>We're on Facebook! <br>Drop by  <a href="http://www.facebook.com/RemotestaffPhilippines" target="_blank" style="color: #0000CC; font-weight: bold; text-decoration:none">http://www.facebook.com/RemotestaffPhilippines</a> <br> and let us know how it's going!</strong> "<br>
<small style="color:#FF0000;">(PS: do this on your break or after working hours)</small></div>  
<br clear="all">
</div>
<div style="border: 1px solid #abccdd; padding: 8px; margin:10px;">
    <h2>Time Sheet</h2>
    <iframe src="/portal/scm_tab/SubconTimeSheet/SubconTimeSheet.html" width="100%" height="408px" frameborder="0">    </iframe>
</div>
<div class="clear"></div>
<div style="border: 1px solid #abccdd; padding: 8px; margin:10px;">
    <a href="monthly_cut_off_faqs.php" style="color: #0000CC; font-weight: bold; text-decoration:none">Monthly Cut Off Period and FAQs about pay</a></div></td>
</tr>
</table>

<script type="text/javascript">
<!--
checkPaymentDetails();
<?php
	if( (@$_SESSION['admin_id']!="" or @$_SESSION['agent_no']!="" or
		 @$_SESSION['client_id']!="" or @$_SESSION['userid']!="" ) && $_SESSION['firstrun']=="") {
		
		$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
?>
function alertchat(clicked) {
	el = document.getElementById("overlay");
	//el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	el.style.display = (!el.style.display || el.style.display == "none") ? "block" : "none";
	if (clicked == 1) {
		popup_win8('./rschat.php?portal=1&email=<?php echo $_SESSION['emailaddr'].'&hash='.$hash_code ?>',800,600);
	}
}
//window.onload=alertchat(0);

<?php
}
?>
-->
</script>
</body>
</html>
