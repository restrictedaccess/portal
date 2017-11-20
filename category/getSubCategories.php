<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}
$category_id = $_REQUEST['category_id'];
//echo $category_id;

?>
<div style="background:#E9E9E9; border:#CCCCCC outset 1px; padding:5px; font:bold 12px Arial;">Sub Categories</div>
<div style="background:#FFFFFF; border:#CCCCCC solid 1px; padding:5px;">
<?
$query = "SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id = $category_id;";
$result = mysql_query($query);
while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($result))
{
	// count the applicants in the job_sub_category_applicants
	$queryCount = "SELECT COUNT(userid) FROM job_sub_category_applicants WHERE sub_category_id = $sub_category_id AND ratings='0';";
	$res =mysql_query($queryCount);
	list($count)=mysql_fetch_array($res);
	
?>
	<div style="padding:5px; font:12px Arial;">
		<input type="checkbox" name="jobSubCategory" value="<?=$sub_category_id;?>" /> <?=$sub_category_name;?> (<?=$count;?>)
	</div>
<?
}

?>
</div>