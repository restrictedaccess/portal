{literal}
<style>
body{font-family:Tahoma; font-size:14px;}
#paragraph {margin-left:10px; margin-top:5px;}
#paragraph p{margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;}
#paragraph h4 {margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; }
#paragraph h3 { color:#660000;margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; }
#paragraph ol{font-family:Tahoma; font-size:13px;}
#paragraph li { margin-bottom:10px; margin-top:10px;}
#paragraph span { margin-top:20px; color:#003399; text-align:justify;font-family:Tahoma; font-size:13px; }
</style>
{/literal}
<table style=' border:#FFFFFF solid 1px;' width='100%'>
<tr><td height='105' width='100%%' valign='top'>
<div id='paragraph' style=''>
<p>{$date}<p>
<h4>Hi&nbsp; {$staff_name|upper}</h4>
<h3>This is to confirm the receipt of your contract. Welcome to RemoteStaff!!! </h3>
<p><b>Before your first day please: </b></p>
<ol>
<li>Go to <a href='http://{$site}/portal/' target='_blank'>Sub-contractors System</a> , log in and check out the Starter Kit. Log in as a 'Contracted Staff'</li>
<ul> <b>Login Detail</b>
	<li><b>Email : {$staff_email}</b></li>
	<li><b>Password : {$main_pass}</b></li>
</ul>
<li>Log in and test out your Skype account. (please note that this has already been created, and you just need to log-in to it.)</li>
<ul><li><b>Skype ID : {$skype}</b></li>
	<li><b>Password : {$skype_password}</b></li>
</ul>
This Skype account should be used for business purpose only. You are required to be logged in to this account during working hours. 
<li>Test your Headset</li>
<li>Download the RemoteStaff Screen Capture Installer from the Sub-Contractor System Website and install it into your computer.</li>
<ul> <b>Login Detail</b>
	<li><b>Email : {$staff_email}</b></li>
	<li><b>Password : {$main_pass}</b></li>
</ul>
The log in details for your RemoteStaff Screen Capture is the same as your log-in details for the Sub-Contractor system.
<li>Log in to your company email address at&nbsp;<a href="https://email.1and1.com/ox6/ox.html#" target="_blank">https://email.1and1.com/ox6/ox.html#</a>. Bookmark this page on your browser for daily easy access</li>
<ul> <b>Login Detail</b>
	<li><b>Email : {$staff_email}</b></li>
	<li><b>Password : {$staff_email_password}</b></li>
</ul>
All communication between you and your client must be made through this email address. 
</ol>
<p><b>Please follow the steps below on your first day. </b></p>
<ol>
   <li>On your first day log in to the System and click <strong>&quot;Start Work&quot;</strong>. Be on time. Log in to the RSSC.
You have to be on the system and Skype on or before your starting working time.</li>
  
   <li>Wait for me or the client to contact you via Skype.  Your client will introduce himself to you. Your client's name is <b>{$client_name|upper} {$company_name|upper}</b> </li>
   <li>While waiting, please read and study the resources on the Sub-Contractor System. After the introduction, you will be working <strong>DIRECTLY</strong> with your client. We will <strong>NOT</strong> project manage you when it comes to your tasks and activities with your client, but we check on your attendance and online visibility. Work and task related issues should be discussed directly with the client.</li>
   
  
</ol>
<span><i>**Please note that you cannot negotiate anything with the client when it comes to problems regarding the work set-up, systems, compensation and attendance. You have to discuss this directly with the RemoteStaff team.    </i></span>
<p>&nbsp;</p>

<p>Welcome to the team! Have a wonderful and productive  first working day! </p>
<p>Cheers!</p>
<p><a href='http://{$site}/portal/' target='_blank'><img src='http://{$site}/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a></p>
<p>{$admin_name}<br>{$admin_email}</p>
</div>
</td></tr>
</tr>
</table>