<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$leads_id = $_REQUEST['leads_id'];
$testimony_id = $_REQUEST['testimony_id'];


$queryClient="SELECT CONCAT(l.fname,' ',SUBSTRING(l.lname,1,1),'.')	FROM leads l  WHERE l.id = $leads_id;";

$result=mysql_query($queryClient);
if(!$result) die ("Error in Script.<br>".$queryClient);
list($client_name)=mysql_fetch_array($result);

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
	<b><?=$txt;?> Testimonials for Client <?=$client_name;?></b></div>
	<div style="float:right;text-align:right;"><a href="javascript:hide('show_testimonial_form_for_<?=$leads_id;?>');" title="close" style="text-decoration:none;">[ x ]</a></div>
	<div style="clear:both;"></div>
</div>	

<div style="text-align:center;">
<textarea id="staff_tetimony_for_<?=$leads_id;?>" name="staff_tetimony_for_<?=$leads_id;?>" class="select" style="width:390px; height:150px;"><?=$row['testimony'];?></textarea>
</div>
<? if($testimony_id > 0){ ?>
	<input type="button" value="Update" onclick="updateStaffTestimonialForClient(<?=$leads_id;?>,<?=$testimony_id;?>)" />
<? } else {?>
	<input type="button" value="Submit" onclick="saveStaffTestimonialForClient(<?=$leads_id;?>)" />
<? }?>
<input type="button" value="Cancel" onclick="javascript:hide('show_testimonial_form_for_<?=$leads_id;?>');" />

	
</div>