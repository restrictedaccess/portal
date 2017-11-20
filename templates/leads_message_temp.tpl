	{section name=j loop=$leads_message_temp}
		
		
		<tr bgcolor='#FFFFFF'>
	<td align='center' class='act_td'>{$leads_message_temp[j].date_created|date_format:"%B %e, %Y"}</td>
	<td align='center' class='act_td'>{$leads_message_temp[j].date_created|date_format:"%H:%M:%S %p"}</td>
	<td align='center' class='act_td'>MESSAGE FROM LEAD</td>
<td class='act_td'><div>{$leads_message_temp[j].message|regex_replace:"/[\r\t\n]/":"<br>"}</div></td>
	<td align='center' class='act_td'>{$leads_info.fname}</td>
	<td align='center' class='act_td $e_d'>&nbsp;</td>
 </tr>
		
		
		
	{/section}
	

