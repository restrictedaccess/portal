<?
include '../config.php';
include '../conf.php';
include '../function.php';
include '../time.php';
include('../AgentCurlMailSender.php');

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$agent_no = $_SESSION['agent_no'];
$action = $_REQUEST['action'];
$leads_id =$_REQUEST['leads_id'];
$subject =filterfield($_REQUEST['subject']);
$details =filterfield($_REQUEST['details']);
//$details =$_REQUEST['details'];

$mode = $_REQUEST['mode'];
$id =$_REQUEST['id'];
if($id==""){
	$id=0;
}
//echo $details;

if($mode=="new")
{
	$query="INSERT INTO history SET agent_no = $agent_no , leads_id = $leads_id ,actions = '$action', history = '$details', date_created = '$ATZ' , subject = '$subject'";
	$result=mysql_query($query);
	if (!$result)
	{
		die("Query: $query\n<br />MySQL Error: " . mysql_error());
	}
	$hid = mysql_insert_id();
	//echo $hid;
	echo "<input type='text' name='hid' id='hid' value=$hid>";
}

if($mode=="update" and $id>0)
{
	$query="UPDATE history SET history ='$details' , subject = '$subject' WHERE id=$id;";
	$result=mysql_query($query);
	if (!$result)
	{
		die("Query: $query\n<br />MySQL Error: " . mysql_error());
	}
	echo "<input type='text' name='hid' id='hid' value=$id>";
	//echo $query;
}



?>
