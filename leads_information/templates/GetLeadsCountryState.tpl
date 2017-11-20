{if $state_list_count neq 0}
<select name="state" id="state" style="width:240px;">
<option value="">Select a State</option>
{$stateoptions}
</select>
{else}
<input type="text" name="state" id="state" value="{$state}" size="37" />
{/if}