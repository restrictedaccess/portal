<table width="100%" cellpadding="3" cellspacing="1" class="tb_prc">
<tr class="tr_w">
	<td width="20%" align="right">Entry Level Price</td>
	<td width="80%"><input type="text" id="entry_price_{$currency}" size="25" value="{$result.jr_entry_price}" /></td>
</tr>
<tr class="tr_w">
	<td align="right">Mid Level Price</td>
	<td><input type="text" id="mid_price_{$currency}" size="25" value="{$result.jr_mid_price}" /></td>
</tr>

<tr class="tr_w">
	<td align="right">Expert Level Price</td>
	<td><input type="text" id="expert_price_{$currency}" size="25" value="{$result.jr_expert_price}" /></td>
</tr>

<tr class="tr_w">
	<td>&nbsp;</td>
	<td><input type="button" name="update" id="update" value="Update" onclick="updateJobTitlePrices('{$jr_name}' , '{$currency}' , {$jr_list_id})" /></td>
</tr>
</table>


