<?
include 'config.php';
include 'conf.php';
$userid=$_SESSION['userid'];
$is_v2 = false;
if(isset($_SESSION["is_v2"])){
	$is_v2 = true;
}
require_once('online_presence/OnlinePresence.php');
$presence = new OnlinePresence($_SESSION['userid'], 'subcon');
$presence->logOut();

$_SESSION['userid']="";
session_destroy();
//if($is_v2){
//	header("location:/portal/v2/secure/logout");
//} else{
//	header("location:/portal/");
//}

header("location:/portal/");

?>
