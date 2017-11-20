{*
2011-03-08  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Portal Administrator Home</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">

<script type="text/javascript" src="js/jscal2.js"></script> 
<script type="text/javascript" src="js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="css/gold/gold.css" />

<link rel=stylesheet type=text/css href="css/overlay.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script language=javascript src="./js/MochiKit.js"></script>

{foreach from=$javascripts item=javascript}
    <script src="{$javascript}" type="text/javascript"></script>
{/foreach}

{foreach from=$stylesheets item=stylesheet}
    <link rel="stylesheet" type="text/css" href="{$stylesheet}" />
{/foreach}



</head>
<body style="margin-top:0; margin-left:0" onLoad="placeIt()">
<div id="overlay">
    <div id="invoice_form" style="width:500px;"></div>
</div>	
	
<FORM NAME="parentForm" method="post" onSubmit="return ValidateConversion()">
{php}include("header.php"){/php}
{php}include("admin_header_menu.php"){/php}

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<tr><td width="18%" valign="top" style="border-right: #006699 2px solid;">
{php}include("adminleftnav.php"){/php}
</td>
<td valign="top">
<div align="right">Welcome #{$admin.admin_id} {$admin.admin_fname} {$admin.admin_lname}</div>

<h2 align="center">Prepaid Clients Conversion Page</h2>
<p align="center" ><span style="font-weight:bold; background:#FFFF99; padding:5px;">This is where you convert the Client Contract from Regular Invoicing to Prepaid.</span></p>

<table id="prepaid" width="90%" align="center" cellpadding="0" cellspacing="0">
<tr><td align="right"><input type="submit" name="convert" value="convert to prepaid"></td><td>&nbsp;</td></tr>
<tr>
<td width="50%" valign="top">
<fieldset>
<legend>Active Clients</legend>
<div class="client_list" >
<ol>
{ foreach from=$active_clients item=client name=client }
    <li><input type="radio"  name="client"  class="kliyente" id="c_{ $client.leads_id }" value="{ $client.leads_id }" >
    <span id="client_{ $client.leads_id }" leads_id="{ $client.leads_id }" class="client" leads_name="#{ $client.leads_id } { $client.fname|capitalize } { $client.lname|capitalize }">{ $client.fname|lower } { $client.lname|lower } - #{ $client.leads_id } ( { $client.no_of_staff } ) </span>
	     <div id="client_staff_{ $client.leads_id }" style="display:none" >
		     
	          <ol>
	            { foreach from=$client.staffs item=staff name=staff }
		            <li>{ $staff.fname|lower } { $staff.lname|lower }</li>
				{ foreachelse }
				no staff	
		        { /foreach }
	          </ol>
	     </div>
	</li>
{ /foreach }
</ol>
</div>
</fieldset>
<!--
<fieldset>
<legend>Non Active Clients</legend>
<div class="client_list" style=" height:300px !important;">
<ol>
{ foreach from=$non_active_clients item=client name=client }
    <li><input type="radio" name="client" value="{ $client.leads_id }">
    <span id="client_{ $client.leads_id }" leads_id="{ $client.leads_id }" class="client" leads_name="#{ $client.leads_id } { $client.fname|capitalize } { $client.lname|capitalize }">( { $client.no_of_staff } ) #{ $client.leads_id } { $client.fname|lower } { $client.lname|lower }</span>
	     <div id="client_staff_{ $client.leads_id }" style="display:none" >
		     
	          <ol>
	            { foreach from=$client.staffs item=staff name=staff }
		            <li>{ $staff.fname|lower } { $staff.lname|lower }</li>
				{ foreachelse }
				no staff	
		        { /foreach }
	          </ol>
	     </div>
	</li>
{ /foreach }
</ol>
</div>
</fieldset>
-->

</td>
<td width="50%" valign="top">
<fieldset>
<legend>Prepaid Clients</legend>
<div class="client_list">
<ol>
{ foreach from=$prepaid_clients item=client name=client }
    <li>
    <span id="client_{ $client.leads_id }" leads_id="{ $client.leads_id }" class="client" leads_name="#{ $client.leads_id } { $client.fname|capitalize } { $client.lname|capitalize }">{ $client.fname|lower } { $client.lname|lower } - #{ $client.leads_id } ( { $client.no_of_staff } ) </span>
	     <div id="client_staff_{ $client.leads_id }" style="display:none" >
		     
	          <ol>
	            { foreach from=$client.staffs item=staff name=staff }
		            <li>{ $staff.fname|lower } { $staff.lname|lower }</li>
			    { foreachelse }
				No Active staff yet
		        { /foreach }
	          </ol>
	     </div>
	</li>
{ /foreach }
</ol>
</div>
</fieldset>

</td>
</tr>
<tr><td align="right"><input type="submit" name="convert" value="convert to prepaid"></td><td>&nbsp;</td></tr>
</table>















</td>
</tr>
</table>

{literal}
<script type='text/javascript' src='js/overlay.js'></script>
<script>
    var items = getElementsByTagAndClassName('span', 'client');
    for (var item in items){
        connect(items[item], 'onclick', ShowClientStaff);
    }
	
	var items = getElementsByTagAndClassName('input', 'kliyente');
    for (var item in items){
        connect(items[item], 'onclick', ShowClientStaffListForm);
    }
</script>
{/literal}

{php}include("footer.php"){/php}
</form>
</body>
</html>
