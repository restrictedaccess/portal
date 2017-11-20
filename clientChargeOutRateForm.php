<?
$currency = $_REQUEST['currency'];

if($currency=="AUD"){
	$fix_rate = '38.00';
}
if($currency=="USD"){
	$fix_rate = '45.00';
}
if($currency=="POUND"){
	$fix_rate = '82.00';
}

?>
<p><label>Monthly Quoted Charge Out Rate :</label><span><input type='text' name='client_price' id="client_price"  class='text' onKeyUp="setCopy(this.value);" value="<?=$client_price;?>"></span>
			<input type='hidden' name='currency' id="currency" value="<?=$currency?>"  class='text' >
			<input type='hidden' name='hiddenprice' id="hiddenprice"  class='text' >
			<input type='hidden' name='hiddenprice3' id="hiddenprice3"  class='text' >
			</p>
			<div id="client_payment_rate" style="display:none;"></div>
			<div style="clear:both;"></div>
			<p><label>Fix Currency Rate :</label><span><input type="text" name="dollar" id="dollar" value="<?=$fix_rate;?>" readonly="true" style="width:40px;" class="text"></span></p>
			<p><label>Today Currency Rate :</label><span><input type="text" name="current_rate" id="current_rate" value="<?=$current_rate;?>" style="width:40px;" class="text" onKeyUp="calculateCurrentRate();"><input type="hidden" name="difference" id="difference"> </span></p>
				
			<div style="clear:both;"></div>
			
			<? if($currency=="AUD"){ ?>
			<p><label>With GST :</label><span><input type="checkbox" name="gst" id="gst" value=".10" onClick="setTax(document.form.hiddenprice3.value,'<?=$flag;?>');"></span>		<input type='hidden' name='tax' id='tax'  class='text' value="<?=$tax;?>"></p>
			
			<? } ?>
			<p id="tax_formula"></p>
			<div id="total_difference"></div>
			<p style=" border:#0000FF dashed 1px;"><label>Total Charge Out Rate :</label><span><input type='text' name='hiddenprice2' id="hiddenprice2"  class='text' value="<?=$total_charge_out_rate;?>" ></span>