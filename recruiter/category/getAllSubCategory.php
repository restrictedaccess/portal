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
$admin_id = $_SESSION['admin_id'];
$category_id =$_REQUEST['category_id'];



//Get All Sub-Category
//sub_category_id, category_id, sub_category_name, sub_category_date_created
$sql="SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id = $category_id;";
$data = 	mysql_query($sql);	
while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($data))
{
	?>
		<div style=" float:left; padding:2px; border-bottom:#CCCCCC solid 1px;">
			<div style="float:left; width:200px; display:block;"><?=$sub_category_name;?></div>
			<span style="float:left; display:block; text-align:right;"><span class="ctrl_btn" title="Edit <?=$sub_category_name;?>" onClick="editCategories('subcat',<?=$sub_category_id;?>)"><img src="./images/b_edit.png"></span></span>
			<div style="clear:both;"></div>
		</div>
	<?
}
?>