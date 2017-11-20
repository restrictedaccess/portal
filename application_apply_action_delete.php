<?
// ROY PEPITO - FEB 19, 2010
// - query to delete record on the top 10 applicant

// ROY PEPITO - MAR 10, 2010
// - query to delete record on the table personal, top10 and application

include 'config.php';
include 'conf.php';

$id = @$_GET["id"];
$type = @$_GET["type"];
if($type == "TOP10")
{
	$q = "DELETE FROM job_sub_category_applicants WHERE id='$id'";
	$result = mysql_query($q);
}
elseif($type == "profile")
{
	$q = "DELETE FROM personal WHERE userid='$id'";
	$result = mysql_query($q);
	
	$q = "DELETE FROM applicants WHERE userid='$id'";
	$result = mysql_query($q);	

	$q = "DELETE FROM job_sub_category_applicants WHERE userid='$id'";
	$result = mysql_query($q);	
}
?>