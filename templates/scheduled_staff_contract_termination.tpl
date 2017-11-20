{*
2010-10-07  Normaneil Macutay <normanm@remotestaff.com.au>

*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
 "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrator-Subcontractors Contract Management</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="admin_subcon/admin_subcon.css">

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' language='JavaScript' src='js/functions.js'></script>
<script type='text/javascript' src='admin_subcon/admin_subcon.js'></script>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" enctype="multipart/form-data" action="{$script_filename}" accept-charset = "utf-8">
<!-- HEADER -->
{php} include 'header.php'{/php}
{if $admin_status neq 'HR'}
	{php} include 'admin_header_menu.php'{/php}
{else}
	{php} include 'recruiter_top_menu.php'{/php}
{/if}	
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr>

<td width="100%" valign="top" style='border: #006699 2px solid; background:#F3F3F3; padding:10px;'>
<h2 class="h2" align="center">SCHEDULED STAFF CONTRACT TERMINATION LIST</h2>
{php} include 'admin_staff_contract_mangement_menu.php'{/php}	
<div id="main" style="background:#CCCCCC;">


<div id="search_form_subconlist">

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
    <br clear="all">
</div>
<input type="submit"  VALUE="Search" name="search" >
<input type="submit" name="export" value="Export" >
    

<!-- start -->
<div id="subcon_listings">

<div id="result_options" style="display:block;">
<div align="center">{if $num_reccords eq 0} No records found {else} {$num_reccords} record<small>/s</small> found {/if}</div>
<table width="100%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor = '#333333'>
    <td width="4%"><b style='color:white;'>#</b></td>
    <td width="34%"><b style='color:white;'>STAFF DETAILS</b></td>
    <td width="62%"><b style='color:white;'>CLIENT NAME</b></td>
  </tr>
  {$resultOptions}
</table>
</div>
</div>
<!-- end -->	

</div></td></tr>
</table>
{php} include 'footer.php'{/php}
<input type="hidden" name="_submit_check" value="1"/>
</form>
</body>
</html>

