<?
include 'config.php';
$id=$_REQUEST['id'];
$userid=$_REQUEST['userid'];
//echo $id."<br>";
//echo $userid."<br>";

$query="DELETE FROM language WHERE id = $id AND userid = $userid;";
$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		header("location:languages.php?mess=$mess&userid=$userid");
	}
	else
	{
		header("location:languages.php?userid=$userid");
	}


?>