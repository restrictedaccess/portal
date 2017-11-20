<form name="form" method="post" action="./update/update_from_js_form.php" onsubmit="return CheckCreatedAds()" >
	<input type="hidden" name="id" id="id" value="{$id}" />
	<input type="hidden" name="mode" id="mode" value="{$mode}" />
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
			<td align="left">Job Title Position :</td>
			<td align="left" >
			<input type="text" name="jobposition" id="jobposition" value="{$job_title.selected_job_title}" size="50">
			</td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Vacancy</td>
			<td align="left">
			<input type="text" readonly="readonly" name="jobvacancy_no" id="jobvacancy_no" value="{$job_title.no_of_staff_needed}" size="3">
			</td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Heading</td>
			<td align="left"><textarea name="heading" id="heading" wrap="physical" style="width:99%; height:200px;">{$heading}</textarea></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Status</td>
			<td align="left">
			<select id="status" name="status" style="width:100px;">
				<option value="" selected="selected">Please Select</option>
				{$status_Options}
			</select></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td align="left">Show Status</td>
			<td align="left">
			<select id="show_status" name="show_status" style="width:100px;">
				<option value="" selected="selected">Please Select</option>
				{$show_status_Options}
			</select></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td colspan="2" align="left">&nbsp;</td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td align="left">Responsibilities</td>
			<td align="left" valign="top"><span style=" display:none;">{counter start =0}</span>
			<table width="100%" border="0" cellpadding="2" cellspacing="2">

				{foreach from=$responsibilities item=responsibility name=responsibility_list}
				{if $responsibility neq ''}
				<tr class="row_to_clone">
					<td width="2%" align="right"><img src="../images/box.gif"></td>
					<td width="98%" align="left">
					<input readonly="readonly" name="responsibility[{$smarty.foreach.responsibility_list.index}]" type="text" class="text" style="width:100%;" value="{$responsibility}"  />
					</td>
				</tr>
				{/if}
				{/foreach}

			</table>
			<div>
				<!--
				<input  type="button" value="Add More "  class="lsb add-responsibility-row"/>
				-->
			</div></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td colspan="2" align="left">&nbsp;</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td align="left">Requirements</td>
			<td align="left" valign="top"><span style=" display:none;">{counter start =0}</span>
			<table width="100%" border="0" cellpadding="2" cellspacing="2">
				{foreach from=$requirements item=requirement name=requirement_list}
				{if $requirement neq ''}
				<tr class="row_to_clone">
					<td width="2%" align="right"><img src="../images/box.gif"></td>
					<td width="98%" align="left">
					<input readonly="readonly" name="requirement[{$smarty.foreach.requirement_list.index}]" type="text" class="text" style="width:100%;" value="{$requirement}"  />
					</td>
				</tr>
				{/if}
				{/foreach}

			</table>
			<div>
				<!--
				<input type="button" value="Add More " class="lsb add-requirement-row"/>
				-->
			</div></td>
		</tr>

		<tr bgcolor="#FFFFFF">
			<td colspan="2">
			<input type="submit" class="lsb" name="update" value="Update" />
			<input class="lsb" type="button" value="Close" onClick="javascript:window.location.href='/portal/custom_get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}'">
			</td>
		</tr>
	</table>

</form>
