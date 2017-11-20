<?


include 'config.php';
include 'time.php';
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];
$userid=$_REQUEST['userid'];
//echo $id."<br>";
//echo $userid."<br>";

$query="DELETE FROM language WHERE id = $id AND userid = $userid;";
$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		header("location:subcon_updatelanguages.php?mess=$mess");
	}
	else
	{
		$queryUpdate ="UPDATE personal SET dateupdated='$ATZ ' WHERE userid = $userid;";
		mysql_query($queryUpdate);
		header("location:subcon_updatelanguages.php");
	}


?>