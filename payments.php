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
$month = $_REQUEST['month'];
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

?>
<html>
<head>
<style>
<!--
#subcon_table{
width:500px;
background:#CCCCCC;

}
#subcon_table  td {
	font:12px Arial, Helvetica, sans-serif;
	border:#999999 solid 1px;
	background:#FFFFFF;
	padding: 4px;
}
-->
</style>
<script language="JavaScript" type="text/javascript">
<!--
function highlight(obj) {
   obj.style.backgroundColor='yellow';
   //obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   //obj.style.cursor='default';
}
//-->
</script>
</head>
<body>
<form name="form" method="post">
<select name="month" onChange="javascript:document.form.submit();">
<?=$monthoptions;?>
</select>
<table >
<tr ><td>#</td><td><b>Subcontractors</b></td><td align='right'><b>Amount Pesos</b></td><td align='right'><b>Amount Dollar</b></td></tr>
<?
$query ="SELECT DISTINCT(CONCAT(p.fname,' ',p.lname)) AS name , s.total_amount , s.converted_amount ,s.exchange_rate
FROM subcon_invoice s
LEFT JOIN personal p ON p.userid = s.userid
WHERE s.status = 'posted'
AND MONTH(s.invoice_date) = '$month'
AND drafted_by_type = 'admin'
ORDER BY p.fname ASC";
//echo $query;
$result =mysql_query($query);
$counter=0;
while(list($name,$amount,$converted_amount)=mysql_fetch_array($result))
{	$counter++;
	echo "<tr onmouseover='highlight(this)' onmouseout='unhighlight(this)'><td>".$counter."</td><td>".$name."</td><td align='right'>P ".number_format($amount,2,'.',',')."</td><td align='right'>$ ".number_format($converted_amount,2,'.',',')."</td></tr>";
	$total_amount =$total_amount + $amount;
	$total_amount_dollar =$total_amount_dollar + $converted_amount;
}

?>

<tr><td colspan="2" >Total Payments</td><td align='right'>P <?=number_format($total_amount,2,'.',',')?></td><td align="right">$ <?=number_format($total_amount_dollar,2,'.',',')?></td></tr>
</table>

</form>
</body>
</html>