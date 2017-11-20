{*
2010-10-07  Normaneil Macutay <normanm@remotestaff.com.au>

*}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
 "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrator-Subcontractors Contract Management</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="admin_subcon/admin_subcon.css">

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' language='JavaScript' src='js/functions.js'></script>
<script type='text/javascript' src='admin_subcon/admin_subcon.js'></script>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" enctype="multipart/form-data" action="{$script_filename}" accept-charset = "utf-8">
<!-- HEADER -->
{php} include 'header.php'{/php}
{if $admin_status neq 'HR'}
	{php} include 'admin_header_menu.php'{/php}
{else}
	{php} include 'recruiter_top_menu.php'{/php}
{/if}	
<table align="center" width=100% cellpadding=0 cellspacing=0 border=0 >
<tr>

<td width="100%" valign="top" style='border: #006699 2px solid; background:#F3F3F3; padding:10px;'>
<h2 class="h2" align="center">CANCELLATION DASHBOARD</h2>
{php} include 'admin_staff_contract_mangement_menu.php'{/php}	
<div id="main">
<table width="100%" cellspacing="0" >
<tr bgcolor="#CCCCCC">
<td style=" padding:5px;">

<div id="search_form_subconlist">
    
    <div>Business Partner : <select name="business_partner_id" id="business_partner_id"  style="width:150px;">
    <option value="">-</option>
    {$bp_Options}
    </select>
    </div>
    
    <div>Hiring Manager : <select name="hm" id="hm" >
    <option value="">-</option>
    {$hm_Options}
    </select>
    </div>
    
    <div>CSRO : <select name="csro" id="csro" >
    <option value="">-</option>
    {$csro_Options}
    </select>
    </div>
    
    <div>Recruiter : <select name="recruiter" id="recruiter" >
    <option value="">-</option>
    {$recruiter_Options}
    </select>
    </div> 


    <div>Work Status : <select name="work_status" id="work_status">
    <option value="">-</option>
    {html_options values=$WORK_STATUS  output=$WORK_STATUS selected=$work_status }
    </select>
    </div>
    
    <div>Reason Type : <select name="reason_type" id="reason_type">
    <option value="">-</option>
    {html_options values=$REASON_TYPE  output=$REASON_TYPE selected=$reason_type }
    </select>
    </div>

    <div>Service Type : <select name="service_type" id="service_type">
    <option value="">-</option>
    {html_options values=$SERVICE_TYPE  output=$SERVICE_TYPE selected=$service_type }
    </select>
    </div>

    <div>From Month: <select name="from_month" id="from_month">
    {html_options values=$MONTH_NUMBERS  output=$MONTH_NAMES selected=$from_month }
    </select>
    </div>
    
    <div>From Year:<select name="from_year" id="from_year">
    {html_options values=$YEARS  output=$YEARS selected=$from_year }
    </select>
    </div>
    
    <div>To Month: <select name="to_month" id="to_month">
    {html_options values=$MONTH_NUMBERS  output=$MONTH_NAMES selected=$to_month }
    </select>
    </div>
    
    <div>To Year : <select name="to_year" id="to_year">
    {html_options values=$YEARS  output=$YEARS selected=$to_year }
    </select>
    </div>
    <br clear="all">
</div>
	
<input type="submit" name="search"  VALUE="Search" >
<input type="button" onclick="location.href='cancellation_dashboard_exporting.php?from_month={$from_month}&from_year={$from_year}&to_month={$to_month}&to_year={$to_year}{$url_link}'" value="Export" >


</fieldset>
</td>
</tr>
</table>

<!-- start -->
<div id="subcon_listings">
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#333">
<tr bgcolor="#333333">
<td width="22%" align="center" style="color:#FFF;">Month / Year</td>
<td width="12%" align="center" style="color:#FFF;">Resigned</td>
<td width="11%" align="center" style="color:#FFF;">Terminated</td>
<td width="13%" align="center" style="color:#FFF;">Request to Replace</td>
<td width="13%" align="center" style="color:#FFF;">No Request to Replace</td>
<td width="15%" align="center" style="color:#FFF;">Total Contract Cancelled</td>
<td width="14%" align="center" style="color:#FFF;">Total Contract Ended</td>
</tr>

{foreach from=$SEARCH_RESULTS name=search item=search}
<tr bgcolor="#FFFFFF">
<td align="center">{$search.date_search_str|date_format:"%B %Y"}</td>
<td align="center"><a href="cancellation_dasboard_details.php?result=resigned&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_resigned}</a></td>
<td align="center"><a href="cancellation_dasboard_details.php?result=terminated&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_terminated}</a></td>
<td align="center"><a href="cancellation_dasboard_details.php?result=yes&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_replacement_request}</a></td>
<td align="center"><a href="cancellation_dasboard_details.php?result=no&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_no_replacement_request}</a></td>
<td align="center"><a href="cancellation_dasboard_details.php?result=cancelled&date={$search.date_search_str}{$url_link}" target="_blank">{$search.total_contract_cancelled}</a></td>
<td align="center"><a href="cancellation_dasboard_details.php?result=ended&date={$search.date_search_str}{$url_link}" target="_blank">{$search.total_contract_ended}</a></td>
</tr>
{/foreach}
</table>
</div>
<!-- end -->	
</div></td></tr>
</table>
{php} include 'footer.php'{/php}
<input type="hidden" name="_submit_check" value="1"/>
</form>
</body>
</html>

