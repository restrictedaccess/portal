{*
2011-08-16 Normaneil Macutay <normanm@remotestaff.com.au>    
*}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Remote Staff Client Active Staff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script language=javascript src="js/functions.js"></script>

</head>
<body style="margin-top:0; margin-left:0" >
{php}include("header.php"){/php}
{php}include("client_top_menu.php"){/php}

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<td width="173" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; ' >
	{php}include("clientleftnav.php"){/php}
</td>

<td valign="top" align="center" style="padding:10px;"> 
{foreach from=$staffs name=staff item=staff}
<div class="staff_box" style='float:left; width:250px; height:105px; display:block; background:#FFFFFF; border:#CCCCCC solid 1px; margin:5px;'>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="30%" valign="top">
<img src="http://www.remotestaff.com.au/portal/tools/staff_image2.php?w=70&h=90&id={$staff.userid}" />
</td>
<td width="70%" valign="top" style="padding-left:15px;">
<strong>{$staff.fname} {$staff.lname}</strong><br />
{$staff.contract_status}<br />
<small>
#{$staff.userid}<br />
{$staff.job_designation}<br />
{$staff.client_timezone} {$staff.client_start_work_hour}<br />
{$staff.login_status}<br />
</small>

</td>

</tr>
</table>
</div>
{/foreach}
</td>

</tr>
</table>
{php}include("footer.php"){/php}
</body>
</html>