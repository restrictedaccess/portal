<table width="600" cellpadding="5" cellspacing="1" bgcolor="#333333" style="margin-left:10px;">
{if $comment_by_type eq 'admin'}
<tr>
<td valign="top">
<table width="100%" bgcolor="#CCCCCC" cellpadding="2" cellspacing="1">

<tr bgcolor="#FFFFFF">
<td width="17%">Staff Name</td>
<td width="83%"><img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=48&id={$staff.userid}' border='0' align='texttop'  /> {$staff.userid} {$staff.fname|capitalize} {$staff.lname|capitalize}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Email</td>
<td>{$staff.email}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Client(s)</td>
<td valign="top">{$leads_options}</td>
</tr>


</table>
</td>
</tr>

{/if}
<tr>
<td valign="top" ><div id="calendar_holder">{$calendar}</div></td>
</tr>
</table>





