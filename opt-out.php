<?php

function opt_out($zig_hash)
{	
	require_once("hash.lib.php") ;
	$hashing = new zig_hash ;
	$email = $hashing->hash("hash","decrypt",$zig_hash) ;
	update_db($email['value']) ;
}

function update_db($email)
{
	//include("db.php") ;
	include 'config.php';
	include 'conf.php';
	//$db = sql_connect() ;
	$sql = "UPDATE leads SET opt='out' WHERE email='$email'" ;
	//echo $sql;
	$query = mysql_query($sql) ;
}

$zig_hash = $_GET['zig_hash'] ;

if($zig_hash)
{
	opt_out($zig_hash) ;
	print "You have been removed from the mailing list!" ;
}

?>