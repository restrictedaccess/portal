<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Business Partner Communication History for Affiliate #{$aff.agent_no} {$aff.fname} {$aff.lname}</title>

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div><img src='./images/remote_staff_logo.png' width='241' height='70'></div>






<div id="history">
<table  width="100%" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-top:20px;">
    <tr>
    <td width='2%' valign='top'><img src='leads_information/media/images/quote.png'></td>
    <td width='98%' valign='top'  style="border-left:#CCCCCC solid 1px; padding-left:5px;">
    
    
    <div style="vertical-align:top; margin-bottom:10px;">{$message|regex_replace:"/[\r\t\n]/":"<br>"}</div>
    <div style=" color:#999999;">BP #{$bp.agent_no} {$bp.fname} {$bp.lname} - , {$result.date_created|date_format:"%A, %B %e, %Y %H:%M:%S %p"}<br />Communication Type : {if $result.actions eq 'MAIL'} NOTES {else} {$result.actions} {/if}</div>
    </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
</table>
</div>

</body>
</html>


