{*
2011-12-01  Normaneil Macutay <normanm@remotestaff.com.au>

*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
 "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrator- Subcontractors Contract Management</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="admin_subcon/admin_subcon.css">


<script type="text/javascript" src="js/jscal2.js"></script> 
<script type="text/javascript" src="js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="css/gold/gold.css" />

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' src='admin_subcon/admin_subcon.js'></script>


</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name='form' method='post' >
<input type="hidden" name="min_date" id="min_date" value="{$min_date}" >
<!-- HEADER -->
{php} include 'header.php'{/php}
{php} include 'admin_header_menu.php'{/php}

<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr>
<td valign="top" style="background:#EEEEEE;">
{php} include 'admin_subcon/contract_management_menu.php' {/php}	

<h2 class="h2" align="center">SUBCONTRACTORS CONTRACT MANAGEMENT</h2>
<div id="staff_contract_list_holder" style="padding:10px;"><div id="staff_contract_list"></div></div>
<div style="background:#EEEEEE; padding:10px;">
<div id="staff_contract_handler">
<div class="drag-handle" ><span id="drag_handle">Staff Contract</span><span id="close_button"><img src="./images/close.gif"></span></div>
<div id="applicant_info">Select staff name to show contract details...</div>
</div>
</div>
</td>
</tr>
</table>
{literal}
<script>
    showAllStaffContractList();
    //var items = getElementsByTagAndClassName('li', 'show_contract_details');
    //for (var item in items){
    //    connect(items[item], 'onclick', showStaffContractDetails);
    //}
</script>
{/literal}
{php} include 'footer.php'{/php}
</form>
</body>
</html>