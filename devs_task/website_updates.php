<?php 
require('./conf/zend_smarty_conf.php');

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

if($_SESSION['admin_id']!="43") {
    die("You are not allowed to access this page. For Anne Only :)");
}  
$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Website Updates</title>
</head>

<body style="margin:0;">
<img src="https://remotestaff.com.au/portal/system_wide_reporting/media/images/remote-staff-logo.jpg" align="absmiddle" /> 
<p><strong>New Function / Pages Deployed on Production</strong></p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">			
			<td width="55%" style="color:#FFFFFF"><strong>Update</strong></td>
			<td width="25%" style="color:#FFFFFF"><strong>URL</strong></td>
			<td width="15%" style="color:#FFFFFF"><strong>Date Released</strong></td>
		</tr>
		
		<tr bgcolor="#FFFFCC">
			<td>Staff Attendance Sheet in django based apps and uses CouchDB</td>
			<td><a href="https://remotestaff.com.au/portal/django/system_wide_reporting/staff_attendance_sheet/" target="_blank">remotestaff.com.au/portal/django/system_wide_reporting/staff_attendance_sheet/</a></td>
			<td>11-18-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Running Late in django based apps and uses CouchDB</td>
			<td><a href="https://remotestaff.com.au/portal/django/system_wide_reporting/running_late/" target="_blank">remotestaff.com.au/portal/django/system_wide_reporting/running_late/</a></td>
			<td>11-18-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Send Auto Responder every 90 days for ASL categorized candidates to check for their availability. WF 4934.</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_staff_manager.php?on_asl=0" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_staff_manager.php</a></td>
			<td>11-11-2013</td>
</table>

</body>
</html>
