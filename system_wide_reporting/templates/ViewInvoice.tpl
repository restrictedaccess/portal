<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff</title>
<link rel=stylesheet type=text/css href="../css/font.css">
</head>
<body style="margin-top:0; margin-left:0">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /><br />
<h3 align="center">{$label} INVOICE</h3>
<p align="center">{$from|date_format:"%B %e, %Y"} to {$to|date_format:"%B %e, %Y"}</p>
<table width="100%" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC" >
<tr bgcolor="#333333">
<td width="5%" style="font-weight:bold; color:#FFFFFF">#</td>
<td width="25%" style="font-weight:bold; color:#FFFFFF">{$label} NAME</td>
<td width="40%" style="font-weight:bold; color:#FFFFFF">DESCRIPTION</td>
<td width="30%" align="center" style="font-weight:bold; color:#FFFFFF">
{if $table eq 'client_invoice'}
INVOICE NUMBER
{else}
INVOICE ID
{/if}
/ STATUS</td>
</tr>
{foreach from=$invoices item=invoice name=invoice}
<tr bgcolor="{cycle values=#eeeeee,#d0d0d0}">
<td >{$smarty.foreach.invoice.iteration}</td>
<td >{$invoice.type_id} {$invoice.fname} {$invoice.lname}<br />
	<small>{$invoice.email}</small>
</td>
<td >{$invoice.description}</td>
<td align="center" >
{if $table eq 'client_invoice'}
{$invoice.invoice_number}
{else}
{$invoice.id}
{/if}
<br/> <em>
{if $label eq 'SUBCON'}
{$invoice.status}
{else}
	{$status}
	{if $status neq 'paid' }
	<br />Due Date : {$invoice.invoice_payment_due_date|date_format:"%B %e, %Y"}
	{/if}
{/if}
</em>
</td>
</tr>
{/foreach}
</table>
</body>
</html>