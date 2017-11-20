<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="verify-v1" content="LaxjipBphycGX3aaNPJVEJ4TawiiEs/3kDSe15OJ8D8=" />
<title>BPO Company Remote Staff Official Website | Hire Offshore Staff from Remote Staff | Outsource Staff, Inexpensive and Professional Online Staff, Virtual Assistant and IT Offshore Outsourcing BPO Services</title>
<meta name="description" content="Outsource staff, inexpensive offshore staff, online staff and Virtual assistant working for you at $4 to $8 per hr, and you don't pay for holidays and sick pay. Save up to 70% off your labour cost with our IT Offshore Outsourcing Services we offer">
<meta name="keywords" content="outsource staff, hire offshore staff, offshore staff, online staff, virtual assistant, IT offshore, offshore outsourcing, outsourcing services, offshore services, remote staff, BPO company, BPO Australia, outsourced staff, offshore labour, offshore hire, offshore labour hire, IT offshore outsourcing, IT offshore staff, labour cost, offshore outsourcing services, outsource offshore, outsource services, IT outsourcing services">
<meta name="ROBOTS" content="NOODP">
<meta name="GOOGLEBOT" content="NOODP"> 
<meta name="title" content="Hire Offshore Staff from Remote Staff | Outsource Staff, Online Staff, Virtual Assistant and IT Offshore Outsourcing Services BPO Company">
<meta name="classification" content="Outsource staff, inexpensive offshore staff, online staff and Virtual assistant working for you at $4 to $8 per hr, and you don't pay for holidays and sick pay. Save up to 70% off your labour cost with our IT Offshore Outsourcing Services we offer">
<meta name="author" content="Remote Staff | Chris J">
<meta name="robots" content="NOYDIR">
<meta name="slurp" content="NOYDIR">
<meta name="robots" content="index all,follow all">
<meta name="revisit-after" content="7 days">
<meta http-equiv="Content-Language" content="en-gb">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
 <link rel=stylesheet type=text/css href="../css/font.css">
<script type="text/javascript" src="../js/addrow-v2.js"></script>
<script src="../media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="../media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">

</head>
<body>
<form method="post" name="form" action="mail_client_tax_invoice.php?client_invoice_id={$client_invoice_id}" accept-charset = "utf-8">
<input type="hidden" name="client_invoice_id" id="client_invoice_id"  value="{$client_invoice_id}" />
<input type="hidden" name="to_counter" id="to_counter_id" value="0"   />
<input type="hidden" name="to_cc" id="to_cc" value="{$cc_counter}" />
<table><tr><td><img src="images/pdf_attached.gif" width="50"></td><td>ATTACHMENT: <font size="2"><strong>invoice.pdf</strong></font></td></tr></table>


<table width="100%" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td  colspan="2" valign="top">This Invoice belongs to Client <strong>{$client_name} - {$email}</strong></td>
</tr>
<tr bgcolor="#FFFFFF">
<td  colspan="2" valign="top"><b>Send this invoice to </b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="9%" valign="top">&nbsp;</td>
<td width="91%" valign="top">
	<div style='margin-bottom:5px;'>Email : <input type="text" name="to[0]" value="{$default_email_field}" size="32"   /> Name : <input type="text" name="to_name[0]" value="{$address_to}" size="32"   /> </div>
		
	<div id="readroot1" style="display:none;margin-bottom:5px;">Email : <input type="text" size="32" name="to[]" /> Name : <input type="text" size="32" name="to_name[]" /></div>
	<div id="writeroot1"></div>
	<span onclick="moreFields(1 , 'to_counter_id')" style="color:#0000FF; text-decoration:underline; cursor:pointer;">Add More Email</span>
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td valign="top"><strong>Add CC </strong>:</td>
<td  valign="top">
	
	{foreach from=$cc_emails name=cc item=cc}
	    <div style='margin-bottom:5px;'>Email : <input type="text" name="cc[{$smarty.foreach.cc.index}]" size="32" value="{$cc.cc_email}"   /> Name : <input type="text" name="cc_name[{$smarty.foreach.cc.index}]" size="32" value="{$cc.cc_name}"   /></div>
	{/foreach}
	
	<div style='margin-bottom:5px;'>Email : <input type="text" name="cc[{$smarty.foreach.cc.total}]" size="32" value="accounts@remotestaff.com.au"   /> Name : <input type="text" name="cc_name[{$smarty.foreach.cc.total}]" size="32" value="{ $admin_name }"   /></div>
	<div id="readroot2" style="display:none;margin-bottom:5px;">Email : <input type="text" name="cc[]" size="32"   /> Name : <input type="text" name="cc_name[]" size="32"   /></div>
	<div id="writeroot2"></div>
	<span onclick="moreFields(2 , 'to_cc')" style="color:#0000FF; text-decoration:underline; cursor:pointer;">Add More Email</span>
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td ><strong>From</strong> :</td>
<td ><input type="text" name="from" size="32" value="accounts@remotestaff.com.au"> { $admin_name }</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Subject</strong> :</td>
<td ><input type="text" name="subject" size="40" value="{ $client_name }: Invoice { $invoice_number }"></td>
</tr>

<tr bgcolor="#FFFFFF">
<td colspan="2" ><strong>Message</strong> : <br />
<textarea name="message" id="heading" cols="48" rows="10" wrap="physical" class="text"  style="width:100%">{$message|regex_replace:"/[\r\t\n]/":"<br>"}</textarea></td>
{literal}
<script type="text/javascript">
	<!--
	tinyMCE.init({mode : "textareas", theme : "simple", relative_urls: false, remove_script_host: false});
	-->
	</script>
{/literal}
</tr>





</table>
<INPUT type="submit" value="SEND" name="submit" class="button" style="width:120px">
</form>
<script type="text/javascript" src="mail_client_tax_invoice.js"></script> 
</body>
</html>
