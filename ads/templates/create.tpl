<form name="form" method="post" action="./create/" onsubmit="return CheckCreatedAds()" accept-charset = "utf-8" >
	<input type="hidden" name="gs_job_titles_details_id" id="gs_job_titles_details_id" value="{$gs_job_titles_details_id}" />
	<input type="hidden" name="mode" id="mode" value="{$mode}" />
	<input type="hidden" name="source" id="source" value="rs" />
	<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />
	<input type="hidden" name="jobposition" id="jobposition" value="{$job_title.selected_job_title}">
	<input type="hidden" name="jobvacancy_no" id="jobvacancy_no" value="{$job_title.no_of_staff_needed}" >

	<table align="center" width="80%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" style="margin-top:20px;">

		<tr bgcolor="#FFFFFF">
			<td width="22%" align="left">Leads Name</td>
			<td width="78%" align="left">{$lead.fname} {$lead.lname}</td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Category</td>
			<td align="left">
			<select id="category_id" name="category_id" style="width:300px;">
				<option value="">Please Select</option>
				{$category_Options}
			</select></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Outsourcing Model</td>
			<td align="left">
			<select id="outsourcing_model" name="outsourcing_model" style="width:300px;">
				<option value="">Please Select</option>
				{$outsourcing_modelOptions}
			</select></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Company</td>
			<td align="left">
			<input type="text" name="companyname" id="companyname" value="{$lead.company_name|escape}" size="50">
			</td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Vacancy</td>
			<td align="left">{$job_title.no_of_staff_needed}</td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Heading</td>
			<td align="left">			<textarea name="heading" id="heading" wrap="physical" style="width:99%; height:200px;">{$heading|capitalize}
{section name=j loop=$job_title_details}
{if $jr_cat_id eq 1}
	
	{if $job_title_details[j].box eq 'campaign_type'}
		<p>{$job_title_details[j].description} Campaign Type</p>
	{/if}
	
	{if $job_title_details[j].box eq 'call_type'}
		<p>{$job_title_details[j].description} Call Type</p>
	{/if}
	
{/if}
{/section}
</textarea></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td colspan="2" align="left">&nbsp;</td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Responsibilities</td>
			<td align="left" valign="top">
			<table width="100%" border="0" cellpadding="2" cellspacing="2">
				{if $responsibilities }
				{foreach from=$responsibilities item=responsibility name=responsibility_list}
				<tr class="row_to_clone">
					<td width="2%" align="right"><img src="../images/box.gif"></td>
					<td width="98%" align="left">
					<input readonly="readonly" name="responsibility[{$smarty.foreach.responsibility_list.index}]" type="text" class="text" style="width:100%;" value="{$responsibility}"  />
					</td>
				</tr>

				{/foreach}
				{else}
				<tr class="row_to_clone">
					<td width="2%" align="right"><img src="../images/box.gif"></td>
					<td width="98%" align="left">
					<input readonly="readonly" name="responsibility[0]" type="text" class="text" style="width:100%;" />
					</td>
				</tr>

				{/if}
			</table>
			<div  >
				<!--
				<input  class="lsb" type="button" value="Add More "  onclick="addRow(); return false;"/>
				-->
			</div></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td colspan="2" align="left">&nbsp;</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td align="left">Requirements</td>
			<td align="left" valign="top">
			<table width="100%" border="0" cellpadding="2" cellspacing="2">
				{assign var='ctr' value='0'}
				{section name=j loop=$requirements}

				<tr class="row_to_clone2">
					<td width="2%" align="right"><img src="../images/box.gif"></td>
					<td width="98%" align="left">
					<input readonly="readonly" name="requirement[{$ctr}]" type="text" class="text" style="width:100%;" value="{$requirements[j]}"  />
					</td>
				</tr>

				{assign var='ctr' value=$ctr+1}

				{sectionelse}
				<tr class="row_to_clone2">
					<td width="2%" align="right"><img src="../images/box.gif"></td>
					<td width="98%" align="left">
					<input readonly="readonly" name="requirement[0]" type="text" class="text" style="width:100%;" value=""  />
					</td>
				</tr>

				{/section}

			</table>
			<div  >
				<!--
				<input class="lsb" type="button" value="Add More "  onclick="addRow2(); return false;"/>
				-->
			</div></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td colspan="2">
			<input type="submit" class="lsb" name="create" value="Create" />
			<input class="lsb" type="button" value="Close" onClick="javascript:window.location.href='/portal/custom_get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}'">
			</td>
		</tr>
	</table>

</form>
