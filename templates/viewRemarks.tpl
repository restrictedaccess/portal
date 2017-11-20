<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>RemoteStaff Remarks #{$leads_info.id} {$leads_info.fname|capitalize} {$leads_info.lname|capitalize} </title>
<link rel=stylesheet type=text/css href="css/font.css">

</head>
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">
<script language=javascript src="js/functions.js"></script>
<div style="padding:5px;"><img src='./images/remote_staff_logo.png' width='241' height='70'></div>
<div style="text-align:right;">
<a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
</div>
<div style="font: 12px Arial;">
<p><b>#{$leads_info.id} {$leads_info.fname|capitalize} {$leads_info.lname|capitalize}</b></p>


<fieldset style="background:#FFF; border: 1px solid #62A4D5 ;">
<legend style="padding:3px; margin-left: 10px; font:bold 14px Arial; border: 1px solid #62A4D5 ; background:#62A4D5; color:#FFFFFF;">Remarks</legend>
<table width="100%" cellpadding="4" >
{section name=j loop=$remarks}
<tr>
<td width="2%" valign="top" style="border-right:#CCCCCC solid 1px;"><img src="leads_information/media/images/quote.png"></td>
<td width="96%" valign="top">
	<div>{$remarks[j].remarks|regex_replace:"/[\r\t\n]/":"<br>"}</div>
	<div style="margin-top:10px; color:#666666;">{$remarks[j].remark_creted_by} ,{$remarks[j].remark_created_on|date_format:"%A, %B %e, %Y %H:%M:%S %p"}</div>
</td>
<td width="2%" valign="top"><span style=" border:#CCCCCC solid 1px; padding:1px; cursor:pointer;" title="delete"><a href="viewRemarks.php?leads_id={$leads_id}&id={$remarks[j].id}"><img src="./images/action_delete.png" align="absmiddle" title="delete" border="0" /></a></span></td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>

{/section}


</table>
</fieldset>
</div>

	

</body>
</html>






