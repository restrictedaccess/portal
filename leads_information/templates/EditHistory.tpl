<div style="position:absolute; display:block; background:#FFFFFF; border:#2c66a5 solid 4px; padding:10px; background:#EEEEEE">
<input type="hidden" id="history_id" name="history_id" value="{$result.id}" />
{if $mode eq 'update'}
<p><textarea name="content" id="content"   style="width:600px; height:400px;" >{$result.history|escape:'htmlall'}</textarea></p>
<p><input type="submit" name="update_history" value="update" onclick="return UpdateHistory({$result.id})" /><input type="button" value="close" onclick="toggle('history_edit_div')" /> </p>
{/if}


{if $mode eq 'delete'}
<p><textarea name="content" id="content"  readonly="readonly"  style="width:600px; height:300px;" >{$result.history|escape:'htmlall'}</textarea></p>

<p><input type="submit" name="delete_history" value="delete" onclick="return DeleteHistory({$result.id})" /><input type="button" value="close" onclick="toggle('history_edit_div')" /> </p>
{/if}



</div>