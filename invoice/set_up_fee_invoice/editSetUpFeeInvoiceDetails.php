<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$set_fee_invoice_details_id =$_REQUEST['id'];
$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($set_fee_invoice_details_id==""){
	die("Set-UP Fee Invoice Detail ID is Missing..");
}

/*
id, set_fee_invoice_id, description, amount, counter, sub_counter
*/
$query = "SELECT description, amount FROM set_up_fee_invoice_details s WHERE id = $set_fee_invoice_details_id;";
$result = mysql_query($query);
if(!$result)die("Error in SQL Script <br>" .$query);
list($description, $amount)=mysql_fetch_array($result);
?>
<div style="width:300px; border:#999999 solid 5px; padding:10px;">
<p><label>Description :</label><input type="text" class="select" id="description" value="<?=$description;?>"></p>
<p><label>Amount :</label><input type="text" class="select" id="amount" value="<?=$amount;?>"></p>
<p>
<input type="button" value="Update" onClick="updateSetUpFeeDetails(<?=$set_fee_invoice_details_id;?>)">
<input type="button" value="Cancel" onClick="hide('edit_div');">
<input type="reset" value="Clear">
</p>
</div>