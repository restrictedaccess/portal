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
$querySubcontractors ="SELECT DISTINCT(CONCAT(p.fname,' ',p.lname)) AS name , s.total_amount , s.converted_amount ,s.exchange_rate,s.client_payment_total_amount
FROM subcon_invoice s
LEFT JOIN personal p ON p.userid = s.userid
WHERE s.status = '$status'
AND MONTH(s.invoice_date) = '$month'
AND drafted_by_type = 'admin'
ORDER BY p.fname ASC";
//echo $querySubcontractors;
$result_subcon = mysql_query($querySubcontractors);
/*
Save it to database
TABLE : payments_invoice_details
id, payments_invoice_id, item_id, description, peso_amount, section, dollar_amount
*/
$item_id = 0;
while(list($name,$peso_amount,$dollar_amount,$exchange_rate,$client_payment_total_amount)=mysql_fetch_array($result_subcon))
{
	$item_id++;
	if($dollar_amount==""){
		$dollar_amount=0.00;
	}
	if($exchange_rate==""){
		$exchange_rate=0.00;
	}
	if($client_payment_total_amount==""){
		$client_payment_total_amount=0.00;
	}
	$queryInsertSubcon="INSERT INTO payments_invoice_details SET payments_invoice_id = $payments_invoice_id, item_id = $item_id, description = '$name', peso_amount = $peso_amount, section = 'SUBCON', dollar_amount = $dollar_amount , exchange_rate = '$exchange_rate' , client_amount = $client_payment_total_amount;";	
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

$queryUpdate2="UPDATE payments_invoice SET dollar_total_amount_BPAFF = $dollar_total_amount_BPAFF WHERE id =$payments_invoice_id;";
mysql_query($queryUpdate2);



//
$query ="SELECT id,description,status,DATE_FORMAT(created_date,'%D %b %Y') FROM payments_invoice ;";
//echo $query;

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



