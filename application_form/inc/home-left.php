<div id="vid" style="margin-top:0px;">
<img src="images/it-vid.jpg" border="0" style="padding-bottom:10px; cursor:pointer" onClick="window.open('remotestaff_presentation.php','_blank','width=510,height=450,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');"/>
<p><strong>Remote Staff</strong> Presentation</p>
</div> <!-- End of Vid 2 -->
<img src="images/icon-latest-job.jpg" />

<div id="staffclass">
<table width="100%" cellpadding="0" cellspacing="0">

<?php
//parse all advertisement category
//jr_cat_id, cat_name
$script_file_name = "jobopenings.php";
$sql = $db->select()
	->from('job_role_category');
$categories = $db->fetchAll($sql);	
foreach($categories as $category){

if($_GET['jr_cat_id'] == $category['jr_cat_id']){
	$display = "block";
}else{
	$display = "block";
}
?>
<tr id="tr_<?php echo $category['jr_cat_id'];?>" style="background:url(images/avail-staff-left-title-expanded.jpg);">
<td height="30" align="right" style="padding-right:5px; color:#FFFFFF; font-weight:bold; cursor:pointer;" onclick="MinMax(<?php echo $category['jr_cat_id'];?>)"><?php echo $category['cat_name'];?></td>
</tr>

<tr>
<td align="right" style="padding-right:5px;">

<div id="tr_sub_<?php echo $category['jr_cat_id'];?>" style="display:<?php echo $display;?>">
<ul>
	<?php
	$query = $db->select()
		->from('job_category')
		->where('job_role_category_id =?' , $category['jr_cat_id'])
		->where('status != ?','removed');
	$sub_cats = $db->fetchAll($query);
	$counter =0;
	foreach($sub_cats as $sub_cat){
	$counter++;
	?>
	<li><a href="<?php echo $script_file_name."?jr_cat_id=".$category['jr_cat_id']."&category_id=".$sub_cat['category_id'];?>"><?php echo $sub_cat['category_name'];?></a></li>
	<?php } ?>
</ul>
</div>  
</td>
</tr>

<?php } ?>

</table>
</div>

<!--
<a href="adhocstaffing.php"><img src="images/btn-adhocstaffing.jpg" border="0" /></a><br />&nbsp;
-->
<a href="javascript:popup_win('http://vps01.remotestaff.biz:5080/rschat/bin-debug/rslivechat.html',800,600);"><img src="images/icon-livechat.jpg" width="170" height="60" border="0" /></a>