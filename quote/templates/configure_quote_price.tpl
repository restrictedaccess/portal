<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="margin-top:20px;">
<tr bgcolor="#FFFFFF">
{foreach from=$quote_price name=p item=p}
    <td valign="top">
	    <div class="quote_price">
        <div class="c_currency">{$p.currency}</div>
		<p><label>Yearly : </label>{$p.sign}{$p.yearly|number_format:2:".":","}</p>
		<p><label>Monthly : </label><span>{$p.sign}{$p.monthly|number_format:2:".":","}</span></p>
		<p><label>Weekly : </label>{$p.sign}{$p.weekly|number_format:2:".":","}</p>
		<p><label>Daily : </label>{$p.sign}{$p.daily|number_format:2:".":","}</p>
		<p><label>Hourly : </label><span>{$p.sign}{$p.hourly|number_format:2:".":","}</span></p>
		{if $p.currency_rate}
		 <p style="background:#666666; margin:0; color:#EEEEEE;"><label>{$salary|number_format:2:".":","} / </label>{$p.sign}{$p.currency_rate|number_format:2:".":","}</p>
		{/if}
		
		<div align="center" style="background:#666666; margin:0; color:#EEEEEE;">
		{if $p.fulltime_margin}
		 Fulltime Margin at {$p.sign}{$p.fulltime_margin|number_format:2:".":","}<br />
		{/if}
		{if $p.parttime_margin}
		 Parttime Margin at {$p.sign}{$p.parttime_margin|number_format:2:".":","}<br />
		{/if}
		</div>
		</div>
    </td>
{/foreach}
</tr>
</table>

{if $show_message}
<p style="font-weight:bold; text-align:center; margin-bottom:20px;">{$show_message}</p>
{/if}