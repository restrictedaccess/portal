<?
include 'config.php';
include 'conf.php';
include 'time.php';
//include_once("hash.lib.php") ;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$tracking_no = $_REQUEST['promotional_code'];
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
  

$agent_id = 44;
//////// Check the PromoCodes //////
if ($tracking_no!="") {
	$sqlCheckAgents="SELECT agent_no,agent_code,fname FROM agent a WHERE status='ACTIVE';";
	//echo $sqlCheckAgents;
	$re=mysql_query($sqlCheckAgents);
	while(list($agent_no,$agent_code,$agent_fname)=mysql_fetch_array($re))
	{
		$length=strlen($agent_code);
		//echo substr($tracking_no,0,$length);
		if(substr($tracking_no,0,$length)==$agent_code)
		{
			$agent_id = $agent_no;
			//echo $agent_fname."<br>";
			break;
		} 
	}
	//Check the promocodes then add 1 (one) point to its current point
	// id, tracking_no, tracking_desc, tracking_created, tracking_createdby, status, points
	$sqlCheckPromoCode="SELECT  * FROM tracking t WHERE tracking_no = '$tracking_no';";
	$result_check=mysql_query($sqlCheckPromoCode);
	$count_check=@mysql_num_rows($result_check);
	if($count_check > 0)
	{
		$row_check=mysql_fetch_array($result_check);
		$points=$row_check['points'];
		$promo_id=$row_check['id'];
		$points=$points+1;
		$sqlAddPoints="UPDATE tracking SET points='$points' WHERE id=$promo_id;";
		mysql_query($sqlAddPoints);
	}
	/////
}	
///////////////////////////////////// 
if($tracking_no=="")
{
	$tracking_no="139";
	$agent_id = 44;
}
$query="INSERT INTO leads SET  tracking_no = '$tracking_no',
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
				agent_id = $agent_id ;";
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
	$to='barbarac@remotestaff.com.au'; //
	$subject='NEW ENQUIRY FROM SITE';
	$headers = "From: ".$agent_email."\r\nContent-type: text/html"; 
	$message =  "CLIENT DETAILS,<br><br>".
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
			"REMOTE STAFF DUTIES :".$jobresponsibilities."<br>".
			"NO. REMOTE STAFF NEEDED :".$rsnumber."<br>".
			"QUESTIONS / CONCERN :".$questions."<br>";
			mail($to,$subject, $message, $headers);
			
//////////  SEND CONFIRMATION EMAIL TO THE USER  TO VERIFY HIS EMAIL ADDRESS ////////////////		
/*
$zig_hash = new zig_hash ;
//$hash_email = $zig_hash->hash("hash","encrypt",$fetch['email']) ;
$hash_email = $zig_hash->hash("hash","encrypt",$email) ;

$admin_email="chrisj@remotestaff.com.au";

$header  = 'MIME-Version: 1.0' . "\r\n";
$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$header .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
	
$body= "Hi ".$fname." ".$lname."<br><br>"."To complete your request, you need to confirm your email address by clicking on the link below or copy and paste the link to the browser:<br>".
"<a href ='http://www.philippinesatwork.com/dev/norman/Chris/authenticate.php?zig_hash=$hash_email[value]'>http://www.philippinesatwork.com/dev/norman/Chris/authenticate.php?zig_hash=$hash_email[value]</a>"."
<br><br><br>"."If you no longer wish to recieve communication from remotestaff, please click here.<br />
<a href ='http://www.philippinesatwork.com/dev/norman/Chris/opt-out.php?zig_hash=$hash_email[value]'>http://www.philippinesatwork.com/dev/norman/Chris/opt-out.php?zig_hash=$hash_email[value]</a><br><br>Best Regards,"."<br>".$admin_email;
//mail($email,'Please Verify your Account with us',$body,$header);
*/
////////////////////////////////////////////////////////////////////////////////////////////

	header("location:http://www.realinks.com.au/thankyou.php");
	
	
}
?>



