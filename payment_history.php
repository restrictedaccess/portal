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
	
	
$thismonth = date( "m" );
$month = $_REQUEST['month'];
//if($month == $thismonth)
//{
//	$status = "approved";
//}else{
	$status = "posted";
//}
$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("Select Month","January","February","March","April","May","June","July","August","September","October","November","December");
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
?>
<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="css/payments.css">
<script type="text/javascript" language="javascript" src="showPayments.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}
function checkMonth(){
	if(document.form.month.selectedIndex=="0")
	{
		alert("Please select a month");
		return false;
	}
	return true;
}
function gotoPaymentDetails(id){
	alert(id);
	return false;
}

//-->
</script>
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="admin_payments.php">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<table width="100%">
<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">

<? include 'adminleftnav.php';?>
</td>
<td valign="top">
<!-- Payemts Here -->
<div class="payment_box">
<div style="margin:2px; padding:3px;">
Create for the Month of : <select name="month" id="month" class="text">
<?=$monthoptions;?>
</select> <input type="button" value="Create" name="create" onClick="createInvoiceByMonth();" ></div>
	<div class="box" style="margin-bottom:20px;">
		<div class="title_header">
		  <div>Total Payments Summary List Per Month from Independent Contractors </div>
		  <div style="color:#999999; padding:2px;">&nbsp;</div>
		</div>
			<div class="headers">
				<div class="item_no"><b>#</b></div>
				<div class="name"><b>Description</b></div>
				<div class="amount_peso"><b>Date</b></div>
				<div class="amount_dollar"><b>Status</b></div>
			</div>
		<div class="scroll" >
		<div id="payment_invoice_list">
<?
//id, users, users_by_type, description, payment_details, drafted_by, drafted_by_type, status, created_date, peso_total_amount_subcon_payments, dollar_total_amount_subcon_payments, payments_month, dollar_total_amount_BPAFF
$query ="SELECT id,description,status,DATE_FORMAT(created_date,'%D %b %Y') FROM payments_invoice ;";
$result =mysql_query($query);
$counter =0;
while(list($id,$description,$status,$created_date)=mysql_fetch_array($result))
{
	$counter++;
?>
		<div class="list_wrapper" onMouseOver="highlight(this);" onMouseOut="unhighlight(this);" onClick="showDetails(<?=$id;?>)" >
				<div class="item_no"><?=$counter;?></div>
				<div class="name"><?=$description;?></div>
				<div class="amount_peso"><?=$created_date;?></div>
				<div class="amount_dollar"><?=$status;?></div>
			</div>
<?
}
?>			
		</div>
		</div> 
		</div>
		
	<!-- -->
	<div id="payment_summary_viewer" style="margin-bottom:20px;">
		<p>Select Month then Click the "Create Button" to generate a automatic Payments Invoice for the selected month.</p>
		<p>Select an Payment Invoice on the left to view its details.</p>
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

