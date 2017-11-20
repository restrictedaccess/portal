<?
include '../config.php';
include '../conf.php';

$quote_details_id = $_REQUEST['quote_details_id'];
?>
<div style="width:400px; background:#FFFFFF; position:absolute;">
	<div style="background:#CCCCCC; border:#999999 outset 1px; padding:5px;"><b>Add Notes</b></div>
		<div style="border:#999999 solid 1px; padding:10px;">
		<p><textarea class="select" id="message" rows="4" style="width:380px;" ></textarea></p>
		<p> <input type="button" class="btn" value="Save Message" onClick="saveMessage(<?=$quote_details_id;?>);"> <input type="button" value="Cancel" onClick="hide('message_form');"></p>
		</div>
</div>