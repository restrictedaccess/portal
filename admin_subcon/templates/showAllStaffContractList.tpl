<table align="center" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td width="25%" valign="top" bgcolor="">
<div class="sl_hdr">NEW REGULAR CONTRACT</div>
{ foreach from=$regular_clients item=client name=client }
<div style="background:{cycle values='#CCFFCC, #FFFFCC'}">
    <div class="c_lient">Client #{ $client.leads_id } { $client.client_name }</div>
	{ foreach from=$client.staffs item=staff name=staff }
	    <div class="show_contract_details" subcon_id="{$staff.id}" mode="new" staff_name="{ $staff.userid } { $staff.staff_name }"><img src="./images/arrow.gif" />{ $staff.userid } { $staff.staff_name }</div>
	{/foreach}
</div>
{ foreachelse }
     <div align="center">No new regular contracts found...<div class="show_contract_details" style="visibility:hidden;" ></div></div>
{ /foreach}			
</td>
<td width="25%" valign="top">
<div class="sl_hdr">NEW PREPAID CONTRACT</div>
{ foreach from=$prepaid_clients item=client name=client }
<div style="background:{cycle values='#FFFFCC, #CCFFCC'}">
    <div class="c_lient">Client #{ $client.leads_id } { $client.client_name }
	
	
	{if $client.no_invoiced_staff eq 0}
	    <input type="button" value="send invoice" id="send_btn_{ $client.leads_id }" onclick="send_invoice({ $client.leads_id }, 'new')"   >
	{/if}
	
	{if $client.no_invoiced_staff eq $client.no_of_staff}
	    {if $client.no_of_paid_staff eq $client.no_invoiced_staff }
		{else}
	    <input type="button" value="resend invoice" id="send_btn_{ $client.leads_id }" onclick="send_invoice({ $client.leads_id }, 'resend')"   >
		{/if}
	{/if}
	
	</div>
	
	{if $client.no_invoiced_staff neq 0  }
	{if $client.no_invoiced_staff lt $client.no_of_staff  }
	    <div class="c_lient">
	    <input type="button" value="resend issued invoice" style="width:110px;" id="send_btn_{ $client.leads_id }" onclick="send_invoice({ $client.leads_id }, 'resend')" title="Send again an another issued invoice to client"   >
		<input type="button" value="send new invoice" style="width:110px;" id="send_btn_{ $client.leads_id }" onclick="send_invoice({ $client.leads_id }, 'new')"  title="Send a  new invoice to client whose staffs are not yet been invoiced"  >
		<br clear="all" />
		</div>
		
	{/if}
	{/if}
	
	
	{ foreach from=$client.staffs item=staff name=staff }
	    <div class="show_contract_details" subcon_id="{$staff.id}" mode="new" staff_name="{ $staff.userid } { $staff.staff_name }"><img src="./images/arrow.gif" />{ $staff.userid } { $staff.staff_name|capitalize }
		{if $staff.counter > 0 }
			<small style="color:green;">-<strong>{$staff.status}</strong></small>
		{else}
			<small style="color:#FF0000;">- not yet been invoiced</small>
		{/if}
		</div>
	{/foreach}
</div>
{ foreachelse }
      <div align="center">No new prepaid contracts found...<div class="show_contract_details" style="visibility:hidden;" ></div></div>
{ /foreach}
</td>
<td width="25%" valign="top" ><div class="sl_hdr">UPDATED REGULAR CONTRACT</div>
{ foreach from=$updated_regular_contracts item=client name=client }
<div style="background:{cycle values='#CCFFCC, #FFFFCC'}">
    <div class="c_lient">Client #{ $client.leads_id } { $client.client_name }</div>
	{ foreach from=$client.staffs item=staff name=staff }
	    <div class="show_contract_details" subcon_id="{$staff.id}" mode="updated" staff_name="{ $staff.userid } { $staff.staff_name }"><img src="./images/arrow.gif" />{ $staff.userid } { $staff.staff_name }</div>
	{/foreach}
</div>
{ foreachelse }
     <div align="center">No new regular contracts found...<div class="show_contract_details" style="visibility:hidden;" ></div></div>
{ /foreach}
</td>
<td width="25%" valign="top"><div class="sl_hdr">UPDATED PREPAID CONTRACT</div>
{ foreach from=$updated_prepaid_contracts item=client name=client }
<div style="background:{cycle values='#CCFFCC, #FFFFCC'}">
    <div class="c_lient">Client #{ $client.leads_id } { $client.client_name }</div>
	{ foreach from=$client.staffs item=staff name=staff }
	    <div class="show_contract_details" subcon_id="{$staff.id}" mode="updated" staff_name="{ $staff.userid } { $staff.staff_name }"><img src="./images/arrow.gif" />{ $staff.userid } { $staff.staff_name }</div>
	{/foreach}
</div>
{ foreachelse }
     <div align="center">No new regular contracts found...<div class="show_contract_details" style="visibility:hidden;" ></div></div>
{ /foreach}
</td>
</tr>
</table>