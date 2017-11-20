<?php
include('conf/zend_smarty_conf_root.php');


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id'] == "" or $_SESSION['admin_id'] == NULL){
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);

$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
$session_email = $admin['admin_email'];
$created_by_id = $_SESSION['admin_id'];
$created_by_type = 'admin';



if(isset($_POST['allocate'])){
	for ($i = 0; $i < count($_POST['category_id']); ++$i){
		if($_POST['category_id'][$i]!=""){
			if($_POST['job_role_category_id'][$i]!=""){
				if($_POST['job_role_category_id'][$i]!="removed"){				
						$data = array(
									'job_role_category_id' => $_POST['job_role_category_id'][$i],
									'status' => 'posted',
									'created_by' => $_SESSION['admin_id'] ,
									'category_date_created' => $ATZ
								);
						$where = "category_id = ".$_POST['category_id'][$i];	
						$db->update('job_category' ,  $data , $where);
				}else{
						$data = array(
									'status' => 'removed',
									'created_by' => $_SESSION['admin_id'] ,
									'category_date_created' => $ATZ
								);
						$where = "category_id = ".$_POST['category_id'][$i];	
						$db->update('job_category' ,  $data , $where);
				}
			}
		}
	}
}















//echo $session_name;
//SELECT * FROM job_role_category
//jr_cat_id, cat_name
$sql = $db->select()
	->from('job_role_category');
$categories = $db->fetchAll($sql);	
foreach($categories as $category){
	$category_Options .="<option value='".$category['jr_cat_id']."' >".$category['cat_name']."</option>";
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Category Management</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="category-management/media/css/category-management.css">

<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="category-management/media/js/category-management.js"></script>

</head>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="category-management.php">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td valign="top" style="padding:10px;">

<div id="no_job_role_category_id" >
<?php 
//Sub Categories check
//category_id, job_role_category_id, category_name, created_by, category_date_created
$query = $db->select()
	->from('job_category')
	->where('status != ?' , 'removed');
//echo $query;exit;	
$sub_categories = $db->fetchAll($query);
foreach($sub_categories as $sub_category){
	if($sub_category['job_role_category_id'] == "" or $sub_category['job_role_category_id'] == NULL){
		$no_job_role_category_id++;
	}
}

if($no_job_role_category_id > 0 ) {?>
<p><b>There are <?php echo $no_job_role_category_id;?> Advertisement Sub Categories that are not yet allocated in any of the available category.</b></p>
<table align="center" width="70%" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
<?php
$i=0;
foreach($sub_categories as $sub_category){
	if($sub_category['job_role_category_id'] == "" or $sub_category['job_role_category_id'] == NULL){
		$counter++;	
		
		echo "<tr bgcolor='#FFFFFF'>
				<td width='5%' align='left'>".$counter."</td>
				<td width='55%' align='left'>".$sub_category['category_name']."</td>
				<td width='40%' align='left'><input type='hidden' name='category_id[$i]' value='".$sub_category['category_id']."' /><select name='job_role_category_id[$i]' style='width:200px;'><option value=''>Please Select</option>$category_Options<option value='removed'>*REMOVED*</option></select>
</td>
			  </tr>";
		$i++;	  
	}
}
?>


<tr bgcolor="#FFFFFF"><td colspan="3" align='left'><input type="submit" name="allocate" value="Allocate" /></td></tr>
</table>
<?php }?>
</div>


<div class="hdr-ava" >Available Categories</div>
<?php
//parse all advertisement category
//SELECT * FROM job_role_category
//jr_cat_id, cat_name
$sql = $db->select()
	->from('job_role_category');
$categories = $db->fetchAll($sql);	

foreach($categories as $category){
?>
		<span class="toggle-btn" onClick="toggle('<?php echo $category['jr_cat_id'];?>_box')">SHOW / HIDE</span>
		<span class="toggle-btn" style="margin-right:5px;" onClick="javascript:EditCategoryName(<?php echo $category['jr_cat_id'];?>)">EDIT</span>
		<span class="toggle-btn" onClick="javascript:ShowAddEditForm(<?php echo $category['jr_cat_id'];?>, 'add' , 0)">ADD</span>
		
		<h2 id="<?php echo $category['jr_cat_id'];?>_name"><?php echo $category['cat_name'];?></h2>
		<div id="<?php echo $category['jr_cat_id'];?>_edit_div" class="add_div"></div>
		<div id="<?php echo $category['jr_cat_id'];?>_box"  style="margin-bottom:20px;">
		<div id="<?php echo $category['jr_cat_id'];?>_add_div" class="add_div"></div>
		<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
		<?php
		//parse all Advertisement Category sub-categories
		//SELECT * FROM job_category j;
		//category_id, job_role_category_id, category_name, created_by, category_date_created
		$query = $db->select()
			->from('job_category')
			->where('job_role_category_id =?' , $category['jr_cat_id'])
			->where('status != ?','removed');
		$sub_cats = $db->fetchAll($query);
		if(count($sub_cats) > 0){
			$counter =0;
			foreach($sub_cats as $sub_cat){
			$counter++;
			echo "<tr bgcolor='#FFFFFF'>
				<td width='5%' align='left'>".$counter."</td>
				<td width='35%' align='left'>".$sub_cat['category_name']."</td>
				<td width='60%' align='left'><a href=\"javascript:ShowAddEditForm(".$category['jr_cat_id'].", 'update' ,".$sub_cat['category_id'].")\">edit</a> | <a href=\"javascript:RemoveSubCat(".$category['jr_cat_id'].", ".$sub_cat['category_id'].")\">remove</a></td>
			  </tr>";
			}  
		}else{
			echo "<tr bgcolor='#FFFFFF'><td colspan='4' align='center'>There are no <b>[ ".$category['cat_name']."-Category ]</b> sub categories to be shown</td></tr>";
		}	
		
		
		?>
		</table>
		</div>

<?php	
}

?>


</td>
</tr>
</table>
</form>
</body>
</html>
