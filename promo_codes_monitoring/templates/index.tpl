<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tracking Links Monitoring</title>

<link href="../site_media/workflow_v2/js/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../site_media/workflow_v2/js/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<script src="../site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../site_media/workflow_v2/js/modernzr.js"></script>    
<script type="text/javascript" src="../site_media/workflow_v2/js/bootstrap/js/bootstrap.min.js"></script>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../site_media/workflow_v2/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
<link rel="shortcut icon" href="../favicon.ico">    
</head>

<body>
<div style="margin:auto; width:70%;">
<h3 align="center">Tracking Links Monitoring</h3>
<p align="center">(Promotional Codes List)</p>
<form name="form" method="post">
<div style="margin:5px;">Owner : 
<select name="tracking_createdby" id="tracking_createdby">
	<option value="">Please Select</option>
	{foreach from=$creators item=creator name=creator}
    	<option {if $tracking_createdby eq $creator.tracking_createdby} selected="selected" {/if}value="{$creator.tracking_createdby}">{$creator.fname} {$creator.lname} - {$creator.work_status}</option>
    {/foreach}
</select> <button>Go</button>
</div>
<hr>
{if $codes}
<table width="100%" cellpadding="1" border="1" style="font-size:11px; font-family:tahoma;">
	<thead>
        <th>Code</th>
        <th>Description</th>
		<th>Date Created</th>
		<th>Points</th>
		<th>Hits</th>

	</thead>
	<tbody>
        {foreach from=$codes item=tracking name=tracking}
        <tr>
            <td valign="top" >{$tracking.tracking_no}
            <td valign="top" >{$tracking.tracking_desc}</td>
            <td valign="top" >{$tracking.tracking_created}</td>
            <td valign="top" align="center" >{if $tracking.points}{$tracking.points}{else}0{/if}</td>
            <td valign="top" align="center" class="tracking_id" tracking_id="{$tracking.id}" id="{$tracking.id}_td"><img src="../images/ajax-loader.gif" width="20" height="20" /></td>
        </tr>
        {/foreach}
    </tbody>

</table>
{/if}
<p align="center" class="muted">Beta version 2014-01-21</p>
</form>
</td>
</body>
<script type="text/javascript" src="../site_media/bulletin_board/js/jquery.ajaxq-0.0.1.js"></script>
<script type="text/javascript" src="./media/js/pcm.js"></script></script>
</html>