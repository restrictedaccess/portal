<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="verify-v1" content="LaxjipBphycGX3aaNPJVEJ4TawiiEs/3kDSe15OJ8D8=" />
<link rel="stylesheet" type="text/css" href="../css/font.css" />
<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />

<title>#{$leads_info.id} {$leads_info.fname|capitalize} {$leads_info.lname|capitalize}</title>
</head>
<body>
<table width='100%' cellpadding='2'cellspacing='1' bgcolor="#CCCCCC"  >
<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la" >Fullname</td>
<td width="66%" valign="top" class="td_info"><b>#{$leads_info.id} {$leads_info.fname|capitalize} {$leads_info.lname|capitalize}</b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Status</td>
<td  valign="top" class="td_info"><b style="color:#FF0000;">{$leads_info.status}</b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Promotional Code</td>
<td  valign="top" class="td_info" style="color:#006600;">{$leads_info.tracking_no}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Ratings</td>
<td  valign="top" class="td_info"><span id="ratings">{$starOptions}</span></td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Date Registered</td>
<td  valign="top" class="td_info">{$date_registered}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Primary Email</td>
<td  valign="top" class="td_info">{$leads_info.email}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Alternative Emails</td>
<td  valign="top" class="td_info">

<div  id="alternative_emails_list">
<ol>
{section name=j loop=$alternate_emails}
<li>{$alternate_emails[j].email}</li>
{/section}
</ol>
</div>
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Country / IP</td>
<td width="66%" valign="top" class="td_info">{$leads_info.leads_country} {$leads_info.state}  {$leads_info.leads_ip}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Leads of</td>
<td width="66%" valign="top" class="td_info">{$leads_of}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Company</td>
<td width="66%" valign="top" class="td_info">{$leads_info.company_name|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Company Position</td>
<td width="66%" valign="top" class="td_info">{$leads_info.company_position|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Company Address</td>
<td width="66%" valign="top" class="td_info">{$leads_info.company_address|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Website</td>
<td width="66%" valign="top" class="td_info">{$leads_info.website|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Company Phone</td>
<td width="66%" valign="top" class="td_info">{$leads_info.officenumber|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Mobile Phone</td>
<td width="66%" valign="top" class="td_info">{$leads_info.mobile|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Company Industry</td>
<td width="66%" valign="top" class="td_info">{$leads_info.company_industry}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">No.of Employee</td>
<td width="66%" valign="top" class="td_info">{$leads_info.company_size}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Company Turnover in a Year</td>
<td width="66%" valign="top" class="td_info">{$leads_info.company_turnover}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Company Profile</td>
<td width="66%" valign="top" class="td_info">{$leads_info.company_description|escape}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">No.of Remote Staff neeeded</td>
<td width="66%" valign="top" class="td_info">{$leads_info.remote_staff_needed}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Remote Staff needed</td>
<td width="66%" valign="top" class="td_info">{$leads_info.remote_staff_needed_when|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Remote Staff needed in Home Office</td>
<td width="66%" valign="top" class="td_info">{$leads_info.remote_staff_one_home}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Remote Staff needed in Office</td>
<td width="66%" valign="top" class="td_info">{$leads_info.remote_staff_one_office}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td width="34%" valign="top" class="td_info td_la">Remote Staff responsibilities</td>
<td width="66%" valign="top" class="td_info">{$leads_info.remote_staff_competences|regex_replace:"/[\r\t\n]/":"<br>
  "}</td>
</tr>
<tr bgcolor="#FFFFFF">
<td valign="top" class="td_info td_la">Client Staff Relations Officer</td>
<td valign="top" class="td_info">{$csro_officer.admin_fname} {$csro_officer.admin_lname}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td valign="top" class="td_info td_la">Lead is Inquiring about : </td>
<td valign="top" class="td_info" >
<table width="100%" cellpadding="2" cellspacing="1">
{$job_positions}
</table>

</td>
</tr>


<tr bgcolor="#FFFFFF">
<td  colspan="2" valign="top" class="td_info" ><b style="color:#FF0000;">Contact Details</b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="50%"  valign="top" class="td_info td_la">Accounts Department Staff Name 1</td>
<td width="50%"  valign="top" class="td_info">{$leads_info.acct_dept_name1}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Accounts Department Email 1</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_email1}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Accounts Department Contact nos. 1</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_contact1}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="50%"  valign="top" class="td_info td_la">Accounts Department Staff Name 2</td>
<td width="50%"  valign="top" class="td_info">{$leads_info.acct_dept_name2}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Accounts Department Email 2</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_email2}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Accounts Department Contact nos. 2</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_contact2}</td>
</tr>



<tr bgcolor="#FFFFFF">
<td colspan="2"  valign="top" class="td_info"><b style="color:#FF0000;">Person directly working with sub-contractor in client organization</b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Name</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_staff_name|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Job Title</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_job_title}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Skype</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_skype}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Email</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_email}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Contact</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_contact}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Business Owner/Director/CEO</td>
<td  valign="top" class="td_info">{$leads_info.business_owners}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Business Partners</td>
<td  valign="top" class="td_info">{$leads_info.business_partners}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td colspan="2"  valign="top" class="td_info"><b style="color:#FF0000;">Secondary Contact Person</b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">First Name</td>
<td  valign="top" class="td_info">{$leads_info.sec_fname|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Last Name</td>
<td  valign="top" class="td_info">{$leads_info.sec_lname|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Email</td>
<td  valign="top" class="td_info">{$leads_info.sec_email|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Phone No.</td>
<td  valign="top" class="td_info">{$leads_info.sec_phone|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Company Position</td>
<td  valign="top" class="td_info">{$leads_info.sec_position|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Note</td>
<td  valign="top" class="td_info">{$leads_info.note|escape}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td  valign="top" class="td_info td_la">Preffers to Communicate Via : </td>
<td  valign="top" class="td_info">{$leads_info.preffered_communication}</td>
</tr>


</table>
</body>
