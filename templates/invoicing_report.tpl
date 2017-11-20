{*
2011-03-08  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Portal Administrator Home</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">




</head>
<body style="margin-top:0; margin-left:0" >
<input type="button" value="Export to Excel" onClick="location.href='export-invoicing-report.php'" >
<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr bgcolor="#333333">
  <td width="14%" style="font-weight:bold; color:#FFFFFF;">Client</td>
  <td colspan="5" width="57%">
	  <table width="100%" cellpadding="0" cellspacing="0">
		  <tr>
		  <td width="30%" style="font-weight:bold; color:#FFFFFF; padding-left:5px;">Staff</td>
		  <td align="center" width="20%" style="font-weight:bold; color:#FFFFFF; border-left:#CCCCCC solid 1px;">Monthly Rate</td>
		  <td align="center" width="10%" style="font-weight:bold; color:#FFFFFF; border-left:#CCCCCC solid 1px;">Work Status</td>
		  <td align="center" width="20%" style="font-weight:bold; color:#FFFFFF; border-left:#CCCCCC solid 1px;">Staff Invoice Amount in PHP for December 2011</td>
		  <td align="center" width="20%" style="font-weight:bold; color:#FFFFFF; border-left:#CCCCCC solid 1px;">Client Charge Out Rate </td>
		  </tr>
	  </table>
  </td>
  <td align="center" width="14%" style="font-weight:bold; color:#FFFFFF;">Client Invoice amount for Dec 2011 </td>
  <td align="center" width="14%" style="font-weight:bold; color:#FFFFFF;">Client Invoice amount for January 2012</td>
</tr>  
{ foreach from=$clients item=client name=client }
<tr bgcolor="{$client.bgcolor}">
  <td valign="top" >( { $client.no_of_staff } ) #{ $client.leads_id } { $client.fname|capitalize } { $client.lname|capitalize }</td>
  <td colspan="5" >
       <table width="100%" cellpadding="0" cellspacing="0" style="height:auto">
       { foreach from=$client.staffs item=staff name=staff }
			<tr bgcolor="{$client.bgcolor}">
			  <td width="30%" style="padding-left:5px;" >{ $staff.staff_name|capitalize }</td>
			  <td align="center" width="20%" style="border-left:#CCCCCC solid 1px; height:27px;">{ $staff.staff_monthly }</td>
			  <td align="center" width="10%" style="border-left:#CCCCCC solid 1px; height:27px;" >{ $staff.work_status }</td>
			  <td align="center" width="20%" style="border-left:#CCCCCC solid 1px; height:27px;">
			  { foreach from=$staff.invoice item=invoice name=invoice}
			      <div align="right" style="font-size:9px; color:#999999;">
				      invoice #{$invoice.invoice_id} {$invoice.currency} {$invoice.total_amount}<br>
				  </div>
			  { /foreach}
			  </td>
			  <td align="center" width="20%" style="border-left:#CCCCCC solid 1px; height:27px;">{ $staff.client_price }</td>
			</tr>  
		{ /foreach }
       </table>
  </td>
  <td valign="middle" >
  <div align="right" style="font-size:9px; color:#999999;">
  { foreach from=$client.dec_invoices item=invoice name=invoice }
      invoice #{$invoice.invoice_number} {$invoice.status} {$invoice.total_amount}<br>
  { /foreach }
  </div>
  <div align="right" style="font-weight:bold;">Total Amount : { $client.dec_total_amount }</div>
  </td>
  <td valign="middle" >
  <div align="right" style="font-size:9px; color:#999999;">
  { foreach from=$client.jan_invoices item=invoice name=invoice }
      invoice #{$invoice.invoice_number} {$invoice.status} {$invoice.total_amount}<br>
  { /foreach }
  </div>
  <div align="right" style="font-weight:bold;">Total Amount : { $client.jan_total_amount }</div>
  </td>
</tr>	

	    

{ /foreach }
</table>
</body>
</html>
