<?php
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];


$set_fee_invoice_id =$_REQUEST['set_fee_invoice_id'];
$job_roles = $_REQUEST['job_roles'];
$no_of_staff=$_REQUEST['no_of_staff'];
$currency = $_REQUEST['currency'];

if($currency == "AUD"){
	$initial_charge = 200;
	$extra_charge = 150;
	$currency_symbol = "\$";
}
if($currency == "USD"){
	$initial_charge = 200;
	$extra_charge = 150;
	$currency_symbol = "\$";
}
if($currency == "POUND"){
	$initial_charge = 130;
	$extra_charge = 80;
	$currency_symbol = "&pound;";
}



if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($set_fee_invoice_id==""){
	die("Set-UP Fee Invoice ID is Missing..");
}



if($job_roles!="" && $no_of_staff!=""){
	
// id, set_fee_invoice_id, description, amount, counter, sub_counter
	if($no_of_staff==1){
	
	// create counter to show breakdown of data of each subcon
	$sqlCounter = "SELECT MAX(counter) FROM set_up_fee_invoice_details;";
	$res = mysql_query($sqlCounter);
	$row = mysql_fetch_array($res);
	$counter = $row[0] + 1;
	
	$query = "INSERT INTO set_up_fee_invoice_details SET set_fee_invoice_id = $set_fee_invoice_id, 
				description = '$job_roles', counter = $counter, sub_counter = $counter ;";
	$result = mysql_query($query);
	if(!$result) die (mysql_error());		
		
	$price = $no_of_staff * $initial_charge;
	$str = "No. of Staff [ ". $no_of_staff ." ]. Set-up price is ". $currency_symbol.number_format($price,2,'.',',');
	
	
	$query = "INSERT INTO set_up_fee_invoice_details SET set_fee_invoice_id = $set_fee_invoice_id, 
				description = '$str', sub_counter = $counter , amount = $price;";
	$result = mysql_query($query);
	if(!$result) die (mysql_error());			

		
		
		
		
	}
	if($no_of_staff>1){
	
		// create counter to show breakdown of data of each subcon
		$sqlCounter = "SELECT MAX(counter) FROM set_up_fee_invoice_details;";
		$res = mysql_query($sqlCounter);
		$row = mysql_fetch_array($res);
		$counter = $row[0] + 1;
	
		$query = "INSERT INTO set_up_fee_invoice_details SET set_fee_invoice_id = $set_fee_invoice_id, 
				description = '$job_roles', counter = $counter, sub_counter = $counter ;";
		$result = mysql_query($query);
		if(!$result) die (mysql_error());			
		
		$price_for_1_staff = $initial_charge;
		$str = "Initial [ 1 ] Staff = ".$currency_symbol.number_format($initial_charge,2,'.',',');
		
		$query = "INSERT INTO set_up_fee_invoice_details SET set_fee_invoice_id = $set_fee_invoice_id, 
				description = '$str', sub_counter = $counter , amount = $price_for_1_staff;";
		$result = mysql_query($query);
		if(!$result) die (mysql_error());	
		
		$price_for_additional_staff = (($no_of_staff-1) * $extra_charge);
		$str = "Additional Staff ". ($no_of_staff-1) . " x ".$currency_symbol.number_format($extra_charge,2,'.',',')." = " .$currency_symbol.number_format((($no_of_staff-1)*$extra_charge),2,'.',',');
		$query = "INSERT INTO set_up_fee_invoice_details SET set_fee_invoice_id = $set_fee_invoice_id, 
				description = '$str', sub_counter = $counter , amount = $price_for_additional_staff;";
		$result = mysql_query($query);
		if(!$result) die (mysql_error());
		
	}
	
	
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
	$sql = "SELECT sub_total, gst, total_amount, currency, gst_flag, leads_id FROM set_up_fee_invoice s WHERE id = $set_fee_invoice_id;";
	$result = mysql_query($sql);
	list($sub_total, $gst, $total_amount, $currency, $gst_flag, $leads_id) = mysql_fetch_array($result);
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
	
	
	$sql = "UPDATE leads SET last_updated_date = '".$ATZ."' WHERE id =".$leads_id;
    mysql_query($sql); 

}




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
<?php echo $data;?>