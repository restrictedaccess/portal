<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

//$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id'];
$selected_job_title = $_REQUEST['selected_job_title'];
$level = $_REQUEST['level'];
$work_status = $_REQUEST['work_status'];
$currency = $_REQUEST['currency'];

$sql2 = $db->select()
	->from('currency_lookup')
	->where('code = ?' , $currency);
$money = $db->fetchRow($sql2);	
$currency_lookup_id = $money['id'];
$currency = $money['code'];
$currency_symbol = $money['sign'];
//jr_list_id, jr_cat_id, jr_name, jr_currency, jr_entry_price, jr_mid_price, jr_expert_price, jr_status

//get the jr_name first
$sql = $db->select()
	->from('job_role_cat_list' , 'jr_name')
	->where('jr_list_id = ?' ,$selected_job_title);
//echo $sql;
$jr_name = $db->fetchOne($sql);
//echo $jr_name;

$sql = $db->select()
	->from('job_role_cat_list' )
	->where('jr_status !=?' , 'removed')
	->where('jr_name = ?' ,$jr_name)
	->where('jr_currency = ?' ,$currency);
//echo $sql;	
$result = $db->fetchRow($sql);
if($result['jr_list_id'] == ""){
    echo "no currency";
	exit;
}
$jr_status = $result['jr_status'];
$jr_list_id = $result['jr_list_id'];
$jr_cat_id = $result['jr_cat_id'];

$jr_entry_price = $result['jr_entry_price'];
$jr_mid_price = $result['jr_mid_price'];
$jr_expert_price = $result['jr_expert_price'];

if($jr_status == "system"){
		if($work_status== "Part-Time"){
			//55% of the original price
			$jr_entry_price = number_format(($jr_entry_price * .55),2,'.',','); 
			$jr_mid_price = number_format(($jr_mid_price * .55),2,'.',','); 
			$jr_expert_price = number_format(($jr_expert_price * .55),2,'.',','); 
				
			$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/4),2,".",","); 
			$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/4),2,".",","); 
			$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/4),2,".",","); 
			
			
			$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
			$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
			$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );
			
		}else{
			
			$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/8),2,".",","); 
			$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/8),2,".",","); 
			$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/8),2,".",","); 
			
			$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
			$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
			$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );
			
			
		}
}else{
	$entry_price_str = "-";
	$mid_price_str = "-";
	$expert_price_str = "-";

}	


if($level == "entry"){
	$amount_str = $entry_price_str;
}else if($level == "mid"){
	$amount_str = $mid_price_str;
}else{
	$amount_str = $expert_price_str;
}




$smarty->assign('jr_list_id', $jr_list_id);
$smarty->assign('jr_cat_id', $jr_cat_id);
$smarty->assign('amount_str', $amount_str);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('showAmount.tpl');
?>

