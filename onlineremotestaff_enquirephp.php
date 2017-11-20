<?
//2008-09-15 Lawrence Sunglao <locsunglao@yahoo.com>
//      add a curl function for this script to send mail using barbaras account

include 'config.php';
include 'conf.php';
include 'time.php';

define(REMOTE_SCRIPT_URL, 'www.onlineremotestaff.com.au/curl_mail_receiver.php');
define(CURL_PASSWORD, '143x244y');
//include_once("hash.lib.php") ;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

/*
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
*/
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
  

$agent_id = 8;
///////////////////////////////////// 
if($tracking_no=="")
{
	$tracking_no="104";
	$agent_id = 8;
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
	$agent_email ="ONLINE INQUIRY www.onlineremotestaff.com.au";
	$to='barbarac@remotestaff.com.au'; //
//	$to='locsunglao@yahoo.com,normaneil007@yahoo.com'; //
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
//			mail($to,$subject, $message, $headers);

            $ch = curl_init();

            $data = array('emails' => $to, 'subject' => $subject, 'headers' => $headers, 'message' => $message, 'curl_password' => CURL_PASSWORD);

            curl_setopt($ch, CURLOPT_URL, REMOTE_SCRIPT_URL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $curl_result = curl_exec($ch);
            curl_close($ch);
//

			
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

	header("location:http://www.onlineremotestaff.com.au/thankyou.php");
}
?>



