<?php
include '../config.php';
include '../conf.php';

$id = $_GET["id"];
if($_SESSION['admin_id']==$id)
{
	$n = "I";
}
else
{
	$query=mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='$id'");
	while ($row = mysql_fetch_assoc($query)) 
	{
		$n = $row['admin_fname'].' '.$row['admin_lname'];
	}
}
echo $n;
?>