<div id="overlay"><div id="add_form" style="width:300px;">
<h3>Staff Contract Finish Date</h3>
<p>
{$label}
<input type="hidden" name="close_contract_status" id="close_contract_status">
<input type="hidden" name="scheduled_close_contract_id" id="scheduled_close_contract_id" value="{$schedule_close_contract.id}">
<input type="hidden" name="min_date" id="min_date" value="{$min_date}" />
<input type="text" name="end_date_str" id="end_date_str" value="{$end_date_str}" readonly >
<br>
<input name="button" type="button" id="close_contract_btn" onClick="CloseContract()" value="Close Contract" /><input type="button" onClick="fade('overlay')" value="Close" />   </p>		
		</div></div>