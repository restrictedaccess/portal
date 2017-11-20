<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff</title>
<link rel=stylesheet type=text/css href="../css/font.css">
</head>
<body style="margin-top:0; margin-left:0">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /><br />
<h3 align="center">First Invoice</h3>
<p align="center">{$from|date_format:"%B %e, %Y"} to {$to|date_format:"%B %e, %Y"}</p>
<table width="100%" cellpadding="2" cellspacing="1" bgcolor="#cccccc" >
<tr bgcolor="#333333">
<td width="5%" style="color:#FFFFFF; font-weight:bold;">#</td>
<td width="29%" style="color:#FFFFFF; font-weight:bold;">CLIENT</td>
<td width="35%" style="color:#FFFFFF; font-weight:bold;">STAFF</td>
<td width="31%" style="color:#FFFFFF; font-weight:bold;" align="center">INVOICE NUMBER / STATUS</td>

</tr>
<span style="visibility:hidden;">{counter start=0 skip=1}</span>
{foreach from=$client_list item=client_list name=client_list}
{ if $client_list.status eq $status}
	<tr bgcolor="{cycle values=#eeeeee,#d0d0d0}">
	<td >{counter}</td>
	<td >{$client_list.leads_id} {$client_list.client}</td>
	<td >
	<div>{$client_list.userid} {$client_list.staff}</div>
	<div>{$client_list.starting_date|date_format:"%B %e, %Y"}</div>
	</td>
	<td align="center">{$client_list.invoice_number}<br />
	<em>
	{ if $client_list.status eq 'paid'}
	{$client_list.status}
	{else}
	{$client_list.status}<br />Due Date : {$client_list.invoice_payment_due_date|date_format:"%B %e, %Y"}
	{/if}
	</em>
	</td>
	</tr>
{/if}

{/foreach}
</table>

</body>
</html>