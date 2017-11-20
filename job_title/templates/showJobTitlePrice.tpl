<div><span id="jr_name_spn" class="jr_name">{$jr_name}</span> <span class="edit-spn" onclick="editJobTitleName()">edit</span><span class="edit-spn" onclick="removeJobTitleName()">remove</span></div>
<div id="edit_jr_name">
	<p><input type="text" id="title_name" size="40"  /> 
	<input type="button" value="update" onclick="updateJobTitleName('{$jr_name}')" /> 
	<input type="button" value="cancel" onclick="toggle('edit_jr_name')" />
	</p>
</div>
{section name=j loop=$job_titles}
	{strip}
		<div class="jr_currency" >{$job_titles[j].jr_currency}</div>
		<div id="currency_{$job_titles[j].jr_currency}">
			<table class="tb_prc" width="100%" cellpadding="3" cellspacing="1" >
			<tr class="tr_w" >
				<td width="20%" align="right">Entry Level Price</td>
				<td width="80%"><input type="text" id="entry_price_{$job_titles[j].jr_currency}" size="25" value="{$job_titles[j].jr_entry_price}" /></td>
			</tr>
			<tr class="tr_w">
				<td align="right">Mid Level Price</td>
				<td><input type="text" id="mid_price_{$job_titles[j].jr_currency}" size="25" value="{$job_titles[j].jr_mid_price}" /></td>
			</tr>
			
			<tr class="tr_w">
				<td align="right">Expert Level Price</td>
				<td><input type="text" id="expert_price_{$job_titles[j].jr_currency}" size="25" value="{$job_titles[j].jr_expert_price}" /></td>
			</tr>
	
			<tr class="tr_w">
				<td>&nbsp;</td>
				<td><input type="button" name="update" id="update" value="Update" onclick="updateJobTitlePrices('{$jr_name}' , '{$job_titles[j].jr_currency}' , {$job_titles[j].jr_list_id}) " /></td>
			</tr>
			</table>
		
		</div>
	{/strip}
{/section}



{section name=k loop=$currency_array}
	{strip}
		{if $currency_array[k] neq 'PHP'}
		<div class="jr_currency">{$currency_array[k]}</div>
		<div id="currency_{$currency_array[k]}">
		<table width="100%" cellpadding="3" cellspacing="1" class="tb_prc">
		<tr class="tr_w">
			<td width="20%" align="right">Entry Level Price</td>
			<td width="80%"><input type="text" id="entry_price_{$currency_array[k]}" size="25" value="" /></td>
		</tr>
		<tr class="tr_w">
			<td align="right">Mid Level Price</td>
			<td><input type="text" id="mid_price_{$currency_array[k]}" size="25" value="" /></td>
		</tr>
		
		<tr class="tr_w">
			<td align="right">Expert Level Price</td>
			<td><input type="text" id="expert_price_{$currency_array[k]}" size="25" value="" /></td>
		</tr>
		
		<tr class="tr_w">
			<td>&nbsp;</td>
			<td><input type="button" name="update" id="update" value="Update" onclick="updateJobTitlePrices('{$jr_name}' , '{$currency_array[k]}' , 0)" /></td>
		</tr>
		</table>
		</div>
		{/if}
	{/strip}
{/section}


























