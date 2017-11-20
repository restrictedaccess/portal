<?php
include('../conf/zend_smarty_conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;
//this will check the admin/bp session and current user settings
include('AdminSessionChecker.php'); //place this after the zend_smarty_conf.php script and  $smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id = $_REQUEST['leads_id'];
$mode = $_REQUEST['mode'];
$mark_lead_for =$_REQUEST['mark_lead_for'];

//echo sprintf('%s %s %s', $leads_id, $mode, $mark_lead_for);

if($leads_id == ""){
    die("leads.id is missing");
}

if($mark_lead_for == ""){
    die("Mark lead for :  is missing");
}

$sql = $db->select()
   ->from('leads', 'mark_lead_for')
   ->where('id =?', $leads_id);
$lead_pin = $db->fetchOne($sql);

if($lead_pin != 'unmark'){
    if($lead_pin != $mark_lead_for){
        if($mark_lead_for == 'unmark'){
	        $history_changes = sprintf('Removed Pin : from %s to unmark', $lead_pin);
	    }else{
		    $history_changes = sprintf('Changed Pin : from %s to %s', $lead_pin, $mark_lead_for);
		}
    } 
}else{
    $history_changes = sprintf('Added Pin : %s', $mark_lead_for);
}  

$data = array('mark_lead_for' => $mark_lead_for, 'last_updated_date' => $ATZ);
$db->update('leads', $data, "id=".$leads_id);



$changes = array(
    'leads_id' => $leads_id ,
    'date_change' => $ATZ, 
	'changes' => $history_changes, 
	'change_by_id' => $current_user['id'], 
	'change_by_type' => $current_user['change_by_type']
);
$db->insert('leads_info_history', $changes);


echo 'ok';
exit;
?>