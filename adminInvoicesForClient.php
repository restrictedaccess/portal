<?php
//2010-01-41    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Removed the old generation of client invoice
//2009-09-01    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Added the MochiKit library
//2009-12-11    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Added Mass Generation of Client invoice button

include('conf/zend_smarty_conf.php');


date_default_timezone_set("Asia/Manila");

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
	exit;
}

$current_year =date("Y");


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$date = new DateTime();
$start_date_ref = $date->format('Y-m-01');
$end_date_ref = $date->format('Y-m-t');
$current_date = $date->format('Y-m-d');
$current_month = $date->format('F');
$month = $date->format('m');
$monthArray=array("1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
}

//$yearoptions
$yearArray=array("2008","2009","2010");
for ($i=$current_year; $i>=2008; $i--)
{
	
	if($current_year == $i){
		$yearoptions .= "<option selected value=\"$i\">$i</option>\n";
	}else{
		$yearoptions .= "<option value=\"$i\">$i</option>\n";
	}
}

$sql = $db->select()
    ->from(array('c' => 'clients'), Array('leads_id'))
	->join(array('l' => 'leads'), 'l.id = c.leads_id', Array('fname', 'lname', 'email'))
	->order('fname ASC');
$clients = $db->fetchAll($sql);


				
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Invoicing for Clients</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

<script type="text/javascript" src="js/MochiKit.js"></script>
<script language=javascript src="js/functions.js"></script> 
<script type="text/javascript" src="js/jscal2.js"></script> 
<script type="text/javascript" src="js/lang/en.js"></script> 

<link rel="stylesheet" type="text/css" media="all" href="css/jscal2.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/border-radius.css"  />
<link rel="stylesheet" type="text/css" media="all" href="css/gold/gold.css"  />


<script type="text/javascript" src="invoice/client/media/js/adminInvoicesForClient.js"></script>
<link rel=stylesheet type=text/css href="invoice/client/admin_client_invoice.css">
<link rel=stylesheet type=text/css href="invoice/client/media/css/client_invoice.css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="showAllClientInvoiceList();">
<form name="form" method="post">
<input type="hidden" name="invoice_status" id="invoice_status" >

<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=0 border=0 align=left >
<tr>
  <td colspan=3><h2 align="center">Client Invoicing Management</h2><br>
<br>
</td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td>
<td colspan="2"></td></tr>
<tr><td width="17%" height="135" valign="top" >
<?php include 'adminleftnav.php';?>
</td>
<td width="83%" valign="top" align="left">
<input type="button" name="create_blank_invoice" id="create_blank_invoice"  value="Create Blank Invoice" onClick="ShowBlankFormInvoice();"> &nbsp;<input type="button" name="create_invoice" id="create_invoice"  value="Create from Subcon Timerecords" onClick="window.open('/portal/invoice/GenerateClientInvoice/GenerateClientInvoice.html', 'client_mass_generation_invoice');">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="32%" valign="top" bgcolor="#E9E9E9" >
	
<div class="invoice_items_hdr" style=" color:#FFFFFF; padding:5px;">
	<div style="float:left; display:block; width:50px;"><b>Search</b></div>
	<!--<input type="text" name="keyword" id="keyword" value="<?php //echo $keyword;?>" class="select"  onKeyUp="searchInvoice(this.value)"  > -->
	<div style="clear:both;"></div>
</div>


	<div id="search_box">
	<p><label>Invoice No.</label><input type="text" class="text" id="invoice_no_str" name="invoice_no_str"> <span id="invoice_no_loading"></span></p>
	<p ><label >Select Month </label>
<select name="month" id="month" class="text">
<option value="0">All</option>
<?=$monthoptions;?>
</select></p>
<p ><label>Select Year </label>
<select name="year" id="year" class="text">
<option value="0">All</option>
<?=$yearoptions;?>
</select></p>

<p ><label>Client </label>
<select name="client_id" id="client_id" class="text" style=" width:250px;">
		<option value="0">All Clients</option>
		<?php
		foreach($clients as $client){
		    echo "<option value='".$client['leads_id']."'>".$client['fname']." ".$client['lname']." - ".$client['email']."</option>";
		}
		?>
	</select></p>

<p><label>&nbsp;</label><input type="button" value="Refresh List" name="refresh" onClick="javascript:showAllClientInvoiceList();"  ></p>
<!--
<hr>
<div style="margin:5px;"><b>Sub-Contractor</b></div>
<div style="margin:5px;"><select name="subcon" id="subcon" class="text" onChange="searchInvoiceBySubCon(this.value);">
<option value="0">--</option>
<?=$subconOptions;?>
</select><span id="searching2"></span></div>
-->
</div>

<div id="invoice_list">Loading Invoices...</div>	</td>

	<td width="67%" valign="top">
	<div id="right_panel">
		<div style="margin:2px; padding:3px;">Click the "Create Blank Invoice" to generate a blank invoice.</div>
		<div style="margin:2px; padding:3px;">Click the "Create Invoice From Timerecords" to generate invoice base from Subcontractors Timerecords .</div>
		<div style="margin:2px; padding:3px;">Select an Invoice on the left to view its details.</div>
	</div>	
	</td>
	</tr>
	</table>
</td>
</tr>
</table>
</td></tr>
</table>
<script type="text/javascript">
<!--
connect('invoice_no_str', 'onkeyup', SearchInvoiceNumber);
-->
</script>
<?php include 'footer.php';?>
</form>
</body>
</html>
