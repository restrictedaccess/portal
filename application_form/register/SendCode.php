<?php
//2010-07-18 Normaneil Macutay <normanm@remotestaff.com.au>

include '../../conf/zend_smarty_conf.php';
include '../../lib/validEmail.php';
include '../time.php';
 
$email=trim($_REQUEST['email']);

$code = rand(1000, 2000) ; 
$date = date("Y-m-d") ;
$validator = new Zend_Validate_EmailAddress();

if (!$validator->isValid($email)){ 
	//Invalid Email Address
	echo "01";
	exit();
}


//check email if exist
$sql=$db->select()
	->from('personal')
	->where('email =?',$email);
$result = $db->fetchAll($sql);
if(count($result) > 0){
	echo '03';
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


if(TEST){
	$static = 'test';
}
else{
	$static = 'www';
}

$redirect = sprintf("http://%s.remotestaff.com.au/portal/application_form/registernow-step1-personal-details.php?code=%s&email=%s", $static, $code , $email );	
//send autoresponder to applicants
$body = "<div align='center' style=' margin:10px; background-color: #FAFCEE; border: 1px solid #D8E899; text-align: left;  ; font: 12px tahoma; padding:20px;'>
		<img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'>
		<p>Dear Applicant, </p>
		<p>&nbsp; </p>
		<p>&nbsp; </p>
		<p>Code verification is done to ensure that your email address is valid. Valid email address is required to process your application as this will be your initial means of contact. </p>
		<p>&nbsp; </p>
		<p>Please see code below: </p>
		<p><font color='#FF0000' size='3'><strong>".$code."</strong></font></p>
		<p>&nbsp; </p>
		<p>Input this code to the code number field on the application form or click <a href=".$redirect.">HERE</a> to continue your registration. </p>
		<p>&nbsp; </p>
		<p>&nbsp; </p>
		<p>Should you have any questions, please don't hesitate to contact us. </p>
		<p>&nbsp; </p>
		<p>RemoteStaff Team </p>
		
	</div>";
	

$subject= "REMOTESTAFF APPLICANTS REGISTRATION CODE";

$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('noreply@remotestaff.com.au', 'noreply');



if(! TEST){
	$mail->addTo($email, 'Applicant');
}else{
	$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
}
$mail->setSubject($subject);
$mail->send($transport);	

//hardcoded remove.

$fp=fopen('sentmail.txt','w');
fwrite($fp, $body);
fclose($fp);

echo '<span id="email-message-sent" style="font-size:11px;" >';
echo 'Code has been sent to '.$email.'<br />Please check your email to get the code and input the to continue the registration process.<br /><strong style="color:#CC0000">NOTE: Do not close this page so you can easily get back to it. </strong><br/>';
echo "Registration Code Not Received? Click <a class='toggle-registration-box' href=\"javascript:showEmailSender()\">HERE</a>";
echo '</span>';