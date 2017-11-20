

<table id="leads_new_info"  width='50%' cellpadding='3'cellspacing='0' style="margin-top:20px; border:#CCCCCC solid 1px;"   >
<tr bgcolor="#333333"><td colspan="2" align="center" style="color:#FFFFFF; font-weight:bold; padding:5px; border-bottom:#000000 solid 1px;">
{$mode|capitalize} Mode
</td></tr>

  <tr>
    <td width="30%" valign="top" class="td_info td_la" >First name</td>
    <td width="70%" valign="top" class="td_info">
      <input type="text" name="fname" class="put" id="fname" value="{$leads_new_info.fname|escape}" /> 
	{if $mode eq 'merge'}
		{if $leads_info.fname neq $leads_new_info.fname}
		<span id="fname_span" style="float:right;"><a href="javascript:MergePerColumn('fname');"><img src="images/icon-merge.gif" border="0" title="merge" /></a></span>
		{else}
		<span style="float:right;"><img src="images/icon-merge.gif" class="shadow" title="cannot be merge" /></span>
		{/if}	
	{/if}
	</td>
  </tr>
   <tr>
    <td valign="top" class="td_info td_la" >Last name</td>
    <td valign="top" class="td_info">
      <input type="text" name="lname" class="put" id="lname" value="{$leads_new_info.lname|escape}" /> 
	{if $mode eq 'merge'}
		{if $leads_info.lname neq $leads_new_info.lname}
	<span id="lname_span" style="float:right;"><a href="javascript:MergePerColumn('lname');"><img src="images/icon-merge.gif" border="0" title="merge" /></a></span>
		{else}
		<span style="float:right;"><img src="images/icon-merge.gif" class="shadow" title="cannot be merge" /></span>
		{/if}
			
	{/if}
	</td>
  </tr>
  <tr>
    <td  valign="top" class="td_info td_la">Status</td>
    <td  valign="top" class="td_info"><b style="color:#FF0000;">{$leads_new_info.status}</b>
	</td>
  </tr>
  <tr>
    <td  valign="top" class="td_info td_la">Promotional Code</td>
    <td  valign="top" class="td_info" style="color:#006600;">{$leads_new_info.tracking_no}</td>
  </tr>
  <tr>
    <td  valign="top" class="td_info td_la">Date Registered</td>
    <td  valign="top" class="td_info">{$date_registered}</td>
  </tr>
  <tr>
    <td  valign="top" class="td_info td_la">Email</td>
    <td  valign="top" class="td_info">
	{if $mode eq 'merge'}
	{$leads_new_info.email} <br />
<small style="color:#999999; font-size:10px;">(email is not included during merge)</small>
	{/if}
	{if $mode eq 'separate'}
		<input type="text" class="put" name="email" id="email" value="{$leads_new_info.email}" /> <br />
<small style="color:#FF0000; font-size:10px;">(Please input a different email address)</small>
	{/if}
</td>
  </tr>
  <tr>
    <td width="30%" valign="top" class="td_info td_la">Country / IP</td>
    <td width="70%" valign="top" class="td_info">{$leads_new_info.leads_country} / {$leads_new_info.leads_ip}</td>
  </tr>
  <tr>
    <td width="30%" valign="top" class="td_info td_la">Leads of</td>
    <td width="70%" valign="top" class="td_info">{$leads_of}</td>
  </tr>
 
 
 
 
  <tr >
    <td width="30%" valign="top" class="td_info td_la" >Company Phone</td>
    <td width="70%" valign="top" class="td_info" ><input type="text" class="put" name="officenumber" id="officenumber" value="{$leads_new_info.officenumber|escape}" />
	{if $mode eq 'merge'}
		{if $leads_info.officenumber neq $leads_new_info.officenumber}
	<span id="officenumber_span" style="float:right;"><a href="javascript:MergePerColumn('officenumber');"><img src="images/icon-merge.gif" border="0" title="merge" /></a></span>
		{else}
		<span style="float:right;"><img src="images/icon-merge.gif" class="shadow" title="cannot be merge" /></span>
		{/if}
	{/if}
	</td>
  </tr>
  <tr>
    <td width="30%" valign="top" class="td_info td_la"  >Mobile Phone</td>
    <td width="70%" valign="top" class="td_info" ><input type="text" class="put" name="mobile" id="mobile" value="{$leads_new_info.mobile|escape}" />
	{if $mode eq 'merge'}
		{if $leads_info.mobile neq $leads_new_info.mobile}
	<span id="mobile_span"  style="float:right;"><a href="javascript:MergePerColumn('mobile');"><img src="images/icon-merge.gif" border="0" title="merge" /></a></span>
		{else}
		<span style="float:right;"><img src="images/icon-merge.gif" class="shadow" title="cannot be merge" /></span>
		{/if}
	{/if}
		</td>
  </tr>
 
  <tr>
    <td colspan="2" valign="top" class="td_info td_la"><div>Question/Concern</div>
	{if $leads_message_temp_count neq 0}
		{if $mode eq 'merge'}
		<span id="leads_message_span" style="float:right;"><a href="javascript:MergePerColumn('leads_message');"><img src="images/icon-merge.gif" border="0" title="merge" /></a></span>
		{/if}
	
        <div id="leads_temp_message" style=" height:150px; overflow:auto; margin-top:7px;">
			  	  	  <table width="100%" cellpadding="2" cellspacing="1" style="background:#CCCCCC;">
<tr >
<td width="14%" align='center'  class="act_tb_hdr" valign="top">Date</td>
<td width="10%" align='center'  class="act_tb_hdr" valign="top">Time</td>
<td width="9%" align='center'  class="act_tb_hdr" valign="top">Type</td>
<td width="40%" class="act_tb_hdr" valign="top">Content</td>
<td width="18%" align='center' class="act_tb_hdr">User</td>
<td width="9%" class="act_tb_hdr">&nbsp;</td>
</tr>

		 {include file="leads_message_temp.tpl"}</table> </div>
	{/if}	
		</td>
  </tr>
  
  <tr><td colspan="2" align="center" >
  {if $mode eq 'merge'}
<input type='submit' name='merge' class='lsb2' value='MERGE ALL' />
<input type='submit' name="acknowledge" class='lsb2' value='MERGE SELECTED FIELD' />
{/if}
{if $mode eq 'separate'}
<input type='submit' class='lsb2' name="separate" value='CLICK TO SEPARATE'  />
{/if}

 <input type='button' class='lsb2' value='CANCEL' onclick="location.href='leads_information2.php?id={$leads_id}&lead_status={$lead_status}'" />

  </td></tr>
</table>



<div style="height:20px;">&nbsp;</div>

<div style="text-align:center;">

 </div>
