<?php
include 'config.php';
include 'conf.php';

if(isset($_SESSION['admin_id']))
{
	$u_id = $_REQUEST["userid"];
	$admin_id = $_SESSION['admin_id'];
	$pull_time_rate = $_REQUEST['pull_time_rate'];
	$part_time_rate = $_REQUEST['part_time_rate'];
	$date = date('Y-m-d');
	
		if($pull_time_rate == "" || $pull_time_rate == NULL)
		{
			$pull_time_rate = 318;
		}
		if($part_time_rate == "" || $part_time_rate == NULL)
		{
			$part_time_rate = 317;
		}
			
	$q_amount=mysql_query("SELECT userid FROM staff_rate WHERE userid='$u_id' LIMIT 1");
	$ctr=@mysql_num_rows($q_amount);
	if ($ctr > 0)
	{
		mysql_query("UPDATE staff_rate 
		SET product_id='$pull_time_rate', part_time_product_id='$part_time_rate', userid='$u_id', admin_id='$admin_id', date_updated='$date' 
		WHERE userid='$u_id' LIMIT 1");
	}
	else
	{
		mysql_query("INSERT INTO staff_rate 
		SET product_id='$pull_time_rate', part_time_product_id='$part_time_rate', userid='$u_id', admin_id='$admin_id', date_updated='$date'");
	}
}	
?>