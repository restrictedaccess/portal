<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$meta_title}</title>

<link rel="stylesheet" type="text/css" href="./media/css/overlay.css" />
<link rel="stylesheet" type="text/css" href="./media/css/admin.css" />

<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />



{foreach from=$jscripts item=jscript}
    <script src="{$jscript}" type="text/javascript"></script>
{/foreach}

{foreach from=$stylesheets item=stylesheet}
    <link rel="stylesheet" type="text/css" href="{$stylesheet}" />
{/foreach}
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" /> 

</head>
<body {$body_attributes} onload="placeIt()">
<div id="overlay">
<div>
<p>Mark Lead <span id="mark_leads_name"></span> For : </p>
<ul>
<li><input type="radio" name="mark_lead_for" value="Replacement Requests" />Replacement Requests</li>
<li><input type="radio" name="mark_lead_for" value="CSR Concerns" />CSR Concerns</li>
<li><input type="radio" name="mark_lead_for" value="Sales Follow Up" />Sales Follow Up</li>
<input type="button" id="mark_btn" leads_id="" value="mark" onclick="MarkLead()" /> <input type="button" value="close" onclick="fade('overlay')" />
</ul>
</div>
</div>
{if $show_notice eq True}
{ include file="show_notice.tpl" }
{/if}
{ include file="nav.tpl" }
<div id="container">
<!-- Content Starts Here -->
