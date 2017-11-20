<?
// from : applicantHome.php
include 'config.php';
include 'conf.php';
include 'time.php';

$userid = $_SESSION['userid'];
$id=$_REQUEST['id'];
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ=$AusDate." ".$AusTime;

if(isset($_POST['lunch_start']))
{
	
	//id, userid, date, timestart, lunchstart, lunchend, timeend, hours, active, notes, luch_time
	$query="UPDATE timerecord SET lunchstart='$AusTime' WHERE id = $id AND userid =$userid;";
	mysql_query($query);
	header("Location:applicantHome.php");
	
}

if(isset($_POST['lunch_end']))
{
	
	$query="UPDATE timerecord SET lunchend='$AusTime' WHERE id = $id AND userid =$userid;";
	mysql_query($query);
	/////////
	$sql="SELECT lunchstart,notes FROM timerecord WHERE id = $id AND userid =$userid;";
	$result=mysql_query($sql);
	list($lunchstart,$notes) = mysql_fetch_array($result);
	////////
	$sql2="SELECT TIMEDIFF('$AusTime','$lunchstart');";
	$result2=mysql_query($sql2);
	list($difference) = mysql_fetch_array($result2);
	////////
	//$comments =$notes."<br>";
	//$comments.="Time spent in Lunch : ".$difference;
	$query2="UPDATE timerecord SET luch_time='$difference' WHERE id = $id AND userid =$userid;";
	//echo $query2;
	mysql_query($query2);
	header("Location:applicantHome.php");
}

if(isset($_POST['logout']))
{
	//id, userid, date, timestart, lunchstart, lunchend, timeend, hours, active, notes, luch_time, date_logout
	$query="UPDATE timerecord SET timeend='$AusTime' WHERE id = $id AND userid =$userid;";
	//echo $query."<br>";
	mysql_query($query);
	/////////
	$sql="SELECT timestart,date,active,notes,luch_time FROM timerecord WHERE id = $id AND userid =$userid;";
	//echo $sql."<br>";
	$result=mysql_query($sql);
	list($timestart,$date,$active,$notes,$lunch_time) = mysql_fetch_array($result);
	////////// GET THE HOURS WORK
	$sql2="SELECT TIMEDIFF('$AusTime','$timestart');";
	//echo $sql2;
	$result2=mysql_query($sql2);
	list($timeends) = mysql_fetch_array($result2);
	////////// GET THE TOTAL HOURS WORK SUBTRACTED WITH THE LUNCH TIME SPENT
	if($lunch_time!="")
	{
		$sql4="SELECT TIMEDIFF('$timeends','$lunch_time');";
		//echo $sql4;
		$result4=mysql_query($sql4);
		list($timeend) = mysql_fetch_array($result4);
	}
	else
	{
		$timeend=$timeends;
	}	
	////////
	if($AusDate!=$date)
	{
		if($active==1)
		{
			
			$sql3="SELECT TIMEDIFF('$date $timestart','$ATZ');";
			//echo $sql2."<br>";
			$result3=mysql_query($sql3);
			list($timeend) = mysql_fetch_array($result3);
			$comments =$notes."<br>";
			$comments .="Did not properly logout";
			//$comments .="Date / Time logout :" .$ATZ;
			$query3="UPDATE timerecord SET hours='$timeend', notes='$comments',active = 0,date_logout ='$ATZ' WHERE id = $id AND userid =$userid;";
			//echo $query2;
			mysql_query($query3);
		}
		//echo "here";
	}
	//else
	//{
		$comments =$notes."<br>";
		//$comments .="Date / Time logout :" .$ATZ;
		$query2="UPDATE timerecord SET hours='$timeend',active = 0, notes='$comments', date_logout ='$ATZ' WHERE id = $id AND userid =$userid;";
		//echo $query2;
		mysql_query($query2);
	//}
	header("Location:applicantHome.php");
	
}


?>