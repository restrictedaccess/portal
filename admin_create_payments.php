<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$month = $_REQUEST['month'];

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

//if($month =="")
//{
//	header("location:payment_history.php");
//}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$current_month=date("m");
$current_month_name=date("F");
$ATZ = $AusDate." ".$AusTime;
$date=date('jS \of F Y \[l\]');


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
	
$thismonth = date( "m" );

$status = "posted";

$monthArray=array("","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($month == $monthArray[$i])
  {
 	$monthoptions = "$monthName[$i]";
	break;
  }
  
}

if(isset($_POST['create']))
{

// Check if the selected Month's is existing then add a new one then increment counter  by one..
$queryCheck ="SELECT COUNT(payments_month)AS counter FROM payments_invoice WHERE payments_month =$month ;";
$resultCheck = mysql_query($queryCheck);
list($counter) = mysql_fetch_array($resultCheck);
if($counter > 0) {
	$counter++;
}else{
	$counter++;
}
//echo $counter;	
//echo $queryCheck;

$description ="#$counter ". $monthoptions." Payments";
//echo $description;
// Create Months Payments
/*
TABLE : payments_invoice
id, users, users_by_type, description, payment_details, drafted_by, drafted_by_type, status, created_date, peso_total_amount_subcon_payments, dollar_total_amount_subcon_payments, payments_month

*/

$query = "INSERT INTO payments_invoice SET users = $admin_id, users_by_type ='admin', description = '$description', drafted_by =$admin_id, drafted_by_type ='admin', status ='draft', created_date = '$ATZ' , payments_month ='$month';";
//echo $query;
$result=mysql_query($query);
$payments_invoice_id=mysql_insert_id();
//echo $payments_invoice_id;

//Get all Subcontractors 
$querySubcontractors ="SELECT DISTINCT(CONCAT(p.fname,' ',p.lname)) AS name , s.total_amount , s.converted_amount ,s.exchange_rate
FROM subcon_invoice s
LEFT JOIN personal p ON p.userid = s.userid
WHERE s.status = '$status'
AND MONTH(s.invoice_date) = '$month'
AND drafted_by_type = 'admin'
ORDER BY p.fname ASC";
$result_subcon = mysql_query($querySubcontractors);
/*
Save it to database
TABLE : payments_invoice_details
id, payments_invoice_id, item_id, description, peso_amount, section, dollar_amount
*/
$item_id = 0;
while(list($name,$peso_amount,$dollar_amount,$exchange_rate)=mysql_fetch_array($result_subcon))
{
	$item_id++;
	$queryInsertSubcon="INSERT INTO payments_invoice_details SET payments_invoice_id = $payments_invoice_id, item_id = $item_id, description = '$name', peso_amount = $peso_amount, section = 'SUBCON', dollar_amount = $dollar_amount , exchange_rate = '$exchange_rate';";	
	//echo $queryInsertSubcon."<br>";
	mysql_query($queryInsertSubcon);
}

//update the TABLE : payments_invoice COLUMN: peso_total_amount_subcon_payments, dollar_total_amount_subcon_payments
$queryPesoDollarTotalAmount ="SELECT SUM(peso_amount), SUM(dollar_amount) FROM payments_invoice_details WHERE payments_invoice_id = $payments_invoice_id AND section ='SUBCON';";
$resultAmount=mysql_query($queryPesoDollarTotalAmount);
$row= mysql_fetch_array($resultAmount);
$total_peso_amount = $row[0];
$total_dollar_amount = $row[1];
//echo $total_peso_amount ."<br>".$total_dollar_amount;


$queryUpdate="UPDATE payments_invoice SET peso_total_amount_subcon_payments = $total_peso_amount, dollar_total_amount_subcon_payments = $total_dollar_amount WHERE id =$payments_invoice_id;";
mysql_query($queryUpdate);


//FOR BP | AFFILIATES

//Get all BP|Aff
$queryBPAFF="SELECT DISTINCT(CONCAT(a.fname,' ',a.lname)) AS name , s.total_amount , s.percent, s.converted_amount,a.work_status
FROM agent_invoice s
LEFT JOIN agent a ON a.agent_no = s.agentid
WHERE s.status = '$status'
AND MONTH(s.invoice_date) = '$month'
AND drafted_by_type = 'admin'
ORDER BY a.fname ASC";
//echo $queryBPAFF;
$resultBPAFF =mysql_query($queryBPAFF);
$item_id = 0;
while(list($agent_name,$agent_amount,$agent_percent,$agent_converted_amount,$work_status)=mysql_fetch_array($resultBPAFF))
{	
	$item_id++;
	$description = $work_status." : ".$agent_name;
	$queryInsertBPAFF="INSERT INTO payments_invoice_details SET payments_invoice_id = $payments_invoice_id, item_id = $item_id, description ='$description' ,
	section = 'AGENT' , dollar_amount_BPAFF = $agent_amount , gst_percent = $agent_percent , dollar_total_amount_BPAFF = $agent_converted_amount;";
	mysql_query($queryInsertBPAFF);
	//echo $queryInsertBPAFF;
}

/*
id, payments_invoice_id, item_id, description, peso_amount, section, dollar_amount, exchange_rate, dollar_amount_BPAFF, gst_percent, dollar_total_amount_BPAFF
*/	
$queryTotalAmountBPAFF="SELECT SUM(dollar_total_amount_BPAFF) FROM payments_invoice_details WHERE payments_invoice_id = $payments_invoice_id AND section ='AGENT';";
//echo $queryTotalAmountBPAFF;
$resultAmount2 = mysql_query($queryTotalAmountBPAFF);
$row2=mysql_fetch_array($resultAmount2);
$dollar_total_amount_BPAFF = $row2[0];

//dollar_total_amount_BPAFF
$queryUpdate2="UPDATE payments_invoice SET dollar_total_amount_BPAFF = $dollar_total_amount_BPAFF WHERE id =$payments_invoice_id;";
//echo $queryUpdate2;
mysql_query($queryUpdate2);
//header("location:admin_payments.php?month=$month");

//echo "create";
}

if(isset($_POST['view']))
{
	$payments_invoice_id=$_REQUEST['payments_invoice_id'];
	//echo $payments_invoice_id;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript1.2">
function subLogin()
{
	if (document.form.payments_invoice_id.value!="")
	{
		document.form.submit();
	}else{
		document.getElementById("errormessage").innerHTML="Error in Srcipt Please try again.";
	}	
}
</script>
</head>
<body onload=subLogin()><!-- onload=subLogin()-->
<!-- -->
<form action="admin_payments.php" name="form" method="POST">
<input type="hidden" name="payments_invoice_id" value="<? echo $payments_invoice_id;?>" />
</form>	 
<div id ="errormessage" style=" padding:10px;"></div>
 <!-- -->
</body>
</html>


