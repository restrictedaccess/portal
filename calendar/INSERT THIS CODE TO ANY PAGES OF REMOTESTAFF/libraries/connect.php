<?php

function connsql() {
	$dbhost = 'localhost' ;
	$dbuser = 'root' ; 
	$dbpass = '' ;
	$dbname = 'calendar' ;

	$db = @ mysql_connect($dbhost, $dbuser, $dbpass) or die("Error connecting to mysql") ;
	mysql_select_db($dbname) or die('error: cant select');
	return $db;
}

function diesql($db) 
{
	mysql_close($db);
}

?>
