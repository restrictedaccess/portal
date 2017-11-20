<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']!="")
{
	$user = $_SESSION['admin_id'];
	$type = 'admin';
}
else{
	die("Session Expired. Please re-login again.");
}

//echo $type;
$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

if($mode == "update"){
	$query = "SELECT * FROM testimonials_reply WHERE testimony_reply_id = $id;";
	$result =mysql_query($query);
	$row = mysql_fetch_array($result);
}


$testimony_statusArray=array('new','posted','cancel','updated','delete');
for($i=0;$i<count($testimony_statusArray);$i++){
	if($row['testimony_reply_status'] == $testimony_statusArray[$i]){
		$statusOptions.="<option selected value=\"$testimony_statusArray[$i]\">$testimony_statusArray[$i]</option>\n";
	}else{
		$statusOptions.="<option value=\"$testimony_statusArray[$i]\">$testimony_statusArray[$i]</option>\n";
	}
}

?>
<div>
Status : <select name="testimony_status_<?=$mode;?>_<?=$id;?>" id="testimony_status_<?=$mode;?>_<?=$id;?>" class="select">
				<?=$statusOptions;?>
			</select>
</div>

<div>
<textarea id="reply_<?=$mode;?>_<?=$id;?>" name="reply_<?=$mode;?>_<?=$id;?>" class="select" style="width:800px; height:80px;"><?=$row['testimony_reply'];?></textarea>
</div>
<div>
<?
if($mode=="save"){
?>
<input type="button"  value="save" onclick="saveAdminReply(<?=$id;?>,'<?=$mode;?>')" />
<input type="button"  value="cancel" onclick="hide('<?=$mode;?>_reply_form_<?=$id;?>')" />
<? } else { ?>
<input type="button"  value="update" onclick="updateAdminReply(<?=$id;?>,'<?=$mode;?>')" />
<input type="button"  value="cancel" onclick="hide('<?=$mode;?>_reply_form_<?=$id;?>')" />
<? }?>

</div>