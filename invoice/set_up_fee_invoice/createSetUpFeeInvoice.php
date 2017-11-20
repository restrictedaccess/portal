<?php
include '../../conf.php';
include '../../config.php';
include '../../time.php';
include '../../function.php';


$ran = get_rand_id();
$ran = CheckRan($ran);
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


if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

$admin_id = $_SESSION['admin_id'];
$agent_no = $_SESSION['agent_no'];

if($admin_id!=NULL){
	$drafted_by = $admin_id;
	$drafted_by_type = 'admin';
}
if($agent_no!=NULL){
	$drafted_by = $agent_no;
	$drafted_by_type = 'agent';
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id = $_REQUEST['leads_id'];
$leads_name = $_REQUEST['leads_name'];
$leads_email = $_REQUEST['leads_email'];
$currency = $_REQUEST['currency'];

// newly added march 26, 2009
$leads_company = $_REQUEST['leads_company'];
$leads_address = $_REQUEST['leads_address'];


if($leads_id >0 or $leads_id!="0"){
	/*
	id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip
	*/
	$sqlLead ="SELECT * FROM leads l WHERE id = $leads_id;";
	$data = mysql_query($sqlLead);
	$row = mysql_fetch_array($data);
	$leads_name = $row['fname']." ".$row['lname'];
	$leads_email = $row['email'];
	$leads_company = $row['company_name'];
	$leads_address = $row['company_address'];
}

// Create invoice number
$sqlInvoiceNumber = "SELECT MAX(invoice_number) FROM set_up_fee_invoice;";
$res = mysql_query($sqlInvoiceNumber);
$row_result = mysql_fetch_array($res);
if($row_result[0] == 0 or $row_result[0]==""){
	$invoice_number = 1000;
}else{
	$invoice_number = $row_result[0] + 1;
}	

/*
set_fee_invoice
id, leads_id, leads_name, leads_email, leads_company, leads_address, description, drafted_by, drafted_by_type, status, invoice_date, draft_date, post_date, paid_date, sub_total, gst, total_amount, invoice_number, currency, gst_flag

*/
$description = "#".$invoice_number ." SET-UP FEE INVOICE";
$leads_company = filterfield($leads_company);
$leads_address = filterfield($leads_address);
$leads_name = filterfield($leads_name);

$query = "INSERT INTO set_up_fee_invoice SET description = '$description', drafted_by = $drafted_by , drafted_by_type = '$drafted_by_type', status = 'draft', 
		  invoice_date  = '$ATZ', draft_date = '$ATZ' , invoice_number = $invoice_number ,leads_id = $leads_id, leads_name = '$leads_name',
		  leads_email = '$leads_email' , currency = '$currency', leads_company = '$leads_company', leads_address = '$leads_address' , ran = '$ran';";
//echo $query;
$result = mysql_query($query);
if(!$result){
	die(mysql_error());
}
$set_fee_invoice_id = mysql_insert_id();

$sql = "UPDATE leads SET last_updated_date = '".$ATZ."' WHERE id =".$leads_id;
mysql_query($sql); 

?>
<input type="hidden" id="set_fee_invoice_id" name="set_fee_invoice_id" value="<?=$set_fee_invoice_id;?>" />


