<?
include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';


$userid = $_SESSION['userid'];
$client_id = $_REQUEST['client_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$id=$_REQUEST['id'];
$subcon_reply=$_REQUEST['subcon_reply'];
$percentage=$_REQUEST['percentage'];
$subcon_reply= filterfield($subcon_reply);


if(isset($_POST['reply']))
{
if($subcon_reply!=""){

	$query="INSERT INTO workflow_chat SET 
	workflow_id = $id, 
	client_id = $client_id,  
	subcon_id =$userid,
	message = '$subcon_reply',
	chat_date = '$ATZ',
	created_by = 'SUBCON';";
	
	if($percentage=="100%") {
	$query2="UPDATE workflow SET 
	percentage = '$percentage',
	status ='DONE'
	WHERE id=$id";
	}else{
	$query2="UPDATE workflow SET 
	percentage = '$percentage'
	WHERE id=$id";
	}
	mysql_query($query2);
	
}
else
{
	if($percentage=="100%") {
	$query="UPDATE workflow SET 
	percentage = '$percentage',
	status ='DONE'
	WHERE id=$id";
	}else{
	$query="UPDATE workflow SET 
	percentage = '$percentage'
	WHERE id=$id";
	}
}

}


//echo $query;
$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
}
else
{
	header("Location:worktask.php");
}

?>