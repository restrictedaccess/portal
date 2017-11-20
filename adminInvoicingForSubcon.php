<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';
date_default_timezone_set("Asia/Manila");

$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));
mysql_query('SET time_zone='.$timeZone);

//$AusTime = date("H:i:s"); 
//$AusDate = date("Y")."-".date("m")."-".date("d");
//$AustodayDate = date ("jS \of F Y");
//$ATZ = $AusDate." ".$AusTime;
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
}

$summary=$_REQUEST['summary'];
$action=$_REQUEST['action'];

$month=$_REQUEST['month'];
$yesterday=$_REQUEST['yesterday'];
$this_day=$_REQUEST['this_day'];
$tomorrow=$_REQUEST['tomorrow'];
$day=$_REQUEST['day'];
$event_date =$_REQUEST['event_date'];

$date = new DateTime();
$start_date_ref = $date->format('Y-m-01');
$end_date_ref = $date->format('Y-m-t');
$current_date = $date->format('Y-m-d');
$current_month = $date->format('F');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Invoicing for Subcontractors</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<style type="text/css">
<!--
div.scroll {
	height: 400px;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
-->
</style>
	
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="invoice/adminInvoicingForSubcon.js"></script>
<link rel=stylesheet type=text/css href="invoice/invoice.css">

<!-- Added by Normaneil 10/24/2008 -->
<script type="text/javascript">
<!--
function convertSalary(){

	var input_number = document.getElementById("input_currency").value;
	var php_total_amount = document.getElementById("total_amount").value;
	var aud_total_amount =(parseFloat(php_total_amount)) / (parseFloat(input_number));
	//alert (php_total_amount);
	document.getElementById("show_conversion").innerHTML ="$ "+Math.round((aud_total_amount)*100)/100 ;
	document.getElementById("converted_amount").value =Math.round((aud_total_amount)*100)/100 ;
	//alert(document.getElementById("total_amount").value);
	
}
-->
</script>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
  <td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Invoicing for Subcontractors</b></font></td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td><td colspan="2">&nbsp;</td></tr>
<tr><td width="18%" height="135" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width="82%" valign="top" align="left">
<div id="invoice_pane"></div>

</td>
</tr>
</table>
</td></tr>
</table>
<? include 'footer.php';?>
</body>
<div id="admin_id" value="<?php echo $admin_id?>"></div>
<div id="start_date_ref" value="<?php echo $start_date_ref?>"></div>
<div id="end_date_ref" value="<?php echo $end_date_ref?>"></div>
<div id="current_date_ref" value="<?php echo $current_date?>"></div>
<div id="current_month" value="<?php echo $current_month?>"></div>
</html>
