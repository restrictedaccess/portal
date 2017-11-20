<?php
//  2010-06-17  Normaneil Macutay <normanm@remotestaff.com.au>
// - used to ZEND_DB



include('conf/zend_smarty_conf_root.php');
include("lib/validEmail.php");

$email = @$_REQUEST["email"] ;
$code = rand(1000, 2000) ; 
$date = date("Y-m-d") ;


//check the email validity
$email = trim($_REQUEST['email']);
if (!validEmailv2($email)){
	echo "<br />You Entered an invalid email address.";
	exit();
}

//check email if exist
$sql ="SELECT * FROM personal WHERE email = '$email';";
$result = $db->fetchAll($sql);
if(count($result) > 0){
	echo "<br />The Email that you are trying to Register is already Registered. You may retrieve your Password by going to <a href='http://".$_SERVER['HTTP_HOST']."/portal/'>".$_SERVER['HTTP_HOST']."/portal/</a> click \"Job Seeker\" then click \"Retrieve Password\"";
	exit();
}


//check the email in tb_temporary_email_account
$sql=$db->select()
	->from('tb_temporary_email_account' )
	->where('email = ?' , $email);
$result	= $db->fetchRow($sql);
$id = $result['id'];

if($id != ""){ 
	//the email already exist in the tb_temporary_email_account. just parse the code
	$code = $result['code'];
}else{
	//insert new record
	$data = array(
			'email' => $email,
			'code' => $code,
			'date' => $date
			);
	$db->insert('tb_temporary_email_account', $data);		
	//$id = $db->lastInsertId();			
}


$body="<div align='center' style=' margin:10px; background-color: #FAFCEE; border: 1px solid #D8E899; text-align: left;  ; font: 12px tahoma; padding:20px;'>
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
				<p>Input this code to the code number field on the application form or click <a href='http://".$_SERVER['HTTP_HOST']."/portal/personal.php?code=".$code."&email=".$email."'>HERE</a> to continue your registration. </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>Should you have any questions, please don't hesitate to contact us. </p>
				<p>&nbsp; </p>
				<p>RemoteStaff Team </p>
				</body>
				</html>
			</div>
			";	

$admin_email = "noreply@remotestaff.com.au";
$admin_name = "Remotestaff";


$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom($admin_email, $admin_name);
if(! TEST){
	$subject= "REMOTESTAFF APPLICANTS REGISTRATION CODE";
	$mail->addTo($email, 'Applicant');
}else{
	$subject= "TEST REMOTESTAFF APPLICANTS REGISTRATION CODE";
	$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
}
$mail->setSubject($subject);
$mail->send($transport);		
	
	
	
echo "<p><b>The code has been sucessfully sent to your primary email.</b><br> [ ".$email." ] </p><p>Code verification is done to ensure that your email address is valid. Valid email address is required to process your application as this will be your initial means of contact. </p>";				
echo "<input type='hidden' name='tmr' id='tmr' value='3' />";

?>

