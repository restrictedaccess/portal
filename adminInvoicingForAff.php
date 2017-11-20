<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

date_default_timezone_set("Asia/Manila");

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

//$AusTime = date("H:i:s"); 
//$AusDate = date("Y")."-".date("m")."-".date("d");
//$AustodayDate = date ("jS \of F Y");
//$ATZ = $AusDate." ".$AusTime;
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$date = new DateTime();
$start_date_ref = $date->format('Y-m-01');
$end_date_ref = $date->format('Y-m-t');
$current_date = $date->format('Y-m-d');
$current_month = $date->format('F');

$monthArray=array("","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($month == $monthArray[$i])
  {
 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  }
  else
  {
$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  }
}

//$yearoptions
$yearArray=array("2008","2009","2010");
for ($i = 0; $i < count($yearArray); $i++)
{
  if($year == $yearArray[$i])
  {
 $yearoptions .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
  }
  else
  {
$yearoptions .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
  }
}



				
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Invoicing for Affiliates</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="invoice/adminInvoicingForAff.js"></script>
<link rel=stylesheet type=text/css href="invoice/admin_invoice.css">

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
  <td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Invoicing for Affiliates</b></font></td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td>
<td colspan="2"></td></tr>
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
