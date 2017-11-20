<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['client_id']!="")
{
	$user = $_SESSION['client_id'];
	$type = 'leads';
	
}
else if($_SESSION['userid']!="")
{
	$user = $_SESSION['userid'];
	$type = 'subcon';
	
}
else if($_SESSION['admin_id']!="")
{
	$user = $_SESSION['admin_id'];
	$type = 'admin';
}
else if($_SESSION['agent_no']!="")
{
	$user = $_SESSION['agent_no'];
	$type = 'agent';
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

?>
<div>
<textarea id="reply" name="reply" class="select" style="width:800px; height:80px;"><?=$row['testimony_reply'];?></textarea>
</div>
<div>
<input type="button"  value="save" onclick="saveReply(<?=$id;?>,'<?=$mode;?>')" />
<input type="button"  value="cancel" onclick="hide('<?=$mode;?>_reply_form_<?=$id;?>')" />
</div>