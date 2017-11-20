<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
}

$service_agreement_id = $_REQUEST['service_agreement_id'];




$sql = "DELETE FROM service_agreement WHERE service_agreement_id = $service_agreement_id;";
$result = mysqli_query($link2, $sql);	
if(!$result) die ("Error in SQL Script ." .$sql);
echo "<p>Service Agreement Deleted</p>";	  
?>




