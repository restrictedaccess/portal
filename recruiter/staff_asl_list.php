<?php
include('../config.php') ;
include('../conf.php') ;
include('../conf/zend_smarty_conf_root.php');

$id = $_REQUEST["id"];
$userid = $_REQUEST["userid"];
$action = $_REQUEST["action"];

if($action == "delete")
{
	$where = "id = ".$id;	
	$db->delete('job_sub_category_applicants', $where);		
}

//START: ASL categories
$asl_categories .= '
<table width=100%>			
	<tr>
		<td class="td_info td_la" width=0>#</td>
		<td class="td_info td_la" width=20%>Category</td>
		<td class="td_info td_la" width=20%>Sub Category</td>
		<td class="td_info td_la" width=20%>ASL</td>
		<td class="td_info td_la" width=20%>Date Created</td>
		<td class="td_info td_la" width=20%></td>
</tr>';									
$q = "SELECT id, category_id, sub_category_id, ratings, DATE_FORMAT(sub_category_applicants_date_created,'%D %b %y') FROM job_sub_category_applicants WHERE userid='$userid'";
$result = mysql_query($q);
$counter = 0;
while(list($id, $category_id, $sub_category_id, $ratings, $sub_category_applicants_date_created)=mysql_fetch_array($result))
{
	$counter++;
	$cat = "SELECT category_name FROM job_category WHERE category_id='$category_id'";
	$cat_result = mysql_query($cat);
	while(list($category_name)=mysql_fetch_array($cat_result))
	{			
		$category_name_display = $category_name;
	}	
	$cat = "SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='$sub_category_id'";
	$cat_result = mysql_query($cat);
	while(list($sub_category_name)=mysql_fetch_array($cat_result))
	{
		$sub_category_name_display = $sub_category_name;
	}
	if($ratings==1)
	{
		$rating_value = '<option value="1" selected>No</option><option value="0">Yes</option>';
	}
	else
	{
		$rating_value = '<option value="1">No</option><option value="0" selected>Yes</option>';
	}
	$asl_categories .= '
	<tr>
		<td class="td_info td_la">'.$counter.'</td>
		<td class="td_info">'.$category_name_display.'</td>
		<td class="td_info">'.$sub_category_name_display.'</td>
		<td class="td_info">
			<select name="star" style="font:10px tahoma;" onChange="javascript: update_asl_visiblity('.$id.', this.value);" >
				<option value="">-</option>
				'.$rating_value.'
			</select>											
		</td>
		<td class="td_info">'.$sub_category_applicants_date_created.'</td>
		<td class="td_info" align=right><a href="javascript: delete_asl('.$userid.','.$id.'); "><font size=1>Delete</font></a></td>
	</tr>';
}
$asl_categories .= '</table>';
if($counter == 0) $asl_categories = "";
echo $asl_categories;
//ENDED: ASL categories

?>