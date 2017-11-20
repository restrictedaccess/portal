<?php
include '../../config.php';
include '../../conf.php';
include '../../time.php';

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
if ($category_id=="60"){
	$query = "SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id = $category_id ";
}else{
	$query = "SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id = $category_id AND status = 'posted';";
}
$result = mysqli_query($link2,$query);
while(list($sub_category_id, $sub_category_name)=mysqli_fetch_array($result))
{
	// count the applicants in the job_sub_category_applicants
	if ($category_id=="60"){
		$queryCount = "SELECT COUNT(*) FROM job_sub_category_applicants WHERE sub_category_id = $sub_category_id";
	}else{
		$queryCount = "SELECT COUNT(*) FROM job_sub_category_applicants WHERE sub_category_id = $sub_category_id AND ratings='0';";
	}
	$res =mysqli_query($link2,$queryCount);
	list($count)=mysqli_fetch_array($res);
	
?>
	<div style="padding:5px; font:12px Arial;">
		<input type="checkbox" name="jobSubCategory" value="<?=$sub_category_id;?>" /> <?=$sub_category_name;?> (<?=$count;?>)
	</div>
<?
}

?>
</div>