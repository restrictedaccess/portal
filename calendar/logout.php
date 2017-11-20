<?
//include 'include/datalib.php';
include 'conf.php';
$userid=$_SESSION['userid'];
$agent_no=$_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];
$client_id = $_SESSION['client_id'];
$userid="";
$agent_no="";
$admin_id ="";
$client_id="";
$_SESSION['userid']="";
$_SESSION['agent_no']="";
$_SESSION['admin_id']="";
$_SESSION['client_id']="";
session_destroy();
header("location:../index.php");
?>