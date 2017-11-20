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

$category = $_REQUEST['category'];
//echo $category;

/*
TABLE : job_category
category_id, category_name, created_by, category_date_created
*/

$query = "INSERT INTO job_category SET category_name = '$category', created_by = $admin_id, category_date_created = '$ATZ';";
$result = mysql_query($query);
if($result){
	echo "<p align='center'>New Category has been saved</p>";
	$category_id = mysql_insert_id();
}else{
	die($query."<br>".mysql_error());
}



$query = "SELECT category_name FROM job_category WHERE category_id = $category_id;";
$result = mysql_query($query);
list($category_name)=mysql_fetch_array($result);
?>
<div style="background:#CCCCCC; border:#999999 outset 1px; padding:3px; font-weight:bold;">Add Sub-Category</div>
<input type="hidden" name='category_id' id="category_id" value="<?=$category_id?>" />
		<div style="padding:20px;">
		<p><label>Category :</label><?=$category_name;?></p>
		<p><label>Sub - Category :</label> <input type="text" id="sub_category"  class="select"></p>
		<p><input type="button" value="Add" id="add_btn" onClick="addSubCategory();"  >&nbsp; <input type="button" value="Cancel" onClick="show_hide('create_category_form')"  ></p>
		</div>
		<div style="background:#CCCCCC; border:#CCCCCC outset 1px;"><?=$category_name;?></div>
		<div id="sub_category_list" class="scroll">&nbsp;
		</div>	
	</div>