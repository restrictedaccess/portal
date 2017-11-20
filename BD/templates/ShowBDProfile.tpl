<a href="javascript:toggle('BD_Profile')" style="float:right; color:#FFFFFF; text-decoration:none; padding-right:5px; font-weight:bold;">[x]</a>
<span class="BD_header">#{$agent.agent_no} {$agent.fname|capitalize} {$agent.lname|capitalize}</span><br />
<div class="BD_content">
<table width="100%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">

<tr bgcolor="#FFFFFF">
<td width="40%">Email</td>
<td  width="60%">{$agent.email}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td >Date Created</td>
<td >{$agent.date_registered|date_format:"%B %e, %Y"}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Address</td>
<td>{$agent.agent_address}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Contact Nos.</td>
<td>{$agent.agent_contact}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td>Status</td>
<td>{$agent.status}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td>Can Access all Leads</td>
<td>{$agent.access_all_leads}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Can Access Affiliates Leads</td>
<td>{$agent.access_aff_leads}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td valign="top"><p>Assign Affiliates</p></td>
<td valign="top" >
<div style="text-align:right; color:#999999; font-size:11px;">Assign Affiliates <a href='admin_assign_bp_affiliate.php?id={$agent.agent_no}'><b>HERE</b></a></div>
	{if $affiliates_count neq 0}
		<ol>
			{section name=j loop=$affiliates}
				<li>{$affiliates[j].fname|capitalize} {$affiliates[j].lname|capitalize}</li>
			{/section}
		</ol>
	{else}
		There are no assign Affiliates.
	{/if}
</td>
</tr>

{if $ShowAgentInfoChangesHistory neq ''} 
<tr bgcolor="#FFFFFF"><td colspan="2" valign="top">
<strong>History changes</strong>
<div style="display:block; height:320px; overflow-y:scroll; overflow-x:hidden; border-left:#CCCCCC solid 1px; border-top:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;">{$ShowAgentInfoChangesHistory}</div> 
</td>
</tr>
{/if}



</table>
</div>
