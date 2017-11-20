<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff</title>
<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel=stylesheet type=text/css href="/portal/site_media/subcontractors/css/subcontractors.css">
<script type="text/javascript" src="/portal/js/MochiKit.js"></script>
<script type="text/javascript" src="/portal/site_media/subcontractors/js/subcontractors.js"></script> 

<link rel=stylesheet type=text/css href="/portal/site_media/subcontractors/css/subcontractors_updates.css">
<script src="/portal/site_media/client_portal/js/jquery.min.js"></script>


</head>
<body>

<img src="/portal/system_wide_reporting/media/images/remote-staff-logo.jpg" align="absmiddle" /><br />
<form name="form1" id="form1" method="post" enctype="multipart/form-data" action="{$script_filename}" accept-charset = "utf-8">
<input type="hidden" name="submit_check" id="submit_check" value="1"  />
<div class="wrapper">
    <div class="container">
        <ul class="menu" rel="sam1">
            <li><a href="./adminHome.php">Admin Home</a></li>
            <li><a href="./subconlist.php">List of Subcontractors</a></li>
            <li><a class="wrapper_selected" href="./subcontractors_updates.php">Staff Contract Updates Report</a></li>
            
        </ul>
    </div>
</div>
<div id="content"> 
<h2 align="center">Staff Contracts Latest Updates</h2>
<fieldset style=" width:90%; margin:auto;">
    <legend>Search</legend>
    <div align="center">
    <select name="year" id="year">
        <option value="">All</option>
        {foreach from=$YEARS name=Y item=Y}
            <option value="{$Y}" {if $year eq $Y} selected="selected" {/if}>{$Y}</option>
        {/foreach}
    </select>
    <select name="month" id="month">
        <option value="">All</option>
        {foreach from=$MONTHS key=k item=v}
            <option value="{$v}" {if $month eq $v} selected="selected" {/if}>{$k}</option>
        {/foreach}
    </select>
    
    CSRO : <select name="csro" id="csro" class="select_box">
<option value="">-</option>
{$team_Options}
</select>
    Client Days Before Suspension
    <select name="days_before_suspension" id="days_before_suspension">
	    <option value="">-</option>
        {foreach from=$DBS name=d item=d}
            <option value="{$d}" {if $days_before_suspension eq $d} selected="selected" {/if}>{$d}</option>
        {/foreach}
    </select>
    
    Staff Status
    <select name="contract_status" id="contract_status">
	    <option value="">-</option>
        {foreach from=$CONTRACT_STATUS_ARRAY name=cs item=cs}
            <option value="{$cs}" {if $contract_status eq $cs} selected="selected" {/if}>{$cs}</option>
        {/foreach}
    </select>
    <br />
    
    <fieldset id="include_changes_in"><legend>Include Changes in</legend>{$checkboxes}</fieldset>
    <input type="submit" name="submit_btn" id="submit_btn" value="search" />
    </div>
            
</fieldset>
<div align="center" style="clear:both; padding:5px; font-weight:bold;">{$numrows} records found</div>
<!--
<div align="center">Page
<select name="page" id="page" >
{foreach from=$page_numbers key=k item=v}
    <option value="{$v}" {if $pageNum eq $v} selected="selected" {/if}>{$v}</option>
{/foreach}
</select>
of {$maxPage}
</div>
-->

<table align="center" id="" cellspacing="1" cellpadding="3" width="100%" bgcolor="#ccc">
	<thead style="background: #333; color: #fff;">
		<th>Subcon ID/Staff Name</th>
		<th>Client Name</th>
		<th>Days<br>Before<br>Suspension</th>
		<th>Csro</th>
        <th>Latest<br>Date Changed</th>
        <th width:15%;>Client Rates<br><small>(All History)</small></th>
        <th width:14%;>Staff Rates<br><small>(All History)</small></th>
        <th>Approved By</th>
		<th>Status</th>
		<th>Note</th>
	</thead>
	<tbody>
    {foreach from=$SUBCONS name=subcon item=subcon }
		<tr class="tr_subcon" style="background: #fff;">
			<td valign="top" class="first_column"><a href="./contractForm.php?sid={$subcon.subcon_id}" target="_blank">{$subcon.staff.fname} {$subcon.staff.lname}</a>
            </td>
			<td valign="top">{$subcon.lead.fname} {$subcon.lead.lname}</td>
			<td align="center" valign="top">{$subcon.days_before_suspension}</td>
			<td valign="top">{$subcon.csro.admin_fname} {$subcon.csro.admin_lname}&nbsp;</td>
            <td valign="top">{$subcon.date_change|date_format}&nbsp;</td>
            <td valign="top" align="right">
                {foreach from=$subcon.client_rates name=client_rate item=client_rate}
                    <div style="border-bottom:#ccc solid 1px; margin-bottom:3px; background:{cycle values=#fff,#f5f5f5}">
                        <span style="float:left; margin-right:5px;">{$client_rate.start_date|date_format}</span>
                        <small>{$client_rate.work_status}</small>
                        {$client_rate.rate}/M | {$client_rate.client_hourly|string_format:"%.2f"}/H 
                        <!--
                        {if $client_rate.end_date}{$client_rate.rate}{else}<strong>{$client_rate.rate}</strong>{/if}
                        -->
                        <br clear="all" />
                    </div>
                {foreachelse}
                    None    
                {/foreach}
                <!--<div><a href="subcontractors_staff_rate/client_rates.php?sid={$subcon.subcon_id}" target="_blank">Resync Client Rates</a></div>-->
            </td>
            <td valign="top" align="right">
                {foreach from=$subcon.staff_rates name=staff_rate item=staff_rate}
                    <div style="border-bottom:#ccc solid 1px; margin-bottom:3px; background:{cycle values=#fff,#f5f5f5}">					
                        <span style="float:left; margin-right:5px;">{$staff_rate.start_date|date_format}</span> 
                        <small>{$staff_rate.work_status}</small> 
                        {$staff_rate.rate}/M | {$staff_rate.staff_hourly|string_format:"%.2f"}/H
						<br clear="all" />
                    </div>
                {foreachelse}
                    None    
                {/foreach}</td>
            <td valign="top">{$subcon.admin.admin_fname} {$subcon.admin.admin_lname}</td>
            <td valign="top">{$subcon.status|lower}</td>
            <td valign="top">{if $subcon.comment_note}
            		<a href="#" class="howdy" data-comment="{foreach from=$subcon.comment_note name=comment item=comment}
            		{$comment.admin} ~ {$comment.date_time} : <em>{$comment.comment}</em>{/foreach}">view note</a>
                {/if}
               
            </td>
		</tr>
	{foreachelse}
        <tr><td class="first_column" colspan="9">No records found.</td></tr>	
    {/foreach}
	</tbody>
</table>
<br clear="all" />
</div>
</form>
<script type="text/javascript" src="/portal/site_media/subcontractors/js/subcontractors_updates.js"></script>
</body>
</html>