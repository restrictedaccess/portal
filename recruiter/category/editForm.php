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

if($table=="cat"){
	$query = "SELECT category_name FROM job_category WHERE category_id = $id;";
	$result = mysql_query($query);
	list($name)=mysql_fetch_array($result);
	$category = "Category";

}

if($table=="subcat"){
	$query = "SELECT sub_category_name, classification FROM job_sub_category WHERE sub_category_id = $id;";
	$result = mysql_query($query);
	list($name, $classification)=mysql_fetch_array($result);
	$category = "Sub-Category";

}
?>
<div style="background:#CCCCCC; border:#999999 outset 1px; padding:3px; font-weight:bold;">Update <?=$category;?></div>
<div style="padding:20px;">
	<p><label><?=$category;?> :</label> <input type="text" id="name" value="<?=$name;?>"  class="select"></p>
	<p>
		<label>Classification :</label>
		<select id="classification" name="classification">
			<?php if($classification == 'it'): ?>
				<option value="it" selected="selected">I.T.</option>
				<option value="non it">Non I.T.</option>
			<?php else: ?>
				<option value="it">I.T.</option>
				<option value="non it" selected="selected">Non I.T.</option>
			<?php endif; ?>
		</select> 
	</p>
	<p><input type="button" value="Update" id="update_btn" onClick="updateCategory('<?=$table;?>',<?=$id;?>);"  >&nbsp;
	  <input name="button" type="button" onClick="show_hide('create_category_form')" value="Cancel"  >
	</p>
</div>	
