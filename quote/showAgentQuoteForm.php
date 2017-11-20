<?
include '../config.php';
include '../conf.php';


$leads_id = $_REQUEST['leads_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
}
echo $leads_id;
?>



