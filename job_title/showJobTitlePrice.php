<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();




$jr_name = $_REQUEST['jr_name'];
$jr_cat_id = $_REQUEST['jr_cat_id'];
$jr_currency = "NULL";
//echo $jr_name;


//jr_list_id, jr_cat_id, jr_name, jr_currency, jr_entry_price, jr_entry_price, jr_expert_price, jr_status
$jr_currencies = array();
$sql = $db->select()
	->from('job_role_cat_list')
	->where('jr_name = ?' , $jr_name)
	->where('jr_currency != ?' , $jr_currency)
	->where('jr_status = ?' , 'system' );
	
$job_titles =  $db->fetchAll($sql);	


//get all currencies that have  per job title role
foreach($job_titles as $job_title){
	$jr_currencies[] = $job_title['jr_currency'];
	
}
	
//get all currencies
$sql2 = $db->select()
	->from('currency_lookup','code');
	//->group('jr_currency')
	//->where('jr_status = ?' , 'system' );
$currencies = $db->fetchAll($sql2);
$currency_lookup = array();

foreach($currencies as $currency){
	$currency_lookup[] = $currency['code'];
}


$missing_currencies = array_diff($currency_lookup,$jr_currencies);
$no_of_missing_currencies = count($missing_currencies);

$currency_array = array();
if($no_of_missing_currencies > 0){
	foreach(array_keys($missing_currencies) as $array_key){
		//echo sprintf("%s<br>", $currency_lookup[$array_key]);
		$currency_array[] = $currency_lookup[$array_key];
	}
}

/*
foreach($job_titles as $job_title){
	echo sprintf("%s<br>",$job_title['jr_currency']);
}
*/

$smarty->assign('jr_cat_id',$jr_cat_id);
$smarty->assign('currency_lookup',$currency_lookup);
$smarty->assign('currency_array',$currency_array);
$smarty->assign('no_of_missing_currencies',$no_of_missing_currencies);
$smarty->assign('jr_name',$jr_name);
$smarty->assign('job_titles',$job_titles);


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('showJobTitlePrice.tpl');

?>