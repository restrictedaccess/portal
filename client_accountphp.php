<?
//from : apply_action.php
include 'config.php';
include 'conf.php';
include 'function.php';

$id=$_REQUEST['id'];
$agent_no = $_REQUEST['agent_no'];
$action = $_REQUEST['action'];
$txt = $_REQUEST['txt'];
//$txt=filterfield($txt);
$mode =$_REQUEST['mode'];
$hid =$_REQUEST['hid'];
$star=$_REQUEST['star'];
$templates=$_REQUEST['templates'];
$subject=$_REQUEST['subject'];

// SELECT * FROM history h;
// id, agent_no, leads_id, actions, history, date_created
if(isset($_POST['Add']))
{
if($mode=="")
{

	if($action=="EMAIL")
	{
		$query="SELECT * FROM agent WHERE agent_no =$agent_no;";
		//echo $query."<br>";
		$result=mysql_query($query);
		$ctr=@mysql_num_rows($result);
		if ($ctr >0 )
		{
			$row = mysql_fetch_array ($result); 
			$name = $row['fname']." ".$row['lname'];
			$agent_email=$row['email'];
			$agent_address =$row['agent_address'];
			$agent_contact =$row['agent_contact'];
			$agent_abn =$row['agent_abn'];
		}
		if($subject=="")
		{
			$subject='Message from RemoteStaff.com c/o  '.$name;
		}
		
		
		$email=$_REQUEST['email'];
		$fullname=$_REQUEST['fullname'];
		$txt=str_replace("\n","<br>",$txt);
		$to=$email;
		$subj=$subject;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: ".$agent_email." \r\n"."Reply-To: ".$agent_email."\r\n";
		//$headers = "From: ".$agent_email."\r\nContent-type: text/html"; 
		$mess =  "Hi,".$fullname ."<br><br>".
			$txt.
		    "<br><br>Best Regards,"."<br>". 
			$name;
		if ($templates =="signature")
		{
			$message =" <html>
					    <head>
						<title>RemoteStaff.Com.Au</title>
						<style>
						body{font-family:Tahoma; font-size:14px;}
						.message{margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;}
						</style>
						</head>
						<body>
						<table style=' border:#FFFFFF solid 1px;' width='100%'>
						<tr><td><img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'></td></tr>
						<tr><td width='100%%' valign='top'><hr style='border:#99CC66 solid 1px;'></td></tr>
						<tr><td height='105' width='100%%' valign='top'>
						<p class='message' align='justify'>".$mess."</p>
						</td></tr>
						<tr><td height='28' background='http://www.philippinesatwork.com/dev/norman/Chris/images/banner/remote.jpg'>&nbsp;</td>
						</tr>
						<tr><td height='10' width='100%%' valign='top' style='color:#999999; font-size:12px;'>
						<div style='margin-left:10px; margin-top:5px;'>
						Agent Name : ".$name."<br>
						Address : ".$agent_address."<br>
						Contact No : ".$agent_contact."<br>
						ABN No : ".$agent_abn."<br>
						Email : ".$agent_email."<br />
						</div>
						</td></tr>
						</table>
						</body>
						</html>";
		}
		if ($templates =="plain")
		{
			$message =$mess;
		}
		//echo $subj."<br>";	
		//echo $headers."<br>";
		//echo $message."<br>";
		$result=mail($to,$subject, $message, $headers);
		if(!result){
			echo "Failed to send email.";
		}
		else
		{   
		    $txt=filterfield($txt);
			$query ="INSERT INTO history (agent_no, leads_id, actions, history, date_created) VALUES ($agent_no, $id, 'EMAIL', '$txt', NOW());";
			//echo $query;
			mysql_query($query);
			header("location:client_account.php?id=$id");
		}
	}
	else
	{
		 $txt=filterfield($txt);
		$query="INSERT INTO history (agent_no, leads_id,actions, history,date_created) VALUES ($agent_no, $id,'$action', '$txt',NOW());";
		//echo $query;
		$result=mysql_query($query);
		if (!$result)
		{
			//$mess="Error";
			echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	
		}
		else
		{
			//echo "Data Inserted";
			//header("location:education");
			header("location:client_account.php?id=$id");
		}
	}
	
}

if($mode=="update")
{
	$txt=filterfield($txt);
	$query="UPDATE history SET history ='$txt' WHERE id=$hid;";
	$result=mysql_query($query);
	if (!$result)
	{
		//$mess="Error";
		echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	
	}
	else
	{
		//echo "Data Inserted";
		//header("location:education");
		header("location:client_account.php?id=$id");
	}
}
}
if(isset($_POST['rate']))
{
	//echo $star." Star";
	$query="UPDATE leads SET rating='$star' WHERE id=$id AND status ='Client';";
	mysql_query ($query) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	header("location:client_account.php?id=$id");
}



// apply_actionphp.php
?>
