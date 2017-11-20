<?
include '../config.php';
include '../conf.php';

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

$leads_id = $_REQUEST['leads_id'];

//if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
//	die("ID is Missing.");
//}
if($_SESSION['agent_no']!=NULL){  
	$created_by_condition = " AND created_by = $agent_no AND created_by_type = 'agent'";
}
else if ($_SESSION['admin_id']!=NULL){
	$created_by_condition="";
}
else{
	die("ID is Missing.");
}


if($leads_id=="")
{
	die("Lead ID is missing..!");
}
//echo $leads_id;
//$work_status
$work_statusArray = array("Full-Time","Part-Time","Freelancer","Hourly-Rate","Rent a Team Staff" , "Outbound/Inbound Digital Dialler");
for($i=0;$i<count($work_statusArray);$i++){
	
	
	$work_status_Options.="<option value= ".$work_statusArray[$i].">".$work_statusArray[$i]."</option>";
	
}

?>
<div style="float:left; width:330px; border:#FFFFFF solid 1px;">
<p><label>Product Category :</label>
<select id="product" name="product" class="select">
<option value="">-</option>
<?=$work_status_Options;?>
</select>
</p>
<p><label>Position :</label><input type="text" name="product_position" id="product_position" class="select" ></p>
<p><label>No. of Staff :</label><input type="text" name="product_quantity" id="product_quantity" class="select" style="width:20px;" ></p>
<p><label>Request Price :</label><input type="text" name="product_requested_price" id="product_requested_price" class="select" ></p>
<p><label>Note : </label><textarea name="product_notes" id="product_notes" class="select"></textarea></p>
<p><input type="button" value="Save" onClick="saveProduct();"></p>
</div>
<div id="leads_product_list" style="float:left; width:620px; border:#CCCCCC solid 1px; margin-left:5px;">

<div class="product_wrapper" style="border:#CCCCCC outset 1px; background:#CCCCCC; font-weight:bold;">
		<div style="float:left; display:block; width:30px;padding-top:2px; padding-bottom:2px;text-align:center; "><b>Item</b></div>
		<div style="float:left; display:block; width:300px; text-align:center; border-left:#000000 solid 1px; border-right:#000000 solid 1px;padding-top:2px;padding-bottom:2px; "><b>Description</b></div>
		<div style="float:left; display:block; width:75px;text-align:center;padding-top:2px;padding-bottom:2px;"><b>Amount</b></div>
		<div style="float:left; display:block; width:210px;text-align:center;border-left:#000000 solid 1px;padding-top:2px;padding-bottom:2px;"><b>Notes</b></div>
		<div style="clear:both;"></div>
	</div>
<?
// Parse all data...

$query = "SELECT id, DATE_FORMAT(created_date,'%D %b %y'), status, product, product_position, product_quantity, product_requested_price, product_notes FROM product_request WHERE leads_id = $leads_id $created_by_condition;";
//echo $query;
$result = mysql_query($query);
$counter =0;


while(list($id, $created_date, $status, $product, $product_position, $product_quantity, $product_requested_price, $product_notes)=mysql_fetch_array($result))
{
	$counter++;
	$description ="Looking for a " . $product ." (".$product_quantity.") ".$product_position;
	$product_notes ? $product_notes : '&nbsp;';
?>
	<div style="border:#333333 solid 1px;" >
		<div style="float:left; display:block; width:30px; text-align:center;"><?=$counter;?></div>
		<div title="Date Created <?=$created_date;?>" style="float:left; display:block; width:300px;text-align:center;border-left:#000000 solid 1px; border-right:#000000 solid 1px; height:20px;;"><?=$description;?></div>
		<div style="float:left; display:block; width:75px;text-align:center;"><?=$product_requested_price;?></div>
		<div style="float:left; display:block; width:190px;text-align:center;border-left:#000000 solid 1px;height:20px;"><?=$product_notes;?></div>
		<div title="Delete" onclick="deleteProductItem(<?=$id;?>)" style="float:left; display:block; width:15px;text-align:center;border-left:#000000 solid 1px;height:20px; text-align:center; color:#FF0000; cursor:pointer;">X</div>
		<div style="clear:both;"></div>
	</div>
<?
}

?>
</div>
<div style="clear:both;"></div>
