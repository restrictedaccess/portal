<div style="background:#CCC;">
<div id="search_form_subconlist">
    <div>Search <input type="text" id="keyword" name="keyword" value="{$keyword}" onKeyUp="SetDefault('userid')"  ></div>
    
    <div>{$page_status} Staff <small>({$numrows})</small>: <select  name="userid" id="userid" onchange="SetDefault('keyword')">
	<option value=""></option>
	{$usernameOptions}</select>
    </div>
    
    <div>Client <small>({$active_clients_num})</small> : <select name="leads_id" id="leads_id" class="select_box" style="width:150px;">
    <option value="">-</option>
    {$active_client_Options}
    </select>
    </div>
    
    <div>Hiring Manager : <select name="hm" id="hm" >
    <option value="">-</option>
    {$hm_Options}
    </select>
    </div>
    
    <div>CSRO : <select name="csro" id="csro" >
    <option value="">-</option>
    {$team_Options}
    </select>
    </div>
    
    <div>Recruiter : <select name="recruiter" id="recruiter" >
    <option value="">-</option>
    {$recruiter_Options}
    </select>
    </div> 

    <div>Business Partner : <select name="business_partner_id" id="business_partner_id"  style="width:150px;">
    <option value="">-</option>
    {$bp_Options}
    </select>
    </div>
    
    <div>Work Status : <select name="work_status" id="work_status" class="select_box">
    <option value="">-</option>
    {$work_status_Options}
    </select>
    </div>
    
    <div>Login Status : <select name="login_status" id="login_status" class="select_box">
    {if $login_status_Options}
    <option value="">-</option>
    {$login_status_Options}
    {else}
    <option value="">Not Applicable</option>	
    {/if}
    </select>
    </div>
    
    
    <div>Client Timezones : <select name="client_timezone" id="client_timezone" class="select_box">
    <option value="">-</option>
    {foreach from=$client_timezones item=p name=p}
    <option value="{$p.client_timezone}" {if $p.client_timezone eq $client_timezone} selected="selected" {/if}>{$p.client_timezone}</option>
    {/foreach}
    </select>
    </div>
    
    
    <div>Flexi : <select name="flexi" id="flexi" class="select_box">
    <option value="">-</option>
    {foreach from=$prepaid_Options item=p name=p}
    <option value="{$p}" {if $p eq $flexi} selected="selected" {/if}>{$p}</option>
    {/foreach}
    </select>
    </div>
    
    <div>Contract Duration : <select name="contract_age_option" id="contract_age_option" class="select_box" >
    <option value="">-</option>
    {$AGE_CONTRACTS_OPTIONS}
    </select> 
    </div>
    
    
    
    {if $page_status eq 'INACTIVE'}
    <div>
    Month : <select name="month">
    {foreach from=$months name=m item=m}
    <option value="{$smarty.foreach.m.index}" {if $smarty.foreach.m.index eq $month} selected="selected" {/if}>{$m}</option>
    {/foreach}
    </select> 
    </div>
    
    <div>
    Year :  <select name="year">
    <option value="">-</option>
    {foreach from=$years name=y item=y}
    <option value="{$y}" {if $y eq $year} selected="selected" {/if}>{$y}</option>
    {/foreach}
    </select>
    </div>
    {/if}
    

    <br clear="all">
</div>
<input type="submit"  VALUE="Search" >
<input type="submit" name="export" value="Export" >
</div>