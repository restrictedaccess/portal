<table width="100%" cellpadding="2" cellspacing="1" style="background:#CCCCCC;">
	<tr>
		<td width="15%" align='center' class="act_tb_hdr">Tracking Code</td>
		<td width="15%" align='center' class="act_tb_hdr"> Subject </td>
		<td width="40%" align='center' class="act_tb_hdr"> Notes </td>
		<td width="15%" align='center' class="act_tb_hdr"> Added By </td>
		<td width="15%" align='center' class="act_tb_hdr"> Date Added </td>
	</tr>
	{foreach from=$job_order_notes key="k" item=job_order_note }
		{if $k++ % 2 == 1}
			<tr bgcolor="#EEEEEE">
		{else}
			<tr bgcolor="#FFFFFF">
		{/if}
			<td width="15%" align='center'> {$job_order_note.tracking_code} </td>
			<td width="15%" align='center'> {$job_order_note.subject} </td>
			<td style="word-wrap: break-word; max-width: 150px !important; min-width: 150px !important; white-space: normal;"> {$job_order_note.comment} </td>
			<td width="15%" align='center'> {$job_order_note.admin_fname} {$job_order_note.admin_lname} </td>
			<td width="15%" align='center'> {$job_order_note.date_created} </td>
		</tr>
	{/foreach}
</table>
