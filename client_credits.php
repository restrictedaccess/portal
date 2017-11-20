<?php
if(!$db){
    require('../conf/zend_smarty_conf.php');
}

$CLIENT_ID = ((int)$_SESSION['client_id']);  //must be an integer
$client = new couchClient($couch_dsn, 'client_docs');
$response = $client->key($CLIENT_ID)->group()->getView('client', 'running_balance');
//echo "=> ".count($response);
$remaining_credits = $response->rows[0]->value;
if(!$remaining_credits){
    $remaining_credits = 0;
}


//client currency settings
$client->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
$client->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
$client->descending(True);
$client->limit(1);
$response = $client->getView('client', 'settings');
$currency_code = $response->rows[0]->value[0];
$currency_gst_apply = $response->rows[0]->value[1];


if($currency_code != ""){
    $sql = $db->select()
	    ->from('currency_lookup')
		->where('code =?', $currency_code);
	$currency = $db->fetchRow($sql);	
}


$total_staffs_per_day_rate = 0;
$number_of_days_credit = 0;
$sql_active_staff = "SELECT id,  userid, client_price, work_status FROM subcontractors WHERE status= 'ACTIVE' AND leads_id=".$CLIENT_ID;
$active_staffs = $db->fetchAll($sql_active_staff);
if(count($active_staffs) > 0){
    foreach($active_staffs as $s){
	    $staff_per_day_rate = 0;
		$gst = 0;
		if($s['client_price'] > 0){
		    $staff_per_day_rate = ((($s['client_price'] * 12) / 52) / 5); //client per day rate per staff
			if($currency_code == 'AUD' and $currency_gst_apply == 'Y'){
			     $gst = $staff_per_day_rate * .10;
			}
		}
		$total_staffs_per_day_rate = ($total_staffs_per_day_rate + ($staff_per_day_rate + $gst));	
	}
	
	$number_of_days_credit = $remaining_credits / $total_staffs_per_day_rate;
}

//echo 'remaining days left =>'.((int)$number_of_days_credit);
?>
<div style=" border:#CCCCCC 1px; display:block; width:144px; ">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center" valign="top">
<a href="/portal/ClientTopupPrepaid/TopUp.html" title="buy credits" style="text-decoration:none;font-size:12px; font-weight:bold;" target="_blank" ><img src="images/money-bag-th.png" border="0" width="35" height="42" /><br />Buy<br />
 Credits</a>
</td>
<td align="center" valign="top">
<a href="/portal/ClientRunningBalance/RunningBalance.html" title="available credits" style="text-decoration:none;font-size:12px; font-weight:bold;" target="_blank"><img src="images/credit-icon.gif" border="0" width="42" height="42"  /><br />Available<br />
Balance</a>
</td>
</tr>
</table>
</div>
<div style="font-family:'Courier New', Courier, monospace ; margin-top:10px; padding-right:11px; font-size:14px; font-weight:bold;">
<span style=" width:100px; padding:5px;">Credits : <?php echo sprintf('%s%s',$currency['sign'],number_format($remaining_credits,2,'.',','));?></span>
<span style=" width:100px; padding:5px;">Staffs : <?php echo count($active_staffs);?></span>
<span style=" width:100px; padding:5px;">Days : <?php echo round($number_of_days_credit, 2);?></span>
</div>
