<div class="holder">
<div id="ratings">
<ol ><b>Rating Scale</b>
<li>No experience</li>
<li>Trained, low level experience</li>
<li>Sound knowledge, some practical experience</li>
<li>Strong working knowledge and understanding</li>
<li>Comprehensive understanding, knowledge and proficiency</li>
<li>In depth expert knowledge and a high level of proficiency &ndash; able to provide specialist advice, insight or technical expertise</li>
</ol>
</div>
<div id="info">
<table width="100%" cellpadding="1" cellspacing="0">

<tr>
<td width="33%">Lead</td>
<td width="67%">#{$basic_info.leads_id} {$basic_info.fname} {$basic_info.lname}</td>
</tr>

<tr>
<td>No. of Staff Needed : </td>
<td>{$no_of_staff_needed}</td>
</tr>


<tr>
<td>Work Status : </td>
<td>{$work_status} {$prices}</td>
</tr>


<tr>
<td>Working Hours : </td>
<td>{$working_time} {$working_timezone} timezone</td>
</tr>

<tr>
<td>Timezone : </td>
<td>{$working_timezone}</td>
</tr>
{if $client_user neq 'True'}

	{if not $posting} 
		<tr>
		<td colspan="2">
		<input type="button" value="Edit" onclick="editJobPostion2({$gs_job_titles_details_id})" />
		</td>
		</tr>
	{/if}


{/if}


<tr class="tr_w" >
	<td>Created and Filled up by</td>
	<td ><span style="background:#FFFF00; font-family:'Courier New', Courier, monospace; ">{$filled_up_by} on <em>{$filled_up_date|date_format:"%B %e, %Y %I:%M:%S %p"}</em></span>
	
	</td>
</tr>


</table>
<div id="div_edit_job_position_form2"></div>


</div>
<div style="clear:both;"></div>
</div>

<div style="padding-left:15px;">
{if $client_user neq 'True'}
	
	{if not $posting} 
		<input type="button" value="Convert to an Advertisement" onclick="javascript:location.href='../ads/?gs_job_titles_details_id={$gs_job_titles_details_id}&mode=create&source=rs'" />
		<input type="button" id="edit_btn"  value="Edit" jr_cat_id="{$jr_cat_id}" gs_job_titles_details_id="{$gs_job_titles_details_id}" jr_list_id="{$jr_list_id}" gs_job_role_selection_id="{$gs_job_role_selection_id}" />
	{else}
	
			{if $allow_edit}
				<input type="button"  value="Convert to an Advertisement"  onclick="javascript:location.href='../ads/?gs_job_titles_details_id={$gs_job_titles_details_id}&mode=edit&source=rs'" />
				<input type="button" id="edit_btn"  value="Edit" jr_cat_id="{$jr_cat_id}" gs_job_titles_details_id="{$gs_job_titles_details_id}" jr_list_id="{$jr_list_id}" gs_job_role_selection_id="{$gs_job_role_selection_id}" />
			{else}
				<input type="button"  value="Convert to an Advertisement"  disabled="disabled" />
				<input type="button" id="edit_btn" value="Edit" disabled="disabled"  />			
			{/if}
			<strong>Advertisment status : {$posting.status}</strong>
	{/if}

{else}

	{if not $posting} 
		<input type="button" id="edit_btn"  value="Edit" jr_cat_id="{$jr_cat_id}" gs_job_titles_details_id="{$gs_job_titles_details_id}" jr_list_id="{$jr_list_id}" gs_job_role_selection_id="{$gs_job_role_selection_id}" />
	{else}
		{if $allow_edit}
			<input type="button" id="edit_btn"  value="Edit" jr_cat_id="{$jr_cat_id}" gs_job_titles_details_id="{$gs_job_titles_details_id}" jr_list_id="{$jr_list_id}" gs_job_role_selection_id="{$gs_job_role_selection_id}" />
		{else}
			<input type="button" id="edit_btn" value="Edit" disabled="disabled"  />
		{/if}
			<strong>Advertisment status : {$posting.status}</strong>
	{/if}


{/if}
</div>