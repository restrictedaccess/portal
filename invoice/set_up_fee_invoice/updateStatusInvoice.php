<?php
include('../../conf/zend_smarty_conf.php');
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$set_fee_invoice_id =$_REQUEST['set_fee_invoice_id'];
$status = $_REQUEST['status'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$site = $_SERVER['HTTP_HOST'];


$admin_id = $_SESSION['admin_id'];
$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($set_fee_invoice_id==""){
	die("Set-UP Fee Invoice ID is Missing..");
}

if($admin_id!=NULL){
	$sql ="SELECT * FROM admin WHERE admin_id = $admin_id;";
	$res=mysql_query($sql);
	$ctr2=@mysql_num_rows($res);
	if ($ctr2 >0 )
	{
		$row = mysql_fetch_array ($res); 
		$email = $row['admin_email'];
		$lname = $row['admin_lname'];
		$fname = $row['admin_fname'];
		$work_status = "Admin ";
	}
}
if($agent_no!=NULL)
{
	$sql ="SELECT * FROM agent WHERE agent_no = $agent_no;";
	$res=mysql_query($sql);
	$ctr2=@mysql_num_rows($res);
	if ($ctr2 >0 )
	{
		$row = mysql_fetch_array ($res); 
		$agent_code = $row['agent_code'];
		$email = $row['email'];
		$lname = $row['lname'];
		$fname = $row['fname'];
		$work_status = $row['work_status'];
		
		if($work_status == "BP"){
			$work_status = "Business Partner ";
		}
		if($work_status == "AFF"){
			$work_status = "Affiliate ";
		}
	}
}


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
$query = "SELECT leads_name, leads_email ,  invoice_date ,DATE_FORMAT(draft_date,'%D %b %Y'),DATE_FORMAT(post_date,'%D %b %Y'), sub_total, gst, total_amount, invoice_number, currency  , gst_flag ,  DATE_FORMAT(paid_date,'%D %b %Y') ,drafted_by, drafted_by_type , leads_company, leads_address
		  FROM set_up_fee_invoice WHERE id = $set_fee_invoice_id;";
$result = mysql_query($query);
list($leads_name,$leads_email,$invoice_date,$draft_date,$post_date,$sub_total,$gst,$total_amount,$invoice_number,$currency ,$gst_flag ,$paid_date ,$drafted_by, $drafted_by_type, $leads_company, $leads_address)=mysql_fetch_array($result);


$leads_company ? $leads_company : '&nbsp;';
$leads_address ? $leads_address : '&nbsp;';
//AUD","USD","POUND
if($currency == "AUD"){
	$currency = "Invoice to be paid in Australian Dollar (AUD)";
	$disabled ="";
	$currency_symbol = "\$";
}

if($currency == "USD"){
	$currency = "Invoice to be paid in United States Dollar (USD)";
	$disabled ="disabled='disabled'";
	$currency_symbol = "\$";
}

if($currency == "POUND"){
	$currency = "Invoice to be paid in United Kingdom Pounds (POUNDs)";
	$disabled ="disabled='disabled'";
	$currency_symbol = "&pound;";
}

$QUERY="SELECT counter FROM set_up_fee_invoice_details WHERE set_fee_invoice_id = $set_fee_invoice_id;";
$RESULT=mysql_query($QUERY);
$num=0;
while(list($counter)=mysql_fetch_array($RESULT))
{	
	
	
	$query = "SELECT id, description, amount,counter  FROM set_up_fee_invoice_details s WHERE set_fee_invoice_id = $set_fee_invoice_id AND sub_counter = $counter;";
	//echo $query;
	
	$result= mysql_query($query);
	while(list($id, $description, $amount,$count )=mysql_fetch_array($result))
	{
		if($amount=="" or $amount == " "){
			$amount ="&nbsp;";
		}else{
			$amount = $currency_symbol." ".number_format($amount,2,'.',',');
		}	

		$data.="<div style='margin-top:0px;margin-bottom:0px;'>";		
		if ($count!=""){		
			$num++;		
			$data.="<div style='float:left; width:40px; border:#666666 solid 1px; padding:5px;display:block;'>".$num."</div>";
			$item.=$num.") ";
		}else{
			$data.="<div style='float:left; width:40px; border:#666666 solid 1px; padding:5px;display:block;'>&nbsp;</div>";
		}
			
			$data.="<div style='float:left; width:470px; border:#666666 solid 1px; padding:5px;display:block;'>".$description."</div>
				<div style='float:left; width:150px; border:#666666 solid 1px; padding:5px;display:block;'>".$amount."</div>
				</div><div style='clear:both;'></div>";
			$item.=$description."<br>";	
	}
	
	
}


$body = "<div style='font:12px Arial; border:#CCCCCC solid 1px; width:720px; padding:10px;'>
<div style='font:12px Arial; color:#999999;'>
		<div style='float:left; width:330px; ' >
			<p><img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='267' height='91' /></p>
			Suite 1A, level 2 802 Pacific Highway, Gordon NSW 2072 Australia<br />
			PH: 02 9016 4461<br />
			Fax: 61 2 8088 7247<br />
			Email: admin@remotestaff.com.au
			
		</div>
		<div style=' margin-left:10px; float:left;' >
			<p><img src='http://remotestaff.com.au/portal/images/think_innovation.jpg' width='267' height='91' /></p>
			Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
			Website: www.remotestaff.com.au<br />
		</div>
		<div style='clear:both;'></div>
	</div>
	<hr />
	<!-- Lead Info -->
<div>
	<div style='margin-bottom:10px; margin-top:10px;'>
		<div  >
			<p><label>To :</label>".$leads_name."</p>
			<p><label>Email :</label>".$leads_email."</p>
			<p><label>Company :</label>".$leads_company."</p>
			<p><label>Address :</label>".$leads_address."</p>
		</div>
		<div style='color:#999999;  margin-top:10px;'>
			From : ".getCreator($drafted_by, $drafted_by_type)."
		</div>
	</div>
		<hr />
	<div style='margin-bottom:10px; margin-top:10px;'>
		<p><label style='float:left; display:block; width:90px;'>Status :</label> Waiting for your immediate payment before your recruitment process begin</p>
		<p><label style='float:left; display:block; width:90px;'>Date Created :</label>".$draft_date."</p>
	</div>
	
	<!--Details -->
	<div style=' margin-top:20px;'>
		<div style=' padding:2px; background:#CCCCCC; border:#CCCCCC outset 1px; text-align:right; color:#666666;'>Set-Up Fee Tax Invoice Details</div>
		<div style='padding:10px; margin:5px; text-align:center;'><b>SET-UP FEE TAX INOICE ".$invoice_number."</b></div>
	
		<div style='font-weight:bold; color:#FF0000;'>
			<div style='float:left; width:40px; border:#666666 solid 1px; padding:5px;display:block;'>Item</div>
			<div style='float:left; width:470px; border:#666666 solid 1px; padding:5px;display:block;'>Description</div>
			<div style='float:left; width:150px; border:#666666 solid 1px; padding:5px;display:block;'>Amount</div>
			<div style='clear:both;'></div>
		</div>
		<div id='set_up_fee_invoice_details' >".$data."</div>
	</div>
	<!-- Payment Details -->
		<div id='payment_details' style=' margin-top:10px; padding-right:20px;'>
			<div style='text-align:right;'>".$currency_txt."</div>
			<div>
			<div style=' float:right;width:100px; text-align:right;'>".$currency_symbol." <span id='sub_total'>".number_format($sub_total,2,'.',',')."</span></div>
			<div style='float:right;  display:block;'><b>Sub Total : </b></div>
			<div style='clear:both;'></div>
			</div>
			<div>
			<div style=' float:right;width:100px;text-align:right;'>".$currency_symbol." <span id='gst'>".number_format($gst,2,'.',',')."</span></div>
			<div style='float:right;  display:block;'><b>GST : </b></div>
			<div style='clear:both;'></div>
			</div>
			<div>
			<div style=' float:right; width:100px;text-align:right;'>".$currency_symbol." <span id='total'>".number_format($total_amount,2,'.',',')."</span></div>
			<div style='float:right;  display:block;'><b>TOTAL : </b></div>
			<div style='clear:both;'></div>
			</div>
		</div>
		<div style='margin-top:10px; text-align:center; color:#999999;'><i>
		Think Innovations - Remote Staff only issued electronic Tax Invoices
		</i>
		</div>
		<div style='clear:both;'></div>

</div>";

$admin_email =$email;
$subject = "Invoice Set-Up Fee #".$invoice_number;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
$headers .= 'Bcc: chrisj@remotestaff.com.au,ricag@remotestaff.com.au,normanm@remotestaff.com.au' . "\r\n";


/*
id, leads_id, leads_name, leads_email, description, drafted_by, drafted_by_type, status, invoice_date, draft_date, post_date, paid_date, sub_total, gst, total_amount, invoice_number, currency, gst_flag
*/


//echo $status."<br>";

if($status == "posted"){
	$sql = "UPDATE set_up_fee_invoice SET status = '$status', post_date = '$ATZ' WHERE id = $set_fee_invoice_id;";
	$result = mysql_query($sql);
	
	echo $body;
	//$to ="normaneil007@yahoo.com,normanm@remotestaff.com.au";
	$to =$leads_email;
	//mail($to,$subject, $body, $headers);
	if(!$result) die (mysql_error());
}

if($status == "paid"){
	$sql = "UPDATE set_up_fee_invoice SET status = '$status', paid_date = '$ATZ' WHERE id = $set_fee_invoice_id;";
	$result = mysql_query($sql);
	if(!$result) die (mysql_error());
	/*
	$admin_email="accounts@remotestaff.com.au";
	$to = "admin@remotestaff.com.au , admin@remotestaff.co.uk ";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
	$headers .= 'Cc: peterb@remotestaff.com.au' . "\r\n";
	$headers .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";

	//echo $subject;
	
	//echo $body;
	mail($to,$subject, $body, $headers);
	*/
	$body = "<p>Dear Admin,</p> 
	<p>".$leads_name." have paid for the set up fee of </p>
	<p>#".$invoice_number." SET UP FEE INVOICE ".strtoupper($leads_name)."</p>
	<p><em>".$item."</em></p> 
	<p>Please process her order by notifying the recruitment team. </p>
	<p>Accounts </p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p style='color:#999999;'><em>Clicked by ".$work_status." ".$fname." ".$lname." ".$email."</em></p>";
	
	$subject = "PAYMENT FOR REMOTESTAFF [".$site."] SET UP FEE INVOICE #".$invoice_number;
	$mail = new Zend_Mail();
	$mail->setSubject($subject);
	$mail->setBodyHtml(stripslashes($body));
	$mail->setFrom('accounts@remotestaff.com.au', 'Accounts');
	
	if(! TEST){
		$mail->addTo('admin@remotestaff.com.au' , 'Administrator');
		$mail->addTo('admin@remotestaff.co.uk' , 'Administrator');
		$mail->addCc('peterb@remotestaff.com.au' , 'Peter B.');
		
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	}
	
	$mail->send($transport);
}
?>