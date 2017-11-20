{*
2011-01-07  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Remotestaff Leave Request Form</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./leave_request_form/media/css/leave_request.css">

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<link rel="stylesheet" type="text/css" href="./leave_request_form/media/css/antique.css" />


<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./js/functions.js"></script>
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>


<script type="text/javascript" src="./leave_request_form/media/js/leave_request_form.js"></script>
</head>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"> 
<form name="form" method="post" enctype="multipart/form-data"  onsubmit="return CheckLeaveRequest()" accept-charset = "utf-8">
<input type="hidden" name="leads" id="leads" />
<input type="hidden" name="userid" id="userid" value="{$userid}" />
<input type="hidden" name="user_type" id="user_type" value="{$user_type}" />

{php}include("header.php"){/php}
<table width="100%" cellpadding=0 cellspacing=0 border=0 >
<tr bgcolor="#abccdd">
<td colspan="2"  style="font: 8pt verdana; height:20px; ">&#160;&#160;<strong>{$staff.fname} {$staff.lname}</strong></td>
</tr>
<tr>
<td width="173" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
{php}include ("subconleftnav.php"){/php}
</td>
<td valign="top">
<div id="lrm">
<h2>LEAVE REQUEST FORM</h2>

<table width="100%" cellpadding="0" cellspacing="1" >

<tr bgcolor="#FFFFFF">
<td colspan="2">

<div style="float:left;">
<p>Clients : <br />
<select id="leads_id" name="leads_id" onchange="ShowStaffRequestedLeaveToClient()">{$leads_Options}</select>
<input type="button" value="Request a Leave" onclick="RequestLeave()" /> 
<span><strong>&nbsp;</strong></span></p>
</div>
<div style="float:right">
<table align="right" border="0" >
		<tr>
		<td bgcolor="#00FF00">&nbsp;</td>
		<td>Approved</td>
		<td bgcolor="#FFFF00">&nbsp;</td>
		<td>Pending</td>
		<td bgcolor="#FF0000">&nbsp;</td>
		<td>Denied</td>
		<td bgcolor="#CCCCCC">&nbsp;</td>
		<td>Cancelled</td>
		<td bgcolor="#0000FF">&nbsp;</td>
		<td>Marked Absent</td>
		</tr>
</table>
</div>
<div style="clear:both"></div>
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td valign="top" width="25%" >

<div id="staff_list"></div>
</td>
<td valign="top" width="75%">

<div id="right_panel">
{if $result_msg}
	<div style="background:#FFFF00; padding:3px; text-align:center; font-size:11px; font-weight:bold; display:block; width:500px; margin-left:20px;">{$result_msg}</div>
{/if}
</div>
</td>
</tr>
</table>

</div>
</td>
</tr>
</table>
{php}include("footer.php"){/php}

{literal}
<script>  ShowStaffRequestedLeaveToClient();</script>
{/literal}


{literal}
<script> ShowStaffAllRequestedLeave(); </script>
{/literal}


</form>
</body>
</html>

