<?php
include 'conf.php';
include 'config.php';

$type = @$_REQUEST["type"];
$id = @$_REQUEST["id"];

if($type == "ARCHIVE")
{
	$query="UPDATE tb_admin_activity_tracker_notes SET status='ARCHIVED' WHERE id='$id'";
	$result=mysql_query($query);
}
else
{
	$query="DELETE FROM tb_admin_activity_tracker_notes WHERE id='$id'";
	$result=mysql_query($query);
}
?>