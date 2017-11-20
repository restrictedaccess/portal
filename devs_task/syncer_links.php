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
<title>Syncer Links</title>
</head>

<body style="margin:0;">
<img src="https://remotestaff.com.au/portal/system_wide_reporting/media/images/remote-staff-logo.jpg" align="absmiddle" /> 
<p style="font:12px verdana;">This page is created for Anne's purpose</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr>	
			<td bgcolor="#666666"></td>
			<td bgcolor="#666666" style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Trac</strong></td>
			<td><a href="http://trac.remotestaff.com.au/portal/login" target="_blank">trac.remotestaff.com.au/portal/login</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td ><strong>Rackspace</strong></td>
			<td><a href="http://rackspace.com" target="_blank">rackspace.com</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td ><strong>phpMyAdmin</strong></td>
			<td><a href="http://test.remotestaff.com.au/phpMyAdmin/" target="_blank">test.remotestaff.com.au/phpMyAdmin/</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Table Dumper</strong></td>
			<td><a href="http://test.remotestaff.com.au/portal/AdminTableDumper/AdminTableDumper.html" target="_blank">test.remotestaff.com.au/portal/AdminTableDumper/AdminTableDumper.html</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Portal Branch Syncer</strong></td>
			<td><a href="http://test.remotestaff.com.au/portal/AdminSyncPortal/AdminSyncPortal.html" target="_blank">test.remotestaff.com.au/portal/AdminSyncPortal/AdminSyncPortal.html</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>CouchDB</strong></td>
			<td><a href="http://couch.test.remotestaff.com.au/_utils/index.html" target="_blank">couch.test.remotestaff.com.au/_utils/index.html</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Portal Updates</strong></td>
			<td><a href="http://test.remotestaff.com.au/portal/production_updates.php" target="_blank">test.remotestaff.com.au/portal/production_updates.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Home Pages Updates</strong></td>
			<td><a href="http://test.remotestaff.com.au/portal/website_updates.php" target="_blank">test.remotestaff.com.au/portal/website_updates.php</a></td>
		</tr>
	</table>

<p style="font:12px verdana; background-color:#FFFFCC"><strong>Pages that uses Replication Server</strong></p>	
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">	
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Staff Attendance Report</strong></td>
			<td><a href="https://remotestaff.com.au/portal/system_wide_reporting/StaffAttendanceSheet.php" target="_blank">remotestaff.com.au/portal/system_wide_reporting/StaffAttendanceSheet.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Running Late Report</strong></td>
			<td><a href="https://remotestaff.com.au/portal/system_wide_reporting/RunningLate.php" target="_blank">remotestaff.com.au/portal/system_wide_reporting/RunningLate.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Recruitment Sheet</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruitment_sheet.php" target="_blank">remotestaff.com.au/portal/recruiter/recruitment_sheet.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>View All</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_search.php" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_search.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Unprocessed</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=UNPROCESSED" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=UNPROCESSED</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Remote Ready</strong></td>
			<td ><a href="https://remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=REMOTEREADY" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=REMOTEREADY</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Prescreened</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=PRESCREENED" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=PRESCREENED</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Inactive</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=INACTIVE" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=INACTIVE</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Shortlisted</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=SHORTLISTED" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=SHORTLISTED</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Endorsed</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=ENDORSED" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_search.php?staff_status=ENDORSED</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Categorized</strong></td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_staff_manager.php?on_asl=0" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_staff_manager.php</a></td>
		</tr>
</table>

<p style="font:12px verdana; background-color:#FFFFCC"><strong>Pages that uses CouchDB</strong></p>	
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Staff Attendance Report</strong></td>
			<td><a href="https://remotestaff.com.au/portal/django/system_wide_reporting/staff_attendance_sheet/" target="_blank">remotestaff.com.au/portal/django/system_wide_reporting/staff_attendance_sheet/</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Running Late Report</strong></td>
			<td><a href="https://remotestaff.com.au/portal/django/system_wide_reporting/running_late/" target="_blank">remotestaff.com.au/portal/django/system_wide_reporting/running_late/</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Inhouse Payroll</strong></td>
			<td><a href="https://remotestaff.com.au/portal/payroll/" target="_blank">remotestaff.com.au/portal/payroll/</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>Subcon Activity Tracker Notes</strong></td>
			<td><a href="https://remotestaff.com.au/portal/subcon/SubconActivityTrackerNotes/SubconActivityTrackerNotes.html" target="_blank">remotestaff.com.au/portal/subcon/SubconActivityTrackerNotes/SubconActivityTrackerNotes.html</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Client Activity Tracker Notes</strong></td>
			<td><a href="https://remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html" target="_blank">remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>RSSC Report</strong></td>
			<td><a href="https://remotestaff.com.au/portal/AdminRsscReports/AdminRsscReports.html" target="_blank">remotestaff.com.au/portal/AdminRsscReports/AdminRsscReports.html</a></td>
		</tr>
	</table>
	
	<p style="font:12px verdana; background-color:#FFFFCC"><strong>Portal </strong>: ssh://hg@remotestaff.com.au:22002/portal</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_portal_test_default.php" target="_blank">remotestaff.com.au/portal/conf/sync_portal_test_default.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.com.au</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_portal.php" target="_blank">remotestaff.com.au/portal/conf/sync_portal.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>remotestaff.com.ph</strong></td>
			<td><a href="http://www.remotestaff.com.ph/portal/conf/sync_portal.php" target="_blank">remotestaff.com.ph/portal/conf/sync_portal.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.co.uk</strong></td>
			<td><a href="http://www.remotestaff.co.uk/portal/conf/sync_portal.php" target="_blank">remotestaff.co.uk/portal/conf/sync_portal.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>remotestaff.net</strong></td>
			<td><a href="http://www.remotestaff.net/portal/conf/sync_portal.php" target="_blank">remotestaff.net/portal/conf/sync_portal.php</a></td>
		</tr>
		</table>	
	
<p style="font:12px verdana; background-color:#FFFFCC"><strong>Home Pages </strong>: ssh://hg@remotestaff.com.au:22002/home_pages</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_home_pages_test.php" target="_blank">remotestaff.com.au/portal/conf/sync_home_pages_test.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.com.au</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_home_pages.php" target="_blank">remotestaff.com.au/portal/conf/sync_home_pages.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>remotestaff.co.uk</strong></td>
			<td><a href="http://www.remotestaff.co.uk/portal/conf/sync_home_pages.php" target="_blank">remotestaff.co.uk/portal/conf/sync_home_pages.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.net</strong></td>
			<td><a href="http://www.remotestaff.net/portal/conf/sync_home_pages.php" target="_blank">remotestaff.net/portal/conf/sync_home_pages.php</a></td>
		</tr>
		</table>	
		
<p style="font:12px verdana; background-color:#FFFFCC"><strong>Get Started </strong>: ssh://hg@remotestaff.com.au:22002/get_started</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_get_started_test.php" target="_blank">remotestaff.com.au/portal/conf/sync_get_started_test.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.com.au</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_get_started.php" target="_blank">remotestaff.com.au/portal/conf/sync_get_started.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>remotestaff.co.uk</strong></td>
			<td><a href="http://www.remotestaff.co.uk/portal/conf/sync_get_started.php" target="_blank">remotestaff.co.uk/portal/conf/sync_get_started.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.biz</strong></td>
			<td><a href="http://www.remotestaff.biz/portal/conf/sync_get_started.php" target="_blank">remotestaff.biz/portal/conf/sync_get_started.php</a></td>
		</tr>
	</table>	
	
<p style="font:12px verdana; background-color:#FFFFCC"><strong>Django Home Pages </strong>: ssh://hg@remotestaff.com.au:22002/django_home_pages</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="http://test.remotestaff.com.au/portal/conf/sync_django_home_pages_test.php" target="_blank">test.remotestaff.com.au/portal/conf/sync_django_home_pages_test.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.com.au</strong></td>
			<td><a href="https://remotestaff.com.au/portal/conf/sync_django_home_pages.php" target="_blank">remotestaff.com.au/portal/conf/sync_django_home_pages.php</a></td>
		</tr>
	</table>	
	
<p style="font:12px verdana; background-color:#FFFFCC"><strong>Adhoc </strong>: ssh://hg@remotestaff.com.au:22002/adhoc</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="https://remotestaff.com.au/portal/conf/sync_adhoc_test_default.php" target="_blank">remotestaff.com.au/portal/conf/sync_adhoc_test_default.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.com.au</strong></td>
			<td><a href="https://remotestaff.com.au/portal/conf/sync_prod_remotestaff_adhoc.php" target="_blank">remotestaff.com.au/portal/conf/sync_prod_remotestaff_adhoc.php</a></td>
		</tr>
	</table>
	
<p style="font:12px verdana; background-color:#FFFFCC"><strong>Request for Interview </strong>: ssh://hg@remotestaff.com.au:22002/request_for_interview</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">			
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_request_for_interview_test.php" target="_blank">remotestaff.com.au/portal/conf/sync_request_for_interview_test.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.com.au</strong></td>
			<td><a href="http://www.remotestaff.com.au/portal/conf/sync_get_started.php" target="_blank">remotestaff.com.au/portal/conf/sync_request_for_interview_test.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>remotestaff.co.uk</strong></td>
			<td><a href="http://www.remotestaff.co.uk/portal/conf/sync_get_started.php" target="_blank">remotestaff.co.uk/portal/conf/sync_request_for_interview_test.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.biz</strong></td>
			<td><a href="http://www.remotestaff.biz/portal/conf/sync_get_started.php" target="_blank">remotestaff.biz/portal/conf/sync_request_for_interview_test.php</a></td>
		</tr>
	</table>
	
<p style="font:12px verdana; background-color:#FFFFCC"><strong>remotestaff.com.ph </strong>: ssh://hg@remotestaff.com.au:22002/www_remotestaff_com_ph</p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="http://www.remotestaff.com.ph/conf/sync_html_test.php" target="_blank">remotestaff.com.ph/conf/sync_html_test.php</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>remotestaff.com.ph</strong></td>
			<td><a href="http://www.remotestaff.com.ph/conf/sync_html.php" target="_blank">remotestaff.com.ph/conf/sync_html.php</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>remotestaff.com.in</strong></td>
			<td><a href="http://test.remotestaff.co.in/conf/sync_html_test.php" target="_blank">remotestaff.co.in/conf/sync_html_test.php</a></td>
		</tr>
	</table>
	
<p style="font:12px verdana; background-color:#FFFFCC"><strong>remotestaff.com </strong></p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>Test Environment</strong></td>
			<td><a href="https://remotestaff.com.au/portal/conf/sync_www_remotestaff_com_test.php" target="_blank">remotestaff.com.au/portal/conf/sync_www_remotestaff_com_test.php</a></td>
		</tr>
	</table>	
	
<p style="font:12px verdana; background-color:#FFFFCC"><strong>Swicthing Syncer for website old design</strong></p>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center" bgcolor="#666666">
		<tr bgcolor="#666666">
			<td></td>
			<td style="color:#FFFFFF"><strong>URL</strong></td>
		</tr>

		<tr bgcolor="#FFFFCC">
			<td><strong>AU</strong></td>
			<td><a href="http://test.remotestaff.com.au/conf/switch.php?id=1" target="_blank">test.remotestaff.com.au/conf/switch.php?id=1</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>UK</strong></td>
			<td><a href="http://test.remotestaff.com.au/conf/switch.php?id=2" target="_blank">test.remotestaff.com.au/conf/switch.php?id=2</a></td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td><strong>US</strong></td>
			<td><a href="http://test.remotestaff.com.au/conf/switch.php?id=3" target="_blank">test.remotestaff.com.au/conf/switch.php?id=3</a></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><strong>PH</strong></td>
			<td><a href="http://test.remotestaff.com.au/conf/switch.php?id=4" target="_blank">test.remotestaff.com.au/conf/switch.php?id=4</a></td>
		</tr>
	</table>	
	
	<p style="font:11px verdana;">i0MpD3k6yqTz</p>
	<p style="font:11px verdana;">@fab remotestaff prod deploy:repo=portal,changeset=2884</p>
	<p style="font:11px verdana;">@fab remotestaff prod restart_django_portal</p>

		
</body>
</html>
