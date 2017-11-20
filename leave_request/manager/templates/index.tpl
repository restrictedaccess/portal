<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leave Request Management</title>

<link href="../../site_media/workflow_v2/js/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../../site_media/workflow_v2/js/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<script src="../../site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script  src="../../site_media/workflow_v2/js/modernzr.js"></script>    
<script  src="../../site_media/workflow_v2/js/bootstrap/js/bootstrap.min.js"></script>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../site_media/workflow_v2/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
<link rel="shortcut icon" href="../../favicon.ico">


<link rel="stylesheet" type="text/css" media="all" href="../../css/calendar-blue.css" title="win2k-1" />
<link rel="stylesheet" type="text/css" href="../../leave_request_form/media/css/antique.css" />
<link rel=stylesheet type=text/css href="./media/css/lrm.css">
<script type="text/javascript" src="../../js/calendar.js"></script> 
<script type="text/javascript" src="../../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../../js/calendar-setup.js"></script>
    
</head>

<body>
<h3 align="center" >Staff Leave Request Management</h3>
<table border="0" style="float:right; width:35%; font-size:11px !important; font-family:tahoma !important; line-height:11px !important;" >
    <tr>
    <td bgcolor="#009900">&nbsp;</td>
    <td>Approved</td>
    <td bgcolor="#FFFF00">&nbsp;</td>
    <td>Pending</td>
    <td bgcolor="#FF0000">&nbsp;</td>
    <td>Denied</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td>Cancelled</td>
    <td bgcolor="#0000FF">&nbsp;</td>
    <td>Marked Absent</td>
    </tr>
</table>
<form name="form" id="form" method="post">
<div>Select Staff : 
    <select name="userid" id="userid">
    	<option value="">All Staff</option>
    	{foreach from=$staffs item=staff name=staff}
        	<option {if $userid eq $staff.userid} selected{/if} value="{$staff.userid}">{$staff.fname|capitalize} {$staff.lname|capitalize}</option>
        {/foreach}
    </select>
    
    Selected Year:
    <select name="year" id="year" style="width:100px;">
    	{$yearOptions}
    </select>
    <button>Go</button> 
</div>
</form>
<hr>
<table width="100%" style="margin:auto" border="0">
	<tr>
    	<td width="30%" valign="top"><div id="leave_reqeust_container"><img src="../../images/ajax-loader.gif" /></div></td>
        <td width="70%" valign="top" align="center">
        <div align="right"><a href="./">Go back to All Staff Leave Calendar</a></div>
        	<div id="leave_request_result">
                <div align="center" id="calendar_indication">{$calendar_indication_str}</div>
                {$calendar}
            </div>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
</body>
<script type="text/javascript" src="./media/js/lr.js"></script>
</html>