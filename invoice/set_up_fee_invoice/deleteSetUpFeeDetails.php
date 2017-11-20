<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

$set_fee_invoice_id = $_REQUEST['set_fee_invoice_id'];
$id =$_REQUEST['id'];

$currency = $_REQUEST['currency'];

if($currency == "AUD"){
	$currency_symbol = "\$";
}
if($currency == "USD"){
	$currency_symbol = "\$";
}
if($currency == "POUND"){
	$currency_symbol = "&pound;";
}



if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($id==""){
	die("Set-UP Fee Detail Invoice ID is Missing..");
}


$query = "DELETE FROM set_up_fee_invoice_details WHERE id = $id;";
//echo $query;
$result = mysql_query($query);
if(!$result)die("Error in SQL Script <br>" .$query);

/*
$querySum="SELECT SUM(amount)AS total_amount FROM set_up_fee_invoice_details WHERE set_fee_invoice_id = $set_fee_invoice_id;";
$resultSum=mysql_query($querySum);
list($sub_total_amount)=mysql_fetch_array($resultSum);
if($sub_total_amount==""){
	$sub_total_amount=0.00;
}



//echo $sub_total_amount;
// update payments
$queryUpdateSub_GST_Total="UPDATE set_up_fee_invoice SET sub_total = $sub_total_amount , 
							total_amount = $sub_total_amount 
							WHERE id = $set_fee_invoice_id;";
mysql_query($queryUpdateSub_GST_Total);
*/
$querySum="SELECT SUM(amount)AS total_amount FROM set_up_fee_invoice_details WHERE set_fee_invoice_id = $set_fee_invoice_id;";
$resultSum=mysql_query($querySum);
list($sub_total_amount)=mysql_fetch_array($resultSum);
if($sub_total_amount==""){
	$sub_total_amount=0.00;
}

// update sub_total
$queryUpdateSubTotal="UPDATE set_up_fee_invoice SET sub_total = $sub_total_amount WHERE id = $set_fee_invoice_id;";
mysql_query($queryUpdateSubTotal);

//Check if the set up fee invoice has gst or vat included
$sql = "SELECT sub_total, gst, total_amount, currency, gst_flag FROM set_up_fee_invoice s WHERE id = $set_fee_invoice_id;";
$result = mysql_query($sql);
list($sub_total, $gst, $total_amount, $currency, $gst_flag) = mysql_fetch_array($result);
if($gst_flag == "yes"){
	if($currency == "AUD"){
		$gst = ($sub_total * .10);
		$total_amount = ($sub_total + $gst);
		$currency_symbol = "\$";
	}
	if($currency == "POUND"){
		$gst = ($sub_total * .15);
		$total_amount = ($sub_total + $gst);
		$currency_symbol = "&pound;";
	}
	if($currency == "USD"){
		$gst = ($sub_total * .0);
		$total_amount = ($sub_total + $gst);
		$currency_symbol = "\$";
	}

	
}else{
	$total_amount = $sub_total_amount;
}

// update payments
$queryUpdatePayments="UPDATE set_up_fee_invoice SET gst = $gst, total_amount = $total_amount WHERE id = $set_fee_invoice_id;";
mysql_query($queryUpdatePayments);

	





$query = "SELECT id, description, amount,counter  FROM set_up_fee_invoice_details s WHERE set_fee_invoice_id = $set_fee_invoice_id ;";
$result= mysql_query($query);
while(list($id, $description, $amount,$count )=mysql_fetch_array($result))
{
	if($amount=="" or $amount == " "){
		$amount ="&nbsp;";
	}else{
		$amount = $currency_symbol." ".number_format($amount,2,'.',',');
	}	

	$data.="<div class='list_wrapper'>";		
	if ($count!=""){		
		$num++;		
		$data.="<div style='float:left; width:40; border:#666666 solid 1px; padding:5px;display:block;'>".$num."</div>";
	}else{
		$data.="<div style='float:left; width:40; border:#666666 solid 1px; padding:5px;display:block;'>&nbsp;</div>";
	}
		
	$data.="<div style='float:left; width:350; border:#666666 solid 1px; padding:5px;display:block;'>".$description."</div>
			<div style='float:left; width:190; border:#666666 solid 1px; padding:5px;display:block;'>
				<div style='float:left;width:100px;'>".$amount."</div>
				<div style='float:left; '><a href='javascript:editSetUpFeeDetails(".$id.")'>edit</a> | <a href='javascript:deleteSetUpFeeDetails(".$id.")'>delete</a></div>
				
			</div>
			</div><div style='clear:both;'></div>";
			
}

?>
<?=$data;?>