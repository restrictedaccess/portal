<!--
<div id="admin_list">

    <div class="admin_box">
        <ul>
               <li class="counter hdr">#</li>
               <li class="name hdr">Name</li>
               <li class="status hdr">Control</li>
               <li class="yn hdr adj2"><br>Manage Recruiters</li>
               <li class="yn hdr adj2"><br>Adjust Timesheet</li>
               <li class="yn hdr adj">Force Logout</li>
               <li class="yn hdr adj2"><br>Notify Invoice Notes</li>
               <li class="yn hdr adj">CSRO</li>
               <li class="yn hdr adj2"><br>Hiring Coordinator</li>
               <li class="yn hdr adj2"><br>View Screen Shots</li>
               <li class="yn hdr adj2"><br>View Camera Shots</li>
               <li class="yn hdr adj2"><br>View RSSC Dashboard</li>
               <li class="yn hdr adj2"><br>Edit RSSC Setings</li>
               <li class="yn hdr adj2"><br>Manage Staff Invoice</li>
               <li class="yn hdr">View Inhouse Confidential Info</li>
               <li class="yn hdr adj2"><br>Edit Admin Settings</li>
        </ul>
    </div>

</div>
-->
<table align="center" id="tb_admin" width="98%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#333333">
    <td width="15%" style="color:#CCC"><strong>Administrators</strong></td>
    <td width="8%" style="color:#CCC" align="center"><strong>Control</strong></td>
	<td width="5%" style="color:#CCC" align="center"><strong>Manage Recruiters</strong></td>
    <td width="9%" style="color:#CCC" align="center"><strong>Adjust Timesheet</strong></td>
    <td width="5%" style="color:#CCC" align="center"><strong>Force Logout</strong></td>
    <td width="6%" style="color:#CCC" align="center"><strong>Notify Invoice Notes</strong></td>
    <td width="8%" style="color:#CCC" align="center"><strong>Notify Timesheet Notes</strong></td>
    <td width="5%" style="color:#CCC" align="center"><strong>CSRO</strong></td>
	<td width="5%" style="color:#CCC" align="center"><strong>Hiring Coordinator</strong></td>
	<td width="5%" style="color:#CCC" align="center"><strong>View Screenshots</strong></td>
	<td width="5%" style="color:#CCC" align="center"><strong>View Camshots</strong></td>
	<td width="5%" style="color:#CCC" align="center"><strong>View Other Admins' Calendar</strong></td>
	
	<td width="5%" style="color:#CCC" align="center"><strong>View RSSC Dashboard</strong></td>
	<td width="5%" style="color:#CCC" align="center"><strong>Edit RSSC Setting</strong></td>
	<td width="5%" style="color:#CCC" align="center"><strong>Manage Staff Invoice</strong></td>
    <td width="5%" style="color:#CCC" align="center"><strong>View Inhouse Confidential Info</strong></td>
    
    <td width="12%" style="color:#CCC" align="center"><strong>Settings</strong></td>
  </tr>
 
{section name=j loop=$result}
{strip}
  <tr bgcolor="#FFFFFF" class="admin_listings">
    <td>
	<div style="text-transform:capitalize;">#{$result[j].admin_id} {$result[j].admin_fname|lower} {$result[j].admin_lname|lower}</div>
	</td>
    <td align="center">{$result[j].status}</td>
    <td align="center">{if $result[j].manage_recruiters eq 'Y'} YES {/if} {if $result[j].manage_recruiters eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].adjust_time_sheet eq 'Y'} YES {/if} {if $result[j].adjust_time_sheet eq 'N'} NO {/if}</td>
    <td align="center">{if $result[j].force_logout eq 'Y'} YES {/if} {if $result[j].force_logout eq 'N'} NO {/if}</td>
    <td align="center">{if $result[j].notify_invoice_notes eq 'Y'} YES {/if} {if $result[j].notify_invoice_notes eq 'N'} NO {/if}</td>
    <td align="center">{if $result[j].notify_timesheet_notes eq 'Y'} YES {/if} {if $result[j].notify_timesheet_notes eq 'N'} NO {/if}</td>
    <td align="center">{if $result[j].csro eq 'Y'} YES {/if} {if $result[j].csro eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].hiring_coordinator eq 'Y'} YES {/if} {if $result[j].hiring_coordinator eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].view_screen_shots eq 'Y'} YES {/if} {if $result[j].view_screen_shots eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].view_camera_shots eq 'Y'} YES {/if} {if $result[j].view_camera_shots eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].view_admin_calendar eq 'Y'} YES {/if} {if $result[j].view_admin_calendar eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].view_rssc_dashboard eq 'Y'} YES {/if} {if $result[j].view_rssc_dashboard eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].edit_rssc_settings eq 'Y'} YES {/if} {if $result[j].edit_rssc_settings eq 'N'} NO {/if}</td>
	<td align="center">{if $result[j].manage_staff_invoice eq 'Y'} YES {/if} {if $result[j].manage_staff_invoice eq 'N'} NO {/if}</td>
    <td align="center">{if $result[j].view_inhouse_confidential eq 'Y'} YES {/if} {if $result[j].view_inhouse_confidential eq 'N'} NO {/if}</td>
    <td align="center">
	<span style="cursor:pointer; color:#0000FF;" onclick="OnClickShowAdminAddEditFormUsers({$result[j].admin_id},'update');">Edit</span>  
	<span style="cursor:pointer; color:#0000FF; margin-left:5px;" onclick="OnClickDeleteAdminUsers({$result[j].admin_id});">Delete</span> 
	<span style="cursor:pointer; color:#0000FF; margin-left:5px;" onclick="showResetPasswordForm({$result[j].admin_id});">Reset</span>
	</td>
  </tr>
{/strip}
{/section}

</table>