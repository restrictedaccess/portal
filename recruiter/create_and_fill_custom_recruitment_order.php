<?php
include '../conf/zend_smarty_conf.php';
include '../function.php';


if (isset($_GET["type"])&&$_GET["type"]=="MERGE"){
	$type = "MERGE";
}else{
	$type = "";
}
if ($type=="MERGE"){
	$row = $db->fetchRow($db->select()->from(array("moi"=>"merged_order_items"), array("jsca_id", "date_added", "lead_id"))->where("moi.merged_order_id = ?", $_GET["merge_order_id"])->where("moi.basis = 1")->where("moi.service_type = 'ASL'"));
	if ($row){
		$date_added = $row["date_added"];
		$jsca_id = $row["jsca_id"];
		$leads_id = $row["lead_id"];
	}
	if (!$date_added){
		$rows = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("jsca_id", "date_added", "lead_id"))->where("moi.merged_order_id = ?", $_GET["merge_order_id"])->where("moi.service_type = 'ASL'")->order("date_added DESC"));
		if (!empty($rows)){
			foreach($rows as $row){
				if ($row["date_added"]&&$row["jsca_id"]&&$row["lead_id"]){
					$date_added = $row["date_added"];
					$jsca_id = $row["jsca_id"];
					$leads_id = $row["lead_id"];
				}
				
			}

		}
	}
}else{
	$date_added = $_GET["date_added"];
	$jsca_id = $_GET["jsca_id"];
	$leads_id = $_GET["lead_id"];
}


if (isset($_SESSION["leads_id"])){
	if (!(isset($_GET["from"])&&($_GET["from"]=="rec_sheet"))){
		$leads_id = $_SESSION["leads_id"];	
	}
}


if ($leads_id){
	//first clear mongo cache for the lead for resyncing purpose
	$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?",$leads_id));
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
			
		$job_orders_collection = $database->selectCollection('job_orders');
		$job_orders_collection->remove(array("leads_id"=>intval($leads_id)), array("justOne"=>false));	
	}catch(Exception $e){
		
	}
}

$session_id =$_GET['session_id'];
if($session_id == ""){
	try{
		$session_id = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), "session_id")->where("job_sub_category_applicants_id = ?", $jsca_id)->where("DATE(date_added) = DATE(?)", $date_added)->where("leads_id = ?", $leads_id));
		$session_id = $session_id["session_id"];		
	}catch(Exception $e){
		
	}

}
if (isset($_SESSION["admin_id"])){
	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);	
}

if (isset($_SESSION["admin_id"])){
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';	
    $_SESSION["filled_up_by_id"] = $_SESSION["admin_id"];
    $_SESSION["filled_up_by_type"] = "admin";
    
}else if (($_SESSION["leads_id"])&&(!isset($_GET["from"]))){
	$created_by_id = $_SESSION['leads_id'];
	$created_by_type = 'leads';		
}else{
	$created_by_id = $leads_id;
	$created_by_type = "leads";	
}




$AusTime = date("H:i:s");
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$ran = get_rand_id();

if (isset($_GET["gs_job_titles_details_id"])){
	$order = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array("gs_job_role_selection_id"))->where("gs_job_titles_details_id = ?", $_GET["gs_job_titles_details_id"]));
	if ($order){
		$data = array(
			'leads_id' => $leads_id,
			'created_by_id' => $created_by_id,
			'created_by_type' => $created_by_type,
			'date_created' => $ATZ,
			'status' => 'new',
			'ran' => $ran,
			'session_id' => $session_id,
			"jsca_id" =>$jsca_id,
			"request_date_added"=>$date_added
		);
		$db->update("gs_job_role_selection", $data, $db->quoteInto("gs_job_role_selection_id = ?", $order["gs_job_role_selection_id"]));
        $custom_recruitment_id = $order["gs_job_role_selection_id"];
		$job_order = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"))->where("gs_job_titles_details_id = ?", $_GET["gs_job_titles_details_id"]));
		unset($job_order["gs_job_titles_details_id"]);
		unset($job_order["comments"]);
		unset($job_order["comment_by_id"]);
		unset($job_order["comment_by_type"]);
		unset($job_order["comment_date"]);
		unset($job_order["sub_category_id"]);
		$db->insert("gs_job_titles_details_temp", $job_order);
		$db->delete("gs_job_titles_details", $db->quoteInto("gs_job_titles_details_id = ?", $_GET["gs_job_titles_details_id"]));
	}else{
		$data = array(
		'leads_id' => $leads_id,
		'created_by_id' => $created_by_id,
		'created_by_type' => $created_by_type,
		'date_created' => $ATZ,
		'status' => 'new',
		'ran' => $ran,
		'session_id' => $session_id,
		"jsca_id" =>$jsca_id,
		"request_date_added"=>$date_added
		);
		$db->insert('gs_job_role_selection', $data);
		$custom_recruitment_id = $db->lastInsertId("gs_job_role_selection");
		if ($type=="MERGE"){
			$db->update("merged_order_items", array("basis"=>0), "merged_order_id = ".$_GET["merge_order_id"]." AND basis = 1");
			$data = array();
			$data["merged_order_id"] = $_GET["merge_order_id"];
			$data["gs_job_title_details_id"] = $custom_recruitment_id;
			$data["basis"] = 1;
			$db->insert("merged_order_items", $data);
		}
		
	}
	$_SESSION["gs_job_role_selection_id"] = $custom_recruitment_id;
}else{
	
	$data = array(
	'leads_id' => $leads_id,
	'created_by_id' => $created_by_id,
	'created_by_type' => $created_by_type,
	'date_created' => $ATZ,
	'status' => 'new',
	'ran' => $ran,
	'session_id' => $session_id,
	"jsca_id" =>$jsca_id,
	"request_date_added"=>$date_added
	);
	$db->insert('gs_job_role_selection', $data);
	$custom_recruitment_id = $db->lastInsertId("gs_job_role_selection");
	if ($type=="MERGE"){
		$db->update("merged_order_items", array("basis"=>0), "merged_order_id = ".$_GET["merge_order_id"]." AND basis = 1");
		$data = array();
		$data["merged_order_id"] = $_GET["merge_order_id"];
		$data["gs_job_title_details_id"] = $custom_recruitment_id;
		$data["basis"] = 1;
		$db->insert("merged_order_items", $data);
	}
    $_SESSION["gs_job_role_selection_id"] = $custom_recruitment_id;
	
}
$_SESSION["client_id"] = $leads_id;
$_SESSION["leads_id"] = $leads_id;
header("Location:/portal/custom_get_started/step2_leads.php?from=recruitment_sheet");
exit;