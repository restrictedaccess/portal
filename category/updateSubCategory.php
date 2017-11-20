<?php
include '../config.php';
include '../conf.php';
if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}
else
{
	$id = @$_REQUEST["id"];
	$name = @$_REQUEST["name"];
	$query = mysql_query("UPDATE job_sub_category SET sub_category_name = '$name' WHERE sub_category_id = '$id'");
}	
?>