<table class="tb_prc" width="100%" cellpadding="3" cellspacing="1" >
<tr class="tr_w" >
	<td width="20%" align="right">Category</td>
	<td width="80%">
	<select name="category" id="category" >
	{$CategoryOptions}
	</select>
	</td>
</tr>
<tr class="tr_w">
	<td align="right">Job Title</td>
	<td><input type="text" id="jr_name" name="jr_name" size="40" /></td>
</tr>


<tr class="tr_w">
	<td>&nbsp;</td>
	<td><input type="button" name="add" id="add" value="Add" onclick="updateJobTitlePrices('{$jr_name}' , '{$job_titles[j].jr_currency}' , {$job_titles[j].jr_list_id}) " /></td>
</tr>
</table>