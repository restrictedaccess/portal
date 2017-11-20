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

$admin_id = $_SESSION['admin_id'];
$category_id = $_REQUEST['category_id'];
$sub_category = $_REQUEST['sub_category'];

if($category_id==NULL || $category_id ==""){
	die("Category ID is Missing.");
}

/*
job_sub_category
sub_category_id, category_id, sub_category_name, sub_category_date_created
*/

$query = "INSERT INTO job_sub_category SET category_id = $category_id, sub_category_name = '$sub_category', sub_category_date_created = '$ATZ';";
$result=mysql_query($query);
if(!$result){
	die($query."<br>".mysql_error());
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