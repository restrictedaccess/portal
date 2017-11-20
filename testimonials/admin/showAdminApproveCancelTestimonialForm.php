<?
include "../../config.php";
include "../../conf.php";
include "../../time.php";
include "../../function.php";



$created_by_id = $_REQUEST['created_by_id'];
$created_by_type = $_REQUEST['created_by_type'];

$recipient_id = $_REQUEST['recipient_id'];
$recipient_type = $_REQUEST['recipient_type'];


$testimony_id = $_REQUEST['testimony_id'];

if($created_by_type == "subcon"){
	$query="SELECT CONCAT(fname,' ',SUBSTRING(lname,1,1),'.')	FROM personal   WHERE userid = $created_by_id;";
	$div = "show_testimonial_form_for_".$recipient_id;
}
if($created_by_type == "leads"){
	$query="SELECT CONCAT(l.fname,' ',SUBSTRING(l.lname,1,1),'.')	FROM leads l  WHERE l.id = $created_by_id;";
	$div = "show_testi_form_for_".$created_by_id;
}


$result=mysql_query($query);
if(!$result) die ("Error in Script.<br>".$query);
list($name)=mysql_fetch_array($result);

$txt = "Create ";
//echo $testimony_id;
if($testimony_id > 0){
	$query = "SELECT * FROM testimonials WHERE testimony_id = $testimony_id;";
	$data = mysql_query($query);
	$row = mysql_fetch_array($data);
	$txt= "Update ";
}

$statusArray = array('posted','cancel');
$statusArrayName = array('POST','CANCEL');
for($i=0;$i<count($statusArray);$i++){
	if($row['testimony_status']==$statusArray[$i]){
		$statusOptions.="<option selected value=\"$statusArray[$i]\">".$statusArrayName[$i]."</option>";
		
	}else{
		$statusOptions.="<option value=\"$statusArray[$i]\">".$statusArrayName[$i]."</option>";
	}
}
?>

<div class="approve_testimonial_form" >
<div>
	<div style=" float:left;">
	<b>Approved / Cancel Testimonial for <?=$name;?></b></div>
	<div style="float:right;text-align:right;">
	<a href="javascript:hide('<?=$div;?>');" title="close" style="text-decoration:none;">[ x ]</a>
	</div>
	<div style="clear:both;"></div>
</div>	
<div style="margin-top:20px; margin-bottom:20px;">
<select id="testimonial_status_for_<?=$recipient_id;?>" name="testimonial_status_for_<?=$recipient_id;?>" class="select" style=" width:80px;" onchange="showStatusTxt(<?=$recipient_id;?>);">
<option value="">--</option>
<?=$statusOptions;?>
</select><span id="testimonial_status_txt_for_<?=$recipient_id;?>"></span>

</div>
<input id="button_for_<?=$recipient_id;?>"  type="button" value="<?=$txt;?>" onclick="ApproveCancelTestimonial(<?=$created_by_id;?>,'<?=$created_by_type;?>',<?=$recipient_id;?>,'<?=$recipient_type;?>',<?=$testimony_id;?>)" />
<input type="button" value="Cancel" onclick="javascript:hide('<?=$div;?>');" />

	
</div>