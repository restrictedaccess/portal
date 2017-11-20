<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];




$leads_id = $_REQUEST['leads_id'];
$product = $_REQUEST['product'];
$product_position = $_REQUEST['product_position'];
$product_quantity = $_REQUEST['product_quantity'];
$product_requested_price = $_REQUEST['product_requested_price'];
$product_notes = $_REQUEST['product_notes'];


if($product_quantity=="") $product_quantity =0;
if($product_requested_price=="")$product_requested_price =0;

if($_SESSION['agent_no']!=NULL){  
	$created_by_type = 'agent';
	$created_by_condition = " AND created_by = $agent_no AND created_by_type = 'agent'";
	$created_by = $_SESSION['agent_no'];
}
else if ($_SESSION['admin_id']!=NULL){
	$created_by_type = 'admin';
	$created_by_condition="";
	$created_by = $_SESSION['admin_id'];
}
else{
	die("ID is Missing.");
}


if($leads_id=="")
{
	die("Lead ID is missing..!");
}

/*
TABLE product_request
id, leads_id, created_by, created_by_type, created_date, status, product, product_position, product_quantity, product_requested_price, product_notes

*/
$query = "INSERT INTO product_request SET leads_id =$leads_id , 
			created_by = $created_by, 
			created_by_type = '$created_by_type', 
			created_date = '$ATZ' , 
			product = '$product', 
			product_position = '$product_position', 
			product_quantity = $product_quantity, 
			product_requested_price = '$product_requested_price' ,
			product_notes = '$product_notes';";
			
$result=mysql_query($query);
if(!$result) die(mysql_error());

?>
<div class="product_wrapper" style="border:#CCCCCC outset 1px; background:#CCCCCC; font-weight:bold;">
		<div style="float:left; display:block; width:30px;padding-top:2px; padding-bottom:2px;text-align:center; "><b>Item</b></div>
		<div style="float:left; display:block; width:300px; text-align:center; border-left:#000000 solid 1px; border-right:#000000 solid 1px;padding-top:2px;padding-bottom:2px; "><b>Description</b></div>
		<div style="float:left; display:block; width:75px;text-align:center;padding-top:2px;padding-bottom:2px;"><b>Amount</b></div>
		<div style="float:left; display:block; width:210px;text-align:center;border-left:#000000 solid 1px;padding-top:2px;padding-bottom:2px;"><b>Notes</b></div>
		<div style="clear:both;"></div>
	</div>
<?
// Parse all data...

$query = "SELECT id, DATE_FORMAT(created_date,'%D %b %y'), status, product, product_position, product_quantity, product_requested_price, product_notes FROM product_request WHERE leads_id = $leads_id  $created_by_condition;";
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