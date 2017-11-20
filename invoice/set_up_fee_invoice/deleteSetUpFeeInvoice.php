<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}


$set_fee_invoice_id = $_REQUEST['set_fee_invoice_id'];

$query = "DELETE FROM set_up_fee_invoice WHERE id = $set_fee_invoice_id;";
//echo $query;
$result = mysql_query($query);
if(!$result){
	die(mysql_error());
}
echo "Set-Up Fee Invoice Deleted";
?>