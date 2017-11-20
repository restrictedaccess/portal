<fieldset id="history">
<legend>HISTORY</legend>
<div id="scroll">
{foreach from=$histories item=history name=history} 
   <div style="color:#000000 !important; float:right;"><span>{$history.admin_fname} {$history.admin_lname} - {$history.date_history}</span></div>
	{$history.history}
	
	
{/foreach}
</div>
</fieldset>