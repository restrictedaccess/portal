<?php
die("Under Maintenance");
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include '/main.function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustralianDateFormat = date("jS")." ".date("M")." ".date("Y");
$ATZ = $AusDate." ".$AusTime;


$site = $_SERVER['HTTP_HOST'];

$email = $_REQUEST['email'];
$email2 = $_REQUEST['email2'];

$password = sha1($_REQUEST['password']);

$fname = $_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$address=$_REQUEST['address'];
$phone=$_REQUEST['phone'];
$status=$_REQUEST['status'];
$id=$_REQUEST['id'];

$companyname=$_REQUEST['companyname'];
$companyposition=$_REQUEST['companyposition'];
$integrate =$_REQUEST['integrate'];
$hosting =$_REQUEST['hosting'];

$marketing_plan =$_REQUEST['marketing_plan'];
$marketing_plan =filterfield($marketing_plan);
$address =filterfield($address);
$phone =filterfield($phone);

$country_location =$_REQUEST['country_location'];
// 
//echo $country_location;
if ($country_location == "Australia") 
{
	$commission_type ="LOCAL";
}else{
	$commission_type ="INTERNATIONAL";
}
//update save

$sql="SELECT * FROM agent WHERE email='$email';";
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
//echo $sql."<br>";
//echo $ctr;
if($ctr > 0)
{
	    $mess="1";
		header("Location:agent.php?mess=$mess");
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
/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status, hosting, work_status, access_aff_leads, agent_bank_account, aff_marketing_plans, companyname, companyposition, integrate, country_location, commission_type
*/

	$query= "INSERT INTO agent SET lname ='$lname', fname = '$fname', email ='$email', agent_password = '$password', date_registered = '$ATZ',
	agent_code = '$agent_code',agent_address = '$address', agent_contact = '$phone', work_status = 'AFF', aff_marketing_plans = '$marketing_plan',
	companyname = '$companyname', companyposition = '$companyposition', integrate = '$integrate' ,hosting ='$hosting' , country_location ='$country_location' ,
	commission_type = '$commission_type';";
    mysql_query($query);
	//echo $query;
// SEND MESSAGE TO CHRIS AND COMPANY.	
//$header  = 'MIME-Version: 1.0' . "\r\n";
//$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$header .= "From: ".$email." \r\n"."Reply-To: ".$email."\r\n";	
$phone2=str_replace('\r\n','<br>',$phone);
$address=str_replace('\r\n','<br>',$address);
$marketing_plan=str_replace('\r\n','<br>',$marketing_plan);
$to ="chrisj@remotestaff.com.au";
$body="<div style=' margin:10px; padding:10px; font: 12px tahoma;'>
<img src='http://$site/portal/images/banner/remoteStaff-small.jpg'>
<br><br>
<b>AFFILIATE REGISTRATION REQUEST</b><br /><br />
		FULL NAME : ".$fname." ".$lname."<br>".
	    "EMAIL : " .$email ."<br><br>".
		"COMPANY NAME : " .$companyname ."<br>".
		"COMPANY POSITION : " .$companyposition ."<br>".
		"COUNTRY : " .$country_location ."<br>".
		"COMMSSION TYPE : " .$commission_type ."<br>".
		"ADDRESS : <ul style='margin-top:1px;'>".$address."</ul>".
		"CONTACT NOs. : <ul style='margin-top:1px;'>".$phone2."</ul>".
		"WEBSITE URL : " .$hosting."<br>".
		"ABOUT THEIR SITE. : <br />
<span style='color:#CCCCCC'>(Traffic statistic - unique visitors per month, 
Nature of business, 
Site audience profile,  etc..)
</span><ul style='margin-top:1px;'>".$marketing_plan."</ul>".
"INTEGRATE REMOTESTAFF INQUIRY FORM TO THEIR SITE : " .$integrate."<br><br><br>".
		"SYSTEM GENERATED AGENT CODE : ".$agent_code."<br>".
		"DATE REGISTRATION : ".$AustralianDateFormat."<br>
<P style='color:#CCCCCC'><B>NOTE :</b> Registered in http://$site/portal</P>
</div>";
//echo $body."<br><br><br><br>";

//mail($to,"AFFILIATE REGISTRATION REQUEST [ ".$site." ]",$body,$header);
$from_address = $email;
$from_name = "REMOTESTAFF.COM.AU";				
sendZendMail($to,"AFFILIATE REGISTRATION REQUEST [ ".$site." ]",$body,$from_address,$from_name);

/// SEND AUTO RESPONDER TO THE REGISTERED USER...
$from="admin@remotestaff.com.au";
//$header2  = 'MIME-Version: 1.0' . "\r\n";
//$header2 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$header2 .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";	

$to2 =$email;
$body2="<div style=' margin:10px; padding:10px; font: 12px tahoma;'>
<img src='http://$site/portal/images/banner/remoteStaff-small.jpg'>
<br><br>
Hi, ".$fname." ".$lname."<br>".
"<p>Thanks for taking time to fill out the affiliate form. </P>".
"<p>We’ll review your application and get back to you within 3 business days.  </P>".
"<p>Cheers!</P>".
"<p>Team RemoteStaff </P>".
"</div>";

//echo $body2;
//mail($to2,'MESSAGE FROM REMOTESTAFF',$body2,$header2);
$from_address = $from;
$from_name = "REMOTESTAFF.COM.AU";				
sendZendMail($to2,'MESSAGE FROM REMOTESTAFF',$body2,$from_address,$from_name);

///
header("Location:agent_thank.php");
	
}
?>