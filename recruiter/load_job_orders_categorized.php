<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/GetJobPosting.php";

require_once "reports/RecruiterASLReports.php";

if (TEST){
	$reports = new RecruiterASLReports($db);
}else{
	$reports = new RecruiterASLReports($db_query_only);
}
$subcategory = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $_REQUEST["sub_category_id"]));
$jos = $reports->getJobOrders($subcategory);
$job_orders = array();
$total = 0;
foreach($jos as $jo){
	try{
		$retries = 0;
		while(true){
			try{
				if (TEST){
					$mongo = new MongoClient(MONGODB_TEST);
					$database = $mongo->selectDB('prod');
				}else{
					$mongo = new MongoClient(MONGODB_SERVER);
					$database = $mongo->selectDB('prod');
				}
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
			
		
		if (TEST){
			$posting = new GetJobPosting($db);
		}else{
			$posting = new GetJobPosting($db_query_only);
		}
		$job_orders_collection = $database->selectCollection('job_orders');
		$cursor = $job_orders_collection->find(array("tracking_code"=>$jo["tracking_code"]));
		while($cursor->hasNext()){
			$result = $cursor->getNext();
			$diff = $result["date_closed"]->sec - $result["date_filled_up"]->sec;
			
			$result["date_filled_up"] = date("Y-m-d", $result["date_filled_up"]->sec);
			$result["date_closed"] = date("Y-m-d", $result["date_closed"]->sec);
			
			if ($result["date_closed"]=="1970-01-01"){
				$result["date_closed"] = "N/A";
				$result["number_of_days"] = "N/A";
			}else{
				$number_of_days = floor($diff/(60*60*24));
				$total += $number_of_days;
				$result["number_of_days"] = $number_of_days." days";
			}
			
			$result = $posting->getTransformedOrder($result);
			$job_orders[] = $result;
			break;
		}
	}catch(MongoConnectionException $e) {
		die($e->getMessage());
	}

}


$smarty = new Smarty();
$smarty->assign("job_orders", $job_orders);
$smarty->assign("subcategory", $subcategory);
$smarty->assign("total_days", $total);
$smarty->display("recruitment_job_orders_categorized.tpl");
