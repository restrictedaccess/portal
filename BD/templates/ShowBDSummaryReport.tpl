<input type="hidden" name="current_date" id="current_date" value="{$current_date}">
<div>
<h2 align="center">
{if $date_selection}
    {$current_date|date_format:"%B %e, %Y"}
{else}
    {if $year neq '' && $month eq ''  }
		YEAR [ {$year} ] ANNUAL RESULT
	{else}
	    {$format_date|date_format:"%B %Y"}	
	{/if}
	
{/if }
</h2>
<p>SYSTEM RESULT <small>(All Business Developers and Admin made)</small></p>
</div>
	<table width="250" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" style="float:left; margin-left:10px;">
	<tr bgcolor="#006699" >
	<td width="80%" valign="top" style="color:#FFFFFF;"><strong>Total no. of leads registered</strong></td>
	<td width="20%" valign="top" style="color:#FFFFFF;"><strong>{$total_no_of_leads_registered}</strong></td>
	</tr>
	{section name=j loop=$total_no_of_leads_breakdowns}
	<tr bgcolor="#FFFFFF" >
	<td valign="top" style="font-size:10px;"><img src="images/user_add.png" align="absmiddle" /> {$total_no_of_leads_breakdowns[j].registered_in|capitalize}</td>
	<td valign="top" style="font-size:10px;">{$total_no_of_leads_breakdowns[j].registered_in_total}</td>
	</tr>
	{/section}
	</table>

	{if $affiliate_referrals_ctr neq 0}
	<table width="250" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" style="float:left; margin-left:10px;">
	<tr bgcolor="#006699" >
	<td width="80%" valign="top" style="color:#FFFFFF;"><strong>Affiliate Referrals</strong></td>
	<td width="20%" valign="top" style="color:#FFFFFF;"><strong>{$affiliate_referral_total}</strong></td>
	</tr>
	{$affiliate_referral_str}
	</table>
	{/if}
	
	<table width="250" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" style="float:left; margin-left:10px;">
	<tr bgcolor="#006699" >
	<td width="80%" valign="top" style="color:#FFFFFF;"><strong>Actions</strong></td>
	<td width="20%" valign="top" style="color:#FFFFFF;"><strong>&nbsp;</strong></td>
	</tr>
	{$action_str}
	</table>
	
	<table width="250" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" style="float:left; margin-left:10px;">
	<tr bgcolor="#006699" >
	<td width="80%" valign="top" style="color:#FFFFFF;"><strong>Sent Out</strong></td>
	<td width="20%" valign="top" style="color:#FFFFFF;"><strong>&nbsp;</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF" >
	<td valign="top" style="font-size:10px;"><img src="images/bullet_red.png" align="absmiddle" /> Quotes</td>
	<td valign="top" style="font-size:10px;">{$quote_count}</td>
	</tr>
	<tr bgcolor="#FFFFFF" >
	<td valign="top" style="font-size:10px;"><img src="images/bullet_red.png" align="absmiddle" /> Setup Fee</td>
	<td valign="top" style="font-size:10px;">{$setup_fee_count}</td>
	</tr>
	<tr bgcolor="#FFFFFF" >
	<td valign="top" style="font-size:10px;"><img src="images/bullet_red.png" align="absmiddle" /> Service Agreement</td>
	<td valign="top" style="font-size:10px;">{$service_agreement_count}</td>
	</tr>
	<tr bgcolor="#FFFFFF" >
	<td valign="top" style="font-size:10px;"><img src="images/bullet_red.png" align="absmiddle" /> Recruitment Job Order Form</td>
	<td valign="top" style="font-size:10px;">{$job_order_count}</td>
	</tr>
	</table>

<br clear="all" />


<table id="agent_list" width="100%" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
<tr bgcolor="#006699" >
<td width="25%" valign="top" style="color:#FFFFFF;"><strong>Business Developers</strong></td>
<td width="19%" valign="top" style="color:#FFFFFF;"><strong>Leads</strong></td>
<td width="18%" valign="top" style="color:#FFFFFF;"><strong>Actions</strong></td>
<td width="18%" valign="top" style="color:#FFFFFF;"><strong>Sent Out</strong></td>
<td width="20%" valign="top" style="color:#FFFFFF;"><strong>Affiliate Referrals</strong></td>
</tr>
{$agent_str}

</table>