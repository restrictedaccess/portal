<?php
include '../conf/zend_smarty_conf.php';
$userid = $_REQUEST["userid"];
$english_comm = $_REQUEST["english_communication"];

//before
$old = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_REQUEST["userid"]));
unset($old["dateupdated"]);

$data = array("english_communication_skill"=>$english_comm, "dateupdated"=>date("Y-m-d H:i:s"));

$db->update("personal", $data, $db->quoteInto("userid = ?", $userid));

$new = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_REQUEST["userid"]));
unset($new["dateupdated"]);

$difference = array_diff_assoc($old,$new);
			
$history_changes = "";
if( count($difference) > 0){
	foreach(array_keys($difference) as $array_key){
		$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
	}          
	include_once "../time.php";
	$status = "HR";
	if ($_SESSION["status"]=="FULL-CONTROL"){
		$status = "ADMIN";
	}
	$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_id"=>$_SESSION["admin_id"], "change_by_type"=>$status));
	
}
?>
<script type="text/javascript">
	alert("English communication skill has been updated");
	window.location.href = "/portal/admin_updatelanguages.php?userid=<?php echo $userid?>";
</script>
