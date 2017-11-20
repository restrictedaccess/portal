<?
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$fname = $_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$address=$_REQUEST['address'];
$phone=$_REQUEST['phone'];
$bank_account=$_REQUEST['bank_account'];
$bank_account=filterfield($bank_account);


///////////////////////////////////// 
$query="UPDATE agent SET lname = '$lname', fname = '$fname', email = '$email' , agent_password = '$password', agent_address = '$address',
 		agent_contact = '$phone' , agent_bank_account = '$bank_account' WHERE agent_no =$agent_no;";

//echo $query;

$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	
}
else
{
	header("location:affprofile.php?mess=1");
}

?>



