<?php 
//UPDATE
include('../../conf/zend_smarty_conf.php');
include('../../function.php');
include('../../time.php');

include '../../category-management/ads-function.php';

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	
	$sql= $db->select()
		->from('agent')
		->where('agent_no =?' ,$_SESSION['agent_no']);
	$agent = $db->fetchRow($sql);	

}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';

}else{
	die("Session expires. Please re-login");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$id = $_POST['id'];
$mode = $_POST['mode'];

$jobposition = $_POST['jobposition'];
$jobvacancy_no = $_POST['jobvacancy_no'];
$category_id = $_POST['category_id'];
$outsourcing_model = $_POST['outsourcing_model'];
$companyname = trim($_POST['companyname']);
$heading = trim($_POST['heading']);
$status = $_REQUEST['status'];
$show_status = $_REQUEST['show_status'];


				
$data = array(
			'category_id' => $category_id,
			'outsourcing_model' => $outsourcing_model, 
			'companyname' => $companyname, 
			'jobposition' => $jobposition, 
			'jobvacancy_no' => $jobvacancy_no, 
			'heading' => $heading,
			'status' => $status,
			'show_status' => $show_status
			);

$where = "id = ".$id;	
$db->update('posting' ,  $data , $where);	

//update the lead marked
check_unmarked_lead($id);		

//exit;
if($id){
	
	//delete first existing records
	$where = "posting_id = ".$id;	
	$db->delete('posting_responsibility' ,$where);
	
	$unique = array();
	foreach($_POST["responsibility"] as $item){
		if (!in_array($item, $unique)){
			$unique[] = $item;
		}
	}

	foreach($unique as $item){
		$data = array("posting_id"=>$id, "responsibility"=>stripslashes(trim($item)));
		$db->insert('posting_responsibility', $data);
			
	}

	//delete first existing records
	$where = "posting_id = ".$id;	
	$db->delete('posting_requirement' ,$where);
	
	for ($x = 0; $x < count($_POST['requirement']); ++$x)
	{
		if($_POST['requirement'][$x]!="")
		{
			$data =  array(
						'posting_id' => $id,
						'requirement' => stripslashes(trim($_POST['requirement'][$x]))
						);
			$db->insert('posting_requirement', $data);
		}	
	}
}	

$posting = $db->fetchRow($db->select()->from("posting", "lead_id")->where("id = ?", $id));
if ($posting){
	$leads_id =  $posting["lead_id"];
	//sync to mongodb
	$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $leads_id));
	try{
		$retries = 0;
		while (true) {
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

	if (TEST){
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
		
	}else{
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
		
	}	
}
if (isset($_POST["mode"])&&$_POST["mode"]=="edit"){
	echo "<script type='text/javascript'>";
	echo "alert('Advertisement has been updated!');\n";
	
	$job_order_id = $db->fetchOne($db->select()->from("posting", "job_order_id")->where("id = ?",$_REQUEST["id"]));
	if ($job_order_id){
		echo "window.location.href='/portal/custom_get_started/job_spec.php?gs_job_titles_details_id={$job_order_id}';";	
	}
	echo "window.open('/portal/Ad.php?id={$_REQUEST["id"]}', \"_blank\", \"width=800, height=600\");";
	echo "</script>";	
}
		
?>

