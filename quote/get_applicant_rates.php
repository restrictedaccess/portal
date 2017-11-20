<?php
include '../conf/zend_smarty_conf.php';
//include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$userid = $_REQUEST['userid'];
$work_status = $_REQUEST['work_status'];
$code = $_REQUEST['currency'];
$amount = 0;
if($code == ""){
    echo "Currency CODE is missing. ";
	exit;
}

$sql = "SELECT id FROM currency_lookup WHERE code = '".$code."';";
$currency_id = $db->fetchOne($sql);
if(!$currency_id){
    echo "Currency CODE does not exist.";
	exit;
}
//echo sprintf('%s<br>%s<br>%s<br>', $userid, $work_status, $currency);

//id, product_id, part_time_product_id, userid, admin_id, date_updated
$sql = "SELECT * FROM staff_rate WHERE userid = ".$userid. " ORDER BY date_updated DESC LIMIT 1;";
//echo $sql;
$rate = $db->fetchRow($sql);

if($rate['id']){
    //echo "<pre>";
    //print_r($rate);
    //echo "</pre>";

    if($work_status == 'Full-Time'){
	    $id = $rate['product_id'];
	}else{
	    $id = $rate['part_time_product_id'];
	}
	
	$sql = $db->select()
	    ->from('products')
		->where('id=?', $id);
	$product = $db->fetchRow($sql);
	
	$sql = $db->select()
	    ->from('product_price_history')
		->where('product_id =?', $id)
		->where('currency_id =?', $currency_id)
		->order('date DESC')
		->limit(1);
	$product_price_history = $db->fetchRow($sql);	
	$amount = $product_price_history['amount'];
    
}else{
    echo "Applicant has no existing Staff Rate";
	exit;
}


/*
echo "<pre>";
print_r($product);
echo "</pre>";

echo "<pre>";
print_r($product_price_history);
echo "</pre>";
*/
echo $amount;
?>