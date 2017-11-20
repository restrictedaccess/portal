<?php
include 'config.php';
include 'conf.php';
$id = @$_REQUEST["id"];
$counter = 0;
$query = mysql_query("SELECT status FROM tb_client_account_settings WHERE client_id='$id'");
while ($row = mysql_fetch_assoc($query)) 
{
	$status = $row["status"];
	if($status == "NONE")
	{
		echo "NOTE: Client's activity tracker notes status is currently disabled.";
	}
	else
	{
		echo "";	
	}
	$counter = 1;
}
if($counter == 0) echo "NOTE: Client Settings not Found!";
?>