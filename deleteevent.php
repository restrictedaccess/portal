<?
// from : organizer.php
include 'config.php';
include 'function.php';

$id=$_REQUEST['id'];

$query="DELETE FROM calendar WHERE id =$id;";
$result=mysql_query($query);
header("location:organizer.php?mess=4");




?>