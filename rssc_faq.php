<?php
include './conf/zend_smarty_conf_root.php';
$userid = $_SESSION['userid'];
//echo $userid;
if($_SESSION['userid']=="")
{
	header("location:index.php");
}

$query="SELECT * FROM personal WHERE userid=$userid";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];
//$payment_details=$result['payment_details'];
//$image = $result['image'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link href='css/admincontactdetails.css' rel="stylesheet" type="text/css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
	<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr>
</table>
	
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr><td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '> <? include 'subconleftnav.php';?></td>
	<td width="1081" valign="top" style="padding:10px;">
  		<center><h3>FAQ about RSSC</h3></center>
  		<p><strong>1. What are the features of RSSC?</strong><br>
  			Features added are:</p>
  	<ul>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Time Stamps :</strong> Once you click ‘Start Work’, it automatically captures the time set in your computer. This cannot be edited by you or anyone else. Once you click on ‘Finish Work’, it automatically captures the total work hours you have rendered for the day and total your lunch time spent.</li><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Screen Capture: </strong> Once the RSSC is running, system captures all activities done on your computer. This is to assure your client that you are only working on work related activities while you are logged in. It communicates to your client the work you did for the day. RSSC Screen capture captures every 3 minutes.</li><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Web Cam Captures: </strong> Configurable screen webcam captures by Admin. This will be activated if we have a reason to believe that you are not working while logged in on your RSSC or when there is no response to our instant messages via Skype and RS Chat, phone calls and text messages. When this is on, you will know as the RSSC will notify you.</li><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Activity Tracker: </strong> Input what are you currently working on and the progress of the said activity. The activity tracker pops up every 20 minutes or as the client requested to check on you.</li>
		<br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Rate the progress of your work task or your currently working on :</strong> ( ‘Just Started’ ,  ‘0% - 100 %’) Rate how much you like the activity you are currently working on. This will update your client on which tasks you prefer and excel on.</li><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>To do’s today:  </strong>a list of work task you entered on RSSC or Work Flow Task you synced from client’s created Work Flow Task.</li><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Configurable Activity Notes: </strong>Admin and your client can now adjust the time interval of your Activity Notes tracker. If you want your activity tracker’s interval to be shorter or longer than what it is now please speak to you client to state why and have them change the settings of your activity tracker note.</li><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Bandwidth Test: </strong>To ensure that your internet connection is stable, a random bandwidth test will be performed to check your internet connection speed. As per our agreement, you are required to have DSL internet connection with minimum download speed of 1 MBPS and minimum upload speed of 0.35 MBPS if you don’t have this, upgrade your internet connection.</li><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif; text-align:left" ><strong>Over-break Notifications: </strong>You are given 10 minutes break for every 4 hours worked, if you don’t return to work after the 10 minutes break, a notice will be sent on your email to remind you then you will be logged out of the RSSC, your status will be changed from “ Working” to “ Not Working”.</li><br>
	</ul>
  
		<p><strong>2. Where can I download the  RSSC?</strong><br>
		  RSSC installer can be downloaded from the subcontracted homepage. Refer to image below.<br>
	
	<div id="main-image"><img src="images/rssc/rssc_01.png"></div>
		<p><strong>3. How to install the new RSSC?</strong></p>
		
	<ul>
		<li style="font:Verdana, Arial, Helvetica, sans-serif">Uninstall the old version of RSSC by going to your control panel. If you need help in doing this contact your CSRO.</li><br clear="all">
		<li style="font:Verdana, Arial, Helvetica, sans-serif">Locate the ThinkInnovationsInstaller.exe you previously downloaded and double click it. Refer to image below.</li><br>
		
		<div id="main-image"><img src="images/rssc/rssc_12.png"></div><br clear="all">
		<li style="font:Verdana, Arial, Helvetica, sans-serif">Click on RUN to begin the installation. Refer to image below.</li><br>
		<div id="main-image"><img src="images/rssc/rssc_05.png"></div><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif">Check or uncheck on the component you want to install then click NEXT to continue.</li><br>
		<div id="main-image"><img src="images/rssc/rssc_06.png"></div><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif">The installer will tell you where the RSSC will be installed. You can also click the BROWSE button to select a folder of your choice.  Click INSTALL button to proceed. </li><br>
		<div id="main-image"><img src="images/rssc/rssc_07.png"></div><br>
		<li style="font:Verdana, Arial, Helvetica, sans-serif">Wait a few minutes to complete the installation. When complete, close the window and locate the RSSC Icon on your desktop or chosen folder. </li><br>
		<div id="main-image"><img src="images/rssc/rssc_08.png"></div><br>
		
		<li style="font:Verdana, Arial, Helvetica, sans-serif"><strong>Note for Windows user:</strong> If you encountered <strong><i>“application configuration is incorrect”</i></strong>, kindly download and install redistributable package first. You can download the redistributable package from <a href="http://www.microsoft.com/downloads/en/details.aspx?familyid=A5C84275-3B97-4AB7-A40D-3802B2AF5FC2&displaylang=en" style="color: #0000CC; font-weight: bold; text-decoration: none;">here.</a></div><br clear="all"></li></div><br>
		
		<li style="font:Verdana, Arial, Helvetica, sans-serif"><strong>Note for Mac Users with OS lower than Snow Leopard:</strong> You can run RSSC via WINE but its hit and miss. RSSC would run but at times, screen shots are all black. Please upgrade your OS the ASAP.</li><br>
		
		<li style="font:Verdana, Arial, Helvetica, sans-serif"><strong>For Linux user</strong></li>
			<p>1. Install pip or easy_install using your favorite package manager (apt-get, aptitude, etc.)</p>
			<p>2. Install python modules (wxpython,twisted,opencv,pil/Python Imaging,platform,psutil), example using pip: pip install wxpython )</p>
			<p>3. Install external programs: xprop, notify-send using package manager of choice</p>
			<p>4. Extract rssc_linux_2013-06-14.tbz into directory of choice</p>
			<p>5. Run ./start_rssc.sh</p>
			<li style="font:Verdana, Arial, Helvetica, sans-serif">You are also able to run the RSSC via WINE (Windows Emulator). From their console, run the installer like this:<br clear="all"><br clear="all"><strong style="background-color:#CCCCCC; border:thick; font:Verdana, Arial, Helvetica, sans-serif" >wine ThinkInnovationsInstaller.exe</strong></li><br>
			<li style="font:Verdana, Arial, Helvetica, sans-serif">Note that <strong>Linux user</strong> will also be required to install the redistributable package from Microsoft click <a href="http://www.microsoft.com/downloads/en/details.aspx?familyid=A5C84275-3B97-4AB7-A40D-3802B2AF5FC2&displaylang=en" style="color: #0000CC; font-weight: bold; text-decoration: none;">here</a> to download. After downloading, execute it on their console:<br clear="all"><br><strong style="background-color:#CCCCCC; border:thick; font:Verdana, Arial, Helvetica, sans-serif" >wine vcredist_x86.exe</strong></li>
	</ul>

<p><strong>4. How to login and Start Work on the new RSSC?</strong></p>
<ul>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Locate and double click the Icon of new RSSC on your desktop. Or from Think Innovations Program that can be found on Start menu –> All Programs.</li><br clear="all">
	<div id="main-image"><img src="images/rssc/rssc_18.png"></div><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Input the Remote Staff email and your password( from the welcome email you recieved from Remote Staff. ) into the corresponding field. Click the Connect button to connect to the RSSC and click "Start Work".</li>
	<br clear="all">
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Image below is the interface of the new RSSC.</li><br>
	<div id="main-image"><img src="images/rssc/rssc_23.png"></div><br>
</ul>
<p><strong>5. What is the default interval of Activity tracker notes will ask me to input their activity note?</strong></p>
<ul>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">The activity tracker is a simple way to update your client about your daily activities. When typing in your activity act like you are answering to your client’s questions <i>“What are you working on right now? Where are you at with it?”</i> The list of your activity notes all throughout the day is emailed to your client the minute you log out and finish work. </li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Subcontractors will be asked to type in their activity in the activity tracker window every time it pops up. You have to be specific in typing in your current activity when this pops up. It should be answered in the shortest amount of time possible. Once done, rate your task per percentage and then just click OK.</li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Default interval is 20 minutes but can be changed to 30 minutes, 45 minutes, 1 hour, 1.5 hour, and 2 hours but is subject to Client’s approval</li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Activity tracker window also pops up 5 minutes after a subcontractor clicks on START WORK” and when “QUICK BREAK” or “LUNCH” has ended</li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Image below is a screenshot of the RSSC Activity tracker window. It comes with a pop-up notification and a sound alert every time it pops up.</li><br>
	<br clear="all">
	<div id="main-image"><img src="images/rssc/rssc_20.png"><br></div>
</ul>  

<p><strong>7. How to use 'To Do's Today' and sync my Work Flow task to Activity Tracker Notes?</strong></p>
<ul>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Click on the 'Sync Workflow' to pre-plotting the Activities or making your workflow task synced on your To Do's Today list. See image below </li><br>
	<div id="main-image"><img src="images/rssc/rssc_syncwf.png"></div><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">To add work task on 'To Do's Today' list click the 'Add' button then key in your agenda then press OK button once done. See image below</li><br>
	<div id="main-image"><img src="images/rssc/rssc_todostoday.png"></div><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">To edit work task on 'To Do's Today' list; just click on the work task from the list then click 'Edit' button then key in your agenda then press OK button once done. See image below</li><br>
	<div id="main-image"><img src="images/rssc/rssc_edittodos.png"></div><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">To delete work task on 'To Do's Today' list; just click on the work task from the list then click 'Delete' button then press OK button to confirm. See image below</li><br>
	<div id="main-image"><img src="images/rssc/rssc_deletetodos.png"></div><br>
	</ul>
	
<p><strong>8. What is the default interval of Capturing Screen and Camera?</strong></p>
<ul>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Default interval is 3 minutes but can be changed to 5 minutes and 10 minutes but is subject to Client’s approval </li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Screen and Camera capture can only be configured by the Inhouse Admin Team and your Client.</li><br>
	</ul>

<p><strong>9. What is Bandwidth test?</strong></p>
<ul>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Bandwidth test is initiated by the system after the subcontractor clicks on Start Work and when LUNCH BREAK has ended </li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">We do this random test to ensure that all subcontractors have the suitable internet connection speed required. If the average speed test result falls below what is acceptable and functional for your role, an upgrade or additional internet connection may be required to continue the contract. </li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Image below is a screenshot when RSSC runs a bandwidth test.</li><br>
	<div id="main-image"><img src="images/rssc/rssc_16.png"><br>
</div>
	</ul>
 
<p><strong>10. How can I prevent over breaks?</strong></p>
<ul>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">One of the features of the new RSSC is the over break notification. When a subcontractor is on Quick break/Lunch break, the notification pops up together with the sound alert 10 minutes before the 60 minutes Lunch is over and when the 10 minute Quick Break has been consumed.</li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Notification will continue to pop up every 5 seconds until subcontractor clicks on finish Quick Break or Lunch</li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Important Note: RSSC will automatically set your status to finish work when staff is on break for more than 15 minutes. An email will also be sent to the staff as a notification that the staff is disconnected and status is set to Finish Work</li><br>
</ul>

<p><strong>11. How will I know if my screen captures and webcam captures is running and working?</strong></p>
<ul>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">You may click on the Daily Time Sheet Action tab on the RSSC tool and check on the status at the bottom part of the RSSC window</li><br>
	<li style="font:Verdana, Arial, Helvetica, sans-serif">Image below shows where to find the status of the Screen and Camera capture </li><br>
	<div id="main-image"><img src="images/rssc/rssc_21.png"></div>
	</ul>

</td>
</tr>
<tr>
  <td valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>&nbsp;</td>
  <td valign="top" style="padding:10px;">&nbsp;</td>
</tr>
</table>
</body>
</html>
