<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$client_invoice_id =$_REQUEST['client_invoice_id'];


?>
<div>
<input type="hidden" name="client_invoice_id" id="client_invoice_id" value="<?=$client_invoice_id;?>">
<p><label>Start Date :</label><input type="text" name="start_date" id="start_date" value="" class="text" readonly="true">&nbsp;
<img align="absmiddle" src="images/calendar_ico.png" id="cal_start_date" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
       </p>
<p><label>End Date :</label><input type="text" name="end_date" id="end_date" value="" class="text" readonly="true">&nbsp;
<img align="absmiddle" src="images/calendar_ico.png" id="cal_end_date" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
</p>
<p><label>Description :</label><input type="text" name="description" id="description" value="" class="text" style=" width:270px;"></p>
<p><label>Total Days Work :</label><input type="text" name="total_days_work" id="total_days_work" value="" class="text"></p>
<p><label>Rate :</label><input type="text" name="rate" id="rate" value="" class="text"></p>
<p><label>Amount :</label><input type="text" name="amount" id="amount" value="" class="text"></p>
<p><input type="button" value="Update" onclick="addInvoiceDetail(<?=$client_invoice_id;?>);" />&nbsp;<input type="button" value="cancel" onclick="HideEditDiv('edit_div');" /></p>
</div>