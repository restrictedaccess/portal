<?
include 'conf.php';
include 'config.php';

$userid=$_REQUEST['id'];
$status=$_REQUEST['status'];

//echo $userid."<br>";
//echo $status."<br>";

if($status=="New")
{
	$new_status="MARK";
}
elseif($status=="MARK")
{
	$new_status="New";
}
	$sqlMark="UPDATE personal SET status='$new_status' WHERE userid = $userid;";

//echo $sqlMark;

$result=mysql_query($sqlMark);
if(!$result)
{
	("Query: $sqlMark\n<br />MySQL Error: " . mysql_error());
	exit;
}
else
{
	header("location:adminadvertise_positions.php");
}	


?>
