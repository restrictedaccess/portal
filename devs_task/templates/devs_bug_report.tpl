<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel=stylesheet type=text/css href="/portal/system_wide_reporting/media/css/system_wide_reporting.css">
<title>Devs Task</title>

</head>
<body id="applicant_list" style="margin-top:0; margin-left:0">

<form name="form" method="post">

	<h3 align="center">Devs Outstanding Bug Report and Work Flow Task</h3>
	<table width="95%" cellpadding="5" cellspacing="1" style="font:11px verdana;" align="center">
		<tr>
			<td bgcolor="#666666" style="color:#FFFFFF" width="5%">BR No</td>
			<td bgcolor="#666666" style="color:#FFFFFF" width="25%">Description</td>
			<td bgcolor="#666666" style="color:#FFFFFF" width="10%">Requestor</td>
			<td bgcolor="#666666" style="color:#FFFFFF" width="10%">Date Requested</td>
			<td bgcolor="#666666" style="color:#FFFFFF" width="10%">Status</td>
			<td bgcolor="#666666" style="color:#FFFFFF" width="20%">Comment</td>
			<td bgcolor="#666666" style="color:#FFFFFF" width="10%">Assign To</td>
			<td bgcolor="#666666" style="color:#FFFFFF" width="10%">Date Fixed</td>
			
		</tr>

		{foreach from=$bg name=bg item=bg}
			<tr>        
				<td width="5%"><a href='/portal/bugreport/?/view_details/{$bg.id}' target="_blank">{$bg.id}</td>
				<td width="25%">{$bg.report_title}</td>
				<td width="10%">{$bg.assignto_ref}</td>
				<td width="10%">{$bg.creation_date}</td>
				<td width="10%">{$bg.STATUS}</td>
				<td width="20%">{$bg.note_content}</td>
				<td width="10%">{$bg.assignto}</td>
				<td width="10%"></td>
				
			</tr>
		{/foreach}
	</table>
	
</form>

</body>
</html>