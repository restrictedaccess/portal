<?
// from : sendemail.php
include 'config.php';
include 'conf.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
/*
agent_no, lname, fname, email, agent_password, date_registered
*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";
//echo $query."<br>";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$name = $row[2]." ".$row[1];
	$agent_email=$row[3];
	
}
$email=$_REQUEST['email'];
$fullname=$_REQUEST['fullname'];
$id=$_REQUEST['id'];
$txt=$_REQUEST['txt'];
$history=$_REQUEST['txt'];
$history =filterfield($history);
$txt=str_replace("\n","<br>",$txt);

$to=$email;
$subject='Welcome to RemoteStaff.com ';
$headers = "From: ".$agent_email."\r\nContent-type: text/html"; 
//$headers = "From: info@philippinesatwork.com\r\nContent-type: text/html"; 
$message =  "Hi,".$fullname ."<br><br>".
			$txt.
		    "<br><br>Best Regards,"."<br>". 
			$name;
//echo $headers."<br>";
//echo "<br>".$message;
$result=mail($to,$subject, $message, $headers);
if(!result){
echo "Failed to send email.";
}
else
{
	//echo "Mail Send";
	//SELECT * FROM history h; 
	// id, agent_no, leads_id, actions, history, date_created
	// insert history information
	$query ="INSERT INTO history (agent_no, leads_id, actions, history, date_created) VALUES ($agent_no, $id, 'EMAIL', '$history', NOW());";
	//echo $query;
	mysql_query($query);
	header("location:apply_action.php?id=$id");
}
//header("location:apply_action.php?id=$id");






// 
?>