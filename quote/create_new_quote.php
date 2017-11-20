<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id=$_REQUEST['leads_id'];

if($leads_id!=""){
    $sql = $db->select()
	    ->from('leads')
		->where('id =?', $leads_id);
	$lead = $db->fetchRow($sql);	
}				
				
//$sql = $db->select()
//    ->from('currency_lookup');
//$currencies = $db->fetchAll($sql);					


//$smarty->assign('currencies', array('AUD', 'GBP', 'USD'));
$smarty->assign('lead', $lead);
$smarty->display('create_new_quote_form.tpl');
?>