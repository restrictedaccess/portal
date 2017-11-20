{*
2010-10-07  Normaneil Macutay <normanm@remotestaff.com.au>

*}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
 "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrator-Subcontractors Contract Management</title>
<link rel=stylesheet type=text/css href="css/font.css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" enctype="multipart/form-data" action="{$script_filename}" accept-charset = "utf-8">
<input type="submit" name="export" value="Export" >
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#333">
<tr bgcolor="#333333">
<td width="1%" align="center" style="color:#FFF;">#</td>
<td width="9%" align="center" style="color:#FFF;">Staff Name</td>
<td width="9%" align="center" style="color:#FFF;">Client Name</td>
<td width="9%" align="center" style="color:#FFF;">Hiring Manager</td>
<td width="9%" align="center" style="color:#FFF;">CSRO</td>
<td width="9%" align="center" style="color:#FFF;">Business Partner</td>
<td width="9%" align="center" style="color:#FFF;">Recruiter</td>
<td width="8%" align="center" style="color:#FFF;">Service Type</td>
<td width="7%" align="center" style="color:#FFF;">Reason Type</td>
<td width="9%" align="center" style="color:#FFF;">Length Of Contract</td>
<td width="6%" align="center" style="color:#FFF;">Replacement Request</td>
<td width="24%" align="center" style="color:#FFF;">Reason</td>
</tr>


{foreach from=$search_results name=search item=search}
<tr bgcolor="{cycle values='#F2F2F2, #CCCCCC'}">
<td align="center">{$smarty.foreach.search.iteration}</td>
<td align="center">{$search.staff_fname} {$search.staff_lname}</td>
<td align="center">{$search.client_fname} {$search.client_lname}</td>
<td align="center">{$search.hiring_manager}</td>
<td align="center">{$search.csro_name}</td>
<td align="center">{$search.business_partner}</td>
<td align="center">{$search.recruiter}</td>
<td align="center">{$search.service_type}</td>
<td align="center">{$search.reason_type}</td>
<td align="center">{$search.starting_date|date_format} - {$search.staff_contract_finish_date|date_format}<br>{$search.duration}<br>({$search.duration_in_days})<br>
<strong style="color:#F00; text-transform:uppercase;">{$search.status}</strong></td>
<td align="center">{$search.replacement_request}</td>
<td align="center">{$search.reason}</td>
</tr>
{/foreach}


</table>

<input type="hidden" name="_submit_check" value="1"/>
</form>
</body>
</html>

