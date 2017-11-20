<?php
include '../../config.php';
include '../../conf.php';
if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}

$admin_id = $_SESSION['admin_id'];
$table = $_REQUEST['table'];
$id = $_REQUEST['id'];

if($table=="cat"){
	$query = "DELETE FROM job_category  WHERE category_id = $id;";
	$result = mysql_query($query);
	$query = "DELETE FROM job_sub_category WHERE category_id = $id;";
	$result = mysql_query($query);
	$query = "DELETE FROM job_sub_category_applicants WHERE category_id = $id;";
	$result = mysql_query($query);
}

if($table=="subcat"){
	$query = "DELETE FROM job_sub_category WHERE sub_category_id = $id;";
	$result = mysql_query($query);
	$category = "Sub-Category";
	$query = "DELETE FROM job_sub_category_applicants WHERE category_id = $id;";
	$result = mysql_query($query);
}

?>

