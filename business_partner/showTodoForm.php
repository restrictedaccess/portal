<?
include '../config.php';
include '../conf.php';
if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}
$agent_no = $_SESSION['agent_no'];
$leads_id = $_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}
$queryLeads ="SELECT * FROM leads WHERE id = $leads_id;";
$resultLeads=mysql_query($queryLeads);
$rows = mysql_fetch_array($resultLeads);
$lname =$rows['lname'];
$fname =$rows['fname'];
$status =$rows['status'];

?>

todo form here