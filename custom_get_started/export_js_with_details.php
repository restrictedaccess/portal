<?php
include('../conf/zend_smarty_conf.php') ;
include_once "../recruiter/lib/Force.php";
$retries = 0;
while(true){
	try{
		if (TEST) {
			$mongo = new MongoClient();
			$database = $mongo -> selectDB('prod');
		
		} else {
			$mongo = new MongoClient(MONGODB_SERVER);
			$database = $mongo -> selectDB('prod');
		}

		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}



$job_spec_collection = $database->selectCollection("job_specifications");


$filter = array(
			'$or'=>array(
				array("other_details.increase_demand"=>"Yes"),
				array("other_details.support_current"=>"Yes"),
				array("other_details.meet_new"=>"Yes"),
				array("other_details.experiment_role"=>"Yes"),
				array("other_details.replacement_post"=>"Yes"),
				
			)
			
		);
		
		
$cursor = $job_spec_collection->find($filter);
$fp = fopen('export_job_order.csv', 'w');
fputcsv($fp, array("Job Title" , "Lead", "Increase Demand", "Meet New", "Replacement Post", "Support Current", "Experiment Role"));

while($cursor->hasNext()){
	$job_spec = $cursor->getNext();
	
	$row = array();
	$row[] = $job_spec["selected_job_title"];
	try{
		$sql = $db->select()->from("leads", array("fname", "lname"))->where("id = ?", $job_spec["job_role_selection"]["leads_id"]);
		$client = $db->fetchRow($sql);
	}catch(Exception $e){
		continue;
	}
	$row[] = $client["fname"]." ".$client["lname"];
	
	if ($job_spec["other_details"]["increase_demand"]=="Yes"){
		$row[] = "Yes";
	}else{
		$row[] = "No";
	}
	if ($job_spec["other_details"]["meet_new"]=="Yes"){
		$row[] = "Yes";
	}else{
		$row[] = "No";
	}
	if ($job_spec["other_details"]["replacement_post"]=="Yes"){
		$row[] = "Yes";
	}else{
		$row[] = "No";
	}
	if ($job_spec["other_details"]["support_current"]=="Yes"){
		$row[] = "Yes";
	}else{
		$row[] = "No";
	}
	if ($job_spec["other_details"]["experiment_role"]=="Yes"){
		$row[] = "Yes";
	}else{
		$row[] = "No";
	}
	
	
	fputcsv($fp, $row);
}
fclose($fp);
output_file("export_job_order.csv", "export_job_order.csv", "text/csv");
unlink("export_job_order.csv");	
