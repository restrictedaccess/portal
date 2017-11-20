<?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];


$aff_id = $_REQUEST['agent'];
if($aff_id!="0"){
	$agent_no = $aff_id;
}

/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$length=strlen($agent_code);
	
}

$tracking_no =$agent_code."OUTBOUNDCALL";

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
$query="INSERT INTO leads SET tracking_no = '$tracking_no',
		timestamp = '$ATZ' ,
		status = 'New Leads' ,
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
		website= '$website', 
		officenumber = '$officenumber', 
		mobile = '$mobile', 
		company_description = '$companydesc', 
		company_size = '$noofemployee', 
		outsourcing_experience = '$used_rs', 
		outsourcing_experience_description = '$usedoutsourcingstaff', 
		company_turnover = '$companyturnover',
		personal_id = '$personal_id',
		agent_id = $agent_no ;";

//echo $query;

$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	$mess="Error";
}
else
{
	$agent_email ="RemoteStaff.com.au";
	$to='chrisjchrisj@yahoo.com'; //
	$subject='Lead Added From Sales Staff';
	$headers = "From: ".$agent_email."\r\nContent-type: text/html"; 
	$message =  "NEW LEAD DETAILS,<br><br>".
			"PROMOTIONAL CODE :".$tracking_no."<br>".
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
			"REMOTE STAFF DUTIES :".$tracking_no."<br>".
			"NO. REMOTE STAFF NEEDED :".$rsnumber."<br>".
			"QUESTIONS / CONCERN :".$questions."<br><br>".
			"-----------------------------------<BR><br>".
			"ADDDED BY :".$name."<br>";
			mail($to,$subject, $message, $headers);
	$mess="";
	
	header("location:addnewlead.php?mess=1");
}

?>



