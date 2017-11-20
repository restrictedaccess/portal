<?
include 'conf.php';
include 'config.php';
include 'function.php';
include 'time.php';
include '/main.function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$leads_id=$_REQUEST['leads_id'];
$applicants =$_REQUEST['applicants'];
$pid = $_REQUEST['pid'];

$users=explode(",",$applicants);


// ACTIONS : Invite, Prescreen, Shortlist, Kept, Hire, Reject
if(isset($_POST['Invite']))
{
	$stat="Invite to Interview";
	for ($i=0; $i<count($users);$i++)
	{
		$sql="SELECT lname,fname,email FROM personal p JOIN  applicants a ON p.userid=a.userid WHERE a.id = $users[$i];";
		$result=mysql_query($sql);
		$row = mysql_fetch_array ($result); 
		$name = $row['lname']." ,  ".$row['fname'];
		$email = $row['email'];
		
		
		$to=$email;
		$admin_email="chrisj@remotestaff.com.au";
		$subject='Invitation for Interview ';
		//$headers  = 'MIME-Version: 1.0' . "\r\n";
		//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
		//$headers = "From: RemoteStaff.Com\r\nContent-type: text/html"; 
		$message =  "Hi ".$name.",<br><br>".
			"You are invited to a Phone Interview with us".
			"<br><br>".
			"Best Regards,"."<br>";
		//mail($to,$subject, $message, $headers);
		$from_address = $admin_email;
		$from_name = "RemoteStaff.Com";				
		sendZendMail($to,$subject,$message,$from_address,$from_name);
		$query="UPDATE applicants SET  status='".$stat."' WHERE id = $users[$i];";
		//echo $query;
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
		
	//echo "<br>".$to."<br>";
	//echo $headers."<br>";
	//echo "<br>".$message;
	}
	
	header("location:adminrecruitment.php?pid=$pid&id=$leads_id&stat=$stat");
}

if(isset($_POST['Prescreen']))
{
	$stat= "Prescreened";
	for ($i=0; $i<count($users);$i++)
	{
		$query="UPDATE applicants SET  status='".$stat."' WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
		//echo $query;
	}
	
	header("location:adminrecruitment.php?pid=$pid&id=$leads_id&stat=$stat");	
}

if(isset($_POST['Shortlist']))
{
	$stat= "Shortlisted";
	for ($i=0; $i<count($users);$i++)
	{
		$query="UPDATE applicants SET  status='".$stat."' WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	}	
	header("location:adminrecruitment.php?pid=$pid&id=$leads_id&stat=$stat");
}

if(isset($_POST['Kept']))
{
	$stat= "Kept for Referenced";
	for ($i=0; $i<count($users);$i++)
	{
		$query="UPDATE applicants SET  status='".$stat."' WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	}
	header("location:adminrecruitment.php?pid=$pid&id=$leads_id&stat=$stat");	
}

if(isset($_POST['Hire']))
{
	$stat= "Hired";
	for ($i=0; $i<count($users);$i++)
	{
		$query="UPDATE applicants SET  status='".$stat."' WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	}
	header("location:adminrecruitment.php?pid=$pid&id=$leads_id&stat=$stat");	
}

if(isset($_POST['Reject']))
{
	$stat= "Rejected";
	for ($i=0; $i<count($users);$i++)
	{
		$query="UPDATE applicants SET  status='".$stat."' WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	}
	header("location:adminrecruitment.php?pid=$pid&id=$leads_id&stat=$stat");	
}

if(isset($_POST['delete']))
{
	//$stat= "Rejected";
	for ($i=0; $i<count($users);$i++)
	{
		$query="DELETE FROM applicants WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
		//echo $query;
	}
	header("location:adminrecruitment.php?pid=$pid&id=$leads_id");	
}


/*
if(isset($_POST['process']))
{
	$leads_id=$_REQUEST['leads_id'];
	$userid=$_REQUEST['userid'];
	$posting_id = $_REQUEST['posting_id'];
	$aid=$_REQUEST['aid'];
	
	//////// $AUSD //////////////////
	$salary_month=$_REQUEST['salary_month'];
	$salary_week=$_REQUEST['salary_week'];
	$salary_day=$_REQUEST['salary_day'];
	$salary_hour=$_REQUEST['salary_hour'];
	
	$hour=$_REQUEST['hour'];
	$days=$_REQUEST['days'];
	$details=$_REQUEST['details'];
	
	///Converted to Phil Pesos
	$salary_month2=$_REQUEST['salary_month2'];
	$salary_week2=$_REQUEST['salary_week2'];
	$salary_day2=$_REQUEST['salary_day2'];
	$salary_hour2=$_REQUEST['salary_hour2'];
		
	$details=filterfield($details);
	
	/////////////////////////////////
	$agent_commission=$_REQUEST['agent_commission'];
	$think_commission=$_REQUEST['think_commission'];
	
	echo "APPLICANT ID :".$userid."<br>".
		"CLIENT ID :" .$leads_id."<br>".
		"POSTING ID :" .$posting_id."<br>".
		"AGENT ID :" .$agent_no."<br>".
		"AUD MONTHLY :" .$salary_month."<br>".
		"AUD WEEKLY :" .$salary_week."<br>".
		"AUD DAILY :" .$salary_day."<br>".
		"AUD HOURLY :" .$salary_hour."<br>".
		"WORKING HOURS :" .$hour."<br>".
		"WORKING DAYS :" .$days."<br>".
		"PHP MONHTLY :" .$salary_month2."<br>".
		"PHP WEEKLY :" .$salary_week2."<br>".
		"PHP DAILY :" .$salary_day2."<br>".
		"PHP HOURLY :" .$salary_hour2."<br>".
		"DETAILS :" .$details."<br><br><br>".
		"AGENT COMMISSION :" .$agent_commission."<br>".
		"COMPANY COMMISSION :" .$think_commission."<br>";

	//id, leads_id, agent_id, userid, posting_id, date_contracted, aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days, php_monthly, php_weekly,
	// php_daily, php_hourly, details, agent_commission, think_commission, overtime
	
	
	$query="INSERT INTO subcontractors (leads_id, agent_id, userid, posting_id, date_contracted, aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days, php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission, think_commission)
	 
			VALUES ($leads_id,$agent_no,$userid,$posting_id,'$ATZ ','$salary_month','$salary_week','$salary_day','$salary_hour','$hour', '$days','$salary_month2','$salary_week2','$salary_day2','$salary_hour2','$details','$agent_commission','$think_commission')";
	//echo $query;
	mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());
	$query2="UPDATE applicants SET  status='Sub-Contracted' WHERE id = $aid;";
	mysql_query($query2)or trigger_error("Query: $query2\n<br />MySQL Error: " . mysql_error());
	header("location:client_account.php?id=$leads_id");
}
*/


?>