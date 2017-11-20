<?
include 'config.php';
$id=$_REQUEST['id'];
$userid=$_REQUEST['userid'];
//echo $id."<br>";
//echo $userid."<br>";

$query="DELETE FROM skills WHERE id = $id AND userid = $userid;";
$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		header("location:updateskillsStrengths.php?mess=$mess&userid=$userid");
	}
	else
	{
		header("location:updateskillsStrengths.php?userid=$userid");
	}


?>