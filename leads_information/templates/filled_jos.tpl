<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
    <tr bgcolor='#90ac24'  >
        <td width="20%" align='center'><strong>Order Date</strong></td>
        <td width="80%" valign="top">
            <table width="100%" cellspacing="1" bgcolor="#CCCCCC">
                <tr bgcolor='#90ac24'  >
                <td width="45%" align='center'><strong>Job Position</strong></td>
                <td width="20%" align='center'><strong>Order Status</strong></td>
                </tr>
            </table>
        </td>
    </tr>

{foreach from=$orders item=order name=order}
    <tr bgcolor='#FFFFFF'>
    	<td align="center">{$order.order_date}</td>
        <td>
        	<table width="100%" >
            	{foreach from=$order.filled_forms item=position name=position}
                <tr bgcolor='#FFFFFF'  >
                <td width="45%" align='center'><a href="javascript:popup_win('/portal/get_started/job_spec.php?gs_job_titles_details_id={$position.gs_job_titles_details_id}&jr_cat_id={$position.jr_cat_id}&jr_list_id={$position.jr_list_id}&gs_job_role_selection_id={$position.gs_job_role_selection_id}' , 950 , 600)">{$position.job_position} {$position.level} level</a></td>
                <td width="20%" align='center'>{$position.order_status}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
{/foreach}

</table>