<?
include '../config.php';
include '../conf.php';


$id = $_REQUEST['id'];
$quote_details_id = $_REQUEST['quote_details_id'];

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

$query="DELETE FROM quote_details WHERE id = $quote_details_id;";
$result = mysql_query($query);
if(!$result) die ("Error in sql script .". $query);
echo $id;
?>


