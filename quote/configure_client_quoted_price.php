<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$salary = $_REQUEST['quoted_price'];
$currency = $_REQUEST['currency'];
$working_hours = $_REQUEST['working_hours'];
$days = $_REQUEST['days'];
$quote_price = array();

$sql = $db->select()
    ->from('currency_lookup')
    ->where('code =?', $currency);
$currency = $db->fetchRow($sql);

$data = array(
    'yearly' => $salary * 12,
	'monthly' => $salary,
	'weekly' => ($salary * 12) / 52,
	'daily' => (($salary * 12) / 52) / $days,
	'hourly' => ((($salary * 12) / 52) / $days) / $working_hours,
	'currency' => $currency['currency'],
	'sign' => $currency['sign'],
	'code' => $currency['code']
);
array_push($quote_price, $data);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
$smarty->assign('quote_price', $quote_price);
$smarty->display('configure_quote_price.tpl');
?>