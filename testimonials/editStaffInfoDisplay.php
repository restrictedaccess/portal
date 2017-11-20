<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$leads_id = $_REQUEST['leads_id'];
$userid = $_REQUEST['userid'];
$id = $_REQUEST['id'];


$queryStaff="SELECT CONCAT(u.fname,' ',SUBSTRING(u.lname,1,1),'.'),u.image,c.latest_job_title
		FROM personal u
		LEFT OUTER JOIN currentjob c ON c.userid = u.userid
		WHERE u.userid = $userid;";
//echo $queryStaff;		
$result=mysql_query($queryStaff);
if(!$result) die ("Error in Script.<br>".$queryStaff);
list($staff_name, $image ,$latest_job_title )=mysql_fetch_array($result);


if($id > 0){
$sqlDisplay = "SELECT * FROM testimonials_display_info WHERE id = $id ;";
}else{
$sqlDisplay = "SELECT * FROM testimonials_display_info 
		WHERE for_id = $userid AND for_by_type = 'subcon' AND recipient_id = $leads_id AND recipient_type = 'leads';";
}		
//echo $sqlDisplay;	
$resulDisplay = mysql_query($sqlDisplay);
if(!$resulDisplay) die ("Error in Script.\n".$sqlDisplay);	
if(mysql_num_rows($resulDisplay) > 0){
	$row = mysql_fetch_array($resulDisplay);	
	$display_name = $row['display_name'];
	$display_desc = $row['display_desc'];
}else{
	$display_name = $staff_name;
	$display_desc = $latest_job_title;
}
?>
<div style="display:block; position:absolute; background:#FFFFFF; border:#333333 solid 5px; padding:5px; width:400px;">
<p><b style="color:#FF0000;">Edit Display Information</b></p>
<p><label><b>Name : </b></label><input class="select" type="text" id="staff_display_name_<?=$leads_id;?>" name="staff_display_name_<?=$leads_id;?>" value="<?=$display_name;?>"></p>
<p><label><b>Company Name :</b></label><input class="select" type="text" id="staff_display_company_name_<?=$leads_id;?>" name="staff_display_company_name_<?=$leads_id;?>" value="<?=$display_desc;?>"></p>
<p>
<input type="button"  value="update" onClick="updateStaffInfoDisplay(<?=$leads_id;?>,<?=$id;?>)">
<input type="button"  value="cancel" onClick="hide('staff_info_details_id_<?=$leads_id;?>');"></p>
</div>