<?php
$sql="SELECT currency, currency_rate_in, rate FROM currency_rates c WHERE currency IN('AUD', 'USD', 'GBP') AND currency_rate_in IN ('PHP', 'INR') AND currently_used='Y';";
$currencies = $db->fetchAll($sql);
foreach($currencies as $currency){
	if($currency['currency_rate_in'] == 'PHP'){
		$PHP_RATES[$currency['currency']]= $currency['rate'];	
	}
	
	if($currency['currency_rate_in'] == 'INR'){
		$INR_RATES[$currency['currency']]= $currency['rate'];	
	}
}
?>