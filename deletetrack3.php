<?
include 'config.php';

$id=$_REQUEST['id'];
$query="UPDATE tracking SET status ='NEW' WHERE id = $id;";
//$query="DELETE FROM tracking WHERE id = $id;";
$result=mysql_query($query);
if (!$result)
{
	$mess="1";
	header("Location: addtracking.php?mess=$mess");
}
else
{
	$mess="3";
	header("Location: addtracking.php?mess=$mess");
}



?>