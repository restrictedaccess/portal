{ include file="header.tpl" }

<div id="div_holder_team" >

<div style="float:right;  text-align:right;">
<p><label>Created by : </label> {$team.admin_fname} {$team.admin_lname}</p>
<p><label>Date Created : </label> {$team.team_date_created}</p>
<p><a href="team.php?team_id={$team.id}">Edit</a></p>
</div>


<p><label>Team Name : </label> <span class="team_name_txt">{$team.team}</span></p> 
<p><label>Description : </label> {$team.team_description}</p>
<p><label>Status : </label> {$team.team_status|upper}</p>


<br clear="all" />
<table id="divteamtb" align="center" width="100%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td width="25%" class="hdr">Hiring Coordinator</td>
<td width="25%" class="hdr">Head Recruiter</td>
<td width="25%" class="hdr">Reccruiters</td>
<td width="25%" class="hdr">CSRO</td>
</tr>


<tr bgcolor="#FFFFFF">
<td class="admin_name">
{foreach from=$members name=m item=m}
    {if $m.member_position eq 'hiring coordinator' }<span class="admin_name" >{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
<td class="admin_name">
{foreach from=$members name=m item=m}
    {if $m.member_position eq 'head recruiter' }<span class="admin_name">{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
<td class="admin_name">
{foreach from=$members name=m item=m}
    {if $m.member_position eq 'recruiter' }<span class="admin_name">{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
<td class="admin_name">
{foreach from=$members name=m item=m}
    {if $m.member_position eq 'csro' }<span class="admin_name">{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
</tr>

</table>

{if $histories}
{ include file="history.tpl" }
{/if}

</div>


{literal}
<script>
<!--
//script here
-->
</script>
{/literal}
{ include file="footer.tpl" }