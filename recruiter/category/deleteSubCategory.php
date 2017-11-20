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
$category_id = $_REQUEST['category_id'];

if($table=="subcat"){
	$query = "DELETE FROM job_sub_category WHERE sub_category_id = $id;";
	$result = mysql_query($query);
	$category = "Sub-Category";
}
?>

<?
//Get All Sub-Category
//sub_category_id, category_id, sub_category_name, sub_category_date_created
$sql="SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id = $category_id;";
$data = 	mysql_query($sql);	
while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($data))
{
	?>
		<div style="padding:2px; border-bottom:#CCCCCC solid 1px;">
			<div style="float:left; width:390px; display:block;"><?=$sub_category_name;?></div>
			<div style="float:left; width:70px; display:block; text-align:right;">
			<span class="ctrl_btn" title="Edit <?=$sub_category_name;?>" onClick="editCategories('subcat',<?=$sub_category_id;?>)">
			<img src="./images/b_edit.png"></span>&nbsp;
			<span class="ctrl_btn" title="Delete <?=$sub_category_name;?>" onClick="deleteCategory('subcat',<?=$sub_category_id;?>)"><img src="./images/delete.png"></span>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?
}
?>