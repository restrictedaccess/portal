<?php
include 'config.php';
include 'conf.php';

if(isset($_SESSION['admin_id']) || isset($_SESSION['agent_no']))
{
	$code_number = @$_REQUEST["code_number"];
	$limit_of_use = @$_REQUEST['limit_of_use'];
	mysql_query("UPDATE voucher SET limit_of_use='$limit_of_use' WHERE code_number='$code_number' LIMIT 1");
}	
?>