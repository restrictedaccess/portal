<?
include 'config.php';
include 'conf.php';
$email = $_REQUEST['email'];
//$password = $_REQUEST['password'];
$password=sha1($_REQUEST['password']);
require_once('online_presence/OnlinePresence.php');
/*
agent_no, lname, fname, email, agent_password, date_registered
*/
$query="SELECT * FROM personal WHERE email ='".$email."' AND pass='".$password."';";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$_SESSION['userid'] =$row[0]; 
    $presence = new OnlinePresence($_SESSION['userid'], 'subcon');
    $presence->logIn();
	header("Location:applicantHome.php");
	
}
else
{
	header("Location:index.php?mess=4");
}



?>
