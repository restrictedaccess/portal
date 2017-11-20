<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';



if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$current_month=date("m");
$current_month_name=date("F");
$ATZ = $AusDate." ".$AusTime;
$date=date('jS \of F Y \[l\]');


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
	$name = $row['admin_fname']." ".$row['admin_lname'];
	
}

//
$payments_invoice_id = $_REQUEST['payments_invoice_id'];
if($payments_invoice_id =="")
{
	echo "Payments Invoice Number is Missing";
	die;
}
//echo $payments_invoice_id;	
$queryPaymentsInvoice = "SELECT * FROM payments_invoice p WHERE id =$payments_invoice_id;";
$results  = mysql_query($queryPaymentsInvoice);
$rows = mysql_fetch_array($results);
/*
id, users, users_by_type, description, payment_details, drafted_by, drafted_by_type, status, created_date, peso_total_amount_subcon_payments, dollar_total_amount_subcon_payments, payments_month, dollar_total_amount_BPAFF
*/
$description = $rows['description'];
$status = $rows['status'];
$peso_total_amount_subcon_payments =$rows['peso_total_amount_subcon_payments'];
$dollar_total_amount_subcon_payments = $rows['dollar_total_amount_subcon_payments'];
//$dollar_total_amount_BPAFF = $rows['dollar_total_amount_BPAFF'];
?>
<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="css/payments.css">
<script type="text/javascript" language="javascript" src="addExpenses.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function highlight(obj , clicked) {
 
   obj.style.backgroundColor='yellow';
   //obj.style.cursor='pointer';
}
function unhighlight(obj , clicked) {
   obj.style.backgroundColor='';
   //obj.style.cursor='default';
}

//-->
</script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="admin_payments.php">
<!-- HEADER -->
<? include 'header.php';?>
<? if ($admin_status=="FULL-CONTROL") {?>
<ul class="glossymenu">
 <li class="current"><a href="adminHome.php"><b>Home</b></a></li>
  <li><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>
<? } else { 
echo "<ul class='glossymenu'>
 <li class='current'><a href='adminHome.php'><b>Home</b></a></li>
  <li><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
  <li><a href='adminclient_listings.php'><b>Clients</b></a></li>
  <li><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>
 ";
}

?>
<table width="103%">
<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">

<? include 'adminleftnav.php';?>
</td>
<td valign="top">
<!-- Payemts Here -->
<div class="payment_box">
<div style="margin:5px; padding:5px; font-weight:bold; background:#FFFFFF ; font-size:16px; border:#000000 dashed 1px; width:480px;"><?=$description;?> </div>
	<div class="box_for_subcon">
		<div class="title_header"><div>Sub-Contractors Section</div>
		<div style="color:#999999; padding:2px;">Data is based from Subcontractors Invoices Paid Section</div>
		</div>
			<div class="headers">
				<div class="subcon_item_hdr"><b>#</b></div>
				<div class="subcon_name_hdr"><b>Name</b></div>
				<div class="subcon_peso_hdr"><b>Pesos</b></div>
				<div class="subcon_dollar_hdr"><b>Dollar</b></div>
				<div class="subcon_client_price_hdr"><b>Client Payment Status</b></div>
			</div>
		<div class="scroll">
<div id="subcon_section">
<?
// Subcontractors 
$query ="SELECT id, description,peso_amount,dollar_amount,client_amount,profit_amount,client_pay_status,DATE_FORMAT(paid_date,'%D %b %Y') FROM payments_invoice_details WHERE payments_invoice_id = $payments_invoice_id AND section = 'SUBCON';";
//echo $query;
$result =mysql_query($query);
$counter=0;
while(list($payment_invoice_details_id,$name,$amount,$converted_amount,$client_amount,$profit_amount,$client_pay_status,$paid_date)=mysql_fetch_array($result))
{	$counter++;
	
	if($client_pay_status==""){
		$payment_details ="&nbsp;";
		$button_name = "paid";
		$pay ="";
	}else{
		$payment_details =" <b>Profit :</b> $ ".number_format($profit_amount,2,'.',','). "<br><b> Paid Date : </b>". $paid_date ." &nbsp; ".$client_pay_status;
		$button_name = "edit";
		$pay ="Paid.";
	}
	$total_amount =$total_amount + $amount;
	$total_amount_dollar =$total_amount_dollar + $converted_amount;
	$total_profit = $total_profit + $profit_amount;
	
?>
		<div class="list_wrapper" onClick="highlight(this,'true');" onMouseOver="highlight(this,'false');" onMouseOut="unhighlight(this,'false');">
				<div class="subcon_item_txt"><?=$counter;?></div>
				<div class="subcon_name_txt"><?=$name;?></div>
				<div class="subcon_peso_txt">P <?=number_format($amount,2,'.',',');?></div>
				<div class="subcon_dollar_txt">$ <?=number_format($converted_amount,2,'.',',');?></div>
				<div class="subcon_client_price_txt"><span style="float:left; padding-left:5px;"><?=$pay;?></span>
				<span style="float:right; padding-right:5px;">
				$ <?=number_format($client_amount,2,'.',',');?> <input type='button' class="show_hide_button" value='<?=$button_name;?>' onclick ="show_hide('subcon_section_client_aount_form<?=$counter;?>') ; "/>
				</span>
				<div style="clear:both;"></div>
				<div class="subcon_section_client_aount_form" id="subcon_section_client_aount_form<?=$counter;?>" style="">
				<?=$counter;?><? //=$payment_invoice_details_id." | ".$payments_invoice_id;?>
				<p style="padding:2px; margin-top:3px; margin-bottom:3px; margin-left:20px;"><b>Amount Paid by the Client</b></p>
				<p style="padding:2px; margin-top:5px; margin-bottom:5px; margin-left:20px;"><label style="float:left; display:block; width:70px;">Amount :</label><input type="text" name="client_paid_amount<?=$counter;?>" id="client_paid_amount<?=$counter;?>" value="<?=number_format($client_amount,2,'.',',');?>"?></p>
				<p style="padding:2px; margin-top:3px; margin-bottom:3px; margin-left:20px;">
				<input type="button" name="add_new_expenses" id="add_new_expenses" onClick="javascript: addAmount(document.form.client_paid_amount<?=$counter;?>.value,<?=$payment_invoice_details_id;?>);" value="add"/>&nbsp;
	<input type="button" name="cancel" id="cancel" onClick="javascript: show_hide('subcon_section_client_aount_form<?=$counter;?>');" value="cancel"/></p>
				</div>
				</div>
				<div class="subcon_section_client_payment_details" style=""><?=$payment_details;?></div>
				</div>
				
<?
}
?>	
</div>		
		</div> 
		<div class="total_amount_wrapper">
			<div class="subcon_total_pesos_txt">Total :</div>
			<div class="subcon_total_amount_peso">P <?=number_format($peso_total_amount_subcon_payments,2,'.',',')?></div>
			<div class="subcon_total_amount_dollar"><b>$ <?=number_format($dollar_total_amount_subcon_payments,2,'.',',')?></b></div>
			<div class="subcon_section_total_profit" style=" color:#0000FF; font-weight:bold;" id="total_profit_div">
				<span style="float:left;">Total Profit from Client Payments made for Remote Staff : </span>
				<span style="float:right;">$ <?=number_format($total_profit,2,'.',',');?></span>
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>	
	<!-- BP AFF section-->
	<div class="box" style="margin-top:10px;">
		<div class="title_header"><div>Business Partner | Affiliates Section</div>
		<div style="color:#999999; padding:2px; height:30px;">Data is based from Business Partner & Affiliates Invoices Paid Section</div>
	</div>
	<div class="headers">
				<div class="item_no"><b>#</b></div>
				<div class="name"><b>Name</b></div>
				<div class="amount_peso"><b>&nbsp;</b></div>
				<div class="amount_dollar"><b>Dollar</b></div>
			</div>
		<div class="scroll">
<?
// BP/Affiliates
$query2="SELECT description,dollar_amount_BPAFF,gst_percent,dollar_total_amount_BPAFF FROM payments_invoice_details p WHERE payments_invoice_id = $payments_invoice_id AND section = 'AGENT'; ";
//echo $query2;
$result2 =mysql_query($query2);
$counter2=0;
while(list($description,$dollar_amount_BPAFF,$gst_percent,$dollar_total_amount_BPAFF)=mysql_fetch_array($result2))
{	
	//$amount_with_percent = $amount_with_percent + ($agent_amount + $agent_percent);
	$counter2++;
?>	
		<div class="list_wrapper" onMouseOver="highlight(this);" onMouseOut="unhighlight(this);">
				<div class="item_no"><?=$counter2;?></div>
				<div class="name"><?=$description;?></div>
				<div class="amount_peso"><small style="font: 10px tahoma;">$ <?=number_format($dollar_amount_BPAFF,2,'.',',')." + GST  $".number_format($gst_percent,2,'.',',');?></small></div>
				<div class="amount_dollar">$ <?=number_format($dollar_total_amount_BPAFF,2,'.',',');?></div>
			</div>
<?	
}

?>
		</div> 
		<div class="total_amount_wrapper">
			<div class="total_pesos_txt">Total :</div>
			<div class="sub_total_amount_peso">&nbsp;</div>
			<div class="sub_total_amount_dollar"><b>$ <?=number_format($rows['dollar_total_amount_BPAFF'],2,'.',',')?></b></div>
		</div>
	</div>
	<!-- Ends here BP AFF--->
	<!-- Other Expenses Section-->
	<div class="box" style="margin-top:10px;">
		<div class="title_header"><div>Other Expenses Section</div>
			<div style="color:#999999; padding:2px; height:30px;"><input type="button" value="Add" id="add_item_other_expenses_section" name="add_item_other_expenses_section" onClick="javascript: show_hide('add_form')"></div>
		<div id="add_form">
			<input type='hidden' value='<?=$payments_invoice_id;?>' name='payments_invoice_id' id='payments_invoice_id'/>
			<p><label>Description :</label><input type="text" name="expenses_description" id="expenses_description" value="" class="text"></p>
			<p><label>Amount :</label><input type="text" name="expenses_price" id="expenses_price" value="" class="text"></p>
			<p><input type="button" name="add_new_expenses" id="add_new_expenses" onClick="javascript: show_hide('add_form');addExpenses();" value="add"/>&nbsp;
			<input type="button" name="cancel" id="cancel" onClick="javascript: show_hide('add_form');" value="cancel"/>
			</p>
		</div>
</div>
<div class="headers">
				<div class="item_no"><b>#</b></div>
				<div class="name_desc"><b>Description</b></div>
				<div class="amount_dollar"><b>Amount</b></div>
			</div>
		<div class="scroll">
		<div id="other_expenses">
		<?
		$queryAll="SELECT id, description, dollar_amount FROM payments_invoice_details p WHERE payments_invoice_id = $payments_invoice_id AND section = 'EXPENSES';";
		$resultAll = mysql_query($queryAll);
		$counter =0;
		while(list($id, $description, $dollar_amount)=mysql_fetch_array($resultAll))
		{
			$counter++;
			$total_expenses = $total_expenses + $dollar_amount;	
		?>
		<div class="list_wrapper" onMouseOver="highlight(this);" onMouseOut="unhighlight(this);">
				<div class="item_no"><?=$counter;?></div>
				<div class="name_desc"><?=$description;?></div>
				<div class="amount_dollar">$ <?=number_format($dollar_amount,2,'.',',');?> <input type='button' value='del' onclick ='javascript: deleteExpenses(<?=$id;?>);'/></div>
			</div>
		<? }?>	
		</div> 
		</div>
		<div class="total_amount_wrapper">
			<div class="total_desc">Total :</div>
			<div class="sub_total_amount_dollar" id="total_expenses_div"><b>$ <?=number_format($total_expenses,2,'.',',');?></b></div>
		</div>
	</div>
	<!--Ends here other expenses --->
	
	<!--Total Sheets-->
	<div class="box" style="margin-top:20px; margin-bottom:10px;">
		<div class="title_header"><div>Total</div>
		  <div style="color:#999999; padding:2px; height:23px;"></div>
		</div>
			<div class="headers">
				<div class="item_no"><b>#</b></div>
				<div class="name_desc"><b>Section</b></div>
				<div class="amount_dollar"><b>Amount</b></div>
			</div>
		<div class="scroll">
			<div id="total_section">
				<div class="list_wrapper" onMouseOver="highlight(this);" onMouseOut="unhighlight(this);">
					<div class="item_no">1</div>
					<div class="name_desc">Subcon Section</div>
					<div class="amount_dollar">$ <?=number_format($dollar_total_amount_subcon_payments,2,'.',',')?></div>
				</div>
				<div class="list_wrapper" onMouseOver="highlight(this);" onMouseOut="unhighlight(this);">
					<div class="item_no">2</div>
					<div class="name_desc">BP | AFF Section</div>
					<div class="amount_dollar">$ <?=number_format($rows['dollar_total_amount_BPAFF'],2,'.',',')?></div>
				</div>
				<div class="list_wrapper" onMouseOver="highlight(this);" onMouseOut="unhighlight(this);">
					<div class="item_no">3</div>
					<div class="name_desc">Others Section</div>
					<div class="amount_dollar" id="expenses_div">$ <?=number_format($total_expenses,2,'.',',');?></div>
				</div>
				<div class="list_wrapper" style="margin-top:20px; border:#000000 solid 1px; background:#FFFFD2;"  >
					<div class="item_no"></div>
					<div class="name_desc"><b>Total Payments</b></div>
					<div class="amount_dollar" id="total_amount_div" style="font-weight:bolder;">$ 
					<? 
						$total_amount=$dollar_total_amount_subcon_payments + $rows['dollar_total_amount_BPAFF'] + $total_expenses ;
						echo number_format($total_amount,2,'.',',');
					?></div>
					<input type="hidden" value="<?=$total_amount;?>" name="total_amount_txt" id="total_amount_txt" />
				</div>
			</div>
		</div>
	</div>
	<!-- -->
	<div style="clear:both;"></div>
</div>
</td>
</tr>
</table>

<? include 'footer.php';?>
</form>	
</body>
</html>

