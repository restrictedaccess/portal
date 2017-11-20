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
?>

<div style="background:#FFFFFF; border:#0033FF solid 5px; padding:5px;">
<div><b><u>Upload Logo or Company Image</u></b></div>
<p><input type="file" id="img" name="img" class="select"></p>
<p><input type="submit" value="upload" name="upload" id="upload"> <input type="button" value="cancel" onclick="hide('image_form_<?=$userid;?>')" /></p>

</div>