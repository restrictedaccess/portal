{*
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
2010-08-24  Normaneil Macutay <normanm@remotestaff.com.au>
2011-01-11 Adding ASL Alert <Roy Pepito>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff {$leads_info.fname} {$leads_info.lname} Leads Information Sheet</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/leads.css">

<link rel=stylesheet type=text/css href="menu.css">
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./js/functions.js"></script>
<script type="text/javascript" src="./js/lead.js"></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>

</head>
<body style="background:#ffffff; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" enctype="multipart/form-data" onSubmit="OnSubmitForm()" >
<input type="hidden" name="applicants" id="applicants" value="">
<input type="hidden" name="status" id="status" >
<input type="hidden" name="tme_flag" id="tme_flag" value="{$tme_flag}" />

{php}include("header.php"){/php}
{if $agent_section eq True}
	{php}include("BP_header.php"){/php}
{/if}
{if $admin_section eq True}
	{php}include("admin_header_menu.php"){/php}
{/if}

<div class="leads_list">
{if $lead_status_selection eq True}
<div style="padding:5px; text-align:center;">
<p><b>Please select the list of leads you want to view</b></p>
<p>{$lead_status_selection_Options}</p>
</div>
{/if}


{if $lead_status_selection eq False}
<div style="background:#E7E7E7; padding:5px; text-align:center; ">
<h2>
{if $admin_section eq True }
Administrator View
{/if}
{if $agent_section eq True}
Business Developer View
{/if}
</h2>
<table align="center" width="80%" cellpadding="3" cellspacing="0" style=" margin-bottom:20px; margin-top:20px;">



{if $access_all_leads eq 'YES'}
	{if $agent_section eq True}
	
		<tr>
		<td  align="left">Business Developer Leads</td>
		<td align="left">
		<select name="business_developer_id" id="business_developer_id" class="search_select" style="width:250px;" onChange="Uncheck('save_setting_access_all_leads')"  >
		<option value="all">Show All Business Developer Leads</option>
		{$business_partners_id_options}
		</select> {$save_setting_access_all_leads}</td>
		<td align="left">Order By Date Regitered</td>
		<td align="left"><select name="order_by" id="order_by" class="search_select" style="width:250px;" onChange="Uncheck('save_setting_leads_order_by')"  >
		<option value=''>Default View</option>
		{$order_by_options}
		</select> {$save_setting_leads_order_by}</td>
		</tr>
		{else}
		<tr>
		<td  align="left">Business Developer Leads</td>
		<td align="left">
		<select name="business_developer_id" id="business_developer_id" class="search_select" style="width:250px;"  >
		<option value="all">Show All Business Developer Leads</option>
		{$business_partners_id_options}
		</select></td>
		<td align="left">Order By Date</td>
		<td align="left"><select name="order_by" id="order_by" class="search_select" style="width:250px;"  >
		<option value=''>Default View</option>
		</select></td>
		</tr>
	
	{/if}	
{/if}

<tr>
<td width="17%" align="left">Show no. of result by</td>
<td width="34%" align="left">
{if $search eq False}
<select name="rowsPerPage" id="rowsPerPage" class="search_select"  >
  {$rowsPerPageOptions}
</select>
{else}
<select name="rowsPerPage" id="rowsPerPage" class="search_select" disabled="disabled"  >
<option value="">-</option>
</select>
{/if}

</td>
<td width="16%" align="left">Keyword Search</td>
<td width="33%" align="left"><input type="text" name="keyword" id="keyword" value="{$keyword}" style=" width:300px;" ></td>
</tr>

<tr>
<td width="17%" align="left">Search Leads in</td>
<td width="34%" align="left"><select name="folder" id="folder" class="search_select"  >
{if $admin_section eq True}
	{if $admin_status eq 'FULL-CONTROL'}
	<option value="All">Search all folders</option>
	{/if}
{/if}

{if $agent_section eq True}
	<option value="All">Search all folders</option>
{/if}

  {$searchoptions}
</select></td>
<td align="left">Search Leads Registered in </td>
<td align="left"><select name="registered_in" id="registered_in" class="search_select"  >
<option value="">-</option>
  {$registered_in_options}
</select></td>
</tr>

<tr>
<td align="left">Ratings</td>
<td align="left"><select name="ratings" id="ratings" onChange="setStar(this.value);" style="width:50px;" >
<option value="">-</option>
{$rate_options}
</select> <span id="star" ></span></td>
<td align="left">Sites</td>
<td align="left"><select name="location_id" id="location_id"  style="width:200px;"  >
<option value="">All</option>
  {$location_id_options}
</select></td>
</tr>

<tr>
<td height="39"  align="left">Date Registered</td>
<td align="left"><input type="text" name="event_date" id="event_date" value="{$event_date}"  size="15" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" />
</td>
<td align="left">Month / Year</td>
<td align="left"> <select name="month" id="month"  style="font-size: 12px; width:80px;" >
{$monthoptions}
</select> 
/
<select name="year" id="year"  style="font-size: 12px; width:80px;" >
<option value="">-</option>
{$yearoptions}
</select>
</td>
</tr>



<tr>
<td height="47" colspan="4" align="left" valign="bottom" style="border-top:#666666 dashed 1px;"><input type="submit" value="Search" name="search"></td>
</tr>
<tr>
<td colspan="4" align="left"><input type="button" name="add" value="Add New Lead" onClick="self.location='adminaddnewlead.php'"/> {if $enable_disable_btn eq True}<input type="submit" name="REMOVED" value="Removed from the list" >{/if}<input type="submit" name="transfer" value="Begin Tranfer to" onClick="return CheckBP();" > <select name="agent_id" id="agent_id" style="width:300px;" >
<option value="">Please Select Business Developer</option>
{$BPOptions}
</select></td>
</tr>

<tr>
<td colspan="4" align="left">
{$transfer_buttons}
{if $admin_section eq True}
	{if $lead_status eq 'Client'}
		<input type="button" value="Export to Excel" onClick="self.location='admin_export_excel_client_listing.php'" />
	{/if}
{/if}

</td>
</tr>

</table>
</div>
{if $leads_transfer_error_msg neq ''}
<div id="leads_transfer_error_msg">{$leads_transfer_error_msg}</div>
{/if}


<table class='leads_table' cellpadding='2' cellspacing='1' width='100%' align='center' bgcolor='#CCCCCC'>
{$leads_list}
</table>
{/if}


</div>



{php}include("footer.php"){/php}
<input type="hidden" name="_submit_check" value="1"/>
{if $lead_status neq ''}
<script type="text/javascript">setCalendar();</script>
{/if}

{if $tme_flag eq 1}
<script type="text/javascript">timedMsg();</script>
{/if}

</form>
<!--ASL ALARM--> <DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV> <!--ENDED-->
</body>
</html>
