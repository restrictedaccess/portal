<table width="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#CCCCCC>
	<tr>
    	<td>
            <table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
                <tr bgcolor="#FFFFFF">
                    <td width="100%" align="left" valign="top"><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>{ if $type eq 'staff files' } CSRO: Staff Unploaded Files Reports { else } Files Uploaded { /if }</strong></font></td><td align="right"><a href='javascript: staff_files_counter_exit(); '><img src="../../portal/images/closelabel.gif" border="0" /></a></td></tr></table></div></td>
                </tr>
                <tr>
                    <td valign="top">
						<table width="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
							<tr>
								<td width="5%" align="left" valign="top" class="td_info td_la">#</td>
								<td width="40%" align="left" valign="top" class="td_info td_la">Name</td>
								<td width="20%" align="left" valign="top" class="td_info td_la" width="">Description</td>
                                <td width="20%" align="left" valign="top" class="td_info td_la" width="">Lock</td>
                                <td width="20%" align="left" valign="top" class="td_info td_la" width="">Date Added</td>
                                <td width="15%" align="left" valign="top" class="td_info td_la">&nbsp;</td>
							</tr>	
							{ foreach from=$staff_files_set item=sf name=ctr}
                                <tr>
                                    <td align="left" valign="top" class="td_info td_la">{ $smarty.foreach.ctr.iteration }.</td>
                                    <td align="left" valign="top" class="td_info">
                                        {if $TEST}    
                                            <a href='../applicants_files/{ $sf.name }' target='_blank'>{ $sf.name }</a>
                                        {else}
                                            <a href='https://remotestaff.com.au/portal/applicants_files/{ $sf.name }' target='_blank'>{ $sf.name }</a>
                                        {/if}
                                        
                                    </td>
                                    <td align="left" valign="top" class="td_info">{ $sf.file_description }</td>
                                    <td align="left" valign="top" class="td_info">{ if $sf.permission eq 'ADMIN' } <input type="checkbox" id="permission{ $sf.id }" checked="checked" onchange="javascript: staff_file_permission_update({ $sf.id }); " /> { else } <input type="checkbox" id="permission{ $sf.id }" onchange="javascript: staff_file_permission_update({ $sf.id }); " /> { /if }</td>
                                    <td align="left" valign="top" class="td_info">{ $sf.date_created }</td>
                                    <td align="left" valign="top" class="td_info"><a href="javascript: delete_file_confirmation('userid={ $userid }&file_id={ $sf.id }','{ $sf.name }'); ">Delete</a></td>
                                </tr>
							{ /foreach }
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>                                    