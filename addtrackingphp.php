<?
include 'config.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no=$_REQUEST['agent_no'];
$agent_code=$_REQUEST['agent_code'];
$promotional_code = $_REQUEST['promotional_code'];
$tracking=$_REQUEST['tracking'];
$mode = $_REQUEST['mode'];
$id=$_REQUEST['id'];
//id, tracking_no, tracking_desc, tracking_created, tracking_createdby
//$promotional_code =$agent_code.$promotional_code;
if ($mode =="")
{
	$query="INSERT INTO tracking (tracking_no, tracking_desc, tracking_created, tracking_createdby,status) VALUES ('$promotional_code','$tracking','$ATZ','$agent_no','NEW');";
	$result=mysql_query($query);
	if (!$result)
	{
		$mess="1";
		header("Location: addtracking.php?mess=$mess");
	}
	else
	{
		$mess="2";
		header("Location: addtracking.php?mess=$mess");
	}
}
if ($mode=="update")
{
	$query2="UPDATE tracking SET tracking_no='$promotional_code',tracking_desc ='$tracking' WHERE id=$id;";
	//echo $query2;
	$result2=mysql_query($query2);
	if (!$result2)
	{
		$mess="1";
		header("Location: addtracking.php?mess=$mess");
	}
	else
	{
		$mess="4";
		header("Location: addtracking.php?mess=$mess");
	}
	
}


?>