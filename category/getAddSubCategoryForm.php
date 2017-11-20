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
$category_id =$_REQUEST['category_id'];



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
		<div id="sub_category_list" class="scroll">
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
		</div>	
	</div>
