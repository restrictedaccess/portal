<?
include './conf/zend_smarty_conf_root.php';
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$email = $_REQUEST['email'];
$email2 = $_REQUEST['email2'];
$password = $_REQUEST['password'];
$fname = $_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$address=$_REQUEST['address'];
$phone=$_REQUEST['phone'];
$status=$_REQUEST['status'];
$id=$_REQUEST['id'];
$hosting =$_REQUEST['hosting'];
$country_location=$_REQUEST['country_location'];
$commission_type =$_REQUEST['commission_type'];

if(isset($_POST['save']))
{
$sql="SELECT * FROM agent WHERE email='$email';";
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
//echo $sql."<br>";
//echo $ctr;
if($ctr > 0)
{
	    $mess="1";
		header("Location:adminnaddagent.php?mess=$mess");
}
else
{
	$sql2="SELECT MAX(agent_code) FROM agent;";
	//echo $sql2."<br>";
	$res=mysql_query($sql2);
	$ctr=@mysql_num_rows($res);
	//echo "ctr : ".$ctr."<br>";
	if ($ctr >0 || $ctr=="" )
	{
	    //$row = mysql_fetch_array ($res, MYSQL_NUM); 
	    //$row = mysql_fetch_array($res);
		//$agent_code = $row[''];
		list($agent_code) = mysql_fetch_array($res);
		$agent_code=$agent_code+001;
		//echo "Agent Code :".$agent_code."<br>";
	}
	else
	{
		$agent_code=100;
	}
	
	
	//echo "Agent Code :".$agent_code."<br>";
	// agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status
	
	$query= "INSERT INTO agent (lname, fname, email, agent_password, date_registered,agent_code,agent_address, agent_contact,hosting,work_status,country_location,commission_type) VALUES ('$lname', '$fname', '$email', '$password','$ATZ','$agent_code','$address','$phone','$hosting','AFF','$country_location','$commission_type');";
	//echo $query;
	mysql_query($query);
	//$_SESSION['agent_no'] = mysql_insert_id(); 
	header("Location:adminaffiliates.php");
}

}

if(isset($_POST['update']))
{
$query= "UPDATE agent SET lname = '$lname', fname = '$fname', email = '$email' , agent_password = '$password', agent_address = '$address',
 		agent_contact = '$phone', status = '$status', email2 = '$email2',hosting ='$hosting',country_location = '$country_location' ,commission_type = '$commission_type'  WHERE agent_no =$id;";
$result=mysql_query($query);

// Send Email to Affiliates if the Status is ACTIVE
if ($status == "ACTIVE") {
	$subject="MESSAGE FROM REMOTESTAFF";
	$admin_email ="admin@remotestaff.com.au";
	//$headers  = 'MIME-Version: 1.0' . "\r\n";
	//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
	$body="<img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'>
		   <div style='font: 12px tahoma; width:500px; padding:10px;'>
			<p align='justify'>Hi  ".$fname." ".$lname.", </p>
			<p align='justify'>Congratulations! </p>
			<p align='justify'>Your application to become a RemoteStaff Affiliate has been approved.</p>
			<p align='justify'>You are now part of the fastest growing un-stoppable industry. </p>
			<p align='justify'>We have developed and tailored a system for your use.
			 This will allow you to easily monitor your offline/online campaigns,
			 easily email and post banners and to monitor
			 what part of sales stage your leads are on. </p>
			<p align='justify'>The system also offers a very easy system to create and calculate your monthly affiliate commission. </p>
			<p align='justify'>To use the RemoteStaff Affiliate system, please log in as <b>&quot;Affiliate&quot;</b> <a href='http://www.remotestaff.com.au/portal/'>HERE</a> using the user name and password on your application. </p>
			<p align='justify'>Should you have any questions, suggestions and/or comments, don't hesitate to contact me. </p>
			<p align='justify'>&nbsp;</p>
			<p style='color:#666666;'>
			Rica Gil<br>
			RemoteStaff <br>
			Email: ricag@remotestaff.com.au <br>
			PH: +61 2 9011 7706 <br>
			Fax: +61 2 8088 7247<br>
			</p>
		  </div>";
	//mail($email,$subject, $body, $headers);	
	$from_address = $admin_email;
	$from_name = "REMOTESTAFF.COM.AU";				
	sendZendMail($email,$subject,$body,$from_address,$from_name);	
	//echo $body;
}	

header("Location:adminaffiliates.php");
}

?>