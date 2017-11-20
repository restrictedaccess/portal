{*
2011-01-12 Normaneil Macutay <normanm@remotestaff.com.au>    
*}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Remotestaff Leave Request Form</title>
<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel=stylesheet type=text/css href="/portal/css/font.css">
<link rel=stylesheet type=text/css href="/portal/leave_request_form/media/css/leave_request.css">
<link rel="stylesheet" type="text/css" media="all" href="/portal/css/calendar-blue.css" title="win2k-1" />
<link rel="stylesheet" type="text/css" href="/portal/leave_request_form/media/css/antique.css" />
<link rel=stylesheet type=text/css href="/portal/site_media/Manager/css/manager.css">
<script type="text/javascript" src="/portal/js/MochiKit.js"></script>
<script type="text/javascript" src="/portal/js/functions.js"></script>
<script type="text/javascript" src="/portal/js/calendar.js"></script> 
<script type="text/javascript" src="/portal/lang/calendar-en.js"></script> 
<script type="text/javascript" src="/portal/js/calendar-setup.js"></script>
<script type="text/javascript" src="/portal/leave_request_form/media/js/leave_request_form.js"></script>

</head>
<body style="margin-top:0; margin-left:0">
{include file="header.tpl"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td valign="top">
<form name="parentForm" method="post" enctype="multipart/form-data" action="#" accept-charset = "utf-8">
<input type="hidden" name="leads" id="leads" />
<input type="hidden" name="userid" id="userid"  />
<input type="hidden" name="user_type" id="user_type" value="{$user_type}" />
<div id="lrm">
<h2 align="center" >STAFF LEAVE REQUEST MANAGEMENT</h2>
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

 
<div id="suggest">Select Staff : <input type="text"  id="inquiring_about" class="inquiring_about" name="inquiring_about" onblur="suggest();" onkeyup="suggest();"  onclick="suggest();"  />
 <input type="button" name="go" value="Search" onclick="ShowStaffAllRequestedLeave()"/>
      <div class="suggestionsBox" id="suggestions" style="display: none;"> 
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
      </div>
</div>



<table align="center" width="98%" cellpadding="0" cellspacing="1" >

<tr bgcolor="#FFFFFF">
<td valign="top" width="25%" >
<div id="staff_list"></div>
</td>
<td valign="top" width="75%" style="padding-left:20px;">
<div id="right_panel">
<div style="margin-left:10px;">
<select name="year" id="year" style="width:100px;" onchange="javascript:document.parentForm.submit();">
{$yearOptions}
</select> Selected Year
<div id="showleave">{$calendar}</div>
</div>
{if $result_msg}
	<div style="background:#FFFF00; padding:3px; text-align:center; font-size:11px; font-weight:bold; display:block; width:500px; margin-left:20px;">{$result_msg}</div>
{/if}
</div>
</td>
</tr>
</table>
<!-- end content -->
</div>

{literal}
<script> ShowStaffList() </script>
{/literal}
</form>
</td>
</tr>
</table>
</body>
</html>