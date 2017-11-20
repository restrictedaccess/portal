<?php
include('conf/zend_smarty_conf_root.php');
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';

}else{
	header("location:index.php");
}




$lead_id=$_REQUEST['lead_id'];
$outsourcing_model=$_REQUEST['outsourcing_model'];
$companyname=$_REQUEST['companyname'];
$jobposition=$_REQUEST['jobposition'];
$jobvacancy_no=$_REQUEST['jobvacancy_no'];
$heading = $_REQUEST['heading'];
$category_id = $_REQUEST['category_id'];

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


header("location:admin_addadvertisement.php");
?>
