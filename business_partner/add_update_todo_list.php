<?
include '../config.php';
include '../conf.php';
include '../function.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}
$agent_no = $_SESSION['agent_no'];
$leads_id = $_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}


$mode=$_REQUEST['mode'];
$subject=$_REQUEST['subject'];
$start_date =$_REQUEST['start_date'];
$due_date=$_REQUEST['due_date'];
$status=$_REQUEST['status'];
$priority=$_REQUEST['priority'];
$details=$_REQUEST['details'];
$priority=$_REQUEST['priority'];
$percentage=$_REQUEST['percentage'];
$todo_id = $_REQUEST['todo_id'];


if($mode=="save"){
	$query="INSERT INTO todo SET agent_no = $agent_no ,lead_id = $leads_id, date_created = '$ATZ', subject = '$subject', start_date = '$start_date', due_date = '$due_date', status = '$status', priority = '$priority', percentage = '$percentage' ,details = '$details', folder = 'NEW';";
	$result = mysql_query($query);
	if($result){
		echo '<input type="hidden" name="result" id="result" value="saved" />';
	}else{
		die($query.mysql_error());
	}
	
}
if($mode=="UPDATE"){
	$query="UPDATE todo SET subject = '$subject', start_date = '$start_date', due_date = '$due_date', status = '$status', priority = '$priority', percentage = '$percentage' ,details = '$details' WHERE id = $todo_id;";
	$result = mysql_query($query);
	if($result){
		echo '<input type="hidden" name="result" id="result" value="saved" />';
	}else{
		die($query.mysql_error());
	}
	
}
?>

