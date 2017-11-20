<?php
include('conf/zend_smarty_conf_root.php');
include 'time.php';

if($_SESSION['admin_id'] == "" or $_SESSION['admin_id'] == NULL){
	header("location:index.php");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$id=$_REQUEST['id'];
$lead_id = $_REQUEST['lead_id'];
$category_id = $_REQUEST['category_id'];
$outsourcing_model=$_REQUEST['outsourcing_model'];
$companyname=$_REQUEST['companyname'];
$jobposition=$_REQUEST['jobposition'];
$jobvacancy_no=$_REQUEST['jobvacancy_no'];
$heading = $_REQUEST['heading'];
$status = $_REQUEST['status'];
$show_status = $_REQUEST['show_status'];


$data = array(
		'lead_id' => $lead_id, 
		'category_id' => $category_id,
		'outsourcing_model' => $outsourcing_model, 
		'companyname' => $companyname, 
		'jobposition' => $jobposition, 
		'jobvacancy_no' => $jobvacancy_no, 
		'heading' => $heading,
		'status' => $status,
		'show_status' => $show_status
		);
//print_r($data);	die;

$where = "id = ".$id;	
$db->update('posting' ,  $data , $where);	


if(count($_POST['responsibility']) > 0){
	//delete the old responsibilities
	$where = "posting_id = ".$id;	
	$db->delete('posting_responsibility' ,$where);

	//insert new record	
	for ($i = 0; $i < count($_POST['responsibility']); ++$i)
	{
		if($_POST['responsibility'][$i]!="")
		{
			$data =  array(
					'posting_id' => $id,
					'responsibility' => $_POST['responsibility'][$i]
					);
			$db->insert('posting_responsibility', $data);
		}	
	}
}

if(count($_POST['requirement']) > 0){
	
	//delete the old requirements
	$where = "posting_id = ".$id;	
	$db->delete('posting_requirement' ,$where);
	
	for ($x = 0; $x < count($_POST['requirement']); ++$x)
	{
		if($_POST['requirement'][$x]!="")
		{
			$data =  array(
						'posting_id' => $id,
						'requirement' => $_POST['requirement'][$x]
						);
			$db->insert('posting_requirement', $data);
		}	
	}
}

//die;
header("location:admineditads.php?id=$id&mess=$mess");

?>
