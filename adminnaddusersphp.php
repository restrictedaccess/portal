<?
//from : adminnaddusers.php
include 'config.php';
include 'conf.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$id = $_REQUEST['id'];
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$status = $_REQUEST['status'];

if(isset($_POST['save']))
{
// admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
$query="INSERT INTO admin SET
		admin_fname ='$fname',
		admin_lname ='$lname',
		admin_email ='$email',
		admin_password ='$password',
		admin_created_on ='$ATZ',
		status = '$status';";

$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
}
else
{
	header("location:adminnaddusers.php?mess=1");
}
}


if(isset($_POST['update']))
{
// admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
$query="UPDATE admin SET
		admin_fname ='$fname',
		admin_lname ='$lname',
		admin_email ='$email',
		admin_password ='$password',
		status = '$status' WHERE admin_id =$id;";

$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
}
else
{
	header("location:adminnaddusers.php?mess=2");
}
}


?>