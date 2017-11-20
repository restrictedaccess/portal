<?php
include ('../conf/zend_smarty_conf.php');
$currency = "AUD";
if (isset($_POST["currency"])&&$_POST["currency"]){
	$currency = $_POST["currency"];
}else{
	$currency = "AUD";
}
$result = array();
if (!empty($_POST["job_orders"])){
	if(isset($_SESSION["job_order_details"])){
		unset($_SESSION["job_order_details"]);
	}
    foreach($_POST["job_orders"] as $job_order){
    
        $jo = $db->fetchRow($db->select()->
                from(array("jscnp"=>"job_sub_categories_new_prices"))
                ->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jscnp.sub_category_id", array("sub_category_name"))
                ->where("level = ?", $job_order["level"])
                ->where("currency = ?", $currency)
                ->where("jscnp.sub_category_id = ?", $job_order["subcategory"])
                ->where("active = ?", 1));
        if (!$jo){
            $jo = array("sub_category_id"=>$job_order["subcategory"], "currency"=>$currency, "level"=>$job_order["level"], "active"=>1, "value"=>0);
            $jo["sub_category_name"] = $db->fetchOne($db->select()->from("job_sub_category", array("sub_category_name"))->where("sub_category_id = ?", $job_order["subcategory"]));
        }       
        if ($jo){
            $jo["category_name"] = $db->fetchOne($db->select()->from("job_category", array("category_name"))->where("category_id = ?", $job_order["category"]));
            $jo["no_of_staff"] = $job_order["no_of_staff"];
            
            if ($jo["level"]=="mid"){
                $jo["level"] = "Mid Level";
            }else if ($jo["level"]=="entry"){
                $jo["level"] = "Entry";
            }else{
                $jo["level"] = "Expert";
            }
            if ($jo["value"]>0){
                if ($job_order["work_status"]=="Part-Time"){
                    $jo["value"] = number_format($jo["value"]*.6, 2);
                    $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/4, 2);
                }else{
                    $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/8, 2);
                    $jo["value"] = number_format($jo["value"], 2);  
                }
    
                
            }else{
                $jo["value"] = false;
                $jo["hourly_value"] = false;
            }
            
            $jo["currency_symbol"] = $db->fetchOne($db->select()->from("currency_lookup", array("sign"))->where("code = ?", $currency));
            $jo["currency"] = $currency;
            $result[] = $jo;
        }
    }    
}

$_SESSION["job_order_details"] = $_POST;
echo json_encode($result);
