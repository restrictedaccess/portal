<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$userid = $_REQUEST['userid'];
$testimony_id = $_REQUEST['testimony_id'];


$queryStaff="SELECT CONCAT(u.fname,' ',SUBSTRING(u.lname,1,1),'.')	FROM personal u WHERE u.userid = $userid;";
//echo $queryStaff;
$result=mysql_query($queryStaff);
if(!$result) die ("Error in Script.<br>".$queryStaff);
list($staff_name)=mysql_fetch_array($result);
$txt = "Create ";
//echo $testimony_id;
if($testimony_id > 0){
	$query = "SELECT * FROM testimonials WHERE testimony_id = $testimony_id;";
	$data = mysql_query($query);
	$row = mysql_fetch_array($data);
	$txt= "Update ";
}
?>

<div class="testimonial_form" >
<div>
	<div style=" float:left;">
	<b><?=$txt;?> Testimonials for Staff <?=$staff_name;?></b></div>
	<div style="float:right;text-align:right;"><a href="javascript:hide('show_testimonial_form_for_<?=$userid;?>');" title="close" style="text-decoration:none;">[ x ]</a></div>
	<div style="clear:both;"></div>
</div>	

<div style="text-align:center;">
<textarea id="client_tetimony_for_<?=$userid;?>" name="client_tetimony_for_<?=$userid;?>" class="select" style="width:390px; height:150px;"><?=$row['testimony'];?></textarea>
</div>
<? if($testimony_id > 0){ ?>
	<input type="button" value="Update" onclick="updateClientTestimonialForStaff(<?=$userid;?>,<?=$testimony_id;?>)" />
<? } else {?>
	<input type="button" value="Submit" onclick="saveClientTestimonialForStaff(<?=$userid;?>)" />
<? }?>
<input type="button" value="Cancel" onclick="javascript:hide('show_testimonial_form_for_<?=$userid;?>');" />

	
</div>