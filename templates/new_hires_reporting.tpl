{*
2012-10-10  Normaneil Macutay <normanm@remotestaff.com.au>

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
<h2 class="h2" align="center">NEW HIRES REPORTING</h2>
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
    
    
    <div>Service Type : <select name="service_type" id="service_type">
    <option value="">-</option>
    {html_options values=$SERVICE_TYPE  output=$SERVICE_TYPE selected=$service_type }
    </select>
    </div>
    
    
    <div>Contract Status : <select name="status" id="status">
    <option value="">-</option>
    {html_options values=$STATUS  output=$STATUS selected=$status }
    </select>
    </div>
    <br clear="all">
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
    
    <div>Include Inhouse Staff : <select name="include_inhouse_staff" id="include_inhouse_staff">
    {html_options values=$ANSWERS  output=$ANSWERS selected=$include_inhouse_staff }
    </select>
    </div>
    
    <br clear="all">
</div>

	
<input type="submit" name="search"  VALUE="Search" >
<input type="button" onclick="location.href='new_hires_reporting_exporting.php?from_month={$from_month}&from_year={$from_year}&to_month={$to_month}&to_year={$to_year}{$url_link}'" value="Export" >


</td>
</tr>
</table>

<!-- start -->
<div id="subcon_listings">
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#333">
<tr bgcolor="#333333">
<td width="30%" align="center" style="color:#FFF;">Month / Year</td>
<td width="10%" align="center" style="color:#FFF;">Custom</td>
<td width="10%" align="center" style="color:#FFF;">ASL</td>
<td width="10%" align="center" style="color:#FFF;">Project Based</td>
<td width="10%" align="center" style="color:#FFF;">Trial</td>
<td width="10%" align="center" style="color:#FFF;">Replacement</td>
<td width="10%" align="center" style="color:#FFF;">Backorder</td>
<td width="10%" align="center" style="color:#FFF;">Inhouse</td>
<td width="10%" align="center" style="color:#FFF;">Count</td>
</tr>

{foreach from=$SEARCH_RESULTS name=search item=search}
<tr bgcolor="#FFFFFF">
<td align="center">{$search.date_search_str|date_format:"%B %Y"}</td>
<td align="center"><a href="new_hires_reporting_details.php?service_type=Customs&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_customs}</a></td>
<td align="center"><a href="new_hires_reporting_details.php?service_type=ASL&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_asl}</a></td>
<td align="center"><a href="new_hires_reporting_details.php?service_type=Project Based&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_project_based}</a></td>
<td align="center"><a href="new_hires_reporting_details.php?service_type=Trial&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_trial}</a></td>
<td align="center"><a href="new_hires_reporting_details.php?service_type=Replacement&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_replacement}</a></td>
<td align="center"><a href="new_hires_reporting_details.php?service_type=Back Order&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_back_order}</a></td>
<td align="center"><a href="new_hires_reporting_details.php?service_type=Inhouse&date={$search.date_search_str}{$url_link}" target="_blank">{$search.num_count_inhouse}</a></td>
<td align="center"><a href="new_hires_reporting_details.php?date={$search.date_search_str}&service_type={$service_type}{$url_link}" target="_blank">{$search.num_count}</a></td>

</tr>
{/foreach}
<tr bgcolor="#FFFF00">
<td align="right" ><strong>Total Count</strong></td>
<td align="center" ><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type=Customs{$url_link}" target="_blank">{$total_num_count_customs}</a></strong></td>
<td align="center" ><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type=ASL{$url_link}" target="_blank">{$total_num_count_asl}</a></strong></td>
<td align="center" ><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type=Project Based{$url_link}" target="_blank">{$total_num_count_project_based}</a></strong></td>
<td align="center" ><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type=Trial{$url_link}" target="_blank">{$total_num_count_trial}</a></strong></td>
<td align="center" ><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type=Replacement{$url_link}" target="_blank">{$total_num_count_replacement}</a></strong></td>
<td align="center" ><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type=Back Order{$url_link}" target="_blank">{$total_num_count_back_order}</a></strong></td>
<td align="center" ><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type=Inhouse{$url_link}" target="_blank">{$total_num_count_inhouse}</a></strong></td>
<td align="center"><strong><a href="new_hires_reporting_details.php?from={$from_year}-{$from_month}&to={$to_year}-{$to_month}&service_type={$service_type}{$url_link}" target="_blank">{$total_num_count}</a></strong></td>
</tr>
</table>
<!-- end -->	
</div></td></tr>
</table>
{php} include 'footer.php'{/php}
<input type="hidden" name="_submit_check" value="1"/>
</form>
</body>
</html>

