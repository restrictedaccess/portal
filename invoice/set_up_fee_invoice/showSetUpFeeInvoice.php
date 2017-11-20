<?php
// 2009-09-30 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Changed Label from GST to VAT
include '../../conf.php';
include '../../config.php';
include '../../time.php';
include '../../function.php';

$set_fee_invoice_id = $_REQUEST['set_fee_invoice_id'];
//echo $set_fee_invoice_id;

$newran = get_rand_id();
$newran = CheckRan($newran);
//Check random character if existing in the table quote 
function CheckRan($ran){
	$query = "SELECT * FROM set_up_fee_invoice WHERE ran = '$ran';";
	$result =  mysql_query($query);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
		// The random character is existing in the table
		$ran = get_rand_id();
		return $ran;
	}else{
		return $ran;
	}
}

//check if the set up fee invoice does not have a random num if not update it....
$query = "SELECT ran FROM set_up_fee_invoice WHERE id = $set_fee_invoice_id;";
$result = mysql_query($query);
list($noran)=mysql_fetch_array($result);
if($noran=="" or $noran == NULL){
	$query = "UPDATE set_up_fee_invoice SET ran = '$newran' WHERE id = $set_fee_invoice_id;";
	mysql_query($query);
	//echo $query;
}



if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

$admin_id = $_SESSION['admin_id'];
$agent_no = $_SESSION['agent_no'];

function getCreator($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		if($row['work_status']=="AFF") $work_status ="Affiliate";
		if($row['work_status']=="BP") $work_status ="Business Partner";
		$name = $work_status." ".strtoupper($row['fname']." ".$row['lname']);
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".strtoupper($row['admin_fname']." ".$row['admin_lname']);
	}
	else{
		$name="";
	}
	return $name;
	
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


/*
id, leads_id, leads_name, leads_email, leads_company, leads_address, description, drafted_by, drafted_by_type, status, invoice_date, draft_date, post_date, paid_date, sub_total, gst, total_amount, invoice_number, currency, gst_flag
*/
$query = "SELECT leads_name, leads_email , status, invoice_date ,DATE_FORMAT(draft_date,'%D %b %Y'),DATE_FORMAT(post_date,'%D %b %Y'), sub_total, gst, total_amount, invoice_number, currency  , gst_flag ,  DATE_FORMAT(paid_date,'%D %b %Y') ,drafted_by, drafted_by_type , leads_company, leads_address , ran
		  FROM set_up_fee_invoice WHERE id = $set_fee_invoice_id;";
$result = mysql_query($query);
list($leads_name,$leads_email,$status,$invoice_date,$draft_date,$post_date,$sub_total,$gst,$total_amount,$invoice_number,$currency ,$gst_flag ,$paid_date ,$drafted_by, $drafted_by_type, $leads_company, $leads_address,$ran)=mysql_fetch_array($result);

//echo $ran;

if($leads_name=="" or $leads_name==" "){
	$leads_name ="-";
}
if($leads_email=="" or  $leads_email==" "){
	$leads_email ="-";
}


if($gst_flag =="no"){
	$flag = "yes";
}else{
	$flag = "no";
}

////

if($gst>0) {
	$gst_btn_txt = "Cancel GST";
	$vat_btn_txt = "Cancel VAT";
	
}else{
	$gst_btn_txt = "Add GST";
	$vat_btn_txt = "Add VAT";
	
}
//AUD","USD","POUND
if($currency == "AUD"){
	$currency_txt = "Invoice to be paid in Australian Dollar (AUD)";
	$currency_symbol = "\$";
	$tax_str = "GST";
	$disabled ="";
}

if($currency == "USD"){
	$currency_txt = "Invoice to be paid in United States Dollar (USD)";
	$disabled ="disabled='disabled'";
	$tax_str = "TAX";
	$currency_symbol = "\$";
}

if($currency == "POUND"){
	$currency_txt = "Invoice to be paid in United Kingdom Pounds (POUNDs)";
	$disabled ="disabled='disabled'";
	$tax_str = "VAT";
	$currency_symbol = "&pound;";
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

<input type="hidden" id="set_fee_invoice_id" value="<?php echo  $set_fee_invoice_id;?>" />
<div style="padding:5px; ">
	<div style="font:12px Arial; color:#999999;">
		<div style="float:left; width:330px; " >
			<p><img src="./images/remote_staff_logo.png" width="289" height="90" /></p>
			104 / 529 Old South Head Road, Rose Bay, NSW 2029<br />
			Phone:<br />
- 02 8088 7247 (Tam)<br />
- 02 8005 1383 (Angeli)<br />
- 02 8003 4576 (Rhiza)<br />
			Fax : 02 8088 7247<br />
			Email: admin@remotestaff.com.au
			
		</div>
		<div style=" margin-left:5px; float:left;" >
			<p><img src='images/think_innovations_logo.png' width='267' height='102' /></p>
			Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
			Website: www.remotestaff.com.au<br />
		</div>
		<div style="clear:both;"></div>
	</div>
	<hr />
	<!-- Lead Info -->
<div>
<p align="right"><a href="javascript:editLeadsInfo();">edit</a></p>
<div id="leads_info_edit_div" style="display:none; position:absolute;"></div>
		<div id="leads_info" >
			<p><label>To :</label><?php echo  $leads_name;?></p>
			<p><label>Email :</label><?php echo  $leads_email ;?></p>
			<p><label>Company :</label><?php echo  $leads_company ? $leads_company : '&nbsp;';?></p>
			<p><label>Address :</label><?php echo  $leads_address ? $leads_address : '&nbsp;';?></p>
		</div>
		<div style="clear:both;"></div>
		<div style="color:#999999;  margin-top:10px;">
			From : 
			<?php echo  getCreator($drafted_by, $drafted_by_type);?>
		</div>
</div>
<hr />
	<div id="date_invoice_details"> 
		<!-- $draft_date $post_date $paid_date -->
		<p><label>Status :</label><?php echo  strtoupper($status);?> </p>
		<p><label>Date Created :</label><?php echo  $draft_date;?></p>
		<p><label>Emailed Date :</label><?php echo  $post_date ? $post_date : '&nbsp;';?></p>
		<p><label>Paid Date :</label><?php echo  $paid_date ? $paid_date : '&nbsp;';?></p>
	</div>
	
	<!--Details -->
	<div style=" margin-top:20px;">
	  <div style=" margin-top:10px; padding:5px;">
		<input type="button" value="Add Job Role" onClick="show_hide('add_job_role_form')"/>
		<input type="button" value="Delete" onClick="deleteSetUpFeeInvoice(<?php echo  $set_fee_invoice_id;?>);"/>
		
		<?php if($currency != "POUND"){ ?>
		<input type="button" id="gst_flag"  name="gst_flag" <?php echo  $disabled;?>  value="<?php echo  $gst_btn_txt;?>" onclick="addGST(<?php echo  $set_fee_invoice_id;?> , '<?php echo  $flag;?>');"/>
		<?php } else { ?>
		<input type="button" value="<?php echo $vat_btn_txt;?>" onclick="addCancelVAT(<?php echo  $set_fee_invoice_id;?> , '<?php echo  $flag;?>');"/>
		<?php }?>
		
		<!--<input type="button" value="Email" onClick="updateSetUpFeeInvoiceStatus('posted');"/>-->
		<input type="button" value="Paid" onClick="updateSetUpFeeInvoiceStatus('paid');"/>
		<input type="button" value="Export to PDF" onClick="location.href='pdf_report/spf/?ran=<? echo $ran;?>'"/>
	  </div>
	<div id="add_job_role_form" style="margin-top:10px; margin-bottom:10px; padding:5px; display:none;  background:#E9E9E9; border:#CCCCCC ridge 1px;">
	<input type="hidden" id="currency_rate" value="<?php echo  $currency;?>"
		<p><label>Job Roles :</label><input type="text" name="job_roles" id="job_roles" class="select" onKeyUp="createJobRoleQuote()" /></p>
		<p><label>No. of Staff :</label><input type="text" name="no_of_staff" id="no_of_staff" class="select" onKeyUp="createJobRoleQuote()" /></p>
		<p><span id="steps_taken_quote"></span></p>
		<p><input type="button" value="Add" onClick="addJobRole(<?php echo  $set_fee_invoice_id;?>);"/>&nbsp;
		<input type="button"  value="Cancel" onClick="show_hide('add_job_role_form');">
		<input type="reset"  value="Clear">
		</p>
	</div>
	<div style=" padding:2px; background:#CCCCCC; border:#CCCCCC outset 1px; text-align:right; color:#666666;">Set-Up Fee Tax Invoice  Details</div>
	<div id="edit_div" style="display:none;">Edit Form Here</div>
	<div style="padding:10px; margin:5px; text-align:center;"><b>RECRUITMENT SET-UP FEE TAX INVOICE <?php echo  $invoice_number;?></b></div>
	
	<div class='list_wrapper' style=" font-weight:bold; color:#FF0000;">
		<div style='float:left; width:40; border:#666666 solid 1px; padding:5px;display:block;'>Item</div>
		<div style='float:left; width:350; border:#666666 solid 1px; padding:5px;display:block;'>Description</div>
		<div style='float:left; width:190; border:#666666 solid 1px; padding:5px;display:block;'>Amount</div>
		<div style='clear:both;'></div>
	</div>
	<div id="set_up_fee_invoice_details" ><?php echo  $data;?></div>
	
	</div>
	<div id="payment_details" style=" margin-top:10px; padding-right:20px;">
			<div style="text-align:right;"><?php echo  $currency_txt;?></div>
			<div>
			<div style=" float:right;width:100px; text-align:right;"><?php echo  $currency_symbol;?> <span id="sub_total"><?php echo  number_format($sub_total,2,'.',',');?></span></div>
			<div style="float:right;  display:block;"><b>Sub Total : </b></div>
			<div style="clear:both;"></div>
			</div>
			<div>
			<div style=" float:right;width:100px;text-align:right;"><?php echo  $currency_symbol;?> <span id="gst"><?php echo  number_format($gst,2,'.',',');?></span></div>
			<div style="float:right;  display:block;"><b><?php echo $tax_str;?> : </b></div>
			<div style="clear:both;"></div>
			</div>
			<div>
			<div style=" float:right; width:100px;text-align:right;"><?php echo  $currency_symbol;?> <span id="total"><?php echo  number_format($total_amount,2,'.',',');?></span></div>
			<div style="float:right;  display:block;"><b>TOTAL : </b></div>
			<div style="clear:both;"></div>
			</div>
		</div>
		<div style="margin-top:10px; text-align:center; color:#999999;"><i>
		Think Innovations - Remote Staff only issued electronic Tax Invoices
		</i>
		</div>
</div>
