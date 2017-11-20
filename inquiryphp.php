<?
include('conf/zend_smarty_conf_root.php');
include 'config.php';
include 'time.php';
include '/main.function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$time="";
$jobresponsibilities="";
$rsnumber="";
$needrs="";
$rsinhome ="";
$rsinoffice="";
$questions="";
$fullname="";
$companyposition="";
$companyname="";
$companyaddress="";
$email="";
$website="";
$officenumber="";
$mobile="";
$companydesc="";
$industry="";
$noofemployee="";
$used_rs="";
$companyturnover="";
$openreferral="";

$tracking_no = $_REQUEST['tracking_no'];
$time=$_REQUEST['time'];
$jobresponsibilities=$_REQUEST['jobresponsibilities'];
$rsnumber=$_REQUEST['rsnumber'];
$needrs=$_REQUEST['needrs'];
$rsinhome=$_REQUEST['rsinhome'];
$rsinoffice=$_REQUEST['rsinoffice'];
$questions=$_REQUEST['questions'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$companyposition=$_REQUEST['companyposition'];
$companyname=$_REQUEST['companyname'];
$companyaddress=$_REQUEST['companyaddress'];
$email=$_REQUEST['email'];
$website=$_REQUEST['website'];
$officenumber=$_REQUEST['officenumber'];
$mobile=$_REQUEST['mobile'];
$companydesc=$_REQUEST['companydesc'];
$industry=$_REQUEST['industry'];
$noofemployee=$_REQUEST['noofemployee'];
$used_rs=$_REQUEST['used_rs'];
if ($used_rs=="Yes")
{
	$usedoutsourcingstaff=$_REQUEST['usedoutsourcingstaff'];
}
if ($used_rs=="No")
{
	$usedoutsourcingstaff="";
}
	
$companyturnover=$_REQUEST['companyturnover'];
$openreferral=$_REQUEST['openreferral'];
//////////////////////////////////////
// create a personal id 

$y =date('Y');
$m =date('m');
$d= date('d');
$date =$y."-".$m."-".$d; 
$sql="SELECT * FROM leads  WHERE DATE_FORMAT(timestamp,'%Y-%m-%d') = '$date';";
//echo $sql."<br>";
$res=mysql_query($sql);
$ctr=@mysql_num_rows($res);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($res); 
	$ctr=$ctr+1;
	$personal_id="L".$y.$d.$m."-".$ctr;	
}
else
{	$ctr=1;
	$personal_id="L".$y.$d.$m."-".$ctr;	
}
  



///////////////////////////////////// 
$registered_url = $_SERVER['HTTP_HOST'].'/portal/inquiry.php';
$query="INSERT INTO leads SET tracking_no = '101',
				timestamp = '$ATZ',
				status = 'New Leads', 
				remote_staff_competences = '$jobresponsibilities', 
				remote_staff_needed = '$rsnumber', 
				remote_staff_needed_when = '$needrs',
				remote_staff_one_home = '$rsinhome', 
				remote_staff_one_office = '$rsinoffice', 
				your_questions = '$questions', 
				fname = '$fname',
				lname = '$lname', 
				company_position = '$companyposition', 
				company_name = '$companyname', 
				company_address = '$companyaddress', 
				email = '$email', 
				website = '$website', 
				officenumber = '$officenumber', 
				mobile = '$mobile', 
				company_description = '$companydesc', 
				company_size = '$noofemployee', 
				outsourcing_experience = '$used_rs', 
				outsourcing_experience_description = '$usedoutsourcingstaff', 
				company_turnover = '$companyturnover',
				personal_id = '$personal_id',
				agent_id = 2,
				business_partner_id = 2,
				registered_in = 'home page', 
				registered_url = $registered_url, 
				registered_domain = LOCATION_ID;";	

//echo $query;

$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	$mess="Error";
}
else
{
	/////// SEND MESSAGE TO CHRIS /////////
	$agent_email ="RemoteStaff.com.au";
	$to='chrisjchrisj@yahoo.com'; //
	$subject='NEW ENQUIRY FROM SITE';
	//$headers = "From: ".$agent_email."\r\nContent-type: text/html"; 
	$message =  "CLIENT DETAILS,<br><br>".
			"PROMOTIONAL CODE : 101".
			"NAME :".$fname."<br>".
			"LAST NAME :".$lname."<br>".
			"COMPANY POSITION :".$companyposition."<br>".
			"COMPANY NAME :".$companyname."<br>".
			"COMPANY ADDRESS :".$companyaddress."<br>".
			"EMAIL :".$email."<br>".
			"WEBSITE :".$website."<br>".
			"OFFICE NO. :".$officenumber."<br>".
			"MOBILE :".$mobile."<br>".
			"COMPANY DETAILS :".$companydesc."<br>".
			"NO. OF EMP :".$noofemployee."<br>".
			"HAVE OUTSOURCING EXP. :".$used_rs."<br>".
			"OUTSOURCING DETAILS :".$usedoutsourcingstaff."<br>".
			"COMPANY TURNOVER :".$companyturnover."<br>".
			"-----------------------------------<BR><br>".
			"REMOTE STAFF DUTIES :".$jobresponsibilities."<br>".
			"NO. REMOTE STAFF NEEDED :".$rsnumber."<br>".
			"QUESTIONS / CONCERN :".$questions."<br>";
			//mail($to,$subject, $message, $headers);
			$from_address = $agent_email;
			$from_name = "RemoteStaff.com.au";				
			sendZendMail($to,$subject,$message,$from_address,$from_name);	
	$mess="";
	//header("location:http://www.remotestaff.com.au/thankyou.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript1.2">
function subLogin()
{
	if (document.form.mess.value=="")
	{
		document.form.submit();
	}	
}
</script>
</head>
<body onload=subLogin()>

<form action="thankyou.php" name="form" method="POST">
<input type="hidden" name="mess" value="<? echo $mess;?>" />
</form>	 


</body>
</html>


