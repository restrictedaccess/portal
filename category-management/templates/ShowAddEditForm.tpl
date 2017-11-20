<div style="background:#FFFFCC; border:#333333 solid 4px; padding:10px; position:absolute; margin-left:10px;">
<table width="500" cellspacing="1">

<tr>
<td width="134">Sub Category Name</td>
<td width="341"><input type="text" name="sub_cat_name_{$jr_cat_id}" id="sub_cat_name_{$jr_cat_id}" value="{$category.category_name}" size="50" /></td>
</tr>
{if $mode eq 'update'}
<tr>
<td width="134">Category</td>
<td width="341"><select name='job_role_category_id_{$jr_cat_id}' id="job_role_category_id_{$jr_cat_id}" style='width:200px;'>
{$category_Options}</select></td>
</tr>
{/if}

<tr>
<td colspan="2">
{if $mode eq 'add'}
<input type="button" name="add" value="Add" onclick="AddSubCat({$jr_cat_id})" />
{else}
<input type="button" name="update" value="Update" onclick="UpdateSubCat({$jr_cat_id} , {$category_id})" />
{/if}
<input type="button" value="Close" onclick="toggle('{$jr_cat_id}_add_div')" />
</td>
</tr>
</table>
</div>