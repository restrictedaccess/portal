<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

if($_SESSION['client_id']=="")
{
	header("location:index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$client_id = $_SESSION['client_id'];
$userid = $_REQUEST['userid'];

$title = filterfield($_REQUEST['title']);
$testimony = filterfield($_REQUEST['testimony']);
$testimony_id = $_REQUEST['testimony_id'];


$query="SELECT CONCAT(fname,' ',lname),email  FROM leads WHERE id=$leads_id;";
$result=mysql_query($query);
list($leads_name, $email) = mysql_fetch_array ($result); 

$sql="SELECT * FROM personal WHERE userid=$userid";
$data=mysql_query($sql);
$row = mysql_fetch_array($data); 
$staff_name =$row['fname']."  ".$row['lname'];



//echo $testimonials;
/*
SELECT * FROM testimonials t;
testimony_id, created_by_id, created_by_type, recipient_id, recipient_type, testimony_status, date_created, date_updated, title, testimony

*/

if(isset($_POST['save']))
{
	$query = "INSERT INTO testimonials SET 
				created_by_id = $client_id, 
				created_by_type = 'leads', 
				recipient_id = $userid, 
				recipient_type = 'subcon', 
				date_created = '$ATZ',
				title = '$title',
				testimony = '$testimony';";
	//echo $query;
	$result = mysql_query($query);		
	if(!$result) die ("Error in Script : <br>".$query);
	
	/*
	$to = $email;
	$subject = "REMOTESTAFF New Testimonial Received from Staff [ ".$staff_name." ]";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: info@remotestaff.com.au \r\n"."Reply-To: info@remotestaff.com.au\r\n";	
	$headers .= 'Cc: chrisj@remotestaff.com.au,ricag@remotestaff.com.au' . "\r\n";
	$headers .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";
	$body = "A new testimonial has been receive for <br><br>".
			"Client Name : ".$leads_name."<br>".
			"Email : ".$email."<br>".
			"Waiting for the RemoteStaff Admin Approval of this Testimonial<br><br>".
			"Message <br><br> ".str_replace("\n","<br>",$testimony)."<br><br>";
	//echo $body;	
	mail($to,$subject, $body, $headers);
	*/
	
	header("location:client_create_testimonials.php?code=1");
}

if(isset($_POST['update']))
{
	//echo $testimony_id;
	$query = "UPDATE testimonials SET 
				date_updated = '$ATZ',
				testimony_status = 'updated',
				title = '$title',
				testimony = '$testimony' WHERE testimony_id = $testimony_id;";
	//echo $query;
	$result = mysql_query($query);		
	if(!$result) die ("Error in Script : <br>".$query);
	/*
	$to = $email;
	$subject = "REMOTESTAFF Update Testimonial Received from Staff [ ".$staff_name." ]";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: info@remotestaff.com.au \r\n"."Reply-To: info@remotestaff.com.au\r\n";	
	$headers .= 'Cc: chrisj@remotestaff.com.au,ricag@remotestaff.com.au' . "\r\n";
	$headers .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";
	$body = "An update testimonial has been receive for <br><br>".
			"Client Name : ".$leads_name."<br>".
			"Email : ".$email."<br>".
			"Waiting for the RemoteStaff Admin Approval of this Testimonial<br><br>".
			"Message <br><br> ".str_replace("\n","<br>",$testimony)."<br><br>";
	//echo $body;	
	mail($to,$subject, $body, $headers);
	*/
	header("location:client_create_testimonials.php?code=2&testimony_id=$testimony_id");
}
?>