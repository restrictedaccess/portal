<?
include '../../conf.php';
include '../../config.php';
$mode=$_REQUEST['mode'];
$current_year =date("Y");
$month = date('m');
if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}

// GEt all Clients
$sql3 = "SELECT DISTINCT l.id, l.lname, l.fname
FROM leads l
LEFT JOIN subcontractors s ON s.leads_id = l.id
WHERE l.status='Client' ORDER BY l.fname ASC;;";
//echo $sql3;
$result3=mysql_query($sql3);
while(list($lead_id, $client_lname, $client_fname) = mysql_fetch_array($result3))
{
	 $client_fullname =$client_fname." ".$client_lname;
	 $clientNameOptions .="<option  value= ".$lead_id.">".$client_fullname."</option>";
	 	
}

$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($month == $monthArray[$i])
  {
 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  }
  else
  {
$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  }
}

$yearArray=array(2008,2009,2010);
for ($i = 0; $i < count($yearArray); $i++)
{
  if($current_year == $yearArray[$i])
  {
 $yearoptions .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
  }
  else
  {
 $yearoptions .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
  }
}
$rateArray=array("AUD","USD","POUND");
for($i=0; $i<count($rateArray);$i++)
{
	if($currency_rate == $rateArray[$i])
	{
		$rate_Options.="<option selected value= ".$rateArray[$i].">".$rateArray[$i]."</option>";
	}else{
		$rate_Options.="<option value= ".$rateArray[$i].">".$rateArray[$i]."</option>";
	}
}
?>

<div id="invoice_form">
<div style="padding:3px; margin:0px; background:#CCCCCC; border:#666666 outset 1px;"><b>Create From Subcon Timerecords</b> </div>
<div style=" border:#666666 solid 1px;">
<p><label>Choose a Client :</label>
	<select name="client" id="client" class="text">
		<option value="0">--Choose Client--</option>
		<?=$clientNameOptions;?>
	</select>
</p>
<p><label>Description :</label><input type="text" name="description" id="description" class="text" style="width:350px;" /></p>
<p><label>Choose Currency Rate</label>
<select name="currency" id="currency"  onChange="javascript:calculateChargeOutRate('new');" class="text">
<option value="">-</option>
<?=$rate_Options;?>
</select>
<span id="currency_desc" style="margin-left:10px; color:#666666;"></span>
</p>
<p><label>Fix Currency Rate :</label><span><input type="text" name="fix_currency_rate" id="fix_currency_rate"   readonly="true" style="width:40px; color:#999999;" class="text"></span></p>
<p><label>Today Currency Rate :</label><span><input type="text" name="current_rate" id="current_rate" value="" style="width:40px;" class="text" ></span>

<p><label>Invoice Month :</label><select name="invoice_month" id="invoice_month" class="text" onchange="getRegularWorkingDays()">
<?=$monthoptions;?>
</select><span id="regular_working_days" style="margin-left:10px;"></span></p>
<p><label>Invoice Year :</label><select name="invoice_year" id="invoice_year" class="text" onchange="getRegularWorkingDays()">
<?=$yearoptions;?>
</select></p>
<p><input type="button" name="create" id="create" value="Create" onclick="createClientInvoiceFromSubconInvoice();" />&nbsp;
<input type="button" name="cancel" id="cancel" onclick="hideInvoiceForm();" value="Cancel"  />
</p>
</div>
</div>
