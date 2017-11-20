<?php
include('../conf/zend_smarty_conf.php') ;
include("../quote/quote_functions.php");

$full_time_rates = $db->fetchAll($db->select()->from("products")->where("name = ?", "Filipino Staff Full Time Rate"));

foreach($full_time_rates as $full_time_rate){
	$str = $full_time_rate["code"];
	$str = str_replace("PHP-FT-", "", $str);
	$price = str_replace(",", "", $str);
	
	$price = floatval($price);
	$aud = $PHP_RATES["AUD"];
	$gbp = $PHP_RATES["GBP"];
	$usd = $PHP_RATES["USD"];
	if ($price >= 20000){
		$margins_aud = $FULLTIME_MARGINS["AUD"];
		$margins_gbp = $FULLTIME_MARGINS["GBP"];
		$margins_usd = $FULLTIME_MARGINS["USD"];
	}else{
		$margins_aud = $NEW_FULLTIME_MARGINS["AUD"];
		$margins_gbp = $NEW_FULLTIME_MARGINS["GBP"];
		$margins_usd = $NEW_FULLTIME_MARGINS["USD"];
		
	}
	if ($price <= 0){
		$aud_price = 0;
		$gbp_price = 0;
		$usd_price = 0;
	}else{
		$aud_price = ($price/$aud)+$margins_aud;
		$gbp_price = ($price/$gbp)+$margins_gbp;
		$usd_price = ($price/$usd)+$margins_usd;
	}
	
	$db->insert("product_price_history",array("product_id"=>$full_time_rate["id"], "amount"=>$aud_price, "currency_id"=>3, "admin_id"=>143, "date"=>date("Y-m-d H:i:s")));
	$db->insert("product_price_history",array("product_id"=>$full_time_rate["id"], "amount"=>$gbp_price, "currency_id"=>4, "admin_id"=>143, "date"=>date("Y-m-d H:i:s")));
	$db->insert("product_price_history",array("product_id"=>$full_time_rate["id"], "amount"=>$usd_price, "currency_id"=>5, "admin_id"=>143, "date"=>date("Y-m-d H:i:s")));	
}


$part_time_rates = $db->fetchAll($db->select()->from("products")->where("name = ?", "Filipino Staff Part Time Rate"));

foreach($part_time_rates as $part_time_rate){
	$str = $part_time_rate["code"];
	$str = str_replace("PHP-PT-", "", $str);
	$price = str_replace(",", "", $str);
	
	$price = floatval($price);
	$aud = $PHP_RATES["AUD"];
	$gbp = $PHP_RATES["GBP"];
	$usd = $PHP_RATES["USD"];
	if ($price >= 14000){
		$margins_aud = $PARTTIME_MARGINS["AUD"];
		$margins_gbp = $PARTTIME_MARGINS["GBP"];
		$margins_usd = $PARTTIME_MARGINS["USD"];
	}else{
		$margins_aud = $NEW_PARTTIME_MARGINS_FOR_14k_BELOW["AUD"];
		$margins_gbp = $NEW_PARTTIME_MARGINS_FOR_14k_BELOW["GBP"];
		$margins_usd = $NEW_PARTTIME_MARGINS_FOR_14k_BELOW["USD"];
		
	}
	
	if ($price <= 0){
		$aud_price = 0;
		$gbp_price = 0;
		$usd_price = 0;
	}else{
		$aud_price = ($price/$aud)+$margins_aud;
		$gbp_price = ($price/$gbp)+$margins_gbp;
		$usd_price = ($price/$usd)+$margins_usd;
	}
	
	$db->insert("product_price_history",array("product_id"=>$part_time_rate["id"], "amount"=>$aud_price, "currency_id"=>3, "admin_id"=>143, "date"=>date("Y-m-d H:i:s")));
	$db->insert("product_price_history",array("product_id"=>$part_time_rate["id"], "amount"=>$gbp_price, "currency_id"=>4, "admin_id"=>143, "date"=>date("Y-m-d H:i:s")));
	$db->insert("product_price_history",array("product_id"=>$part_time_rate["id"], "amount"=>$usd_price, "currency_id"=>5, "admin_id"=>143, "date"=>date("Y-m-d H:i:s")));	
}


/**
 * Injected By Josef Balisalisa
 * To update the prices in mongo
 */
global $base_api_url;
global $curl;

$curl->get($base_api_url . "/mongo-index/sync-price-full-time-part-time/");




