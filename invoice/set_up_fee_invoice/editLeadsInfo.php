<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$set_fee_invoice_id =$_REQUEST['set_fee_invoice_id'];
$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($set_fee_invoice_id==""){
	die("Set-UP Fee Invoice ID is Missing..");
}

/*
id, leads_id, leads_name, leads_email, leads_company, leads_address, description, drafted_by, drafted_by_type, status, invoice_date, draft_date, post_date, paid_date, sub_total, gst, total_amount, invoice_number, currency, gst_flag

*/
$query = "SELECT leads_name, leads_email, leads_company, leads_address FROM set_up_fee_invoice s WHERE id = $set_fee_invoice_id;";
$result = mysql_query($query);
if(!$result)die("Error in SQL Script <br>" .$query);
list($leads_name, $leads_email, $leads_company, $leads_address)=mysql_fetch_array($result);
?>
<div style="width:350px; border:#999999 solid 5px; padding:10px; background:#FFFFFF;">
<p><label>Name :</label><?=$leads_name;?></p>
<p><label>Email :</label><input type="text" name="edit_leads_email" id="edit_leads_email" class="select" value="<?=$leads_email;?>"  /></p>
<p><label>Company : </label><input type="text" name="edit_leads_company" id="edit_leads_company" class="select" value="<?=$leads_company;?>"  /></p>
<p><label>Address : </label><textarea id="edit_leads_address" name="edit_leads_address" class="select"><?=$leads_address;?></textarea></p>
<p>
<input type="button" value="Update" onClick="updateLeadsInfo(<?=$set_fee_invoice_id;?>)">
<input type="button" value="Cancel" onClick="hide('leads_info_edit_div');">
<input type="reset" value="Clear">
</p>
</div>