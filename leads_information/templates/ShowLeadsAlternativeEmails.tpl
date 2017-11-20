<table width="80%" cellpadding="1" cellspacing="2">
{section name=j loop=$alternate_emails}
<tr>
<td width="72%">{$alternate_emails[j].email}</td>
<td width="28%"><a href="javascript:DeleteAlternativeEmail({$alternate_emails[j].id});">x</a></td>
</tr>
{/section}
</table>