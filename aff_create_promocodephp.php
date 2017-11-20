<?
include 'conf.php';
include 'config.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];
$agent_code=$_REQUEST['agent_code'];
$promotional_code = $_REQUEST['promotional_code'];
$tracking=$_REQUEST['tracking'];
$mode = $_REQUEST['mode'];
$id=$_REQUEST['id'];
//id, tracking_no, tracking_desc, tracking_created, tracking_createdby
//$promotional_code =$agent_code.$promotional_code;
if(isset($_POST['save']))
{
	$query="INSERT INTO tracking (tracking_no, tracking_desc, tracking_created, tracking_createdby,status) VALUES ('$promotional_code','$tracking','$ATZ','$agent_no','NEW');";
	
	//echo $query;
	$result=mysql_query($query);
	if (!$result)
	{
		
		header("Location: aff_create_promocode.php?mess=2");
	}
	else
	{
		
		header("Location: aff_create_promocode.php?mess=1");
	}
}

if(isset($_POST['update']))
{
	$query2="UPDATE tracking SET tracking_no='$promotional_code',tracking_desc ='$tracking' WHERE id=$id;";
	//echo $query2;
	$result2=mysql_query($query2);
	if (!$result2)
	{
		
		header("Location: aff_create_promocode.php?mess=2");
	}
	else
	{
		
		header("Location: aff_create_promocode.php?mess=3");
	}
	
}


?>