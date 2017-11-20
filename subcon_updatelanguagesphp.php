<?
// from : languages.php
include 'config.php';
include 'conf.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$userid=$_SESSION['userid'];

//$userid=$_REQUEST['userid'];
$language=$_REQUEST['language'];
$spoken=$_REQUEST['spoken'];
$written=$_REQUEST['written'];

if(isset($_POST['Add']))
{	
	// language
	// id, userid, language, spoken, written
	$query="INSERT INTO language (userid, language, spoken, written) VALUES ($userid, '$language', $spoken, $written)";
	$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	}
	else
	{	
		$queryUpdate ="UPDATE personal SET dateupdated='$ATZ ' WHERE userid = $userid;";
		mysql_query($queryUpdate);
		header("location:subcon_updatelanguages.php");
	}
}

?>