


<table width='100%' cellpadding='5'cellspacing='1' bgcolor="#CCCCCC"  >
<tr bgcolor="#FFFFFF">
<td width="2%"><input type="checkbox" name="merge_{$leads_new_info.id}" value="fname"  /></td>
<td width="12%" valign="top" class="td_info td_la" >First Name</td>
<td width="86%" valign="top" class="td_info"><b>{$leads_new_info.fname|escape}</b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="merge_{$leads_new_info.id}" value="lname"  /></td>
<td valign="top" class="td_info td_la" >Last Name</td>
<td valign="top" class="td_info"><b>{$leads_new_info.lname|escape} </b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="merge_{$leads_new_info.id}" value="officenumber"  /></td>
<td valign="top" class="td_info td_la">Company Phone</td>
<td valign="top" class="td_info">{$leads_new_info.officenumber|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="merge_{$leads_new_info.id}" value="mobile"  /></td>
<td valign="top" class="td_info td_la">Mobile Phone</td>
<td valign="top" class="td_info">{$leads_new_info.mobile|escape}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td  valign="top" class="td_info td_la">Status</td>
<td  valign="top" class="td_info"><b style="color:#FF0000;">{$leads_new_info.status}</b></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td  valign="top" class="td_info td_la">Promotional Code</td>
<td  valign="top" class="td_info" style="color:#006600;">{$leads_new_info.tracking_no}</td>
</tr>



<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td  valign="top" class="td_info td_la">Date Registered</td>
<td  valign="top" class="td_info">{$date_registered}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td  valign="top" class="td_info td_la">Country / IP</td>
<td  valign="top" class="td_info">{$leads_new_info.leads_country} {$leads_new_info.leads_ip}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td  valign="top" class="td_info td_la">Email</td>
<td  valign="top" class="td_info"><input type="text" id="email" name="email" value="{$leads_new_info.email}" size="40" /> <small>( Email Address is not included in merging )</small>
</td>
</tr>




{*
{if $leads_message_temp_count neq 0}
<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="merge_{$leads_new_info.id}" value="your_questions" /></td>
<td valign="top" class="td_info td_la">Lead Messages</td>
<td valign="top" class="td_info">
	{section name=j loop=$leads_message_temp}
		<div><img src="./leads_information/media/images/quote.png" />{$leads_message_temp[j].message|regex_replace:"/[\r\t\n]/":"<br>"}<img src="./leads_information/media/images/quote-end.png" /></div>
	{/section}
</td>
</tr>
{/if}
*}
</table>


<div style="height:20px;">&nbsp;</div>

<div style="text-align:center;"><input type='button' name='edit_merge' class='lsb2' value='MERGE' onclick="Merge()" /> <input type='button' class='lsb2' name="edit_separate" value='SEPARATE' onclick="Separate()"  />
{if $admin_section eq True}
 <input type='button' name="acknowledge" class='lsb2' value='ACKNOWLEDGE' onclick="Acknowledge()" />
{/if} 
 </div>