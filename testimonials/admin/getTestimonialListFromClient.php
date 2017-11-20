<?
include "../../config.php";
include "../../conf.php";
include "../../time.php";
include "../../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$id = $_REQUEST['id'];
$section = $_REQUEST['section'];


if($_SESSION['admin_id']=="")
{
	die("Admin Session ID already Expire! Please Re-Login !");
}
if($id == ""){
	die("ID is Missing.");
}

if($section == ""){
	die("Section is Missing.");
}

echo $id." ".$section;

?>

<div style="padding:35px;">Not Yet Available</div>