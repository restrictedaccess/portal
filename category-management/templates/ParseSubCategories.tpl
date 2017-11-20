<div id="{$jr_cat_id}_add_div" class="add_div"></div>
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
{section name=j loop=$sub_cats}
	<tr bgcolor='#FFFFFF'>
		<td width='5%' align='left'>{$smarty.section.j.iteration}</td>
		<td width='35%' align='left'>{$sub_cats[j].category_name}</td>
		<td width='60%' align='left'><a href="javascript:ShowAddEditForm({$jr_cat_id}, 'update' ,{$sub_cats[j].category_id})">edit</a> | <a href="javascript:RemoveSubCat({$jr_cat_id}, {$sub_cats[j].category_id})">remove</a></td>
	  </tr>
{sectionelse}
	<tr bgcolor='#FFFFFF'><td colspan='4' align='center'>There are no sub categories to be shown</td></tr>
{/section}

</table>