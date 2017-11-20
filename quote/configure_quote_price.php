<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$staff_country = $_REQUEST['staff_country'];
$currency = $_REQUEST['currency'];
$salary = $_REQUEST['salary'];
$working_hours = $_REQUEST['working_hours'];
$days = $_REQUEST['days'];
$quote_price = array();

if($staff_country == 'Philippines'){
    $CURRENCY_RATES = $PHP_RATES;
	$staff_currency = 'PHP';
}else{
    $CURRENCY_RATES = $INR_RATES;
	$staff_currency = 'INR';
}

$sql = $db->select()
    ->from('currency_lookup')
    ->where('code =?', $staff_currency);
$currency = $db->fetchRow($sql);

if($working_hours > 0){
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
}	
	
array_push($quote_price, $data);

foreach(array_keys($CURRENCY_RATES) as $code){
    //echo $code." => ".$CURRENCY_RATES[$code]."<br>";
	$sql = $db->select()
	    ->from('currency_lookup')
		->where('code =?', $code);
	$currency = $db->fetchRow($sql);	
	
	$salary = $_REQUEST['salary'] / $CURRENCY_RATES[$code];
	if($working_hours > 0){
	    $data = array(
            'yearly' => $salary * 12,
	        'monthly' => $salary,
	        'weekly' => ($salary * 12) / 52,
	        'daily' => (($salary * 12) / 52) / $days,
	        'hourly' => ((($salary * 12) / 52) / $days) / $working_hours,
	        'currency_rate' => $CURRENCY_RATES[$code],
	        'currency' => $currency['currency'],
	        'sign' => $currency['sign'],
		    'code' => $currency['code']
        );
		
	    if($_REQUEST['work_status'] == 'Full-Time'){
			if($_REQUEST['salary'] < 20000){
			    $data['fulltime_margin'] = $NEW_FULLTIME_MARGINS[$code];
		    }else{
				$data['fulltime_margin'] = $FULLTIME_MARGINS[$code];
			}
			unset($data['parttime_margin']);
		}else{
			if($_REQUEST['salary'] < 14000){
			    $data['parttime_margin'] = $NEW_PARTTIME_MARGINS_FOR_14k_BELOW[$code];
		    }else{
				$data['parttime_margin'] = $PARTTIME_MARGINS[$code];
			}
			unset($data['fulltime_margin']);
		}
		
	    array_push($quote_price, $data);
	}
}


//echo "<pre>";
//print_r($quote_price);
//echo "</pre>";
//exit;
$smarty->assign('show_message', "* This above amount is the minimum margin you can add on top of the Staff Monthly Rate converted per currency");
$smarty->assign('salary', $_REQUEST['salary']);
$smarty->assign('quote_price', $quote_price);
$smarty->display('configure_quote_price.tpl');
?>