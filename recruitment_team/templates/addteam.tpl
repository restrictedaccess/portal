{ include file="header.tpl" }
<form name="form" method="post" action="{$form_action}">
<input type="hidden" name="team_id" id="team_id" value="{$team_id}"  />
<div id="divaddteam">
{if $error_msg}
<div align='center' style='font-weight:bold; margin:5px;'><span style='background:yellow; '>{$error_msg}</span></div>
{/if}
<p><label>Team Name : </label><input type="text" name="team" id="team" size="40" value="{$team_name}" /></p>
<p><label>Team Description : </label><textarea name="team_description" id="team_description" >{$team_description}</textarea></p>

<p><label>Hiring Coordinator : </label>
<select name='hiring_coordinator' id="hiring_coordinator">
<option value="">Please Select</option>
{foreach from=$hiring_coordinators item=hc name=hc}
    
    <option value="{$hc.admin_id}" {if $hiring_coordinator_id eq $hc.admin_id} selected="selected" {/if}>{$hc.admin_fname} {$hc.admin_lname} - #{$hc.admin_id}</option>
{/foreach}
</select>
</p>

<p><label>Head Recruiter : </label>
<select name='head_recruiter' id="head_recruiter">
<option value="">Please Select</option>
{foreach from=$head_recruiters item=hc name=hc}    
    <option value="{$hc.admin_id}" {if $head_rercuiter_id eq $hc.admin_id} selected="selected" {/if}>{$hc.admin_fname} {$hc.admin_lname} - #{$hc.admin_id}</option>
{/foreach}
</select>
</p>


<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="19%" align="right" valign="top">Recruiters : </td>
<td width="69%" valign="top" style="padding-left:5px;">
{if $recruiters}
    {foreach from=$recruiters item=hc name=hc}
         <span><input type="checkbox" name="recruiters[]" value="{$hc.admin_id}"  {if $hc.selected} checked="checked" {/if}/>{$hc.admin_fname} {$hc.admin_lname} - #{$hc.admin_id}</span>
    {/foreach}
{else}
   <em>No Available Recruiters...</em>
{/if}
</td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
<td align="right" valign="top">CSRO : </td>
<td  valign="top" style="padding-left:5px;">
{if $csros}
    {foreach from=$csros item=hc name=hc}
        <span><input type="checkbox" name="csros[]" value="{$hc.admin_id}"  {if $hc.selected} checked="checked" {/if} />{$hc.admin_fname} {$hc.admin_lname} - #{$hc.admin_id}</span>
    {/foreach}
{else}
    <em>No Available CSRO...</em>
{/if}
</td>
</tr>


</table>



{if $histories}
{ include file="history.tpl" }
{/if}

</div>
<p align="center"><input type="submit" name="add" value="{$button_name}"  /></p>
</form>
{ include file="footer.tpl" }