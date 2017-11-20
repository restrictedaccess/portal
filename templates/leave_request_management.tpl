{*
2011-01-12 Normaneil Macutay <normanm@remotestaff.com.au>    
*}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Remotestaff Leave Request Form</title>
<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="./leave_request_form/media/css/leave_request.css">

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<link rel="stylesheet" type="text/css" href="./leave_request_form/media/css/antique.css" />

<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./js/functions.js"></script>
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>


<script type="text/javascript" src="./leave_request_form/media/js/leave_request_form.js"></script>

</head>
<body style="margin-top:0; margin-left:0">
<form name="parentForm" method="post" enctype="multipart/form-data" action="#" accept-charset = "utf-8">
<input type="hidden" name="leads" id="leads" />
<input type="hidden" name="userid" id="userid"  />
<input type="hidden" name="user_type" id="user_type" value="{$user_type}" />

{if $page_type neq "iframe" }
	{php}include("header.php"){/php}
	
	{if $client_section eq True}
		{php}include("client_top_menu.php"){/php}
	{/if}
	
	{if $admin_section eq True}
		{php}include("admin_header_menu.php"){/php}
	{/if}
{/if}

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
{if $page_type neq "iframe" }
<td width="173" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; ' >

	{if $client_section eq True}
		{php}include("clientleftnav.php"){/php}
	{/if}
	
	{if $admin_section eq True}
		{php}include("adminleftnav.php"){/php}
	{/if}
</td>
{/if}

<td valign="top">
<!-- content -->
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



<table width="100%" cellpadding="0" cellspacing="1" >

<tr bgcolor="#FFFFFF">
<td valign="top" width="25%" >
<div id="staff_list"></div>
</td>
<td valign="top" width="75%">
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
</td>

</tr>
</table>
{if $page_type neq "iframe" }
	{php}include("footer.php"){/php}
{/if}
{literal}
<script> ShowStaffList() </script>
{/literal}
</form>

</body>
</html>
