<?php
//ADD NEW RECORD
include ('../../conf/zend_smarty_conf.php');
include ('../../function.php');
include ('../../time.php');

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if ($_SESSION['agent_no'] != "" or $_SESSION['agent_no'] != NULL) {

	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';

	$sql = $db -> select() -> from('agent') -> where('agent_no =?', $_SESSION['agent_no']);
	$agent = $db -> fetchRow($sql);

} else if ($_SESSION['admin_id'] != "" or $_SESSION['admin_id'] != NULL) {

	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';

} else {
	die("Session expires. Please re-login");
}

$AusTime = date("H:i:s");
$AusDate = date("Y") . "-" . date("m") . "-" . date("d");
$ATZ = $AusDate . " " . $AusTime;

$gs_job_titles_details_id = $_POST['gs_job_titles_details_id'];
$source = $_POST['source'];
$mode = $_POST['mode'];
$leads_id = $_POST['leads_id'];
$jobposition = $_POST['jobposition'];
$jobvacancy_no = $_POST['jobvacancy_no'];
$category_id = $_POST['category_id'];
$outsourcing_model = $_POST['outsourcing_model'];
$companyname = trim($_POST['companyname']);
$heading = trim($_POST['heading']);

$data = array('agent_id' => $created_by_id, 'created_by_type' => $created_by_type, 'lead_id' => $leads_id, 'category_id' => $category_id, 'date_created' => $ATZ, 'outsourcing_model' => $outsourcing_model, 'companyname' => $companyname, 'jobposition' => $jobposition, 'jobvacancy_no' => $jobvacancy_no, 'heading' => $heading, 'status' => 'NEW', 'show_status' => 'NO', 'job_order_id' => $gs_job_titles_details_id, 'job_order_source' => $source);
//print_r($data);
$db -> insert('posting', $data);
$posting_id = $db -> lastInsertId();

if ($posting_id) {
	for ($i = 0; $i < count($_POST['responsibility']); ++$i) {
		if ($_POST['responsibility'][$i] != "") {
			$data = array('posting_id' => $posting_id, 'responsibility' => stripslashes(trim($_POST['responsibility'][$i])));
			$db -> insert('posting_responsibility', $data);

		}
	}

	for ($x = 0; $x < count($_POST['requirement']); ++$x) {
		if ($_POST['requirement'][$x] != "") {
			$data = array('posting_id' => $posting_id, 'requirement' => stripslashes(trim($_POST['requirement'][$x])));
			$db -> insert('posting_requirement', $data);
		}
	}
}

//send email if the user is an agemt
if ($_SESSION['agent_no'] != "" or $_SESSION['agent_no'] != NULL) {

	if ($lead_id) {
		$sql = $db -> select() -> from('leads') -> where('id =?', $lead_id);
		$lead = $db -> fetchRow($sql);
		$client_name = $lead['fname'] . " " . $lead['lname'];
	}
	$details = "<h3>NEW ADS CREATED</h3>
				<p>CLIENT : " . $client_name . "</p>
				<p>POSITION : AD#" . $posting_id . " " . $jobposition . "</p>
				<p>HEADING : " . $heading . "</p>
				<p>Created by : " . $agent['fname'] . " " . $agent['lname'] . "</p>
				<p>NOTE : THIS AD IS NOT YET POSTED WAITING FOR ADMIN APPROVAL.</p><p>See it in Advertisement Tab Admin Section</p>";

	//echo $details;exit;

	$mail = new Zend_Mail();
	$mail -> setBodyHtml($details);
	$mail -> setFrom('noreply@remotestaff.com.au', 'No Reply');

	if (!TEST) {
		$mail -> addTo('admin@remotestaff.com.au', 'Rica J.');
		$mail -> addTo('peterb@remotestaff.com.au', 'Peter B.');
	} else {
		$mail -> addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	}
	//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
	//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	$mail -> setSubject($site . " REMOTESTAFF NEW ADS CREATED BY " . $agent['fname'] . " " . $agent['lname']);
	$mail -> send($transport);

	//$mess = "Successfully added . An email was sent to Admin waiting for approval.";
}

//sync to mongodb
$db -> delete("mongo_job_orders", $db -> quoteInto("leads_id = ?", $leads_id));
try {
	$retries = 0;
	while(true){
		try{
			if (TEST) {
				$mongo = new MongoClient(MONGODB_TEST);
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
		
	$job_orders_collection = $database -> selectCollection('job_orders');
	$job_orders_collection -> remove(array("leads_id" => intval($leads_id)), array("justOne" => false));
} catch(Exception $e) {

}
if (TEST) {
	file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
	file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
	file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
	file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
	file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
	file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");

} else {
	file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
	file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
	file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
	file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
	file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
	file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");

}

if (isset($_POST["mode"])&&$_POST["mode"]=="create"){
	echo "<script type='text/javascript'>";
	echo "alert('Advertisement has been created!');\n";
	$job_order_id = $db->fetchOne($db->select()->from("posting", "job_order_id")->where("id = ?",$posting_id));
	if ($job_order_id){
		echo "window.location.href='/portal/custom_get_started/job_spec.php?gs_job_titles_details_id={$job_order_id}';";	
	}
	echo "window.open('/portal/Ad.php?id={$posting_id}', \"_blank\", \"width=800, height=600\");";
	echo "</script>";	
}
