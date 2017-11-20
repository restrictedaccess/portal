<?
// from : organizer.php
include '../config.php';
include '../function.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$i=$_REQUEST['i'];
$mode=$_REQUEST['mode'];

$agent_no = $_REQUEST['agent_no']; //agent id
$leads_id=$_REQUEST['leads_id']; // client id
$url=$_REQUEST['url'];

$event_date=$_REQUEST['event_date'];
$title=$_REQUEST['title'];
$desc=$_REQUEST['desc'];
$time=$_REQUEST['time'];

$title = filterfield($title);
$desc = filterfield($desc);

//id, agent_no, lead_id, lead_name, title, details, date_created, ctime, event_date
if($leads_id!="") {
$sql ="SELECT * FROM leads WHERE id = $leads_id;";
$result=mysql_query($sql);
$row = mysql_fetch_array($result);
$lead_name =$row['fname']." ".$row['lname'];
}	



if ($mode=="")
{
	if($leads_id!="" && $lead_name !="") {
		$query="INSERT INTO calendar (agent_no,lead_id,lead_name,event_date, title, details, date_created,ctime) VALUES
			 ($agent_no, $leads_id, '$lead_name','$event_date', '$title', '$desc', '$ATZ','$time');";
	}
	else
	{
		$query="INSERT INTO calendar (agent_no,event_date, title, details, date_created,ctime) VALUES
			 ($agent_no,'$event_date', '$title', '$desc', '$ATZ','$time');";
	}		 
	//echo $query;
	$result=mysql_query($query);
	if (!$result)
	{
		//$mess="Error";
		echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
		//header("location:organizer.php?mess=1");
	}
	else
	{	
		header("location:organizer.php?leads_id=$leads_id&url=$url");
	}

}

if ($mode=="update")
{
	$query="UPDATE calendar SET cmonth='$month', cday='$day', cyear='$year', title='$title', details='$desc' WHERE id=$i;";
	$result=mysql_query($query);
	header("location:organizer.php?mess=3");
}

// to ---> organizer.php
?>
