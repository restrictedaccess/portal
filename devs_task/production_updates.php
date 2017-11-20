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
<title>Portal Updates</title>
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
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Recruitment ASL Reporting</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_asl_reporting.php" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_asl_reporting.php</a></td>
			<td>11-11-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Inhouse Payroll</td>
			<td><a href="https://remotestaff.com.au/portal/payroll/" target="_blank">remotestaff.com.au/portal/payroll</a></td>
			<td>11-11-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Activity Logger</td>
			<td><a href="https://remotestaff.com.au/portal/aclog/" target="_blank">remotestaff.com.au/portal/aclog</a></td>
			<td>10-23-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Identical Resume Detector @wf 4733</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/staff_information.php?userid=5671" target="_blank">remotestaff.com.au/portal/recruiter/staff_information.php</a></td>
			<td>10-15-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Recruiter Job Order Summary</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruiter_job_orders_view_summary.php" target="_blank">remotestaff.com.au/portal/recruiter/recruiter_job_orders_view_summary.php</a></td>
			<td>10-1-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Recruitment Sheet Mongo based</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruitment_sheet.php" target="_blank">remotestaff.com.au/portal/recruiter/recruitment_sheet.php</a></td>
			<td>10-1-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Session test generation / test admin</td>
			<td><a href="https://remotestaff.com.au/portal/test_admin/" target="_blank">remotestaff.com.au/portal/test_admin</a></td>
			<td>9-25-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Workflow Enhancement for Client, Managers, Subcon and admin</td>
			<td><a href="https://remotestaff.com.au/portal/django/workflow/search/" target="_blank">remotestaff.com.au/portal/django/workflow/search/</a></td>
			<td>9-19-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Remote Staff Registration Facebook Application. WF 4564</td>
			<td><a href="https://remotestaff.com.au/portal/application_form/registernow-step1-personal-details.php" target="_blank">remotestaff.com.au/portal/application_form/registernow-step1-personal-details.php</a></td>
			<td>9-3-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Reffer a Frient for Job Seeker</td>
			<td><a href="https://remotestaff.com.au/portal/jobseeker/refer_a_friend.php" target="_blank">remotestaff.com.au/portal/jobseeker/refer_a_friend.php</a></td>
			<td>9-3-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Referral Sheet for Recruiter</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/referrals.php" target="_blank">remotestaff.com.au/portal/recruiter/referrals.php</a></td>
			<td>9-3-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Django based List of Subcontractors. Re [RS Bug Report] #89.</td>
			<td><a href="https://remotestaff.com.au/portal/django/subcontractors/subcons/active" target="_blank">remotestaff.com.au/portal/django/subcontractors/subcons/active</a></td>
			<td>9-2-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Recruitment Team Shortlist Reports.</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruitment_team_shortlists.php" target="_blank">remotestaff.com.au/portal/recruiter/recruitment_team_shortlists.php</a></td>
			<td>9-2-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Django app Bulletin Board for Admin and Subcon</td>
			<td><a href="https://remotestaff.com.au/portal/django/bulletin_board" target="_blank">remotestaff.com.au/portal/django/bulletin_board</a></td>
			<td>8-28-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Django Base Subcon Payment Details. WF 4176</td>
			<td><a href="https://remotestaff.com.au/portal/django/subcontractors/subcon_payment_details/" target="_blank">remotestaff.com.au/portal/django/subcontractors/subcon_payment_details/</a></td>
			<td>8-20-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Skill Test Kenexa </td>
			<td><a href="https://remotestaff.com.au/portal/skills_test/" target="_blank">remotestaff.com.au/portal/skills_test</a></td>
			<td>6-18-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Remote Ready - Request for Prescreened Reporting</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/request_for_prescreen.php" target="_blank">remotestaff.com.au/portal/recruiter/request_for_prescreen.php</a></td>
			<td>6-13-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>SMS Sender on Admin Resume</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/sms_sender.php?userid=5671" target="_blank">remotestaff.com.au/portal/recruiter/sms_sender.php</a></td>
			<td>5-27-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Added promo code on the Registration Button located on homepage of .com.ph site</td>
			<td><a href="https://remotestaff.com.au/portal/jobseeker/promo_codes.php" target="_blank">remotestaff.com.au/portal/jobseeker/promo_codes.php</a></td>
			<td>5-27-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Commission Management in Admin, Client and Subcon portal</td>
			<td><a href="https://remotestaff.com.au/portal/django/commission/" target="_blank">remotestaff.com.au/portal/django/commission</a></td>
			<td>3-11-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Re-designed Job Seeker Portal</td>
			<td><a href="https://remotestaff.com.au/portal/jobseeker/" target="_blank">https://remotestaff.com.au/portal/jobseeker/</a></td>
			<td>2-13-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Integration of Mike Lacanilao's Record Script on New Jobseeker PortalFurther improve skill searching on autocomplete</td>
			<td><a href="https://remotestaff.com.au/portal/application_form/registernow-step7-upload-voice-recording.php" target="_blank">remotestaff.com.au/portal/application_form/registernow-step7-upload-voice-recording.php</a></td>
			<td>2-11-2013</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Bug Report for admin, client and subcon</td>
			<td><a href="https://remotestaff.com.au/portal/bugreport/index.php?/reportform/popup" target="_blank">remotestaff.com.au/portal/bugreport</a></td>
			<td>12-17-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Meeting Calendar Django Based</td>
			<td><a href="https://remotestaff.com.au/portal/django/meeting_calendar/view/?admin_id=43&view_mode=my_sched&view_other_admin=0" target="_blank">remotestaff.com.au/portal/django/meeting_calendar/view</a></td>
			<td>10-24-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td> Active Subcon list reporting</td>
			<td><a href="https://remotestaff.com.au/portal/subconlist_reporting/" target="_blank">remotestaff.com.au/portal/subconlist_reporting</a></td>
			<td>10-24-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Recruiter's new hire reporting</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruitment_contract_dashboard.php" target="_blank">remotestaff.com.au/portal/recruiter/recruitment_contract_dashboard.php</a></td>
			<td>10-24-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>New Hire Reporting</td>
			<td><a href="https://remotestaff.com.au/portal/new_hires_reporting.php" target="_blank">remotestaff.com.au/portal/new_hires_reporting.php</a></td>
			<td>10-16-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Client's Sub Account creation for Admin and Client </td>
			<td><a href="https://remotestaff.com.au/portal/django/Manager/" target="_blank">remotestaff.com.au/portal/django/Manager</a></td>
			<td>9-19-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Create Jobseeker account via recruiter side</td>
			<td><a href="https://remotestaff.com.au/portal/candidates/index.php" target="_blank">remotestaff.com.au/portal/candidates/index.php</a></td>
			<td>9-19-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Django based Admin Users Management</td>
			<td><a href="https://remotestaff.com.au/portal/django/rsadmin/" target="_blank">remotestaff.com.au/portal/django/rsadmin/</a></td>
			<td>9-19-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Leads ASL email settings in Admin/BP portal</td>
			<td><a href="https://remotestaff.com.au/portal/leads_invoice_setting.php?id=7915" target="_blank">remotestaff.com.au/portal/leads_invoice_setting.php</a></td>
			<td>9-19-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Converting Client into Prepaid Invoice</td>
			<td><a href="https://remotestaff.com.au/portal/contractForm.php?sid=3049" target="_blank">remotestaff.com.au/portal/contractForm.php?sid=3049</a></td>
			<td>9-4-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Prepaid Clients Conversion Page</td>
			<td><a href="https://remotestaff.com.au/portal/admin_prepaid_clients.php" target="_blank">remotestaff.com.au/portal/admin_prepaid_clients.php</a></td>
			<td>9-4-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Prepaid Invoice Mass Generation and Adjustment</td>
			<td><a href="https://remotestaff.com.au/portal/AdminMassGeneratePrepaidAdjustments/AdminMassGeneratePrepaidAdjustments.html" target="_blank">remotestaff.com.au/portal/AdminMassGeneratePrepaidAdjustments/AdminMassGeneratePrepaidAdjustments.html</a></td>
			<td>9-4-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Prepaid Invoice Management</td>
			<td><a href="https://remotestaff.com.au/portal/AdminPrepaidInvoiceManagement/AdminPrepaidInvoiceManagement.html" target="_blank">remotestaff.com.au/portal/AdminPrepaidInvoiceManagement/AdminPrepaidInvoiceManagement.html</a></td>
			<td>9-4-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Client Available Balance Search</td>
			<td><a href="https://remotestaff.com.au/portal/AdminRunningBalanceClientSearch/ClientSearch.html" target="_blank">remotestaff.com.au/portal/AdminRunningBalanceClientSearch/ClientSearch.html</a></td>
			<td>9-4-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Recritment Sheet</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruitment_sheet.php" target="_blank">remotestaff.com.au/portal/recruiter/recruitment_sheet.php</a></td>
			<td>8-19-2012</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Recruitment Dash Board</td>
			<td><a href="https://remotestaff.com.au/portal/recruiter/recruitment_sheet_dashboard.php" target="_blank">remotestaff.com.au/portal/recruiter/recruitment_sheet_dashboard.php</a></td>
			<td>8-19-2012</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>RS Office Seat Booking</td>
			<td><a href="https://remotestaff.com.au/portal/seatbooking/seatb.php?/index/" target="_blank">remotestaff.com.au/portal/seatbooking/</a></td>
			<td>3-12-2013</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Job Title Price Management for Custom Recruitment Ordering page</td>
			<td><a href="https://remotestaff.com.au/portal/job_titles.php" target="_blank">remotestaff.com.au/portal/job_titles.php</a></td>
			<td>10-18-2011</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>Leave Request for Admin, Client and Subcon Portal</td>
			<td><a href="https://remotestaff.com.au/portal/leave_request_management.php" target="_blank">remotestaff.com.au/portal/leave_request_management.php</a></td>
			<td>10-18-2011</td>
		</tr>
		<tr bgcolor="#FFFFCC">
			<td>Workflow for Client, Subcon and Admin</td>
			<td><a href="https://remotestaff.com.au/portal/django/workflow/staff/" target="_blank">remotestaff.com.au/portal/django/workflow/staff/</a></td>
			<td>3-15-2011</td>
		</tr>
</table>

</body>
</html>
