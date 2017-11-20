<?php

function authenticate($zig_hash)
{	
	require_once("hash.lib.php") ;
	$hashing = new zig_hash ;
	$email = $hashing->hash("hash","decrypt",$zig_hash) ;
	update_db($email['value']) ;
}

function update_db($email)
{
	//include("db.php") ;
	
	//$db = sql_connect() ;
	include 'config.php';
	include 'conf.php';
	$sql = "UPDATE leads SET authenticate='confirmed' WHERE email='$email'" ;
	//echo $sql; 
	$query = mysql_query($sql) ;
}

$zig_hash = $_GET['zig_hash'] ;

if($zig_hash)
{
	authenticate($zig_hash) ;
	print "Your request have been completed!" ;
}

?>