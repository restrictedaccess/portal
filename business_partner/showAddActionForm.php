<?
include '../config.php';
include '../conf.php';
include '../function.php';
include '../time.php';


$agent_no = $_SESSION['agent_no'];
$action = $_REQUEST['action'];
$leads_id=$_REQUEST['leads_id'];
$mode = $_REQUEST['mode'];
$id =$_REQUEST['id'];
if($id==""){
	$id=0;
}
if($mode=="new")
{
	$button ='<input type="button" class="new_button" name="button" value="Save" onClick="saveActionDetails()" class="new_button">';
}
if($mode=="update")
{
	$query ="SELECT history, DATE_FORMAT(date_created,'%D %b %Y'),subject,actions FROM history WHERE id = $id;";
	$result=mysql_query($query);
	list($history,$date,$subject,$action)= mysql_fetch_array($result);
	$desc= str_replace("\n\r","<br>",$desc);
	$button ='<input type="button" class="new_button" name="button" value="Update" onClick="updateActionDetails()" class="new_button">';
}


if($_SESSION['agent_no']=="")
{
	die("Your Session has timeout Please Re-Login again..");
}
if($leads_id=="")
{
	die("Lead ID is missing..!");
}


?>
<div id="action_form">
<input type="hidden" name="history_id" id="history_id" value="<?=$id;?>">
<? if ($date!="") { ?>
<p><label>Date Created :</label><?=$date;?></p>
<? }?>
<p><label>Option :</label><?=$action;?></p>
<p><label>Subject :</label><input type="text" name="subject" id="subject" style="width:300px; font:11px tahoma;"  value="<?=$subject ? $subject : '[ Type Subject Here ]';?>"></p>
<p><label>Message :</label><textarea name="details" id="details" rows="5"><?=$history;?></textarea></p>
<p><?=$button;?> <input type="button" class="new_button" name="canecel" value="Cancel" onClick="hideAddActionForm(<?=$id;?>);"></p>
</div>