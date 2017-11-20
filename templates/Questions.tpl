<table width="100%" cellpadding="2" cellspacing="1" style="background:#CCCCCC;">
<tr >
<td width="15%" align='center' class="act_tb_hdr">Date</td>
<td width="15%" align='center' class="act_tb_hdr">Time</td>
<td width="20%" align='center' class="act_tb_hdr">Applicant</td>
<td width="50%" class="act_tb_hdr">Question / Concern</td>
</tr>

{foreach from=$questions item=question name=question}

<tr bgcolor="{if $question.status eq 'unread'} #FFFFFF {else} #EEEEEE {/if}" >
<td align='center' >{$question.date_created|date_format:"%B %e, %Y"}</td>
<td align='center'>{$question.date_created|date_format:"%I:%M:%S %p"}</td>
<td align='center'>
{if $admin_section eq True}
<a href="recruiter/staff_information.php?userid={$question.userid}" target="_blank">#{$question.userid} {$question.fname}</a>
{else}
<a href="../available-staff-resume.php?userid={$question.userid}" target="_blank">#{$question.userid} {$question.fname}</a>
{/if}
</td>
<td ><a href="javascript:popup_win('./viewQuestion.php?id={$question.id}',500,400);">{$question.question|substr:0:100}</a>
<span style="float:right; font-size:10px; color:#666666">{$question.status}</span></td>
</tr>

{/foreach}
</table>