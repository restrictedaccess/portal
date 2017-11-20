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


if (!$status){
	$status = "NEW";
}

if (!$show_status){
	$show_status = "NO";
}
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
try{
	if ($_SESSION["gs_job_titles_details_id"]){
		$gs_job_titles_details_id = $_SESSION["gs_job_titles_details_id"];
		
		
		$leads_id = $db->fetchOne($db->select()
									->from(array("gs_jtd"=>"gs_job_titles_details"), array())
									->joinLeft(array("gs_jrs"=>"gs_job_role_selection")
											, "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", 
											array("gs_jrs.leads_id"))
									->where("gs_jtd.gs_job_titles_details_id = ?", $gs_job_titles_details_id));
		$data["lead_id"] = $leads_id;
	}	
	$where = "id = ".$id;	
	$db->update('posting' ,  $data , $where);
			
}catch(Exception $e){
	if ($_SESSION["gs_job_titles_details_id"]){
		$gs_job_titles_details_id = $_SESSION["gs_job_titles_details_id"];
		$data["job_order_id"] = $gs_job_titles_details_id;
		$data["date_created"] = date("Y-m-d H:i:s");
	}
	
	$db->insert("posting", $data);
	$id = $db->lastInsertId("posting");
}			




//update the lead marked
check_unmarked_lead($id);		

//exit;
if($id){
	
	//delete first existing records
	$where = "posting_id = ".$id;	
	$db->delete('posting_responsibility' ,$where);
	
	for ($i = 0; $i < count($_POST['responsibility']); ++$i)
	{
		if($_POST['responsibility'][$i]!="")
		{
			$data =  array(
						'posting_id' => $id,
						'responsibility' => stripslashes(trim($_POST['responsibility'][$i]))
						);
			$db->insert('posting_responsibility', $data);
			
		}	
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
require_once dirname(__FILE__)."/../../lib/JobOrderManager.php";
if ($_SESSION["gs_job_titles_details_id"]){
	$gs_job_titles_details_id = $_SESSION["gs_job_titles_details_id"];

	
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
			
		
		$job_order_collection = $database->selectCollection("job_orders");
		
		$cursor = $job_order_collection->find(array("gs_job_titles_details_id"=>intval($gs_job_titles_details_id)));
		$tracking_code = "";
		while($cursor->hasNext()){
			$jo = $cursor->getNext();
			$tracking_code = $jo["tracking_code"];
			if ($tracking_code){
				break;
			}
		}
		if ($tracking_code){
			$manager = new JobOrderManager($db);
			$manager->assignStatus($tracking_code, JobOrderManager::AD_UP);					
		}
	}catch(Exception $e){
		
	}
}

if (isset($_POST["mode"])&&$_POST["mode"]=="edit"){
	echo "<script type='text/javascript'>";
	echo "alert('Advertisement has been updated!');\n";
	
	$job_order_id = $db->fetchOne($db->select()->from("posting", "job_order_id")->where("id = ?", $_REQUEST["id"]));
	if ($job_order_id){
		echo "window.location.href='/portal/custom_get_started/job_spec.php?gs_job_titles_details_id={$job_order_id}';";	
	}
	echo "window.open('/portal/Ad.php?id={$_REQUEST["id"]}', \"_blank\", \"width=800, height=600\");";
	echo "</script>";	
}
		
	
?>

