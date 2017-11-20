<?
// from : organizer.php
include 'config.php';
include 'function.php';

$i=$_REQUEST['i'];
$mode=$_REQUEST['mode'];
$agent_no = $_REQUEST['agent_no'];
$month=$_REQUEST['month'];
$day=$_REQUEST['day'];
$year=$_REQUEST['year'];
$title=$_REQUEST['title'];
$desc=$_REQUEST['desc'];
$time=$_REQUEST['time'];

$title = filterfield($title);
$desc = filterfield($desc);

//id, agent_no, cmonth, cday, cyear, title, desc, date_created
if ($mode=="")
{

	$query="INSERT INTO calendar (agent_no, cmonth, cday, cyear, title, details, date_created,ctime) VALUES
			 ($agent_no, '$month', '$day', '$year', '$title', '$desc', NOW(),'$time');"	;
	$result=mysql_query($query);
	if (!$result)
	{
		//$mess="Error";
		echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
		//header("location:organizer.php?mess=1");
	}
	else
	{
		header("location:weekviewOrganizer.php");
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
