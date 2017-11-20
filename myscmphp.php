<?
include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';


$client_id = $_SESSION['client_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$userid=$_REQUEST['userid'];
$jobdetails=$_REQUEST['jobdetails'];
$event_date=$_REQUEST['event_date'];
$percentage=$_REQUEST['percentage'];
$finish_date=$_REQUEST['finish_date'];
$notes=$_REQUEST['notes'];

$jobdetails =filterfield($jobdetails);
$notes = filterfield($notes);


//id, client_id, userid, date_start, date_finished, date_created, work_details, notes, percentage, status
$query="INSERT INTO workflow SET client_id = $client_id, 
				userid = $userid, 
				date_start = '$event_date', 
				date_finished = '$finish_date', 
				date_created ='$ATZ', 
				work_details = '$jobdetails', 
				notes = '$notes', 
				percentage = '$percentage'";


//echo $query;
$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
}
else
{
	echo "ok";
}

?>