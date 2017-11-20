<?php
include 'config.php';
include 'conf.php';

$time_zone=$_REQUEST['time_zone'];
$action=$_REQUEST['action'];
$userid=$_REQUEST['userid'];
$type=$_REQUEST['type'];

if($action == "check")
{
	if($type == "fulltime")
	{
		$p=mysql_query("SELECT time_zone FROM staff_timezone WHERE userid='$userid' LIMIT 1");
		$ctr=@mysql_num_rows($p);
		if ($ctr > 0)
		{
			while ($r = mysql_fetch_assoc($p)) 
			{
				$tz = $r['time_zone'];
			}
			$time_zone = $time_zone.",".$tz;
			mysql_query("UPDATE staff_timezone SET time_zone='$time_zone' WHERE userid='$userid'");		
			//mysql_query("UPDATE staff_timezone SET time_zone = 2 WHERE userid='$userid'");
		}
		else
		{
			mysql_query("INSERT INTO staff_timezone(userid,time_zone) VALUES('$userid','$time_zone')");
			//mysql_query("INSERT INTO staff_timezone SET time_zone='$time_zone', userid='$userid'");
		}
	}
	else
	{
		$p=mysql_query("SELECT time_zone FROM staff_timezone WHERE userid='$userid' LIMIT 1");
		$ctr=@mysql_num_rows($p);
		if ($ctr > 0)
		{
			while ($r = mysql_fetch_assoc($p)) 
			{
				$tz = $r['time_zone'];
			}
			$time_zone = $time_zone.",".$tz;
			mysql_query("UPDATE staff_timezone SET time_zone='$time_zone' WHERE userid='$userid'");		
		}
		else
		{
			mysql_query("INSERT INTO staff_timezone(userid,time_zone) VALUES('$userid','$time_zone')");
		}
	}
}
else
{
	if($type == "fulltime")
	{	
		mysql_query("UPDATE staff_timezone SET time_zone=REPLACE(time_zone,'$time_zone','') WHERE userid='$userid'");
	}
	else
	{
		mysql_query("UPDATE staff_timezone SET time_zone=REPLACE(time_zone,'$time_zone','') WHERE userid='$userid'");
	}
}
?>