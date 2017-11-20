<?
include 'config.php';
$id=$_REQUEST['id'];
$query="DELETE FROM tracking WHERE id = $id;";
$result=mysql_query($query);
if (!$result)
{
	header("Location: aff_create_promocode.php?mess=2");
}
else
{
	header("Location: aff_create_promocode.php?mess=4");
}



?>