<?
include '../config.php';
include '../conf.php';
if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}

$admin_id = $_SESSION['admin_id'];
$table = $_REQUEST['table'];
$id = $_REQUEST['id'];
$name = $_REQUEST['name'];

if($table=="cat"){
	$query = "UPDATE job_category SET category_name = '$name' WHERE category_id = $id;";
	$result = mysql_query($query);
	$category = "Category";
}

if($table=="subcat"){
	$query = "UPDATE job_sub_category SET sub_category_name = '$name' WHERE sub_category_id = $id;";
	$result = mysql_query($query);
	$category = "Sub-Category";
}




?>