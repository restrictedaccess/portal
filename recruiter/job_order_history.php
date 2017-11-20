<?php
include('../conf/zend_smarty_conf.php') ;
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
		if (TEST){
			$mongo = new MongoClient(MONGODB_TEST);
			$database2 = $mongo2->selectDB('prod');
		}else{
			$mongo2 = new MongoClient(MONGODB_SERVER);
			$database2 = $mongo2->selectDB('prod');
		}

		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}
	
$job_orders_collection = $database->selectCollection('job_orders');
$job_orders_history_collection = $database2->selectCollection('job_orders_history');
$cursor = $job_orders_history_collection->find();
$cursor->sort(array("date"=>-1))->limit(1000);

$histories = array();
while($cursor->hasNext()){
	$history = $cursor->getNext();	
	$history["date"] = date("Y-m-d", $history["date"]->sec);
	if (strpos($history["tracking_code"], 'MERGE') !== FALSE){
		$id = explode("-", $history["tracking_code"]);
		$id = $id[0];
		
		//find leads data
		$items = $db->select()->from("merged_order_items")->where("merged_order_id = ?", $id);
		foreach($items as $item){
			if ($item["gs_job_title_details_id"]){
				$leads_id = $db->fetchOne($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array())
						->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id"))
						->where("gs_jtd.gs_job_titles_details_id = ?", $item["gs_job_title_details_id"]));
				
			}else{
				$leads_id = $item["lead_id"];
			}
			if ($leads_id){
				break;
			}
		}
	}else{
		$id = explode("-", $history["tracking_code"]);
		$id = $id[0];
		$leads_id = $db->fetchOne($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array())
						->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id"))
						->where("gs_jtd.gs_job_titles_details_id = ?", $id));
	}
	if (!$leads_id){
		$cursor_jo = $job_orders_collection->find(array("tracking_code"=>$history["tracking_code"]));
		while($cursor_jo->hasNext()){
			$job_order = $cursor_jo->getNext();
			$leads_id = $job_order["leads_id"];
		}
	}
	
	//query the lead
	if ($leads_id){
		$history["lead"] = $db->fetchRow($db->select()->from("leads", array("id", "fname", "lname"))
										->where("id = ?", $leads_id));
	}else{
		$history["lead"] = array();
	}
	
	$histories[] = $history;
}	

$smarty = new Smarty();
$smarty->assign("histories", $histories);
$smarty->display("job_order_history.tpl");
