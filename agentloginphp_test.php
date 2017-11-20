<?
include 'config.php';
include 'conf.php';
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
/*
agent_no, lname, fname, email, agent_password, date_registered
*/
$query="SELECT * FROM agent WHERE email ='".$email."' AND agent_password='".$password."' AND status ='ACTIVE' AND work_status ='BP';";



$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$_SESSION['agent_no'] =$row[0]; 
	header("Location:business_partner/agentHome.php");
}
else
{
	header("Location:index.php?mess=1");
}



?>