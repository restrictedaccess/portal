<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff</title>
<link rel=stylesheet type=text/css href="../css/font.css">
</head>
<body style="margin-top:0; margin-left:0">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /><br />
<div style="text-align:center; text-transform:capitalize;">
{if $list }
	<strong>{$list} today<br />{$date_today}</strong>
{else}
	{if $date_hdr}
		{$date_hdr}
	{else}
		{$start_date_str|date_format:"%B %e, %Y"} - {$end_date_str|date_format:"%B %e, %Y"}
	{/if}
	<br />
	<strong>{$status_str}</strong>
{/if}
</div>
<table width="100%" cellpadding="2" cellspacing="1" style="border:#CCCCCC solid 1px;">
{$staff_list}
</table>
</body>
</html>