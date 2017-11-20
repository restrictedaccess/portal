<?php
include './conf/zend_smarty_conf_root.php';
include 'time.php';
include 'function.php';



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

$site =  $_SERVER['HTTP_HOST'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$email=$_REQUEST['email'];
$mobile=$_REQUEST['mobile'];
$officenumber=$_REQUEST['officenumber'];
$company_name=$_REQUEST['company_name'];
$company_position=$_REQUEST['company_position'];
$used_rs=$_REQUEST['used_rs'];
$company_description=$_REQUEST['company_description'];
$company_industry=$_REQUEST['company_industry'];
$contact_person=$_REQUEST['contact_person'];

//Save to leads table
$data = array(
	'tracking_no' => '101JobRequest',
	'agent_id' => 2, 
	'fname' => $fname ,
	'lname' => $lname,
	'email' => $email,
	'mobile' => $mobile,
	'officenumber' => $officenumber,
	'company_name' => $company_name,
	'company_position' => $company_position,
	'company_description' => $company_description,
	'company_industry' => $company_industry,
	'contact' => $contact
	);
	
$db->insert('leads', $data);
$leads_id = $db->lastInsertId();


//create a random no. for our job order form request
$ran = get_rand_id();

//Save to the leads table
$data = array(
	'leads_id' => $leads_id, 
	'created_by_id' => 2, 
	'created_by_type' => 'agent', 
	'date_created' => $ATZ, 
	'status' => 'new' , 
	'ran' => $ran
	);
$db->insert('job_order', $data);
//echo $email;

$body = "<p><img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='241' height='70'></p>
<p><br><br>Hi ".$fname." ".$lname.",</p>
<p>Thank you for requesting to our RemoteStaff Job Order Request form .<br><br>
Please let us know what skills, responsibilities and capabilities  that you are looking for from a staff.<br>
<br>
Please fill up all the forms if possible.<br>
<br>
<br>
Here is the link to your RemoteStaff Job Order Request Form<br>
<br>
<a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran' target='_blank'>										http://$site/portal/pdf_report/job_order_form/?ran=".$ran."</a>
<br>
<br>
Cheers!,<br><br>
RemoteStaff<br>
<br>
</p>";



$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'RemoteStaff');
$mail->addTo($email, $fname." ".$lname);

//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject('RemoteStaff Job Order Form Request');
$mail->send($transport);


$message =  "<p>NEW LEADS DETAILS REGISTERED in URL  [ ".$site." ] <br><br>".
			"PROMOTIONAL CODE : 101<br>".
			"NAME :".$fname." ".$lname."<br>".
			"EMAIL :".$email."<br>".
			"COMPANY NAME :".$company_name."<br>".
			"COMPANY POSITION :".$company_position."<br>".
			
			"OFFICE NO. :".$officenumber."<br>".
			"MOBILE :".$mobile."<br>".
			"COMPANY DETAILS :".$company_description."<br>".
			"COMPANY INDUSTRY :".$company_industry."<br>".
			"CONTACT PERSON :".$contact."<br></p>";
			
			
$mail = new Zend_Mail();
$mail->setBodyHtml($body.$message);
$mail->setFrom('info@remotestaff.com.au', 'RemoteStaff');
$mail->addTo('chrisj@remotestaff.com.au', 'Chris Jankulovski');
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject('RemoteStaff Job Order Form Request');
$mail->send($transport);
	
header("location:./pdf_report/job_order_form/?ran=$ran"); 
?>