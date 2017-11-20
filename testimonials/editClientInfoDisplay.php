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

$query="SELECT fname,lname,company_name,logo_image FROM leads WHERE id=$leads_id;";
$data=mysql_query($query);
list($fname,$lname, $company_name , $logo_image) = mysql_fetch_array ($data); 
$client_name = $fname." ".substr($lname,0,1).".";


if($id > 0){
$sqlDisplay = "SELECT * FROM testimonials_display_info WHERE id = $id ;";
}else{
$sqlDisplay = "SELECT * FROM testimonials_display_info 
		WHERE for_id = $leads_id AND for_by_type = 'leads' AND recipient_id = $userid AND recipient_type = 'subcon';";
}		
	//echo $sqlDisplay;	
$resulDisplay = mysql_query($sqlDisplay);
if(!$resulDisplay) die ("Error in Script.\n".$sqlDisplay);	
if(mysql_num_rows($resulDisplay) > 0){
	$row = mysql_fetch_array($resulDisplay);	
	$display_name = $row['display_name'];
	$display_desc = $row['display_desc'];
}else{
	$display_name = $client_name;
	$display_desc = $company_name;
}

?>
<div style="display:block; position:absolute; background:#FFFFFF; border:#333333 solid 5px; padding:5px; width:400px;">
<p><b style="color:#FF0000;">Edit Display Information</b></p>
<p><label><b>Name : </b></label><input class="select" type="text" id="client_display_name_<?=$userid;?>" name="client_display_name_<?=$userid;?>" value="<?=$display_name;?>"></p>
<p><label><b>Company Name :</b></label><input class="select" type="text" id="client_display_company_name_<?=$userid;?>" name="client_display_company_name_<?=$userid;?>" value="<?=$display_desc;?>"></p>
<p>
<input type="button"  value="update" onClick="updateClientInfoDisplay(<?=$userid;?>,<?=$id;?>)">
<input type="button"  value="cancel" onClick="hide('client_info_details_id_<?=$userid;?>');"></p>
</div>