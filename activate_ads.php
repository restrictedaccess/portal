<?
include 'conf.php';
include 'config.php';

$admin_id = $_SESSION['admin_id'];
$postings =$_REQUEST['postings'];
$ads=explode(",",$postings);


// id, agent_id, lead_id, date_created, outsourcing_model, companyname, jobposition, jobvacancy_no, skill, responsibility, status, heading
if(isset($_POST['Activate']))
{
	
	for ($i=0; $i<count($ads);$i++)
	{
		$query="UPDATE posting SET  status='ACTIVE' WHERE id = $ads[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	}
	header("location:admin_advertise_list.php");	
}


if(isset($_POST['DeActivate']))
{
	$subject="MESSAGE FROM ADMIN REMOTESTAFF.COM.AU";
	$admin_email ="ricag@remotestaff.com.au";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
	
	for ($i=0; $i<count($ads);$i++)
	{
		$query="UPDATE posting SET  status='ARCHIVE' WHERE id = $ads[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
		/*
		////Send Email to all Unprocessed Applicant ...
		$sql="SELECT u.fname,u.lname,u.email,p.jobposition
FROM personal u
JOIN applicants a ON a.userid = u.userid
JOIN posting p ON p.id = a.posting_id
WHERE a.status = 'Unprocessed' AND a.posting_id = $ads[$i];";
		//echo $sql;
		$result =mysql_query($sql);
		while(list($fname,$lname,$email,$jobposition)=mysql_fetch_array($result))
		{
			//echo $fname." ".$lname." : ".$email."<br>".$jobposition."<br>";
			$message = "<div style='font:12px Trebuchet MS'>
						<fieldset style='background:#FFF;border: 1px dashed #31B9FB;'>
						<legend style=';margin-left: 25px;padding:20px; margin-bottom:10x;background:#FFFFF;'>
						<img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg' >
						</legend>
						<div style='padding:10px; margin:20px;'>
						<p>Hi ".$fname." ".$lname.",  </p>
						<p>Thank you for your interest and application with RemoteStaff as a <b>".strtoupper($jobposition)."</b>. </p> 
						<p>Unfortunately other applicants are considered to have more relevant skills and experience to meet the requirements 
						of our current clients. As such, we are unable to continue with your application at this time. </p> 
						<p>However as your application was of a high standard we would like to keep your details on file should a more suitable opportunity arise.
						 Should such an opportunity become available you will be notified by email.   </p>
						<p>If you do not wish for us to send you updates please respond with <b>&quot;NO THANKS&quot;</b> on your subject line. </p> 
						<p>We hope that you find the opportunity that you are looking for.  </p>
						<p style=' color:#999999'>Cheers!<br>
						Rica Gil <br>
						RemoteStaff  <br>
						 +61 2 9011 7706 <br>
						1300 733 430</p>
						</div>
						</fieldset>
						</div>";
						
			if (mail($email,$subject, $message, $headers))
			{
				$mail++;
			}else {
				$notmail++;
			}			
			
		}
		*/
		
		
	}
	//echo "Sent Mail : ".$mail."<br>";
	//echo "Failed Send : ".$notmail."<br>";
	header("location:admin_advertise_list.php");	
}


?>