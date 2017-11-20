<div style="background:#FFFFCC; border:#333333 solid 4px; padding:10px; position:absolute; margin-left:10px;">
<table width="500" cellspacing="1">

<tr>
<td width="134">Category Name</td>
<td width="341"><input type="text" name="cat_name_{$jr_cat_id}" id="cat_name_{$jr_cat_id}" value="{$category.cat_name}" size="50" /></td>
</tr>

<tr>
<td colspan="2">
<input type="button" name="update" value="Update" onclick="UpdateCatName({$jr_cat_id})" />

<input type="button" value="Close" onclick="toggle('{$jr_cat_id}_edit_div')" />
</td>
</tr>
</table>
</div>