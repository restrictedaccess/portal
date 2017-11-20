<?php
//2010-06-15 Normaneil Macutay <normanm@remotestaff.com.au>
// - removed the nationality field

include '../conf/zend_smarty_conf.php';
include '../class.php';
include '../portal/lib/validEmail.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$pass2 = $_REQUEST['pass2'];
$passGen = new passGen(5);
$rv = $_POST['rv'];

$fname=trim($_REQUEST['staff_fname']);
$lname=trim($_REQUEST['staff_lname']);
$email=trim($_REQUEST['staff_email']);

$bmonth =$_REQUEST['bmonth'];
$bday = $_REQUEST['bday'];
$byear = $_REQUEST['byear'];

$identification = $_REQUEST['identification'];
$identification_number = $_REQUEST['identification_number'];

$gender = $_REQUEST['gender'];
$nationality = $_REQUEST['nationality'];
$permanent_residence =$_REQUEST['permanent_residence'];


$code = rand(1000, 2000) ; 
$date = date("Y-m-d") ;

if($passGen->verify($pass2, $rv))
{
	$status=1;
}
else
{
	echo "0";
	exit();
}


if($status == 1){
	//check the email validity
	if (!validEmailv2($email)){
		//Invalid Email Address
		echo "01";
		exit();
	}
	//check email if exist
	$sql ="SELECT * FROM personal WHERE email = '$email';";
	$result = $db->fetchAll($sql);
	if(count($result) > 0){
		echo "02";
		exit();
	}
	
	
	//check the email in tb_temporary_email_account
	$sql=$db->select()
		->from('tb_temporary_email_account' )
		->where('email = ?' , $email);
	$result	= $db->fetchRow($sql);
	$id = $result['id'];

	if($id != ""){
		$code = $result['code'];
	}else{
		//insert new record
		$data = array(
				'email' => $email,
				'code' => $code,
				'date' => $date
				);
		$db->insert('tb_temporary_email_account', $data);		
		$id = $db->lastInsertId();			
	}
	
	/*
	//make a random string password for client 
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $rand_pw = '';    
    for ($p = 0; $p < 10; $p++) {
        $rand_pw .= $characters[mt_rand(0, strlen($characters))];
	}	
	
	
	$data = array(
		'lname' => $lname, 
		'fname' => $fname, 
		'byear' => $byear, 
		'bmonth' => $bmonth, 
		'bday' => $bday, 
		'auth_no_type_id' => $identification, 
		'msia_new_ic_no' => $identification_number, 
		'gender' => $gender, 
		'nationality' => $nationality, 
		'permanent_residence' => $permanent_residence, 
		'email' => $email, 
		'pass' => sha1($rand_pw),
		'datecreated' => $ATZ
	);		
	
	$db->insert('personal', $data);		
	$userid = $db->lastInsertId();
	$_SESSION['userid'] = $userid;
	
	$site = $_SERVER['HTTP_HOST'];
	$body = "<table width='550' style='border:#62A4D5 solid 1px; font:11px tahoma;' cellpadding='3' cellspacing='0'>
				<tr bgcolor='#62A4D5'  >
					<td colspan='3' style='color:#FFFFFF;'><b>RemoStaff</b> New Applicant Registered [".$site."]</td>
				</tr>
				
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>NAME</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$fname." ".$lname."</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>EMAIL</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$email."</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>BIRTHDATE.</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$bmonth."/".$bday."/".$byear."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>GENDER.</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$gender."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>NATIONALITY </td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$nationality ."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>PERMANENT RESIDENCE</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$permanent_residence ."&nbsp;</td>
				</tr>
				
				
				<tr>
					<td colspan='3' valign='top' style='border-bottom:#CCCCCC solid 1px;'>&nbsp;</td>
					
				</tr>
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>DATE REGISTERED </td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$ATZ ."&nbsp;</td>
				</tr>
				</table>";	
				
		
		$subject= "NEW APPLICANTS REGISTRATION FROM SITE [".$site."]";
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
		
		if(! TEST){
			$mail->addTo('chrisj@remotestaff.com.au', 'Chris Jankulovski');
			$mail->addCc('ricag@remotestaff.com.au', 'Admin');// Adds a recipient to the mail with a "Cc" header
			$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
		}else{
			$mail->addTo('normanm@remotestaff.com.au', 'Remotestaff Developers');
		}
		
		$mail->setSubject($subject);
		$mail->send($transport);	
	*/
	
		//send autoresponder to applicants
		$body = "<div align='center' style=' margin:10px; background-color: #FAFCEE; border: 1px solid #D8E899; text-align: left;  ; font: 12px tahoma; padding:20px;'>
				<img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'>
				<html>
				<head>
				<title>Code</title>
				<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
				</head>
				<body>
				<p>Dear Applicant, </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>Code verification is done to ensure that your email address is valid. Valid email address is required to process your application as this will be your initial means of contact. </p>
				<p>&nbsp; </p>
				<p>Please see code below: </p>
				<p><font color='#FF0000' size='3'><strong>".$code."</strong></font></p>
				<p>&nbsp; </p>
				<p>Input this code to the code number field on the application form or click <a href='http://remotestaff.com.au/portal/personal.php?code=".$code."&email=".$email."&flag=1'>HERE</a> to continue your registration. </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>Should you have any questions, please don't hesitate to contact us. </p>
				<p>&nbsp; </p>
				<p>RemoteStaff Team </p>
				</body>
				</html>
			</div>";
			
		
		$subject= "REMOTESTAFF APPLICANTS REGISTRATION CODE";
		
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
		
		if(! TEST){
			$mail->addTo($email, 'Applicant');
		}else{
			$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
		}
		$mail->setSubject($subject);
		$mail->send($transport);
	
	
}
?>



