<?
include '../config.php';
include '../conf.php';

//$agent_no = $_SESSION['agent_no'];
$id = $_REQUEST['id'];

//if($_SESSION['agent_no']==NULL){
//	die("Agent ID is Missing.");
//}

if($id=="")
{
	die("Product ID is missing..!");
}


$query ="DELETE FROM product_request WHERE id = $id;";
mysql_query($query);
?>