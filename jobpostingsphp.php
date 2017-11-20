<?php
include('conf/zend_smarty_conf_root.php');
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


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
	header("location:index.php");
}




$lead_id=$_REQUEST['id'];
$lead_status = $_REQUEST['lead_status'];

$outsourcing_model=$_REQUEST['outsourcing_model'];
$companyname=$_REQUEST['companyname'];
$jobposition=$_REQUEST['jobposition'];
$jobvacancy_no=$_REQUEST['jobvacancy_no'];
$heading = $_REQUEST['heading'];
$category_id = $_REQUEST['category_id'];

$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}

$data = array(
		'agent_id' => $created_by_id, 
		'created_by_type' => $created_by_type,
		'lead_id' => $lead_id, 
		'category_id' => $category_id,
		'date_created' => $ATZ, 
		'outsourcing_model' => $outsourcing_model, 
		'companyname' => $companyname, 
		'jobposition' => $jobposition, 
		'jobvacancy_no' => $jobvacancy_no, 
		'status' => 'NEW', 
		'heading' => $heading
		);
//print_r($data);		
		
$db->insert('posting', $data);
$posting_id = $db->lastInsertId();


for ($i = 0; $i < count($_POST['responsibility']); ++$i)
{
	if($_POST['responsibility'][$i]!="")
	{
		$data =  array(
					'posting_id' => $posting_id,
					'responsibility' => $_POST['responsibility'][$i]
					);
		$db->insert('posting_responsibility', $data);
		
	}	
}

for ($x = 0; $x < count($_POST['requirement']); ++$x)
{
	if($_POST['requirement'][$x]!="")
	{
		$data =  array(
					'posting_id' => $posting_id,
					'requirement' => $_POST['requirement'][$x]
					);
		$db->insert('posting_requirement', $data);
	}	
}

$mess = "Successfully added";


//add history
$history_changes = 'New Advertisement created and added';
$changes = array('posting_id' => $posting_id,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $created_by_id, 
			 'change_by_type' => $created_by_type);
$db->insert('posting_history', $changes);


//send email if the user is an agemt
if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){


	if($lead_id){
		$sql = $db->select()
			->from('leads')
			->where('id =?' , $lead_id);
		$lead = $db->fetchRow($sql);	
		$client_name = $lead['fname']." ".$lead['lname'];
	}
	$details =  "<h3>NEW ADS CREATED</h3>
				<p>CLIENT : ".$client_name."</p>
				<p>POSITION : AD#".$posting_id." ".$jobposition."</p>
				<p>HEADING : ".$heading."</p>
				<p>Created by : ".$agent['fname']." ".$agent['lname']."</p>
				<p>NOTE : THIS AD IS NOT YET POSTED WAITING FOR ADMIN APPROVAL.</p><p>See it in Recruitment tab under Advertisement Management --> New Job Advertisement Admin Section</p>";
				
	//echo $details;exit;
	
	$mail = new Zend_Mail();
	$mail->setBodyHtml($details);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	
	if(! TEST){
		$mail->addTo('admin@remotestaff.com.au', 'Rica J.');
		$mail->addTo('peterb@remotestaff.com.au', 'Peter B.');
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	}
	//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
	//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	$mail->setSubject($site." REMOTESTAFF NEW ADS CREATED BY ".$agent['fname']." ".$agent['lname']);
	$mail->send($transport);
	
	$mess = "Successfully added . An email was sent to Admin waiting for approval.";
}


header("location:jobpostings.php?id=$lead_id&lead_status=$lead_status&mess=$mess&page_type=$page_type");
?>
