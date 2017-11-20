<?
// from :meeting_appointments.php
include 'config.php';
include 'conf.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
$txt=$_REQUEST['txt'];
$id = $_REQUEST['id'];
$txt = filterfield($txt);

// SELECT * FROM meeting_appointments m;
// id, agent_no, details

$query="INSERT INTO meeting_appointments (agent_no, details,date_created) VALUES ($agent_no, '$txt',NOW());";
$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
}
else
{
	header("Location:meeting_appointments.php?id=$id");
}


?>
s