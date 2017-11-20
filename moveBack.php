<?
include 'config.php';
//include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];

$query="UPDATE leads SET status ='Contacted Lead',contacted_since='$ATZ' WHERE id=$id;";
//echo $query;
$result=mysql_query($query);
if (!$result)
{
	//$mess="Error";
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	//header("location:education.php?mess=$mess&userid=$userid");
}
else
{
	header("location:apply_action2.php?id=$id");
}



?>
