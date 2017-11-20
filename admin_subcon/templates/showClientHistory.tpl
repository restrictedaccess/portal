<div>
<input type="hidden" name="max_month_interval" id="max_month_interval" value="{$max_month_interval}" />
<div style="padding-bottom:5px;"><a href="javascript:toggle('staff_list')">Staff List</a> <span style="margin-left:10px;"><em>No.of staff [{$no_of_staff}]</em></span></div>
<table align="center" id="staff_list" width="65%" cellpadding="3" cellspacing="0" style="display:none;border-left:#333333 solid 1px;border-right:#333333 solid 1px;border-top:#333333 solid 1px;">
	<tr bgcolor = '#999999'>
	<td width="5%"><b>#</b></td>
	<td width="20%"><b>STAFF NAME</b></td>
	<td width="10%"><b>DATE STARTED</b></td>
	<td width="15%"><b>PERIOD</b></td>
	</tr>
	{section name=j loop=$result}
	
		<tr  bgcolor="{cycle values='#FFFFFF,#f5f5f5'}">
		<td valign='top' style='border-bottom:#333333 solid 1px;  border-right:#333333 solid 1px;'  >{$smarty.section.j.iteration} )</td>
		<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'>{$result[j].staff_name}</td>
		<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'>{$result[j].starting_date_str}</td>
		{if $result[j].month_interval eq 0 }
			<td valign='top' style='border-bottom:#333333 solid 1px;'>{$result[j].no_of_days} days</td></tr>
		{else}
		    <td valign='top' style='border-bottom:#333333 solid 1px;'>{$result[j].month_interval} months</td></tr>
		{/if}
	
	{sectionelse}
		<tr><td colspan="4" align="center"><b>This client has no ative staff to be shown </b></td></tr>
	{/section}
	
</table>


	
</div>

