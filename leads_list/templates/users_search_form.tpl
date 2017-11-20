<!-- USER SEARCH FORM CONTAINER START-->
<div id="users_search_form">

	<!-- HIDDEN FIELDS -->
	<input type="hidden" name="page" id="page" value="{$pageNum}" />
	<input type="hidden" name="agent_no" id="agent_no" />
	<input type="hidden" name="path" id="path" value="{$path}" />
	<input type="hidden" name="applicants" id="applicants">
	<input type="hidden" name="status" id="status" >

	<!-- START FORM FILTER CONTAINER -->
	<div class="form_filters">

		<!-- START FORM FILTER FIELDSET -->
		<fieldset style="padding: 15px;">

			<legend> SEARCH FILTERS </legend>

			<!-- TABLE SEARCH -->
			<table width="67%" cellspacing="0" style="margin: 0 auto;">
				<tbody>
					<tr>
						<td>Search By:</td>
						<td colspan="3">
							<select name="field" id="field">
								<option value="keyword">Keyword</option>
								{ foreach from=$fields key=k item=fields }
									{if $k eq $field }
										<option value="{$k}" selected="selected">{$fields|capitalize}</option>
									{else}
										<option value="{$k}" >{$fields|capitalize}</option>
									{/if}
								{ /foreach}
							</select>
							<input type="text" name="keyword" id="keyword" value="{$keyword}" size="30" />
						</td>
						<td></td>
					</tr>
					<tr>
						<td style="width: 60px;">Search Leads: </td>
						<td style="width: 130px;">
							<select name="lead_status" id="lead_status" style="width:130px;">
								{ if $current_user.menu_status eq 'FULL-CONTROL'}
									<option value="All">All</option>
								{/if}
								{ foreach from=$lead_statuses item=statuses }
									{if $statuses.status}
										{if $lead_status eq $statuses.status }
											<option value="{$statuses.status}" selected="selected">{$statuses.status|capitalize}</option>
										{else}
											<option value="{$statuses.status}" >{$statuses.status|capitalize}</option>
										{/if}
									{/if}
								{ /foreach}
							</select>
						</td>
						<td style="width: 50px;">Business Developer:</td>
						<td style="width: 130px;">
							<select name="business_developer_id" id="business_developer_id" style="width:130px;"
							{if $current_user.access_all_leads neq 'YES'} disabled="disabled" {/if}
							{if $current_user.user_type eq 'BP'} onChange="Uncheck('save_setting_access_all_leads')" {/if}
							>
								<option value="all">All</option>
								{foreach from=$business_partners item=bp}
									{ if $business_developer_id eq $bp.agent_no }
										<option value="{$bp.agent_no}" selected="selected">{$bp.fname|capitalize} {$bp.lname|capitalize}</option>
									{ else }
										<option value="{$bp.agent_no}" >{$bp.fname|capitalize} {$bp.lname|capitalize}</option>
									{ /if }
								{/foreach}
							</select>
						</td>
						<td style="width: 90px;">
							{if $current_user.user_type eq 'BP'}
								{if $current_user.access_all_leads eq 'YES'}
									{ if $current_user.view_leads_setting }
										<input type='checkbox' checked name='save_setting_access_all_leads' value='business_developer_id' onclick="SaveSetting('save_setting_access_all_leads')"  /> <small id='save_setting_access_all_leads_txt' style='vertical-align:super;' >remove setting</small>
									{else}	
										<input type='checkbox' name='save_setting_access_all_leads' value='business_developer_id' onclick="SaveSetting('save_setting_access_all_leads')"  /> <small id='save_setting_access_all_leads_txt' style='vertical-align:super;' >save setting</small>
									{/if}
								{/if}
							{/if}
						</td>
					</tr>
					<tr>
						<td>Hiring Coordinator:</td>
						<td>
							<select name="hiring_coordinator_id" id="hiring_coordinator_id" style="width:130px;">
								<option value="">-</option>
								{foreach from=$hiring_coordinators item=h name=h}
								   <option value="{$h.admin_id}" {if $h.admin_id eq $hiring_coordinator_id} selected="selected" {/if} >{$h.admin_fname} {$h.admin_lname}</option>
								{/foreach}
							</select>
						</td>
						<td>Pin:</td>
						<td colspan="2">
							<select name="pin" id="pin" style="width:130px;">
							   <option value="">-</option>
							   {foreach from=$pin_array item=p name=p}
								   <option value="{$p}" { if $p eq $pin } selected="selected" {/if}>{$p}</option>
							   {/foreach}
							</select>
						</td>
					</tr>
					{if $lead_status eq 'Client'}
						<tr>
							<td>CSRO:</td>
							<td colspan="4">
								<select name="csro_id" id="csro_id" style="width:130px;">
									<option value="">-</option>
									{foreach from=$csro_officers item=h name=h}
									   <option value="{$h.admin_id}" {if $h.admin_id eq $csro_id} selected="selected" {/if} >{$h.admin_fname} {$h.admin_lname}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					{/if}
					<tr>
						<td>Date Updated:</td>
						<td>
							<table width="100%">
								<tbody>
									<tr>
										<td>From:</td>
										<td><input type="text" name="date_updated_start" id="date_updated_start"  style=" width:72px;" value="{$date_updated_start}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png" id="bd1" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" /></td>
									</tr>
									<tr>
										<td>To:</td>
										<td><input type="text" name="date_updated_end" id="date_updated_end"  style=" width:72px;" value="{$date_updated_end}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" /></td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>Register Date:</td>
						<td>
							<table width="100%">
								<tbody>
									<tr>
										<td>From:</td>
										<td><input type="text" name="register_date_start" id="register_date_start"  style=" width:72px;" value="{$register_date_start}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png" id="bd3" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" /></td>
									</tr>
									<tr>
										<td>To:</td>
										<td><input type="text" name="register_date_end" id="register_date_end"  style=" width:72px;" value="{$register_date_end}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png" id="bd4" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" /></td>
									</tr>
								</tbody>
							</table>
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:center;">
							<input type="submit" name="search" id="search" value="Search" class="button" style="width: 100px;" />
							<input type="button" name="reset" id="reset" value="Reset" class="button" style="width: 100px;" onclick="window.location.href='/portal/leads_list/index.php?lead_status=All';" />
						</td>
					</tr>
				</tbody>
			</table>

		</fieldset>
		<!-- END FORM FILTER FIELDSET -->

	</div>
	<!-- END FORM FILTER CONTAINER -->

	<!-- START FORM FILTER CONTAINER -->
	<div class="form_filters" style="margin-top:20px;">

		<!-- START FORM FILTER FIELDSET -->
		<fieldset style="padding: 15px;">

			<legend>ACTION BUTTONS</legend>

			<p>

				<!-- NEW LEAD -->
				<input type="button" value="Add New Lead" class="button" onClick="self.location='../AddUpdateLeads.php'" />

				{foreach from=$transfer_status item=status}
					{if $lead_status neq $status}
						<!-- MOVE -->
						<input type="submit" name="move" id="move" value="Move to {$status|capitalize}" disabled="disabled" onclick="Move('{$status}')" class="button" />
					{/if}
				{/foreach}

				{if $enable_disable_btn eq True}
					<!-- REMOVE -->
					<input type="submit" name="remove" id="remove" disabled="disabled" value="Remove" class="button" >
				{/if}

				<!-- TRANSFER -->
				<input type="button" name="transfer" id="transfer" disabled="disabled" value="Tranfer to" onClick="TransferLeads();"  class="button"> 

				<!-- AGENT -->
				<select name="agent_id" id="agent_id" style="width:200px;" disabled="disabled">
					<option value="">Business Developer</option>
					{$BPOptions}
				</select>

			</p>

		</fieldset>
		<!-- END FORM FILTER FIELDSET -->

	</div>
	<!-- END FORM FILTER CONTAINER -->

	<!-- CLEAR ALL FLOAT LEFT -->
	<br clear="all" />

	<!-- TITLE-->
	<h2 align="center">
		{if $lead_status eq 'Client'}
			{if $filter}
				{$filter} clients
			{else}
				All Clients
			{/if}
		{else}
			{$lead_status}
		{/if}
	</h2>

	<!-- SEARCH RESULT -->
	<p align="center">

		There are

		<strong>{$today_numrows}</strong>

		<span style="text-transform:capitalize;">{$lead_status|lower}</span>

		today {$date_today|date_format:"%B %e, %Y"}

		{if $bd_name and $hc_name eq '' and $csro_name eq ''}
			under {$bd_name}
		{/if}

		{if $bd_name and $hc_name eq '' and $csro_name}
			under {$bd_name} and {$csro_name}
		{/if}

		{if $hc_name and $bd_name eq '' and $csro_name eq ''}
			under {$hc_name}
		{/if}

		{if $hc_name and $bd_name eq '' and $csro_name }
			under {$hc_name} and {$csro_name}
		{/if}

		{if $bd_name and $hc_name and $csro_name eq ''}
			under {$bd_name} and {$hc_name}
		{/if}

		{if $csro_name and $bd_name eq '' and $hc_name eq ''}
			under {$csro_name}
		{/if}

		{if $bd_name and $hc_name and $csro_name}
			under {$bd_name}  and {$hc_name} and {$csro_name}
		{/if}

		{if $keyword }
			with <em>{$keyword}</em> on their profile.
		{/if}

	</p>

	<br clear="all" />

</div>
<!-- USER SEARCH FORM CONTAINER END-->
