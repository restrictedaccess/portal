{*
2010-10-07  Normaneil Macutay <normanm@remotestaff.com.au>

*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
 "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrator- Add Subcontractors</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="admin_subcon/admin_subcon.css">

<script type="text/javascript" src="js/jscal2.js"></script> 
<script type="text/javascript" src="js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="css/gold/gold.css" />

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' language='JavaScript' src='js/functions.js'></script>
<script type='text/javascript' src='admin_subcon/admin_subcon.js'></script>

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" enctype="multipart/form-data" action="adminaddsubcon.php" accept-charset = "utf-8" onSubmit="return checkSearch();">
<input type="hidden" id="mode" name="mode" value="add">
<input type="hidden" name="min_date" id="min_date" value="{$min_date}" >
{php} include 'header.php' {/php}
{if $admin_status neq 'HR'}
	{php} include 'admin_header_menu.php'{/php}
{else}
	{php} include 'recruiter_top_menu.php'{/php}
{/if}
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr>

<td width="100%" valign="top" style='border: #006699 2px solid; background:#F3F3F3; padding:10px'>
<div >
<h2 class="h2" align="center">ADD SUBCONTRACTOR</h2>
{php} include 'admin_staff_contract_mangement_menu.php' {/php}	
<div id="main">
<!-- start -->

<table width="100%" cellpadding="2" cellspacing="0" >
<tr bgcolor="#6699FF">
<!--
<td >
<input type="button" onClick="showOptionsResult('1')" value="Create New" >
<input type="button" onClick="showOptionsResult('2')" value="List of Applicants" >
<input type="button" onClick="showOptionsResult('3')" value="Marked Applicants" >
<input type="button" onClick="showOptionsResult('4')" value="Subcontractors List" >
</td>
-->
<td>
<b>Search</b>
<input type="text" id="keyword" name="keyword" class="select" style="width:400px;" value="{$keyword}"  >
<input type="radio" name="search" id="search" value="userid" {$search_userid} >USERID 
<input type="radio" name="search" id="search" value="keyword" {$search_any}>ANY 

<input type="submit" class="bttn" VALUE="Search" onClick="">
</td>
</tr>
</table>
<div id="result_options" style="display:block;">{$search_result}</div>
<div id="applicant_info"></div>
	
	
<!-- end -->	
</div>	
</div>
</td></tr>
</table>
{php} include 'footer.php' {/php}
<input type="hidden" name="_submit_check" value="1"/>
</form>
{literal}
<script>

LoadApplicantDetails({/literal}{$userid}{literal});

</script>
{/literal}

</body>
</html>