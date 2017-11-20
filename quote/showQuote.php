<?php
include '../config.php';
include '../conf.php';
include '../time.php';
include '../function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
}

$quote_id = $_REQUEST['quote_id'];

// Check if the quote_id is already exist in the service_agreement table. If exist insert it otherwise notify a update button
$sqlCheck ="SELECT * FROM service_agreement s WHERE quote_id = $quote_id;";
//echo $sqlCheck;
$data = mysql_query($sqlCheck);
$ctr  = mysql_num_rows($data);
if($ctr > 0 )
{
	$row = mysql_fetch_array($data);
	$service_agreement_id = $row['service_agreement_id'];
	
}

$query = "SELECT  l.id,CONCAT(l.fname,' ',l.lname) ,created_by,created_by_type,quote_no, l.company_name, l.company_address, l.mobile, l.email 
		  FROM quote q LEFT JOIN leads l ON l.id = q.leads_id 
		  WHERE  q.id = $quote_id
		  ORDER BY date_quoted DESC;";
	//echo $query;
	$data = mysql_query($query);
	list($leads_id,$leads_name,$created_by,$created_by_type,$quote_no, $company_name, $company_address, $mobile, $email )=mysql_fetch_array($data);


if ($service_agreement_id!=NULL){
	//echo "This Quote #$quote_no already has an existing Service Agreement";
}
?>

<div style="padding:5px; background:#D4D4D4; border:#D4D4D4 ridge 1px;">
<input type="button" value="Save as Service Agreement" onClick="createServiceAgreement();">
<input type="button" value="Cancel" onClick="hide('right_panel');">
<input type="hidden" id="quote_id" value="<?php echo $quote_id;?>">
</div>
<div style="padding:5PX;  margin-top:5px; ">
	<div style="text-align:center;">
		<p><b style="color:#FF0000;">SCHEDULE 1</b></p>
		<p><b>PRO FORMA REQUEST FOR SERVICE</b></p>
	</div>
</div>
<div style="padding:10px;">
<p><label>Dated:</label><?php echo date('jS \of F Y ');?></p>
<p><label>From:</label><?php echo $leads_name;?></p>
<p><label>Company:</label><?php echo $company_name ? $company_name : '&nbsp;';?></p>
<p><label>ACN:</label>&nbsp;</p>
<p><label>ABN:</label>&nbsp;</p>
<p><label>Address:</label><?php echo $company_address ? $company_address : '&nbsp;';?></p>
<p><label>Telephone:</label><?php echo $mobile ? $mobile : '&nbsp;';?></p>
<p><label>Facsimile:</label>&nbsp;</p>
<p><label>Email:</label><?php echo $email ? $email : '&nbsp;';?></p>

<div style="margin-top:20px;">
	<p><b><label>TO:</label> Think Innovations- Remote Staff</b></p>
	<p>&nbsp;</p>
	<p><label>ABN:</label> 37-094-364-511</p>
	<p><label>Contact:</label> Chris Jankuovski or Rica Gil</p>
	<p><label>Telephone:</label> +61 2 9016 44 61, +61 2 9011 7706</p>
	<p><label>Facsimile: </label>+61 2 8088 7247</p>
	<p><label>US Fax:</label>(650) 745 108</p>
	<p><label>Email:</label> chrisj@remotestaff.com.au , ricag@remotestaff.com.au</p>
	<p>&nbsp;</p>
	<p><b>SERVICES:</b></p>
	<p>Recruitment and compliance management of the following staff:</p>
	<p style="color:#999999;">Referenced : Quote # <?php echo $quote_no;?></p>
</div>
<div style="margin-top:10px;">
<?php 
  $sql = "SELECT q.work_status, q.work_position, q.working_hours, q.days, q.currency, q.quoted_price , q.gst 
  		  FROM quote_details q
		  WHERE quote_id = $quote_id;";
	//echo $sql;	
  $result = mysql_query($sql);	
  $counter=0;
  /*
  1. 1 part time Debt Collector (telemarketer), working 4 hours a day, 5 days a week
	Monthly Fees: $AUD 600 - 700 + GST + Temporary Currency Fluctuation Fee
  */
  while(list($work_status, $work_position, $working_hours, $days, $currency, $quoted_price, $gst)=mysql_fetch_array($result))
  {
  		$counter++;
		if($currency == "AUD"){
			$currency_symbol = "\$ ";
			$tax_str = "+ GST";
		}
		
		if($currency == "USD"){
			$currency_symbol = "\$ ";
			$tax_str = "+ TAX";
		}
		
		if($currency == "POUND"){
			$currency_symbol = "&pound; ";
			$tax_str = "+ VAT";
			$currency ="GBP";
		} 
		
		if($gst > 0){
			$tax_str = $tax_str;
		}else{
			$tax_str ="";
		} 
		
	?>
		<div style="margin-bottom:20px; margin-left:20px;">
	<div style="margin-bottom:10px;"><?php echo $counter;?>)&nbsp;&nbsp;<?php echo getWorkStatusLongDescription($work_status);?>&nbsp;<?php echo $work_position;?> , working <?php echo $working_hours;?> hours a day, <?php echo $days;?>  days a week </div>
	<div style="margin-left:20px;">Monthly Fees: <?php echo $currency.$currency_symbol.number_format($quoted_price,2,'.',',');?> <?php echo $tax_str;?> + Temporary Currency Fluctuation Fee</div>	
		</div>
	<?php 	
  }
	  
?>
</div>
<div style="margin-top:40px;">
	<p>PERIOD SERVICES TO BE PROVIDED: Upon receipt of the payment for the set up invoice attached with this contract.</p>
		<div style="float:left; display:block;">
		<p><label>Signed by</label> ____________________________</p>
		<p>Remote Staff authorised representative </p>
		<p><label>Date:</label> ____________________________</p>
	</div>
	<div style="float:right; display:block;">
		<p>___________________________________</p>
		<p>Your authorised representative</p>
		<p>Date:_______________________________</p>
	</div>
	<div style=" clear:both;"></div>

</div>

</div>

