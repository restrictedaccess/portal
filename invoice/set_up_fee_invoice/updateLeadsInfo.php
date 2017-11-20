<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$id =$_REQUEST['id'];
$edit_leads_email = $_REQUEST['edit_leads_email'];
$edit_leads_company = $_REQUEST['edit_leads_company'];
$edit_leads_address = $_REQUEST['edit_leads_address'];


$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($id==""){
	die("Set-UP Fee Invoice ID is Missing..");
}


$query = "UPDATE  set_up_fee_invoice SET 
		  leads_email = '$edit_leads_email', 
		  leads_company = '$edit_leads_company', 
		  leads_address = '$edit_leads_address' 
		  WHERE id = $id;";
$result = mysql_query($query);
if(!$result)die("Error in SQL Script <br>" .$query);
/*
id, leads_id, leads_name, leads_email, leads_company, leads_address, description, drafted_by, drafted_by_type, status, invoice_date, draft_date, post_date, paid_date, sub_total, gst, total_amount, invoice_number, currency, gst_flag

*/
$query = "SELECT leads_name, leads_email, leads_company, leads_address FROM set_up_fee_invoice s WHERE id = $id;";
$result = mysql_query($query);
if(!$result)die("Error in SQL Script <br>" .$query);
list($leads_name, $leads_email, $leads_company, $leads_address)=mysql_fetch_array($result);
?>
<p><label>To :</label><?=$leads_name;?></p>
<p><label>Email :</label><?=$leads_email ;?></p>
<p><label>Company :</label><?=$leads_company ? $leads_company : '&nbsp;';?></p>
<p><label>Address :</label><?=$leads_address ? $leads_address : '&nbsp;';?></p>