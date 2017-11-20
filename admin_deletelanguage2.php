<?php

include 'config.php';
include 'conf.php';
include 'conf/zend_smarty_conf.php';

$id=$_REQUEST['id'];
$userid=$_REQUEST['userid'];
//echo $id."<br>";
//echo $userid."<br>";


$db->delete('language',"id = ".$id." AND userid = ".$userid);
header("location:admin_updatelanguages.php?userid=".$userid);
exit;

$query="DELETE FROM language WHERE id = $id AND userid = $userid;";
$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		header("location:admin_updatelanguages.php?userid=".$userid."mess=$mess");
	}
	else
	{
		header("location:admin_updatelanguages.php?userid=".$userid);
	}


?>
