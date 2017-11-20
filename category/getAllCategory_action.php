
<?
include '../config.php';
include '../conf.php';

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}
$admin_id = $_SESSION['admin_id'];
$query = "SELECT DISTINCT(COUNT(u.userid)) AS numrows FROM personal u;";
$result = mysql_query($query);
list($numrows)=mysql_fetch_array($result);
?>
<div style="float:left;">
<div style="display:block;" >
	<div style="float:left;"><img src="./images/folder_clip.gif" /></div>
	<div style="float:left; margin-left:10PX; display:block; width:210px; color:#0033FF; " ><a href="adminadvertise_positions.php"><b>All Registered Applicants</b></a> (<?=$numrows;?>)</div>
	<div style="clear:both;"></div>
</div>
<div id="applicant" style="margin-left:30px;">
	<li>Unprocessed</li>
	<li>Prescreened</li>
	<li>Short Listed</li>
	<li>Hired</li>
	<li>Rejected</li>
</div>
</div>
<?
// Get All Categories
$query = "SELECT category_id, category_name FROM job_category ORDER BY category_name ASC;";
$result = mysql_query($query);
$counter=0;
while(list($category_id, $category_name)=mysql_fetch_array($result))
{
	$counter++;
?>
	<div style="float:left; margin-left:10px;display:block;" onmouseover="show_controls('<?=$category_id;?>')" onmouseout="hide_controls('<?=$category_id;?>')">
	<div>
		<div style="float:left;"><img src="./images/folder_clip.gif" /></div>
		<div style="float:left; margin-left:10PX; display:block; color:#0033FF; cursor:pointer; "  ><b><?=$category_name;?></b></div>
		<div style="clear:both;"></div>
	</div>
	<div id="<?=$category_id;?>" style="display:none;" onmouseover="show_controls('<?=$category_id;?>')" >
<span class="ctrl_btn" title="Add Sub-Category <?=$category_name;?>" onClick="addSubCategories(<?=$category_id;?>);"><img src="./images/category/add.png"></span>
&nbsp;<span class="ctrl_btn" title="Edit <?=$category_name;?>" onClick="editCategories('cat',<?=$category_id;?>)"><img src="./images/category/b_edit.png"></span>
&nbsp;<span class="ctrl_btn" title="Delete <?=$category_name;?>" onClick="deleteCategories('cat',<?=$category_id;?>)"><img src="./images/category/delete.png"></span>
	<?
			//Get All Sub-Category
			//sub_category_id, category_id, sub_category_name, sub_category_date_created
			$sql="SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id = $category_id;";
			$data = 	mysql_query($sql);	
			while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($data))
			{
				// count the applicants in the job_sub_category_applicants
				$queryCount = "SELECT COUNT(userid) FROM job_sub_category_applicants WHERE sub_category_id = $sub_category_id;";
				$res =mysql_query($queryCount);
				list($count)=mysql_fetch_array($res);
				
				?>
					<li><a href="adminadvertise_category_action.php?t10_category_id=<?=$sub_category_id;?>&t10_category_name=<?=$sub_category_name;?>" target="_parent"><?=$sub_category_name;?></a> (<?=$count;?>)</li>						
				<?
			}
		?>
	</div>	
	
	
	
	</div>
<? 
}
?>


<div style="clear:both;"></div>
