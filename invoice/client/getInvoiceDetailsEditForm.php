<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$id=$_REQUEST['id'];
$client_invoice_id =$_REQUEST['client_invoice_id'];
$query="SELECT * FROM client_invoice_details WHERE id = $id;";
$result=mysql_query($query);
$row=mysql_fetch_array($result);


?>
<div>
<input type="hidden" name="client_invoice_id" id="client_invoice_id" value="<?=$client_invoice_id;?>">
<p><label>Start Date :</label><input type="text" name="start_date" id="start_date" value="<?=$row['start_date'];?>" class="text" readonly="true">&nbsp;<b id="cal_start_date" class="cal_button">CHANGE DATE</b>       </p>
<p><label>End Date :</label><input type="text" name="end_date" id="end_date" value="<?=$row['end_date'];?>" class="text" readonly="true">&nbsp;<b id="cal_end_date" class="cal_button">CHANGE DATE</b></p>
<p><label>Description :</label><input type="text" name="description" id="description" value="<?=$row['decription'];?>" class="text" style=" width:270px;"></p>
<p><label>Total Days Work :</label><input type="text" name="total_days_work" id="total_days_work" value="<?=$row['total_days_work'];?>" class="text" onkeyup="updateTotalDayswork(this.value);"></p>
<p><label>Rate :</label><input type="text" name="rate" id="rate" value="<?=$row['rate'];?>" class="text"></p>
<p><label>Amount :</label><input type="text" name="amount" id="amount" value="<?=$row['amount'];?>" class="text"><input type="hidden" name="amount_hidden" id="amount_hidden" value="<?=$row['amount'];?>" class="text">
</p>
<p><input type="button" value="Update" onclick="updateInvoiceDetail(<?=$id;?>);" />&nbsp;<input type="button" value="cancel" onclick="HideEditDiv('edit_div');" /></p>
</div>