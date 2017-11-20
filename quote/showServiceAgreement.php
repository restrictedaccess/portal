<?php
include '../config.php';
include '../conf.php';
include '../time.php';

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

$service_agreement_id = $_REQUEST['service_agreement_id'];

// Check if the quote_id is already exist in the service_agreement table. If exist insert it otherwise notify a update button
//service_agreement_id, quote_id, leads_id, created_by, created_by_type, date_created, status, date_posted, posted_by, posted_by_type
$query = "SELECT s.leads_id,CONCAT(l.fname,' ',l.lname) ,s.created_by,s.created_by_type,quote_no, l.company_name, l.company_address, l.mobile, l.email 
		  FROM service_agreement s
		  LEFT JOIN leads l ON l.id = s.leads_id 
		  LEFT JOIN quote q ON q.id = s.quote_id 
		  WHERE s.service_agreement_id = $service_agreement_id ;";
	//echo $query;
	$data = mysql_query($query);
	list($leads_id,$leads_name,$created_by,$created_by_type,$quote_no, $company_name, $company_address, $mobile, $email )=mysql_fetch_array($data);


if ($service_agreement_id!=NULL){
	//echo "This Quote #$quote_no already has an existing Service Agreement";
}
?>

<div style="padding:5px; background:#D4D4D4; border:#D4D4D4 ridge 1px;">
  <input type="button" value="Delete" onclick="deleteServiceAgreement();" >
<input type="button" value="Cancel" onClick="hide('right_panel');">
<input type="hidden" id="service_agreement_id" value="<?php echo $service_agreement_id;?>">
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
<div id="service_agreement_details_edit_form" ></div>
<div id="service_agreement_details" style="margin-top:10px;">
<?php
  $sql = "SELECT service_agreement_details_id, service_agreement_details FROM service_agreement_details s WHERE service_agreement_id = $service_agreement_id;";
	//echo $sql;	
  $result = mysql_query($sql);	
  $counter=0;
  /*
  1. 1 part time Debt Collector (telemarketer), working 4 hours a day, 5 days a week
	Monthly Fees: $AUD 600 - 700 + GST + Temporary Currency Fluctuation Fee
  */
  while(list($service_agreement_details_id, $service_agreement_details)=mysql_fetch_array($result))
  {
  		$counter++;
				
	?>
		<div style="padding:10px;">
			<div style="text-align:right;"><a href="javascript:editServiceAgreementDetails(<?php echo $service_agreement_details_id;?>)">Edit</a> | <a href="javascript:deleteServiceAgreementDetails(<?php echo $service_agreement_details_id;?>)">Delete</a></div>
			<div>
			<?php
			$str =  $service_agreement_details;
			//echo $str;
			$chars = preg_split('/Monthly/', $str, -1, PREG_SPLIT_NO_EMPTY);
			echo $counter.") ". $chars[0];
			echo "<br>Monthly ". $chars[1];
			
			?>
			</div>
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

