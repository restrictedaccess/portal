<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';


$client_invoice_id =$_REQUEST['client_invoice_id'];
$query="SELECT * FROM client_invoice WHERE id = $client_invoice_id;";
$result=mysql_query($query);
$row=mysql_fetch_array($result);


?>
Invoice Payment Due Date :<input type="text" name="invoice_payment_due_date" id="invoice_payment_due_date" value="<?=$row['invoice_payment_due_date'];?>" class="text" readonly="true">&nbsp;<input type="button" id="cal_due_date" value="change date" style="font:10px tahoma;" />       
<input type="button" value="update" onclick="updateDueDate(<?=$client_invoice_id;?>);" style="font:10px tahoma;" />&nbsp;<input type="button" value="cancel" onclick="HideEditDiv('due_date_div');" style="font:10px tahoma;" />
