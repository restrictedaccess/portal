{*
2012-01-20 Normaneil E. Macutay
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff {$leads_info.fname|escape} {$leads_info.lname|escape} Leads Information Sheet</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="menu.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script language=javascript src="./js/functions.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>

<script type="text/javascript" src="./leads_information/media/js/tabber.js"></script>
</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_invoice_setting.php?id={$leads_id}&lead_status={$lead_status}&page_type={$page_type}#A" accept-charset = "utf-8">
<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />
<input type="hidden" name="cc_emails" id="cc_emails"  />
<input type="hidden" name="asl_cc_emails" id="asl_cc_emails"  />
{if $page_type eq 'TRUE'}
	{php}include("header.php"){/php}
	
	{if $agent_section eq True}
		{php}include("BP_header.php"){/php}
	{/if}
	
	{if $admin_section eq True}
		{php}include("admin_header_menu.php"){/php}
	{/if}
{/if}

<h1>{$leads_info.fname|escape} {$leads_info.lname|escape} <span class="leads_id">#{$leads_id}</span></h1>

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
{if $admin_status neq 'HR'}
	{if $page_type eq 'TRUE'}
		<td width="173" valign="top" >
		
			{if $agent_section eq True}
				{php}include("agentleftnav.php"){/php}
			{/if}
			
			{if $admin_section eq True}
				{php}include("adminleftnav.php"){/php}
			{/if}
		
		</td>
	{/if}
{/if}
<td valign="top">
{php}include("leads_information/top-tab.php"){/php}
<div align="center" style="font-weight:bold; padding:10px; font-size:14px; margin-top:20px;">Invoice Address  Management Page</div>
<div id="invoice_setting_add_email">
<p><strong>Client Invoices will be address to</strong> : <small style="color:#999999;">( name to be appeared in invoice ) </small></p>
<ul>
<li><input type="radio" name="invoice_address_to" class="invoice_address_to" value="main_acct_holder" {if $invoice_setting.address_to eq 'main_acct_holder'} checked="checked" {/if}  >Main Account Holder : <span id="main_acct_holder">{$leads_info.fname} {$leads_info.lname}</span> </li>
<li><input type="radio" name="invoice_address_to" class="invoice_address_to" value="supervisor_staff_name" {if $invoice_setting.address_to eq 'supervisor_staff_name'} checked="checked" {/if}>Person Directly Working with Staff : <input type="text" name="supervisor_staff_name" id="supervisor_staff_name"  value="{$leads_info.supervisor_staff_name}"> </li>
<li><input type="radio" name="invoice_address_to" class="invoice_address_to" value="secondary_contact_person" {if $invoice_setting.address_to eq 'secondary_contact_person'} checked="checked" {/if}>Secondary Contact Person : <input type="text" name="secondary_contact_person" id="secondary_contact_person" value="{$leads_info.secondary_contact_person}">  </li>
<li><input type="radio" name="invoice_address_to" class="invoice_address_to" value="accounts">Accounts Contact Details : 
    <ol>
	    <li><input type="radio" name="accounts_name" value="acct_dept_name1" class="accounts" {if $invoice_setting.address_to eq 'acct_dept_name1'} checked="checked" {/if} >Accounts Department Staff Name 1 : <input type="text" name="acct_dept_name1" id="acct_dept_name1" value="{$leads_info.acct_dept_name1}" ></li>
		<li><input type="radio" name="accounts_name" value="acct_dept_name2" class="accounts" {if $invoice_setting.address_to eq 'acct_dept_name2'} checked="checked" {/if}>Accounts Department Staff Name 2 : <input type="text" name="acct_dept_name2" id="acct_dept_name2" value="{$leads_info.acct_dept_name2}" ></li>
	</ol>
</li>
</ul>

<hr />

<p><strong>Always Email Client Invoice to</strong>  : <small style="color:#999999;">( recipients of client invoice ) </small></p>
<ul>
<li><span class="default_s"><input type="radio" name="default_email" class="default_email" value="email" {if $invoice_setting.default_email_field eq 'email'} checked="checked" {/if} >Default</span>
    <span class="cc_s"><input type="checkbox" name="cc" class="cc" value="email" {if in_array('email' , $cc) eq true} checked="checked" {/if}    />Cc</span> 
    Main Account Holder : <span id="email">{$leads_info.email}</span>
</li>
<li><span class="default_s"><input type="radio" name="default_email" class="default_email" value="supervisor_email" {if $invoice_setting.default_email_field eq 'supervisor_email'} checked="checked" {/if}>Default</span>
    <span class="cc_s"><input type="checkbox" name="cc" class="cc" value="supervisor_email" {if in_array('supervisor_email' , $cc) eq true} checked="checked" {/if}  />Cc</span>
     Person Directly Working with Staff : <input type="text" name="supervisor_email" id="supervisor_email"  value="{$leads_info.supervisor_email}"> </li>
<li><span class="default_s"><input type="radio" name="default_email" class="default_email" value="sec_email" {if $invoice_setting.default_email_field eq 'sec_email'} checked="checked" {/if}>Default</span>
    <span class="cc_s"><input type="checkbox" name="cc" class="cc" value="sec_email" {if in_array('sec_email' , $cc) eq true} checked="checked" {/if}   />Cc</span>
Secondary Contact Person : <input type="text" name="sec_email" id="sec_email" value="{$leads_info.sec_email|escape}">  </li>
<li>Accounts Contact Details : 
    <ol>
	    <li><span class="default_s"><input type="radio" name="default_email" value="acct_dept_email1" class="default_email" {if $invoice_setting.default_email_field eq 'acct_dept_email1'} checked="checked" {/if} >Default</span>
		<span class="cc_s"><input type="checkbox" name="cc" class="cc" value="acct_dept_email1" {if in_array('acct_dept_email1' , $cc) eq true} checked="checked" {/if}   />Cc</span>
		Accounts Department Staff Email 1 : <input type="text" name="acct_dept_email1" id="acct_dept_email1" value="{$leads_info.acct_dept_email1}" ></li>
		<li><span class="default_s"><input type="radio" name="default_email" value="acct_dept_email2" class="default_email" {if $invoice_setting.default_email_field eq 'acct_dept_email2'} checked="checked" {/if}>Default</span>
		<span class="cc_s"><input type="checkbox" name="cc" class="cc" value="acct_dept_email2" {if in_array('acct_dept_email2' , $cc) eq true} checked="checked" {/if}   />Cc</span>
		Accounts Department Staff Email 2 : <input type="text" name="acct_dept_email2" id="acct_dept_email2" value="{$leads_info.acct_dept_email2}" ></li>
	</ol>
</li>
</ul>

<hr />

<p><strong>ASL Recipients</strong></p>

<ul>
<li><span class="default_s"><input type="radio" name="asl_default_email" class="asl_default_email" value="email" {if $invoice_setting.asl_default_email eq 'email'} checked="checked" {/if} >Default</span>
    <span class="cc_s"><input type="checkbox" name="asl_cc" class="asl_cc" value="email" {if in_array('email' , $asl_cc) eq true} checked="checked" {/if}    />Cc</span> 
    Main Account Holder : <span id="email">{$leads_info.email}</span>
</li>
<li><span class="default_s"><input type="radio" name="asl_default_email" class="asl_default_email" value="supervisor_email" {if $invoice_setting.asl_default_email eq 'supervisor_email'} checked="checked" {/if}>Default</span>
    <span class="cc_s"><input type="checkbox" name="asl_cc" class="asl_cc" value="supervisor_email" {if in_array('supervisor_email' , $asl_cc) eq true} checked="checked" {/if}  />Cc</span>
     Person Directly Working with Staff : <input type="text" name="asl_supervisor_email" id="asl_supervisor_email"  value="{$leads_info.supervisor_email}"> </li>
<li><span class="default_s"><input type="radio" name="asl_default_email" class="asl_default_email" value="sec_email" {if $invoice_setting.asl_default_email eq 'sec_email'} checked="checked" {/if}>Default</span>
    <span class="cc_s"><input type="checkbox" name="asl_cc" class="asl_cc" value="sec_email" {if in_array('sec_email' , $asl_cc) eq true} checked="checked" {/if}   />Cc</span>
Secondary Contact Person : <input type="text" name="asl_sec_email" id="asl_sec_email" value="{$leads_info.sec_email|escape}">  </li>
<li>Accounts Contact Details : 
    <ol>
	    <li><span class="default_s"><input type="radio" name="asl_default_email" value="acct_dept_email1" class="asl_default_email" {if $invoice_setting.asl_default_email eq 'acct_dept_email1'} checked="checked" {/if} >Default</span>
		<span class="cc_s"><input type="checkbox" name="asl_cc" class="asl_cc" value="acct_dept_email1" {if in_array('acct_dept_email1' , $asl_cc) eq true} checked="checked" {/if}   />Cc</span>
		Accounts Department Staff Email 1 : <input type="text" name="asl_acct_dept_email1" id="asl_acct_dept_email1" value="{$leads_info.acct_dept_email1}" ></li>
		<li><span class="default_s"><input type="radio" name="asl_default_email" value="acct_dept_email2" class="asl_default_email" {if $invoice_setting.asl_default_email eq 'acct_dept_email2'} checked="checked" {/if}>Default</span>
		<span class="cc_s"><input type="checkbox" name="asl_cc" class="asl_cc" value="acct_dept_email2" {if in_array('acct_dept_email2' , $asl_cc) eq true} checked="checked" {/if}   />Cc</span>
		Accounts Department Staff Email 2 : <input type="text" name="asl_acct_dept_email2" id="asl_acct_dept_email2" value="{$leads_info.acct_dept_email2}" ></li>
	</ol>
</li>
</ul>

</div>


<p><input type="button" id="setup_btn" value="Save" /></p>
</td>
</tr>
</table>
{if $page_type eq 'TRUE'}
	{php}include("footer.php"){/php}
{/if}
{literal}
<script>
var items = getElementsByTagAndClassName('input', 'invoice_address_to', 'invoice_setting_add_email');
for (var item in items){
    connect(items[item] , 'onclick', SelectAddressTo);
}
var items = getElementsByTagAndClassName('input', 'accounts', 'invoice_setting_add_email');
for (var item in items){
    connect(items[item] , 'onclick', SelectAccountsTo);
}

var items = getElementsByTagAndClassName('input', 'default_email', 'invoice_setting_add_email');
for (var item in items){
    connect(items[item] , 'onclick', SelectDefaultEmail);
}

var items = getElementsByTagAndClassName('input', 'cc', 'invoice_setting_add_email');
for (var item in items){
    connect(items[item] , 'onclick', SelectCcEmail);
}

var items = getElementsByTagAndClassName('input', 'asl_default_email', 'invoice_setting_add_email');
for (var item in items){
    connect(items[item] , 'onclick', SelectASLDefaultEmail);
}

var items = getElementsByTagAndClassName('input', 'asl_cc', 'invoice_setting_add_email');
for (var item in items){
    connect(items[item] , 'onclick', SelectASLCcEmail);
}


checkAccountIfSelected();
checkCcIfSelected();
connect('setup_btn', 'onclick', SaveClientSendInvoiceSettingSetup);
</script>
{/literal}
</form>
</body>
</html>
